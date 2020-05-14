<?php
use ActiveRecord\Model;

class Board extends Model{
    private $_dice;
    private $_resultDice1 = 0;
    private $_resultDice2 = 0;
    private $_blockedNumberP1;
    private $_blockedNumberP2;

    //Faz chamadas de métodos de outras classes
    public function throwDices(){
        $_resultDice1 = new Dice();
        $_resultDice2 = new Dice();
    }

    public function checkFinalPlayP1($sum){
        //verifica se pode jogar mais uma vez
    }

    public function checkFinalPlayP2($sum){

    }

    public function getWinner(){

    }

    public function getWinnerPoints(){

    }
}