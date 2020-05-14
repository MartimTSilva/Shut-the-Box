<?php
use ActiveRecord\Model;

class Dice extends Model{
    
    public function throwDices(){
        //Randomizar numero de 1 a 6
        return rand(1, 6);
    }
}