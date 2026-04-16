<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status');
        $query  = Post::with(['author', 'categories'])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $posts = $query->paginate(20)->withQueryString();

        return view('admin.posts.index', compact('posts', 'status'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', 'unique:posts,slug'],
            'excerpt'          => ['nullable', 'string'],
            'content'          => ['nullable', 'string'],
            'status'           => ['required', 'in:draft,published,scheduled'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'categories'       => ['nullable', 'array'],
            'categories.*'     => ['exists:categories,id'],
            'tags'             => ['nullable', 'string'],
            'published_at'     => ['nullable', 'date'],
        ]);

        $validated['slug']    = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['user_id'] = auth()->id();

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        if (! empty($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        if (! empty($validated['tags'])) {
            $tagIds = collect(explode(',', $validated['tags']))
                ->map(fn ($t) => trim($t))
                ->filter()
                ->map(fn ($name) => Tag::firstOrCreate(['name' => $name], ['slug' => Str::slug($name)])->id);
            $post->tags()->sync($tagIds);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully.');
    }

    public function show(Post $post): View
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', "unique:posts,slug,{$post->id}"],
            'excerpt'          => ['nullable', 'string'],
            'content'          => ['nullable', 'string'],
            'status'           => ['required', 'in:draft,published,scheduled'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'categories'       => ['nullable', 'array'],
            'categories.*'     => ['exists:categories,id'],
            'tags'             => ['nullable', 'string'],
            'published_at'     => ['nullable', 'date'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        if ($validated['status'] === 'published' && $post->published_at === null) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        $post->categories()->sync($validated['categories'] ?? []);

        if (isset($validated['tags'])) {
            $tagIds = collect(explode(',', $validated['tags']))
                ->map(fn ($t) => trim($t))
                ->filter()
                ->map(fn ($name) => Tag::firstOrCreate(['name' => $name], ['slug' => Str::slug($name)])->id);
            $post->tags()->sync($tagIds);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post moved to trash.');
    }
}
