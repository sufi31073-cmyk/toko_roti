<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminWebController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalSales = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalProducts = Product::count();
        $lowStockCount = Product::where('stock', '<=', 10)->count();

        $categories = Category::withCount('products')->get();
        $products = Product::with('category')->latest()->get();
        
        $orderQuery = Order::with(['user', 'items']);
        if ($request->filled('order_status')) {
            $orderQuery->where('status', $request->order_status);
        }
        $orders = $orderQuery->latest()->get();

        $stockHistories = StockHistory::with('product')->latest()->take(20)->get();

        $activeTab = $request->get('tab', 'dashboard');

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'totalProducts',
            'lowStockCount',
            'categories',
            'products',
            'orders',
            'stockHistories',
            'activeTab'
        ));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'image_url' => 'nullable|string',
            'is_popular' => 'nullable|boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $imageUrl = 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=600&q=80';

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('products', $filename, 'public');
            $imageUrl = asset('storage/' . $path);
        } elseif ($request->filled('image_url')) {
            $imageUrl = $request->image_url;
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->filled('discount_price') ? $request->discount_price : null,
            'stock' => $request->stock,
            'image_url' => $imageUrl,
            'is_popular' => $request->has('is_popular') ? true : false,
            'rating' => $request->rating ?? 4.8,
        ]);

        // Record initial stock
        if ($product->stock > 0) {
            StockHistory::create([
                'product_id' => $product->id,
                'change' => $product->stock,
                'note' => 'Stok awal saat penambahan produk baru',
            ]);
        }

        return redirect()->route('admin.dashboard', ['tab' => 'products'])->with('success', 'Produk roti "' . $product->name . '" berhasil ditambahkan!');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'image_url' => 'nullable|string',
            'is_popular' => 'nullable|boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $oldStock = $product->stock;
        $imageUrl = $product->image_url;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('products', $filename, 'public');
            $imageUrl = asset('storage/' . $path);
        } elseif ($request->filled('image_url')) {
            $imageUrl = $request->image_url;
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->filled('discount_price') ? $request->discount_price : null,
            'stock' => $request->stock,
            'image_url' => $imageUrl,
            'is_popular' => $request->has('is_popular') ? true : false,
            'rating' => $request->rating ?? $product->rating,
        ]);

        // Record stock adjustment if stock changed
        if ($oldStock != $product->stock) {
            $diff = $product->stock - $oldStock;
            StockHistory::create([
                'product_id' => $product->id,
                'change' => $diff,
                'note' => 'Penyesuaian stok manual dari form edit produk (' . ($diff > 0 ? '+' : '') . $diff . ')',
            ]);
        }

        return redirect()->route('admin.dashboard', ['tab' => 'products'])->with('success', 'Data produk "' . $product->name . '" berhasil diperbarui!');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $name = $product->name;
        $product->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'products'])->with('success', 'Produk "' . $name . '" berhasil dihapus!');
    }

    public function addStock(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        $qty = (int) $request->quantity;
        $product->increment('stock', $qty);

        StockHistory::create([
            'product_id' => $product->id,
            'change' => $qty,
            'note' => $request->note ?: 'Restock tambahan roti (+' . $qty . ' pcs)',
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan ' . $qty . ' stok untuk "' . $product->name . '"!');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon ?: 'bakery_dining',
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'categories'])->with('success', 'Kategori baru "' . $category->name . '" berhasil dibuat!');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon ?: $category->icon,
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'categories'])->with('success', 'Kategori "' . $category->name . '" berhasil diperbarui!');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.dashboard', ['tab' => 'categories'])->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk roti terkait.');
        }

        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'categories'])->with('success', 'Kategori "' . $name . '" berhasil dihapus!');
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan #' . $order->order_number . ' berhasil diubah menjadi ' . strtoupper($request->status) . '!');
    }
}

