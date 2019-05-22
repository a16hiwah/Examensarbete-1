<!-- This is the code used to measure the execution time in CodeIgniter and CakePHP -->

<?php
// Place at the top of index.php (first file to load)
$t_start = microtime(true);

// Place all the code below at the bottom of index.php (first file to load)
// except the PHP closing tag
$t_stop = microtime(true);

// Calculate execution time in milliseconds (round to 3 decimals)
$exec_time = round((($t_stop - $t_start) * 1000), 3);

// Display the result on the rendered web page to make it possible to get it
// with JavaScript
echo '<div id="exec-time">'.$exec_time.'</div>';

?>