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

foreach($brit_trim as $brit){
if(preg_match("/<br\s\/>/",$brit)){
 $temp = explode("<br />",$brit);
unset($brit);
foreach($temp as $tmp){
$brit_trim[] = $tmp;
}//end foreach temp
unset($temp);
}//end if preg_match
} //end foreach brit_trim
		
	
//== Consolidate and order sources
$sources = ([$bbc_trim, $wiki_trim, $brit_trim]);
		
$consolids = array();
foreach ($sources as $source){
$i = 1;
while($i < count($source) - 1){
$consolids[] = strip_tags($source[$i]);
$i++;
} //end while i
} //end foreach
		
		print_r($consolids);

$bcevents=array();
$adevents = array();		
$bcpreg = "/^(.{1,2})?b\.?c/i";
foreach($consolids as $consolid){
$text = str_split($consolid);
//div up into year and event	
$year = "";

$i = 0;
while(preg_match("/\d/",$text[0]) && $i < 4){
	$leaddig = array_shift($text);
	$year .= $leaddig;
	$i++;
}
$event = implode($text);
	
if(preg_match($bcpreg,$event)){
	$bcevents[] = ([$year, preg_replace($bcevent,"",$event)]);
}
else
{
	$adevents[] = ([$year, $event]);
}
}

rsort($bcevents);
sort($adevents);
echo "<ul>";
foreach($bcevents as $bc){
 echo "<li>{$bc[0]} BC: {$bc[1]}</li>";
}

foreach($adevents as $ad){
 echo "<li>{$ad[0]}: {$ad[1]}</li>";
}		

echo "</ul>";
		?>
<p><a href="quiz.php">Take a general knowledge quiz</a></p>
		
	</body>
</html>
