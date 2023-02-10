<?php
include dirname(__FILE__) . '/../view/template/Template.php';
use core\Init as Init;
use util\Debug as Debug;
use util\Security as Security;

class RegisterController extends Controller
{
    public function index()
    {
        Security::Block_LoginUser();
        Template::view('register.html', [
            'title' => 'Camagru SG Registration',
            'error' => false,
            'errormessage' => ''
        ]);
    }

    public function register_account() {
        Security::Block_LoginUser();

        $this->model->connect();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            Debug::print_string($_POST['username']);
            Debug::print_string($_POST['email']);
            Debug::print_string($_POST['psw']);
            Debug::print_string($_POST['psw-repeat']);
        }
    }
}



