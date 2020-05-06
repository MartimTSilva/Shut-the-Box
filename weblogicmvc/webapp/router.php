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
Router::get('home/login',	'HomeController/login');
Router::get('home/signup',	'HomeController/signup');
Router::get('home/top',	    'HomeController/top');

//Game
Router::get('game/index',	'ShutBoxController/index');

//User
Router::get('user/edit',	'UserController/edit');

//Admin
Router::get('admin/index',	'AdminController/index');

/************** End of URLEncoder Routing Rules ************************************/