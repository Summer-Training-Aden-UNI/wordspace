@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

<div class="mx-auto max-w-6xl px-6 py-16 md:px-10 md:py-24">

    {{-- Header --}}
    <div class="mb-12 max-w-5xl">

        <p class="meta mb-3">
            New Story
        </p>

        <h1>
            Create a Post
        </h1>

        <p class="body-large muted mt-4">
            Put your thoughts into words and share them with the WordSpace community.
        </p>

    </div>




{{-- Form --}}
<div class="mx-auto max-w-5xl">

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
        action="{{ route('posts.store') }}"
        method="POST"
        class="space-y-8"
    >

        @csrf

        {{-- Title --}}
        <div>

            <label for="title">
                Title
            </label>

            <input
                id="title"
                type="text"
                name="title"
                value="{{ old('title') }}"
                placeholder="Give your story a title"
                class="text-lg"
            >

            @error('title')
                <p class="mt-2 text-sm text-[var(--color-error)]">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Content --}}
        <div>

            <label for="content">
                Content
            </label>

            <textarea
                id="content"
                name="content"
                rows="14"
                placeholder="Start writing..."
                class="min-h-[360px]"
            >{{ old('content') }}</textarea>

            @error('content')
                <p class="mt-2 text-sm text-[var(--color-error)]">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Status --}}
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
                    @selected(old('status') === 'draft')
                >
                    Draft
                </option>

                <option
                    value="published"
                    @selected(old('status') === 'published')
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


        {{-- Actions --}}
        <div class="flex flex-col gap-3 border-t border-[var(--border-subtle)] pt-8 sm:flex-row sm:items-center">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Create Post
            </button>

            <a
                href="{{ route('posts.index') }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

        </div>

    </form>

</div>


</div>

@endsection
