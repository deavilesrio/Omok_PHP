<?php

//creating and encoding the basic information of the game/
$strategies = array('Smart' => 'SmartStrategy','Random' => 'RandomStrategy');
$info = new GameInfo(15, array_keys($strategies));
echo json_encode($info); 

class GameInfo {
   public $size;
   public $strategies;
   function __construct($size, $strategies) {
      $this->size= $size; 
      $this->strategies = $strategies;
    }
	public function toJson(){
		echo json_encode($this);
	}
}
?>
