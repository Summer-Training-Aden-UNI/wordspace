@extends('layouts.admin')

@section('title', 'Manage Posts')

@section('content')

<div class="site-container py-10 md:py-16">

{{-- Page Header --}}
<header class="border-b border-[var(--border-subtle)] pb-8">

    <div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">

        <div>

            <p class="meta mb-3 text-[var(--color-tertiary)]">
                Content Management
            </p>

            <h1>
                Manage Posts
            </h1>

            <p class="body-large muted mt-3">
                Monitor and manage all posts published on WordSpace.
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


{{-- Posts --}}
<section class="mt-10">

    <div class="flex items-end justify-between border-b border-[var(--border-subtle)] pb-4">

        <div>

            <p class="meta text-[var(--color-primary)]">
                WordSpace
            </p>

            <h2 class="mt-1 text-3xl">
                All Posts
            </h2>

        </div>

    </div>


    <div>

        @forelse($posts as $post)

            <article class="group border-b border-[var(--border-subtle)] py-7">

                <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">

                    {{-- Post Information --}}
                    <div class="min-w-0 max-w-4xl">

                        <div class="flex flex-wrap items-center gap-3">

                            <h3 class="font-display text-2xl font-medium text-[var(--color-on-surface)] transition-colors group-hover:text-[var(--color-primary)]">
                                {{ $post->title }}
                            </h3>

                            @if($post->status === 'published')

                                <span class="border border-[var(--color-tertiary)] bg-transparent px-2.5 py-1 text-xs font-semibold text-[var(--color-tertiary)]">
                                    Published
                                </span>

                            @else

                                <span class="border border-[var(--color-outline)] bg-transparent px-2.5 py-1 text-xs font-semibold text-[var(--color-on-surface-variant)]">
                                    Draft
                                </span>

                            @endif

                        </div>

                        <p class="meta-small mt-2">
                            By
                            <span class="text-[var(--color-secondary)]">
                                {{ $post->user->name }}
                            </span>
                        </p>

                        <p class="body-medium mt-4 max-w-3xl text-[var(--color-on-surface)]">
                            {{ Str::limit($post->content, 200) }}
                        </p>

                        <p class="meta-small mt-4">
                            {{ $post->created_at->format('M d, Y') }}
                        </p>

                    </div>


                    {{-- Actions --}}
                    <div class="flex shrink-0 items-center gap-3">

                        <a
                            href="{{ route('posts.show', $post) }}"
                            class="btn border border-[var(--color-primary)] bg-transparent text-[var(--color-primary)] hover:bg-transparent"
                        >
                            View
                        </a>

                        <form
                            action="{{ route('admin.posts.destroy', $post) }}"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                onclick="return confirm('Are you sure you want to delete this post?')"
                                class="btn border border-[var(--color-error)] bg-transparent text-[var(--color-error)] hover:bg-transparent"
                            >
                                Delete
                            </button>

                        </form>

                    </div>

                </div>

            </article>

        @empty

            <div class="border-b border-[var(--border-subtle)] py-8">

                <p class="muted">
                    No posts found.
                </p>

            </div>

        @endforelse

    </div>

</section>

</div>

@endsection
