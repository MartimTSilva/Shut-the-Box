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
class AdminController extends BaseController
{

    public function index(){
        if(Session::has('admin')) {
            return View::make('admin.index', ["all_users" => User::all()]);
        } else {
            return View::make('home.index');
        }

    }

    public function blockUser($id)
    {
        $user = User::find($id);
        if($user->blocked == 0)
            $user->blocked = 1;
        else 
            $user->blocked = 0;

        $user->save();
        return View::make('admin.index', ["all_users" => User::all()]);
    }

    public function giveAdmin($id)
    {
        $user = User::find($id);
        if($user->admin == 0)
            $user->admin = 1;
        else 
            $user->admin = 0;

        $user->save();
        return View::make('admin.index', ["all_users" => User::all()]);
    }
}