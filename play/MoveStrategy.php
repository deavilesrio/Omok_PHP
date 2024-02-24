<?php
include "Board.php";


$board = new Board();
abstract class MoveStrategy {
   protected $board;
   
   function __construct(Board $board = null) {
      $this->board = $board;
   }

   abstract function pickPlace($board);

   function toJson() {
      return array('name' => get_class($this));
   }

   static function fromJson() {
       $strategy = new static();
       return $strategy;
   }
}
