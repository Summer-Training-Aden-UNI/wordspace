@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')

<div class="site-container py-10 md:py-16">

{{-- Header --}}
<header class="border-b border-[var(--border-subtle)] pb-8">

    <div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">

        <div>

            <p class="meta mb-3 text-[var(--color-secondary)]">
                User Management
            </p>

            <h1>
                Manage Users
            </h1>

            <p class="body-large muted mt-3">
                View and manage all registered users.
            </p>

        </div>

        <a
            href="{{ route('admin.dashboard') }}"
            class="btn border border-[var(--color-primary)] bg-transparent text-[var(--color-primary)] hover:bg-transparent"
        >
            Back to Dashboard
        </a>

    </div>

</header>


{{-- Success Message --}}
@if(session('success'))

    <div class="alert alert-success mt-8">
        {{ session('success') }}
    </div>

@endif


{{-- Users Table --}}
<section class="mt-10">

    <div class="flex items-end justify-between border-b border-[var(--border-subtle)] pb-4">

        <div>

            <p class="meta text-[var(--color-primary)]">
                WordSpace Community
            </p>

            <h2 class="mt-1 text-3xl">
                Registered Users
            </h2>

        </div>

    </div>


    <div class="mt-0 overflow-x-auto">

        <table class="w-full min-w-[760px] text-left">

            <thead class="border-b border-[var(--border-color)]">

                <tr>

                    <th class="px-5 py-4 text-left meta-small">
                        Name
                    </th>

                    <th class="px-5 py-4 text-left meta-small">
                        Email
                    </th>

                    <th class="px-5 py-4 text-left meta-small">
                        Role
                    </th>

                    <th class="px-5 py-4 text-left meta-small">
                        Joined
                    </th>

                    <th class="px-5 py-4 text-left meta-small">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($users as $user)

                    <tr class="border-b border-[var(--border-subtle)] transition-colors hover:bg-[var(--color-surface-container-low)]">

                        <td class="px-5 py-5">

                            <span class="font-semibold text-[var(--color-on-surface)]">
                                {{ $user->name }}
                            </span>

                        </td>


                        <td class="px-5 py-5">

                            <span class="text-sm text-[var(--color-on-surface-variant)]">
                                {{ $user->email }}
                            </span>

                        </td>


                        <td class="px-5 py-5">

                            @if($user->isAdmin())

                                <span class="inline-block border border-[var(--color-primary)] bg-transparent px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[var(--color-primary)]">
                                    Admin
                                </span>

                            @else

                                <span class="inline-block border border-[var(--color-secondary)] bg-transparent px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[var(--color-secondary)]">
                                    User
                                </span>

                            @endif

                        </td>


                        <td class="px-5 py-5">

                            <span class="meta-small">
                                {{ $user->created_at->format('M d, Y') }}
                            </span>

                        </td>


                        <td class="px-5 py-5">

                            @if($user->id !== auth()->id())

                                <form
                                    action="{{ route('admin.users.destroy', $user) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Are you sure you want to delete this user?')"
                                        class="btn border border-[var(--color-error)] bg-transparent text-[var(--color-error)] hover:bg-transparent"
                                    >
                                        Delete
                                    </button>

                                </form>

                            @else

                                <span class="text-sm font-medium text-[var(--color-primary)]">
                                    Current account
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="border-b border-[var(--border-subtle)] py-10 text-center"
                        >

                            <p class="muted">
                                No users found.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</section>

</div>

@endsection
