<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Model\Query;
use Phalcon\Http\Request;
use Phalcon\Http\Response;

class IndexController extends Controller
{
    
    public function indexAction(){
        //Check if user is logged in
        $response = new Response();
        $IsloggedIn = $_SESSION["loggedIN"];
        if(isset($IsloggedIn) && $IsloggedIn == false){
            //Load login page
            return $response->redirect("/LindseyTest/operator/login");
        }else{

            //Send user to Customers page
            return $response->redirect("/LindseyTest/customer/");

        }
        
    }
}

?>