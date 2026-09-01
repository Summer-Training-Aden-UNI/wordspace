@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="site-container py-16 md:py-24">

    {{-- Header --}}
    <div class="mx-auto mb-12 max-w-2xl">

        <p class="meta mb-3">
            Welcome Back
        </p>

        <h1>
            Log In
        </h1>

        <p class="body-large muted mt-4">
            Sign in to your WordSpace account to continue writing and managing your posts.
        </p>

    </div>


    {{-- Login Form --}}
    <div class="mx-auto max-w-2xl">

        {{-- Session Status --}}
        @if (session('status'))

            <div class="alert alert-success mb-8">
                {{ session('status') }}
            </div>

        @endif


        {{-- Validation Errors --}}
        @if($errors->any())

            <div class="alert alert-error mb-8">

                <p class="mb-2 font-semibold">
                    Please correct the following:
                </p>

                <ul class="list-disc space-y-1 pl-5">

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('login') }}"
            class="space-y-7"
        >

            @csrf


            {{-- Email --}}
            <div>

                <label for="email">
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                >

                @error('email')
                    <p class="mt-2 text-sm text-[var(--color-error)]">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Password --}}
            <div>

                <label for="password">
                    Password
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                >

                @error('password')
                    <p class="mt-2 text-sm text-[var(--color-error)]">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Remember Me --}}
            <div>

                <label class="inline-flex cursor-pointer items-center gap-2">

                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="h-4 w-4 border-[var(--border-color)] text-[var(--color-primary)] focus:ring-[var(--color-primary)]"
                    >

                    <span class="text-sm text-[var(--color-on-surface-variant)]">
                        Remember me
                    </span>

                </label>

            </div>


            {{-- Actions --}}
            <div class="flex flex-col gap-4 border-t border-[var(--border-subtle)] pt-8 sm:flex-row sm:items-center sm:justify-between">

                @if (Route::has('password.request'))

                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm font-medium text-[var(--color-on-surface-variant)] underline underline-offset-4 transition-colors hover:text-[var(--color-primary)]"
                    >
                        Forgot your password?
                    </a>

                @endif

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Log In
                </button>

            </div>

        </form>

    </div>

</div>

@endsection

