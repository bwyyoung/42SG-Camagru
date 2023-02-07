<?php
use Model\Model;

/** Autoloading The required Classes **/
class RegisterModel extends Model
{
    function __construct(){
        parent::__construct();
        $this->connect();
    }
}
