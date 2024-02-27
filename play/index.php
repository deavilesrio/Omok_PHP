<?php

//Diego Aviles and Angel Urbina
require 'Common.php';
require 'Game.php';
require 'Response.php';
require 'RandomStrategy.php';
require 'Strategy.php';
$uri = explode('?', $_SERVER['REQUEST_URI']);
$x = $_GET["x"];
$y = $_GET["y"];


	// get the pid from the query aka $uri[1]
	$pid = getParam("pid", $uri[1]);
	$filename = "../new/$pid.txt";
	// check if strategy was found
	if($pid){
		// get the $move from the query
		
		if (file_exists($filename)) {
			if($x!=Null){
				if($y!=Null){
					if($y>14){
						echo('{"response": false, "reason": "Invalid y coordinate '. $y.'}');
					}elseif($x>14){
						echo('{"response": false, "reason": "Invalid x coordinate '. $x.'}');
					}
					else{
						// echo('succesfully make a movement');
						makeMove($pid, array((int)$x, (int)$y));
					}
				}elseif(!$y){
					echo('{"response": false, "reason": "y not specified"}');
				}
			}else{
				echo('{"response": false, "reason": "Move not specified"}');
			}
		} else {
			echo ('{"response": false, "reason": "Unknown pid"}');
		}
		
	} else {
		echo json_encode(Response::withReason("Pid not specified"));
		}
	
	
	
function makeMove($pid, $move){
	//echo json_encode($move);
	// restore the saved game
	$game = Game::restore($pid);
	// TODO check is valid move
	$ackMove = $game->doMove(TRUE, $move);
	if($ackMove->isWin || $ackMove->isDraw){
		echo json_encode(Response::withMove($ackMove));
	}
	elseif($ackMove == null){
		echo('"response": false, "reason": "Position occupied');
	}
	else {
		if($game->strategy === "random"){
			// $move = RandomStrategy::getMove($game->board);
			$move = RandomStrategy::pickPlace($game->board);
			
		}
		else{
			$move = SmartStrategy::getMove(FALSE, $game->board, $move);
		}
		$myMove = $game->doMove(FALSE, $move);
		echo json_encode(Response::withMoves($ackMove, $myMove));
	}
	saveGame($pid, $game);
}
?>
