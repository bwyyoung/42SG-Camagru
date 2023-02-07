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
}