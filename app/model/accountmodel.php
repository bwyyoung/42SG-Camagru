<?php

namespace Model;
include_once 'table/usersessiontable.php';


use config\Config_str;
use Model\Table\UserSessionTable;
use Model\Table\UserTable;
use util\Email;
use util\Security;

class AccountModel extends Model {

    public function login($username, $password, $rememberme) : bool {
        $user = UserTable::gettable_keyval(Config_str::KW_USERNAME->value, $username);
        if ($user === null)
            return false;
        if (!password_verify($password.Security::get_pepper(), $user->password))
            return false;
        if (\password_needs_rehash($user->password, \PASSWORD_BCRYPT)) {
            $user->password = \password_hash($_POST[Config_str::KW_PASSWORD->value].Security::get_pepper(), \PASSWORD_ARGON2ID);
            $user->commit(Model::get_db());
        }
        return (UserSessionTable::create_new_session($user->id(), $rememberme));
    }
    public function logout(): bool {
        return UserSessionTable::deletetable_keyval(Config_str::KW_SESSION->value, session_id());
    }
    public function send_password_email() : bool {
        return Email::send_password_email($this->temp_user->username, $this->temp_user->email, $this->temp_token->token());
    }
    public function send_verification_email() : bool {
        return Email::send_activation_email($this->temp_user->username, $this->temp_user->email, $this->temp_token->token());
    }

    public function token_password($user, $token) : bool {
        if (!$this->verify_token($user, $token, Config_str::KW_PASSWORD->value))
            return false;
        $this->delete_token($user);
        return true;
    }

    public function change_password($user, $password) : bool {
        $user->password = password_hash($password.Security::get_pepper(), \PASSWORD_ARGON2ID);;
        $user->commit(static::$db);
        return true;
    }
}