<?php

declare(strict_types=1);

namespace App\Controller\Transaction; 

use App\Controller\AppController;
use Cake\Utility\Hash; 
use Cake\I18n\Date;

// export 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
  
/**
 * Invoices Controller
 *
 * @property \App\Model\Table\InvoicesTable $Invoices
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InvoicesController extends AppController  
{
    /**
     * Index method
     *  
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $invoices = $this->Invoices->find('all')->contain(['Orders.Customers', 'Users']); 

        $code = $this->request->getQuery('filtercode');
        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');
        $customer = $this->request->getQuery('filtercustomer');
        $deliver = $this->request->getQuery('filterdeliver');
        $status = $this->request->getQuery('filterstatus');  

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Invoices.code like'] = '%' . $code . '%';
        }

        if (!empty($customer)) {
            $dataWhere['Customers.name like'] = '%' . $customer . '%';
        }

        if (!empty($deliver)) {
            $dataWhere['Invoices.delivered like'] = '%' . $deliver . '%';
        }
        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(Invoices.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }
        if (!empty($status)) {
            $dataWhere['Invoices.payment'] =  $status;  
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $invoices->where([$dataWhere])->order(['Invoices.code' => 'DESC']) : $invoices->order(['Invoices.code' => 'DESC']);

        $this->set('invoices', $this->paginate($queries, ['limit' => '10']));
    } 

    /**
     * View method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoice = $this->Invoices->get($id, [
            'contain' => [
                'Orders.OrderLines', 
                'Orders.OrderLines.Items',
                'Orders.Customers',  
                'Customers',
                'Receipts' => [
                    'sort' => ['Receipts.date' => 'ASC'] // Mengurutkan berdasarkan tanggal
                ]
            ],
        ]);

        $this->set(compact('invoice'));
    }

    public function childView($id = null)
    {
        $invoice = $this->Invoices->get($id, [
            'contain' => [
                'Orders.OrderLines', 
                'Orders.OrderLines.Items',
                'Orders.Customers',  
                'Customers',
                'Receipts' => [
                    'sort' => ['Receipts.date' => 'ASC'] // Mengurutkan berdasarkan tanggal
                ]
            ],
        ]);

        $parentInvoiceCode = '-';
        if ($invoice->parent_id > 0) {
            $parentInvoice = $this->Invoices->find()
                ->select(['code'])
                ->where(['id' => $invoice->parent_id])
                ->first();
            if ($parentInvoice) {
                $parentInvoiceCode = $parentInvoice->code;
            }
        }

        $this->set(compact('invoice', 'parentInvoiceCode'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function get_last_number()
    {
        $dataRows = $this->Invoices->find('all', [ 
            'fields' => array('codes' => 'MAX(Invoices.code)'),
        ])->first();
        $code = (!empty($dataRows->codes) ? explode("/", $dataRows['codes']) : array());
        $dataResult = isset($code[0]) ? ($code[0] + 1) : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = $result . '/INV/NSI/' . $this->Krs->numToRome(date('m')) . '/' . date('Y');
        return $number;
    }

    public function get_last_number_kuitansi()
    {
        // Mengambil kode kuitansi terakhir dari tabel Receipts
        $dataRows = $this->Receipts->find('all', [
            'fields' => ['codes' => 'MAX(Receipts.code)'],
        ])->first();

        // Memisahkan kode kuitansi berdasarkan delimiter "/"
        $code = !empty($dataRows->codes) ? explode("/", $dataRows['codes']) : [];

        // Menghasilkan nomor urut berikutnya
        // Mengambil bagian pertama dari kode yang dipecah, diharapkan berupa angka
        $dataResult = isset($code[0]) ? intval(substr($code[0], 2)) + 1 : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);

        // Menyusun format nomor kuitansi yang baru
        $number = 'K.' . $result . '/NSI/' . $this->Krs->numToRome(date('m')) . '/' . date('Y');
        
        return $number;
    }

    public function add()
    {
        $invoice = $this->Invoices->newEmptyEntity(); 
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "Add"); 
            $dataAuditLog = ['is_log' => $auditLog];
            $date = ['date' => $this->Krs->dateTo($dataRow['dates'])];
            $expired = ['expired' => $this->Krs->dateTo($dataRow['expireds'])];
            $ppn = ['ppn' => $dataRow['ppns']];
            $grandTotal = ['grandtotal' => $this->Krs->nom2Dec($dataRow['grandtotal'])];
            $dpPpn = ['dp_ppn' => $dataRow['dp_ppns']];
            $dpNominal = ['dp_nominal' => $this->Krs->nom2Dec($dataRow['nominals'])];
            $dpMethod = ['dp_method' => $dataRow['dp_methods']];

            $orders = []; 
            if (isset($dataRow['orders'])) {
                foreach ($dataRow['orders'] as $index => $value) { 
                    $orders[$index]['id'] = $dataRow['order_id'];
                    $orders[$index]['deliver_pays'] = $this->Krs->nom2Dec($value['ship_payments']);
                    // $orders[$index]['discount'] = $value['discount'];
                    $orders[$index]['grandtotal'] = $this->Krs->nom2Dec($dataRow['grandtotal']);
                } 
            }

            $order_lines = [];
            if (isset($dataRow['order_lines'])) { 
                foreach ($dataRow['order_lines'] as $index => $value) {
                    $order_lines[$index]['id'] = $value['order_line_id'];
                    $order_lines[$index]['price_t'] = $this->Krs->nom2Dec($value['price_t']);
                    $order_lines[$index]['discount'] = $this->Krs->nom2Dec($value['discount']);
                    $order_lines[$index]['subtotal'] = $this->Krs->nom2Dec($value['subtotal']); 
                }
            }

            // Memperbarui invoice 
            $dataRow['orders'] = $orders;
            $dataRow['order_lines'] = $order_lines;
            $invoice = $this->Invoices->patchEntity($invoice, array_merge($dataRow, $dataAuditLog, $date, $expired, $ppn, $grandTotal, $dpNominal, $dpPpn, $dpMethod));

            // pr($dataRow);

            if ($this->Invoices->save($invoice)) {
                // Update order jika berhasil
                $tableOrders = $this->getTableLocator()->get('Orders');
                foreach ($orders as $orderData) {
                    $order = $tableOrders->get($orderData['id']);
                    $order = $tableOrders->patchEntity($order, $orderData);
                    $id = $invoice->id;
                    $order->invoice_id = $id;
                    $tableOrders->save($order);
                }

                // Update order_lines jika berhasil
                $tableOrderLines = $this->getTableLocator()->get('OrderLines');
                foreach ($order_lines as $orderLineData) {
                    $orderLine = $tableOrderLines->get($orderLineData['id']);
                    $orderLine = $tableOrderLines->patchEntity($orderLine, $orderLineData);
                    $tableOrderLines->save($orderLine);
                }

                $this->Flash->success(__('The invoice has been saved.'));
                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
        }

        // Kode untuk menyiapkan data untuk view
        $data['lastNumber'] = $this->get_last_number();
        $this->loadModel('Orders');
        $this->loadModel('Customers');
        $this->loadModel('OrderLines');

        $orderLines = $this->OrderLines->find()
            ->contain('Items')
            ->toList();

        $orderIds = $this->Orders->find('list', ['keyField' => 'id', 'valueField' => 'id'])
            ->where(['Orders.status_wait' => 'Wait'])
            ->toArray();

        $customerIds = Hash::extract($orderIds, '{n}.customer_id');
        $customers = $this->Customers->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        $orders = $this->Orders->find('list', ['keyField' => 'id', 'valueField' => 'code']);

        $this->set(compact('invoice', 'data', 'customers', 'orderLines', 'orders'));
    }

    public function child($id = null)
    {
        // Ambil data yang sudah ada berdasarkan ID
        $invoice = $this->Invoices->get($id, [
            'contain' => ['Customers', 'Orders.OrderLines.Items'],
        ]);
        
        // Jika form di-submit
        if ($this->request->is(['patch', 'post', 'put'])) {
            // Ambil data dari form
            $dataRow = $this->request->getData();
            
            // Ambil data tambahan untuk log, tanggal, dll.
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "Add"); 
            $dataAuditLog = ['is_log' => $auditLog];
            $date = ['date' => $this->Krs->dateTo($dataRow['dates'])];
            $expired = ['expired' => $this->Krs->dateTo($dataRow['expireds'])];
            $ppn = ['proforma_ppn' => $dataRow['ppns']];
            $nominal = ['proforma_nominal' => $this->Krs->nom2Dec($dataRow['nominals'])];

            // Membuat entitas baru untuk data invoice baru
            $newInvoice = $this->Invoices->newEmptyEntity(); 

            // Patch data yang diambil dari form
            $newInvoice = $this->Invoices->patchEntity($newInvoice, array_merge($dataRow, $dataAuditLog, $date, $expired, $ppn, $nominal));

            // pr($dataRow);

            // Simpan data baru (ID baru otomatis diberikan)
            if ($this->Invoices->save($newInvoice)) {
                $this->Flash->success(__('The invoice has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
        }

        // Kode untuk menyiapkan data untuk view
        $data['lastNumber'] = $this->get_last_number();
        $this->loadModel('Orders');
        $this->loadModel('Customers');
        $this->loadModel('OrderLines');

        $orderLines = $this->OrderLines->find()
            ->contain('Items')
            ->toList();

        $orderIds = $this->Orders->find('list', ['keyField' => 'id', 'valueField' => 'id'])
            ->where(['Orders.status_wait' => 'Wait'])
            ->toArray();

        $customerIds = Hash::extract($orderIds, '{n}.customer_id');
        $customers = $this->Customers->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        $orders = $this->Orders->find('list', ['keyField' => 'id', 'valueField' => 'code']);

        $this->set(compact('invoice', 'data', 'customers', 'orderLines', 'orders'));
    }
 
    /**
     * Edit method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function childEdit($id = null)
    {
        // Ambil data yang sudah ada berdasarkan ID
        $invoice = $this->Invoices->get($id, [
            'contain' => ['Customers', 'Orders.OrderLines.Items'],
        ]);
        
        // Jika form di-submit
        if ($this->request->is(['patch', 'post', 'put'])) {
            // Ambil data dari form
            $dataRow = $this->request->getData();
            
            // Ambil data tambahan untuk log, tanggal, dll.
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "Edit"); 
            $dataAuditLog = ['is_log' => $auditLog];
            $date = ['date' => $this->Krs->dateTo($dataRow['dates'])];
            $expired = ['expired' => $this->Krs->dateTo($dataRow['expireds'])];
            $ppn = ['proforma_ppn' => $dataRow['ppns']];
            $nominal = ['proforma_nominal' => $this->Krs->nom2Dec($dataRow['nominals'])];

            // Patch data yang diambil dari form
            $invoice = $this->Invoices->patchEntity($invoice, array_merge($dataRow, $dataAuditLog, $date, $expired, $ppn, $nominal));

            // pr($dataRow);

            // Simpan data baru (ID baru otomatis diberikan)
            if ($this->Invoices->save($invoice)) {
                $this->Flash->success(__('The invoice has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
        }

        // Kode untuk menyiapkan data untuk view
        $data['lastNumber'] = $this->get_last_number();
        $this->loadModel('Orders');
        $this->loadModel('Customers');
        $this->loadModel('OrderLines');

        $orderLines = $this->OrderLines->find()
            ->contain('Items')
            ->toList();

        $orderIds = $this->Orders->find('list', ['keyField' => 'id', 'valueField' => 'id'])
            ->where(['Orders.status_wait' => 'Wait'])
            ->toArray();

        $customerIds = Hash::extract($orderIds, '{n}.customer_id');
        $customers = $this->Customers->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        $orders = $this->Orders->find('list', ['keyField' => 'id', 'valueField' => 'code']);

        $parentInvoiceCode = '-';
        if ($invoice->parent_id > 0) {
            $parentInvoice = $this->Invoices->find()
                ->select(['code'])
                ->where(['id' => $invoice->parent_id])
                ->first();
            if ($parentInvoice) {
                $parentInvoiceCode = $parentInvoice->code;
            }
        }

        $this->set(compact('invoice', 'data', 'customers', 'orderLines', 'orders', 'parentInvoiceCode'));
    }

    public function edit($id = null)
    {
        $invoice = $this->Invoices->get($id, [
            'contain' => ['Customers', 'Orders.OrderLines.Items'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "Edit"); 
            $dataAuditLog = ['is_log' => $auditLog];
            $date = ['date' => $this->Krs->dateTo($dataRow['dates'])];
            $expired = ['expired' => $this->Krs->dateTo($dataRow['expireds'])];
            $ppn = ['ppn' => $dataRow['ppns']];
            $grandTotal = ['grandtotal' => $this->Krs->nom2Dec($dataRow['grandtotal'])];
            $dpPpn = ['dp_ppn' => $dataRow['dp_ppns']];
            $dpNominal = ['dp_nominal' => $this->Krs->nom2Dec($dataRow['nominals'])];

            $orders = [];
            if (isset($dataRow['orders'])) {
                foreach ($dataRow['orders'] as $index => $value) {
                    $orders[$index]['id'] = $dataRow['order_id'];
                    $orders[$index]['deliver_pays'] = $this->Krs->nom2Dec($value['ship_payments']);
                    // $orders[$index]['discount'] = $value['discount'];
                    $orders[$index]['grandtotal'] = $this->Krs->nom2Dec($dataRow['grandtotal']);
                } 
            }

            $order_lines = [];
            if (isset($dataRow['order_lines'])) {
                foreach ($dataRow['order_lines'] as $index => $value) {
                    $order_lines[$index]['id'] = $value['order_line_id']; 
                    $order_lines[$index]['quantity'] = $value['quantity']; 
                    $order_lines[$index]['price_t'] = $this->Krs->nom2Dec($value['price_t']);
                    $order_lines[$index]['discount'] = $this->Krs->nom2Dec($value['discount']);
                    $order_lines[$index]['subtotal'] = $this->Krs->nom2Dec($value['subtotal']); 
                }
            }

            // Memperbarui invoice
            $dataRow['orders'] = $orders;
            $dataRow['order_lines'] = $order_lines;
            $invoice = $this->Invoices->patchEntity($invoice, array_merge($dataRow, $dataAuditLog, $date, $expired, $ppn, $grandTotal, $dpPpn, $dpNominal));

            // pr($dataRow);

            if ($this->Invoices->save($invoice)) {
                // Update order jika berhasil
                $tableOrders = $this->getTableLocator()->get('Orders');
                foreach ($orders as $orderData) {
                    $order = $tableOrders->get($orderData['id']);
                    $order = $tableOrders->patchEntity($order, $orderData);
                    $id = $invoice->id;
                    $order->invoice_id = $id;
                    $tableOrders->save($order);
                }

                // Update order_lines jika berhasil
                $tableOrderLines = $this->getTableLocator()->get('OrderLines');
                foreach ($order_lines as $orderLineData) {
                    $orderLine = $tableOrderLines->get($orderLineData['id']);
                    $orderLine = $tableOrderLines->patchEntity($orderLine, $orderLineData);
                    $tableOrderLines->save($orderLine);
                }

                $this->Flash->success(__('The invoice has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
        }

        // Kode untuk menyiapkan data untuk view
        $data['lastNumber'] = $this->get_last_number();
        $this->loadModel('Orders');
        $this->loadModel('Customers');
        $this->loadModel('OrderLines');

        $orderLines = $this->OrderLines->find()
            ->contain('Items')
            ->toList();

        $orderIds = $this->Orders->find('list', ['keyField' => 'id', 'valueField' => 'id'])
            ->where(['Orders.status_wait' => 'Wait'])
            ->toArray();

        $customerIds = Hash::extract($orderIds, '{n}.customer_id');
        $customers = $this->Customers->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        $orders = $this->Orders->find('list', ['keyField' => 'id', 'valueField' => 'code']);

        $this->set(compact('invoice', 'data', 'customers', 'orderLines', 'orders'));
    }

    public function delivery()
    {
        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');
        $code = $this->request->getQuery('filtercode');
        $status = $this->request->getQuery('filterstatus');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Invoices.code like'] = '%' . $code . '%';
        }
        if ($status == 'Belum Terkirim') {
            $dataWhere[]  =  'Invoices.delivery IS null';
        }
        if ($status == 'Terkirim') {
            $dataWhere[]  =  'Invoices.delivery IS NOT null';
        }
        if ($status == 'Semua') {
            $dataWhere[]  = 'Invoices.delivery  IS NOT null OR Invoices.delivery  IS null';
        }
        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(Invoices.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }

        // Cek apakah ada filter yang digunakan
        if (!empty($dataWhere)) {
            // Jalankan query
            $invoices = $this->Invoices->find('all')
                ->contain(['Orders.Customers'])
                ->where([$dataWhere])
                ->toArray();

            if (!empty($invoices)) {
                // Jika data ditemukan berdasarkan filter
                $queries = $invoices;
                $this->Flash->success(__('Data ditemukan.'));
            } else {
                // Jika tidak ada data yang cocok dengan filter
                $queries = array();
                $this->Flash->warning(__('Data tidak ditemukan.'));
            }
        } else {
            // Jika tidak ada filter yang digunakan
            $queries = array();
            $this->Flash->warning(__('Silahkan cari data!'));
        }

        $invoice = $this->Invoices->find('all')->toList();
        $invoiceIds = Hash::extract($invoice, '{n}.order_id');

        $this->loadModel('Orders');
        $orders = $this->Orders->find('all')->where(['Orders.id IN' => count(($invoiceIds) > 0 ? $invoiceIds : [null])])->toArray();
        $orderIds = Hash::extract($orders, '{n}.customer_id');

        $customers = $this->Orders->Customers->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Customers.id IN' => count(($orderIds) > 0 ? $orderIds : [null])])->toArray();
        $this->set(['customers' => $customers, 'invoices' => $queries]);

        // edit
        $dataSending = array();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Invoices delivery");

            $invoiceTables = $this->getTableLocator()->get('Invoices');

            foreach ($dataRow['data'] as $index => $rowInvoice) {
                if (($rowInvoice['delivery']) !== ''  || ($rowInvoice['delivery_date']) !== '' || ($rowInvoice['delivery_media']) !== '') {
                    $dataSending[$index] = $invoiceTables->get($index);
                    $dataSending[$index]['delivery'] = $rowInvoice['delivery'];
                    $dataSending[$index]['delivery_date'] = $this->Krs->dateTo($rowInvoice['delivery_date']);
                    $dataSending[$index]['delivery_media'] = $rowInvoice['delivery_media'];
                    $dataSending[$index]['delivery_desc'] = $rowInvoice['delivery_desc'];
                    $dataSending[$index]['is_log'] =  $auditLog;
                }
            }

            if ($invoiceTables->saveMany($dataSending)) {
                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                return $this->redirect(['action' => 'delivery']);
            }
            $this->Flash->error(__('Maaf data gagal disimpan, silakan masukkan data dengan benar!!'));
        }

        $this->set('dataSending', $dataSending);
    }

    public function payment()
    {
        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');
        $code = $this->request->getQuery('filtercode');
        $customer = $this->request->getQuery('filtercustomer'); 

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Invoices.code like'] = '%' . $code . '%';
        }
        if (!empty($customer)) {
            $dataWhere['Invoices.customer_id like'] = '%' . $customer . '%';
        }
        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(Invoices.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }

        // Cek apakah ada filter yang digunakan
        if (!empty($dataWhere)) {
            // Jalankan query
            $invoices = $this->Invoices->find('all')
            ->contain([
                'Customers',
                'Orders.Customers', 
                'Receipts' => [
                    'sort' => ['Receipts.date' => 'ASC'] // Mengurutkan berdasarkan tanggal
                ]
            ])
            ->where([$dataWhere])
            ->toArray();

            if (!empty($invoices)) { 
                // Jika data ditemukan berdasarkan filter
                $queries = $invoices;
                $this->Flash->success(__('Data ditemukan.'));
            } else {
                // Jika tidak ada data yang cocok dengan filter
                $queries = array();
                $this->Flash->warning(__('Data tidak ditemukan.'));
            }
        } else {
            // Jika tidak ada filter yang digunakan
            $queries = array();
            $this->Flash->warning(__('Silahkan cari data!'));
        }

        // Set data untuk view
        $invoice = $this->Invoices->find('all')->toList();
        $invoiceIds = Hash::extract($invoice, '{n}.order_id');

        $this->loadModel('Orders');
        $orders = $this->Orders->find('all')->where(['Orders.id IN' => count(($invoiceIds) > 0 ? $invoiceIds : [null])])->toArray();
        $orderIds = Hash::extract($orders, '{n}.customer_id');

        $customers = $this->Orders->Customers->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Customers.id IN' => count(($orderIds) > 0 ? $orderIds : [null])])->toArray();
        $this->set(['customers' => $customers, 'invoices' => $queries]);

        $this->loadModel('Receipts'); // Pastikan model Receipts diload

        $dataSending = array();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Invoices payment");

            $invoiceTables = $this->getTableLocator()->get('Invoices');
            $dataSending = array();

            foreach ($dataRow['data'] as $index => $rowInvoice) { 
                $dataSending[$index] = $invoiceTables->get($index);
                
                $dataSending[$index]['pph_date'] = $this->Krs->dateTo($rowInvoice['pph_date']);
                $dataSending[$index]['pph_jumlah'] = $this->Krs->nom2Dec($rowInvoice['pph_jumlah']);
                $dataSending[$index]['pph_no'] = $this->Krs->nom2Dec($rowInvoice['pph_no']);
                $dataSending[$index]['ppn_900_date'] = $this->Krs->dateTo($rowInvoice['ppn_900_date']);
                $dataSending[$index]['ppn_900_jumlah'] = $this->Krs->nom2Dec($rowInvoice['ppn_900_jumlah']);
                $dataSending[$index]['biaya_bank'] = $this->Krs->nom2Dec($rowInvoice['biaya_bank']);
                $dataSending[$index]['pembulatan'] = $this->Krs->nom2Dec($rowInvoice['pembulatan']);

                $nominalBayar = $this->Krs->nom2Dec($rowInvoice['jumlah_nominal']);
                $paymentDate = $rowInvoice['payment_date'] == '' || $rowInvoice['payment_date'] == null ? null : $this->Krs->dateTo($rowInvoice['payment_date']);
                $paymentMethod = $rowInvoice['payment_method'] == '' || $rowInvoice['payment_method'] == null ? null : $rowInvoice['payment_method'];
                $paymentDesc = $rowInvoice['payment_desc'] == '' || $rowInvoice['payment_desc'] == null ? null : $rowInvoice['payment_desc'];

                // Kondisi penyimpanan pada kolom yang sesuai
                if ($dataSending[$index]['payment_nominal_1'] === null && $dataSending[$index]['payment_date_1'] === null && $dataSending[$index]['payment_method_1'] === null) {
                    $dataSending[$index]['payment_nominal_1'] = $nominalBayar;
                    $dataSending[$index]['payment_date_1'] = $paymentDate;
                    $dataSending[$index]['payment_method_1'] = $paymentMethod;
                } elseif ($dataSending[$index]['payment_nominal_2'] === null && $dataSending[$index]['payment_date_2'] === null && $dataSending[$index]['payment_method_2'] === null) {
                    $dataSending[$index]['payment_nominal_2'] = $nominalBayar;
                    $dataSending[$index]['payment_date_2'] = $paymentDate;
                    $dataSending[$index]['payment_method_2'] = $paymentMethod;
                } else {
                    $dataSending[$index]['payment_nominal_3'] = $nominalBayar;
                    $dataSending[$index]['payment_date_3'] = $paymentDate;
                    $dataSending[$index]['payment_method_3'] = $paymentMethod;
                }

                // Ambil nilai payment_nominal_1 dari database, jika sudah ada
                $payment1 = isset($dataSending[$index]['payment_nominal_1']) 
                    ? $this->Krs->nom2Dec($dataSending[$index]['payment_nominal_1']) 
                    : 0.00;

                // Hitung total pembayaran dengan nilai yang diperbarui
                $payment2 = isset($dataSending[$index]['payment_nominal_2']) 
                    ? $this->Krs->nom2Dec($dataSending[$index]['payment_nominal_2']) 
                    : 0.00;

                $payment3 = isset($dataSending[$index]['payment_nominal_3']) 
                    ? $this->Krs->nom2Dec($dataSending[$index]['payment_nominal_3']) 
                    : 0.00;

                $totalPayment = $payment1 + $payment2 + $payment3;
                $grandTotal = $this->Krs->formatCurrency($rowInvoice['grandtotal_nominal']); 

                // Periksa apakah totalPayment sama dengan, kurang dari, atau lebih besar dari grandTotal
                if ($totalPayment == $grandTotal) {
                    $dataSending[$index]['payment'] = 'Y'; 
                } else {
                    $dataSending[$index]['payment'] = 'NP'; 
                }

                // Masukkan array $dataSending[$index] ke dalam array $dataRow['data'][$index]
                $dataRow['data'][$index] = $dataSending[$index];

                // pr($dataSending);

                // Simpan data invoice
                if ($invoiceTables->save($dataSending[$index])) {
                    // Dapatkan ID invoice yang baru disimpan
                    $invoiceId = $dataSending[$index]->id;

                    // Data untuk disimpan ke tabel receipts
                    $receiptData = [
                        'invoice_id' => $invoiceId,
                        'customer_id' => $dataSending[$index]['customer_id'],
                        'order_id' => $dataSending[$index]['order_id'],
                        'code' => $this->get_last_number_kuitansi(),
                        'date' => $this->Krs->dateTo($rowInvoice['payment_date']),
                        'nominal' => $nominalBayar,
                        'description' => $rowInvoice['payment_desc'],
                        'payment_type' => $rowInvoice['payment_type'],
                        'is_create' => $dataRow['is_update'],
                        'created' => date('Y-m-d H:i:s')
                    ];

                    // Simpan data ke tabel receipts
                    $receiptsTable = $this->getTableLocator()->get('Receipts');
                    $receiptEntity = $receiptsTable->newEntity($receiptData);

                    if ($receiptsTable->save($receiptEntity)) {
                        // Data receipt berhasil disimpan
                        $this->Flash->success(__('Kuitansi untuk Invoice #' . $dataSending[$index]['code'] . ' berhasil dibuat.'));
                    } else {
                        // Jika terjadi kesalahan dalam penyimpanan
                        $this->Flash->error(__('Terjadi kesalahan saat menyimpan kuitansi untuk Invoice #' . $dataSending[$index]['code']));
                    }
                } else {
                    $this->Flash->error(__('Gagal menyimpan data invoice ID: ' . $index));
                }
            }

            // pr($receiptData);
            // pr($dataSending[$index]);

            if ($invoiceTables->saveMany($dataSending)) {
                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));
                return $this->redirect(['action' => 'payment']);
            }
            $this->Flash->error(__('Maaf data gagal disimpan, silakan masukkan data dengan benar!!'));
        }

        $customers = $this->Invoices->Customers->find('list', ['keyField' => 'id', 'valueField' => 'name', 'limit' => 200])->toArray();

        $this->set(['dataSending' => $dataSending, 'customers' => $customers]);
    }


    /**
     * Delete method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoice = $this->Invoices->get($id);
        if ($this->Invoices->delete($invoice)) {
            $this->Flash->success(__('The invoice has been deleted.'));
        } else {
            $this->Flash->error(__('The invoice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getOrder() 
    {
        $order = $this->request->getQuery('order');
        $customer = $this->request->getQuery('customer');
        $start = $this->request->getQuery('start');
        $end = $this->request->getQuery('end');

        $this->loadModel('Orders');
        $this->loadModel('OrderLines');
        $this->loadModel('Customers'); 
        $this->loadModel('Items');

        // Membuat query dengan relasi yang diperlukan
        $orders = $this->Orders->find()->contain([
            'Customers',
            'OrderLines.Items'
        ]);

        // Membuat kondisi pencarian
        $conditions = array();

        if (!empty($order)) {
            if (is_array($order)) {
                $conditions['Orders.id IN'] = $order;
            } else {
                $conditions['Orders.id'] = $order;
            }
        }

        if (!empty($customer)) {
            if (is_array($customer)) {
                $conditions['Orders.customer_id IN'] = $customer;
            } else {
                $conditions['Orders.customer_id'] = $customer;
            }
        }

        if (!empty($start) && !empty($end)) {
            $startDate = $this->Krs->dateTo($start);
            $endDate = $this->Krs->dateTo($end);

            $conditions['Orders.date >='] = $startDate;
            $conditions['Orders.date <='] = $endDate;
        }

        // Menerapkan kondisi pada query dan mengambil hasil sebagai array
        $queries = $orders->where($conditions)
            ->andWhere(['Orders.invoice_id' => 0])
            ->all();

        // Mengelompokkan hasil berdasarkan nama pelanggan
        $group = [];
        $a = 0;
        foreach ($queries as $value) {
            $orderLines = $value->order_lines;
            $customer = $value->pelanggan;
            foreach ($orderLines as $orderLine) {
                $item = $orderLine->item;
                //pr($item);

                $group[$a]['order_id'] = $value['id'];
                $group[$a]['order_line_id'] = $orderLine['id'];
                $group[$a]['text'] = $value['code'];
                $group[$a]['customer'] = $customer['name'];
                $group[$a]['tanggal'] = $value['date'];
                $group[$a]['item'] = $item['name'];
                $group[$a]['harga'] = $this->Krs->_currency($orderLine['price_t']);
                $group[$a]['subtotal'] = $this->Krs->_currency($orderLine['subtotal']); 
                $group[$a]['jumlah'] = $orderLine['quantity'];
                $group[$a]['unit'] = $orderLine['unit'];
                $group[$a]['ppn'] = $customer['ppn'];
                $group[$a]['diskon_item'] = $this->Krs->_currency($orderLine['discount']);
                $group[$a]['biaya_pengiriman'] = $this->Krs->_currency($value['deliver_pays']);
                $group[$a]['diskon'] = $this->Krs->_currency($value['discount']);
                $group[$a]['expired_date'] = $orderLine['expired_date'];
                $group[$a]['keterangan'] = $orderLine['comment'];
                $group[$a]['note'] = $value['keterangan'];
                $a++;
                //$group[$value->customer][] = $value;
            }
        } 

        $data = [
            'result' => $group
        ];

        // Mengembalikan hasil dalam format JSON
        return $this->response->withType('application/json')->withStringBody(json_encode($data));
    }

    public function print($id = null)   
    {
        // Ambil data invoice beserta relasi yang dibutuhkan
        $invoices = $this->Invoices->get($id, [
            'contain' => ['Customers', 'Orders.OrderLines', 'Orders.Customers', 'Orders.OrderLines.Items'], 
        ]);

        $order_id = $invoices->order_id;
        $receiptsTable = $this->getTableLocator()->get('Receipts');
        $receipts = $receiptsTable->find('all', [
            'conditions' => ['Receipts.order_id' => $order_id]
        ])->toArray();

        // Ambil data yang diperlukan dari objek invoice
        $customer_name = !empty($invoices->customer_id) ? $invoices->customer->name : '';
        $invoice_code = !empty($invoices->code) ? $invoices->code : '';
        $current_date = !empty($invoices->date) ? date('d-m-Y', strtotime($invoices->date->format('Y-m-d'))) : '';

        // Membuat nama file dinamis berdasarkan tanggal download, referense_po, nama customer, dan kode invoice
        $filename = $current_date . ' - ' . $customer_name . ' - ' . $invoice_code ;

        // Matikan layout default dan set PDF view
        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');

        // Mengatur agar file PDF tidak di-download secara otomatis
        $this->viewBuilder()->setOption('pdfConfig', [
            'orientation' => 'portrait',
            'download' => true, // Agar file terbuka di tab/jendela baru
            'filename' => $filename . '.pdf'
        ]); 

        // Simpan informasi rpt_invoice
        $invoiceTable = $this->getTableLocator()->get('Invoices');
        $invoice = $invoiceTable->get($id);

        $invoice->rpt_invoice = $invoice->rpt_invoice + 1;
        $invoice->rpt_invoice_date = date('Y-m-d H:i:s');
        $invoiceTable->save($invoice);

        // Mengirim data ke view
        $this->set(array(
            'report' => $invoices,
            'receipt' => $receipts
        ));
    }

    public function printOut($id = null)  
    {
        // Ambil data invoice beserta relasi yang dibutuhkan
        $invoices = $this->Invoices->get($id, [
            'contain' => ['Customers', 'Orders.OrderLines', 'Orders.Customers', 'Orders.OrderLines.Items'], 
        ]);

        $order_id = $invoices->order_id;
        $receiptsTable = $this->getTableLocator()->get('Receipts');
        $receipts = $receiptsTable->find('all', [
            'conditions' => ['Receipts.order_id' => $order_id]
        ])->toArray();

        // Ambil data yang diperlukan dari objek invoice
        $customer_name = !empty($invoices->customer_id) ? $invoices->customer->name : '';
        $invoice_code = !empty($invoices->code) ? $invoices->code : '';
        $current_date = !empty($invoices->date) ? date('d-m-Y', strtotime($invoices->date->format('Y-m-d'))) : '';

        // Membuat nama file dinamis berdasarkan tanggal download, referense_po, nama customer, dan kode invoice
        $filename = $current_date . ' - ' . $customer_name . ' - ' . $invoice_code ;

        // Matikan layout default dan set PDF view
        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');

        // Mengatur agar file PDF tidak di-download secara otomatis
        $this->viewBuilder()->setOption('pdfConfig', [
            'orientation' => 'portrait',
            'download' => true, // Agar file terbuka di tab/jendela baru
            'filename' => $filename . '.pdf'
        ]);

        // Simpan informasi rpt_invoice
        $invoiceTable = $this->getTableLocator()->get('Invoices');
        $invoice = $invoiceTable->get($id);

        $invoice->rpt_invoice = $invoice->rpt_invoice + 1;
        $invoice->rpt_invoice_date = date('Y-m-d H:i:s');
        $invoiceTable->save($invoice);

        // Mengirim data ke view
        $this->set(array(
            'report' => $invoices,
            'receipt' => $receipts
        ));
    }

    public function childPrint($id = null)   
    {
        // Ambil data invoice beserta relasi yang dibutuhkan
        $invoices = $this->Invoices->get($id, [
            'contain' => ['Customers', 'Orders.OrderLines', 'Orders.Customers', 'Orders.OrderLines.Items'], 
        ]);

        $order_id = $invoices->order_id;
        $receiptsTable = $this->getTableLocator()->get('Receipts');
        $receipts = $receiptsTable->find('all', [
            'conditions' => ['Receipts.order_id' => $order_id]
        ])->toArray();

        // Ambil data yang diperlukan dari objek invoice
        $customer_name = !empty($invoices->customer_id) ? $invoices->customer->name : '';
        $invoice_code = !empty($invoices->code) ? $invoices->code : '';
        $current_date = !empty($invoices->date) ? date('d-m-Y', strtotime($invoices->date->format('Y-m-d'))) : '';

        // Membuat nama file dinamis berdasarkan tanggal download, referense_po, nama customer, dan kode invoice
        $filename = $current_date . ' - ' . $customer_name . ' - ' . $invoice_code ;

        // Matikan layout default dan set PDF view
        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');

        // Mengatur agar file PDF tidak di-download secara otomatis
        $this->viewBuilder()->setOption('pdfConfig', [
            'orientation' => 'portrait',
            'download' => true, // Agar file terbuka di tab/jendela baru
            'filename' => $filename . '.pdf'
        ]);

        // Simpan informasi rpt_invoice
        $invoiceTable = $this->getTableLocator()->get('Invoices');
        $invoice = $invoiceTable->get($id);

        $invoice->rpt_invoice = $invoice->rpt_invoice + 1;
        $invoice->rpt_invoice_date = date('Y-m-d H:i:s');
        $invoiceTable->save($invoice);

        // Mengirim data ke view
        $this->set(array(
            'report' => $invoices,
            'receipt' => $receipts
        ));
    }

    public function childPrintOut($id = null)   
    {
        // Ambil data invoice beserta relasi yang dibutuhkan
        $invoices = $this->Invoices->get($id, [
            'contain' => ['Customers', 'Orders.OrderLines', 'Orders.Customers', 'Orders.OrderLines.Items'], 
        ]);

        $order_id = $invoices->order_id;
        $receiptsTable = $this->getTableLocator()->get('Receipts');
        $receipts = $receiptsTable->find('all', [
            'conditions' => ['Receipts.order_id' => $order_id]
        ])->toArray();

        // Ambil data yang diperlukan dari objek invoice
        $customer_name = !empty($invoices->customer_id) ? $invoices->customer->name : '';
        $invoice_code = !empty($invoices->code) ? $invoices->code : '';
        $current_date = !empty($invoices->date) ? date('d-m-Y', strtotime($invoices->date->format('Y-m-d'))) : '';

        // Membuat nama file dinamis berdasarkan tanggal download, referense_po, nama customer, dan kode invoice
        $filename = $current_date . ' - ' . $customer_name . ' - ' . $invoice_code ;

        // Matikan layout default dan set PDF view
        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');

        // Mengatur agar file PDF tidak di-download secara otomatis
        $this->viewBuilder()->setOption('pdfConfig', [
            'orientation' => 'portrait',
            'download' => true, // Agar file terbuka di tab/jendela baru
            'filename' => $filename . '.pdf'
        ]);

        // Simpan informasi rpt_invoice
        $invoiceTable = $this->getTableLocator()->get('Invoices');
        $invoice = $invoiceTable->get($id);

        $invoice->rpt_invoice = $invoice->rpt_invoice + 1;
        $invoice->rpt_invoice_date = date('Y-m-d H:i:s');
        $invoiceTable->save($invoice);

        // Mengirim data ke view
        $this->set(array(
            'report' => $invoices,
            'receipt' => $receipts
        ));
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
        $sheet->setCellValue('A1', 'No. Invoice');
        $sheet->setCellValue('B1', 'Tanggal Invoice');
        $sheet->setCellValue('C1', 'Tanggal Jatuh Tempo');
        $sheet->setCellValue('D1', 'Marketing');
        $sheet->setCellValue('E1', 'Area');
        $sheet->setCellValue('F1', 'Customer');
        $sheet->setCellValue('G1', 'Deskripsi Barang');
        $sheet->setCellValue('H1', 'Qty');
        $sheet->setCellValue('I1', 'Unit');
        $sheet->setCellValue('J1', 'Price');
        $sheet->setCellValue('K1', 'Discount');
        $sheet->setCellValue('L1', 'Subtotal');
        $sheet->setCellValue('M1', 'Total');
        $sheet->setCellValue('N1', 'PPN');
        $sheet->setCellValue('O1', 'Nominal');
        $sheet->setCellValue('P1', 'Status');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }


        $report = $this->Invoices->find('all')->contain(['Orders.OrderLines.Items', 'Customers', 'Customers.Users'])->where([$condition])->toArray();

        $prevInvoiceId = null;
        $mergeStartRow = 2;
        $row = 2;
        
        foreach ($report as $index => $data) {
            $customers = $data->customer;
            $orders = $data->order;
            $marketing = $customers->user->name ?? '-';
            $customerName = $customers->name ?? '-';
            $area = $customers->area ?? '-';
            $ppn = $orders->ppn;
            $grandTotal = $orders->grandtotal;
            $total = $grandTotal / 1.11;
            $dataPpn = ($ppn > 0) ? ($total * 11) / 100 : 0;
            $status = $this->Krs->statusInvoice($data->payment);

            // Cek apakah invoice_id sama dengan sebelumnya
            if ($prevInvoiceId === $data->id) {
                // Jika sama, hanya isi kolom Item, Quantity, Price, Discount, dan Subtotal
                $mergeEndRow = $row;
            } else {
                // Jika tidak sama, merge kolom sebelumnya jika ada
                if ($mergeStartRow < $row - 1) {
                    $sheet->mergeCells("A{$mergeStartRow}:A" . ($row - 1)); // No. Invoice
                    $sheet->mergeCells("B{$mergeStartRow}:B" . ($row - 1)); // Tanggal Invoice
                    $sheet->mergeCells("C{$mergeStartRow}:C" . ($row - 1)); // Tanggal Jatuh Tempo
                    $sheet->mergeCells("D{$mergeStartRow}:D" . ($row - 1)); // Marketing
                    $sheet->mergeCells("E{$mergeStartRow}:E" . ($row - 1)); // Area
                    $sheet->mergeCells("F{$mergeStartRow}:F" . ($row - 1)); // Customer
                    $sheet->mergeCells("L{$mergeStartRow}:L" . ($row - 1)); // Total
                    $sheet->mergeCells("M{$mergeStartRow}:M" . ($row - 1)); // PPN
                    $sheet->mergeCells("N{$mergeStartRow}:N" . ($row - 1)); // Nominal
                    $sheet->mergeCells("O{$mergeStartRow}:O" . ($row - 1)); // Status
                }
                $mergeStartRow = $row; // Set awal merge baru

                // Isi kolom utama
                $sheet->setCellValue('A' . $row, $data->code);
                $sheet->setCellValue('B' . $row, $this->Krs->fDate($data->date, 'd-m-Y'));
                $sheet->setCellValue('C' . $row, $this->Krs->fDate($data->expired, 'd-m-Y'));
                $sheet->setCellValue('D' . $row, $marketing);
                $sheet->setCellValue('E' . $row, $area);
                $sheet->setCellValue('F' . $row, $customerName);
                $sheet->setCellValueExplicit('M' . $row, $this->Krs->_currency($total), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('N' . $row, $this->Krs->_currency($dataPpn), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('O' . $row, $this->Krs->_currency($data->grandtotal), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('P' . $row, $status);
            }

            // Loop untuk menampilkan detail item
            foreach ($orders->order_lines as $orderLine) {
                $itemName = $orderLine->item->name ?? '-';
                $quantity = $orderLine->quantity ?? 0;
                $unit = $orderLine->unit ?? '-';
                $price = $orderLine->price_t ?? 0;
                $discount = $orderLine->discount ?? 0;
                $subtotal = $orderLine->subtotal ?? 0;

                $sheet->setCellValue('G' . $row, $itemName);
                $sheet->setCellValue('H' . $row, $quantity);
                $sheet->setCellValue('I' . $row, $unit);
                $sheet->setCellValueExplicit('J' . $row, $this->Krs->_currency($price), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('K' . $row, $this->Krs->_currency($discount), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('L' . $row, $this->Krs->_currency($subtotal), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $row++;
            }

            $prevInvoiceId = $data->id;
        }

        // Merge terakhir jika masih ada yang belum di-merge
        if ($mergeStartRow < $row - 1) {
            $sheet->mergeCells("A{$mergeStartRow}:A" . ($row - 1));
            $sheet->mergeCells("B{$mergeStartRow}:B" . ($row - 1));
            $sheet->mergeCells("C{$mergeStartRow}:C" . ($row - 1));
            $sheet->mergeCells("D{$mergeStartRow}:D" . ($row - 1));
            $sheet->mergeCells("E{$mergeStartRow}:E" . ($row - 1));
            $sheet->mergeCells("F{$mergeStartRow}:F" . ($row - 1));
            $sheet->mergeCells("M{$mergeStartRow}:M" . ($row - 1));
            $sheet->mergeCells("N{$mergeStartRow}:N" . ($row - 1));
            $sheet->mergeCells("O{$mergeStartRow}:O" . ($row - 1));
            $sheet->mergeCells("P{$mergeStartRow}:P" . ($row - 1));
        }

        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Invoice - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
