<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function lupaPassword()
    {
        return view('auth.lupa-password');
    }
}
