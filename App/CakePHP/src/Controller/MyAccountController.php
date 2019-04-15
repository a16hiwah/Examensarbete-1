<?php

namespace App\Controller;

class MyAccountController extends AppController
{
    public function index()
    {
        $title = 'My account';
        $this->set(compact('title'));
    }
}