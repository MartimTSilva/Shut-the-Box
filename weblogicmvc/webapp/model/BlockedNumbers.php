<?php
use ActiveRecord\Model;
use ArmoredCore\WebObjects\Session;

class BlockedNumbers extends Model{
    public $_numBlock = [];

    protected function start(){
        //Coloca vetor a falso
        reset($_numBlock);
    }

    //Recebe os números que quer bloquear
    protected function blockNumber($number, $diceSum){
        //Vê se o numero pressionado é menor ou igual à soma de dados
        if ($number <= $diceSum){
            //Se for menor, adicona o número aos dos bloqueados
            //TODO: Ver se número está bloqueado
            $this->_numBlock[] = $number;
            return true;
        }
        return false;
    }

    //Recebe os números que quer desbloquear
    protected function unBlockNumber($number){
        //Retira do array o número que se quer desbloquear
        array_splice($this->_numBlock[], $number);
    }

    //Vê se a soma dos dados restantes permite bloquear outro número
    protected function checkPlay($diceSum){
        //Se não houve mais números proveniente da some de dados, então pode lançar outra vez os dados

        //TODO: Igualar 2 arrays, uma para ficar com os numeros bloqueados difinitivos e outros para bloquear os números da jogada
        if ($diceSum == 0){
            return true;
        }
        return false;
    }

    //Vai buscar a soma de todos os números bloqueados
    protected function getFinalPointsSum(){
        //Vê se é o bot ou o player a jogar e guarda na sessão os números bloquados
        Session::set('P1_numBlock', $this->_numBlock);
        Session::set('P2_numBlock', $this->_numBlock);
        return array_sum($this->_numBlock);        
    }
}