<?php

declare(strict_types=1);

namespace App\Controller\Transaction;

use App\Controller\AppController;
use Cake\Utility\Hash;

// export 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
 

/**  
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController 
{
    /**
     * Index method 
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $orders = $this->Orders->find('all')->contain(['Customers', 'Users']);
 
        $code = $this->request->getQuery('filtercode');
        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');
        $customer = $this->request->getQuery('filtercustomer');
        $status = $this->request->getQuery('filterstatus');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Orders.code like'] = '%' . $code . '%'; 
        }

        if (!empty($customer)) {
            $dataWhere['Customers.name like'] = '%' . $customer . '%';
        }

        if (!empty($status)) {
            $dataWhere['Orders.status_wait'] =  $status;
        }
        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(Orders.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $orders->where([$dataWhere])->order(['Orders.code' => 'DESC']) : $orders->order(['Orders.code' => 'DESC']);

        $this->set('orders', $this->paginate($queries, ['limit' => '10'])); 
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['Customers', 'OrderLines.Items', 'Users', 'Invoices'],
        ]);

        $this->set(compact('order'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function get_last_number() 
    {
        $dataRows = $this->Orders->find('all', [
            'fields' => array('codes' => 'MAX(Orders.code)'),
        ])->first();
        $code = (!empty($dataRows->codes) ? explode("/", $dataRows['codes']) : array());
        $dataResult = isset($code[0]) ? ($code[0] + 1) : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = $result . '/ORDER/NSI/' . $this->Krs->numToRome(date('m')) . '/' . date('Y');
        return $number;
    }

    public function add() 
    {
        $order = $this->Orders->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $code = array('code' => $this->get_last_number());
            $date = array('date' => date('Y-m-d'));
            $grandtotal = array('grandtotal' => $dataRow['grandtotal']);
            $ppn = array('ppn' => $dataRow['ppns']);
            $noPO = array('po_number' => $dataRow['po_number']);
            // $discount = array('discount' => $this->Krs->nom2Dec($dataRow['discounts']));
            $ship_payment = array('deliver_pays' => $this->Krs->nom2Dec($dataRow['ship_payments']));
            $keterangan = array('keterangan' => $dataRow['keterangan']);

            $order_lines = array();
            if ($dataRow['order_lines']) {
                foreach ($dataRow['order_lines'] as $index => $value) { 
                    $order_lines['order_lines'][$index]['item_id'] = $value['item_id'];
                    $order_lines['order_lines'][$index]['quantity'] = $value['quantity'];
                    $order_lines['order_lines'][$index]['unit'] = $value['unit'];
                    $order_lines['order_lines'][$index]['discount'] = $this->Krs->nom2Dec($value['discount']);
                    $order_lines['order_lines'][$index]['expired_date'] = $this->Krs->dateTo($value['expired_date']); 
                    $order_lines['order_lines'][$index]['price_t'] = $this->Krs->nom2Dec($value['price_t']); 
                    $order_lines['order_lines'][$index]['subtotal'] = $this->Krs->nom2Dec($value['subtotal']);
                    $order_lines['order_lines'][$index]['comment'] = $value['comment'];
                }
            }

            $order = $this->Orders->patchEntity($order, array_merge($dataRow, $dataAuditLog, $date, $grandtotal, $ship_payment, $code, $order_lines, $noPO, $ppn, $keterangan)); 

            // pr($dataRow);

            if ($this->Orders->save($order)) {

                return $this->redirect(['action' => 'index']);
                $this->Flash->success(__('The order has been saved.'));
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }

        $this->loadModel('Customers');
        $this->loadModel('Items');
        $customers = $this->Customers->find('list')->select(['id' => 'Customers.id', 'name' => 'Customers.name'])->toArray();
        //$customers = $this->Items->find('list')->contain(['Customers'])->select(['id' => 'Customers.id', 'name' => 'Customers.name'])->toArray(); 
        $items = $this->Items->find('list')->select(['id' => 'Items.id', 'name' => 'Items.name'])->toArray();
        $branches = $this->Orders->Branches->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $warehouses = $this->Orders->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $this->set(compact('order', 'customers',  'branches', 'warehouses', 'items'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    { 
        $order = $this->Orders->get($id, [ 
            'contain' => ['Customers', 'OrderLines.Items', 'Branches', 'Warehouses', 'Items'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => date('Y-m-d'));
            $noPO = array('po_number' => $dataRow['po_number']);
            // $discount = array('discount' => $this->Krs->nom2Dec($dataRow['discounts']));
            $ship_payment = array('deliver_pays' => $this->Krs->nom2Dec($dataRow['ship_payments']));
            $grandtotal = array('grandtotal' => $dataRow['grandtotal']);
            $ppn = array('ppn' => $this->Krs->nom2Dec($dataRow['ppns']));
            $with_price = !empty($dataRow['with_price']) ? 'N' : 'Y';
            $keterangan = array('keterangan' => $dataRow['keterangan']);

            $order_lines = [];
            if ($dataRow['order_lines']) {
                foreach ($dataRow['order_lines'] as $index => $value) {
                    // Menyiapkan data order_line
                    $order_line_data = [
                        'item_id' => $value['item_id'],
                        'quantity' => $value['quantity'],
                        'discount' => $this->Krs->nom2Dec($value['discount']),
                        'unit' => $value['unit'], 
                        'expired_date' => $this->Krs->dateTo($value['expired_date']),
                        'price_t' => $this->Krs->nom2Dec($value['price_t']),
                        'subtotal' => $this->Krs->nom2Dec($value['subtotal']),
                        'comment' => $value['comment']
                    ];

                    // Memeriksa apakah item_id tidak kosong
                    if (!empty($value['item_id'])) {
                        // Mencari order_line yang ada berdasarkan order_id dan item_id
                        $existing_line = $this->Orders->OrderLines->find()
                            ->where(['order_id' => $order->id, 'item_id' => $value['item_id']])
                            ->first();
                        if ($existing_line) {
                            // Jika ditemukan, gabungkan data baru dengan data yang ada (update)
                            $order_lines['order_lines'][$index] = array_merge(['id' => $existing_line->id], $order_line_data);
                        } else {
                            // Jika tidak ditemukan, tambahkan data baru (add)
                            $order_lines['order_lines'][$index] = $order_line_data;
                        }
                    } else {
                        // Jika item_id kosong, tambahkan data baru (add)
                        $order_lines['order_lines'][$index] = $order_line_data;
                    }
                }
            }

            $order = $this->Orders->patchEntity($order, array_merge($dataRow, $date, $dataAuditLog, $noPO, $grandtotal, $ship_payment, $order_lines, $ppn, ['with_price' => $with_price], $keterangan));

            // pr($dataRow);

            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }

        $this->loadModel('Items');
        $this->loadModel('BranchStocks');
        $this->loadModel('WarehouseStocks');

        $itemIds = array();
        if ($order->branch_id > 0) {
            $items = $this->BranchStocks->find('all')->where(['BranchStocks.branch_id' => $order->branch_id])->toArray();
            $itemIds = Hash::extract($items, '{n}.item_id');
        } else {
            $items = $this->WarehouseStocks->find('all')->where(['WarehouseStocks.warehouse_id' => $order->warehouse_id])->toArray();
            $itemIds = Hash::extract($items, '{n}.item_id');
        }

        // Mengambil data dari tabel Items berdasarkan item_ids yang telah didapatkan
        $items = $this->Items->find('list', [
            'conditions' => ['Items.id IN' => $itemIds],
            'keyField' => 'id',
            'valueField' => 'name'
        ])->toArray();

        $item = array();
        // Memasukkan item ke dalam array $item
        foreach ($items as $id => $name) {
            $item[] = ['id' => $id, 'text' => $name];
        }

        $this->set(['order' => $order, 'item' => $item]);

    }

    // surat jalan
    public function get_last_permit()
    {
        $this->loadModel('Permits');
        $dataRows = $this->Permits->find('all', [
            'fields' => array('codes' => 'MAX(Permits.code)'),
        ])->first();
        $code = (!empty($dataRows->codes) ? explode("/", $dataRows['codes']) : array());
        $dataResult = isset($code[0]) ? ($code[0] + 1) : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = $result . '/SJ/NSI/' . $this->Krs->numToRome(date('m')) . '/' . date('Y');
        return $number;
    }

    public function delivery($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['Customers', 'OrderLines.MouseItems.Items'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_delivery'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);

            $tablePermits =  $this->getTableLocator()->get('Permits');
            $permit = $tablePermits->newEmptyEntity();
            $permit->date = $this->Krs->dateTo($dataRow['dates']);
            $permit->code = $dataRow['code'];
            $permit->order_id = $dataRow['order_id'];
            $permit->is_create = $dataRow['is_delivery'];
            $permit->description = $dataRow['description'];
            $permit->delivered = $dataRow['delivered'];
            $permit->is_log = $auditLog;

            if ($tablePermits->save($permit)) {
                $permit_id = array('permit_id' => $permit->id);

                $order = $this->Orders->patchEntity($order, array_merge($dataRow, $dataAuditLog, $permit_id));
                $this->Orders->save($order);

                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }

        $data['lastNumber'] = $this->get_last_permit();
        $this->set(compact('order', 'data'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function approve($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['OrderLines.Items', 'Customers'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {  


            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_approve'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Approve");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('status_date' => date('Y-m-d'));
            $status = array('status_wait' => 'Yes');

            $order = $this->Orders->patchEntity($order, array_merge($dataRow, $dataAuditLog, $date, $status));
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $this->set(compact('order'));
    }

    public function getitem()
    {
        $this->autoRender = false;
        $this->loadModel('Items'); 
        $this->loadModel('BranchStocks');
        $this->loadModel('WarehouseStocks');

        // Mengambil item berdasarkan jenis entitas (toko atau gudang) dan ID entitas
        $itemIds = array();
        if ($this->request->getQuery('type') == 'branch') {
            // Mengambil item dari BranchStocks berdasarkan ID toko
            $items = $this->BranchStocks->find('all')->where(['BranchStocks.branch_id' => $this->request->getQuery('id')])->toArray();
            $itemIds =  Hash::extract($items, '{n}.item_id');
        } else {
            // Mengambil item dari WarehouseStocks berdasarkan ID gudang
            $items = $this->WarehouseStocks->find('all')->where(['WarehouseStocks.warehouse_id' => $this->request->getQuery('id')])->toArray();
            $itemIds =  Hash::extract($items, '{n}.item_id');
        }

        // Mengambil item dari tabel Items berdasarkan item_ids yang sudah didapatkan sebelumnya
        $itemsData = $this->Items->find('all')->where(['Items.id IN' => $itemIds])->toArray();

        // Memformat data item untuk dikirim sebagai respons
        $itemsResponse = array();
        foreach ($itemsData as $index => $item) {
            $itemsResponse[$index]['id'] = $item->id;
            $itemsResponse[$index]['text'] = $item->name;
        }

        // Mengirim data item sebagai respons dalam format JSON
        return $this->response->withType("application/json")->withStringBody(json_encode($itemsResponse));
    }

    public function setitem()
    {
        $this->autoRender = false;
        $this->loadModel('Items');
        $this->loadModel('BranchStocks');
        $this->loadModel('WarehouseStocks');

        // Mengambil data item dari tabel Items berdasarkan ID yang diberikan
        $item = $this->Items->find('all')->where(['Items.id' => $this->request->getQuery('id')])->first();

        // Periksa jenis entitas (cabang atau gudang)
        if ($this->request->getQuery('type') == 'branch') {
            // Mengambil stok item dari BranchStocks berdasarkan ID item dan ID toko
            $itemStock = $this->BranchStocks->find('all')->where(['BranchStocks.item_id' => $item->id, 'BranchStocks.branch_id' =>  $this->request->getQuery('itemId')])->first();
            //$itemStock = null; // Sesuaikan dengan kebutuhan Anda
        } else {
            // Mengambil stok item dari WarehouseStocks berdasarkan ID item dan ID gudang
            $itemStock = $this->WarehouseStocks->find('all')->where(['WarehouseStocks.item_id' => $item->id, 'WarehouseStocks.warehouse_id' =>  $this->request->getQuery('itemId')])->first();
            //$itemStock = null; // Sesuaikan dengan kebutuhan Anda
        }

        // Mengirim data item dan stok sebagai respons dalam format JSON
        return $this->response->withType("application/json")->withStringBody(json_encode([$item, $itemStock]));
    }


    public function excel() 
    {
        ini_set('memory_limit', '2048M');

        $session = $this->getRequest()->getSession(); //get session
        $condition = $session->read('condition');
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'No. Order');
        $sheet->setCellValue('B1', 'Customer');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Status Order');
        $sheet->setCellValue('E1', 'Total');
        $sheet->setCellValue('F1', 'Admin');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }


        $report = $this->Orders->find('all')->contain(['Customers', 'Users'])->where([$condition])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $dataGrandTotal = $this->Krs->_currency($data->grandtotal);

            $sheet->setCellValue('A' . $row, $data->code);
            $sheet->setCellValue('B' . $row, (!empty($data->pelanggan) ? $data->pelanggan->name : '-'));
            $sheet->setCellValue('C' . $row,  $this->Krs->fDate($data->date, 'd-m-Y'));
            $sheet->setCellValue('D' . $row, $this->Krs->statusWaitOrder($data->status_wait));
            $sheet->setCellValue('E' . $row, $dataGrandTotal);
            $sheet->setCellValue('F' . $row, (!empty($data->user) ? $data->user->code : '-'));
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Order - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
