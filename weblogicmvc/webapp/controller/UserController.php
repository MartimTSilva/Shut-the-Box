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
    public function editPage(){
        if (isset($_SESSION['userid'])){
            $user = User::find_by_id(Session::get('userid'));
            return view::make('user.edit', ['user' => $user]);
        } else {
            return view::make('home.index');    
        }
    }

    public function loginUser(){
        $username = Post::get('username');
        $password = Post::get('password');

        $user = User::find_by_username($username);

        if ($user){
            if(password_verify($password, $user->password) && $user->blocked == 0)
            {
                Redirect::toRoute('game/index'); 
                Session::set('loggedin', true);
                Session::set('userid', $user->id);
                Session::set('admin', $user->admin);
                if ($user->admin == 1) {
                    Redirect::toRoute('admin/index');
                }
                else {
                    return view::make('home.index');    
                }
            } else {
                $erro = "Erro! Informação incorreta.";
                Redirect::flashToRoute('home/login', ['erro' => $erro]);
            }
        } else {
            $erro = "Erro! Utilizador não existe.";
            Redirect::flashToRoute('home/login', ['erro' => $erro]);
        }
    }

    public function logoutUser(){
        if (Session::get('loggedin') != null && Session::get('loggedin') == true) {
            Session::destroy();
            Session::set('loggedin', false);
            $erro = "";
            return view::make('home.login', ['erro' => $erro]);
        }
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

    public function updateUserDetails($id)
    {
        //Vai buscar o user com o id
        $user = User::find($id);

        //Vê se o utilizador introduziu uma nova password, se sim faz hash
        if (!empty(Post::get('password')))
            $password = password_hash(Post::get('password'), PASSWORD_DEFAULT);
        else
            $password = $user->password;

        $user->update_attributes([
            "name" => Post::get('name'),
            "email" => Post::get('email'),
            "password" => $password
        ]);

        //Se os dados forem válido, regista se não volta para a página de registo com os campos preenchidos
        if($user->is_valid()){
            $user->save();
            Redirect::toRoute('home/index');
        } else {
            // return form with data and errors
            Redirect::flashToRoute('user/edit', ['user' => $user]);
        }
    }
}