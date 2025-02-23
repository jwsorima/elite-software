<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;

class ArtistController extends Controller {
  // Get all artists (Public)
  public function index() {
    return response()->json(Artist::all());
  }

  // Get a single artist (Public)
  public function show($id) {
    return response()->json(Artist::findOrFail($id));
  }

  // Create a new artist (Admin only)
  public function store(Request $request) {
    $request->validate([
      'code' => 'required|unique:artists,code|max:255',
      'name' => 'required|string|max:255',
    ]);

    $artist = Artist::create($request->all());
    return response()->json($artist, 201);
  }

  // Update an artist's details (Admin only)
  public function update(Request $request, $id) {
    $artist = Artist::findOrFail($id);

    $request->validate([
      'code' => 'unique:artists,code,' . $id . '|max:255',
      'name' => 'string|max:255',
    ]);

    $artist->update($request->all());
    return response()->json($artist);
  }

  // Delete an artist (Admin only)
  public function destroy($id) {
    $artist = Artist::findOrFail($id);
    $artist->delete();
    return response()->json(['message' => 'Artist deleted successfully'], 204);
  }
}
