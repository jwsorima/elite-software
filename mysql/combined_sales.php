<?php
  include 'db_config.php';

  echo "<h2>Combined Album Sales Per Artist</h2>";

  $sql = "SELECT artist, SUM(sales) AS total_sales 
          FROM albums 
          GROUP BY artist 
          ORDER BY total_sales DESC";

  $result = $conn->query($sql);

  echo "<table border='1'>
          <tr>
            <th>Artist</th>
            <th>Total Sales</th>
          </tr>";

  while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['artist']}</td>
            <td>{$row['total_sales']}</td>
          </tr>";
  }

  echo "</table>";

  $conn->close();
?>
