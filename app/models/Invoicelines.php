<?php 

use Phalcon\Mvc\Model;

class Invoicelines extends Model{
    public $Id;
    public $InvoiceId;
    public $Description;
    public $DateCreated;
    public $Amount;
}