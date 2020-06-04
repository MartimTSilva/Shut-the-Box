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
        
        //Guarda os números bloqueados da ronda anterior
        if (!empty($game->_board->_blockedNumbersP1->_numBlockCurrentPlay)) {
            $game->_board->_blockedNumbersP1->saveBlockedNumbers();
        } else if (!empty($game->_board->_blockedNumbersP2->_numBlockCurrentPlay)) {
            $game->_board->_blockedNumbersP2->saveBlockedNumbers();
        }
        
        //Lança novos dados
        $game->_board->throwDices();

        //Vê se é possivel jogar com os dados calhados
        //Se for o jogador 1 a jogar
        if ($game->getGameState() == 1 || $game->getGameState() == 2){
            //Se NÃO for a última jogada, muda de estado para que o P1 possa bloquear números
            if (!$game->_board->checkFinalPlayP1($game->_board->_resultDice1 + $game->_board->_resultDice2)){
                $game->updateGameState(2);
            } else {
                //Muda para o 2 jogador
                $game->updateGameState(3);

                //Remove os dados do jogador 1
                $game->_board->_resultDice1 = null;
                $game->_board->_resultDice2 = null;

                //Calcula os pontos do jogador 1
                $_P1_SumPoints = $game->_board->_blockedNumbersP1->getFinalPointsSum();
                Session::set('P1_sumPoints', 45 - $_P1_SumPoints);
            }
        }
        //Se for o jogador 2 a jogar
        else if ($game->getGameState() == 3 || $game->getGameState() == 4){
            if (!$game->_board->checkFinalPlayP2($game->_board->_resultDice1 + $game->_board->_resultDice2)){
                $game->updateGameState(4);
            } else {
                //Acaba o jogo
                $game->updateGameState(5);

                //Calcula os pontos do jogador 2
                $_P2_SumPoints = $game->_board->_blockedNumbersP2->getFinalPointsSum();
                Session::set('P2_sumPoints', 45 - $_P2_SumPoints);
            }
        } else if ($game->getGameState() == 5){

        }

        Session::set('game', $game);
        return View::make('game.index', ['game' => $game]);
    }

    public function blockNumber($number){
        $game = Session::get('game');

        if ($game->getGameState() == 2) {
            //Jogador 1 a jogar
            if ($game->_board->_blockedNumbersP1->blockNumber($number, $game)){
                //Se consegui bloquear então subtrai a soma dos dados
                $game->_board->_diceSum = $game->_board->_diceSum - $number;
            }
        } else if ($game->getGameState() == 4) {
            //Jogador 2 a jogar
            if ($game->_board->_blockedNumbersP2->blockNumber($number, $game)){
                $game->_board->_diceSum = $game->_board->_diceSum - $number;
            }
        }

        Session::set('game', $game);

        return View::make('game.index', ['game' => $game]);
    }
}