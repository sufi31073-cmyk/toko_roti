<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // Dashboard Stats Summary
    public function dashboard()
    {
        $totalSales = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        $recentOrders = Order::with('user', 'items')
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'total_sales' => (float) $totalSales,
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'processing_orders' => $processingOrders,
            'completed_orders' => $completedOrders,
            'total_products' => $totalProducts,
            'total_categories' => $totalCategories,
            'recent_orders' => $recentOrders,
        ]);
    }

    // Orders Management
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'items']);

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->get();
        return response()->json($orders);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json([
            'message' => 'Status pesanan berhasil diperbarui!',
            'order' => $order->load(['user', 'items']),
        ]);
    }

    // Product Management (CRUD)
    public function storeProduct(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'required|string',
            'is_popular' => 'nullable|boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'image_url' => $request->image_url,
            'is_popular' => $request->is_popular ?? false,
            'rating' => $request->rating ?? 4.8,
        ]);

        return response()->json([
            'message' => 'Produk roti berhasil ditambahkan!',
            'product' => $product->load('category'),
        ], 201);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'image_url' => 'sometimes|string',
            'is_popular' => 'nullable|boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $product->update($request->all());

        return response()->json([
            'message' => 'Data produk berhasil diperbarui!',
            'product' => $product->load('category'),
        ]);
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Produk berhasil dihapus!'
        ]);
    }

    // Category Management (CRUD)
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon ?? 'bakery_dining',
        ]);

        return response()->json([
            'message' => 'Kategori berhasil ditambahkan!',
            'category' => $category,
        ], 201);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        if ($request->has('name')) {
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
        }
        if ($request->has('description')) $category->description = $request->description;
        if ($request->has('icon')) $category->icon = $request->icon;

        $category->save();

        return response()->json([
            'message' => 'Kategori berhasil diperbarui!',
            'category' => $category,
        ]);
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'message' => 'Kategori berhasil dihapus!'
        ]);
    }
}
