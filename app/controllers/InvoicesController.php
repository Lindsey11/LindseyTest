<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Model\Query;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Model\Manager;

class InvoicesController extends Controller
{
    public $invoiceID = 0;
    public function indexAction(){
        $invoices = new Invoices();
        
        $customerID = $_GET['Id'];

        if(isset($customerID)){
            $sql = "SELECT n.Id, c.Name,n.Description, n.DateCreated , n.Amount FROM invoices n LEFT JOIN customers c on n.CustomerId = c.Id where n.CustomerId = " .$customerID;
            $connection = $this->db;
            $data = $connection->query($sql);
            $success = $data->execute();
            $data->setFetchMode(PDO::FETCH_ASSOC);
            $results =$data->fetchAll();
            $this->view->invoices = $results;
        }
    }

    public function createAction(){
        $SuccessState = false;
        $invoices = new Invoices();
        $response = new Response();
        if ($this->request->getPost()) {
            

            $invoices->assign(
                $this->request->getPost(),
                [
                    'CustomerId',
                    'Description',
                    'Amount'
                ]
            );
            $success = false;
        $sqlins = "INSERT INTO invoices (CustomerId, Description, Amount)";
        $sqlins .= " VALUES (" . $invoices->CustomerId . ",'" . $invoices->Description . "','" . $invoices->Amount ."')";
        
        if (isset($invoices)) {
            $success =  $this->modelsManager->executeQuery(
                $sqlins
            );
        }

        
            $connection1 = $this->db;
            //Get the id 
            $getId = "SELECT LAST_INSERT_ID();";
            $data = $connection1->query($getId);
            $success2 = $data->execute();
            $invoiceID =$data->fetchAll();

        if ($success == true) {
            return $response->setJsonContent($invoiceID[0][0]);
        } else {
            return $response->setJsonContent($success);
        }
        }
        
    }

    public function itemsAction()
    {

        $SuccessState = false;
        $invoiceslines = new Invoicelines();
        $response = new Response();
        if ($this->request->getPost()) {


            $invoiceslines->assign(
                $this->request->getPost(),
                [
                    'InvoiceId',
                    'Description',
                    'Amount'
                ]
            );
            $success = false;
            $sql = "INSERT INTO invoicelines (InvoiceId, Description, Amount)";
            $sql .= " VALUES ('" . $invoiceslines->InvoiceId . "','" . $invoiceslines->Description . "'," . $invoiceslines->Amount . ")";
            $connection = $this->db;
            $data = $connection->query($sql);
            $success = $data->execute();

            if ($success == true) {
                return $response->setJsonContent($success);
            } else {
                $SuccessState = false;
                return $SuccessState;
            }
        }
    }

    public function getitemsAction(){
        $invoiceslines = new Invoicelines();
        $response = new Response();

        if($this->request->getQuery()){
            $invoiceslines->assign(
                $this->request->getQuery(),
                [
                    'Id'
                ]
            );

            $sql = "SELECT Description,Amount FROM invoicelines where InvoiceId = " . $invoiceslines->Id;
            $connection = $this->db;
            $data = $connection->query($sql);
            $success = $data->execute();
            $data->setFetchMode(PDO::FETCH_ASSOC);
            $results =$data->fetchAll();
            
            return $response->setJsonContent($results);
        }
    }
}