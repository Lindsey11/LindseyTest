<?php 

use Phalcon\Mvc\Model;

class Customers extends Model{
    public $Id;
    public $name;
    public $Address;
    public $DateCreated;
    public $Username;
    public $Password;
    public $Balance;
}