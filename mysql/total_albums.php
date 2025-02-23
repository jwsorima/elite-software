<?php
  include 'db_config.php';

  echo "<h2>Total Number of Albums Sold Per Artist</h2>";

  $sql = "SELECT artist, COUNT(album) AS total_albums 
          FROM albums 
          GROUP BY artist";

  $result = $conn->query($sql);

  echo "<table border='1'>
          <tr>
            <th>Artist</th>
            <th>Total Albums</th>
          </tr>";

  while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['artist']}</td>
            <td>{$row['total_albums']}</td>
          </tr>";
  }

  echo "</table>";

  $conn->close();
?>
