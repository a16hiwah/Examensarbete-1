<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Resources Controller
 *
 * @property \App\Model\Table\ResourcesTable $Resources
 *
 * @method \App\Model\Entity\Resource[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ResourcesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['view', 'open']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->redirect('/resources/view/a');
    }

    /**
     * View method
     *
     * @param string|null $filter Title LIKE %filter.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($filter)
    {
        $title = 'Resources - '.$filter;

        if ($filter === '0-9')
		{
            $query = $this->Resources->find('all', [
                'conditions' => ['Resources.title REGEXP "^[0-9]"'],
                'order' => ['Resources.title ASC']
            ]);
		}
		else
		{
            $query = $this->Resources->find('all', [
                'conditions' => ['Resources.title LIKE ' => $filter.'%'],
                'order' => ['Resources.title ASC']
            ]);

            // Alternative syntax
			// $query = $this->Resources->find('all')
            //     ->where(['Resources.title LIKE ' => $filter.'%']);
        }
        
        if($query->isEmpty()) {
            $query = null;
        }
        
        $this->set(compact('title', 'query'));
    }

    /**
     * Open method
     *
     * @param string|null $slug Resource slug.
     * @return \Cake\Http\Response|void
     */
    public function open($slug)
    {
        $title = 'Resource - opened';
        $show_create_comment = (isset($_SESSION['user_signed_in'])) ? true : false;

        $query = $this->Resources->findBySlug($slug);
        $query->contain(['Users' => ['ProfileImages']]);

        $this->set(compact('title', 'show_create_comment', 'query'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $title = 'Create resource';

        $resource = $this->Resources->newEntity();
        if ($this->request->is('post')) {
            $resource = $this->Resources->patchEntity($resource, $this->request->getData());
            $resource->user_id = $this->Auth->user('id');

            if ($this->Resources->save($resource)) {
                return $this->redirect('/my-account/my-resources');
            }
        }
        $this->set(compact('title', 'resource'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Resource id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $resource = $this->Resources->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $resource = $this->Resources->patchEntity($resource, $this->request->getData());
            if ($this->Resources->save($resource)) {
                $this->Flash->success(__('The resource has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The resource could not be saved. Please, try again.'));
        }
        $users = $this->Resources->Users->find('list', ['limit' => 200]);
        $this->set(compact('resource', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Resource id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $resource = $this->Resources->get($id);
        if ($this->Resources->delete($resource)) {
        }

        return $this->redirect(['action' => 'index']);
    }
}
