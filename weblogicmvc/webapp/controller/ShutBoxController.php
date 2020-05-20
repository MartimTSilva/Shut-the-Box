<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;

/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 09-05-2016
 * Time: 11:30
 */
class ShutBoxController extends BaseController
{

    public function index(){
        if (Session::has('loggedin') == true) {
            return View::make('game.index');
        } else {
            $erro = "Precisa de estar autenticado/a para poder jogar!";
            return view::make('home.login', ['erro' => $erro]);
        }
    }
}