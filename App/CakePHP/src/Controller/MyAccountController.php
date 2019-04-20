<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;

class MyAccountController extends AppController
{
    public function overview()
    {
        $title = 'Overview';
        
        $users = $this->loadModel('Users');
        $user = $users->get($this->Auth->user('id'), [
            'contain' => ['ProfileImages']
        ]);

        $uid = $this->Auth->user('id');
        $username = $this->Auth->user('username');
        $profile_img = $user->profile_image->img_src;
        $biography = $user->biography;
        $created = substr(
            $this->Auth->user('created')->i18nFormat('yyyy-MM-dd HH:mm:ss'),
            0,
            10
        );
        
        $this->set(compact(
            'title',
            'uid',
            'username',
            'profile_img',
            'biography',
            'created'
        ));
    }

    public function myResources()
    {
        $title = 'My Resources';

        $resources = $this->loadModel('Resources');
        $query = $resources->find('all', [
            'conditions' => ['Resources.user_id' => $this->Auth->user('id')]
        ]);

        if($query->isEmpty()) {
            $query = null;
        }

        $this->set(compact('title', 'query'));
    }

    public function myCollections()
    {
        $title = 'My Collections';
        $this->set(compact(
            'title'
        ));
    }

    public function myComments()
    {
        $title = 'My Comments';

        $comments = $this->loadModel('Comments');
        $query = $comments->find(
            'all', [
            'contain' => ['Resources'],
            'conditions' => ['Comments.user_id' => $this->Auth->user('id')]
        ]);

        if($query->isEmpty()) {
            $query = null;
        }

        $this->set(compact('title', 'query'));
    }

}