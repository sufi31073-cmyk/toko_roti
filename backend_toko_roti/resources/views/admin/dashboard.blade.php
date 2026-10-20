<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dea Bakery Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .brand-font { font-family: 'Playfair Display', serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #FFF0F3; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #FDA4AF; border-radius: 9999px; }
    </style>
</head>
<body class="bg-[#FFF5F7] text-slate-800 antialiased min-h-screen flex flex-col lg:flex-row custom-scrollbar">

    <!-- Mobile Header Bar -->
    <div class="lg:hidden bg-white border-b border-rose-100 p-4 flex items-center justify-between sticky top-0 z-40 shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-pink-500 to-rose-600 flex items-center justify-center text-white text-lg shadow-md shadow-rose-500/20">
                <i class="fa-solid fa-bread-slice"></i>
            </div>
            <div>
                <h1 class="text-lg font-black text-rose-700 leading-none brand-font">Dea Bakery</h1>
                <span class="text-[10px] text-pink-500 font-bold uppercase tracking-wider">Admin Panel</span>
            </div>
        </div>
        <button onclick="toggleMobileSidebar()" class="p-2 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>
    </div>

    <!-- SIDEBAR NAVIGATION MENU -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-rose-100/80 flex flex-col justify-between transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:h-screen lg:sticky top-0 shadow-xl lg:shadow-none">
        <div>
            <!-- Sidebar Header & Logo -->
            <div class="p-6 border-b border-rose-50 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-pink-400 via-rose-500 to-rose-600 flex items-center justify-center text-white text-xl shadow-lg shadow-rose-500/30">
                        <i class="fa-solid fa-bread-slice"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-black text-rose-700 leading-tight brand-font">Dea Bakery</h1>
                        <span class="text-[11px] text-pink-600 font-bold uppercase tracking-wider">Management Center</span>
                    </div>
                </div>
                <button onclick="toggleMobileSidebar()" class="lg:hidden text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="p-4 space-y-1.5">
                <div class="px-3 py-2 text-[10px] font-extrabold uppercase tracking-wider text-rose-400">Menu Utama</div>

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard', ['tab' => 'dashboard']) }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-2xl font-bold text-sm transition-all duration-200 {{ $activeTab === 'dashboard' ? 'bg-gradient-to-r from-rose-500 to-pink-500 text-white shadow-md shadow-rose-500/25' : 'text-slate-600 hover:bg-rose-50 hover:text-rose-700' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-chart-pie text-base {{ $activeTab === 'dashboard' ? 'text-white' : 'text-rose-400' }}"></i>
                        <span>Dashboard Overview</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs opacity-60"></i>
                </a>

                <!-- Produk Roti (Katalog & Tambah) -->
                <a href="{{ route('admin.dashboard', ['tab' => 'products']) }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-2xl font-bold text-sm transition-all duration-200 {{ $activeTab === 'products' ? 'bg-gradient-to-r from-rose-500 to-pink-500 text-white shadow-md shadow-rose-500/25' : 'text-slate-600 hover:bg-rose-50 hover:text-rose-700' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-bread-slice text-base {{ $activeTab === 'products' ? 'text-white' : 'text-rose-400' }}"></i>
                        <span>Katalog & Produk Roti</span>
                    </div>
                    <span class="px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'products' ? 'bg-white/20 text-white' : 'bg-rose-100 text-rose-700 font-extrabold' }}">{{ $totalProducts }}</span>
                </a>

                <!-- Tambah / Kelola Stok -->
                <a href="{{ route('admin.dashboard', ['tab' => 'stock']) }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-2xl font-bold text-sm transition-all duration-200 {{ $activeTab === 'stock' ? 'bg-gradient-to-r from-rose-500 to-pink-500 text-white shadow-md shadow-rose-500/25' : 'text-slate-600 hover:bg-rose-50 hover:text-rose-700' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-boxes-stacked text-base {{ $activeTab === 'stock' ? 'text-white' : 'text-rose-400' }}"></i>
                        <span>Kelola & Tambah Stok</span>
                    </div>
                    @if($lowStockCount > 0)
                        <span class="px-2 py-0.5 text-[10px] rounded-full bg-amber-400 text-amber-950 font-black animate-pulse">{{ $lowStockCount }} Menipis</span>
                    @endif
                </a>

                <!-- Kategori Menu -->
                <a href="{{ route('admin.dashboard', ['tab' => 'categories']) }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-2xl font-bold text-sm transition-all duration-200 {{ $activeTab === 'categories' ? 'bg-gradient-to-r from-rose-500 to-pink-500 text-white shadow-md shadow-rose-500/25' : 'text-slate-600 hover:bg-rose-50 hover:text-rose-700' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-tags text-base {{ $activeTab === 'categories' ? 'text-white' : 'text-rose-400' }}"></i>
                        <span>Kategori Roti</span>
                    </div>
                    <span class="px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'categories' ? 'bg-white/20 text-white' : 'bg-rose-100 text-rose-700 font-extrabold' }}">{{ $categories->count() }}</span>
                </a>

                <!-- Pesanan Masuk -->
                <a href="{{ route('admin.dashboard', ['tab' => 'orders']) }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-2xl font-bold text-sm transition-all duration-200 {{ $activeTab === 'orders' ? 'bg-gradient-to-r from-rose-500 to-pink-500 text-white shadow-md shadow-rose-500/25' : 'text-slate-600 hover:bg-rose-50 hover:text-rose-700' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-receipt text-base {{ $activeTab === 'orders' ? 'text-white' : 'text-rose-400' }}"></i>
                        <span>Pesanan Pelanggan</span>
                    </div>
                    @if($pendingOrders > 0)
                        <span class="px-2 py-0.5 text-xs rounded-full bg-pink-500 text-white font-extrabold">{{ $pendingOrders }} Baru</span>
                    @endif
                </a>

                <div class="px-3 pt-4 pb-2 text-[10px] font-extrabold uppercase tracking-wider text-rose-400">Laporan & Log</div>

                <!-- Riwayat Stok Logs -->
                <a href="{{ route('admin.dashboard', ['tab' => 'stock_logs']) }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-2xl font-bold text-sm transition-all duration-200 {{ $activeTab === 'stock_logs' ? 'bg-gradient-to-r from-rose-500 to-pink-500 text-white shadow-md shadow-rose-500/25' : 'text-slate-600 hover:bg-rose-50 hover:text-rose-700' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-clock-rotate-left text-base {{ $activeTab === 'stock_logs' ? 'text-white' : 'text-rose-400' }}"></i>
                        <span>Riwayat Log Stok</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs opacity-60"></i>
                </a>
            </div>
        </div>

        <!-- Sidebar Bottom Profile / System Status -->
        <div class="p-4 border-t border-rose-50 space-y-3 bg-gradient-to-b from-transparent to-pink-50/50">
            <div class="flex items-center justify-between p-2.5 rounded-2xl bg-white border border-rose-100 shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-rose-400 to-pink-500 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-xs font-black text-slate-800">{{ Auth::user()->name ?? 'Admin' }}</div>
                        <div class="text-[10px] text-emerald-600 font-semibold flex items-center mt-0.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-ping"></span>
                            Online & Siap
                        </div>
                    </div>
                </div>
            </div>

            {{-- Logout Button --}}
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 rounded-2xl bg-rose-50 hover:bg-rose-100 border border-rose-200 hover:border-rose-300 text-rose-600 hover:text-rose-700 font-bold text-xs transition-all duration-200 group"
                    onclick="return confirm('Yakin ingin keluar dari panel admin?')"
                >
                    <i class="fa-solid fa-arrow-right-from-bracket group-hover:translate-x-0.5 transition-transform"></i>
                    <span>Keluar dari Admin</span>
                </button>
            </form>

            <div class="text-center text-[10px] text-rose-400 font-semibold">
                Dea Bakery System v2.0 • 2026
            </div>
        </div>
    </aside>

    <!-- Overlay for Mobile Sidebar -->
    <div id="sidebar-overlay" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/40 z-40 hidden lg:hidden backdrop-blur-sm"></div>

    <!-- MAIN CONTENT AREA -->
    <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 space-y-6">

        <!-- Top Header Controls -->
        <div class="bg-white p-4 sm:p-5 rounded-3xl border border-rose-100/80 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="p-2.5 bg-rose-50 rounded-2xl text-rose-600 text-lg">
                    @if($activeTab === 'dashboard') <i class="fa-solid fa-chart-pie"></i>
                    @elseif($activeTab === 'products') <i class="fa-solid fa-bread-slice"></i>
                    @elseif($activeTab === 'stock') <i class="fa-solid fa-boxes-stacked"></i>
                    @elseif($activeTab === 'categories') <i class="fa-solid fa-tags"></i>
                    @elseif($activeTab === 'orders') <i class="fa-solid fa-receipt"></i>
                    @elseif($activeTab === 'stock_logs') <i class="fa-solid fa-clock-rotate-left"></i>
                    @endif
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-black text-slate-900">
                        @if($activeTab === 'dashboard') Dashboard Overview
                        @elseif($activeTab === 'products') Katalog & Manajemen Roti
                        @elseif($activeTab === 'stock') Kelola Stok & Tambah Stok Cepat
                        @elseif($activeTab === 'categories') Manajemen Kategori Menu
                        @elseif($activeTab === 'orders') Manajemen Pesanan Pelanggan
                        @elseif($activeTab === 'stock_logs') Audit Log Riwayat Stok
                        @endif
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">Panel kontrol terpadu toko roti Dea Bakery</p>
                </div>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <button onclick="openModal('modalAddProduct')" class="inline-flex items-center px-4 py-2.5 rounded-2xl bg-gradient-to-r from-rose-500 to-pink-500 text-white font-bold text-xs sm:text-sm shadow-md shadow-rose-500/20 hover:opacity-95 transition-all">
                    <i class="fa-solid fa-plus mr-2"></i> Tambah Roti Baru
                </button>
                <button onclick="openModal('modalAddCategory')" class="inline-flex items-center px-3.5 py-2.5 rounded-2xl bg-white border border-rose-200 text-rose-700 font-bold text-xs sm:text-sm hover:bg-rose-50 transition-all">
                    <i class="fa-solid fa-tag mr-2"></i> + Kategori
                </button>
                <span class="inline-flex items-center px-3 py-1.5 rounded-2xl text-xs font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-100">
                    <span class="w-2 h-2 mr-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                    API Active
                </span>
            </div>
        </div>

        <!-- Alert Notifications -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-black text-lg">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 text-base"></i>
                    <span class="font-bold text-sm">{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-black text-lg">&times;</button>
            </div>
        @endif

        <!-- ======================================================== -->
        <!-- TAB 1: DASHBOARD OVERVIEW -->
        <!-- ======================================================== -->
        @if($activeTab === 'dashboard')
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-pink-500 via-rose-500 to-rose-600 p-6 sm:p-8 rounded-[2rem] text-white shadow-xl shadow-rose-500/20 relative overflow-hidden">
                <div class="relative z-10 space-y-2 max-w-2xl">
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-white text-xs font-extrabold backdrop-blur-md">
                        Pusat Kendali Toko Roti
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black brand-font italic">Selamat Datang di Dea Bakery Dashboard</h2>
                    <p class="text-pink-100 text-xs sm:text-sm leading-relaxed">
                        Kelola produk roti hangat, tambah stok produksi harian, unggah foto produk berkualitas, pantau pesanan pelanggan, dan analisa transaksi penjualan secara real-time.
                    </p>
                </div>
            </div>

            <!-- Stats Overview Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Total Sales -->
                <div class="bg-white p-5 rounded-3xl border border-rose-100 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-extrabold text-rose-500 uppercase tracking-wider">Total Penjualan</span>
                        <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-base">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-2xl font-black text-slate-900">
                        Rp {{ number_format($totalSales, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-emerald-600 font-bold mt-1 flex items-center">
                        <i class="fa-solid fa-arrow-trend-up mr-1"></i> Omset Aktif Toko
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="bg-white p-5 rounded-3xl border border-rose-100 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-extrabold text-blue-500 uppercase tracking-wider">Total Pesanan</span>
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-base">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-2xl font-black text-slate-900">
                        {{ $totalOrders }} Order
                    </div>
                    <div class="text-[11px] text-blue-600 font-bold mt-1">
                        {{ $completedOrders }} Pesanan Selesai
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="bg-white p-5 rounded-3xl border border-rose-100 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-extrabold text-amber-500 uppercase tracking-wider">Menunggu Konfirmasi</span>
                        <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-base">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-2xl font-black text-slate-900">
                        {{ $pendingOrders }} Order
                    </div>
                    <div class="text-[11px] text-amber-600 font-bold mt-1">
                        Perlu Segera Diproses
                    </div>
                </div>

                <!-- Total Products & Stock -->
                <div class="bg-white p-5 rounded-3xl border border-rose-100 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-extrabold text-purple-500 uppercase tracking-wider">Total Menu Roti</span>
                        <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-base">
                            <i class="fa-solid fa-bread-slice"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-2xl font-black text-slate-900">
                        {{ $totalProducts }} Varian
                    </div>
                    <div class="text-[11px] {{ $lowStockCount > 0 ? 'text-rose-500 font-extrabold' : 'text-purple-600 font-bold' }} mt-1">
                        {{ $lowStockCount > 0 ? $lowStockCount . ' Roti Perlu Restock' : 'Semua Stok Aman' }}
                    </div>
                </div>
            </div>

            <!-- Quick Action Banner for Bakery Stock & Add Product -->
            <div class="bg-white rounded-3xl border border-rose-100 p-6 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-pink-100 to-rose-200 flex items-center justify-center text-2xl text-rose-700">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Ingin menambah stok produksi roti hari ini?</h3>
                        <p class="text-xs text-slate-500">Gunakan fitur Quick Restock untuk menambah jumlah stok roti langsung hanya dalam 1-klik.</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dashboard', ['tab' => 'stock']) }}" class="px-5 py-2.5 rounded-2xl bg-rose-50 text-rose-700 font-bold text-xs sm:text-sm hover:bg-rose-100 transition-all">
                        <i class="fa-solid fa-boxes-stacked mr-1.5"></i> Buka Manajemen Stok
                    </a>
                    <button onclick="openModal('modalAddProduct')" class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-rose-500 to-pink-500 text-white font-bold text-xs sm:text-sm shadow-md shadow-rose-500/20 hover:opacity-95 transition-all">
                        <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Upload Roti Baru
                    </button>
                </div>
            </div>

            <!-- Recent Orders Section -->
            <div class="bg-white rounded-3xl border border-rose-100 shadow-sm overflow-hidden">
                <div class="p-5 sm:p-6 border-b border-rose-50 flex items-center justify-between bg-gradient-to-r from-white to-pink-50/30">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base sm:text-lg">Transaksi Pesanan Terbaru</h3>
                        <p class="text-xs text-slate-500">Daftar transaksi pesanan terakhir yang masuk dari aplikasi</p>
                    </div>
                    <a href="{{ route('admin.dashboard', ['tab' => 'orders']) }}" class="text-xs font-extrabold text-rose-600 hover:text-rose-800">
                        Lihat Semua Pesanan →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-rose-50/50 text-rose-800 font-bold uppercase text-[10px] tracking-wider border-b border-rose-50">
                            <tr>
                                <th class="px-6 py-4">No. Order</th>
                                <th class="px-6 py-4">Pelanggan</th>
                                <th class="px-6 py-4">Item Roti</th>
                                <th class="px-6 py-4">Total Bayar</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-rose-50">
                            @forelse($orders->take(6) as $order)
                                <tr class="hover:bg-rose-50/20 transition-colors">
                                    <td class="px-6 py-4 font-extrabold text-slate-900">
                                        {{ $order->order_number }}
                                        <div class="text-[10px] font-normal text-slate-400 mt-0.5">{{ $order->created_at->format('d M Y H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-900">{{ $order->user->name ?? 'Pelanggan Guest' }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $order->user->phone ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-medium text-slate-700">
                                        @foreach($order->items as $item)
                                            <span class="inline-block bg-slate-100 px-2 py-0.5 rounded text-[11px] mr-1 mb-1">
                                                {{ $item->product_name }} ({{ $item->quantity }}x)
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 font-black text-rose-600">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($order->status === 'completed')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Selesai
                                            </span>
                                        @elseif($order->status === 'processing')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-blue-100 text-blue-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span> Diproses
                                            </span>
                                        @elseif($order->status === 'cancelled')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-rose-100 text-rose-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Dibatalkan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-amber-100 text-amber-900">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="inline-flex items-center space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="text-xs border-rose-200 rounded-xl px-2.5 py-1 bg-rose-50/50 text-rose-900 font-bold focus:ring-rose-500 border focus:border-rose-500 outline-none">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Proses</option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-slate-400 font-medium">Belum ada data transaksi pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- ======================================================== -->
        <!-- TAB 2: KATALOG & PRODUK ROTI (TAMBAH, EDIT, UPLOAD, HAPUS) -->
        <!-- ======================================================== -->
        @if($activeTab === 'products')
            <div class="space-y-6">
                <!-- Product Section Top Controls -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-3xl border border-rose-100">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-lg">Daftar Produk & Varian Roti</h3>
                        <p class="text-xs text-slate-500">Kelola katalog menu, foto roti, harga, diskon, dan stok produk</p>
                    </div>
                    <button onclick="openModal('modalAddProduct')" class="inline-flex items-center px-5 py-2.5 rounded-2xl bg-gradient-to-r from-rose-500 to-pink-500 text-white font-bold text-sm shadow-md shadow-rose-500/20 hover:opacity-95 transition-all">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Roti Baru
                    </button>
                </div>

                <!-- Product Grid List -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($products as $product)
                        <div class="bg-white rounded-3xl border border-rose-100 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
                            <div>
                                <!-- Image Container -->
                                <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute top-3 left-3 flex flex-col gap-1">
                                        <span class="px-2.5 py-1 rounded-xl bg-white/90 backdrop-blur-md text-rose-700 text-[10px] font-extrabold shadow-sm">
                                            {{ $product->category->name ?? 'Bakery' }}
                                        </span>
                                        @if($product->is_popular)
                                            <span class="px-2 py-0.5 rounded-xl bg-amber-400 text-amber-950 text-[10px] font-black shadow-sm flex items-center">
                                                <i class="fa-solid fa-fire text-[9px] mr-1"></i> Populer
                                            </span>
                                        @endif
                                    </div>
                                    <div class="absolute bottom-3 right-3">
                                        <span class="px-2.5 py-1 rounded-xl {{ $product->stock <= 5 ? 'bg-rose-500 text-white' : ($product->stock <= 15 ? 'bg-amber-400 text-amber-950' : 'bg-emerald-500 text-white') }} text-xs font-black shadow-md">
                                            Stok: {{ $product->stock }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Body -->
                                <div class="p-5 space-y-2.5">
                                    <h4 class="font-extrabold text-slate-900 text-base line-clamp-1">{{ $product->name }}</h4>
                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $product->description }}</p>

                                    <div class="pt-2 border-t border-rose-50 flex items-center justify-between">
                                        <div>
                                            @if($product->discount_price)
                                                <div class="text-[10px] text-slate-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                                <div class="text-base font-black text-rose-600">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</div>
                                            @else
                                                <div class="text-base font-black text-rose-600">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                            @endif
                                        </div>
                                        <div class="text-xs text-amber-500 font-bold flex items-center">
                                            <i class="fa-solid fa-star text-amber-400 text-xs mr-1"></i> {{ number_format($product->rating ?? 4.8, 1) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Actions -->
                            <div class="p-4 bg-rose-50/40 border-t border-rose-50 flex items-center justify-between gap-2">
                                <button onclick="openAddStockModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->stock }})" 
                                        class="flex-1 py-2 px-3 rounded-xl bg-pink-100 text-pink-700 hover:bg-pink-200 font-bold text-xs transition-all text-center">
                                    <i class="fa-solid fa-plus mr-1"></i> Stok
                                </button>
                                <button onclick='openEditProductModal(@json($product))' 
                                        class="p-2 px-3 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold text-xs transition-all">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 px-3 rounded-xl bg-rose-100 text-rose-700 hover:bg-rose-200 font-bold text-xs transition-all">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 bg-white rounded-3xl border border-rose-100 text-center space-y-3">
                            <div class="text-4xl text-rose-300"><i class="fa-solid fa-bread-slice"></i></div>
                            <h4 class="font-extrabold text-slate-800 text-lg">Belum ada produk roti</h4>
                            <p class="text-xs text-slate-400">Klik tombol "Tambah Roti Baru" untuk menambahkan produk pertama Anda.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        <!-- ======================================================== -->
        <!-- TAB 3: KELOLA & TAMBAH STOK CEPAT -->
        <!-- ======================================================== -->
        @if($activeTab === 'stock')
            <div class="space-y-6">
                <!-- Header Stock -->
                <div class="bg-white p-5 rounded-3xl border border-rose-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-lg">Manajemen Stok & Restock Roti</h3>
                        <p class="text-xs text-slate-500">Perbarui jumlah ketersediaan roti hasil produksi harian</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-xs font-bold text-slate-500">Indikator Stok:</span>
                        <span class="px-2.5 py-1 rounded-xl bg-emerald-100 text-emerald-800 text-[10px] font-extrabold">Aman (>15)</span>
                        <span class="px-2.5 py-1 rounded-xl bg-amber-100 text-amber-800 text-[10px] font-extrabold">Menipis (6-15)</span>
                        <span class="px-2.5 py-1 rounded-xl bg-rose-100 text-rose-800 text-[10px] font-extrabold">Kritis (≤5)</span>
                    </div>
                </div>

                <!-- Stock Table -->
                <div class="bg-white rounded-3xl border border-rose-100 overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-rose-50/50 text-rose-800 font-bold uppercase text-[10px] tracking-wider border-b border-rose-50">
                                <tr>
                                    <th class="px-6 py-4">Roti</th>
                                    <th class="px-6 py-4">Kategori</th>
                                    <th class="px-6 py-4 text-center">Stok Saat Ini</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-right">Tambah Stok Cepat (+Qty)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-rose-50">
                                @foreach($products as $product)
                                    <tr class="hover:bg-rose-50/20 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-2xl object-cover border border-rose-100">
                                                <div>
                                                    <div class="font-extrabold text-slate-900 text-sm">{{ $product->name }}</div>
                                                    <div class="text-[11px] text-rose-600 font-bold">Rp {{ number_format($product->discount_price ?? $product->price, 0, ',', '.') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-slate-600 text-xs">
                                            {{ $product->category->name ?? 'Bakery' }}
                                        </td>
                                        <td class="px-6 py-4 text-center font-black text-base {{ $product->stock <= 5 ? 'text-rose-600' : ($product->stock <= 15 ? 'text-amber-600' : 'text-slate-800') }}">
                                            {{ $product->stock }} pcs
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($product->stock <= 5)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 animate-pulse">
                                                    Kritis
                                                </span>
                                            @elseif($product->stock <= 15)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-100 text-amber-900">
                                                    Menipis
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800">
                                                    Cukup
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="inline-flex items-center space-x-1.5">
                                                <!-- Quick +5 -->
                                                <form action="{{ route('admin.products.stock', $product->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="quantity" value="5">
                                                    <input type="hidden" name="note" value="Restock batch cepat +5">
                                                    <button type="submit" class="px-2.5 py-1.5 rounded-xl bg-pink-50 hover:bg-pink-100 text-pink-700 font-extrabold text-xs transition-all">+5</button>
                                                </form>

                                                <!-- Quick +10 -->
                                                <form action="{{ route('admin.products.stock', $product->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="quantity" value="10">
                                                    <input type="hidden" name="note" value="Restock batch cepat +10">
                                                    <button type="submit" class="px-2.5 py-1.5 rounded-xl bg-rose-100 hover:bg-rose-200 text-rose-800 font-extrabold text-xs transition-all">+10</button>
                                                </form>

                                                <!-- Quick +25 -->
                                                <form action="{{ route('admin.products.stock', $product->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="quantity" value="25">
                                                    <input type="hidden" name="note" value="Restock batch besar +25">
                                                    <button type="submit" class="px-2.5 py-1.5 rounded-xl bg-rose-500 hover:bg-rose-600 text-white font-extrabold text-xs transition-all shadow-sm">+25</button>
                                                </form>

                                                <!-- Custom Modal -->
                                                <button onclick="openAddStockModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->stock }})" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition-all">
                                                    Custom...
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- ======================================================== -->
        <!-- TAB 4: KATEGORI ROTI -->
        <!-- ======================================================== -->
        @if($activeTab === 'categories')
            <div class="space-y-6">
                <!-- Categories Header -->
                <div class="bg-white p-5 rounded-3xl border border-rose-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-lg">Kategori Menu Roti</h3>
                        <p class="text-xs text-slate-500">Kelola kelompok varian produk toko roti Dea Bakery</p>
                    </div>
                    <button onclick="openModal('modalAddCategory')" class="inline-flex items-center px-5 py-2.5 rounded-2xl bg-gradient-to-r from-rose-500 to-pink-500 text-white font-bold text-sm shadow-md shadow-rose-500/20 hover:opacity-95 transition-all">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Kategori
                    </button>
                </div>

                <!-- Category Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($categories as $category)
                        <div class="bg-white p-6 rounded-3xl border border-rose-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                            <div>
                                <div class="flex items-center justify-between">
                                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                                        <i class="fa-solid fa-tag"></i>
                                    </div>
                                    <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-extrabold">
                                        {{ $category->products_count }} Menu
                                    </span>
                                </div>
                                <h4 class="font-black text-slate-900 text-lg mt-4">{{ $category->name }}</h4>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $category->description ?? 'Kategori produk olahan toko roti segar.' }}</p>
                            </div>

                            <div class="pt-3 border-t border-rose-50 flex items-center justify-end space-x-2">
                                <button onclick='openEditCategoryModal(@json($category))' class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                </button>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori {{ addslashes($category->name) }}?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-100 hover:bg-rose-200 text-rose-700 font-bold text-xs">
                                        <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- ======================================================== -->
        <!-- TAB 5: PESANAN PELANGGAN -->
        <!-- ======================================================== -->
        @if($activeTab === 'orders')
            <div class="space-y-6">
                <!-- Orders Filter Tab -->
                <div class="bg-white p-4 sm:p-5 rounded-3xl border border-rose-100 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-lg">Semua Transaksi Pesanan Pelanggan</h3>
                        <p class="text-xs text-slate-500">Perbarui dan pantau status transaksi pemesanan roti</p>
                    </div>

                    <!-- Status Filter Badges -->
                    <div class="flex flex-wrap items-center gap-1.5">
                        <a href="{{ route('admin.dashboard', ['tab' => 'orders']) }}" class="px-3.5 py-1.5 rounded-2xl text-xs font-extrabold {{ !request('order_status') ? 'bg-rose-500 text-white shadow-sm' : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">
                            Semua ({{ $orders->count() }})
                        </a>
                        <a href="{{ route('admin.dashboard', ['tab' => 'orders', 'order_status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-2xl text-xs font-extrabold {{ request('order_status') == 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-amber-50 text-amber-800 hover:bg-amber-100' }}">
                            Pending ({{ $pendingOrders }})
                        </a>
                        <a href="{{ route('admin.dashboard', ['tab' => 'orders', 'order_status' => 'processing']) }}" class="px-3.5 py-1.5 rounded-2xl text-xs font-extrabold {{ request('order_status') == 'processing' ? 'bg-blue-500 text-white shadow-sm' : 'bg-blue-50 text-blue-800 hover:bg-blue-100' }}">
                            Diproses ({{ $processingOrders }})
                        </a>
                        <a href="{{ route('admin.dashboard', ['tab' => 'orders', 'order_status' => 'completed']) }}" class="px-3.5 py-1.5 rounded-2xl text-xs font-extrabold {{ request('order_status') == 'completed' ? 'bg-emerald-500 text-white shadow-sm' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                            Selesai ({{ $completedOrders }})
                        </a>
                    </div>
                </div>

                <!-- Full Orders Table -->
                <div class="bg-white rounded-3xl border border-rose-100 overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-rose-50/50 text-rose-800 font-bold uppercase text-[10px] tracking-wider border-b border-rose-50">
                                <tr>
                                    <th class="px-6 py-4">No. Order & Tanggal</th>
                                    <th class="px-6 py-4">Pelanggan</th>
                                    <th class="px-6 py-4">Item Pembelian</th>
                                    <th class="px-6 py-4">Metode Bayar</th>
                                    <th class="px-6 py-4">Total</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Ubah Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-rose-50">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-rose-50/20 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-extrabold text-slate-900">{{ $order->order_number }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $order->created_at->format('d M Y H:i:s') }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-slate-900">{{ $order->user->name ?? 'Guest User' }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $order->user->phone ?? 'Tanpa nomor' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="space-y-1 max-w-xs">
                                                @foreach($order->items as $item)
                                                    <div class="text-xs font-medium text-slate-700 flex items-center justify-between">
                                                        <span>• {{ $item->product_name }}</span>
                                                        <span class="font-bold text-rose-600 text-[11px]">x{{ $item->quantity }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-slate-700 text-xs">
                                            <span class="px-2 py-1 rounded-lg bg-slate-100 text-slate-800 text-[11px] font-bold">
                                                {{ strtoupper($order->payment_method ?? 'COD') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-black text-rose-600 text-base">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($order->status === 'completed')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Selesai
                                                </span>
                                            @elseif($order->status === 'processing')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-blue-100 text-blue-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span> Diproses
                                                </span>
                                            @elseif($order->status === 'cancelled')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-rose-100 text-rose-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Dibatalkan
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-900">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> Menunggu
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="inline-flex items-center space-x-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()" class="text-xs border-rose-200 rounded-xl px-3 py-1.5 bg-rose-50/70 text-rose-900 font-bold focus:ring-rose-500 border focus:border-rose-500 outline-none">
                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-slate-400 font-medium">Tidak ada pesanan yang sesuai dengan filter ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- ======================================================== -->
        <!-- TAB 6: LOG RIWAYAT STOK -->
        <!-- ======================================================== -->
        @if($activeTab === 'stock_logs')
            <div class="space-y-6">
                <!-- Header -->
                <div class="bg-white p-5 rounded-3xl border border-rose-100">
                    <h3 class="font-extrabold text-slate-900 text-lg">Audit Log Perubahan Stok Roti</h3>
                    <p class="text-xs text-slate-500">Catatan riwayat penambahan stok, produksi harian, dan pengurangan stok</p>
                </div>

                <!-- Table Logs -->
                <div class="bg-white rounded-3xl border border-rose-100 overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-rose-50/50 text-rose-800 font-bold uppercase text-[10px] tracking-wider border-b border-rose-50">
                                <tr>
                                    <th class="px-6 py-4">Waktu / Tanggal</th>
                                    <th class="px-6 py-4">Nama Produk Roti</th>
                                    <th class="px-6 py-4 text-center">Perubahan Stok</th>
                                    <th class="px-6 py-4">Keterangan / Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-rose-50">
                                @forelse($stockHistories as $log)
                                    <tr class="hover:bg-rose-50/20 transition-colors">
                                        <td class="px-6 py-4 text-xs font-semibold text-slate-500">
                                            {{ $log->created_at->format('d M Y H:i:s') }}
                                        </td>
                                        <td class="px-6 py-4 font-bold text-slate-900">
                                            {{ $log->product->name ?? 'Produk dihapus' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($log->change > 0)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800">
                                                    +{{ $log->change }} pcs
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-800">
                                                    {{ $log->change }} pcs
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-xs text-slate-600">
                                            {{ $log->note ?? 'Penyesuaian stok sistem' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium">Belum ada riwayat perubahan stok yang tercatat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

    </main>

    <!-- ======================================================== -->
    <!-- MODAL: TAMBAH PRODUK ROTI BARU (DENGAN UPLOAD FOTO) -->
    <!-- ======================================================== -->
    <div id="modalAddProduct" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-rose-100 space-y-6 my-8 max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="flex items-center justify-between border-b border-rose-50 pb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Tambah Produk Roti Baru</h3>
                        <p class="text-xs text-slate-500">Unggah foto dan isi data roti untuk ditampilkan di aplikasi</p>
                    </div>
                </div>
                <button onclick="closeModal('modalAddProduct')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center font-bold">
                    &times;
                </button>
            </div>

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Nama Roti & Kategori -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Roti <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="Contoh: Choco Lava Bun" class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kategori <span class="text-rose-500">*</span></label>
                        <select name="category_id" required class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Roti <span class="text-rose-500">*</span></label>
                    <textarea name="description" rows="3" required placeholder="Jelaskan cita rasa lembut, bahan baku mentega pilihan, dan isian roti..." class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20"></textarea>
                </div>

                <!-- Harga, Harga Diskon, Stok Awal -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Harga Asli (Rp) <span class="text-rose-500">*</span></label>
                        <input type="number" name="price" required min="0" placeholder="20000" class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Harga Promo (Rp)</label>
                        <input type="number" name="discount_price" min="0" placeholder="Opsional (misal: 18000)" class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Stok Awal (pcs) <span class="text-rose-500">*</span></label>
                        <input type="number" name="stock" required min="0" value="20" class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20">
                    </div>
                </div>

                <!-- Upload Foto / File Gambar Roti -->
                <div class="space-y-2 pt-2 border-t border-rose-50">
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                        Upload Foto Roti (File Gambar)
                    </label>
                    <div class="border-2 border-dashed border-rose-200 rounded-3xl p-4 text-center hover:bg-rose-50/30 transition-all cursor-pointer relative bg-rose-50/10">
                        <input type="file" name="image_file" accept="image/*" onchange="previewImage(this, 'add_preview')" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div id="add_preview_container" class="space-y-2">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-rose-400"></i>
                            <div class="text-xs font-bold text-slate-700">Pilih file foto dari laptop / HP atau seret ke sini</div>
                            <div class="text-[10px] text-slate-400">Format: JPG, PNG, WEBP (Maks 3MB)</div>
                        </div>
                        <img id="add_preview" src="" alt="Preview" class="hidden max-h-40 mx-auto rounded-2xl object-cover shadow-md mt-2">
                    </div>
                </div>

                <!-- Atau Input Image URL -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 mb-1">Atau Gunakan Image URL Langsung (Unsplash dsb):</label>
                    <input type="url" name="image_url" placeholder="https://images.unsplash.com/photo-..." class="w-full px-4 py-2 rounded-2xl border border-rose-100 focus:border-rose-500 text-xs outline-none bg-rose-50/10">
                </div>

                <!-- Popular & Rating Options -->
                <div class="flex items-center justify-between pt-2 border-t border-rose-50">
                    <label class="flex items-center space-x-2.5 cursor-pointer">
                        <input type="checkbox" name="is_popular" value="1" class="w-4 h-4 text-rose-600 rounded border-rose-300 focus:ring-rose-500">
                        <span class="text-xs font-bold text-slate-800">Tandai sebagai Roti Populer / Best Seller</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-rose-50 flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeModal('modalAddProduct')" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-rose-500 to-pink-500 hover:opacity-95 text-white font-black text-sm shadow-lg shadow-rose-500/25">
                        Simpan Roti Baru
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL: EDIT PRODUK ROTI -->
    <!-- ======================================================== -->
    <div id="modalEditProduct" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-rose-100 space-y-6 my-8 max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="flex items-center justify-between border-b border-rose-50 pb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Edit Data Produk Roti</h3>
                        <p class="text-xs text-slate-500">Perbarui informasi, harga, stok, atau foto produk</p>
                    </div>
                </div>
                <button onclick="closeModal('modalEditProduct')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center font-bold">
                    &times;
                </button>
            </div>

            <form id="formEditProduct" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Nama Roti & Kategori -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Roti <span class="text-rose-500">*</span></label>
                        <input type="text" id="edit_name" name="name" required class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kategori <span class="text-rose-500">*</span></label>
                        <select id="edit_category_id" name="category_id" required class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Roti <span class="text-rose-500">*</span></label>
                    <textarea id="edit_description" name="description" rows="3" required class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20"></textarea>
                </div>

                <!-- Harga, Harga Diskon, Stok -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Harga Asli (Rp) <span class="text-rose-500">*</span></label>
                        <input type="number" id="edit_price" name="price" required min="0" class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Harga Promo (Rp)</label>
                        <input type="number" id="edit_discount_price" name="discount_price" min="0" class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Stok Saat Ini (pcs) <span class="text-rose-500">*</span></label>
                        <input type="number" id="edit_stock" name="stock" required min="0" class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20">
                    </div>
                </div>

                <!-- Upload Foto Baru -->
                <div class="space-y-2 pt-2 border-t border-rose-50">
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                        Ganti Foto Roti (Upload Baru)
                    </label>
                    <div class="border-2 border-dashed border-rose-200 rounded-3xl p-4 text-center hover:bg-rose-50/30 transition-all cursor-pointer relative bg-rose-50/10">
                        <input type="file" name="image_file" accept="image/*" onchange="previewImage(this, 'edit_preview')" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div id="edit_preview_container" class="space-y-1">
                            <i class="fa-solid fa-camera text-2xl text-rose-400"></i>
                            <div class="text-xs font-bold text-slate-700">Klik untuk memilih foto baru pengganti</div>
                        </div>
                        <img id="edit_preview" src="" alt="Preview" class="max-h-40 mx-auto rounded-2xl object-cover shadow-md mt-2">
                    </div>
                </div>

                <!-- Image URL Input -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 mb-1">Atau Ubah Image URL:</label>
                    <input type="url" id="edit_image_url" name="image_url" class="w-full px-4 py-2 rounded-2xl border border-rose-100 focus:border-rose-500 text-xs outline-none bg-rose-50/10">
                </div>

                <!-- Popular Toggle -->
                <div class="flex items-center justify-between pt-2 border-t border-rose-50">
                    <label class="flex items-center space-x-2.5 cursor-pointer">
                        <input type="checkbox" id="edit_is_popular" name="is_popular" value="1" class="w-4 h-4 text-rose-600 rounded border-rose-300 focus:ring-rose-500">
                        <span class="text-xs font-bold text-slate-800">Tandai sebagai Roti Populer / Best Seller</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-rose-50 flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeModal('modalEditProduct')" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-rose-500 to-pink-500 hover:opacity-95 text-white font-black text-sm shadow-lg shadow-rose-500/25">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL: TAMBAH STOK CEPAT DENGAN CATATAN -->
    <!-- ======================================================== -->
    <div id="modalAddStock" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-rose-100 space-y-6">
            <div class="flex items-center justify-between border-b border-rose-50 pb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Tambah Stok Roti</h3>
                        <p id="stock_modal_product_name" class="text-xs text-rose-600 font-bold">Pilih roti</p>
                    </div>
                </div>
                <button onclick="closeModal('modalAddStock')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center font-bold">
                    &times;
                </button>
            </div>

            <form id="formAddStock" action="" method="POST" class="space-y-4">
                @csrf
                <div class="p-4 rounded-2xl bg-rose-50/50 border border-rose-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-600">Stok Saat Ini:</span>
                    <span id="stock_modal_current_stock" class="text-base font-black text-slate-900">0 pcs</span>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jumlah Stok Tambahan <span class="text-rose-500">*</span></label>
                    <input type="number" name="quantity" required min="1" value="10" class="w-full px-4 py-2.5 rounded-2xl border border-rose-200 focus:border-rose-500 focus:ring-rose-500 text-sm font-black outline-none bg-white">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Catatan Restock (Opsional)</label>
                    <input type="text" name="note" placeholder="Contoh: Produksi Roti Pagi, Batch #2" class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-xs outline-none bg-rose-50/20">
                </div>

                <div class="pt-4 border-t border-rose-50 flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeModal('modalAddStock')" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-rose-500 to-pink-500 text-white font-black text-sm shadow-md shadow-rose-500/25">
                        Tambah Stok
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL: TAMBAH KATEGORI BARU -->
    <!-- ======================================================== -->
    <div id="modalAddCategory" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-rose-100 space-y-6">
            <div class="flex items-center justify-between border-b border-rose-50 pb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-tag"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Tambah Kategori Baru</h3>
                        <p class="text-xs text-slate-500">Buat kelompok jenis roti baru</p>
                    </div>
                </div>
                <button onclick="closeModal('modalAddCategory')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center font-bold">
                    &times;
                </button>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Roti Tawar & Toast" class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Kategori</label>
                    <textarea name="description" rows="2" placeholder="Deskripsi singkat kategori roti..." class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20"></textarea>
                </div>

                <div class="pt-4 border-t border-rose-50 flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeModal('modalAddCategory')" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-rose-500 to-pink-500 text-white font-black text-sm shadow-md shadow-rose-500/25">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL: EDIT KATEGORI -->
    <!-- ======================================================== -->
    <div id="modalEditCategory" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-rose-100 space-y-6">
            <div class="flex items-center justify-between border-b border-rose-50 pb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Edit Kategori</h3>
                        <p class="text-xs text-slate-500">Perbarui informasi kategori</p>
                    </div>
                </div>
                <button onclick="closeModal('modalEditCategory')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center font-bold">
                    &times;
                </button>
            </div>

            <form id="formEditCategory" action="" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit_cat_name" name="name" required class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Kategori</label>
                    <textarea id="edit_cat_description" name="description" rows="2" class="w-full px-4 py-2.5 rounded-2xl border border-rose-100 focus:border-rose-500 focus:ring-rose-500 text-sm outline-none bg-rose-50/20"></textarea>
                </div>

                <div class="pt-4 border-t border-rose-50 flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeModal('modalEditCategory')" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-rose-500 to-pink-500 text-white font-black text-sm shadow-md shadow-rose-500/25">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT HANDLERS -->
    <script>
        // Toggle Mobile Sidebar
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Modal Open / Close
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        // Image Preview Handler
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Open Add Stock Modal
        function openAddStockModal(productId, productName, currentStock) {
            const form = document.getElementById('formAddStock');
            form.action = `/admin/products/${productId}/stock`;
            document.getElementById('stock_modal_product_name').innerText = productName;
            document.getElementById('stock_modal_current_stock').innerText = currentStock + ' pcs';
            openModal('modalAddStock');
        }

        // Open Edit Product Modal
        function openEditProductModal(product) {
            const form = document.getElementById('formEditProduct');
            form.action = `/admin/products/${product.id}`;
            document.getElementById('edit_name').value = product.name || '';
            document.getElementById('edit_category_id').value = product.category_id || '';
            document.getElementById('edit_description').value = product.description || '';
            document.getElementById('edit_price').value = product.price || '';
            document.getElementById('edit_discount_price').value = product.discount_price || '';
            document.getElementById('edit_stock').value = product.stock || 0;
            document.getElementById('edit_image_url').value = product.image_url || '';
            document.getElementById('edit_preview').src = product.image_url || '';
            document.getElementById('edit_preview').classList.remove('hidden');
            document.getElementById('edit_is_popular').checked = !!product.is_popular;
            openModal('modalEditProduct');
        }

        // Open Edit Category Modal
        function openEditCategoryModal(category) {
            const form = document.getElementById('formEditCategory');
            form.action = `/admin/categories/${category.id}`;
            document.getElementById('edit_cat_name').value = category.name || '';
            document.getElementById('edit_cat_description').value = category.description || '';
            openModal('modalEditCategory');
        }
    </script>
</body>
</html>
