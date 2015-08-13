<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Vacancies Controller
 *
 * @property \App\Model\Table\VacanciesTable $Vacancies
 */
class VacanciesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories', 'Users']
        ];
        $this->set('vacancies', $this->paginate($this->Vacancies));
        $this->set('_serialize', ['vacancies']);
    }

    public function home()
    {
        $this->paginate = [
            'contain' => ['Categories', 'Users','Tags']
        ];
        $this->set('vacancies', $this->paginate($this->Vacancies));
        $this->set('_serialize', ['vacancies']);
    }

    /**
     * View method
     *
     * @param string|null $id Vacancy id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vacancy = $this->Vacancies->get($id, [
            'contain' => ['Categories', 'Users', 'Tags', 'Applications']
        ]);
        $this->set('vacancy', $vacancy);
        $this->set('_serialize', ['vacancy']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $vacancy = $this->Vacancies->newEntity();
        if ($this->request->is('post')) {
            $vacancy = $this->Vacancies->patchEntity($vacancy, $this->request->data);
            $vacancy->user_id = $this->Auth->user('id');
            if ($this->Vacancies->save($vacancy)) {
                $this->Flash->success(__('The vacancy has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The vacancy could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Vacancies->Categories->find('list', ['limit' => 200]);
        $users = $this->Vacancies->Users->find('list', ['limit' => 200]);
        $tags = $this->Vacancies->Tags->find('list', ['limit' => 200]);
        $this->set(compact('vacancy', 'categories', 'users', 'tags'));
        $this->set('_serialize', ['vacancy']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Vacancy id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $vacancy = $this->Vacancies->get($id, [
            'contain' => ['Tags']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vacancy = $this->Vacancies->patchEntity($vacancy, $this->request->data);
            if ($this->Vacancies->save($vacancy)) {
                $this->Flash->success(__('The vacancy has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The vacancy could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Vacancies->Categories->find('list', ['limit' => 200]);
        $users = $this->Vacancies->Users->find('list', ['limit' => 200]);
        $tags = $this->Vacancies->Tags->find('list', ['limit' => 200]);
        $this->set(compact('vacancy', 'categories', 'users', 'tags'));
        $this->set('_serialize', ['vacancy']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Vacancy id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vacancy = $this->Vacancies->get($id);
        if ($this->Vacancies->delete($vacancy)) {
            $this->Flash->success(__('The vacancy has been deleted.'));
        } else {
            $this->Flash->error(__('The vacancy could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['home']);
    }

    public function isAuthorized($user)
    {
        if (in_array($this->request->action, ['add','edit','delete'])) {
            return true;
        }
        return parent::isAuthorized($user);
    }


}
