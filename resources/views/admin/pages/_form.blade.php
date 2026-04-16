<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2 space-y-6">
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">Title <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" required
                    value="{{ old('title', $page?->title) }}"
                    class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm @error('title') ring-red-500 @enderror">
                @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="mt-4">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1.5">Slug</label>
                <div class="flex rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-blue-600">
                    <span class="flex select-none items-center pl-3 text-gray-400 sm:text-sm">/</span>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $page?->slug) }}"
                        class="block flex-1 border-0 bg-transparent py-2.5 pl-1 pr-3 text-gray-900 focus:ring-0 sm:text-sm">
                </div>
            </div>
        </div>

        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
            <label for="content" class="block text-sm font-medium text-gray-700 mb-1.5">Content</label>
            <textarea id="content" name="content" rows="18"
                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm font-mono">{{ old('content', $page?->content) }}</textarea>
        </div>

        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">SEO</h3>
            <div class="space-y-4">
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1.5">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $page?->meta_title) }}"
                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">
                </div>
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1.5">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3"
                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">{{ old('meta_description', $page?->meta_description) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Publish</h3>
            <div class="space-y-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                    <select id="status" name="status"
                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">
                        <option value="draft" {{ old('status', $page?->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $page?->status) === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                <div>
                    <label for="template" class="block text-sm font-medium text-gray-700 mb-1.5">Template</label>
                    <select id="template" name="template"
                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">
                        <option value="default" {{ old('template', $page?->template ?? 'default') === 'default' ? 'selected' : '' }}>Default</option>
                        <option value="full-width" {{ old('template', $page?->template) === 'full-width' ? 'selected' : '' }}>Full Width</option>
                        <option value="landing" {{ old('template', $page?->template) === 'landing' ? 'selected' : '' }}>Landing Page</option>
                    </select>
                </div>
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1.5">Parent Page</label>
                    <select id="parent_id" name="parent_id"
                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm">
                        <option value="">— None —</option>
                        @foreach ($parentPages as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $page?->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-5 flex gap-3">
                <button type="submit"
                    class="flex-1 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-colors">
                    {{ $page ? 'Update Page' : 'Create Page' }}
                </button>
                <a href="{{ route('admin.pages.index') }}"
                   class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</div>
