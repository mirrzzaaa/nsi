<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Trucks Controller
 *
 * @property \App\Model\Table\TrucksTable $Trucks
 * @method \App\Model\Entity\Truck[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrucksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $trucks = $this->paginate($this->Trucks);

        $this->set(compact('trucks'));
    }

    /**
     * View method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $truck = $this->Trucks->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('truck'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $truck = $this->Trucks->newEmptyEntity();
        if ($this->request->is('post')) {
            $truck = $this->Trucks->patchEntity($truck, $this->request->getData());
            if ($this->Trucks->save($truck)) {
                $this->Flash->success(__('The truck has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The truck could not be saved. Please, try again.'));
        }
        $this->set(compact('truck'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $truck = $this->Trucks->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $truck = $this->Trucks->patchEntity($truck, $this->request->getData());
            if ($this->Trucks->save($truck)) {
                $this->Flash->success(__('The truck has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The truck could not be saved. Please, try again.'));
        }
        $this->set(compact('truck'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $truck = $this->Trucks->get($id);
        if ($this->Trucks->delete($truck)) {
            $this->Flash->success(__('The truck has been deleted.'));
        } else {
            $this->Flash->error(__('The truck could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
