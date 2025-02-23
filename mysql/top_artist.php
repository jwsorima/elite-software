<?php
  include 'db_config.php';

  echo "<h2>Top 1 Artist with Most Combined Album Sales</h2>";

  $sql = "SELECT artist, SUM(sales) AS total_sales 
          FROM albums 
          GROUP BY artist 
          ORDER BY total_sales DESC 
          LIMIT 1";

  $result = $conn->query($sql);

  if ($row = $result->fetch_assoc()) {
    echo "<p><strong>Top Artist:</strong> {$row['artist']}</p>";
    echo "<p><strong>Total Sales:</strong> {$row['total_sales']}</p>";
  } else {
    echo "No data available.";
  }

  $conn->close();
?>
