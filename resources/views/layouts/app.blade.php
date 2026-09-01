<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
    @yield('title', 'WordSpace')
</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

{{-- Header --}}
<header class="border-b border-[var(--border-subtle)] bg-[var(--color-surface)]">

    <nav class="site-container flex h-20 items-center justify-between">

        {{-- Logo --}}
        <a
            href="{{ route('posts.index') }}"
            class="font-display text-2xl font-semibold tracking-tight text-[var(--color-primary)]"
        >
            WordSpace
        </a>


        {{-- Navigation --}}
        <div class="flex items-center gap-6">

            {{-- Home --}}
            <a
                href="{{ route('posts.index') }}"
                class="hidden text-sm font-medium text-[var(--color-on-surface-variant)] transition-colors hover:text-[var(--color-primary)] sm:block"
            >
                Home
            </a>


            @auth

                {{-- Dashboard --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="hidden text-sm font-medium text-[var(--color-on-surface-variant)] transition-colors hover:text-[var(--color-primary)] sm:block"
                >
                    Dashboard
                </a>


                {{-- Create Post --}}
                <a
                    href="{{ route('posts.create') }}"
                    class="btn btn-primary"
                >
                    Create Post
                </a>


                {{-- Logout --}}
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="text-sm font-medium text-[var(--color-on-surface-variant)] transition-colors hover:text-[var(--color-primary)]"
                    >
                        Logout
                    </button>

                </form>

            @else

                {{-- Login --}}
                <a
                    href="{{ route('login') }}"
                    class="text-sm font-medium text-[var(--color-on-surface-variant)] transition-colors hover:text-[var(--color-primary)]"
                >
                    Login
                </a>


                {{-- Register --}}
                <a
                    href="{{ route('register') }}"
                    class="btn btn-primary"
                >
                    Register
                </a>

            @endauth

        </div>

    </nav>

</header>


{{-- Flash Messages --}}
@if(session('success'))

    <div class="site-container pt-6">

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    </div>

@endif


{{-- Main Content --}}
<main>
    @yield('content')
</main>


{{-- Footer --}}
<footer class="mt-24 border-t border-[var(--border-subtle)] bg-[var(--color-surface-container-low)]">

    <div class="site-container py-10">

        <div class="flex flex-col gap-4 text-center md:flex-row md:items-center md:justify-between md:text-left">

            {{-- Brand --}}
            <div>
                <p class="font-display text-xl font-medium text-[var(--color-primary)]">
                    WordSpace
                </p>

                <p class="mt-1 text-sm text-[var(--color-on-surface-variant)]">
                    A space for ideas, stories, and thoughtful writing.
                </p>
            </div>


            {{-- Copyright --}}
            <p class="text-xs uppercase tracking-wider text-[var(--color-outline)]">
                © {{ date('Y') }} WordSpace
            </p>

        </div>

    </div>

</footer>

</body>

</html>
