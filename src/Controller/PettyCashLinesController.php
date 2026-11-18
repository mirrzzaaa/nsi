<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PettyCashLines Controller
 *
 * @property \App\Model\Table\PettyCashLinesTable $PettyCashLines
 * @method \App\Model\Entity\PettyCashLine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PettyCashLinesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['PettyCashes'],
        ];
        $pettyCashLines = $this->paginate($this->PettyCashLines);

        $this->set(compact('pettyCashLines'));
    }

    /**
     * View method
     *
     * @param string|null $id Petty Cash Line id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pettyCashLine = $this->PettyCashLines->get($id, [
            'contain' => ['PettyCashes'],
        ]);

        $this->set(compact('pettyCashLine'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pettyCashLine = $this->PettyCashLines->newEmptyEntity();
        if ($this->request->is('post')) {
            $pettyCashLine = $this->PettyCashLines->patchEntity($pettyCashLine, $this->request->getData());
            if ($this->PettyCashLines->save($pettyCashLine)) {
                $this->Flash->success(__('The petty cash line has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The petty cash line could not be saved. Please, try again.'));
        }
        $pettyCashes = $this->PettyCashLines->PettyCashes->find('list', ['limit' => 200]);
        $this->set(compact('pettyCashLine', 'pettyCashes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Petty Cash Line id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pettyCashLine = $this->PettyCashLines->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pettyCashLine = $this->PettyCashLines->patchEntity($pettyCashLine, $this->request->getData());
            if ($this->PettyCashLines->save($pettyCashLine)) {
                $this->Flash->success(__('The petty cash line has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The petty cash line could not be saved. Please, try again.'));
        }
        $pettyCashes = $this->PettyCashLines->PettyCashes->find('list', ['limit' => 200]);
        $this->set(compact('pettyCashLine', 'pettyCashes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Petty Cash Line id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pettyCashLine = $this->PettyCashLines->get($id);
        if ($this->PettyCashLines->delete($pettyCashLine)) {
            $this->Flash->success(__('The petty cash line has been deleted.'));
        } else {
            $this->Flash->error(__('The petty cash line could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
