<?php

namespace Controller;

class AccountController extends Controller
{
    public function index() : bool {
        // Show the user profile page.

        return true;
    }

    public function login() : bool{
        //login function when user clicks login

        return true;
    }

    public function logout () {
        //logout function that can be called anywhere, logging out the user.

        return true;
    }
}