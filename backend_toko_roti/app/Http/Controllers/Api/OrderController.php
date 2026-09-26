<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class OrderController extends Controller
{
    private function configureMidtrans()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

    public function index(Request $request)
    {
        $orders = Order::with('items')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();
        return response()->json($orders);
    }

    public function show(Request $request, $id)
    {
        $order = Order::with('items')
            ->where('user_id', $request->user()->id)
            ->where('id', $id)
            ->firstOrFail();
        return response()->json($order);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'nullable|string',
            'shipping_address' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $orderItemsData = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $price = $product->discount_price ?? $product->price;
                $subtotal = $price * $item['quantity'];
                $totalAmount += $subtotal;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                ];

                // Reduce stock
                $product->decrement('stock', $item['quantity']);
            }

            $orderNumber = 'ROTI-' . strtoupper(uniqid());

            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_number' => $orderNumber,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method ?? 'Midtrans',
                'payment_status' => 'pending',
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
            ]);

            foreach ($orderItemsData as $itemData) {
                $itemData['order_id'] = $order->id;
                OrderItem::create($itemData);
            }

            // Generate Midtrans Snap Token
            $this->configureMidtrans();

            $midtransItems = array_map(function ($item) {
                return [
                    'id' => (string) $item['product_id'],
                    'price' => (int) $item['price'],
                    'quantity' => (int) $item['quantity'],
                    'name' => substr($item['product_name'], 0, 50),
                ];
            }, $orderItemsData);

            $midtransParams = [
                'transaction_details' => [
                    'order_id' => $orderNumber,
                    'gross_amount' => (int) $totalAmount,
                ],
                'customer_details' => [
                    'first_name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'phone' => $request->user()->phone ?? '08123456789',
                ],
                'item_details' => $midtransItems,
            ];

            $snapToken = Snap::getSnapToken($midtransParams);
            $paymentUrl = "https://app.sandbox.midtrans.com/snap/v2/vtweb/" . $snapToken;

            $order->update([
                'snap_token' => $snapToken,
                'payment_url' => $paymentUrl,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.',
                'snap_token' => $snapToken,
                'payment_url' => $paymentUrl,
                'order' => $order->load('items'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function notification(Request $request)
    {
        $this->configureMidtrans();

        try {
            $notification = new Notification();
            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            $fraudStatus = $notification->fraud_status;

            $order = Order::where('order_number', $orderId)->first();
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $order->update(['payment_status' => 'pending']);
                } else if ($fraudStatus == 'accept') {
                    $order->update(['payment_status' => 'paid', 'status' => 'processing']);
                }
            } else if ($transactionStatus == 'settlement') {
                $order->update(['payment_status' => 'paid', 'status' => 'processing']);
            } else if ($transactionStatus == 'pending') {
                $order->update(['payment_status' => 'pending']);
            } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
            }

            return response()->json(['message' => 'Notification handled successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
