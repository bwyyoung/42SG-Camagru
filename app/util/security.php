<?php

namespace util;
use config\Config_str;
use core\Init as Init;

class Security
{
    /*
     * Blocking the users who are already logged in, and don't need to see this page.
     * For example: Registration page.
     */
    public static function Home() {
        header("Location: http://".Config_str::KW_DOMAIN->value);
        exit();
    }

    public static function password_hash($password) : string {
        return password_hash($password.Security::get_pepper(), \PASSWORD_ARGON2ID,
            ["memory_cost" => 19456, "time_cost" => 2, "threads" => 1] );
    }

    public static function Block_LoginUser()
    {
        if (!Init::getInstance()->login)
            return;
        self::Home();
    }

    public static function get_pepper(): string {
        return getenv('WEBSITE_PEPPER');
    }

    /*
     * Block users who are guests from seeing pages like profile page, settings page, etc.
     */
    public static function Block_GuestUser()
    {
        if (Init::getInstance()->login)
            return;
        self::Home();
    }

    public static function attack_sql_injection(string $input): bool {
        if (preg_match("/\b(ALTER|CREATE|DELETE|DROP|EXEC(UTE){0,1}|INSERT( +INTO){0,1}|MERGE|SELECT|UPDATE|UNION( +ALL){0,1})\b/",
            strtoupper($input)))
            return true;
        return 0;
    }

    public static function verify_password($password, $confirmpassword): bool {
        if ($password !== $confirmpassword)
            return false;
        if (self::attack_sql_injection($password))
            return false;
        #Debug::print_string('1 [a-z]');
        if (preg_match_all('/[a-z]/', $password) == 0)
            return false;
        #Debug::print_string('2 [A-Z]');
        if (preg_match_all('/[A-Z]/', $password) == 0)
            return false;
        #Debug::print_string('3 [0-9]');
        if (preg_match_all('/[0-9]/', $password) == 0)
            return false;
        #Debug::print_string('4 \s');
        if (preg_match_all('/\s/', $password) > 0)
            return false;
        #Debug::print_string('5 [#$%@^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]');
        if (preg_match_all('/[#$%@^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $password) == 0)
            return false;
        #Debug::print_string('6 <8 >100');
        if (strlen($password) < 8)
            return false;
        if (strlen($password) > 100)
            return false;
        return true;
    }

    public static function verify_username($username): bool {
        if (self::attack_sql_injection($username))
            return false;
        if (preg_match_all('/\s/', $username) > 0)
            return false;
        if (strlen($username) < 3)
            return false;
        if (strlen($username) > 25)
            return false;
        return true;
    }

    public static function verify_email($email): bool {
        if (self::attack_sql_injection($email))
            return false;
        if (preg_match_all('/\s/', $email) > 0)
            return false;
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}