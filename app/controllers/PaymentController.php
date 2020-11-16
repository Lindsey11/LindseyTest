<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Model\Query;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Model\Manager;

class PaymentController extends Controller
{
    public function indexAction(){
        
        $InvoiceId = $_GET['InvoiceId'];

        if(isset($InvoiceId)){
            $sql = "SELECT p.Id, p.Amount, p.DateCreated,n.Id FROM payments p LEFT JOIN invoices n on p.InvoiceId = n.Id where p.InvoiceId = " .$InvoiceId;
            $connection = $this->db;
            $data = $connection->query($sql);
            $success = $data->execute();
            $data->setFetchMode(PDO::FETCH_ASSOC);
            $results =$data->fetchAll();
            $this->view->payments = $results;
        }
    }

    public function createAction(){
     
    }

    public function addAction(){
        $payments = new Payments();
        $response = new Response();
        if ($this->request->getPost()) {
            

            $payments->assign(
                $this->request->getPost(),
                [
                    'CustomerId',
                    'Amount',
                    'InvoiceId'
                ]
            );
            $success = false;
            $sql = "INSERT INTO payments (CustomerId,Amount,InvoiceId)";
            $sql .= " VALUES (" . $payments->CustomerId . "," . $payments->Amount . "," . $payments->InvoiceId .")";
            
            if (isset($payments)) {
                $success =  $this->modelsManager->executeQuery(
                    $sql
                );
            }


        if ($success == true) {
            return $response->setJsonContent($success);
        } else {
            return $response->setJsonContent($success);
        }
        }
    }

    
}