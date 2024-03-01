<?php
// require("Game.php");
abstract class MoveStrategy {
   protected $board_game;
   
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
