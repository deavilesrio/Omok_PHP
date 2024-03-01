<?php

//Diego Aviles and Angel Urbina
require 'Common.php';
require 'Game.php';
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
					if($x>14 | $x< 0){
						echo json_encode(array('response' => false,'reason' => "Invalid x coordinate"));
					}
					elseif($y>14 | $y<0){
						echo json_encode(array('response' => false,'reason' => "Invalid y coordinate"));
					}
					else{
						// echo('succesfully make a movement');
						makeMove($pid, array((int)$x, (int)$y));
					}
				}elseif(!$y){
					echo json_encode(array('response' => false,'reason' => "y not specified"));
				}
			}else{
				echo json_encode(array('response' => false,'reason' => "Move not specified"));
			}
		} else {
			echo json_encode(array('response' => false,'reason' => "Unknown pid"));
		}
		
	} else {
		echo json_encode(array('response' => false,'reason' => "Pid not specified"));
		}
	
	
	
function makeMove($pid, $move){
	//echo json_encode($move);
	// restore the saved game
	$game = Game::restore($pid);
	// TODO check is valid move
	$ackMove = $game->doMove(TRUE, $move);
	if($ackMove->isWin || $ackMove->isDraw){
		echo json_encode(array('response' => true,'ack_move' => $ackMove));
	}
	elseif($ackMove == null){
		echo json_encode(array("response "=> false, "reason" => "Place not empty, (".$move[0].", ".$move[1].")"));
	}
	else {
		if($game->strategy === "random"){
			// $move = RandomStrategy::getMove($game->board);
			$move = RandomStrategy::pickPlace($game->board);
			
		}
		else{
			$move = SmartStrategy::getMove($game->board, $move);
		}
		$myMove = $game->doMove(FALSE, $move);
		echo json_encode(array('response' => true ,'ack_move' => $ackMove, 'move' => $myMove));
	}
	saveGame($pid, $game);
}
?>
