<?php
include dirname(__FILE__) . '/../view/template/Template.php';

use config\Config_str;
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
            Debug::print_string($_POST[Config_str::KW_USERNAME->value]);
            Debug::print_string($_POST[Config_str::KW_EMAIL->value]);
            Debug::print_string($_POST['psw']);
            Debug::print_string($_POST['psw-repeat']);
        }

        // Check duplicates
        if ($this->model->check_credential_exists(Config_str::KW_USERNAME->value, $_POST[Config_str::KW_USERNAME->value]))
            return $this->Render_Error_Registration('Failure to submit: Username already exists.');
        if ($this->model->check_credential_exists(Config_str::KW_EMAIL->value, $_POST[Config_str::KW_EMAIL->value]))
            return $this->Render_Error_Registration('Failure to submit: Email already exists.');
        // Check and Hash password
        // Create the User - Persist?
        // Register a new valid session
        // Generate a token for the email verification link
        // Send mail
    }

    private function Render_Error_Registration(string $message) {
        Template::view('register.html', [
            'title' => 'Camagru SG Registration',
            'error' => true,
            'errormessage' => $message
        ]);
        return true;
    }
}



