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
    protected function blockNumber($number, $diceSum){
        //Vê se o número já está bloqueado
        if (in_array($number, $this->_numBlock[])){
            //Vê se já tem 2 números bloqueados
            if(sizeof($this->_numBlockCurrentPlay) < 2){
                //Vê se o numero pressionado é menor ou igual à soma de dados
                if ($number <= $diceSum){
                    //Adiciona o número aos dos bloqueados
                    array_push($this->_numBlockCurrentPlay, $number);
                    return true;
                }
            }
        } 
        else {
            //Desbloqueia o número
            $this->unBlockNumber($number);
            return false;
        }
        //Não deixa bloquear o numero
        return false;        
    }

    //Recebe os números que quer desbloquear
    protected function unBlockNumber($number){
        //Retira do array o número que se quer desbloquear
        array_splice($this->_numBlockCurrentPlay[], $number);
    }

    //Vê se a soma dos dados restantes permite bloquear outro número
    protected function checkPlay($diceSum){
        if ($diceSum == 0){
            //Se não houver mais números proveniente da soma de dados, então pode lançar outra vez os dados
            //Iguala 2 arrays, uma para ficar com os numeros bloqueados definitivos e outros para bloquear os números da jogada
            array_push($this->_numBlock,  $this->_numBlockCurrentPlay);
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