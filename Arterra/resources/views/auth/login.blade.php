<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/png" href="{{ asset('assets/icon.png') }}">
		<title>{{ config('app.name') }} </title>
		<link rel="preconnect" href="https://fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>
	<body class="bg-[#F3F6FB] text-[#0F172A]">
		<div class="min-h-screen flex items-center justify-center px-6 py-10">
			<div class="relative w-full max-w-md">
				<div class="pointer-events-none absolute inset-0 -z-10">
					<div class="absolute -top-10 right-6 h-32 w-32 rounded-full bg-[#1E3A8A]/15 blur-2xl"></div>
					<div class="absolute bottom-0 left-6 h-24 w-24 rounded-full bg-[#4CAF50]/15 blur-2xl"></div>
				</div>
				<div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
					<div class="flex items-center gap-3">
						<img src="{{ asset('assets/icon.png') }}" class="h-10 w-10 object-contain" alt="Arterra Logo">
						<div>
							<p class="text-lg font-semibold">Arterra</p>
							<p class="text-xs text-slate-500">Jawa Tengah Analytics</p>
						</div>
					</div>
					<h1 class="mt-6 text-2xl font-semibold">Masuk ke Dashboard</h1>
					<p class="mt-2 text-sm text-slate-500">Gunakan email dan password yang sudah terdaftar.</p>

					<form method="POST" action="{{ route('login.submit') }}" class="mt-6 space-y-4">
						@csrf
						<div>
							<label class="text-sm font-semibold text-slate-600">Email</label>
							<input name="email" type="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:border-[#1E3A8A] focus:outline-none" placeholder="nama@email.com">
							@error('email')
								<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label class="text-sm font-semibold text-slate-600">Password</label>
							<input name="password" type="password" required class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:border-[#1E3A8A] focus:outline-none" placeholder="********">
						</div>
						<div class="flex items-center justify-between text-xs text-slate-500">
							<label class="flex items-center gap-2">
								<input type="checkbox" name="remember" class="rounded border-slate-300 text-[#1E3A8A] focus:ring-[#1E3A8A]">
								Ingat saya
							</label>
						</div>
						<button type="submit" class="w-full rounded-xl bg-[#1E3A8A] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1C347B]">Masuk</button>
					</form>

					<p class="mt-6 text-center text-sm text-slate-500">Belum punya akun? <a class="font-semibold text-[#1E3A8A] hover:underline" href="{{ route('register') }}">Daftar</a></p>
				</div>
			</div>
		</div>
	</body>
</html>
