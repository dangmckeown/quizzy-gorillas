
<!doctype html>
<html>

	<head>
		<title>Quizzy Gorillas - Quiz Answers</title>
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

<div style="font-size: 14pt; font-family: 'Arial Narrow'">

  <p style="font-weight: bold;">Quiz, you scurvy apes</p>
  
<?php

include_once('functions.php');

short_quiz(5);

?>
<p>Find out <a href="index.php">what happened on this day in history</a>.</p>
</div>
</html>

<div style="font-size: 14pt; font-family: 'Arial Narrow'">

  <p style="font-weight: bold;">Answers</p>

<?php

include_once('questions.php');

$total_score = 0;
$possible_score = $_POST['possible_score'];

foreach ($_POST as $q => $ans){

// prevent total possible score being misidentified as a question answer

if ($questions[$q][0]){

echo "<p>" . $questions[$q][0] . "<br/>";
if ($questions[$q][1] == $ans){
echo "<span style='color: green;'>&star; $ans is correct!</span>";
$total_score++;
}
else
{
echo "<span style='color: red;'><b>&times;</b> The correct answer is " . $questions[$q][1] . ".</span> (Your answer: $ans.)";
}

} //end total score catcher

echo "</p>";
}


echo "<p><b>You scored $total_score out of $possible_score</b></p>";

echo "<p><a href=\"quiz.php\">Give me another go</a></p>";

?>

<p>Find out <a href="index.php">what happened on this day in history</a>.</p>

</div>
</html>
