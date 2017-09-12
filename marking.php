<div style="font-size: 14pt; font-family: 'Arial Narrow'">

  <p style="font-weight: bold;">Answers</p>

<?

include_once('questions.php');

$total_score = 0;
$possible_score = $_POST['possible_score'];

#var_dump($_POST);

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
