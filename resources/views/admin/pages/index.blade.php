@extends('admin.layouts.app')
@section('title', 'Pages')
@section('page-title', 'Pages')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div class="flex gap-2">
            @foreach (['all' => 'All', 'published' => 'Published', 'draft' => 'Draft'] as $key => $label)
                <a href="{{ route('admin.pages.index', $key !== 'all' ? ['status' => $key] : []) }}"
                   class="{{ ($status === $key || ($key === 'all' && !$status))
                        ? 'bg-blue-600 text-white'
                        : 'bg-white text-gray-700 hover:bg-gray-50 ring-1 ring-inset ring-gray-300'
                    }} rounded-lg px-3 py-1.5 text-sm font-medium transition-colors">
                    {{ $label }}
                </a>
            @endforeach
        </div>
        <a href="{{ route('admin.pages.create') }}"
           class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-colors">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
            </svg>
            New Page
        </a>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
        @if ($pages->isEmpty())
            <div class="py-16 text-center">
                <p class="text-sm text-gray-500">No pages found.</p>
                <a href="{{ route('admin.pages.create') }}" class="mt-2 inline-block text-sm text-blue-600 hover:underline">Create your first page</a>
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 pl-6 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Title</th>
                        <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 hidden sm:table-cell">Author</th>
                        <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Status</th>
                        <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 hidden lg:table-cell">Updated</th>
                        <th class="relative py-3 pl-3 pr-6"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($pages as $page)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 pl-6 pr-3">
                                <p class="text-sm font-medium text-gray-900">{{ $page->title }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">/{{ $page->slug }}</p>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden sm:table-cell">{{ $page->author->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $page->status === 'published' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-gray-50 text-gray-600 ring-gray-500/10' }}">
                                    {{ ucfirst($page->status) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden lg:table-cell">{{ $page->updated_at->format('M j, Y') }}</td>
                            <td class="whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm space-x-3">
                                <a href="{{ route('admin.pages.edit', $page) }}" class="text-blue-600 hover:text-blue-500 font-medium">Edit</a>
                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Move this page to trash?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-400 font-medium">Trash</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="border-t border-gray-200 px-6 py-4">{{ $pages->links() }}</div>
        @endif
    </div>
@endsection
