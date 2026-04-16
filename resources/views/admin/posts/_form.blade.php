<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    {{-- Main column --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Title --}}
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">Title <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" required
                    value="{{ old('title', $post?->title) }}"
                    placeholder="Enter post title..."
                    class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm @error('title') ring-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1.5">Slug</label>
                <div class="flex rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-blue-600">
                    <span class="flex select-none items-center pl-3 text-gray-400 sm:text-sm">/</span>
                    <input type="text" id="slug" name="slug"
                        value="{{ old('slug', $post?->slug) }}"
                        placeholder="auto-generated-from-title"
                        class="block flex-1 border-0 bg-transparent py-2.5 pl-1 pr-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm">
                </div>
                @error('slug')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Content --}}
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
            <label for="content" class="block text-sm font-medium text-gray-700 mb-1.5">Content</label>
            <textarea id="content" name="content" rows="18"
                placeholder="Write your post content here..."
                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm font-mono">{{ old('content', $post?->content) }}</textarea>
        </div>

        {{-- Excerpt --}}
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1.5">Excerpt</label>
            <p class="text-xs text-gray-500 mb-2">A short summary of the post (used in listings and SEO).</p>
            <textarea id="excerpt" name="excerpt" rows="3"
                placeholder="Optional short description..."
                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">{{ old('excerpt', $post?->excerpt) }}</textarea>
        </div>

        {{-- SEO --}}
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">SEO</h3>
            <div class="space-y-4">
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1.5">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title"
                        value="{{ old('meta_title', $post?->meta_title) }}"
                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">
                </div>
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1.5">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3"
                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">{{ old('meta_description', $post?->meta_description) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar column --}}
    <div class="space-y-6">
        {{-- Publish --}}
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Publish</h3>
            <div class="space-y-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                    <select id="status" name="status"
                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">
                        @foreach (['draft' => 'Draft', 'published' => 'Published', 'scheduled' => 'Scheduled'] as $value => $label)
                            <option value="{{ $value }}" {{ old('status', $post?->status ?? 'draft') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1.5">Publish Date</label>
                    <input type="datetime-local" id="published_at" name="published_at"
                        value="{{ old('published_at', $post?->published_at?->format('Y-m-d\TH:i')) }}"
                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">
                </div>
            </div>

            <div class="mt-5 flex gap-3">
                <button type="submit"
                    class="flex-1 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-colors">
                    {{ $post ? 'Update Post' : 'Create Post' }}
                </button>
                <a href="{{ route('admin.posts.index') }}"
                   class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
            </div>
        </div>

        {{-- Categories --}}
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Categories</h3>
            <div class="space-y-2 max-h-48 overflow-y-auto">
                @forelse ($categories as $category)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                            {{ in_array($category->id, old('categories', $post?->categories->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600">
                        <span class="text-sm text-gray-700">{{ $category->name }}</span>
                    </label>
                @empty
                    <p class="text-xs text-gray-400">No categories yet. <a href="{{ route('admin.categories.create') }}" class="text-blue-600 hover:underline">Create one</a>.</p>
                @endforelse
            </div>
        </div>

        {{-- Tags --}}
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Tags</h3>
            <input type="text" id="tags" name="tags"
                value="{{ old('tags', $post?->tags->pluck('name')->join(', ')) }}"
                placeholder="Enter tags, separated by commas"
                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">
            <p class="mt-1.5 text-xs text-gray-400">Separate multiple tags with commas.</p>
        </div>
    </div>
</div>
