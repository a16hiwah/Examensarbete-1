<?php

namespace App\Controller;

class ResourcesController extends AppController
{
    public function index()
    {
        $this->redirect('/resources/view/A');
	}
	
	// Show resources based on filter settings set by the user
	public function view($filter)
	{
		$title = 'Resources';
		$this->set(compact('title'));
	}
}