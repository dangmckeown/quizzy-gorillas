<?

//connects to questions.csv and returns contents as array $questions

include_once('classes.php');

$fh = fopen('questions.csv','rb');

$questions=array();
$i = 0;

while ((! feof($fh)) && ($line = fgetcsv($fh))) {
$questions[$i] = ([$line[0],$line[1],$line[2],$line[3]]);
# var_dump($info);
$i++;
}

//get rid of header row from CSV - no use in array 
unset($questions[0]);


