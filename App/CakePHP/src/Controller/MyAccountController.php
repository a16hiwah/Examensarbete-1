<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;

class MyAccountController extends AppController
{
    public function overview()
    {
        $users = $this->loadModel('Users');
        $user = $users->get($this->Auth->user('id'), [
            'contain' => ['ProfileImages']
        ]);

        $title = 'Overview';
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
}