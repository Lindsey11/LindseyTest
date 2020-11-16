<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Model\Query;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Model\Manager;
use MyApp\Models\Operators as ops;
use Phalcon\Di;
//$_SESSION["loggedIN"] = false;

/**
 * @property Manager $modelsManager
 * @property Request $request
 * @property View    $view
 */

class OperatorController extends Controller
{
    public function indexAction()
    {
    }

    public function registerAction()
    {
        $this->view->message = "";

        if ($this->request->getPost()) {
            $operator = new Operators();

            //Fetch values from post
            $operator->assign(
                $this->request->getPost(),
                [
                    'Name',
                    'Username',
                    'Password'
                ]
            );

            $success = false;
            $sql = "INSERT INTO operators (Name, Username, Password)";
            $sql .= " VALUES ('" . $operator->Name . "','" . $operator->Username . "','" . md5($operator->Password) . "')";

            if (isset($operator)) {
                $success =  $this->modelsManager->executeQuery(
                    $sql
                );
            }

            if($success == true){
                $_SESSION["loggedIN"] = true;
                $_SESSION["CurrentOP"] = $operator->Username;
                return $this->dispatcher->forward(["controller" => "customer","action" => "index"]);
            }

            //$this->view->message = $operator->Name;
        }
    }

    public function loginAction()
    {
        if ($this->request->getPost()) {
            $operator = new Operators();

            //Fetch values from post
            $username = $_POST["Username"];
            $password = $_POST["Password"];
            //Check if the user exsits
           
            $sql = "SELECT Name FROM operators where Username = ". "'" . $username . "'" . " AND Password = " . "'" .md5($password) . "'";
           
            $response = new Response();
            $connection = $this->db;
            $data = $connection->query($sql);
            $data->execute();
            $check = $data->fetchAll();

            if(isset($check) && count($check) > 0 ){
                $_SESSION["loggedIN"] = true;
                return $response->redirect("/LindseyTest/customer/");
            }else{
                $this->view->message = "No Operator found with this User Name and Password. Please try again.";
            }
        }
    }
}
