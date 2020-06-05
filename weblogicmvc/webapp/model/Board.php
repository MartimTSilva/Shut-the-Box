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
    public function checkFinalPlayP1($sumDices){
        //Vê todas as somas possiveis da $sum e dos números não bloquados
        if($this->checkIfPlayIsPossible($sumDices)){
            return false;
        } else {
            //Se não poder, envia "true"/que é a final play
            return true;
        }
    }

    //Verifica se pode jogar mais uma vez
    public function checkFinalPlayP2($sumDices){
        if($this->checkIfPlayIsPossible($sumDices)){
            return false;
        } else {
            //Se não poder, acaba o jogo
            return true;
        }
    }

    public function getWinner(){
        $_P1_final_points = Session::get('P1_sumPoints');
        $_P2_final_points = Session::get('P2_sumPoints');

        if ($_P1_final_points < $_P2_final_points){
            //Userid para guardar classificação
            $user_id = Session::get('userid');

            //Timezone para a data
            date_default_timezone_set("Europe/Lisbon");
            
            //Guarda a classificação
            $classification = new Classification([
                "user_id" => $user_id,
                "points" => $_P1_final_points,
                "date" => date("Y/m/d H:i:s")
            ]);
            $classification->save();

            //Player 1 ganha, retorna 1.
            return 1;
        } else if ($_P1_final_points == $_P2_final_points){
            //Empate
            return 3;
        } else {
            //Player 2 ganha
            return 2;
        }
    }

    /*public function getWinnerPoints(){
        $_P1_final_points = Session::get('P1_sumPoints');
        $_P2_final_points = Session::get('P2_sumPoints');

        if ($this->getWinner($_P1_final_points, $_P2_final_points) == 1) {
            return $_P1_final_points;
        } else {
            return $_P2_final_points;
        }
    }*/

    public function checkIfPlayIsPossible($sumDices)
    {
        $game = Session::get('game');

        //Todos os números possiveis
        $_availableNumbers = [1, 2 , 3, 4, 5, 6, 7, 8, 9];

        //Vê quem está a jogar
        if ($game->getGameState() == 2){
            //Vê quais os números que o Player 1 não bloqueou
            $_availableNumbers = array_diff($_availableNumbers, $game->_board->_blockedNumbersP1->_numBlock);
        } else if ($game->getGameState() == 4){
            //Vê quais os números que o Player 2 não bloqueou
            $_availableNumbers = array_diff($_availableNumbers, $game->_board->_blockedNumbersP2->_numBlock);
        }

        //Com os números que não estão bloqueados, vamos ver se ainda é possivel fazer a jogada
        foreach ($_availableNumbers as $number){
            if ($number == $sumDices){
                return true;
            } else {
                foreach ($_availableNumbers as $number_2nd_array){
                    if ($number == $number_2nd_array){
                        continue;
                    } else {
                        $num_sum=$number + $number_2nd_array;
                        if($num_sum == $sumDices){
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}