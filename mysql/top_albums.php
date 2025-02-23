<?php
  include 'db_config.php';

  echo "<h2>Top 10 Albums Based on Sales</h2>";

  $sql = "SELECT release_date, album, artist, sales 
          FROM albums 
          ORDER BY sales DESC 
          LIMIT 10";

  $result = $conn->query($sql);

  echo "<table border='1'>
          <tr>
            <th>Year</th>
            <th>Album</th>
            <th>Artist</th>
            <th>Sales</th>
          </tr>";

  while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . date('Y', strtotime($row['release_date'])) . "</td>
            <td>{$row['album']}</td>
            <td>{$row['artist']}</td>
            <td>{$row['sales']}</td>
          </tr>";
  }

  echo "</table>";

  $conn->close();
?>
