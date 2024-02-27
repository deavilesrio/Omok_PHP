<?php
// require('RandomStrategy.php');
// class RandomStrategy{
// 	static function getMove($board){
// 		for(;;){
// 			$move[0] = rand(0, 14);
// 			$move[1] = rand(0, 14);
// 			// if(!$board[$move[0]][$move[1]]){
// 			// 	return $move;
// 			// }
// 			if ($board[$move[0]][$move[1]]== 0){
// 				return $move;
// 			 }
// 		}
// 	}
// }

class SmartStrategy{
	static function getMove($bool, $board, $lastMove){

		$playerMove = $board[$lastMove[0]][$lastMove[1]];
		$startIndexH= ($lastMove[0]<4)? 0 : $lastMove[0]-4;
		$endIndexH = ($lastMove[0]>10)? 14 : $lastMove[0]+4;
		$startIndexV = ($lastMove[1]<4)? 0 : $lastMove[1]-4;
		$endIndexV = ($lastMove[1]>10)? 14 : $lastMove[1]+4;
		$counth = 0;
		$countv= 0;
		$count1 = 0;
		$count2 = 0;
		$count3 = 0;
		$count4 = 0;
		$temp = 0;
		$tempValue = array(0,0);	
		$backwars_h = true;
		$backwars_v = true;
		
		//echo json_encode($playerMove);
		// echo('<br>Player Mover'.$lastMove[0].' and '.$lastMove[1]);
		// echo('<br>Horizontal Index'.$startIndexH.' and '.$endIndexH);
		// echo('<br>Vertical Index'.$startIndexV.' and '.$endIndexV);
		//TODO check if there is a win in horizontal of the last move in the board
		for($i = $startIndexH; $i <= $endIndexH; $i++){
			
			if($board[$i][$lastMove[1]] == $playerMove){
				
				$counth++;
			} else if($counth > $temp){
				$backwars_h = false;
				$temp = $counth;
				if($temp >= 2 && $board[$i][$lastMove[1]] == 0){
					// echo('<br>1 Horizontal');
					//echo json_encode($temp);
					$tempValue[0] = $i;
					$tempValue[1] = $lastMove[1];
					break;
				} else if($temp > 1 && $board[$i][$lastMove[1]] == 2 && $board[$lastMove[0]-1][$lastMove[1]] == 0){
					// echo('<br>2 Horizontal');
					$tempValue[0] = $lastMove[0]-1;
					$tempValue[1] = $lastMove[1];
					break;
				} else {
					//if($temp > 3){echo json_encode($temp);}
					// echo('<br>Random Horizontal');
					$tempValue = RandomStrategy::pickPlace($board);
					
				}
			}
			// echo('<br>'.$i.' and '.$lastMove[1].'- count: '. $counth);
		}
		
		
		// echo('<br>'.$tempValue[0]. ' '. $tempValue[1]);
		
		//echo json_encode($tempValue);
		
		//TODO checks if there is a win in the vertical of the last move on the board
		for($i = $startIndexV; $i <= $endIndexV; $i++){
			
			if($board[$lastMove[0]][$i] == $playerMove){
				$countv++;
			} else if($countv > $temp){
						$backwars_v = false;
						$temp = $countv;
						if($temp >= 2 && $board[$lastMove[0]][$i] == 0){
							// echo('<br>1 Vertical');
							
							//echo json_encode($temp);
							$tempValue[0] = $lastMove[0];
							$tempValue[1] = $i;
							break;
						} else if($temp > 1 && $board[$lastMove[0]][$i] == 2 && $board[$lastMove[0]][$lastMove[1]-1] == 0){
							//echo('<br>2 Vertical');
							$tempValue[0] = $lastMove[0];
							$tempValue[1] = $lastMove[1]-1;
							break;
						} else {
							//if($temp > 3){echo json_encode($temp);}
							//echo('<br>Random Vertical');
							$tempValue = RandomStrategy::pickPlace($board);
						}
					}
					//echo('<br>'.$lastMove[0].' and '.$i.'- count: '. $countv);
				} 
				//echo('<br>'.$tempValue[0]. ' '. $tempValue[1]);
			if($backwars_h){
				//echo('<br>Went into backwars_h');
				for($i = $startIndexH+5; $i > $endIndexH-5; $i--){
			
					if($board[$i][$lastMove[1]] == $playerMove){
						
						$counth++;
					} else if($counth > $temp){
						
						$temp = $counth;
						if($temp >= 2 && $board[$i][$lastMove[1]] == 0){
							//echo('<br>1 Horizontal backwards');
							//echo json_encode($temp);
							$tempValue[0] = $i;
							$tempValue[1] = $lastMove[1];
							break;
						} else if($temp > 1 && $board[$i][$lastMove[1]] == 2 && $board[$lastMove[0]-1][$lastMove[1]] == 0){
							//echo('<br>2 Horizontal backwards');
							$tempValue[0] = $lastMove[0]-1;
							$tempValue[1] = $lastMove[1];
							break;
						} else {
							//if($temp > 3){echo json_encode($temp);}
							//echo('<br>Random Horizontal backwards');
							$tempValue = RandomStrategy::pickPlace($board);
							
						}
					}
					//echo('<br>'.$i.' and '.$lastMove[1].'- count: '. $counth);
				}
				
				//echo('<br>'.$tempValue[0]. ' '. $tempValue[1]);
			}
			
			if($backwars_v){
				for($i = $startIndexV+5; $i >$endIndexV-5; $i--){
			
					if($board[$lastMove[0]][$i] == $playerMove){
						$countv++;
					} else if($countv > $temp){
								$temp = $countv;
								if($temp >= 2 && $board[$lastMove[0]][$i] == 0){
									//echo('<br>1 Vertical backwards');
									
									//echo json_encode($temp);
									$tempValue[0] = $lastMove[0];
									$tempValue[1] = $i;
									break;
								} else if($temp > 1 && $board[$lastMove[0]][$i] == 2 && $board[$lastMove[0]][$lastMove[1]-1] == 0){
									//echo('<br>2 Vertical backwards');
									$tempValue[0] = $lastMove[0];
									$tempValue[1] = $lastMove[1]-1;
									break;
								} else {
									//if($temp > 3){echo json_encode($temp);}
									//echo('<br>Random Vertical backwards');
									$tempValue = RandomStrategy::pickPlace($board);
								}
							}
							//echo('<br>'.$lastMove[0].' and '.$i.'- count: '. $countv);
						} 
						//echo('<br>'.$tempValue[0]. ' '. $tempValue[1]);
			}
				
		return $tempValue;
	}
	
}
?>
	

