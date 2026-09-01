<!DOCTYPE html>

<html lang="en">

<head>


<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    @yield('title', 'Admin Panel') - WordSpace
</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body>


<div class="min-h-screen">


    {{-- Sidebar --}}
    <aside
        class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col border-r border-[var(--border-subtle)] bg-[var(--color-surface-container-lowest)]"
    >

        {{-- Logo --}}
        <div class="border-b border-[var(--border-subtle)] px-6 py-7">

            <a
                href="{{ route('admin.dashboard') }}"
                class="font-display text-2xl font-semibold tracking-tight text-[var(--color-primary)]"
            >
                WordSpace
            </a>

            <p class="meta-small mt-2">
                Admin Panel
            </p>

        </div>


        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-7">


            {{-- Main Navigation --}}
            <div class="space-y-1">

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="flex items-center rounded-md px-4 py-3 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.dashboard')
                        ? 'bg-[var(--color-primary)] text-white'
                        : 'text-[var(--color-on-surface-variant)] hover:bg-[var(--color-surface-container-low)] hover:text-[var(--color-primary)]' }}"
                >
                    Dashboard
                </a>


                <a
                    href="{{ route('admin.posts') }}"
                    class="flex items-center rounded-md px-4 py-3 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.posts*')
                        ? 'bg-[var(--color-primary)] text-white'
                        : 'text-[var(--color-on-surface-variant)] hover:bg-[var(--color-surface-container-low)] hover:text-[var(--color-primary)]' }}"
                >
                    Posts
                </a>


                <a
                    href="{{ route('admin.comments') }}"
                    class="flex items-center rounded-md px-4 py-3 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.comments*')
                        ? 'bg-[var(--color-primary)] text-white'
                        : 'text-[var(--color-on-surface-variant)] hover:bg-[var(--color-surface-container-low)] hover:text-[var(--color-primary)]' }}"
                >
                    Comments
                </a>


                <a
                    href="{{ route('admin.users') }}"
                    class="flex items-center rounded-md px-4 py-3 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.users*')
                        ? 'bg-[var(--color-primary)] text-white'
                        : 'text-[var(--color-on-surface-variant)] hover:bg-[var(--color-surface-container-low)] hover:text-[var(--color-primary)]' }}"
                >
                    Users
                </a>

            </div>


            {{-- Personal --}}
            <div class="mt-10">

                <p class="meta-small px-4 mb-2">
                    Personal
                </p>

                <a
                    href="{{ route('my-writing') }}"
                    class="flex items-center rounded-md px-4 py-3 text-sm font-medium transition-colors
                    {{ request()->routeIs('my-writing')
                        ? 'bg-[var(--color-primary)] text-white'
                        : 'text-[var(--color-on-surface-variant)] hover:bg-[var(--color-surface-container-low)] hover:text-[var(--color-primary)]' }}"
                >
                    My Writing
                </a>

            </div>

        </nav>


        {{-- Back to Website --}}
        <div class="border-t border-[var(--border-subtle)] p-4">

            <a
                href="{{ route('posts.index') }}"
                class="flex items-center rounded-md px-4 py-3 text-sm font-medium text-[var(--color-on-surface-variant)] transition-colors hover:bg-[var(--color-surface-container-low)] hover:text-[var(--color-primary)]"
            >
                ← Back to WordSpace
            </a>

        </div>

    </aside>


    {{-- Main --}}
    <div class="pl-64">


        {{-- Top Header --}}
        <header
            class="sticky top-0 z-30 border-b border-[var(--border-subtle)] bg-[var(--color-surface)]"
        >

            <div class="flex h-20 items-center justify-between px-8">


                {{-- Page Context --}}
                <div>

                    <p class="meta">
                        Administration
                    </p>

                </div>


                {{-- User Controls --}}
                <div class="flex items-center gap-6">

                    <span class="text-sm font-medium text-[var(--color-on-surface)]">
                        {{ auth()->user()->name }}
                    </span>


                    <span class="h-5 w-px bg-[var(--border-subtle)]"></span>


                    <a
                        href="{{ route('profile.edit') }}"
                        class="text-sm text-[var(--color-on-surface-variant)] transition-colors hover:text-[var(--color-primary)]"
                    >
                        Profile
                    </a>


                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="text-sm text-[var(--color-on-surface-variant)] transition-colors hover:text-[var(--color-error)]"
                        >
                            Logout
                        </button>

                    </form>

                </div>

            </div>

        </header>


        {{-- Page Content --}}
        <main class="min-h-[calc(100vh-5rem)] bg-[var(--color-surface)]">

            @yield('content')

        </main>

    </div>

</div>

</body>

</html>
