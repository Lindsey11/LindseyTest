<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Model\Query;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Model\Manager;

class CustomerController extends Controller
{

    public function indexAction(){
        //Check if user is logged in
        $IsloggedIn = true;//$_SESSION["loggedIN"];

        if(isset($IsloggedIn) && $IsloggedIn == false){
            //Load login page
            $response = new Response();
            return $response->redirect("/LindseyTest/operator/login");
        }else{

            //Fetch all the customers
            $this->view->customers = $this->modelsManager->executeQuery(
                'SELECT Id, Name,Address ,DateCreated ,Balance FROM Customers'
             );

        }
        
    }

    public function createAction(){
        $SuccessState = false;
        $customer = new Customers();
        if ($this->request->getPost()) {
            

            $customer->assign(
                $this->request->getPost(),
                [
                    'Name',
                    'Username',
                    'Address',
                    'Password'
                ]
            );
        }
        $success = false;
        $sql = "INSERT INTO customers (Name, Address, Username,Password,Balance)";
        $sql .= " VALUES ('" . $customer->Name . "','" . $customer->Address . "','" . $customer->Username . "','" . $customer->Password . "' , 0.00)";

        if (isset($customer)) {
            $success =  $this->modelsManager->executeQuery(
                $sql
            );
        }

        if ($success == true) {
            $SuccessState = true;
            return $SuccessState;
        } else {
            $SuccessState = false;
            return $SuccessState; 
        }

    }

    public function deleteAction(){
        $customer = new Customers();
        if ($this->request->getPost()) {
            $customer->assign(
                $this->request->getPost(),
                [
                    'Id'
                ]
            );
            $sql = "DELETE FROM customers where Id = " . $customer->Id;
            $connection = $this->db;
            $data = $connection->query($sql);
            $success = $data->execute();
            
            if ($success == true) {
                $SuccessState = true;
                return $SuccessState;
            } else {
                $SuccessState = false;
                return $SuccessState; 
            }

        }
    }

    public function updateAction(){
        $customer = new Customers();
        $response = new Response();
        if($this->request->getQuery()){
            $customer->assign(
                $this->request->getQuery(),
                [
                    'Id'
                ]
            );

            $sql = "SELECT Id, Name,Address,Username,Password FROM customers where Id = " . $customer->Id;
            $connection = $this->db;
            $data = $connection->query($sql);
            $success = $data->execute();
            $data->setFetchMode(PDO::FETCH_ASSOC);
            $results =$data->fetchAll();
            
            return $response->setJsonContent($results);
        }

    }

    public function editAction(){
        $customer = new Customers();
        $response = new Response();
        if ($this->request->getPost()) {
            
            $customer->assign(
                $this->request->getPost(),
                [
                    'Id',
                    'Name',
                    'Username',
                    'Address',
                    'Password'
                ]
            );
        }
        $success = false;
        $sql = "UPDATE customers SET Name = '" . $customer->Name . "', Address = '" . $customer->Address ."'," . "Password = '" . $customer->Password . "'" ;
        $sql .= " WHERE Id = ". $customer->Id ;
        if (isset($customer)) {
            $connection = $this->db;
            $data = $connection->query($sql);
            $success = $data->execute();
        }

        if( $success == true){
            return $response->setJsonContent($success);
        }else{
            return $response->setJsonContent($success);
        }
        

    }

}
