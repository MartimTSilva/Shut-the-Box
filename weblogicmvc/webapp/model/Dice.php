<?php
use ActiveRecord\Model;

class Dice extends Model{
    
    public static function throwDice(){
        //Randomizar numero de 1 a 6
        return rand(1, 6);
    }
}