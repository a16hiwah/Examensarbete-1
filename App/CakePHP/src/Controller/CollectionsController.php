<?php

namespace App\Controller;

class CollectionsController extends AppController
{
    public function index()
    {
        $title = 'Collections';
        $this->set(compact('title'));
    }
}