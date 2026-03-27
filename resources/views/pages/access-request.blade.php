<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Inquiry - RAMS Region III</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=IBM+Plex+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'IBM Plex Sans', sans-serif; }
        .display-font { font-family: 'Space Grotesk', sans-serif; }
    </style>
</head>
<body class="bg-white text-slate-900">
    <div class="min-h-screen flex items-center justify-center px-6 py-16">
        <div class="w-full max-w-xl rounded-[2rem] border border-slate-200 bg-white p-10 shadow-xl">
            <div class="mb-6">
                <div class="text-xs uppercase tracking-[0.3em] text-slate-400">Access Inquiry</div>
                <h1 class="display-font text-3xl font-bold mt-2">Request New Access</h1>
                <p class="text-slate-500 mt-3">
                    Provide your agency details and the RAMS team will validate and provision your account.
                </p>
            </div>

            <form class="space-y-5">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Full Name</label>
                    <input type="text" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-600" placeholder="Juan Dela Cruz">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Agency</label>
                    <input type="text" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-600" placeholder="Department / Office">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Email Address</label>
                    <input type="email" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-600" placeholder="name@agency.gov.ph">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Message</label>
                    <textarea rows="4" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-600" placeholder="Tell us the access scope you need."></textarea>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="button" class="w-full rounded-xl bg-teal-600 py-3 font-semibold text-white shadow-lg shadow-teal-200 hover:bg-teal-700 transition">
                        Submit Inquiry
                    </button>
                    <a href="{{ route('landing') }}" class="w-full rounded-xl border border-slate-200 py-3 text-center font-semibold text-slate-600 hover:border-teal-600 hover:text-teal-700 transition">
                        Back to Home
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
