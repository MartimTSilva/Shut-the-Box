<?php
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 09-05-2016
 * Time: 11:30
 */
class UserController extends BaseController
{
    public function edit(){
        return View::make('user.edit');
    }

    public function registerUser(){
        //Vai buscar os campos ao POST
        $name = Post::get('name');
        $username = Post::get('username');
        $email = Post::get('email');
        $password = password_hash(Post::get('password'), PASSWORD_DEFAULT);
        $birthdate = Post::get('birthdate');

        $user = new User([
            "name" => $name,
            "username" => $username,
            "email" => $email,
            "password" => $password,
            "birthdate" => $birthdate
        ]);

        //Se os dados forem válido, regista se não volta para a página de registo com os campos preenchidos
        if($user->is_valid()){
            $user->save();
            Redirect::toRoute('home/login');
        } else {
            // return form with data and errors
            Redirect::flashToRoute('home/signup', ['user' => $user]);
        }
    }
}