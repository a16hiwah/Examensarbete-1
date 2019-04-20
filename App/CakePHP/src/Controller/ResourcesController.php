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

        $query = $this->Resources->findBySlug($slug);
        $query->contain(['Users' => ['ProfileImages'], 'Comments' => ['Users']]);

        $this->set(compact('title', 'query'));
    }

    /**
     * Search method
     *
     * @return \Cake\Http\Response|void
     */
    public function search()
    {
        $searchTerm = ($_POST['search-box'] !== '') ? $_POST['search-box'] : null;
        
        if ($searchTerm !== null) {
            $title = 'Search results';

            $query = $this->Resources->find('all', [
                'conditions' => ['Resources.title LIKE ' => '%'.$searchTerm.'%'],
                'order' => ['Resources.title ASC']
            ]);

            if($query->isEmpty()) {
                $query = null;
            }

            $this->set(compact('title', 'query'));

        } else { // Go back to previous page if search box is empty
            $this->redirect($this->referer());
        }
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
     * @param string|null $resrc_id Resource user_id.
     * @return \Cake\Http\Response|null Redirects on successful edit, or if user is not allowed to edit.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null, $resrc_uid = null)
    {
        // Only allow users to edit their own resources
        if ($resrc_uid == $this->Auth->user('id')) {
            $resource = $this->Resources->get($id);

            if ($this->request->is(['patch', 'post', 'put'])) {
                $resource = $this->Resources->patchEntity($resource, $this->request->getData());
                if ($this->Resources->save($resource)) {
                    return $this->redirect('/my-account/my-resources');
                }
            }
            
            $this->set(compact('resource'));
            
        } else {
            return $this->redirect('/my-account/my-resources');
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Resource id.
     * @param string|null $resrc_id Resource user_id.
     * @return \Cake\Http\Response|null Redirects to my-account/my-resources.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $resrc_uid = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        if ($resrc_uid == $this->Auth->user('id')) {
            $resource = $this->Resources->get($id);
            
            if ($this->Resources->delete($resource)) {
                return $this->redirect('/my-account/my-resources');
            }
        }
        
    }
}
