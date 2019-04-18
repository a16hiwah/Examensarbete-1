<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['logout', 'add']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->redirect(['controller' => 'MyAccount', 'action' => 'overview']);
    }

    /**
     * View method
     *
     * @param string|null $id User username.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($username = null)
    {
        $title = 'User overview';
        $username_search = $username;

        $query = $this->Users->findByUsername($username);
        $query->select(
            [
                'Users.username',
                'Users.biography',
                'Users.created',
                'ProfileImages.img_src'
            ]
        );
        $query->contain(['ProfileImages']);

        if($query->isEmpty()) {
            $query = null;
        }

        $this->set(compact('title', 'username_search', 'query'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $title = 'Create user';
        $this->set(compact('title'));
        
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                return $this->redirect(['action' => 'index']);
            }
        }
        $profileImages = $this->Users->ProfileImages->find('list', ['limit' => 200]);
        $this->set(compact('user', 'profileImages'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $title = 'Edit profile';
        $this->set(compact('title'));

        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($user->biography === '') {
                $user->biography = null;
            }
            if ($this->Users->save($user)) {
                return $this->redirect(['action' => 'index']);
            }
        }
        $profileImages = $this->loadModel('ProfileImages')->find();
        $this->set(compact('user', 'profileImages'));
    }

    public function login()
    {
        $title = 'Sign in';
        $this->set(compact('title'));

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $_SESSION['uid'] = $this->Auth->user('id');
                $_SESSION['user_signed_in'] = true;
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
    }

    public function logout()
    {
        $this->getRequest()->getSession()->destroy();
        return $this->redirect($this->Auth->logout());
    }
}
