<?php

function getWords($number_of_letters){
    $wordsFound = [];
    $file = fopen("words.txt","rb");
 
    while ($word = fgets($file)){
        if(strlen(trim($word))==$number_of_letters)
          $wordsFound[]=trim($word);
    }
    fclose($file);
    return $wordsFound;
}

function replaceAll($guessString, $guessWord, $thisLetter){
    foreach(array_keys($guessWord,$thisLetter) as $index){
        $guessString[$index] = $thisLetter;
    }
    return $guessString;
}

function availableLetters(&$pUsedLetters){

$allLetters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ \n";
echo("Letters available: " );
if($pUsedLetters == null){
    
    print($allLetters);
}else{
    for($i = 0; $i < count($pUsedLetters); $i++){
        $currentLetter = strtoupper($pUsedLetters[$i]);
        $allLetters = str_replace($currentLetter, '-', $allLetters);
    }
    echo $allLetters;
    
}
}

function strArrayToString($passedInArray){
    $jointWord = '';
    for($i = 0; $i < count($passedInArray); $i++){
        $jointWord += $passedInArray[$i];
    }
    return $jointWord;
}

const LIVES = 6;
$lives = LIVES;
$number_of_letters = readline("Enter the word length: ");
$words = getWords($number_of_letters);
 
printf ("There are %s words with %s letters\n", count($words), $number_of_letters);

$guessWord = str_split($words[rand(0, count($words)-1)]);
printf ("Guessing the word: %s\n", implode("",$guessWord));
$strWordToGuess =  implode("",$guessWord);
//$strWordToGuess= str_replace('-', '', $strWordToGuess);
 
$guessString = array_fill(0, $number_of_letters, "_");
$usedLetters = array();
while($lives > 0){
    
    availableLetters($usedLetters);
    $thisLetter = readline("Guess a letter: ");
    array_push($usedLetters, $thisLetter);
    
    if (in_array($thisLetter,$guessWord)){
        $guessString = replaceAll($guessString, $guessWord, $thisLetter);
    
        if (implode($guessString) == implode($guessWord)){
            printf("You guessed the word!\n");
            break;
        } 
    } else {
        $lives = $lives-1;
        printf("Letter not found.  Lives remaining %s \n", $lives);

        if($lives == 0){
            
            echo "you lost!\n";
            echo "the letter you failed to guess was: ".$strWordToGuess;
            print"\n";
        }
    }
    print("Your current correct guesses are: ".implode($guessString) . " \n");
}
 
if ($lives > 0) {
    $player = readline("Enter player name for high score table: ");
    $fout = fopen("hangmanScores.txt","ab");
    $score = $lives * $number_of_letters;
    $scoreText = "$player\t$score\n";
    print($scoreText);
    fwrite($fout, $scoreText);
    fclose($fout);
}


?>