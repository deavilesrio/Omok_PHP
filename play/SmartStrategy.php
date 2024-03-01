<?php


class SmartStrategy{
	static function getMove($board, $ourMove){
		//plaver spot value
		$playerMove = $board[$ourMove[0]][$ourMove[1]];
		//gets the last 4 moves downs or up depending the lastMove for the horizontal line and for the vertical line
		$startIndexH= ($ourMove[0]<4)? 0 : $ourMove[0]-4;	$startIndexV = ($ourMove[1]<4)? 0 : $ourMove[1]-4;
		$endIndexH = ($ourMove[0]>10)? 14 : $ourMove[0]+4;	$endIndexV = ($ourMove[1]>10)? 14 : $ourMove[1]+4;
		
		//count variable to count how many token in a row there are in the board
		$counth = 0;
		$countv= 0;
		$temp = 0;
		$tempValue = array(0,0);	// temp  array to store possible move to do(bot turn)

		//booleans to know if the bots need to check from up to down, or right to left
		$backwars_h = true; 
		$backwars_v = true;
		
		//TODO check if there is a win in horizontal line from the last 4 left to right direction
		for($i = $startIndexH; $i <= $endIndexH; $i++){ // loops 5 times checking 5 spots below our actual move in the horizontal line
			
			if($board[$i][$ourMove[1]] == $playerMove){ // checks how many tokens next to another there are
				
				$counth++;
			} else if($counth > $temp){ // if the count is greater than temp tha go inside
				$backwars_h = false; // we dont have to check in reverse cause it means there a token going up
				$temp = $counth; // temp stores counth, there might be more token next to another later on

				if($temp >= 2 && $board[$i][$ourMove[1]] == 0){ 
				// if there are two or more consecutive token from us and the next spot is not taken by any one, the bot will place its token their
					$tempValue[0] = $i;
					$tempValue[1] = $ourMove[1];
					break; //break from the loop
				} else if($temp > 1 && $board[$i][$ourMove[1]] == 2 && $board[$ourMove[0]-1][$ourMove[1]] == 0){
					// if there are more than 1 consecutive token from us and the next spot is taken the bot, and the spot before is not taken by any one the bot will place its token their
	
					$tempValue[0] = $ourMove[0]-1;
					$tempValue[1] = $ourMove[1];
					break;
				} else {
					//if the last two are not met then it means their is no danger of losing for the bot, therefore choose a random spot
					$tempValue = RandomStrategy::pickPlace($board);
					
				}
			}
			
		}
		
		
	
		
		//TODO checks if there is a win in the vertical line from the last 4 down to up direction
		for($i = $startIndexV; $i <= $endIndexV; $i++){ // loops 5 times checking 5 spots below our actual move in the vertical line
			
			if($board[$ourMove[0]][$i] == $playerMove){ // checks how many tokens next to another there are
				$countv++;
			} else if($countv > $temp){ // if the count is greater than temp tha go inside
						$backwars_v = false; // we dont have to check in reverse cause it means there a token going up
						$temp = $countv; // temp stores countv, there might be more token next to another later on
						if($temp >= 2 && $board[$ourMove[0]][$i] == 0){

							// if there are two or more consecutive token from us and the next spot is not taken by any one, the bot will place its token their						
							$tempValue[0] = $ourMove[0];
							$tempValue[1] = $i;
							break; //break from the loop
						} else if($temp > 1 && $board[$ourMove[0]][$i] == 2 && $board[$ourMove[0]][$ourMove[1]-1] == 0){
							// if there are more than 1 consecutive token from us and the next spot is taken the bot, and the spot before is not taken by any one the bot will place its token their
							$tempValue[0] = $ourMove[0];
							$tempValue[1] = $ourMove[1]-1;
							break;
						} else {
							//if the last two are not met then it means their is no danger of losing for the bot, therefore choose a random spot							
							$tempValue = RandomStrategy::pickPlace($board);
						}
					}
					
				} 
			//the horizontal left to right check failed there for check from right to left now
			if($backwars_h){
				//therefore it starts 5 index above, and stops 5 spot below
				for($i = $startIndexH+5; $i > $endIndexH-5; $i--){
			
					if($board[$i][$ourMove[1]] == $playerMove){ // checks how many tokens next to another there are
						
						$counth++;
					} else if($counth > $temp){// if the count is greater than temp tha go inside
						
						$temp = $counth; // temp stores counth, there might be more token next to another later on
						if($temp >= 2 && $board[$i][$ourMove[1]] == 0){
							// if there are two or more consecutive token from us and the next spot is not taken by any one, the bot will place its token their	
							$tempValue[0] = $i;
							$tempValue[1] = $ourMove[1];
							break; //break from the loop
						} else if($temp > 1 && $board[$i][$ourMove[1]] == 2 && $board[$ourMove[0]-1][$ourMove[1]] == 0){
							// if there are more than 1 consecutive token from us and the next spot is taken the bot, and the spot before is not taken by any one the bot will place its token their
							$tempValue[0] = $ourMove[0]-1;
							$tempValue[1] = $ourMove[1];
							break;
						} else {
							//if the last two are not met then it means their is no danger of losing for the bot, therefore choose a random spot						
							$tempValue = RandomStrategy::pickPlace($board);
							
						}
					}
					
				}
				
				
			}
			//the vertical down to up check failed there for check from up to down now
			if($backwars_v){
				for($i = $startIndexV+5; $i >$endIndexV-5; $i--){
			
					if($board[$ourMove[0]][$i] == $playerMove){ // checks how many tokens next to another there are
						$countv++;
					} else if($countv > $temp){ // if the count is greater than temp tha go inside
								$temp = $countv;// temp stores countv, there might be more token next to another later on

								if($temp >= 2 && $board[$ourMove[0]][$i] == 0){
									// if there are two or more consecutive token from us and the next spot is not taken by any one, the bot will place its token their	
									$tempValue[0] = $ourMove[0];
									$tempValue[1] = $i;
									break;
								} else if($temp > 1 && $board[$ourMove[0]][$i] == 2 && $board[$ourMove[0]][$ourMove[1]-1] == 0){
									// if there are more than 1 consecutive token from us and the next spot is taken the bot, and the spot before is not taken by any one the bot will place its token their
									$tempValue[0] = $ourMove[0];
									$tempValue[1] = $ourMove[1]-1;
									break;
								} else {
									//if the last two are not met then it means their is no danger of losing for the bot, therefore choose a random spot									
									$tempValue = RandomStrategy::pickPlace($board);
								}
							}
							
						} 
						
			}
		//returns the array of the movement choosen by the bot		
		return $tempValue;
	}
	
}
?>
	

