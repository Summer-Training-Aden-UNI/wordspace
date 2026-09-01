@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="site-container py-16 md:py-24">

    {{-- Header --}}
    <div class="mx-auto mb-12 max-w-2xl">

        <p class="meta mb-3">
            Join WordSpace
        </p>

        <h1>
            Create an Account
        </h1>

        <p class="body-large muted mt-4">
            Create your account and start sharing your ideas with the WordSpace community.
        </p>

    </div>


    {{-- Registration Form --}}
    <div class="mx-auto max-w-2xl">

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
            action="{{ route('register') }}"
            class="space-y-7"
        >

            @csrf


            {{-- Name --}}
            <div>

                <label for="name">
                    Name
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                >

                @error('name')
                    <p class="mt-2 text-sm text-[var(--color-error)]">
                        {{ $message }}
                    </p>
                @enderror

            </div>


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
                    autocomplete="new-password"
                >

                @error('password')
                    <p class="mt-2 text-sm text-[var(--color-error)]">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Confirm Password --}}
            <div>

                <label for="password_confirmation">
                    Confirm Password
                </label>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                >

                @error('password_confirmation')
                    <p class="mt-2 text-sm text-[var(--color-error)]">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Actions --}}
            <div class="flex flex-col gap-4 border-t border-[var(--border-subtle)] pt-8 sm:flex-row sm:items-center sm:justify-between">

                <a
                    href="{{ route('login') }}"
                    class="text-sm font-medium text-[var(--color-on-surface-variant)] underline underline-offset-4 transition-colors hover:text-[var(--color-primary)]"
                >
                    Already registered?
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Register
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
