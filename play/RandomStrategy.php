<?php
require "MoveStrategy.php";
class RandomStrategy extends MoveStrategy{
    
    static function pickPlace($board){
        
        $position = False;
        while(!$position){
            $move[0] = rand(0, 14);
			$move[1] = rand(0, 14);
    
            if ($board->board[$move[0]][$move[1]]== 0){
               $position = True;
               //insert Token in the board
               return $move;
            }
            
        }
    }
    
}