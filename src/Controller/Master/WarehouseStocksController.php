<?php

declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

// export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * WarehouseStocks Controller
 *
 * @property \App\Model\Table\WarehouseStocksTable $WarehouseStocks
 * @method \App\Model\Entity\WarehouseStock[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WarehouseStocksController  extends AppController
{
    /**
     * Index method 
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session 
        $warehouseStocks = $this->WarehouseStocks->find('all')->contain(['Items.Suppliers','Warehouses','Items', 'Users']);

        $code = $this->request->getQuery('filtercode');
        $name = $this->request->getQuery('filtername');
        $supplier = $this->request->getQuery('filtersupplier');
        $wh = $this->request->getQuery('filterwh');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['WarehouseStocks.code like'] = '%' . $code . '%';
        }
        if (!empty($name)) {
            $dataWhere['Items.name like'] = '%' . $name . '%';
        }
        if (!empty($supplier)) {
            $dataWhere['Suppliers.name like'] = '%' . $supplier . '%';
        }
        if (!empty($wh)) {
            $dataWhere['Warehouses.name like'] = '%' . $wh . '%';
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $warehouseStocks->where([$dataWhere])->order(['WarehouseStocks.code' => 'DESC']) : $warehouseStocks->order(['WarehouseStocks.code' => 'DESC']);

        $this->set('warehouseStocks', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Warehouse Stock id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $warehouseStock = $this->WarehouseStocks->get($id, [
            'contain' => ['Items', 'Warehouses', 'Items.Suppliers'],
        ]);

        $this->set(compact('warehouseStock'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $warehouseStock = $this->WarehouseStocks->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $expiredDate = array('expired_date' => $this->Krs->dateTo($dataRow['dates']));
            $date = array('date' => date('Y-m-d'));
            $stock = array('stock' => $this->Krs->nom2Dec($dataRow['stocks']));
            $buy = array('buy' => $this->Krs->nom2Dec($dataRow['buys']));
            $sell = array('sell' => $this->Krs->nom2Dec($dataRow['sells']));

            $warehouseStock = $this->WarehouseStocks->patchEntity($warehouseStock, array_merge($dataRow, $dataAuditLog, $date, $expiredDate, $stock, $buy, $sell));
            if ($this->WarehouseStocks->save($warehouseStock)) {
                $this->Flash->success(__('The warehouse stock has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The warehouse stock could not be saved. Please, try again.'));
        }
        $warehouses = $this->WarehouseStocks->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $itemsLines = $this->WarehouseStocks->Items->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $this->set(compact('warehouseStock',  'warehouses', 'itemsLines')); 

        // $this->loadModel('Warehouses'); 
        // $warehouses = $this->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        // $this->set(compact('warehouseStock', 'warehouses')); 
    }

    /**
     * Edit method
     *
     * @param string|null $id Warehouse Stock id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $warehouseStock = $this->WarehouseStocks->get($id, [
            'contain' => ['Warehouses', 'Items', 'Items.Suppliers'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $expiredDate = array('expired_date' => $this->Krs->dateTo($dataRow['dates']));
            $date = array('date' => date('Y-m-d'));
            $buy = array('buy' => $this->Krs->nom2Dec($dataRow['buys']));
            $sell = array('sell' => $this->Krs->nom2Dec($dataRow['sells']));
            $stock = array('stock' => $this->Krs->nom2Dec($dataRow['stocks']));

            $warehouseStock = $this->WarehouseStocks->patchEntity($warehouseStock, array_merge($dataRow, $dataAuditLog, $date, $expiredDate, $buy, $sell, $stock));
            if ($this->WarehouseStocks->save($warehouseStock)) {
                $this->Flash->success(__('The warehouse stock has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The warehouse stock could not be saved. Please, try again.'));
        }
        $warehouses = $this->WarehouseStocks->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $this->set(compact('warehouseStock', 'warehouses'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Warehouse Stock id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $warehouseStock = $this->WarehouseStocks->get($id);
        if ($this->WarehouseStocks->delete($warehouseStock)) {
            $this->Flash->success(__('The warehouse stock has been deleted.'));
        } else {
            $this->Flash->error(__('The warehouse stock could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getitem()
    {
        $this->autoRender = false;
        $this->loadModel('Items');

        $search = $this->request->getQuery('search');

        $items = $this->Items->find('all')->where(['OR' => ['name like' => '%' . $search . '%']]);

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
 

    public function excel()
    {
        $session = $this->getRequest()->getSession(); //get session
        $condition = $session->read('condition');
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'Barcode');
        $sheet->setCellValue('B1', 'Kode Internal');
        $sheet->setCellValue('C1', 'Nama Produk');
        $sheet->setCellValue('D1', 'Tanggal Expired');
        $sheet->setCellValue('E1', 'Supplier');
        $sheet->setCellValue('F1', 'Stock');
        $sheet->setCellValue('G1', 'Satuan');
        $sheet->setCellValue('H1', 'Harga Beli');
        $sheet->setCellValue('I1', 'Harga Jual');
        $sheet->setCellValue('J1', 'Gudang');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $report = $this->WarehouseStocks->find('all')->contain(['Items.Suppliers', 'Warehouses', 'Users'])->where([$condition])->toArray();

        $currentUser = $this->request->getAttribute('identity'); // Ambil pengguna login

        $row = 2;
        foreach ($report as $data) {
            $sheet->setCellValue('A' . $row, (!empty($data->item->barcode) ? $data->item->barcode : '-'));
            $sheet->setCellValue('B' . $row, (!empty($data->code) ? $data->code : '-'));
            $sheet->setCellValue('C' . $row, (!empty($data->item->name) ? $data->item->name : '-'));
            $sheet->setCellValue('D' . $row, (!empty($data->expired_date) ? date('d-m-Y', strtotime($data->expired_date->format('Y-m-d H:i:s'))) : '-'));
            $sheet->setCellValue('E' . $row, (!empty($data->item->supplier->name) ? $data->item->supplier->name : '-'));
            $sheet->setCellValue('F' . $row, (!empty($data->stock) ? $data->stock : '-'));
            $sheet->setCellValue('G' . $row, (!empty($data->item->unit) ? $data->item->unit : '-'));

            // Validasi berdasarkan devision pengguna login
            if (!empty($currentUser) && $currentUser->devision == 'Marketing') {
                $sheet->setCellValue('H' . $row, '-'); // Kosongkan kolom H
            } else {
                $sheet->setCellValue('H' . $row, (!empty($data->buy) ? $this->Krs->nom($data->buy) : '-'));
            }

            $sheet->setCellValue('I' . $row, (!empty($data->sell) ? $this->Krs->nom($data->sell) : '-'));
            $sheet->setCellValue('J' . $row, (!empty($data->warehouse->name) ? $data->warehouse->name : '-'));
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Item Warehouse - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
