@extends('layouts.app')

@section('title', 'Posts')

@section('content')

<div class="site-container py-8 md:py-24">

{{-- Page Header --}}
<div class="mb-12 md:mb-16">

    <div class="flex flex-col gap-8 md:flex-row md:items-end md:justify-between">

        <div class="max-w-2xl">

            <p class="meta mb-3">
                WordSpace
            </p>

            <h1>
                Latest Stories
            </h1>

            <p class="body-large muted mt-4 max-w-xl">
                Discover thoughtful writing, ideas, and stories from the WordSpace community.
            </p>

        </div>

        @auth
            <a
                href="{{ route('posts.create') }}"
                class="btn btn-primary shrink-0"
            >
                Create Post
            </a>
        @endauth

    </div>

</div>


{{-- Posts --}}
<div class="space-y-0">

    @forelse($posts as $post)

        <article class="group border-t border-[var(--border-subtle)] py-8 md:py-10">

            <div class="grid gap-5 md:grid-cols-[1fr_auto] md:items-start">

                <div class="max-w-4xl">

                    {{-- Post Title --}}
                    <h2 class="text-3xl md:text-4xl leading-tight">

                        <a
                            href="{{ route('posts.show', $post) }}"
                            class="transition-colors duration-200 group-hover:text-[var(--color-primary)]"
                        >
                            {{ $post->title }}
                        </a>

                    </h2>


                    {{-- Excerpt --}}
                    <p class="body-large muted mt-4 max-w-3xl">
                        {{ Str::limit($post->content, 220) }}
                    </p>


                    {{-- Metadata --}}
                    <div class="mt-6 flex flex-wrap items-center gap-x-4 gap-y-2">

                        <span class="meta">
                            By {{ $post->user->name }}
                        </span>

                        <span class="text-[var(--color-outline-variant)]">
                            /
                        </span>

                        <span class="meta-small">
                            {{ $post->created_at->format('M d, Y') }}
                        </span>

                    </div>

                </div>


                {{-- Read Link --}}
                <a
                    href="{{ route('posts.show', $post) }}"
                    class="hidden text-sm font-semibold text-[var(--color-primary)] transition-transform duration-200 group-hover:translate-x-1 md:block"
                >
                    Read →
                </a>

            </div>

        </article>

    @empty

        <div class="border-y border-[var(--border-subtle)] py-16 text-center">

            <h2 class="text-2xl">
                No published posts yet.
            </h2>

            <p class="muted mt-3">
                Be the first to share something with the WordSpace community.
            </p>

            @auth
                <a
                    href="{{ route('posts.create') }}"
                    class="btn btn-primary mt-6"
                >
                    Create Post
                </a>
            @endauth

        </div>

    @endforelse

</div>

</div>

@endsection