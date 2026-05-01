<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }} - Simulation</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F3F6FB] text-[#0F172A]">
        <div class="min-h-screen">
            <x-sidebar />
            <main class="lg:pl-72">
                <section class="px-6 py-8">
                    <h1 class="text-2xl font-semibold">Simulation</h1>
                    <p class="mt-2 text-slate-600">Konten simulasi akan ditambahkan di sini.</p>
                </section>
            </main>
        </div>
    </body>
</html>
