<?php

include 'BinarySearch.php';

$binarySearch = new BinarySearch('TestData.txt');
$start = microtime(true);
// $binarySearch->createTestData(10000);
print_r($binarySearch->search('KeyElem2'));
echo "<br>";
echo microtime(true)-$start;

