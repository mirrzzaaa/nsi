<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ReturSupplierLines Controller
 *
 * @property \App\Model\Table\ReturSupplierLinesTable $ReturSupplierLines
 * @method \App\Model\Entity\ReturSupplierLine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReturSupplierLinesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ReturSuppliers', 'PurchasingLines', 'WarehouseStocks', 'BranchStocks'],
        ];
        $returSupplierLines = $this->paginate($this->ReturSupplierLines);

        $this->set(compact('returSupplierLines'));
    }

    /**
     * View method
     *
     * @param string|null $id Retur Supplier Line id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $returSupplierLine = $this->ReturSupplierLines->get($id, [
            'contain' => ['ReturSuppliers', 'PurchasingLines', 'WarehouseStocks', 'BranchStocks'],
        ]);

        $this->set(compact('returSupplierLine'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $returSupplierLine = $this->ReturSupplierLines->newEmptyEntity();
        if ($this->request->is('post')) {
            $returSupplierLine = $this->ReturSupplierLines->patchEntity($returSupplierLine, $this->request->getData());
            if ($this->ReturSupplierLines->save($returSupplierLine)) {
                $this->Flash->success(__('The retur supplier line has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The retur supplier line could not be saved. Please, try again.'));
        }
        $returSuppliers = $this->ReturSupplierLines->ReturSuppliers->find('list', ['limit' => 200]);
        $purchasingLines = $this->ReturSupplierLines->PurchasingLines->find('list', ['limit' => 200]);
        $warehouseStocks = $this->ReturSupplierLines->WarehouseStocks->find('list', ['limit' => 200]);
        $branchStocks = $this->ReturSupplierLines->BranchStocks->find('list', ['limit' => 200]);
        $this->set(compact('returSupplierLine', 'returSuppliers', 'purchasingLines', 'warehouseStocks', 'branchStocks'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Retur Supplier Line id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $returSupplierLine = $this->ReturSupplierLines->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $returSupplierLine = $this->ReturSupplierLines->patchEntity($returSupplierLine, $this->request->getData());
            if ($this->ReturSupplierLines->save($returSupplierLine)) {
                $this->Flash->success(__('The retur supplier line has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The retur supplier line could not be saved. Please, try again.'));
        }
        $returSuppliers = $this->ReturSupplierLines->ReturSuppliers->find('list', ['limit' => 200]);
        $purchasingLines = $this->ReturSupplierLines->PurchasingLines->find('list', ['limit' => 200]);
        $warehouseStocks = $this->ReturSupplierLines->WarehouseStocks->find('list', ['limit' => 200]);
        $branchStocks = $this->ReturSupplierLines->BranchStocks->find('list', ['limit' => 200]);
        $this->set(compact('returSupplierLine', 'returSuppliers', 'purchasingLines', 'warehouseStocks', 'branchStocks'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Retur Supplier Line id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $returSupplierLine = $this->ReturSupplierLines->get($id);
        if ($this->ReturSupplierLines->delete($returSupplierLine)) {
            $this->Flash->success(__('The retur supplier line has been deleted.'));
        } else {
            $this->Flash->error(__('The retur supplier line could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
