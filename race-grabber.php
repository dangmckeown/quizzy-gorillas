<?php

//Racegrabber

$months = array(
1 => 'january',
2 => 'february',
3 => 'march',
4 => 'april',
5 => 'may',
6 => 'june',
7 => 'july',
8 => 'august',
9 => 'september',
10 => 'october',
11 => 'november',
12 => 'december'
);

$month = (int)date("m");

for ($i = $month; $i <=12; $i++){

$fh = file_get_contents('http://www.fellrunner.org.uk/races.php?m=' . $months[$i] .'&y=2018');

$array1 = explode('<table id="posts-table">', $fh);

$array2 = explode('</div>'$array1[1]);

echo "<table>";

echo $array2[0];

}
