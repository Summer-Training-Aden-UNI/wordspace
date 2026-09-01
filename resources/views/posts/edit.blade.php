@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')

<div class="site-container py-16 md:py-24">

<div class="reading-column mb-12">

    <p class="meta mb-3">
        Edit Story
    </p>

    <h1>
        Edit Post
    </h1>

    <p class="body-large muted mt-4">
        Refine your story, update its content, or change its publication status.
    </p>

</div>

<div class="reading-column">

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
        action="{{ route('posts.update', $post) }}"
        method="POST"
        class="space-y-8"
    >

        @csrf
        @method('PUT')

        <div>

            <label for="title">
                Title
            </label>

            <input
                id="title"
                type="text"
                name="title"
                value="{{ old('title', $post->title) }}"
                placeholder="Give your story a title"
                class="text-lg"
            >

            @error('title')
                <p class="mt-2 text-sm text-[var(--color-error)]">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <div>

            <label for="content">
                Content
            </label>

            <textarea
                id="content"
                name="content"
                rows="14"
                placeholder="Continue writing..."
                class="min-h-[360px]"
            >{{ old('content', $post->content) }}</textarea>

            @error('content')
                <p class="mt-2 text-sm text-[var(--color-error)]">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <div>

            <label for="status">
                Publication Status
            </label>

            <select
                id="status"
                name="status"
            >

                <option
                    value="draft"
                    @selected(old('status', $post->status) === 'draft')
                >
                    Draft
                </option>

                <option
                    value="published"
                    @selected(old('status', $post->status) === 'published')
                >
                    Published
                </option>

            </select>

            @error('status')
                <p class="mt-2 text-sm text-[var(--color-error)]">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <div class="flex flex-col gap-3 border-t border-[var(--border-subtle)] pt-8 sm:flex-row sm:items-center">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Update Post
            </button>

            <a
                href="{{ route('posts.show', $post) }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

        </div>

    </form>

</div>

</div>

@endsection
