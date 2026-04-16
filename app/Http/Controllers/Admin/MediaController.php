<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(Request $request): View
    {
        $type  = $request->get('type');
        $query = Media::with('user')->latest();

        if ($type === 'image') {
            $query->where('mime_type', 'like', 'image/%');
        }

        $media = $query->paginate(24)->withQueryString();

        return view('admin.media.index', compact('media', 'type'));
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:20480'],
        ]);

        $file    = $request->file('file');
        $path    = $file->store('media/' . now()->format('Y/m'), 'public');

        $media = Media::create([
            'user_id'   => auth()->id(),
            'name'      => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'disk'      => 'public',
            'path'      => $path,
            'size'      => $file->getSize(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'id'   => $media->id,
                'url'  => $media->url,
                'name' => $media->name,
            ]);
        }

        return redirect()->route('admin.media.index')
            ->with('success', 'File uploaded successfully.');
    }

    public function show(Media $medium): View
    {
        return view('admin.media.show', compact('medium'));
    }

    public function edit(Media $medium): View
    {
        return view('admin.media.edit', compact('medium'));
    }

    public function update(Request $request, Media $medium): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $medium->update($validated);

        return redirect()->route('admin.media.index')
            ->with('success', 'Media updated successfully.');
    }

    public function destroy(Media $medium): RedirectResponse
    {
        Storage::disk($medium->disk)->delete($medium->path);
        $medium->forceDelete();

        return redirect()->route('admin.media.index')
            ->with('success', 'File deleted permanently.');
    }
}
