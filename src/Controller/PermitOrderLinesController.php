<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PermitOrderLines Controller
 *
 * @property \App\Model\Table\PermitOrderLinesTable $PermitOrderLines
 * @method \App\Model\Entity\PermitOrderLine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PermitOrderLinesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Permits', 'OrderLines'],
        ];
        $permitOrderLines = $this->paginate($this->PermitOrderLines);

        $this->set(compact('permitOrderLines'));
    }

    /**
     * View method
     *
     * @param string|null $id Permit Order Line id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $permitOrderLine = $this->PermitOrderLines->get($id, [
            'contain' => ['Permits', 'OrderLines'],
        ]);

        $this->set(compact('permitOrderLine'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $permitOrderLine = $this->PermitOrderLines->newEmptyEntity();
        if ($this->request->is('post')) {
            $permitOrderLine = $this->PermitOrderLines->patchEntity($permitOrderLine, $this->request->getData());
            if ($this->PermitOrderLines->save($permitOrderLine)) {
                $this->Flash->success(__('The permit order line has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The permit order line could not be saved. Please, try again.'));
        }
        $permits = $this->PermitOrderLines->Permits->find('list', ['limit' => 200]);
        $orderLines = $this->PermitOrderLines->OrderLines->find('list', ['limit' => 200]);
        $this->set(compact('permitOrderLine', 'permits', 'orderLines'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Permit Order Line id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $permitOrderLine = $this->PermitOrderLines->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $permitOrderLine = $this->PermitOrderLines->patchEntity($permitOrderLine, $this->request->getData());
            if ($this->PermitOrderLines->save($permitOrderLine)) {
                $this->Flash->success(__('The permit order line has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The permit order line could not be saved. Please, try again.'));
        }
        $permits = $this->PermitOrderLines->Permits->find('list', ['limit' => 200]);
        $orderLines = $this->PermitOrderLines->OrderLines->find('list', ['limit' => 200]);
        $this->set(compact('permitOrderLine', 'permits', 'orderLines'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Permit Order Line id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $permitOrderLine = $this->PermitOrderLines->get($id);
        if ($this->PermitOrderLines->delete($permitOrderLine)) {
            $this->Flash->success(__('The permit order line has been deleted.'));
        } else {
            $this->Flash->error(__('The permit order line could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
