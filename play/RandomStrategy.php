<?php
require "MoveStrategy.php";
class RandomStrategy extends MoveStrategy{
    
    static function pickPlace($board){ //once this function is called it return a random location in the board by the bot
        
        $position = False;
        while(!$position){ //loop infinite until and free spot is found
            $move[0] = rand(0, 14); //return a random number between 0 to 14 in x position
			$move[1] = rand(0, 14); //return a random number between 0 to 14 in y position
    
            if ($board->board[$move[0]][$move[1]]== 0){ // if the postion at [x][y] is 0 means the spot is free 
               $position = True; // stops loop
               
               return $move; // move is return to who called the function
            }
            
        }
    }
    
}