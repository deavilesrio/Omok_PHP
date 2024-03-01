<?php
require 'PlayerMove.php';
class Board{
	public $board;
	public $strategy;
	function __construct($strategy){

		/// the board is represented by a 15x15 2d array
		$this->board = array(
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)
		);
		$this->strategy = $strategy;
	}
	
	static function restore($pid){
		// read the file with the game
		// this is where we would check if pid is valid
		// with invalid pid, return false and handle in play/index.php
		$filename = "../new/$pid.txt";
		$handle = fopen($filename, 'rb') or die('Cannot open file:  '.$filename);
		$content = fread($handle, filesize($filename));
		fclose($handle);
		$previous = json_decode($content);

		// construct is kinda nasty cuz we make a new board but overwrite it later
		// we can probably fix this later
		$instance = new self($previous->strategy);
		// convert board from stdClass to array of arrays
		$instance->board = json_decode(json_encode($previous->board), TRUE);
		// return the restored game
		return $instance;
	}
	
	function doMove($player1, $move){
		// TODO check if valid move
		if($this->board[$move[0]][$move[1]] == 0){
		$this->board[$move[0]][$move[1]] = ($player1)? 1 : 2;
		// the value tells us if it was a win, draw, or neither
		$result = $this->checkWin($move);
		if($result == 0){
			// move didn't result in either win or draw
			return new PlayerMove($move[0], $move[1], FALSE, FALSE, array());
		} else if($result == 2){
			// move resulted in a draw
			return new PlayerMove($move[0], $move[1], FALSE, TRUE, array());
		} else {
			// move resulted in a win
			return new PlayerMove($move[0], $move[1], TRUE, FALSE, $result);
		}				
		}
		return null;
	}
	
	
	function checkWin($lastMove){
		$row = array();
		$myMove = $this->board[$lastMove[0]][$lastMove[1]];
		$horizontalStartIndex = ($lastMove[0]<4)? 0 : $lastMove[0]-4;
		$horizontalEndIndex = ($lastMove[0]>10)? 14 : $lastMove[0]+4;
		$verticalStartIndex = ($lastMove[1]<4)? 0 : $lastMove[1]-4;
		$verticalEndIndex = ($lastMove[1]>10)? 14 : $lastMove[1]+4;
		$horizontalCount = 0;
		$verticalCount= 0;
		$count1 = 0;
		$count2 = 0;
		$count3 = 0;
		$count4 = 0;
		
		// check if there is a win in horizontal of the last move in the board
		for($i = $horizontalStartIndex; $i <= $horizontalEndIndex; $i++){
			if($this->board[$i][$lastMove[1]] == $myMove){
				$horizontalCount++;
				$row[] =$i;
				$row[] = $lastMove[1];
				if($horizontalCount == 5){
					return $row;
				}
			}
			else {
				$horizontalCount = 0;
			}
		}
		
		$row = array();
		
		// checks if there is a win in the vertical of the last move on the board
		for($i = $verticalStartIndex; $i <= $verticalEndIndex; $i++){
			if($this->board[$lastMove[0]][$i] == $myMove){
				$verticalCount++;
				$row[] =$lastMove[0];
				$row[] = $i;
				if($verticalCount == 5){
					return $row;
				}
			} else {
				$verticalCount = 0;
			}
		}
		
		$row = array();
		
		//TODO checks if there is a win for the both diagonals for the last move
		for($x = 4; $x < 15; $x++){
			for($i = 0; $i <= $x; $i++){
				
				if($this->board[$x-$i][$i] == $myMove){
					
					$count1++;
					$row1[] = $x-$i;
					$row1[] = $i;
					if($count1 == 5){
						return $row1;
					}
				} else {
					$count1 = 0;
				}
				if($this->board[14-$x+$i][14-$i] == $myMove){
					
					$count2++;
					$row2[] = 14-$x+$i;
					$row2[] = 14-$i;
					if($count2 == 5){
						return $row2;
					}
				} else {
					$count2 = 0;
				}
				
				if($this->board[14-$x+$i][$i] == $myMove){
					
					$count3++;
					$row3[] = 14-$x+$i;
					$row3[] = $i;
					if($count3 == 5){
						return $row3;
					}
				} else {
					$count3 = 0;
				}
				if($this->board[$i][14-$x+$i] == $myMove){
					
					$count4++;
					$row4[] = $i;
					$row4[] = 14-$x+$i;
					if($count4 == 5){
						return $row4;
					}
				} else {
					$count4 = 0;
				}
			}
			
			
		}
		//checks the draw of the game, if it comes to an open space, the for loops stops
		for($i = 0; $i < 15; $i++){
			for($j = 0; $j < 15; $j++){
				if($this -> board[$i][$j] === 0){
					return 0;
				}
			}
		}
		
		return 2;
	}
	
}
?>
