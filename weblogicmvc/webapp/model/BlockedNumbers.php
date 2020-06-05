<?php
use ArmoredCore\WebObjects\Session;

class BlockedNumbers{
    public $_numBlock = [];
    public $_numBlockCurrentPlay = [];

    protected function start(){
        //Coloca vetor a falso
        reset($_numBlock);
        reset($_numBlockCurrentPlay);
    }

    //Recebe os números que quer bloquear
    public function blockNumber($number, $game){
        //Vê se o número já está bloqueado
        if (!in_array($number, $this->_numBlockCurrentPlay)){
            //Vê se já tem 2 números bloqueados
            if(sizeof($this->_numBlockCurrentPlay) < 2){
                //Adiciona o número aos dos bloqueados
                array_push($this->_numBlockCurrentPlay, $number);
                return true;
            }
        } 
        else {
            //Adiciona o número retirado à soma dos dados
            $game->_board->_diceSum = $game->_board->_diceSum + $number;

            //Desbloqueia o número
            $this->unBlockNumber($number);
            return false;
        } 
    }

    //Recebe os números que quer desbloquear
    public function unBlockNumber($number){
        //Retira do array o número que se quer desbloquear
        if (($key = array_search($number, $this->_numBlockCurrentPlay)) !== false) {
            unset($this->_numBlockCurrentPlay[$key]);
        }
    }

    
    /*public function checkPlay($game){
        if ($game->_board->_diceSum == 0){
            $game->updateGameState(1);
            return true;
        }
        return false;
    }*/

    //Vai buscar a soma de todos os números bloqueados
    public function getFinalPointsSum(){
        //Vê se é o bot ou o player a jogar e guarda na sessão os números bloquados
        return array_sum($this->_numBlock);        
    }

    public function saveBlockedNumbers()
    {
        $this->_numBlock = array_merge($this->_numBlock, $this->_numBlockCurrentPlay);
        $this->_numBlockCurrentPlay = [];
    }
}   