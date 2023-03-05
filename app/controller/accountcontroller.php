<?php

namespace Controller;

use config\Config_str;
use http\Client\Curl\User;
use Model\Model;
use Model\Table\UserSessionTable;
use Model\Table\UserTable;
use PSpell\Config;
use util\Debug;
use util\Security;
use View\Template as Template;

class AccountController extends Controller
{
    public function index() : bool {
        // Show the user profile page.
        Template::view('account.html', [
            Config_str::KW_TITLE->value  => 'Camagru SG Home Page',
            Config_str::KW_STATE->value => Config_str::STATE_PROFILE->value
        ]);
        return true;
    }

    public function login() : bool{
        Security::Block_LoginUser();
        $rememberme = (isset($_POST[Config_str::KW_REMEMBERME->value]) ? 1 : 0);
        if ($_SERVER["REQUEST_METHOD"] != "POST")
            Security::Home();
        if (!isset($_POST[Config_str::KW_PASSWORD->value]) || !isset($_POST[Config_str::KW_USERNAME->value]))
            Security::Home();
        //login function when user clicks login
        // Check and Hash password
        if (!Security::verify_password($_POST[Config_str::KW_PASSWORD->value], $_POST[Config_str::KW_PASSWORD->value]))
            return $this->Render_Error_Account('Failure to submit: Password invalid.');
        if (!Security::verify_username($_POST[Config_str::KW_USERNAME->value]))
            return $this->Render_Error_Account('Failure to submit: Username invalid.');
        if (!$this->model->login($_POST[Config_str::KW_USERNAME->value], $_POST[Config_str::KW_PASSWORD->value], $rememberme))
            return $this->Render_Error_Account('Invalid Username / Password');
        Security::Home();
        return true;
    }

    public function logout () {
        //logout function that can be called anywhere, logging out the user.
        Security::Block_GuestUser();
        $this->model->logout();
        Security::Home();
        return true;
    }

    public function settings() {
        Security::Block_GuestUser();
        Template::view('account.html', [
            Config_str::KW_TITLE->value  => 'Camagru SG Home Page',
            Config_str::KW_STATE->value => Config_str::STATE_SETTINGS->value
        ]);
    }

    public function upload() {
        Security::Block_GuestUser();
        Template::view('account.html', [
            Config_str::KW_TITLE->value  => 'Camagru SG Home Page',
            Config_str::KW_STATE->value => Config_str::STATE_UPLOAD->value
        ]);
    }

    public function forgot_password() {
        Security::Block_LoginUser();
        Template::view('account.html', [
            Config_str::KW_TITLE->value  => 'Camagru SG Home Page',
            Config_str::KW_STATE->value => Config_str::STATE_FORGOTPASSWORD->value
        ]);
    }

    public function forgot_password_submit() {
        Security::Block_LoginUser();
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header("Location: http://camagru.sg/account/forgot_password");
            return true;
        }
        if (!isset($_POST[Config_str::KW_EMAIL->value]))
            return $this->Render_Error_Account('Invalid Email.');
        if (!$this->model->set_temp_user(Config_str::KW_EMAIL->value, $_POST[Config_str::KW_EMAIL->value]))
            return $this->Render_Error_Account('Invalid Email.');
        if (!$this->model->generate_token(Config_str::KW_PASSWORD->value))
            return $this->Render_Error_Account('Unable to generate new token.');
        if (!$this->model->send_password_email())
            return $this->Render_Error_Account('Unable to send verification email.');
        $this->Render_ForgotPassword_Email_Sent();
    }

    public function reset_password()
    {
        Security::Block_LoginUser();
        if ($_SERVER["REQUEST_METHOD"] != "GET") {
            header("Location: http://camagru.sg/register");
            return true;
        }
        if (!isset($_GET[Config_str::KW_EMAIL->value]) || !isset($_GET[Config_str::KW_ACTIVATION_CODE->value]))
            return $this->Render_Error_Account('Invalid Reset Password.');
        if (Security::attack_sql_injection($_GET[Config_str::KW_EMAIL->value]) || Security::attack_sql_injection($_GET[Config_str::KW_ACTIVATION_CODE->value]))
            return $this->Render_Error_Account('Invalid Reset Password.');
    }

    private function Render_ForgotPassword_Email_Sent() {
        $message = 'If it was previously registered, we will email '.$_POST[Config_str::KW_EMAIL->value].' to reset your password.';
        Template::view('account.html', [
            Config_str::KW_TITLE->value  => 'Reset Password Email Sent',
            Config_str::KW_STATE->value  => Config_str::STATE_FORGOTPASSWORD_SUBMIT->value,
            Config_str::KW_MESSAGE->value => $message
        ]);
        unset($_POST);
        return true;
    }

    private function Render_Error_Account(string $message)
    {
        unset($_POST);
        Template::view('index.html', [
            Config_str::KW_TITLE->value  => 'Camagru SG Home Page',
            Config_str::KW_STATE->value => Config_str::STATE_ERROR->value,
            Config_str::KW_MESSAGE->value => $message
        ]);
        return true;
    }


}