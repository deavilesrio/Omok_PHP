<?php

//Diego Aviles and Angel Urbina
require 'Common.php';
require 'Game.php';
require 'RandomStrategy.php';
require 'Strategy.php';
$uri = explode('?', $_SERVER['REQUEST_URI']); // gets an array of substrings split it by ?
$x = $_GET["x"]; //gets from the url the value of x
$y = $_GET["y"]; //gets from the url the value of y


	// get the pid from the query aka $uri[1]
	$pid = getParam("pid", $uri[1]); 
	$filename = "../new/$pid.txt"; // gets the file name depending on the pids given
	// check if strategy was found
	if($pid){ // if  a pid was given continue
			
		if (file_exists($filename)) { // if the piden given, exists which means a new match was created continue
			if($x!=Null){ //if x was given continue
				if($y!=Null){ //if y was given continue
					if($x>14 | $x< 0){ // if the positon x is valid
						echo json_encode(array('response' => false,'reason' => "Invalid x coordinate"));
					}
					elseif($y>14 | $y<0){// if the positon y is valid
						echo json_encode(array('response' => false,'reason' => "Invalid y coordinate"));
					}
					else{ //if all values were correctly given make a move, send the pid value an array of x and y
						// echo('succesfully make a movement');
						makeMove($pid, array((int)$x, (int)$y));
					}
				}elseif(!$y){ //else if y wasn't given
					echo json_encode(array('response' => false,'reason' => "y not specified"));
				}
			}else{ // if x was given
				echo json_encode(array('response' => false,'reason' => "Move not specified"));
			}
		} else { //if the file name depending of the pid doesn't exist meaning there was created a match with that pid
			echo json_encode(array('response' => false,'reason' => "Unknown pid"));
		}
		
	} else { // else if pid wasn't given
		echo json_encode(array('response' => false,'reason' => "Pid not specified"));
		}
	
	
	
function makeMove($pid, $move){
	
	// restore the saved game, $game receives the instance of that pid
	$game = Game::restore($pid);
	// TODO check is a valid move
	$ackMove = $game->doMove(TRUE, $move);
	if($ackMove->isWin || $ackMove->isDraw){ //if our move results in win or draw
		echo json_encode(array('response' => true,'ack_move' => $ackMove));
	}
	elseif($ackMove == null){ //if our move is given null, meaning we try placing a token, in a spot that is taken
		echo json_encode(array("response "=> false, "reason" => "Place not empty, (".$move[0].", ".$move[1].")"));
	}
	else { // all of the above was met, is the bot turn to move
		if($game->strategy === "random"){ // if we selected a random strategy for the bot, to play as
			
			$move = RandomStrategy::pickPlace($game->board); // bot makes a move randomly, and $move recieves and array of the cordinates that bot decided to move
			
		}
		else{ // if we selected a smart strategy for the bot, to play as
			$move = SmartStrategy::getMove($game->board, $move); // bot makes a move kind of smart, and $move recieves and array of the cordinates that bot decided to move
			
		$myMove = $game->doMove(FALSE, $move);  //check is a valid move
		echo json_encode(array('response' => true ,'ack_move' => $ackMove, 'move' => $myMove)); // prints the play
		}
	saveGame($pid, $game); // saves the new changes in the pid file
	}
}
?>
