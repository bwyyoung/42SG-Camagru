<?php

namespace util;
use core\Init as Init;

class Security
{
    /*
     * Blocking the users who are already logged in, and don't need to see this page.
     * For example: Registration page.
     */
    public static function Block_LoginUser()
    {
        if (!Init::getInstance()->login)
            return;
        header("Location: http://camagru.sg");
        exit();
    }

    /*
     * Block users who are guests from seeing pages like profile page, settings page, etc.
     */
    public static function Block_GuestUser()
    {
        if (Init::getInstance()->login)
            return;
        header("Location: http://camagru.sg");
        exit();
    }

    public static function attack_sql_injection(string $input): bool {
        if (preg_match("/\b(ALTER|CREATE|DELETE|DROP|EXEC(UTE){0,1}|INSERT( +INTO){0,1}|MERGE|SELECT|UPDATE|UNION( +ALL){0,1})\b/",
            strtoupper($input)))
            return true;
        return 0;
    }
}