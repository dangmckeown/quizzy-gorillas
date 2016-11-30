<?

class Question{

public $question;
public $text;
public $correct;
public $wrong;
public $false;

public function answer($question,$answer){

if ($question == $this->question && $answer = $this->correct){
return true;
}
else
{
return false;
}	//end if

} //end function

}	//end class