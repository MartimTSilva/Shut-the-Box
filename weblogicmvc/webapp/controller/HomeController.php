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
        $erro = "";
        return view::make('home.login', ['erro' => $erro]);
    }

    public function signupPage(){
        return View::make('home.signup');
    }

    public function getTop10(){
        //Count para as classificações
        $count = 1;
        //Criação do array para as classificações
        $Top10 = [];
        //Vai buscar todas as classificações
        $all_classifications = Classification::all();
        
        //Faz query à BD para ir buscar todas as pontuações ordenadas por pontos
        $mysqli = NEW MySQLi('localhost', 'root', '', 'shutthebox');
        $result = $mysqli->query("SELECT * FROM classifications ORDER BY points ASC");
        
        while($rows = $result->fetch_assoc()){
            if ($count < 11){
                $count++;
                $user = User::find($rows['user_id']);
                $username = $user->username;

                array_push($Top10, (object)[
                    'user_id' => $rows['user_id'],
                    'points' => $rows['points'],
                    'username' => $username
                    //'date' => $classification->date
                ]);
            } 
        }
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