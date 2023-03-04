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
            Config_str::KW_STATE->value => Config_str::STATE_PROFILE->value,
            Config_str::KW_MESSAGE->value => ''
        ]);
        return true;
    }

    public function login() : bool{
        Security::Block_LoginUser();

        if ($_SERVER["REQUEST_METHOD"] != "POST")
            Security::Home();
        if (!isset($_POST[Config_str::KW_PASSWORD->value]) || !isset($_POST[Config_str::KW_USERNAME->value]))
            Security::Home();
        //login function when user clicks login
        // Check and Hash password
        if (Security::attack_sql_injection($_POST[Config_str::KW_PASSWORD->value]) || Security::attack_sql_injection($_POST[Config_str::KW_USERNAME->value]))
            return $this->Render_Error_Login('Invalid Username / Password');
        if (!Security::verify_password($_POST[Config_str::KW_PASSWORD->value], $_POST[Config_str::KW_PASSWORD->value]))
            return $this->Render_Error_Login('Failure to submit: Password invalid.');
        if (!Security::verify_username($_POST[Config_str::KW_USERNAME->value]))
            return $this->Render_Error_Login('Failure to submit: Username invalid.');
        $rememberme = (isset($_POST[Config_str::KW_REMEMBERME->value]) ? 1 : 0);
        $user = UserTable::gettable_keyval(Config_str::KW_USERNAME->value, $_POST[Config_str::KW_USERNAME->value]);
        if ($user === null)
            return $this->Render_Error_Login('Invalid Username / Password');
        if (!password_verify($_POST[Config_str::KW_PASSWORD->value].Security::get_pepper(), $user->password))
            return $this->Render_Error_Login('Invalid Username / Password');
        if (\password_needs_rehash($user->password, \PASSWORD_BCRYPT)) {
            $user->password = \password_hash($_POST[Config_str::KW_PASSWORD->value].Security::get_pepper(), \PASSWORD_ARGON2ID);
            $user->commit(Model::get_db());
        }
        UserSessionTable::create_new_session($user->id(), $rememberme);
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
            Config_str::KW_STATE->value => Config_str::STATE_SETTINGS->value,
            Config_str::KW_MESSAGE->value => ''
        ]);
    }

    public function upload() {
        Security::Block_GuestUser();
        Template::view('account.html', [
            Config_str::KW_TITLE->value  => 'Camagru SG Home Page',
            Config_str::KW_STATE->value => Config_str::STATE_UPLOAD->value,
            Config_str::KW_MESSAGE->value => ''
        ]);
    }

    public function forgotpassword() {
        Security::Block_LoginUser();
        Template::view('account.html', [
            Config_str::KW_TITLE->value  => 'Camagru SG Home Page',
            Config_str::KW_STATE->value => Config_str::STATE_FORGOTPASSWORD->value,
            Config_str::KW_MESSAGE->value => ''
        ]);
    }

    private function Render_Error_Login(string $message)
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