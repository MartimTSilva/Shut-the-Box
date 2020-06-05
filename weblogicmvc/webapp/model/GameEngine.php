<?php
/*
    Game States:
    1 - Começa o jogo / Espera ação do P1 (Lançar os dados)
    2 - Espera o P1 bloquear os dados
    3 - Espera ação do P2 (Lançar os dados)
    4 - Espera o P2 bloquear os dados
    5 - Fim do jogo (Calcular vencedor)
*/
class GameEngine{
    public $_board;
    private $_gameState = 0;

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