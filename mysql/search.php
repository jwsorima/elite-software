<?php
  include 'db_config.php';

  $artist = $_GET['artist'] ?? '';
  $artist = $conn->real_escape_string($artist); //Sanitize input

  if ($artist) {
    echo "<h2>Albums by '$artist'</h2>";

    $sql = "SELECT album, release_date, sales 
            FROM albums 
            WHERE artist LIKE '%$artist%' 
            ORDER BY release_date DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<table border='1'>
              <tr>
                <th>Album</th>
                <th>Year</th>
                <th>Sales</th>
              </tr>";

      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['album']}</td>
                <td>" . date('Y', strtotime($row['release_date'])) . "</td>
                <td>{$row['sales']}</td>
              </tr>";
      }

      echo "</table>";
    } else {
      echo "No albums found for '$artist'.";
    }
  }

  $conn->close();
?>
