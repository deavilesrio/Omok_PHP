<?php
// require("Game.php");
abstract class MoveStrategy {
   protected $board_game;
   
   // had to remove the constructor becuase the way index play is implemented, it requires the board file and having it here too crashes
//    function __construct(Game $board_game = null) { 
//       $this->$board_game = $board_game;
//    }

   abstract static function pickPlace($board);
   function toJson() {
      return array('name' => get_class($this));
   }

   static function fromJson() {
       $strategy = new static();
       return $strategy;
   }
}
