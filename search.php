<?php

include 'BinarySearch.php';

$binarySearch = new BinarySearch();
$start = microtime(true);
// $binarySearch->createTestData("TestData.txt",10000);
print_r($binarySearch->search('TestData.txt','KeyElem2'));
echo "<br>";
echo microtime(true)-$start;

