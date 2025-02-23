<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Album Sales Dashboard</title>
</head>
<body>
  <h2>Music Album Sales Dashboard</h2>
  <ul>
    <li><a href="total_albums.php">View Total Number of Albums Per Artist</a></li>
    <li><a href="combined_sales.php">View Combined Album Sales Per Artist</a></li>
    <li><a href="top_artist.php">View Top 1 Artist with Most Album Sales</a></li>
    <li><a href="top_albums.php">View Top 10 Albums by Sales</a></li>
    <li>
      <form action="search.php" method="GET">
        <input type="text" name="artist" placeholder="Search by Artist" required>
        <button type="submit">Search</button>
      </form>
    </li>
  </ul>
</body>
</html>
