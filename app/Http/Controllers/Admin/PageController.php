<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status');
        $query  = Page::with('author')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $pages = $query->paginate(20)->withQueryString();

        return view('admin.pages.index', compact('pages', 'status'));
    }

    public function create(): View
    {
        $parentPages = Page::whereNull('parent_id')->orderBy('title')->get();

        return view('admin.pages.create', compact('parentPages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', 'unique:pages,slug'],
            'content'          => ['nullable', 'string'],
            'status'           => ['required', 'in:draft,published'],
            'template'         => ['nullable', 'string', 'max:100'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'parent_id'        => ['nullable', 'exists:pages,id'],
        ]);

        $validated['slug']    = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['user_id'] = auth()->id();

        Page::create($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    public function show(Page $page): View
    {
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page): View
    {
        $parentPages = Page::whereNull('parent_id')
            ->where('id', '!=', $page->id)
            ->orderBy('title')
            ->get();

        return view('admin.pages.edit', compact('page', 'parentPages'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', "unique:pages,slug,{$page->id}"],
            'content'          => ['nullable', 'string'],
            'status'           => ['required', 'in:draft,published'],
            'template'         => ['nullable', 'string', 'max:100'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'parent_id'        => ['nullable', 'exists:pages,id'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page moved to trash.');
    }
}
