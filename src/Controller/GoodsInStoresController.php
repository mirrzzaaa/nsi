<?php

declare(strict_types=1);

namespace App\Controller;

// export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Cake\Utility\Hash;

/**
 * GoodsInStores Controller
 *
 * @property \App\Model\Table\GoodsInStoresTable $GoodsInStores
 * @method \App\Model\Entity\GoodsInStore[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GoodsInStoresController extends AppController 
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [ 
            'contain' => ['Branches', 'GoodsOutWarehouses', 'GoodsOutStores'],
        ];
        $goodsInStores = $this->paginate($this->GoodsInStores);

        $this->set(compact('goodsInStores'));
    }

    /**
     * View method
     *
     * @param string|null $id Goods In Store id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $goodsInStore = $this->GoodsInStores->get($id, [
            'contain' => ['Branches', 'GoodsOutStores', 'GoodsOutWarehouses', 'GoodsInStoreLines'],
        ]);

        $this->set(compact('goodsInStore'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function get_last_number()
    {
        $dataRows = $this->GoodsInStores->find('all', [
            'fields' => array('codes' => 'MAX(GoodsInStores.code)'),
        ])->where(['date' => date('Y-m-d')])->first();
        $code = (!empty($dataRows->code) ? explode("/", $dataRows['code']) : array());
        $dataResult = (isset($code[0]) ? ((date('d-m') != '01-01') ? ($code[0] + 1) : 1) : 1);
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = $result . '/ST-IN/NSI/' . $this->Krs->numToRome(date('m')) . '/' . date('Y');
        return $number;
    }


    public function add()
    {
        $goodsInStore = $this->GoodsInStores->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['date']));

            $goodsInStore = $this->GoodsInStores->patchEntity($goodsInStore, array_merge($dataRow, $dataAuditLog, $date), ['associated' => ['GoodsInStoreLines' => ['validate' => true]]]);
            if ($this->GoodsInStores->save($goodsInStore)) {

                if ($dataRow['is_from'] == 'Warehouse') {

                    $tableGoodsWarehouse = $this->getTableLocator()->get('GoodsOutWarehouseLines');
                    foreach ($dataRow['goods_in_store_lines'] as $index => $rowGoodsInStore) {
                        $goodsWarehouse = $tableGoodsWarehouse->get($rowGoodsInStore['goods_out_warehouse_line_id']);
                        $goodsWarehouse['qty_out'] = $goodsWarehouse['qty_out'] - $rowGoodsInStore['qty'];
                        $goodsWarehouse['is_active'] = ($goodsWarehouse['qty_out'] == 0) ? 'N' : 'Y';
                        $tableGoodsWarehouse->save($goodsWarehouse);
                    }
                } else {

                    $tableGoodsStore = $this->getTableLocator()->get('GoodsOutStoreLines');
                    foreach ($dataRow['goods_in_store_lines'] as $index => $rowGoodsInStore) {
                        $goodsStore = $tableGoodsStore->get($rowGoodsInStore['goods_out_store_line_id']);
                        $goodsStore['qty_out'] = $goodsStore['qty_out'] - $rowGoodsInStore['qty'];
                        $goodsStore['is_active'] = ($goodsStore['qty_out'] == 0) ? 'N' : 'Y';
                        $tableGoodsStore->save($goodsStore);
                    }
                }

                $this->Flash->success(__('The goods in store has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The goods in store could not be saved. Please, try again.'));
        }
        $branches = $this->GoodsInStores->Branches->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $data['lastNumber'] = $this->get_last_number();
        $this->set(compact('goodsInStore', 'branches', 'data'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Goods In Store id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $goodsInStore = $this->GoodsInStores->get($id, [
            'contain' => ['GoodsOutWarehouses', 'GoodsInStoreLines.ItemLines.Items'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['date']));

            $goodsInStore = $this->GoodsInStores->patchEntity($goodsInStore, array_merge($dataRow, $dataAuditLog, $date), ['associated' => ['GoodsInStoreLines' => ['validate' => true]]]);
            if ($this->GoodsInStores->save($goodsInStore)) {
                $this->Flash->success(__('The goods in store has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The goods in store could not be saved. Please, try again.'));
        }
        $branches = $this->GoodsInStores->Branches->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        $this->set(compact('goodsInStore', 'branches'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Goods In Store id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $goodsInStore = $this->GoodsInStores->get($id);
        if ($this->GoodsInStores->delete($goodsInStore)) {
            $this->Flash->success(__('The goods in store has been deleted.'));
        } else {
            $this->Flash->error(__('The goods in store could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getwhout()
    {
        $this->autoRender = false;
        $this->loadModel('GoodsOutWarehouseLines'); 
        $this->loadModel('GoodsOutWarehouses');

        $lines = $this->GoodsOutWarehouseLines->find()->select(['goods_out_warehouse_id', 'is_active'])->where(['is_active' => 'Y'])->group(['goods_out_warehouse_id'])->toArray();
        $goodsId = Hash::extract($lines, '{n}.goods_out_warehouse_id');

        $search = $this->request->getQuery('search');

        $items = $this->GoodsOutWarehouses->find('all')->where(['GoodsOutWarehouses.id IN' => $goodsId, 'GoodsOutWarehouses.code like' => '%' . $search . '%', 'GoodsOutWarehouses.is_to' => 'Store']);

        $result = array();
        foreach ($items as $key => $data) {
            $result[] = array("value" =>  $data->code, "data" => (object) array('id' => $data->id, 'label' => $data->code));
        }

        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }


    public function getsout()
    {
        $this->autoRender = false;
        $this->loadModel('GoodsOutStoreLines');
        $this->loadModel('GoodsOutStores');

        $lines = $this->GoodsOutStoreLines->find()->select(['goods_out_store_id', 'is_active'])->where(['is_active' => 'Y'])->group(['goods_out_store_id'])->toArray();
        $goodsId = Hash::extract($lines, '{n}.goods_out_store_id');

        $search = $this->request->getQuery('search');

        $items = $this->GoodsOutStores->find('all')->where(['GoodsOutStores.id IN' => $goodsId, 'GoodsOutStores.code like' => '%' . $search . '%', 'GoodsOutStores.is_to' => 'Store']);

        $result = array();
        foreach ($items as $key => $data) {
            $result[] = array("value" =>  $data->code, "data" => (object) array('id' => $data->id, 'label' => $data->code));
        }

        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }

    public function setwhout()
    {
        $this->autoRender = false;
        $this->loadModel('GoodsOutStores');
        $items = $this->GoodsOutStores->find('all')->contain(['GoodsOutStoreLines.Items'])->where(['GoodsOutStores.id' => $this->request->getQuery('id')])->first();

        return $this->response->withType("application/json")->withStringBody(json_encode($items));
    }

    public function setsout()
    {
        $this->autoRender = false;
        $this->loadModel('GoodsOutStores');
        $items = $this->GoodsOutStores->find('all')->contain(['GoodsOutStoreLines.Items'])->where(['GoodsOutStores.id' => $this->request->getQuery('id')])->first();

        return $this->response->withType("application/json")->withStringBody(json_encode($items));
    }

    public function excel()
    {
        $session = $this->getRequest()->getSession(); //get session
        $condition = $session->read('condition');
        ini_set('memory_limit', '2048M');
        
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'Kode');
        $sheet->setCellValue('B1', 'Dari');
        $sheet->setCellValue('C1', 'Tgl. Masuk');
        $sheet->setCellValue('D1', 'Ke Toko');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $report = $this->GoodsInStores->find('all')->contain(['Branches'])->where([$condition])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->code);
            $sheet->setCellValue('B' . $row, $data->is_from);
            $sheet->setCellValue('C' . $row, (($data->date != null) ? $this->Krs->fDate($data->date, 'd-m-Y') : ''));
            $sheet->setCellValue('D' . $row, (($data->branch_id > 0) ? (!empty($data->branch) ? $data->branch->name : '-') : '-'));
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Masuk Toko -' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
