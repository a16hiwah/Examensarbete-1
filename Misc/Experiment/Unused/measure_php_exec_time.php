<!-- This is the code used to measure the execution time in CodeIgniter and CakePHP -->

<?php
// Place at the top of index.php (first file to load)
$t_start = microtime(true);

// Place all the code below at the bottom of index.php (first file to load)
// except the PHP closing tag
$t_stop = microtime(true);

// Calculate execution time in milliseconds (round to 3 decimals)
$exec_time = round((($t_stop - $t_start) * 1000), 3);

// Path to csv file where the result should be saved (choose one)
$fileLocation = getenv('DOCUMENT_ROOT') . '/logs/codeigniter_measurements.csv';
// $fileLocation = getenv('DOCUMENT_ROOT') . '/logs/cakephp_measurements.csv';

// Save the result
$handle = fopen($fileLocation, 'a');
fputcsv($handle, [$exec_time]);
fclose($handle);
?>