<?php
namespace Controller;


use Model\Table\UserSessionTable;
use View\Template as Template;
use config\Config_str;
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

        if ($_SERVER["REQUEST_METHOD"] != "POST")
            return $this->Render_Error_Registration('Failure to submit credentials.');
        if (count($_POST) == 0 ){
            header('Location: http://'.Config_str::KW_DOMAIN->value.'/register');
            exit();
        }
        Debug::print_string($_POST[Config_str::KW_USERNAME->value]);
        Debug::print_string($_POST[Config_str::KW_EMAIL->value]);
        Debug::print_string($_POST[Config_str::KW_PASSWORD->value]);
        Debug::print_string($_POST[Config_str::KW_PASSWORD->value.'-repeat']);

        // Check duplicates
        if ($this->model->check_credential_exists(Config_str::KW_USERNAME->value, $_POST[Config_str::KW_USERNAME->value]))
            return $this->Render_Error_Registration('Failure to submit: Username already exists.');
        if ($this->model->check_credential_exists(Config_str::KW_EMAIL->value, $_POST[Config_str::KW_EMAIL->value]))
            return $this->Render_Error_Registration('Failure to submit: Email already exists.');
        // Check and Hash password
        if (!$this->model->verify_password($_POST[Config_str::KW_PASSWORD->value],$_POST[Config_str::KW_PASSWORD->value.'-repeat']))
            return $this->Render_Error_Registration('Failure to submit: Password invalid.');

        // Create the User and Persist
        $this->model->register_unverified_user($_POST[Config_str::KW_USERNAME->value],
            $_POST[Config_str::KW_EMAIL->value], $_POST[Config_str::KW_PASSWORD->value]);
        $this->model->create_new_session();
        // Generate a token for the email verification link
        $this->model->generate_token();
        // Send email
        $this->model->send_verification_email();

    }

    private function Render_Error_Registration(string $message) {
        Template::view('register.html', [
            'title' => 'Camagru SG Registration',
            'error' => true,
            'errormessage' => $message
        ]);
        unset($_POST);
        return true;
    }
}



