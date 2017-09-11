<?

function print_quiz($quiz){

//renders selected questions onto web form
	
shuffle($quiz);

$poss = 0;

echo "<form method='post' action='marking.php'>";
foreach ($quiz as $q){
$poss++;
var_dump($q);
echo "<p>";
$qid=$q->question;

//set default answer 'no response' this will be overwritten if user selects a radio button
echo "<input type='hidden' name='$qid' value='no response' />";

echo $q->text;
$answers = array($q->correct,$q->wrong,$q->false);
shuffle($answers);
foreach ($answers as $an){
	echo "<br/>$an <input type='radio' name='$qid' value='$an' />";
}
echo "</p>";
}
echo "<input type='hidden' name='possible_score' value='$poss' />";
echo "<input type='submit' value='Go!' />";
echo "</form>";
}

//================================

function new_quiz(){

// uses all questions available

include_once('questions.php');

$quiz = array();

for ($i = 0; $i < count($questions); $i++){
$j = $i + 1;
$quiz[$i] = new Question;
$quiz[$i]->question = $j;
$quiz[$i]->text = $questions[$j][0];
$quiz[$i]->correct = $questions[$j][1];
$quiz[$i]->wrong = $questions[$j][2];
$quiz[$i]->false = $questions[$j][3];
}

print_quiz($quiz);
}

//==============================

function short_quiz($n){

//selects $n questions from available list

$quiz = array();

include_once('questions.php');

if ($n > count($questions)){

echo "Error: too many questions requested. Ask for fewer in short_quiz() in index.php or add more to questions.csv <br/>email daniel.mckeown@gmail.com for support";

}

else

{

//See if this introduces more randomness into the questions...	
	
#	var_dump($questions);
# shuffle($questions);
// ^this is what's messing it up	
#	var_dump($questions);
	
$keys = array_rand($questions,$n);
	
	var_dump($keys);

	
#	var_dump($questions);
	
$i = 0;

foreach ($keys as $k){
$quiz[$i] = new Question;
$quiz[$i]->question = $k;
$quiz[$i]->text = $questions[$k][0];
$quiz[$i]->correct = $questions[$k][1];
$quiz[$i]->wrong = $questions[$k][2];
$quiz[$i]->false = $questions[$k][3];
$i++;
}

print_quiz($quiz);

}

}
