<?php
/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 02-05-2016
 * Time: 11:18
 */
use ArmoredCore\Facades\Router;

/****************************************************************************
 *  URLEncoder/HTTPRouter Routing Rules
 *  Use convention: controllerName@methodActionName
 ****************************************************************************/

//Home
Router::get('/',			'HomeController/index');
Router::get('home/',		'HomeController/index');
Router::get('home/index',	'HomeController/index');
Router::get('home/signup',	'HomeController/signup');

//Register
Router::Get('home/signup' ,'HomeController/signupPage');
Router::Post('home/signup' ,'UserController/registerUser');

//Login
Router::get('home/login',	'HomeController/loginPage');
Router::post('home/login',	'UserController/loginUser');

//Logout
Router::get('home/', 'UserController/logoutUser');

//UserPage
Router::get('user/edit', 'UserController/editPage');
Router::post('user/update', 'UserController/updateUserDetails');

//Admin
Router::get('admin/index',	'AdminController/index');

//Leaderboard
Router::get('home/top',	    'HomeController/getTop10');

//Game
Router::get('game/index',	'ShutBoxController/index');
Router::get('game/startGame',	'ShutBoxController/startGame');
Router::get('game/blockNumber',	'ShutBoxController/blockNumber');


/************** End of URLEncoder Routing Rules ************************************/