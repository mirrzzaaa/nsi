<?php

declare(strict_types=1);

namespace App\Controller;

// export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Cake\Utility\Hash;

/**
 * GoodsOutWarehouses Controller 
 *
 * @property \App\Model\Table\GoodsOutWarehousesTable $GoodsOutWarehouses
 * @method \App\Model\Entity\GoodsOutWarehouse[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GoodsOutWarehousesController extends AppController 
{
    /** 
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view 
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $goodsOutWarehouses = $this->GoodsOutWarehouses->find('all')->contain(['Warehouses']);

        $code = $this->request->getQuery('filtercode');
        $warehouse = $this->request->getQuery('filterwarehouse');
        $desc = $this->request->getQuery('filterdesc');

        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['GoodsOutWarehouses.code like'] = '%' . $code . '%';
        }
        if (!empty($warehouse)) {
            $dataWhere['Warehouses.name like'] = '%' . $warehouse . '%';
        }
        if (!empty($desc)) {
            $dataWhere['GoodsOutWarehouses.description like'] = '%' . $desc . '%';
        }

        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(GoodsOutWarehouses.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $goodsOutWarehouses->where([$dataWhere])->order(['GoodsOutWarehouses.created' => 'Desc']) : $goodsOutWarehouses->order(['GoodsOutWarehouses.created' => 'DESC']);

        $this->set('goodsOutWarehouses', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Goods Out Warehouse id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $goodsOutWarehouse = $this->GoodsOutWarehouses->get($id, [
            'contain' => ['Warehouses', 'GoodsOutWarehouseLines.WarehouseStocks.Items'],
        ]);

        $this->set(compact('goodsOutWarehouse'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function get_last_number()
    {
        $this->loadModel('GoodsOutWarehouses');
        $dataRows = $this->GoodsOutWarehouses->find('all', [
            'fields' => array('codes' => 'MAX(GoodsOutWarehouses.code)'),
        ])->first();
        $code = (!empty($dataRows->codes) ? explode("/", $dataRows['codes']) : array());
        $dataResult = isset($code[0]) ? ($code[0] + 1) : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = $result . '/WH-OUT/NSI/' . $this->Krs->numToRome(date('m')) . '/' . date('Y');
        return $number;
    }


    public function add()
    {
        $goodsOutWarehouse = $this->GoodsOutWarehouses->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['date']));
            $codes = array('code' => $this->get_last_number()); 

            $goodLines = array();
            foreach ($dataRow['goods_out_warehouse_lines'] as $index => $value) {
                $goodLines['goods_out_warehouse_lines'][$index]['item_id'] = $value['item_id'];
                $goodLines['goods_out_warehouse_lines'][$index]['warehouse_stock_id'] = $value['warehouse_stock_id'];
                $goodLines['goods_out_warehouse_lines'][$index]['qty'] = $this->Krs->nom2Dec($value['qty']);
                $goodLines['goods_out_warehouse_lines'][$index]['unit'] = $this->Krs->nom2Dec($value['unit']);
                $goodLines['goods_out_warehouse_lines'][$index]['name'] = $value['name'];
                $goodLines['goods_out_warehouse_lines'][$index]['nomor_seri'] = $value['nomor_seri'];
                $goodLines['goods_out_warehouse_lines'][$index]['kode_produk'] = $value['kode_produk'];
                $goodLines['goods_out_warehouse_lines'][$index]['supplier_code'] = $value['supplier_code'];
                $goodLines['goods_out_warehouse_lines'][$index]['supplier_name'] = $value['supplier_name'];
            }

            $goodsOutWarehouse = $this->GoodsOutWarehouses->patchEntity($goodsOutWarehouse, array_merge($dataRow, $dataAuditLog, $date, $goodLines, $codes));

            // pr($dataRow);

            if ($this->GoodsOutWarehouses->save($goodsOutWarehouse)) {

                foreach ($dataRow['goods_out_warehouse_lines'] as $index => $value) {
                    $tableItems = $this->getTableLocator()->get('WarehouseStocks');
                    $item = $tableItems->get($value['warehouse_stock_id']);
                    $item->stock = $item->stock - $value['qty'];
                    $tableItems->save($item);
                }

                $this->Flash->success(__('The goods out warehouse has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The goods out warehouse could not be saved. Please, try again.'));
        }

        $warehouses = $this->GoodsOutWarehouses->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $permits = $this->GoodsOutWarehouses->Permits->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $data['lastNumber'] = $this->get_last_number();
        $this->set(compact('goodsOutWarehouse', 'warehouses', 'data', 'permits'));
    }


    public function delivery()
    {
        $goodsOutWarehouse = $this->GoodsOutWarehouses->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => date('Y-m-d'));
            $is_to = array('is_to' => 'Order');
            $codes = array('code' => $this->get_last_number());
            $dataWarehouse = array('warehouse_id' => $dataRow['gudang']); 

            $goodLines = array();
            foreach ($dataRow['goods_out_warehouse_lines'] as $index => $value) {
                $goodLines['goods_out_warehouse_lines'][$index]['item_id'] = $value['item_id'];
                $goodLines['goods_out_warehouse_lines'][$index]['qty'] = $this->Krs->nom2Dec($value['qty']);
                $goodLines['goods_out_warehouse_lines'][$index]['unit'] = $this->Krs->nom2Dec($value['unit']);
                $goodLines['goods_out_warehouse_lines'][$index]['description'] = $value['description'];
                $goodLines['goods_out_warehouse_lines'][$index]['name'] = $value['name'];
            }

            $tablePermits =  $this->getTableLocator()->get('Permits');
            $tableOrders =  $this->getTableLocator()->get('Orders');

            $goodsOutWarehouse = $this->GoodsOutWarehouses->patchEntity($goodsOutWarehouse, array_merge($dataRow, $dataAuditLog, $date, $is_to, $codes, $dataWarehouse, $goodLines));
            if ($this->GoodsOutWarehouses->save($goodsOutWarehouse)) {

                $permit = $tablePermits->get($dataRow['permit_id']);
                $permit->is_active = 'N';
                $tablePermits->save($permit);

                $order = $tableOrders->get($permit->order_id);
                $order->status_wait = 'Yes';
                $tableOrders->save($order);

                foreach ($dataRow['goods_out_warehouse_lines'] as $index => $value) {
                    $tableItems = $this->getTableLocator()->get('Items');
                    $item = $tableItems->get($value['item_id']);
                    $item->stock = $item->stock - $value['qty'];
                    $tableItems->save($item);
                }

                $this->Flash->success(__('The goods out warehouse has been saved.')); 

                return $this->redirect(['action' => 'delivery']);
            }
            $this->Flash->error(__('The goods out warehouse could not be saved. Please, try again.'));
        }

        $warehouses = $this->GoodsOutWarehouses->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $permits = $this->GoodsOutWarehouses->Permits->find('list', ['keyField' => 'id', 'valueField' => 'code'])->toArray();
        $orders = $this->GoodsOutWarehouses->Permits->Orders->find('list', ['keyField' => 'id', 'valueField' => 'code'])->toArray();
        $data['lastNumber'] = $this->get_last_number();
        $this->set(compact('goodsOutWarehouse', 'warehouses', 'data', 'permits', 'orders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Goods Out Warehouse id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $goodsOutWarehouse = $this->GoodsOutWarehouses->get($id, [
            'contain' => ['GoodsOutWarehouseLines.WarehouseStocks.Items', 'Warehouses', 'Permits', 'Permits.Orders'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['date']));

            $goodsOutWarehouse = $this->GoodsOutWarehouses->patchEntity($goodsOutWarehouse, array_merge($dataRow, $dataAuditLog, $date));

            if ($this->GoodsOutWarehouses->save($goodsOutWarehouse)) {

                $this->Flash->success(__('The goods out warehouse has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The goods out warehouse could not be saved. Please, try again.'));
        }

        $this->loadModel('WarehouseStocks');
        $this->loadModel('Permits');

        //pr($goodsOutWarehouse);
        $items = $this->WarehouseStocks->find('all')->contain(['Items'])->where(['WarehouseStocks.warehouse_id' => $goodsOutWarehouse->warehouse_id])->toArray();
        $orderLine = $this->Permits->Orders->find('all')->contain(['Customers'])->toArray();
        // ->where(['Orders.id' => $goodsOutWarehouse->warehouse_id])
        //$warehouses = $this->WarehouseStocks->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $warehouses = $this->WarehouseStocks->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Warehouses.id' => $goodsOutWarehouse->warehouse_id])->toArray();
        $permits = $this->Permits->Orders->find('list', ['keyField' => 'id', 'valueField' => 'code'])->toArray();

        $this->set(compact('goodsOutWarehouse', 'items', 'warehouses', 'permits', 'orderLine'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Goods Out Warehouse id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $goodsOutWarehouse = $this->GoodsOutWarehouses->get($id);
        if ($this->GoodsOutWarehouses->delete($goodsOutWarehouse)) {
            $this->Flash->success(__('The goods out warehouse has been deleted.'));
        } else {
            $this->Flash->error(__('The goods out warehouse could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getitem()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;
        $this->loadModel('WarehouseStocks');

        $warehouseId = $this->request->getQuery('id');

        // Validasi ID gudang (pastikan integer)
        if (!is_numeric($warehouseId)) {
            return $this->response->withType("application/json")
                ->withStringBody(json_encode([]));
        }

        $items = $this->WarehouseStocks->find('all')
            ->contain(['Items'])
            ->where([
                'WarehouseStocks.warehouse_id' => $warehouseId,
                'WarehouseStocks.stock >' => 0
            ])
            ->toArray();

        $result = [];

        foreach ($items as $index => $value) {
            if (!empty($value->item)) {
                $result[] = [
                    'id' => $value->item->id, // ID item, bukan ID stok
                    'text' => $value->item->name
                ];
            }
        }

        return $this->response->withType("application/json")
            ->withStringBody(json_encode($result));
    }


    public function setitem()
    {
        $this->autoRender = false;
        $this->loadModel('WarehouseStocks');
        $items = $this->WarehouseStocks->find('all')->contain(['Items'])->where(['Items.id' => $this->request->getQuery('id')])->first();

        return $this->response->withType("application/json")->withStringBody(json_encode($items));
    }

    public function getorder()
    {
        $this->autoRender = false;
        $this->loadModel('Permits');
        $this->loadModel('Orders');

        $search = $this->request->getQuery('search');

        $permits = $this->Permits->find('all')->where(['OR' => ['code like' => '%' . $search . '%']]);

        $result = array();
        foreach ($permits as $key => $data) {
            $result[$key]['id'] = (int) $data['id'];
            $result[$key]['text'] = $data['code'];
        }
        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }

    public function setorder()
    {
        $this->autoRender = false;

        // Load model 
        $this->loadModel('Permits');
        $this->loadModel('Orders');
        $this->loadModel('OrderLines');
        $this->loadModel('Customers');

        // Ambil id dari parameter request
        $id = $this->request->getQuery('id');

        $permit = $this->Permits->get($id, [
            'contain' => ['Orders.Customers', 'Orders.OrderLines.Items', 'Orders.Warehouses'], 
        ]);

        if ($permit) {
            $data = array();
            $a = 0;
            foreach ($permit->order->order_lines as $orderLine) {
                //$orders = $permit->order;
                $items = $orderLine->item;
                $data[$a]['id'] = $items->id;
                $data[$a]['name'] = $items->name;
                $data[$a]['quantity'] = $orderLine->quantity;
                $data[$a]['unit'] = $items->unit;
                $data[$a]['deskripsi'] = $items->description; 
                $data[$a]['item_id'] = $orderLine->item_id; 
                //$data[$a]['gudang'] = $orders->warehouse_id;
                $a++;
            }

            // Gabungkan data customers dan permit dalam satu array untuk di-encode
            $response_data = [
                'result' => $data,
                'permit' => $permit
            ];

            // Mengembalikan response JSON
            return $this->response->withType("application/json")->withStringBody(json_encode($response_data));
        } else {
            // Jika data tidak ditemukan
            return $this->response->withType("application/json")->withStringBody(json_encode(['error' => 'Data not found']));
        }
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
        $sheet->setCellValue('A1', 'No');
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

        $report = $this->GoodsOutWarehouses->find('all')->contain(['GoodsOutWarehouseLines.WarehouseStocks.Items', 'Warehouses', 'Permits', 'Permits.Orders'])->where([$condition])->toArray();

        $row = 2;
        $no = 1;

        foreach ($report as $data) {
            foreach ($data->goods_out_warehouse_lines as $line) {
                $item = $line->warehouse_stock->item ?? null;

                $sheet->setCellValue('A' . $row, $no++);
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
        $filename = 'Keluar Gudang - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
