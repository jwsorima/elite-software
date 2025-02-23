<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Album extends Model {
  use HasFactory;

  protected $fillable = ['artist_id', 'year', 'name', 'sales', 'cover_image'];

  // Accessor: Get Full URL of Image
  public function getCoverImageUrlAttribute() {
    return $this->cover_image ? Storage::url($this->cover_image) : null;
  }

  // Relationship: An album belongs to an artist
  public function artist() {
    return $this->belongsTo(Artist::class);
  }
}
