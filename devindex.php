<!doctype html>
<html>

	<head>
		<title>Quizzy Gorillas - for when you absolutely *positively* need to know what happened on this day in history</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<style>
			body {font-family: 'Arial Narrow';} 
			li {font-size: 14pt;}
			li { padding-bottom: 3px; }
			h1 {font-size: 18pt; font-weight: bold;}
			h2 {font-size: 16pt; font-weight: normal;}
		</style>
	</head>
	<body>
		
		<center>
			<h1>Quizzy Gorillas</h1>
			<h2>When you absolutely *positively* need to know what happened on this day in history</h2>
			<img style="width: 300px;" alt="thoughtful-looking gorilla" src="https://upload.wikimedia.org/wikipedia/commons/6/63/Gorilla_port_lympne1.jpg" />
		</center>
		
	
<?php
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
} //end if preg_match
} //end foreach bbs
//== Get Beautiful Britain after site rejig
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
foreach ($wiki_trim as $trim){
	$trim = strip_tags($trim);
}
//== Trim Beautiful Britain Output
$brit_trim = explode("<p>",$brits);
		
	
//== Consolidate and order sources
$sources = ([$bbc_trim, $wiki_trim, $brit_trim]);
foreach ($sources as $source){
print_r($source);
	echo "<p />";
}		
		
$consolids = array();
foreach ($sources as $source){
$i = 1;
while($i < count($source) - 1){
$consolids[] = $source[$i];
$i++;
} //end while i
} //end foreach
$bc = "/^\W*B\.?C\.?/i";
$events = array();
$bc_events = array();
foreach ($consolids as $consolid){
$split=array();
	
$textarr = str_split(strip_tags($consolid));
	
$has_tags = "/^</";
if(! preg_match($has_tags, $textarr)){
	while(preg_match("/\d/",$textarr[0])){
	$leaddig = array_shift($textarr);
	$split[0] .= $leaddig;
	} //end while
	$split[1] = strip_tags(implode($textarr));
}//end if !preg_match
else{
//reassemble string, strip tags and dismantle again
$textarr = str_split(strip_tags($consolid));
	print_r($textarr);
	
	while(preg_match("/\d/",$textarr[0])){
	$leaddig = array_shift($textarr);
	$split[0] .= $leaddig;
	} //end while
		
}//end else $!has_tags
	
if(preg_match($bc, $split[1])){
$bc_events[] = array('year' => $split[0], 'event' => preg_replace($bc,"",trim($split[1])));
} //end if BC
    
else
{
$events[] = array('year' => $split[0], 'event' => $split[1]);
} //end if else BC
} //end foreach consolids
rsort($bc_events);
sort($events);
		
echo "<ul>";
      
foreach ($bc_events as $event){
echo "<li>" . $event['year'] . " BC: " . $event['event']  . "</li>";
} //end foreach bc_events
   
foreach ($events as $event){
echo "<li>" . $event['year'] . ": " . $event['event']  . "</li>";
} //end foreach events
echo "</ul>";
echo "<p><a href='quiz.php'>Take a general knowledge quiz</a></p>";
?>
	</body></html>
