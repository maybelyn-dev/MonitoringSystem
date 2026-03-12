<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - RAMS Region III</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-2xl">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-200">
                <i class="fas fa-map-marked-alt text-white text-2xl"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-900">RAMS Region III</h1>
            <p class="text-sm text-slate-500 mt-1">Create Your Agency Account</p>
        </div>

        <!-- Registration Card -->
        <div class="bg-white rounded-[2rem] p-8 shadow-xl border border-blue-100">
            <h2 class="text-2xl font-black text-slate-800 mb-2">Get Started</h2>
            <p class="text-sm text-slate-500 mb-8">Register your agency account</p>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <ul class="text-sm text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>&bull; {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Name Fields (3-column grid) -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">Full Name</label>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <!-- First Name -->
                        <div class="md:col-span-5">
                            <input type="text" name="first_name" required value="{{ old('first_name') }}"
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="First Name *">
                            @error('first_name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Middle Initial -->
                        <div class="md:col-span-2">
                            <input type="text" name="middle_initial" value="{{ old('middle_initial') }}"
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="M.I.">
                            @error('middle_initial')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="md:col-span-5">
                            <input type="text" name="last_name" required value="{{ old('last_name') }}"
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Last Name *">
                            @error('last_name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Province Selection -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        <i class="fas fa-building text-blue-600 mr-2"></i>Select Your Province *
                    </label>
                    <select name="province_id" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white text-slate-700">
                        <option value="">-- Choose a province --</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}" {{ (string) old('province_id') === (string) $province->id ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('province_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

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
                           placeholder="********">
                    <p class="text-xs text-slate-500 mt-1">Minimum 8 characters</p>
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="********">
                    @error('password_confirmation')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms -->
                <div class="flex items-start">
                    <input type="checkbox" id="terms" name="terms" required class="rounded text-blue-600 cursor-pointer mt-1">
                    <label for="terms" class="ml-2 text-xs text-slate-600 cursor-pointer">
                        I agree to the Terms of Service and Privacy Policy
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition duration-300 shadow-lg shadow-blue-200">
                    Create Account
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-slate-500">Already have an account?</span>
                </div>
            </div>

            <!-- Sign In Link -->
            <a href="{{ route('login') }}" class="block w-full text-center bg-slate-100 text-slate-700 font-bold py-3 rounded-xl hover:bg-slate-200 transition duration-300">
                Sign In
            </a>
        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-500 mt-8">
            &copy; 2026 RAMS Region III. All rights reserved.
        </p>
    </div>
</body>
</html>
