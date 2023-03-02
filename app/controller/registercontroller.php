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
            Config_str::KW_TITLE->value => 'Camagru SG Registration',
            Config_str::KW_STATE->value => Config_str::STATE_DEFAULT->value,
            Config_str::KW_MESSAGE->value => ''
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

    public function resend_verification_email () {
        Template::view('register.html', [
            Config_str::KW_TITLE->value => 'Resend Verification Email',
            Config_str::KW_STATE->value => Config_str::STATE_RESEND_VERIFICATION_EMAIL->value,
            Config_str::KW_MESSAGE->value => ''
        ]);
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
        if (!$this->model->register_unverified_user($_POST[Config_str::KW_USERNAME->value],
            $_POST[Config_str::KW_EMAIL->value], $_POST[Config_str::KW_PASSWORD->value]))
            return $this->Render_Error_Registration('Unable to create new user.');
        if (!$this->model->create_new_session())
            return $this->Render_Error_Registration('Unable to create new session.');
        // Generate a token for the email verification link
        if (!$this->model->generate_token())
            return $this->Render_Error_Registration('Unable to generate new token.');
        // Send email
        if (!$this->model->send_verification_email())
            return $this->Render_Error_Registration('Unable to send verification email.');
        Template::view('register.html', [
            Config_str::KW_TITLE->value  => 'Verify your email',
            Config_str::KW_STATE->value  => Config_str::STATE_REGISTERED->value,
            Config_str::KW_MESSAGE->value => 'We\'ve emailed '.$_POST[Config_str::KW_EMAIL->value].' to verify your email address and activate your account.<br>
            The link in the email will expire in 24 hours. <br>
            If you did not receive your verification email, please <a href="http://camagru.sg/register/resend_verification_email">Click Here.</a>'
        ]);
        unset($_POST);
        return true;
    }

    private function Render_Error_Registration(string $message) {
        Template::view('register.html', [
            Config_str::KW_TITLE->value  => 'Camagru SG Registration',
            Config_str::KW_STATE->value => Config_str::STATE_ERROR->value,
            Config_str::KW_MESSAGE->value => $message
        ]);
        unset($_POST);
        return true;
    }
}



