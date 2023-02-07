<?php
use Model\Model;

class UserModel extends Model {
    protected $id;
    protected $username;
    protected $email;

    public function get_id() {
        return $this->id;
    }

    public function get_username() {
        return $this->username;
    }

    public function  get_email() {
        return $this->email;
    }

    public function set_username(string $username) {
        $this->username = $username;
    }

    public function set_email(string $email) {
        $this->email = $email;
    }
}