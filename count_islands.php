<?php

function displayIslandMap($grid) {
    echo "Island Map:\n";
    foreach ($grid as $row) {
        echo str_replace([1, 0], ['X', '~'], implode("", $row)) . "\n";
    }
}

$matrix = [
  [1, 1, 1, 1],
  [0, 1, 1, 0],
  [0, 1, 0, 1],
  [1, 1, 0, 0]
];

displayIslandMap($matrix);

?>
