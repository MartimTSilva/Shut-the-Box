<?php
use ActiveRecord\Model;
use ArmoredCore\WebObjects\Session;

//Faz chamadas de métodos de outras classes
class Board extends Model{
    private $_dice;
    private $_resultDice1 = 0;
    private $_resultDice2 = 0;
    private $_blockedNumbersP1 = [];
    private $_blockedNumbersP2 = [];

    //Lança 2 dados
    public static function throwDices(){
        $_resultDice1 = Dice::throwDices();
        $_resultDice2 = Dice::throwDices();

        //TODO: Ver se está a jogar o bot ou o player
        Board::checkFinalPlayP1($_resultDice1 + $_resultDice2);

        //Else, bot
        Board::checkFinalPlayP2($_resultDice1 + $_resultDice2);
    }

    //Verifica se pode jogar mais uma vez
    public function checkFinalPlayP1($sum){
        //Vê todas as somas possiveis da $sum e dos números não bloquados
        $this->_blockedNumbersP1 = BlockedNumbers::$_numBlock;

        //Se não poder, guarda os numeros bloquados e muda para o bot
        //$this->_blockedNumbersP1 = Session::get('P1_numBlock');
        return BlockedNumbers::checkPlay($sum);
    }

    //Verifica se pode jogar mais uma vez
    public function checkFinalPlayP2($sum){
        //Vê todas as somas possiveis da $sum e dos números não bloquados
        $this->_blockedNumbersP2 = BlockedNumbers::$_numBlock;

        //Se não poder, guarda os numeros bloquados e muda para o bot
        $this->_blockedNumbersP2 = Session::get('P2_numBlock');
        return BlockedNumbers::checkPlay($sum);
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
}