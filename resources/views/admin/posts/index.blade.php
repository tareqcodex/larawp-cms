@extends('admin.layouts.app')

@section('title', 'Posts')
@section('page-title', 'Posts')

@section('content')
    <div class="flex items-center justify-between mb-6">
        {{-- Status filter --}}
        <div class="flex gap-2">
            @foreach (['all' => 'All', 'published' => 'Published', 'draft' => 'Draft', 'scheduled' => 'Scheduled'] as $key => $label)
                <a href="{{ route('admin.posts.index', $key !== 'all' ? ['status' => $key] : []) }}"
                   class="{{ ($status === $key || ($key === 'all' && !$status))
                        ? 'bg-blue-600 text-white'
                        : 'bg-white text-gray-700 hover:bg-gray-50 ring-1 ring-inset ring-gray-300'
                    }} rounded-lg px-3 py-1.5 text-sm font-medium transition-colors">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <a href="{{ route('admin.posts.create') }}"
           class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-colors">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
            </svg>
            New Post
        </a>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
        @if ($posts->isEmpty())
            <div class="py-16 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <p class="mt-4 text-sm text-gray-500">No posts found.</p>
                <a href="{{ route('admin.posts.create') }}" class="mt-2 inline-block text-sm text-blue-600 hover:underline">Create your first post</a>
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 pl-6 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Title</th>
                        <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 hidden sm:table-cell">Author</th>
                        <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 hidden md:table-cell">Categories</th>
                        <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Status</th>
                        <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 hidden lg:table-cell">Date</th>
                        <th class="relative py-3 pl-3 pr-6"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($posts as $post)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 pl-6 pr-3">
                                <p class="text-sm font-medium text-gray-900">{{ $post->title }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">/{{ $post->slug }}</p>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden sm:table-cell">
                                {{ $post->author->name }}
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500 hidden md:table-cell">
                                {{ $post->categories->pluck('name')->join(', ') ?: '—' }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                @php
                                    $statusClass = match($post->status) {
                                        'published' => 'bg-green-50 text-green-700 ring-green-600/20',
                                        'draft'     => 'bg-gray-50 text-gray-600 ring-gray-500/10',
                                        'scheduled' => 'bg-blue-50 text-blue-700 ring-blue-700/10',
                                        default     => 'bg-red-50 text-red-700 ring-red-600/10',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden lg:table-cell">
                                {{ $post->created_at->format('M j, Y') }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm space-x-3">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-600 hover:text-blue-500 font-medium">Edit</a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Move this post to trash?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-400 font-medium">Trash</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="border-t border-gray-200 px-6 py-4">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
