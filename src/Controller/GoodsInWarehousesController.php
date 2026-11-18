<?php

declare(strict_types=1);

namespace App\Controller;

// export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Cake\Utility\Hash;

/**
 * GoodsInWarehouses Controller
 *
 * @property \App\Model\Table\GoodsInWarehousesTable $GoodsInWarehouses
 * @method \App\Model\Entity\GoodsInWarehouse[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GoodsInWarehousesController extends AppController
{ 
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $goodsInWarehouses = $this->GoodsInWarehouses->find('all')->contain(['Purchasings', 'Warehouses']);

        $code = $this->request->getQuery('filtercode');
        $warehouse = $this->request->getQuery('filterwarehouse');
        $desc = $this->request->getQuery('filterdesc');

        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['GoodsInWarehouses.number like'] = '%' . $code . '%';
        }
        if (!empty($warehouse)) {
            $dataWhere['Warehouses.name like'] = '%' . $warehouse . '%';
        }
        if (!empty($desc)) {
            $dataWhere['GoodsInWarehouses.description like'] = '%' . $desc . '%';
        }

        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(GoodsInWarehouses.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $goodsInWarehouses->where([$dataWhere])->order(['GoodsInWarehouses.created' => 'Desc']) : $goodsInWarehouses->order(['GoodsInWarehouses.created' => 'DESC']);

        $this->set('goodsInWarehouses', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Goods In Warehouse id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $goodsInWarehouse = $this->GoodsInWarehouses->get($id, [
            'contain' => ['GoodsInWarehouseLines', 'Purchasings', 'Purchasings.PurchasingLines.Items', 'Warehouses'],
        ]);

        $this->set(compact('goodsInWarehouse'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function get_last_code()
    {
        $dataRows = $this->GoodsInWarehouses->find('all', [
            'fields' => array('code' => 'MAX(GoodsInWarehouses.number)'), 
        ])->first();

        $code = (!empty($dataRows->code) ? explode("/", $dataRows['code']) : array());
        $dataResult = (isset($code[0]) ? ((date('d-m') != '01-01') ? ($code[0] + 1) : 1 ) : 1);
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = $result . '/WH-IN/NSI/' . $this->Krs->numToRome(date('m')) . '/' . date('Y');
        return $number;
    }

    public function get_last_number()
    {
        $dataRows = $this->GoodsInWarehouses->find('all', [
            'fields' => array('code' => 'MAX(GoodsInWarehouses.number)'), 
        ])->first();

        $code = (!empty($dataRows->code) ? explode("/", $dataRows['code']) : array());
        $dataResult = (isset($code[0]) ? ((date('d-m') != '01-01') ? ($code[0] + 1) : 1 ) : 1);
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        return $result;
    }

    public function add()
    {
        $goodsInWarehouse = $this->GoodsInWarehouses->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['dates']));
            $code = array('code' => $this->get_last_code());
            $number = array('number' => $this->get_last_number());

            $goodsLines = array();
            foreach ($dataRow['goods_in_warehouse_lines'] as $index => $rowGoods) {
                $goodsLines['goods_in_warehouse_lines'][$index]['item_id'] = $rowGoods['item_id'];
                // $goodsLines['goods_in_warehouse_lines'][$index]['goods_out_warehouse_line_id'] = $rowGoods['goods_out_warehouse_line_id'];
                // $goodsLines['goods_in_warehouse_lines'][$index]['goods_out_store_line_id'] = $rowGoods['goods_out_store_line_id'];
                $goodsLines['goods_in_warehouse_lines'][$index]['purchasing_line_id'] = $rowGoods['purchasing_line_id'];
                $goodsLines['goods_in_warehouse_lines'][$index]['qty'] = $rowGoods['qty'];
                $goodsLines['goods_in_warehouse_lines'][$index]['unit'] = $rowGoods['unit'];
                $goodsLines['goods_in_warehouse_lines'][$index]['nomor_seri'] = $rowGoods['nomor_seri']; 
                $goodsLines['goods_in_warehouse_lines'][$index]['kode_produk'] = $rowGoods['kode_produk']; 
                $goodsLines['goods_in_warehouse_lines'][$index]['supplier_code'] = $rowGoods['supplier_code']; 
                $goodsLines['goods_in_warehouse_lines'][$index]['supplier_name'] = $rowGoods['supplier_name']; 
            }

            $goodsInWarehouse = $this->GoodsInWarehouses->patchEntity($goodsInWarehouse, array_merge($dataRow, $dataAuditLog, $date, $code, $number, $goodsLines));

            if ($this->GoodsInWarehouses->save($goodsInWarehouse)) {
            // Setelah menyimpan goodsInWarehouse, simpan goodsLines
            $goodsInWarehouseLinesTable = $this->getTableLocator()->get('GoodsInWarehouseLines');
            foreach ($goodsLines['goods_in_warehouse_lines'] as $line) {
                $line['goods_in_warehouse_id'] = $goodsInWarehouse->id; // Mengaitkan dengan ID dari goodsInWarehouse
                $goodsInWarehouseLine = $goodsInWarehouseLinesTable->newEntity($line);
                $goodsInWarehouseLinesTable->save($goodsInWarehouseLine);
            }

            if ($dataRow['is_from'] == 'Purchasing') { // Perbaikan pada kondisi ini
                $tablePurchasingLines = $this->getTableLocator()->get('PurchasingLines');
                $tablePurchasings = $this->getTableLocator()->get('Purchasings');

                foreach ($dataRow['goods_in_warehouse_lines'] as $index => $rowGoodsInWarehouse) {
                    // Update table PurchasingLines
                    $purchasingLine = $tablePurchasingLines->get($rowGoodsInWarehouse['purchasing_line_id']);
                    $purchasingLine['quantity_in'] = $purchasingLine['quantity_in'] - $rowGoodsInWarehouse['qty'];
                    $purchasingLine['status_wait'] = ($purchasingLine['quantity_in'] == 0) ? 'Yes' : 'Wait';
                    $tablePurchasingLines->save($purchasingLine);

                    // Update table Purchasings
                    $purchasing = $tablePurchasings->get($purchasingLine['purchasing_id']); // Ambil purchasing berdasarkan ID dari PurchasingLine
                    $purchasing['goods_in_warehouse_id'] = $goodsInWarehouse->id; // Isi kolom goods_in_warehouse_id dengan ID goodsInWarehouse
                    $tablePurchasings->save($purchasing);
                }
            }

            $this->Flash->success(__('The goods in warehouse has been saved.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The goods in warehouse could not be saved. Please, try again.'));
        }

        $warehouses = $this->GoodsInWarehouses->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $data['lastCode'] = $this->get_last_code();
        $data['lastNumber'] = $this->get_last_number();
        $this->set(compact('goodsInWarehouse', 'warehouses', 'data')); 
    }

    /**
     * Edit method
     *
     * @param string|null $id Goods In Warehouse id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $goodsInWarehouse = $this->GoodsInWarehouses->get($id, [
            'contain' => ['GoodsInWarehouseLines', 'Purchasings', 'Purchasings.PurchasingLines.Items', 'Warehouses'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['dates']));

            $goodsInWarehouse = $this->GoodsInWarehouses->patchEntity($goodsInWarehouse, array_merge($dataRow, $dataAuditLog, $date));

            // pr($dataRow);

            if ($this->GoodsInWarehouses->save($goodsInWarehouse)) {
                $this->Flash->success(__('The goods in warehouse has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The goods in warehouse could not be saved. Please, try again.'));
        }

        $this->loadModel('PurchasingLines');
        $purchasings = $this->PurchasingLines->find('all')->contain(['Items'])->where(['PurchasingLines.status_wait' => 'Wait', 'PurchasingLines.purchasing_id' => $goodsInWarehouse->purchasing_id])->toArray();

        $this->set(compact('goodsInWarehouse', 'purchasings'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Goods In Warehouse id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $goodsInWarehouse = $this->GoodsInWarehouses->get($id);
        if ($this->GoodsInWarehouses->delete($goodsInWarehouse)) {
            $this->Flash->success(__('The goods in warehouse has been deleted.'));
        } else {
            $this->Flash->error(__('The goods in warehouse could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getpo()
    {
        $this->autoRender = false;
        $this->loadModel('PurchasingLines');
        $this->loadModel('Purchasings');

        $lines = $this->PurchasingLines->find()->select(['purchasing_id', 'status_wait'])->where(['status_wait' => 'Wait'])->group(['purchasing_id'])->toArray();
        $poIds = Hash::extract($lines, '{n}.purchasing_id');

        $search = $this->request->getQuery('search');

        $items = $this->Purchasings->find('all')->where(['Purchasings.number like' => '%' . $search . '%']);
        //, 'Purchasings.status_wait' => 'Yes', 'Purchasings.goods_in_warehouse_id' => 0
        //$items = $this->Purchasings->find('all')->where(['Purchasings.id IN' => $poIds, 'Purchasings.number like' => '%' . $search . '%', 'Purchasings.status_wait' => 'Yes', 'Purchasings.goods_in_warehouse_id' => 0]);

        $result = array();
        foreach ($items as $key => $data) {
            $result[] = array("value" =>  $data->number, "data" => (object) array('id' => $data->id, 'label' => $data->number));
        }

        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }


    public function getwhout()
    {
        $this->autoRender = false;
        $this->loadModel('GoodsOutWarehouseLines');
        $this->loadModel('GoodsOutWarehouses');

        $lines = $this->GoodsOutWarehouseLines->find()->select(['goods_out_warehouse_id', 'is_active'])->where(['is_active' => 'Y'])->group(['goods_out_warehouse_id'])->toArray();
        $goodsId = Hash::extract($lines, '{n}.goods_out_warehouse_id');

        $search = $this->request->getQuery('search');

        $items = $this->GoodsOutWarehouses->find('all')->where(['GoodsOutWarehouses.id IN' => $goodsId, 'GoodsOutWarehouses.code like' => '%' . $search . '%', 'GoodsOutWarehouses.is_to' => 'Warehouse']);

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

        $items = $this->GoodsOutStores->find('all')->where(['GoodsOutStores.id IN' => $goodsId, 'GoodsOutStores.code like' => '%' . $search . '%', 'GoodsOutStores.is_to' => 'Warehouse']);

        $result = array();
        foreach ($items as $key => $data) {
            $result[] = array("value" =>  $data->code, "data" => (object) array('id' => $data->id, 'label' => $data->code));
        }

        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }


    public function setpo()
    {
        $this->autoRender = false; 
        $this->loadModel('Purchasings');
        $items = $this->Purchasings->find('all')->contain(['Warehouses', 'Suppliers', 'PurchasingLines.Items'])->where(['Purchasings.id' => $this->request->getQuery('id')])->first();

        return $this->response->withType("application/json")->withStringBody(json_encode($items));
    }

    public function setwhout()
    {
        $this->autoRender = false;
        $this->loadModel('GoodsOutWarehouses');
        $items = $this->GoodsOutWarehouses->find('all')->contain(['Warehouses', 'GoodsOutWarehouseLines.Items'])->where(['GoodsOutWarehouses.id' => $this->request->getQuery('id')])->first();

        return $this->response->withType("application/json")->withStringBody(json_encode($items));
    }

    public function setsout()
    {
        $this->autoRender = false;
        $this->loadModel('GoodsOutStores');
        $items = $this->GoodsOutStores->find('all')->contain(['GoodsOutStoreLines.Items'])->where(['GoodsOutStores.id' => $this->request->getQuery('id')])->first();

        return $this->response->withType("application/json")->withStringBody(json_encode($items));
    }


    public function setitem()
    {
        $this->autoRender = false;
        $this->loadModel('PurchasingLines');

        $item = $this->PurchasingLines->find('all')->contain(['Items'])->where(['PurchasingLines.id' => $this->request->getQuery('id')])->first();

        return $this->response->withType("application/json")->withStringBody(json_encode($item));
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
        $sheet->setCellValue('B1', 'ID Produk');
        $sheet->setCellValue('C1', 'Nama Produk');
        $sheet->setCellValue('D1', 'Nomor Izin Edar');
        $sheet->setCellValue('E1', 'Tipe dan Ukuran');
        $sheet->setCellValue('F1', 'Nomor Seri');
        $sheet->setCellValue('G1', 'Kode Produk');
        $sheet->setCellValue('H1', 'Jumlah Masuk');
        $sheet->setCellValue('I1', 'Tanggal Masuk');
        $sheet->setCellValue('J1', 'Tanggal Kadaluwarsa');
        $sheet->setCellValue('K1', 'ID Upline');
        $sheet->setCellValue('L1', 'Nama Upline');
        

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $report = $this->GoodsInWarehouses->find('all')
            ->contain([
                'GoodsInWarehouseLines', 
                'Purchasings', 
                'Purchasings.PurchasingLines.Items', 
                'Warehouses'
            ])
            ->where([$condition])
            ->toArray();

        $row = 2;

        foreach ($report as $data) {
            $goodsLines = $data->goods_in_warehouse_lines; 

            // Ambil purchasing_line dan item dari relasi
            $purchasing = $data->purchasing ?? null;
            $purchasingLine = !empty($purchasing->purchasing_lines[0]) ? $purchasing->purchasing_lines[0] : null;
            $item = $purchasingLine->item ?? null;

            // Loop per line di goods_in_warehouse_lines
            foreach ($goodsLines as $line) {
                $sheet->setCellValue('A' . $row, $data->number);
                $sheet->setCellValue('B' . $row, $item->code_internal ?? '');
                $sheet->setCellValue('C' . $row, $item->name ?? '');
                $sheet->setCellValueExplicit('D' . $row, $item->izin_edar ?? '', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('E' . $row, ($item ? $item->type . ' ' . $item->ukuran : ''));
                $sheet->setCellValue('F' . $row, $line->nomor_seri ?? '');
                $sheet->setCellValue('G' . $row, $line->kode_produk ?? '');
                $sheet->setCellValue('H' . $row, $line->qty ?? '');
                $sheet->setCellValue('I' . $row, ($data->date ? $this->Krs->fDate($data->date, 'Y-m-d') : ''));
                $sheet->setCellValue('J' . $row, ($item && $item->expired_date ? $this->Krs->fDate($item->expired_date, 'Y-m-d') : ''));
                $sheet->setCellValue('K' . $row, $line->supplier_code ?? '');
                $sheet->setCellValue('L' . $row, $line->supplier_name ?? '');

                $row++;
            }
        }


        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Masuk Gudang -' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
