<?php
use ArmoredCore\WebObjects\Session;

//Faz chamadas de métodos de outras classes
class Board{
    private $_dice;
    public $_resultDice1;
    public $_resultDice2;
    public $_blockedNumbersP1;
    public $_blockedNumbersP2;
    public $_diceSum = 0;


    public function __construct(){
        $this->_blockedNumbersP1 = new BlockedNumbers();
        $this->_blockedNumbersP2 = new BlockedNumbers();
    }

    //Lança 2 dados
    public function throwDices(){
        $this->_dice = new Dice();
        $this->_resultDice1 = $this->_dice->throwDice();
        $this->_resultDice2 = $this->_dice->throwDice();
        
        //Guarda a soma dos dados
        $this->_diceSum = $this->_resultDice1 + $this->_resultDice2;
    }

    //Verifica se pode jogar mais uma vez
    public function checkFinalPlayP1($sum){
        //Vê todas as somas possiveis da $sum e dos números não bloquados
        if($this->checkIfPlayIsPossible($sum)){
            return false;
        } else {
            //Se não poder, envia "true"/que é a final play
            return true;
        }
    }

    //Verifica se pode jogar mais uma vez
    public function checkFinalPlayP2($sum){
        if($this->checkIfPlayIsPossible($sum)){
            return false;
        } else {
            //Se não poder, acaba o jogo
            return true;
        }
    }

    public function getWinner(){
        $_max_possible_points = 45;
        $_P1_final_points = $_max_possible_points - Session::get('P1_numBlock');
        $_P2_final_points = $_max_possible_points - Session::get('P2_numBlock');

        if ($_P1_final_points < $_P2_final_points){
            //Player ganha
            return 1;
        } else {
            //Bot ganha
            return 2;
        }
        //TODO: Empates?
    }

    public function getWinnerPoints(){
        $_max_possible_points = 45;
        if (Board::getWinner() == 1) {
            return $_max_possible_points - Session::get('P1_numBlock');
        } else {
            return $_max_possible_points - Session::get('P2_numBlock');
        }
    }

    public function checkIfPlayIsPossible($sum)
    {
        $game = Session::get('game');

        $_availableNumbers = [1, 2 , 3, 4, 5, 6, 7, 8, 9];
        if ($game->getGameState() == 2){
            $_availableNumbers = array_diff($_availableNumbers, $game->_board->_blockedNumbersP1->_numBlock);
        } else if ($game->getGameState() == 4){
            $_availableNumbers = array_diff($_availableNumbers, $game->_board->_blockedNumbersP2->_numBlock);
        }

        foreach ($_availableNumbers as $number){
            if ($number == $sum){
                return true;
            } else {
                foreach ($_availableNumbers as $number_2nd_array){
                    if ($number == $number_2nd_array){
                        continue;
                    } else {
                        $num_sum=$number + $number_2nd_array;
                        if($num_sum == $sum){
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}