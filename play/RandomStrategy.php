<?php
include "MoveStrategy.php";

class RandomStrategy extends MoveStrategy{
    function printBoard($board){
        for($i= 0;$i<sizeof($board->board);$i++){
            for($j= 0;$j<sizeof($board->board[$i]); $j++){
                print($board->board[$i][$j].""); //prints each line
            }
            echo PHP_EOL; // newline
        }
    }
    function insert_Token($x, $y, $board){
        //Inserting token
        $board->board[$x][$y] = 1;
    }
    function pickPlace($board){
        $position = False;
        while(!$position){
            $x = mt_rand(0,14);
            $y = mt_rand(0,14);
    
            if ($board->board[$x][$y]== 0){
               $position = True;
               //insert Token in the board
               $this->insert_Token($x, $y, $board);
               return true;
            }
            
        }
        return false;
    }
    
}

$random = new RandomStrategy();
$empty = $random->pickPlace($board);
if($empty){
    $random ->printBoard($board);
}
