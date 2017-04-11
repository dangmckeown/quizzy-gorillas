<?php

//Begin formatting function

function format_date($string){

$reg = "/^\d\d?\d?\d?\w/";

$result = preg_match($reg, $string);

$string_arr = str_split($string);

	#var_dump($string_arr);

$num = "/\d/";

$index = 0;

foreach ($string_arr as $sar){
	if (! preg_match($num,$sar)){
	break;
	}	
	else
	{
	$index++;
	}
}
	
array_splice($string_arr, $index, 0, " ");	

	$output = implode($string_arr);
	
	echo $output;
	
	return ltrim($output);
}

// End formatting function

$day = date('j');

$month = date('F');

echo "<h1>$day $month</h1>";

$wikis = file_get_contents('https://en.wikipedia.org/wiki/' . $month . '_' . $day);

$bbcs = file_get_contents('http://news.bbc.co.uk/onthisday/hi/dates/stories/' . strtolower($month) .'/' . $day .'/default.stm');

//== Trim bbc output

$bbc_trim=array();

$bbs = explode("<td>", $bbcs);

$regex = "/\/onthisday\/hi\/dates\/stories\/" . strtolower($month) ."\/" . $day . ".*\d\.stm/";

foreach ($bbs as $bb){

if (preg_match($regex,$bb)){
$bbc_trim[] = trim(str_replace(":","",strip_tags($bb)));
}

}

//== Get Beautiful Britain after site rejig

#$brits = file_get_contents('http://www.beautifulbritain.co.uk/htm/onthisday/current/'.$day.'.htm');

$brit_base = file_get_contents("http://www.beautifulbritain.co.uk/htm/onthisday/onthisday.htm");

$today_url = array();

$brits = file_get_contents('http://www.beautifulbritain.co.uk/htm/onthisday/current/'.$day.'.htm');

$preg_url = "/".$month."\/.*".$day."\.htm/";

preg_match($preg_url, $brit_base, $today_url);

if(! $today_url[0]){
echo "ERROR getting Beautiful Britain URL! <a href='http://www.beautifulbritain.co.uk/htm/onthisday/onthisday.htm'>Go to the site</a>";
}
else
{
$brits = file_get_contents('http://www.beautifulbritain.co.uk/htm/onthisday/' . $today_url[0]);
}

//=== Trim Wiki Output

$wiks = explode("<h2>Contents</h2>", $wikis);

$wis = explode("<span class=\"mw-headline\" id=\"Events\">Events</span>",$wiks[1]);

$ws = explode("<span class=\"mw-headline\" id=\"Births\">Births</span>",$wis[1]);

$wiki_trim = explode("<li>",str_replace(" – "," ", $ws[0]));

//== Trim Beautiful Britain Output

$brit_trim = explode("<p>",$brits);

//== Consolidate and order sources

$sources = ([$bbc_trim, $wiki_trim, $brit_trim]);

$consolids = array();

foreach ($sources as $source){
$i = 1;

while($i < count($source) - 1){
$consolids[] = format_date($source[$i]);
$i++;
}

}

$year = "/^\d{1,4}/";

$bc = "/^B\.?C\.?/i";

$events = array();

$bc_events = array();

foreach ($consolids as $consolid){
	
$split = explode(" ", strip_tags($consolid), 2); 

//get rid of leading whitespace
$split[0] = ltrim($split[0]);
	
	
$year = explode("&nbsp;", $split[0]);
while (count($year) > 1){
$extra = array_pop($year);
$split[1] = $extra . " " . $split[1];
}

$split[0] = $year[0];	
	
 if(preg_match($bc, $split[1])){
$bc_events[] = array('year' => $split[0], 'event' => $split[1]);
}
else
{
$events[] = array('year' => $split[0], 'event' => $split[1]);
}

   }

rsort($bc_events);

/*
echo "<p>BC events</p>";

var_dump($bc_events);
*/

sort($events);
/*
echo "<p>Events</p>";

var_dump($events);
*/
 echo "<ul>";

      
foreach ($bc_events as $event){
echo "<li><b>" . $event['year'] . "</b> " . $event['event']  . "</li>";
}

   
foreach ($events as $event){
echo "<li><b>" . $event['year'] . "</b> " . $event['event']  . "</li>";
}
echo "</ul>";

echo "<p><a href='quiz.php'>Take a general knowledge quiz</a></p>";


?>
