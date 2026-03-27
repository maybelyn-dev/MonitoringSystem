<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RAMS Region III</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-200">
                <i class="fas fa-map-marked-alt text-white text-2xl"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-900">RAMS Region III</h1>
            <p class="text-sm text-slate-500 mt-1">Regional Agency Monitoring System</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-[2rem] p-8 shadow-xl border border-blue-100">
            <h2 class="text-2xl font-black text-slate-800 mb-2">Welcome Back</h2>
            <p class="text-sm text-slate-500 mb-8">Sign in to your agency account</p>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <p class="text-sm font-bold text-red-700">{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf

<<<<<<< HEAD
=======
                <!-- Province Selection -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        <i class="fas fa-building text-blue-600 mr-2"></i>Select Your Province *
                    </label>
                    <select name="province_id" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white text-slate-700">
                        <option value="">-- Choose a province --</option>
                        @forelse($provinces->unique('name') as $province)
                            <option value="{{ $province->id }}" {{ (string) old('province_id') === (string) $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                        @empty
                            <option value="" disabled>No provinces available</option>
                        @endforelse
                    </select>
                    @error('province_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

>>>>>>> cf987bb09545d4af71f7cee8ba04d0b7d536a31c
                <!-- Email -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                    <input type="email" name="email" required value="{{ old('email') }}" 
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="your@email.com">
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="••••••••">
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="rounded text-blue-600 cursor-pointer">
                    <label for="remember" class="ml-2 text-sm text-slate-600 cursor-pointer">Remember me</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition duration-300 shadow-lg shadow-blue-200">
                    Sign In
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-slate-500">Need access?</span>
                </div>
            </div>

            <!-- Access Request Link -->
            <a href="{{ route('access.request') }}" class="block w-full text-center bg-slate-100 text-slate-700 font-bold py-3 rounded-xl hover:bg-slate-200 transition duration-300">
                Request New Access
            </a>
        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-500 mt-8">
            &copy; 2026 RAMS Region III. All rights reserved.
        </p>
    </div>
</body>
</html>
