<?php
use ActiveRecord\Model;

class User extends Model{
    static $validates_presence_of = array(
        array(
            'name',
            'message' => 'O nome é um campo obrigatório.'
        ),
        array(
            'username',
            'message' => 'O Username é um campo obrigatório.'
        ),
        array(
            'email',
            'message' => 'O e-mail é um campo obrigatório.'
        ),
        array(
            'password',
            'message' => 'A password é um campo obrigatório.'
        ),
        array(
            'birthdate',
            'message' => 'A data de nascimento é um campo obrigatório.'
        )
    );
    
    static $validates_size_of = array(
        array(
            'name', 'minimum' => 3, 
            'too_short' => 'O nome tem que ter no mínimo 3 caracteres.',
        ),
        array(
            'name', 'maximum' => 35, 
            'too_long' => 'O nome não pode exceder os 35 caracteres.'
        ),
        array(
            'username', 'minimum' => 4, 
            'too_short' => 'O username tem que ter no mínimo 4 caracteres.'
        ),
        array(
            'username', 'maximum' => 15, 
            'too_long' => 'O username não pode exceder os 15 caracteres.'
        ),
        array(
            'email', 'minimum' => 5, 
            'too_short' => 'O e-mail tem que ter no mínimo 5 caracteres.'
        ),
        array(
            'email', 'maximum' => 35, 
            'too_long' => 'O e-mail não pode exceder os 35 caracteres.'
        ),
        array(
            'password', 'minimum' => 5, 
            'too_short' => 'A password tem que ter no mínimo 5 caracteres.'
        )
    );

    static $validates_uniqueness_of = array(
        array(
            'username',
            'message' => 'Já existe um utilizador com este username.'
        ),
        array(
            'email',
            'message' => 'Já existe um utilizador com este e-mail.'         
        )
    );
} 