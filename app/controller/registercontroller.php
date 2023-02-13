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

        if(isset($_POST['test']))
            $this->test();

        Template::view('register.html', [
            'title' => 'Camagru SG Registration',
            'error' => false,
            'errormessage' => ''
        ]);
    }

    public function check_user_credential() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        if (!isset($_POST['id']) || !isset($_POST['value']) )
            return Debug::echo_return('error');
        $r = $this->model->check_credential_exists($_POST['id'], $_POST['value']);
        return match ($r) {
            1 => Debug::echo_return('found'),
            -1 => Debug::echo_return('invalid'),
            default => Debug::echo_return('not found'),
        };
    }




    public function register_account() {
        Security::Block_LoginUser();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            Debug::print_string($_POST['username']);
            Debug::print_string($_POST['email']);
            Debug::print_string($_POST['psw']);
            Debug::print_string($_POST['psw-repeat']);
        }
    }
}



