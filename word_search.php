<?php

function findTargetIndices($words, $target) {
  $words = array_slice($words, 0, 1000);

  if (empty($words)) {
    echo "No words in the list.\n";
    return;
  }

  $targetLower = strtolower($target);
  $indices = [];

  foreach ($words as $index => $word) {
    if (strtolower($word) === $targetLower) {
      $indices[] = $index;
    }
  }

  if (empty($indices)) {
    echo "Target not found.\n";
    return;
  }

  if (count($indices) === 1) {
    echo "INDEX " . $indices[0];
  } elseif (count($indices) === 2) {
    echo "INDEX " . $indices[0] . " and INDEX " . $indices[1];
  } else {
    $lastIndex = array_pop($indices);
    echo "INDEX " . implode(", INDEX ", $indices) . " AND INDEX " . $lastIndex;
  }
}

$target = "TWO";
$words = ["I", "TWO", "FORTY", "THREE", "JEN", "TWO", "tWo", "Two"];


findTargetIndices($words, $target);

?>
