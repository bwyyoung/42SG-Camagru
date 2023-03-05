<?php
namespace Controller;


use Model\Model;
use Model\Table\UserSessionTable;
use PSpell\Config;
use View\Template as Template;
use config\Config_str;
use util\Debug as Debug;
use util\Security as Security;

class RegisterController extends Controller
{
    public function index() : bool
    {
        Security::Block_LoginUser();
        Template::view('register.html', [
            Config_str::KW_TITLE->value => 'Camagru SG Registration',
            Config_str::KW_STATE->value => Config_str::STATE_REGISTRATION->value
        ]);
        return true;
    }

    public function activate() {
        if ($_SERVER["REQUEST_METHOD"] != "GET") {
            header("Location: http://camagru.sg/register");
            return true;
        }

        if (!isset($_GET[Config_str::KW_EMAIL->value]) || !isset($_GET[Config_str::KW_ACTIVATION_CODE->value]))
            return $this->Render_Error_Registration('Invalid Activation.');
        if (Security::attack_sql_injection($_GET[Config_str::KW_EMAIL->value]) || Security::attack_sql_injection($_GET[Config_str::KW_ACTIVATION_CODE->value]))
            return $this->Render_Error_Registration('Invalid Activation.');
        if (!$this->model->set_temp_user(Config_str::KW_EMAIL->value, $_GET[Config_str::KW_EMAIL->value]))
            return $this->Render_Error_Registration('Invalid Activation.');
        if ($this->model->get_temp_user()->verified)
            return $this->Render_Error_Registration('Account already verified.');
    #    $this->model->get_temp_user()->verified = true;
     #   $this->model->get_temp_user()->commit(Model::get_db());
        if (!$this->model->verify_user($_GET[Config_str::KW_ACTIVATION_CODE->value]))
            return $this->Render_Error_Registration('Invalid activation code, please request new code.');
        Template::view('register.html', [
            Config_str::KW_TITLE->value  => 'Activation Success',
            Config_str::KW_STATE->value  => Config_str::STATE_ACTIVATED->value,
            Config_str::KW_MESSAGE->value => 'Congratulations! '.$_GET[Config_str::KW_EMAIL->value].' has been activated. Please login to continue.'
        ]);
    }

    public function check_user_credential() {
        Security::Block_LoginUser();
        $_POST = json_decode(file_get_contents('php://input'), true);
        if (!isset($_POST[Config_str::KW_ID->value]) || !isset($_POST['value']) )
            return Debug::echo_return('error');
        $r = $this->model->check_credential_exists($_POST[Config_str::KW_ID->value], $_POST[Config_str::KW_VALUE->value]);
        return match ($r) {
            1 => Debug::echo_return('found'),
            -1 => Debug::echo_return('invalid'),
            default => Debug::echo_return('not found'),
        };
    }



    public function resend_verification_email () {

        Template::view('register.html', [
            Config_str::KW_TITLE->value => 'Resend Verification Email',
            Config_str::KW_STATE->value => Config_str::STATE_RESEND_VERIFICATION_EMAIL->value
        ]);
    }

    public function resend_verification_email_submit() {

        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header("Location: http://camagru.sg/register");
            return true;
        }
        if (!isset($_POST[Config_str::KW_EMAIL->value]))
            return $this->Render_Error_Registration('Invalid Email.');
        if (!$this->model->set_temp_user(Config_str::KW_EMAIL->value, $_POST[Config_str::KW_EMAIL->value]))
            return $this->Render_Error_Registration('Invalid Email.');
        #if (!UserSessionTable::create_new_session($this->model->get_user()->id(), false))
         #   return $this->Render_Error_Registration('Unable to create new session.');
        if ($this->model->get_temp_user()->verified)
            return $this->Render_Verification_Email_Sent();
        // Generate a token for the email verification link
        if (!$this->model->generate_token(Config_str::KW_VERIFICATION->value))
            return $this->Render_Error_Registration('Unable to generate new token.');
        // Send email
        if (!$this->model->send_verification_email())
            return $this->Render_Error_Registration('Unable to send verification email.');
        $this->Render_Verification_Email_Sent();
    }


    public function register_account() {
        Security::Block_LoginUser();

        if ($_SERVER["REQUEST_METHOD"] != "POST")
            return $this->Render_Error_Registration('Failure to submit credentials.');
        if (count($_POST) == 0 ){
            header('Location: http://'.Config_str::KW_DOMAIN->value.'/register');
            exit();
        }

        // Check duplicates
        if ($this->model->check_credential_exists(Config_str::KW_USERNAME->value, $_POST[Config_str::KW_USERNAME->value]))
            return $this->Render_Error_Registration('Failure to submit: Username already exists.');
        if ($this->model->check_credential_exists(Config_str::KW_EMAIL->value, $_POST[Config_str::KW_EMAIL->value]))
            return $this->Render_Error_Registration('Failure to submit: Email already exists.');

        // Check and Hash password
        if (!Security::verify_password($_POST[Config_str::KW_PASSWORD->value],$_POST[Config_str::KW_PASSWORD->value.'-repeat']))
            return $this->Render_Error_Registration('Failure to submit: Password invalid.');
        if (!Security::verify_username($_POST[Config_str::KW_USERNAME->value]))
            return $this->Render_Error_Registration('Failure to submit: Username invalid.');
        if (!Security::verify_email($_POST[Config_str::KW_EMAIL->value]))
            return $this->Render_Error_Registration('Failure to submit: Email invalid.');

        // Create the User and Persist
        if (!$this->model->register_unverified_user($_POST[Config_str::KW_USERNAME->value],
            $_POST[Config_str::KW_EMAIL->value], $_POST[Config_str::KW_PASSWORD->value]))
            return $this->Render_Error_Registration('Unable to create new user.');
        if (!UserSessionTable::create_new_session($this->model->get_temp_user()->id(), false))
            return $this->Render_Error_Registration('Unable to create new session.');
        // Generate a token for the email verification link
        if (!$this->model->generate_token(Config_str::KW_VERIFICATION->value))
            return $this->Render_Error_Registration('Unable to generate new token.');
        // Send email
        if (!$this->model->send_verification_email())
            return $this->Render_Error_Registration('Unable to send verification email. Please go to this link to resend: http://camagru.sg/register/resend_verification_email');
        $this->Render_Verification_Email_Sent();
    }

    private function Render_Verification_Email_Sent() {
        $message = 'If it was previously registered, we will email '.$_POST[Config_str::KW_EMAIL->value].' to verify your email address and activate your account.';
        Template::view('register.html', [
            Config_str::KW_TITLE->value  => 'Verification Email Sent',
            Config_str::KW_STATE->value  => Config_str::STATE_REGISTERED->value,
            Config_str::KW_MESSAGE->value => $message
        ]);
        unset($_POST);
        return true;
    }

    private function Render_Error_Registration(string $message) {

        Template::view('register.html', [
            Config_str::KW_TITLE->value  => 'Error :(',
            Config_str::KW_STATE->value => Config_str::STATE_ERROR->value,
            Config_str::KW_MESSAGE->value => $message
        ]);
        unset($_POST);
        return true;
    }
}



