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
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
            return View::make('admin.index');
        } else {
            return View::make('home.index');
        }

    }
}