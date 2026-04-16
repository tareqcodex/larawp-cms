@extends('admin.layouts.app')
@section('title', 'New Category')
@section('page-title', 'New Category')
@section('content')
    <div class="max-w-xl">
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Name</label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}"
                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-colors">
                        Create Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}"
                       class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
