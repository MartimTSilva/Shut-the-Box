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
            Session::remove('game');
            return View::make('game.index');
        } else {
            $erro = "Precisa de estar autenticado/a para poder jogar!";
            return view::make('home.login', ['erro' => $erro]);
        }
    }

    public function startGame(){
        $game = new GameEngine();
        $game->startGame();

        $game->updateGameState(1);
        
        Session::set('game', $game);

        return View::make('game.index', ['game' => $game]);
    }

    public function throwDices(){
        $game = Session::get('game');
        
        $game->_board->throwDices();

        Session::set('game', $game);
        return View::make('game.index', ['game' => $game]);
    }

    public function blockNumber($number, $diceSum){
        $blockedNumber = new BlockedNumbers();
        //Enquanto a soma dos dados não forem zero, não é possível acabar a jogada
        do{
            if($blockedNumber->blockNumber($number, $diceSum))
                $diceSum = $diceSum - $number;
                            
        } while (!$blockedNumber->checkPlay($diceSum));
    }
}