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
Router::get('home/top',	    'HomeController/top');

//Register
Router::Get('home/signup' ,'HomeController/signupPage');
Router::Post('home/signup' ,'UserController/registerUser');

//Login
Router::get('home/login',	'HomeController/loginPage');
Router::post('home/login',	'UserController/loginUser');

//Logout
Router::get('home/', 'UserController/logoutUser');

//Game
Router::get('game/index',	'ShutBoxController/index');

//User
Router::get('user/edit',	'UserController/edit');

//Admin
Router::get('admin/index',	'AdminController/index');

/************** End of URLEncoder Routing Rules ************************************/