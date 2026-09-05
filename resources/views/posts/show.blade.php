@extends('layouts.app')

@section('title', $post->title)

@section('content')

@php
 $wordCount = str_word_count(strip_tags($post->content)); 
 $readingTime = max(1, ceil($wordCount / 200)); 
@endphp

<div class="site-container py-10 md:py-14">

{{-- Post --}}
<article class="max-w-6xl">

    {{-- Post Header --}}
    <header class="border-b border-[var(--border-subtle)] pb-7">

        <p class="meta mb-3">
            Story
        </p>

        <h1 class="article-title">
            {{ $post->title }}
        </h1>

        <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2">

            <span class="meta">
                By {{ $post->user->name }}
            </span>

            <span class="text-[var(--color-outline-variant)]">
                /
            </span>

            <span class="meta-small">
                {{ $post->created_at->format('M d, Y') }}
            </span>

            <span class="text-[var(--color-outline-variant)]"> 
                / 
                </span> 
            <span class="meta-small"> 
                {{ $readingTime }} min read 

            </span>

        </div>

    </header>


    {{-- Content + Actions --}}
    <div class="grid grid-cols-1 gap-8 border-b border-[var(--border-subtle)] py-8 md:grid-cols-[minmax(0,1fr)_120px]">

        {{-- Post Content --}}
        <div class="article-body max-w-4xl">

            {{ $post->content }}

        </div>


        {{-- Actions --}}
        <aside class="flex items-start justify-start md:justify-end">

            <div class="flex flex-row items-center gap-3 md:flex-col">

                {{-- Edit / Delete --}}
                @auth

                    @if($post->user_id === auth()->id() || auth()->user()->isAdmin())

                        <a
                            href="{{ route('posts.edit', $post) }}"
                            title="Edit Post"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-[var(--border-color)] text-[var(--color-on-surface-variant)] transition-colors hover:border-[var(--color-primary)] hover:text-[var(--color-primary)]"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.7"
                                class="h-5 w-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 20h9"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"
                                />
                            </svg>
                        </a>

                        <form
                            action="{{ route('posts.destroy', $post) }}"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                title="Delete Post"
                                class="flex h-10 w-10 items-center justify-center rounded-full border border-[var(--color-error)] text-[var(--color-error)] transition-colors hover:bg-[var(--color-error-container)]"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    class="h-5 w-5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 6h18"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M8 6V4h8v2"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19 6l-1 14H6L5 6"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M10 11v5M14 11v5"
                                    />
                                </svg>
                            </button>

                        </form>

                    @endif

                @endauth


                {{-- Like --}}
                @auth

                    @php
                        $userLiked = $post->likes
                            ->where('user_id', auth()->id())
                            ->isNotEmpty();
                    @endphp

                    @if($userLiked)

                        <form
                            action="{{ route('likes.destroy', $post) }}"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                title="Unlike"
                                aria-label="Unlike"
                                class="flex h-10 w-10 items-center justify-center rounded-full border border-[var(--color-secondary)] text-[var(--color-secondary)] transition-all duration-200 hover:bg-[var(--color-secondary-container)]"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="h-5 w-5"
                                >
                                    <path d="M12 21s-7.5-4.35-9.5-8.5C.5 8.5 3 5 6.5 5c2 0 3.5 1 5.5 3 2-2 3.5-3 5.5-3C21 5 23.5 8.5 21.5 12.5 19.5 16.65 12 21 12 21z"/>
                                </svg>
                            </button>

                        </form>

                    @else

                        <form
                            action="{{ route('likes.store', $post) }}"
                            method="POST"
                        >

                            @csrf

                            <button
                                type="submit"
                                title="Like"
                                aria-label="Like"
                                class="flex h-10 w-10 items-center justify-center rounded-full border border-[var(--border-color)] text-[var(--color-on-surface-variant)] transition-all duration-200 hover:border-[var(--color-secondary)] hover:text-[var(--color-secondary)]"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    class="h-5 w-5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"
                                    />
                                </svg>
                            </button>

                        </form>

                    @endif

                @else

                    <a
                        href="{{ route('login') }}"
                        title="Log in to like"
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-[var(--border-color)] text-[var(--color-on-surface-variant)] transition-colors hover:border-[var(--color-primary)] hover:text-[var(--color-primary)]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            class="h-5 w-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"
                            />
                        </svg>
                    </a>

                @endauth

            </div>

        </aside>

    </div>


    {{-- Like Count --}}
    <div class="border-b border-[var(--border-subtle)] py-3">

        <span class="meta">
            {{ $post->likes->count() }}
            {{ Str::plural('Like', $post->likes->count()) }}
        </span>

    </div>


    {{-- Comments --}}
    <section class="mt-10">

        <div class="border-b border-[var(--border-subtle)] pb-4">

            <p class="meta">
                Discussion
            </p>

            <h2 class="mt-1 text-3xl">
                Comments
            </h2>

        </div>


        {{-- Add Comment --}}
        @auth

            <form
                action="{{ route('comments.store', $post) }}"
                method="POST"
                class="mt-6"
            >

                @csrf

                <label for="comment">
                    Add a Comment
                </label>

                <textarea
                    id="comment"
                    name="content"
                    rows="4"
                    placeholder="Write a thoughtful comment..."
                    class="mt-2"
                >{{ old('content') }}</textarea>

                @error('content')

                    <p class="mt-2 text-sm text-[var(--color-error)]">
                        {{ $message }}
                    </p>

                @enderror

                <button
                    type="submit"
                    class="btn btn-primary mt-3"
                >
                    Comment
                </button>

            </form>

        @else

            <p class="body-medium muted mt-6">

                <a
                    href="{{ route('login') }}"
                    class="font-semibold text-[var(--color-primary)] underline underline-offset-4"
                >
                    Log in
                </a>

                to join the discussion.

            </p>

        @endauth


        {{-- Comments List --}}
        <div class="mt-6">

            @forelse($post->comments as $comment)

                <div class="border-t border-[var(--border-subtle)] py-6">

                    <div class="flex items-start justify-between gap-6">

                        <div>

                            <p class="font-semibold text-[var(--color-on-surface)]">
                                {{ $comment->user->name }}
                            </p>

                            <p class="meta-small mt-1">
                                {{ $comment->created_at->diffForHumans() }}
                            </p>

                        </div>

                        @auth

                            @if(
                                $comment->user_id === auth()->id()
                                || auth()->user()->isAdmin()
                            )

                                <form
                                    action="{{ route('comments.destroy', $comment) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-sm font-medium text-[var(--color-error)] transition-opacity hover:opacity-70"
                                    >
                                        Delete
                                    </button>

                                </form>

                            @endif

                        @endauth

                    </div>

                    <p class="body-medium mt-3 text-[var(--color-on-surface)]">
                        {{ $comment->content }}
                    </p>

                </div>

            @empty

                <div class="border-t border-[var(--border-subtle)] py-6">

                    <p class="muted">
                        No comments yet.
                    </p>

                </div>

            @endforelse

        </div>

    </section>

</article>

</div>

@endsection
