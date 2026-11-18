<?php
declare(strict_types=1);

namespace App\Controller;


/**
 * GoodsOutStores Controller
 *
 * @property \App\Model\Table\GoodsOutStoresTable $GoodsOutStores
 * @method \App\Model\Entity\GoodsOutStore[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GoodsOutStoresController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */ 
    public function index()
    {
        $this->paginate = [
            'contain' => ['Branches'],
        ];
        $goodsOutStores = $this->paginate($this->GoodsOutStores);

        $this->set(compact('goodsOutStores'));
    }

    /**
     * View method
     *
     * @param string|null $id Goods Out Store id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $goodsOutStore = $this->GoodsOutStores->get($id, [
            'contain' => ['Branches', 'GoodsOutStoreLines.Items'],
        ]);

        $this->set(compact('goodsOutStore'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

     public function get_last_number()
     {
         $dataRows = $this->GoodsOutStores->find('all', [
             'fields' => array('codes' => 'MAX(GoodsOutStores.code)'),
         ])->where(['date' => date('Y-m-d')])->first();
         $code = (!empty($dataRows->code) ? explode("/", $dataRows['code']) : array());
        $dataResult = (isset($code[0]) ? ((date('d-m') != '01-01') ? ($code[0] + 1) : 1 ) : 1);
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = $result . '/ST-OUT/NSI/' . $this->Krs->numToRome(date('m')) . '/' . date('Y');
        return $number;
     }

    public function add()
    {
        $goodsOutStore = $this->GoodsOutStores->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData(); 
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['date']));

            $goodLines = array();
            foreach ($dataRow['goods_out_store_lines'] as $index => $value) {
                $goodLines['goods_out_store_lines'][$index]['item_id'] = $value['item_id'];
                $goodLines['goods_out_store_lines'][$index]['qty'] = $value['qty'];
                $goodLines['goods_out_store_lines'][$index]['qty_out'] = $value['qty'];
                $goodLines['goods_out_store_lines'][$index]['description'] = $this->Krs->nom2Dec($value['description']);
            }

            $goodsOutStore = $this->GoodsOutStores->patchEntity($goodsOutStore, array_merge($dataRow, $dataAuditLog, $date, $goodLines));
            if ($this->GoodsOutStores->save($goodsOutStore)) {
                $this->Flash->success(__('The goods out store has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The goods out store could not be saved. Please, try again.'));
        }
        $branches = $this->GoodsOutStores->Branches->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $data['lastNumber'] = $this->get_last_number();
        $this->set(compact('goodsOutStore', 'branches', 'data'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Goods Out Store id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $goodsOutStore = $this->GoodsOutStores->get($id, [
            'contain' => ['GoodsOutStoreLines.Items', 'Branches'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['date']));

            $goodsOutStore = $this->GoodsOutStores->patchEntity($goodsOutStore, array_merge($dataRow, $dataAuditLog, $date), ['associated' => ['GoodsOutStoreLines' => ['validate' => true]]]);
            if ($this->GoodsOutStores->save($goodsOutStore)) {
                $this->Flash->success(__('The goods out store has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The goods out store could not be saved. Please, try again.'));
        }
        $branches = $this->GoodsOutStores->Branches->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

        $this->loadModel('Items');
        $items = $this->Items->find('all')->where(['Items.branch_id' => $goodsOutStore->branch_id, 'Items.stock >' => 1])->toArray();
        $this->set(compact('goodsOutStore', 'branches', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Goods Out Store id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $goodsOutStore = $this->GoodsOutStores->get($id);
        if ($this->GoodsOutStores->delete($goodsOutStore)) {
            $this->Flash->success(__('The goods out store has been deleted.'));
        } else {
            $this->Flash->error(__('The goods out store could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function getitem()
    {
        $this->autoRender = false;
        $this->loadModel('Branches');
        $this->loadModel('BranchStocks');

        $search = $this->request->getQuery('search');

        $items = $this->Branches->find('all')->where(['OR' => ['name like' => '%' . $search . '%']]);

        $result = array();
        foreach ($items as $key => $data) {
            $result[$key]['id'] = (int) $data['id'];
            $result[$key]['text'] = $data['name'];
        }
        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }

    public function setitem()
    {
        $this->autoRender = false;
        $this->loadModel('Items');
        $items = $this->Items->find('all')->where(['Items.id' => $this->request->getQuery('id')])->first();

        return $this->response->withType("application/json")->withStringBody(json_encode($items));
    }

    public function getretur()
    {
        $this->autoRender = false;
        $this->loadModel('Returs');
        $returs = $this->Returs->find('all')->contain(['ReturLines.OrderLines.ItemLines.Items'])->where(['Returs.code' => $this->request->getQuery('code'), 'Returs.is_active' => 'Y'])->first();

        return $this->response->withType("application/json")->withStringBody(json_encode($returs));
    }
}
