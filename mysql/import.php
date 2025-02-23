<!-- WARNING: Running this script multiple times will insert duplicate records into the database. -->

<?php
  include 'db_config.php';

  $csvFile = "../Data_Reference_(ALBUM_SALES).csv"; // Set the correct file name

  if (!file_exists($csvFile)) {
      die("Error: CSV file not found! Make sure '$csvFile' is in the correct folder.");
  }

  if (($handle = fopen($csvFile, "r")) !== FALSE) {
    fgetcsv($handle); // Skip header row
    $rowCount = 0;
    $errorCount = 0;

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Reads up to 1000 characters per row
      $artist = $conn->real_escape_string($data[0]); //Sanitize input
      $album = $conn->real_escape_string($data[1]);
      $sales = (float) $data[2];

      // Convert 'ymd' format (e.g., 220117) to 'Y-m-d' (e.g., 2022-01-17)
      $release_date = DateTime::createFromFormat('ymd', $data[3]);
      $last_update = DateTime::createFromFormat('ymd', $data[4]);

      if (!$release_date || !$last_update) {
        echo "Skipping row: Invalid date format in '$album' by '$artist'.<br>";
        $errorCount++;
        continue;
      }

      // Format the dates to 'YYYY-MM-DD'
      $release_date = $release_date->format('Y-m-d');
      $last_update = $last_update->format('Y-m-d');

      $sql = "INSERT INTO albums (artist, album, sales, release_date, last_update) 
        VALUES ('$artist', '$album', $sales, '$release_date', '$last_update')";

      if ($conn->query($sql) === TRUE) {
        $rowCount++;
      } else {
        echo "Error inserting '$album' by '$artist': " . $conn->error . "<br>";
        $errorCount++;
      }
    }
    fclose($handle);

    echo "<br><strong>Import Summary:</strong><br>";
    echo "Successfully Imported: $rowCount rows<br>";
    echo "Failed Imports: $errorCount rows<br>";

  } else {
    die("Error: Failed to open the CSV file.");
  }

  $conn->close();
?>
