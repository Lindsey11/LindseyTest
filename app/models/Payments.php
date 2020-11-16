<?php 
//namespace MyApp\Models;
use Phalcon\Mvc\Model;

class Payments extends Model{
    public $Id;
    public $CustomerId;
    public $Amount;
    Public $InvoiceId;
}