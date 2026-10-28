@props(['header' => true])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pe-rl</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-perl-bg text-perl-dark font-sans antialiased min-h-screen">

    {{-- Logout (top right) --}}
    <form method="POST" action="{{ route('logout') }}" class="absolute top-4 right-6">
        @csrf
        <button class="text-sm underline">log out</button>
    </form>

    @if ($header)
        <header class="text-center pt-10 pb-4">
            @if (auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}" class="w-20 h-20 rounded-full object-cover mx-auto">
            @else
                <div class="w-20 h-20 rounded-full bg-perl-blue mx-auto"></div>
            @endif

            <p class="font-semibold mt-3">{{ auth()->user()->name }}</p>
            <p class="text-xs font-bold uppercase">{{ now()->format('M. j Y') }}</p>

            <div class="flex justify-center gap-4 mt-3">
                {{-- Edit profile --}}
                <a href="{{ route('profile.edit') }}" title="Edit profile">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M16 3l5 5L8 21H3v-5L16 3z"/>
                    </svg>
                </a>
                {{-- Statistics --}}
                <a href="{{ route('statistics') }}" title="Statistics">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 20V10M12 20V4M18 20v-7"/>
                    </svg>
                </a>
            </div>
        </header>
    @endif

    <main>
        {{ $slot }}
    </main>

</body>
</html>