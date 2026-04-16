@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    {{-- Stats grid --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $cards = [
                ['label' => 'Total Posts', 'value' => $stats['posts'], 'color' => 'blue', 'route' => 'admin.posts.index'],
                ['label' => 'Published', 'value' => $stats['published'], 'color' => 'green', 'route' => 'admin.posts.index'],
                ['label' => 'Drafts', 'value' => $stats['drafts'], 'color' => 'yellow', 'route' => 'admin.posts.index'],
                ['label' => 'Pages', 'value' => $stats['pages'], 'color' => 'purple', 'route' => 'admin.pages.index'],
                ['label' => 'Categories', 'value' => $stats['categories'], 'color' => 'pink', 'route' => 'admin.categories.index'],
                ['label' => 'Media Files', 'value' => $stats['media'], 'color' => 'orange', 'route' => 'admin.media.index'],
                ['label' => 'Users', 'value' => $stats['users'], 'color' => 'teal', 'route' => 'admin.dashboard'],
            ];
            $colors = [
                'blue' => 'bg-blue-50 text-blue-700 ring-blue-700/10',
                'green' => 'bg-green-50 text-green-700 ring-green-600/20',
                'yellow' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20',
                'purple' => 'bg-purple-50 text-purple-700 ring-purple-700/10',
                'pink' => 'bg-pink-50 text-pink-700 ring-pink-700/10',
                'orange' => 'bg-orange-50 text-orange-700 ring-orange-700/10',
                'teal' => 'bg-teal-50 text-teal-700 ring-teal-700/10',
            ];
        @endphp

        @foreach ($cards as $card)
            <a href="{{ route($card['route']) }}"
               class="overflow-hidden rounded-xl bg-white px-6 py-5 shadow-sm ring-1 ring-gray-900/5 hover:shadow-md transition-shadow">
                <dt class="truncate text-sm font-medium text-gray-500">{{ $card['label'] }}</dt>
                <dd class="mt-2 flex items-baseline gap-x-2">
                    <span class="text-3xl font-semibold tracking-tight text-gray-900">{{ number_format($card['value']) }}</span>
                </dd>
            </a>
        @endforeach
    </div>

    {{-- Recent Posts --}}
    <div class="mt-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold text-gray-900">Recent Posts</h2>
            <a href="{{ route('admin.posts.create') }}"
               class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-colors">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
                </svg>
                New Post
            </a>
        </div>

        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
            @if ($recentPosts->isEmpty())
                <div class="py-12 text-center text-sm text-gray-500">
                    No posts yet. <a href="{{ route('admin.posts.create') }}" class="text-blue-600 hover:underline">Create your first post</a>.
                </div>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 pl-6 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Title</th>
                            <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Author</th>
                            <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Status</th>
                            <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Date</th>
                            <th class="relative py-3 pl-3 pr-6"><span class="sr-only">Edit</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($recentPosts as $post)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 pl-6 pr-3">
                                    <p class="text-sm font-medium text-gray-900 truncate max-w-xs">{{ $post->title }}</p>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $post->author->name }}</td>
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
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $post->created_at->format('M j, Y') }}
                                </td>
                                <td class="whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-600 hover:text-blue-500 font-medium">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
