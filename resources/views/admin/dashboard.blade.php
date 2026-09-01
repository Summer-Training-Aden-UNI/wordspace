@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="site-container py-10 md:py-16">

{{-- Dashboard Header --}}
<header class="border-b border-[var(--border-subtle)] pb-8">

    <p class="meta mb-3">
        Administration
    </p>

    <h1>
        Dashboard
    </h1>

    <p class="body-large muted mt-3">
        Overview of your WordSpace platform.
    </p>

</header>


{{-- Statistics --}}
<section class="grid border-b border-[var(--border-subtle)] md:grid-cols-3">

    {{-- Users --}}
    <div class="border-b border-[var(--border-subtle)] py-7 md:border-b-0 md:border-r md:pr-10">

        <p class="meta-small">
            Total Users
        </p>

        <p class="mt-2 font-display text-4xl font-medium text-[var(--color-primary)]">
            {{ $usersCount }}
        </p>

    </div>


    {{-- Posts --}}
    <div class="border-b border-[var(--border-subtle)] py-7 md:border-b-0 md:border-r md:px-10">

        <p class="meta-small">
            Total Posts
        </p>

        <p class="mt-2 font-display text-4xl font-medium text-[var(--color-primary)]">
            {{ $postsCount }}
        </p>

    </div>


    {{-- Comments --}}
    <div class="py-7 md:pl-10">

        <p class="meta-small">
            Total Comments
        </p>

        <p class="mt-2 font-display text-4xl font-medium text-[var(--color-primary)]">
            {{ $commentsCount }}
        </p>

    </div>

</section>


{{-- Recent Activity --}}
<section class="mt-12">

    {{-- Activity Header --}}
    <div class="flex flex-col gap-5 border-b border-[var(--border-subtle)] pb-4 sm:flex-row sm:items-end sm:justify-between">

        <div>

            <p class="meta">
                Platform Activity
            </p>

            <h2 class="mt-1 text-3xl">
                Recent Activity
            </h2>

            <p class="body-medium muted mt-2">
                View the latest activity on WordSpace.
            </p>

        </div>


        {{-- Dropdown --}}
        <div class="shrink-0">

            <label
                for="activityType"
                class="sr-only"
            >
                Activity Type
            </label>

            <select
                id="activityType"
                class="min-w-[150px]"
            >

                <option value="posts">
                    Posts
                </option>

                <option value="users">
                    Users
                </option>

                <option value="comments">
                    Comments
                </option>

            </select>

        </div>

    </div>


    {{-- Posts --}}
    <div
        id="postsActivity"
        class="activity-content"
    >

        @forelse($recentPosts as $post)

            <article class="group border-b border-[var(--border-subtle)] py-7">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                    <div class="min-w-0">

                        <a
                            href="{{ route('posts.show', $post) }}"
                            class="font-display text-2xl font-medium text-[var(--color-on-surface)] transition-colors group-hover:text-[var(--color-primary)]"
                        >
                            {{ $post->title }}
                        </a>

                        <p class="meta-small mt-2">
                            By
                            <span class="text-[var(--color-on-surface-variant)]">
                                {{ $post->user->name }}
                            </span>
                        </p>

                        <span
                            class="mt-3 inline-block border border-[var(--border-color)] px-2.5 py-1 text-xs font-medium
                            {{ $post->status === 'published'
                                ? 'border-[var(--color-primary)] text-[var(--color-primary)]'
                                : 'text-[var(--color-on-surface-variant)]' }}"
                        >
                            {{ ucfirst($post->status) }}
                        </span>

                    </div>

                    <p class="meta-small shrink-0">
                        {{ $post->created_at->diffForHumans() }}
                    </p>

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


    {{-- Users --}}
    <div
        id="usersActivity"
        class="activity-content hidden"
    >

        @forelse($recentUsers as $user)

            <article class="border-b border-[var(--border-subtle)] py-7">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                    <div>

                        <p class="font-display text-2xl font-medium text-[var(--color-on-surface)]">
                            {{ $user->name }}
                        </p>

                        <p class="body-medium muted mt-1">
                            {{ $user->email }}
                        </p>

                        <span
                            class="mt-3 inline-block border border-[var(--border-color)] px-2.5 py-1 text-xs font-medium
                            {{ $user->isAdmin()
                                ? 'border-[var(--color-primary)] text-[var(--color-primary)]'
                                : 'text-[var(--color-on-surface-variant)]' }}"
                        >
                            {{ $user->isAdmin() ? 'Admin' : 'User' }}
                        </span>

                    </div>

                    <p class="meta-small shrink-0">
                        {{ $user->created_at->diffForHumans() }}
                    </p>

                </div>

            </article>

        @empty

            <div class="border-b border-[var(--border-subtle)] py-8">

                <p class="muted">
                    No users found.
                </p>

            </div>

        @endforelse

    </div>


    {{-- Comments --}}
    <div
        id="commentsActivity"
        class="activity-content hidden"
    >

        @forelse($recentComments as $comment)

            <article class="border-b border-[var(--border-subtle)] py-7">

                <div class="flex flex-col gap-3">

                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                        <p class="font-semibold text-[var(--color-on-surface)]">
                            {{ $comment->user->name }}
                        </p>

                        <p class="meta-small">
                            {{ $comment->created_at->diffForHumans() }}
                        </p>

                    </div>

                    <p class="body-medium text-[var(--color-on-surface)]">
                        {{ $comment->content }}
                    </p>

                    <a
                        href="{{ route('posts.show', $comment->post) }}"
                        class="text-sm font-medium text-[var(--color-primary)] underline underline-offset-4 transition-opacity hover:opacity-70"
                    >
                        On: {{ $comment->post->title }}
                    </a>

                </div>

            </article>

        @empty

            <div class="border-b border-[var(--border-subtle)] py-8">

                <p class="muted">
                    No comments found.
                </p>

            </div>

        @endforelse

    </div>

</section>

</div>

{{-- Activity Dropdown JavaScript --}}

<script>

    const activityType = document.getElementById('activityType');

    const activities = {
        posts: document.getElementById('postsActivity'),
        users: document.getElementById('usersActivity'),
        comments: document.getElementById('commentsActivity')
    };

    activityType.addEventListener('change', function () {

        Object.values(activities).forEach(function (activity) {
            activity.classList.add('hidden');
        });

        activities[this.value].classList.remove('hidden');

    });

</script>

@endsection
