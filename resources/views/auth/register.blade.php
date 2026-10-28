<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pe-rl | Register</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-4 font-sans antialiased text-perl-dark
             bg-gradient-to-b from-perl-bg from-50% to-blue-300">

    <div class="w-full max-w-2xl rounded-[2rem] p-8 md:p-10 shadow-sm
                bg-gradient-to-b from-orange-100 to-neutral-100
                flex flex-col md:flex-row items-center gap-8">

        {{-- Left: logo --}}
        <div class="shrink-0">
            <h1 class="text-4xl font-serif tracking-wide">Pe-rl</h1>
            <p class="font-serif text-lg -mt-1 mb-3">todo app</p>
            <div class="w-28 h-28 rounded-3xl bg-gradient-to-b from-blue-800 to-orange-200
                        flex items-center justify-center">
                <div class="w-10 h-10 rounded-full bg-gray-300"></div>
            </div>
        </div>

        {{-- Right: form --}}
        <form method="POST" action="{{ route('register') }}" class="w-full space-y-3">
            @csrf

            <input type="text" name="name" value="{{ old('name') }}" placeholder="name" required autofocus
                   class="w-full rounded-xl border-0 bg-gray-300 placeholder-perl-dark/70 focus:ring-2 focus:ring-perl-blue">

            <input type="email" name="email" value="{{ old('email') }}" placeholder="email" required
                   class="w-full rounded-xl border-0 bg-gray-300 placeholder-perl-dark/70 focus:ring-2 focus:ring-perl-blue">

            <input type="password" name="password" placeholder="password" required
                   class="w-full rounded-xl border-0 bg-gray-300 placeholder-perl-dark/70 focus:ring-2 focus:ring-perl-blue">

            <input type="password" name="password_confirmation" placeholder="confirm password" required
                   class="w-full rounded-xl border-0 bg-gray-300 placeholder-perl-dark/70 focus:ring-2 focus:ring-perl-blue">

            @if ($errors->any())
                <ul class="text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <button class="bg-perl-blue text-white rounded-full px-8 py-2">Create account</button>

            <p class="text-sm font-semibold">
                already have an account?
                <a href="{{ route('login') }}" class="underline">log in.</a>
            </p>
        </form>
    </div>

</body>
</html>