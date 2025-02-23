<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Album;
use App\Models\Artist;

class AlbumController extends Controller {
  public function index() {
    $albums = Album::with('artist')->get();

    // Ensure `cover_image` returns a properly formatted URL
    $albums->each(function ($album) {
        if (!empty($album->cover_image)) {
            $album->cover_image = asset(Storage::url($album->cover_image));
        }
    });

    return response()->json($albums, 200, [], JSON_UNESCAPED_SLASHES);
}

public function show($id) {
    $album = Album::with('artist')->findOrFail($id);

    // Ensure `cover_image` returns a properly formatted URL
    if (!empty($album->cover_image)) {
        $album->cover_image = asset(Storage::url($album->cover_image));
    }

    return response()->json($album, 200, [], JSON_UNESCAPED_SLASHES);
}

  // Create a new album (Admin only)
  public function store(Request $request) {
    $request->validate([
      'artist_id' => 'required|exists:artists,id',
      'year' => 'required|integer',
      'name' => 'required|string|max:255',
      'sales' => 'required|numeric',
      'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $data = $request->all();

    // Handle Cover Image Upload
    if ($request->hasFile('cover_image')) {
      $filePath = $request->file('cover_image')->store('albums', 'public');
      $data['cover_image'] = $filePath;
    }

    $album = Album::create($data);
    return response()->json($album, 201);
  }

  // Update an album (Admin only)
  public function update(Request $request, $id) {
    $album = Album::findOrFail($id);

    $request->validate([
      'artist_id'   => 'exists:artists,id',
      'year'        => 'integer',
      'name'        => 'string|max:255',
      'sales'       => 'numeric',
      'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Exclude cover_image from the update data by default.
    // This prevents the current URL (from the initial GET) from overwriting the field.
    $data = $request->except('cover_image');

    // Only update the cover image if a new file has been uploaded.
    if ($request->hasFile('cover_image')) {
        // Delete the old cover image if it exists.
        if ($album->cover_image) {
            Storage::disk('public')->delete($album->cover_image);
        }

        // Store the new cover image.
        $filePath = $request->file('cover_image')->store('albums', 'public');
        $data['cover_image'] = $filePath;
    }

    $album->update($data);
    return response()->json($album);
  }

  // Delete an album (Admin only)
  public function destroy($id) {
    $album = Album::findOrFail($id);

    // Delete album cover image if exists
    if ($album->cover_image) {
      Storage::disk('public')->delete($album->cover_image);
    }

    $album->delete();
    return response()->json(['message' => 'Album deleted successfully'], 204);
  }

  // Upload a cover image separately (Admin only)
  public function uploadCover(Request $request, $id) {
    $request->validate([
      'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $album = Album::findOrFail($id);

    // Delete old image if exists
    if ($album->cover_image) {
      Storage::disk('public')->delete($album->cover_image);
    }

    // Store New Cover Image
    $filePath = $request->file('cover_image')->store('albums', 'public');
    $album->update(['cover_image' => $filePath]);

    return response()->json([
      'message' => 'Cover image uploaded successfully',
      'cover_image_url' => Storage::url($filePath)
    ]);
  }
}
