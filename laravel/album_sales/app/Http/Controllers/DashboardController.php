<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Album;

class DashboardController extends Controller
{
    public function totalAlbumsPerArtist() {
      $data = Artist::withCount('albums')->get();
      return response()->json($data);
    }

    public function combinedSalesPerArtist() {
      $data = Artist::withSum('albums', 'sales')->get();
      return response()->json($data);
    }

    public function topSellingArtist() {
      $artist = Artist::withSum('albums', 'sales')
        ->orderByDesc('albums_sum_sales')
        ->first();

      return response()->json($artist);
    }

    public function searchAlbums(Request $request) {
      $request->validate([
        'artist' => 'required|string'
      ]);
  
      $artistName = $request->query('artist');
  
      $albums = Album::whereHas('artist', function ($query) use ($artistName) {
          $query->where('name', 'like', "%$artistName%");
        })
        ->get();

      return response()->json($albums);
    }
  
}
