<?php

class GameEngine{
    public $_board;
    public $_gameState = 0;

    public function startGame(){
        $this->_board = new Board();
    }

    public function getGameState(){
        return $this->_gameState;
    }

    public function updateGameState($state){
        $this->_gameState = $state;
    }
}