<div style="font-size: 16pt;">

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
echo "<span style='color: green;'>$ans is correct!</span>";
$total_score++;
}
else
{
echo "<span style='color: red;'>The correct answer is " . $questions[$q][1] . ".</span> (Your answer: $ans.)";
}

} //end total score catcher

# $possible_score = count($_POST) - 1;
echo "</p>";
}


echo "<p>You scored $total_score out of $possible_score</p>";

echo "<p><a href=\"index.php\">Give me another go</a></p>";

?>

<p>Find out <a href="index.php">what happened on this day in history</a>.</p>

</div>