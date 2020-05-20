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
class HomeController extends BaseController
{

    public function index(){
        return View::make('home.index');
    }

    public function loginPage(){
        if (Session::has('loggedin')) {
            return View::make('home.index');
        } else {
            $erro = "";
        return view::make('home.login', ['erro' => $erro]);
        }
    }

    public function signupPage(){
        if (Session::has('loggedin')) {
            return View::make('home.index');
        } else {
            return View::make('home.signup');
        }
    }

    public function getTop10(){
        //Criação do array para as classificações
        $Top10 = [];
        //Vai buscar todas as classificações
        $all_classifications = Classification::all(array('limit' => 10, 'order' => 'points asc'));

        foreach ($all_classifications as $classification){
            $user = User::find($classification->user_id);
            $username = $user->username;

            $originalDate = $classification->date;
            //$newDate = date("d/m/Y - h:m", strtotime($originalDate));
            //var_dump($originalDate);

            array_push($Top10, (object)[
                'user_id' => $classification->user_id,
                'points' => $classification->points,
                'username' => $username,
                'date' => $originalDate
            ]);
        }
        //die();
        return View::make('home.top', ["leaderboard" => $Top10]);
    }

    public function worksheet(){

        View::attachSubView('titlecontainer', 'layout.pagetitle', ['title' => 'MVC Worksheet']);

        return View::make('home.worksheet');
    }

    public function setsession(){
        $dataObject = MetaArmCoreModel::getComponents();
        Session::set('object', $dataObject);

        Redirect::toRoute('home/worksheet');
    }

    public function showsession(){
        $res = Session::get('object');
        var_dump($res);
    }

    public function destroysession(){

        Session::destroy();
        Redirect::toRoute('home/worksheet');
    }


}