@extends('layouts.app')

@section('title', 'My Writing')

@section('content')

<div class="site-container py-10 md:py-16">

{{-- Page Header --}}
<header class="border-b border-[var(--border-subtle)] pb-8">

    <div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">

        <div>

            <p class="meta mb-3">
                Personal Space
            </p>

            <h1>
                My Writing
            </h1>

            <p class="body-large muted mt-3">
                Manage your published posts and drafts.
            </p>

        </div>

        <a
            href="{{ route('posts.create') }}"
            class="btn btn-primary shrink-0"
        >
            Create Post
        </a>

    </div>

</header>

{{-- Published Posts --}}
<section class="mt-12">

    <div class="flex items-end justify-between border-b border-[var(--border-subtle)] pb-4">

        <div>

            <p class="meta">
                Your Writing
            </p>

            <h2 class="mt-1 text-3xl text-[var(--color-primary)]">
                Published Posts
            </h2>

        </div>

    </div>

    <div>

        @forelse($publishedPosts as $post)

            <article class="group border-b border-[var(--border-subtle)] py-7">

                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">

                    <div class="min-w-0">

                        <h3 class="font-display text-2xl font-medium text-[var(--color-on-surface)] transition-colors group-hover:text-[var(--color-primary)]">

                            <a href="{{ route('posts.show', $post) }}">
                                {{ $post->title }}
                            </a>

                        </h3>

                        <p class="meta-small mt-2">
                            Published {{ $post->created_at->diffForHumans() }}
                        </p>

                    </div>

                    <a
                        href="{{ route('posts.show', $post) }}"
                        class="shrink-0 text-sm font-semibold text-[var(--color-primary)] transition-transform duration-200 group-hover:translate-x-1"
                    >
                        View →
                    </a>

                </div>

            </article>

        @empty

            <div class="border-b border-[var(--border-subtle)] py-8">

                <p class="muted">
                    You haven't published any posts yet.
                </p>

                <a
                    href="{{ route('posts.create') }}"
                    class="mt-4 inline-block text-sm font-semibold text-[var(--color-primary)] underline underline-offset-4"
                >
                    Write your first post →
                </a>

            </div>

        @endforelse

    </div>

</section>

{{-- Drafts --}}
<section class="mt-14">

    <div class="border-b border-[var(--border-subtle)] pb-4">

        <p class="meta">
            Unfinished
        </p>

        <h2 class="mt-1 text-3xl text-[var(--color-secondary)]">
            Drafts
        </h2>

    </div>

    <div>

        @forelse($draftPosts as $post)

            <article class="border-b border-[var(--border-subtle)] py-7">

                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">

                    <div class="min-w-0">

                        <h3 class="font-display text-2xl font-medium text-[var(--color-on-surface)]">
                            {{ $post->title }}
                        </h3>

                        <p class="meta-small mt-2">
                            Draft · {{ $post->created_at->diffForHumans() }}
                        </p>

                    </div>

                    <div class="flex shrink-0 items-center gap-3">

                        <a
                            href="{{ route('posts.edit', $post) }}"
                            class="btn btn-secondary"
                        >
                            Edit
                        </a>

                        <form
                            action="{{ route('posts.destroy', $post) }}"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                onclick="return confirm('Are you sure you want to delete this draft?')"
                                class="btn border border-[var(--color-error)] text-[var(--color-error)] hover:bg-[var(--color-error-container)]"
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
                    You don't have any drafts.
                </p>

            </div>

        @endforelse

    </div>

</section>

</div>

@endsection
