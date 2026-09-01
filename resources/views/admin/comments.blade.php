@extends('layouts.admin')

@section('title', 'Manage Comments')

@section('content')

<div class="site-container py-10 md:py-16">

```
{{-- Page Header --}}
<header class="border-b border-[var(--border-subtle)] pb-8">

    <div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">

        <div>

            <p class="meta mb-3">
                Administration
            </p>

            <h1>
                Manage Comments
            </h1>

            <p class="body-large muted mt-3">
                Monitor and manage all comments on WordSpace.
            </p>

        </div>

        <a
            href="{{ route('admin.dashboard') }}"
            class="btn btn-secondary shrink-0"
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

{{-- Comments --}}
<section class="mt-10">

    <div class="border-b border-[var(--border-subtle)] pb-4">

        <p class="meta">
            Community
        </p>

        <h2 class="mt-1 text-3xl">
            Comments
        </h2>

    </div>

    <div>

        @forelse($comments as $comment)

            <article class="border-b border-[var(--border-subtle)] py-7">

                <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">

                    <div class="min-w-0 max-w-4xl">

                        <p class="font-display text-xl leading-relaxed text-[var(--color-on-surface)]">
                            "{{ $comment->content }}"
                        </p>

                        <div class="mt-4 space-y-1">

                            <p class="meta-small">
                                By
                                <span class="text-[var(--color-on-surface-variant)]">
                                    {{ $comment->user->name }}
                                </span>
                            </p>

                            <p class="meta-small">

                                On

                                <a
                                    href="{{ route('posts.show', $comment->post) }}"
                                    class="font-medium text-[var(--color-primary)] underline underline-offset-4 transition-opacity hover:opacity-70"
                                >
                                    {{ $comment->post->title }}
                                </a>

                            </p>

                            <p class="meta-small">
                                {{ $comment->created_at->format('M d, Y H:i') }}
                            </p>

                        </div>

                    </div>

                    <form
                        action="{{ route('admin.comments.destroy', $comment) }}"
                        method="POST"
                        class="shrink-0"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            onclick="return confirm('Are you sure you want to delete this comment?')"
                            class="btn border border-[var(--color-error)] text-[var(--color-error)] hover:bg-[var(--color-error-container)]"
                        >
                            Delete
                        </button>

                    </form>

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
```

</div>

@endsection
