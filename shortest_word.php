<?php
	$inputOne = "TRUE FRIENDS ARE ME AND YOU";
	$inputTwo = "I AM THE LEGENDARY VILLAIN";

  function findShortestWordLength($input) {
    $words = explode(' ', $input);

    $lengths = [];

    foreach ($words as $word) {
      $lengths[] = strlen($word);
    }

    $shortest = min($lengths);
    
    $shortestWordKey = array_search($shortest, $lengths);

    echo "$shortest - BECAUSE THE SHORTEST WORD IS \"$words[$shortestWordKey]\"";
	}
	
	echo findShortestWordLength($inputOne);
	echo "\n";
	echo findShortestWordLength($inputTwo);
?>