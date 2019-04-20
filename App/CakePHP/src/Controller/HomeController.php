<?php

namespace App\Controller;

class HomeController extends AppController
{
    public function index()
    {
        $title = 'Home';

        $resources = $this->loadModel('Resources');
        $query = $resources
                    ->find()
                    ->select(['Resources.title', 'Resources.slug', 'Resources.created'])
                    ->order(['created' => 'DESC'])
                    ->limit(10);

        if($query->isEmpty()) {
            $query = null;
        }

        $this->set(compact('title', 'query'));
    }
}