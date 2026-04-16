@extends('admin.layouts.app')
@section('title', 'Media Library')
@section('page-title', 'Media Library')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div class="flex gap-2">
            <a href="{{ route('admin.media.index') }}"
               class="{{ !$type ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 ring-1 ring-inset ring-gray-300' }} rounded-lg px-3 py-1.5 text-sm font-medium transition-colors">
                All
            </a>
            <a href="{{ route('admin.media.index', ['type' => 'image']) }}"
               class="{{ $type === 'image' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 ring-1 ring-inset ring-gray-300' }} rounded-lg px-3 py-1.5 text-sm font-medium transition-colors">
                Images
            </a>
        </div>

        <label for="upload-file"
            class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-colors">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a.75.75 0 01.75.75v10.638l3.96-4.158a.75.75 0 111.08 1.04l-5.25 5.5a.75.75 0 01-1.08 0l-5.25-5.5a.75.75 0 111.08-1.04l3.96 4.158V3.75A.75.75 0 0110 3z" clip-rule="evenodd" transform="scale(1,-1) translate(0,-20)"/>
                <path d="M2.25 15.75a.75.75 0 01.75.75v2.25h14V16.5a.75.75 0 011.5 0v3a.75.75 0 01-.75.75H2.25a.75.75 0 01-.75-.75v-3a.75.75 0 01.75-.75z"/>
            </svg>
            Upload File
        </label>
    </div>

    {{-- Upload form (hidden) --}}
    <form id="upload-form" action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="hidden">
        @csrf
        <input id="upload-file" name="file" type="file" accept="*/*" onchange="this.form.submit()">
    </form>

    @if ($media->isEmpty())
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 py-16 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-200" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
            </svg>
            <p class="mt-4 text-sm text-gray-500">No files uploaded yet.</p>
        </div>
    @else
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            @foreach ($media as $item)
                <div class="group relative overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
                    @if ($item->isImage())
                        <img src="{{ $item->url }}" alt="{{ $item->name }}"
                             class="aspect-square w-full object-cover">
                    @else
                        <div class="flex aspect-square w-full items-center justify-center bg-gray-100">
                            <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="p-2">
                        <p class="truncate text-xs font-medium text-gray-700">{{ $item->name }}</p>
                        <p class="text-xs text-gray-400">{{ $item->human_size }}</p>
                    </div>
                    <div class="absolute inset-0 flex items-center justify-center gap-2 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity">
                        <form action="{{ route('admin.media.destroy', $item) }}" method="POST"
                              onsubmit="return confirm('Delete this file permanently?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="rounded-md bg-red-600 px-2.5 py-1.5 text-xs font-semibold text-white hover:bg-red-500">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $media->links() }}</div>
    @endif
@endsection
