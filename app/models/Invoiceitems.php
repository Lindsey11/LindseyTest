<?php 
//namespace MyApp\Models;
use Phalcon\Mvc\Model;

class Invoices extends Model{
    public $Id;
    public $InvoiceId;
    public $Description;
    public $DateCreated;
    public $Amount;
}