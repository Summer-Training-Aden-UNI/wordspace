@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="site-container py-10 md:py-16">

    {{-- Page Header --}}
    <header class="border-b border-[var(--border-subtle)] pb-8">

        <p class="meta mb-3">
            Personal Space
        </p>

        <h1>
            Profile
        </h1>

        <p class="body-large muted mt-3">
            Manage your account information, password, and account settings.
        </p>

    </header>


    {{-- Profile Information --}}
    <section class="mt-12">

        <div class="border-b border-[var(--border-subtle)] pb-4">

            <p class="meta">
                Account
            </p>

            <h2 class="mt-1 text-3xl">
                Profile Information
            </h2>

        </div>

        <div class="max-w-3xl py-8">

            @include('profile.partials.update-profile-information-form')

        </div>

    </section>


    {{-- Password --}}
    <section class="mt-12">

        <div class="border-b border-[var(--border-subtle)] pb-4">

            <p class="meta">
                Security
            </p>

            <h2 class="mt-1 text-3xl">
                Update Password
            </h2>

        </div>

        <div class="max-w-3xl py-8">

            @include('profile.partials.update-password-form')

        </div>

    </section>


    {{-- Delete Account --}}
    <section class="mt-12">

        <div class="border-b border-[var(--border-subtle)] pb-4">

            <p class="meta">
                Account Management
            </p>

            <h2 class="mt-1 text-3xl">
                Delete Account
            </h2>

        </div>

        <div class="max-w-3xl py-8">

            @include('profile.partials.delete-user-form')

        </div>

    </section>

</div>

@endsection
