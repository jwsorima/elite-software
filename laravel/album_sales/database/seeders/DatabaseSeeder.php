<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use App\Models\Artist;
use App\Models\Album;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {
  public function run(): void {
    $csvFile = database_path('seeders/albums.csv'); // Ensure the correct file path

    if (!file_exists($csvFile)) {
      die("Error: CSV file not found at $csvFile");
    }

    $csv = Reader::createFromPath($csvFile, 'r');
    $csv->setHeaderOffset(0);
    $faker = Faker::create(); // Initialize Faker

    // DELETE ALL EXISTING DATA BEFORE SEEDING
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    Album::truncate();
    Artist::truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $artists = [];

    foreach ($csv as $record) {
      // Insert Artist if not exists
      $artistName = $record['Artist'];
      if (!isset($artists[$artistName])) {
        $artist = Artist::create([
          'code' => strtoupper(substr($artistName, 0, 3)) . rand(100, 999), // Generate unique code
          'name' => $artistName,
        ]);
        $artists[$artistName] = $artist->id;
      }

      Album::create([
        'artist_id' => $artists[$artistName],
        'year' => substr($record['Date Released'], 0, 4),
        'name' => $record['Album'],
        'sales' => $record['2022 Sales'] ?? $faker->numberBetween(5000, 500000), // Random number if missing, column is not null
        'cover_image' => $faker->imageUrl(300, 300, 'music', true, $record['Album']), // Generate album cover URL
      ]);
    }

    echo "Database Cleared & CSV Import Completed!";
  }
}
