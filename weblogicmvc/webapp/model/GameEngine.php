<?php

class GameEngine{
    private $_board;
    private $_gameState = 0;

    public function startGame(){
        $_board = new Board();
    }

    public function getGameState(){
        return $this->_gameState;
    }

    public function updateGameState(){

    }
}