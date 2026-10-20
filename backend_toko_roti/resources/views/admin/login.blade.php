<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Dea Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .brand-font { font-family: 'Playfair Display', serif; }

        /* Animated gradient background */
        .bg-animated {
            background: linear-gradient(-45deg, #fff0f3, #ffe4e8, #fdf2f8, #fff5f7, #fce7f3);
            background-size: 400% 400%;
            animation: gradientShift 10s ease infinite;
        }
        @keyframes gradientShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.35;
            animation: blobFloat 8s ease-in-out infinite;
        }
        .blob-1 { width: 420px; height: 420px; background: #fda4af; top: -100px; left: -120px; animation-delay: 0s; }
        .blob-2 { width: 350px; height: 350px; background: #f9a8d4; bottom: -80px; right: -100px; animation-delay: -3s; }
        .blob-3 { width: 250px; height: 250px; background: #fecdd3; top: 40%; left: 50%; animation-delay: -5s; }
        @keyframes blobFloat {
            0%, 100% { transform: translateY(0px) scale(1); }
            50%       { transform: translateY(-24px) scale(1.05); }
        }

        /* Card glass effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        /* Input focus ring */
        .input-field {
            transition: all 0.25s ease;
            border: 1.5px solid #fecdd3;
        }
        .input-field:focus {
            outline: none;
            border-color: #e11d48;
            box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.12);
        }
        .input-field.error-field {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        /* Primary button */
        .btn-primary {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 50%, #be123c 100%);
            transition: all 0.25s ease;
            box-shadow: 0 8px 24px rgba(225, 29, 72, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 32px rgba(225, 29, 72, 0.42);
        }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Particle dots decoration */
        .dot { position: absolute; border-radius: 50%; background: #fda4af; opacity: 0.4; }

        /* Shake animation on error */
        .shake { animation: shakeAnim 0.5s ease; }
        @keyframes shakeAnim {
            0%, 100% { transform: translateX(0); }
            20%       { transform: translateX(-8px); }
            40%       { transform: translateX(8px); }
            60%       { transform: translateX(-5px); }
            80%       { transform: translateX(5px); }
        }

        /* Spin animation for loading */
        @keyframes spin { to { transform: rotate(360deg); } }
        .spin { animation: spin 1s linear infinite; }
    </style>
</head>
<body class="min-h-screen bg-animated flex items-center justify-center p-4 overflow-hidden relative">

    {{-- Animated background blobs --}}
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    {{-- Decorative dots --}}
    <div class="dot w-3 h-3" style="top:15%;left:10%;"></div>
    <div class="dot w-2 h-2" style="top:25%;left:20%;"></div>
    <div class="dot w-4 h-4" style="top:70%;left:8%;"></div>
    <div class="dot w-2 h-2" style="top:80%;left:25%;"></div>
    <div class="dot w-3 h-3" style="top:10%;right:15%;"></div>
    <div class="dot w-5 h-5" style="top:35%;right:8%;"></div>
    <div class="dot w-2 h-2" style="bottom:20%;right:20%;"></div>

    {{-- Login Card --}}
    <div class="relative z-10 w-full max-w-md">

        {{-- Floating brand badge --}}
        <div class="flex justify-center mb-6">
            <div class="flex items-center space-x-3 bg-white/70 backdrop-blur-md rounded-2xl px-5 py-3 shadow-lg border border-rose-100">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-400 via-rose-500 to-rose-600 flex items-center justify-center text-white shadow-md shadow-rose-500/30">
                    <i class="fa-solid fa-bread-slice text-lg"></i>
                </div>
                <div>
                    <h1 class="text-lg font-black text-rose-700 leading-none brand-font">Dea Bakery</h1>
                    <span class="text-[10px] text-pink-500 font-bold uppercase tracking-wider">Management Center</span>
                </div>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="glass-card rounded-3xl shadow-2xl shadow-rose-300/30 overflow-hidden" id="loginCard">

            {{-- Card Top Decoration --}}
            <div class="h-1.5 bg-gradient-to-r from-pink-400 via-rose-500 to-rose-600"></div>

            <div class="p-8 sm:p-10">

                {{-- Heading --}}
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-rose-50 border border-rose-100 mb-4">
                        <i class="fa-solid fa-shield-halved text-2xl text-rose-500"></i>
                    </div>
                    <h2 class="text-2xl font-black text-slate-800 brand-font">Masuk ke Panel Admin</h2>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Masukkan kredensial admin Anda untuk melanjutkan</p>
                </div>

                {{-- Alert Messages --}}
                @if(session('error'))
                <div class="flex items-start space-x-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-3.5 mb-6 text-sm font-medium">
                    <i class="fa-solid fa-circle-exclamation mt-0.5 shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @if(session('success'))
                <div class="flex items-start space-x-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl px-4 py-3.5 mb-6 text-sm font-medium">
                    <i class="fa-solid fa-circle-check mt-0.5 shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="flex items-start space-x-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-3.5 mb-6 text-sm font-medium">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 shrink-0"></i>
                    <div>
                        @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Login Form --}}
                <form method="POST" action="{{ route('admin.login.post') }}" id="loginForm" novalidate>
                    @csrf

                    {{-- Email Field --}}
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-bold text-slate-700 mb-2">
                            Alamat Email Admin
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-envelope text-rose-400 text-sm"></i>
                            </div>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                placeholder="admin@deabakery.com"
                                class="input-field {{ $errors->has('email') ? 'error-field' : '' }} w-full pl-11 pr-4 py-3.5 rounded-xl bg-white/80 text-slate-800 font-medium placeholder-slate-400 text-sm"
                            >
                        </div>
                        @error('email')
                        <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center space-x-1">
                            <i class="fa-solid fa-circle-xmark"></i>
                            <span>{{ $message }}</span>
                        </p>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-bold text-slate-700 mb-2">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-rose-400 text-sm"></i>
                            </div>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="input-field {{ $errors->has('password') ? 'error-field' : '' }} w-full pl-11 pr-12 py-3.5 rounded-xl bg-white/80 text-slate-800 font-medium placeholder-slate-400 text-sm"
                            >
                            {{-- Toggle Password Visibility --}}
                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-rose-500 transition-colors"
                            >
                                <i id="eyeIcon" class="fa-solid fa-eye text-sm"></i>
                            </button>
                        </div>
                        @error('password')
                        <p class="text-xs text-red-500 mt-1.5 font-medium flex items-center space-x-1">
                            <i class="fa-solid fa-circle-xmark"></i>
                            <span>{{ $message }}</span>
                        </p>
                        @enderror
                    </div>

                    {{-- Remember Me + Forgot --}}
                    <div class="flex items-center justify-between mb-7">
                        <label class="flex items-center space-x-2.5 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="remember" id="remember" class="sr-only peer">
                                <div class="w-5 h-5 rounded-md border-2 border-rose-200 peer-checked:bg-rose-500 peer-checked:border-rose-500 transition-all flex items-center justify-center">
                                    <i class="fa-solid fa-check text-white text-[10px] opacity-0 peer-checked:opacity-100 transition-opacity hidden peer-checked:block"></i>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-slate-600 group-hover:text-slate-800 transition-colors select-none">Ingat Saya</span>
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button
                        type="submit"
                        id="submitBtn"
                        class="btn-primary w-full py-3.5 rounded-xl text-white font-bold text-sm tracking-wide flex items-center justify-center space-x-2"
                    >
                        <i id="btnIcon" class="fa-solid fa-right-to-bracket"></i>
                        <span id="btnText">Masuk ke Dashboard</span>
                    </button>
                </form>

                {{-- Divider --}}
                <div class="flex items-center my-6">
                    <div class="flex-1 h-px bg-rose-100"></div>
                    <span class="px-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Keamanan</span>
                    <div class="flex-1 h-px bg-rose-100"></div>
                </div>

                {{-- Security Info --}}
                <div class="grid grid-cols-3 gap-3">
                    <div class="flex flex-col items-center p-3 rounded-xl bg-rose-50/70 border border-rose-100/80 text-center">
                        <i class="fa-solid fa-lock text-rose-400 text-base mb-1.5"></i>
                        <span class="text-[10px] font-bold text-slate-500 leading-tight">Koneksi<br>Terenkripsi</span>
                    </div>
                    <div class="flex flex-col items-center p-3 rounded-xl bg-rose-50/70 border border-rose-100/80 text-center">
                        <i class="fa-solid fa-user-shield text-rose-400 text-base mb-1.5"></i>
                        <span class="text-[10px] font-bold text-slate-500 leading-tight">Akses<br>Terbatas</span>
                    </div>
                    <div class="flex flex-col items-center p-3 rounded-xl bg-rose-50/70 border border-rose-100/80 text-center">
                        <i class="fa-solid fa-clock-rotate-left text-rose-400 text-base mb-1.5"></i>
                        <span class="text-[10px] font-bold text-slate-500 leading-tight">Sesi<br>Aman</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- Footer note --}}
        <p class="text-center text-xs text-slate-400 font-medium mt-5">
            Hanya untuk personel berwenang &copy; {{ date('Y') }} Dea Bakery
        </p>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Custom checkbox behavior
        document.getElementById('remember').addEventListener('change', function() {
            const checkIcon = this.closest('label').querySelector('.fa-check');
            if (checkIcon) {
                checkIcon.classList.toggle('hidden', !this.checked);
            }
        });

        // Loading state on submit
        const form = document.getElementById('loginForm');
        const btn  = document.getElementById('submitBtn');
        const btnIcon = document.getElementById('btnIcon');
        const btnText = document.getElementById('btnText');

        form.addEventListener('submit', function(e) {
            const email    = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();

            if (!email || !password) {
                e.preventDefault();
                document.getElementById('loginCard').classList.add('shake');
                setTimeout(() => document.getElementById('loginCard').classList.remove('shake'), 500);
                return;
            }

            // Show loading state
            btn.disabled = true;
            btnIcon.classList.replace('fa-right-to-bracket', 'fa-circle-notch');
            btnIcon.classList.add('spin');
            btnText.textContent = 'Memverifikasi...';
        });
    </script>
</body>
</html>
