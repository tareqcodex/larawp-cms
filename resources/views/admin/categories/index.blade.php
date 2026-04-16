@extends('admin.layouts.app')
@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Add category form --}}
        <div class="lg:col-span-1">
            <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-4">Add New Category</h2>
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                            class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm @error('name') ring-red-500 @enderror">
                        @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1.5">Slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}" placeholder="auto-generated"
                            class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                        <textarea id="description" name="description" rows="3"
                            class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1.5">Parent</label>
                        <select id="parent_id" name="parent_id"
                            class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">
                            <option value="">— None —</option>
                            @foreach ($categories as $cat)
                                @if (! $cat->parent_id)
                                    <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-colors">
                        Add Category
                    </button>
                </form>
            </div>
        </div>

        {{-- Categories table --}}
        <div class="lg:col-span-2">
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
                @if ($categories->isEmpty())
                    <div class="py-16 text-center text-sm text-gray-500">No categories yet.</div>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 pl-6 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Name</th>
                                <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Slug</th>
                                <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 hidden sm:table-cell">Posts</th>
                                <th class="relative py-3 pl-3 pr-6"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($categories as $category)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 pl-6 pr-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            @if ($category->parent_id)
                                                <span class="text-gray-400 mr-1">↳</span>
                                            @endif
                                            {{ $category->name }}
                                        </p>
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500">{{ $category->slug }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-500 hidden sm:table-cell">{{ $category->posts_count }}</td>
                                    <td class="whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm space-x-3">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-500 font-medium">Edit</a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-400 font-medium">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="border-t border-gray-200 px-6 py-4">{{ $categories->links() }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection
