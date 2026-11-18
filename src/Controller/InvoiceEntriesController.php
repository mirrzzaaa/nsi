<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;

// export 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * InvoiceEntries Controller
 *
 * @property \App\Model\Table\InvoiceEntriesTable $InvoiceEntries
 * @method \App\Model\Entity\InvoiceEntry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InvoiceEntriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $invoiceEntries = $this->InvoiceEntries->find('all')->contain(['Purchasings.Suppliers']); 

        $code = $this->request->getQuery('filtercode');
        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');
        $customer = $this->request->getQuery('filtercustomer');
        $deliver = $this->request->getQuery('filterdeliver');
        $status = $this->request->getQuery('filterstatus');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['invoiceEntries.code like'] = '%' . $code . '%';
        }

        if (!empty($customer)) {
            $dataWhere['Suppliers.name like'] = '%' . $customer . '%';
        }

        if (!empty($deliver)) {
            $dataWhere['invoiceEntries.delivered like'] = '%' . $deliver . '%';
        }
        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(invoiceEntries.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }
        if (!empty($status)) {
            $dataWhere['invoiceEntries.payment_status'] =  $status;
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $invoiceEntries->where([$dataWhere])->order(['InvoiceEntries.code' => 'DESC']) : $invoiceEntries->order(['InvoiceEntries.code' => 'DESC']);

        $this->set('invoiceEntries', $this->paginate($queries, ['limit' => '10']));

    }

    /**
     * View method
     *
     * @param string|null $id Invoice Entry id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoiceEntry = $this->InvoiceEntries->get($id, [
            'contain' => ['Purchasings.PurchasingLines', 'Purchasings.PurchasingLines.Items', 'Purchasings.Suppliers'],
        ]);

        $this->set(compact('invoiceEntry'));
    }

    public function get_last_number()
    {
        $dataRows = $this->InvoiceEntries->find('all', [
            'fields' => array('codes' => 'MAX(InvoiceEntries.code)'),
        ])->first();
        $code = (!empty($dataRows->codes) ? explode("/", $dataRows['codes']) : array());
        $dataResult = isset($code[0]) ? ($code[0] + 1) : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = $result . '/INV-ENTRY/NSI.' . $this->Krs->numToRome(date('m')) . '-' . date('Y');
        return $number;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function add()
    {
        $invoiceEntry = $this->InvoiceEntries->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['dates'])); 
            $dueDate = array('due_date' => $this->Krs->dateTo($dataRow['due_dates']));
            $ppn = ['ppn' => $dataRow['ppns']];

            $purchasings = [];
            if ($dataRow['purchasings']) {
                foreach ($dataRow['purchasings'] as $index => $value) {
                    $purchasings[$index]['id'] = $dataRow['purchasing_id'];
                    $purchasings[$index]['ship_payment'] = $this->Krs->nom2Dec($value['ship_payments']);
                    $purchasings[$index]['discount'] = $value['discounts'];
                    $purchasings[$index]['grandtotal'] = $this->Krs->nom2Dec($value['grandtotal']);
                }
            }

            $purchasing_lines = [];
            if ($dataRow['purchasing_lines']) {
                foreach ($dataRow['purchasing_lines'] as $index => $value) {
                    $purchasing_lines[$index]['id'] = $value['purchasing_line_id'];
                    $purchasing_lines[$index]['price'] = $this->Krs->nom2Dec($value['price']);
                    $purchasing_lines[$index]['discount'] = $value['discount'];
                    $purchasing_lines[$index]['subtotal'] = $this->Krs->nom2Dec($value['subtotal']);
                }
            }

            // Memperbarui invoice
            $dataRow['purchasings'] = $purchasings;
            $dataRow['purchasing_lines'] = $purchasing_lines;
            $invoiceEntry = $this->InvoiceEntries->patchEntity($invoiceEntry, array_merge($dataRow, $dataAuditLog, $date, $dueDate, $ppn));

            // pr($dataRow);

            if ($this->InvoiceEntries->save($invoiceEntry)) {
                // Update purchase jika berhasil
                $tablePurchasings = $this->getTableLocator()->get('Purchasings');
                foreach ($purchasings as $purchaseData) {
                    $purchase = $tablePurchasings->get($purchaseData['id']);
                    $purchase = $tablePurchasings->patchEntity($purchase, $purchaseData);
                    $id = $invoiceEntry->id;
                    $purchase->invoice_entry_id = $id;
                    $tablePurchasings->save($purchase);
                }

                // Update purchasing_lines jika berhasil
                $tablePurchasingLines = $this->getTableLocator()->get('PurchasingLines');
                foreach ($purchasing_lines as $purchaseLineData) {
                    $purchaseLine = $tablePurchasingLines->get($purchaseLineData['id']);
                    $purchaseLine = $tablePurchasingLines->patchEntity($purchaseLine, $purchaseLineData);
                    $tablePurchasingLines->save($purchaseLine);
                }

                $this->Flash->success(__('The invoice has been saved.'));
                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
        }

        // Kode untuk menyiapkan data untuk view
        $data['lastNumber'] = $this->get_last_number();
        $this->loadModel('Purchasings');
        $this->loadModel('Suppliers');
        $this->loadModel('PurchasingLines');

        $purchasingLines = $this->PurchasingLines->find()
            ->contain('Items')
            ->toList();

        // Ambil daftar ID pesanan yang statusnya "Wait"
        $purchasingIds = $this->Purchasings->find('list', ['keyField' => 'id', 'valueField' => 'id'])
            ->where(['Purchasings.status_wait' => 'Wait'])
            ->toArray();

        // Ambil daftar ID pelanggan yang terkait dengan pesanan "Wait"
        $supplierIds = Hash::extract($purchasingIds, '{n}.supplier_id');

        // Ambil daftar pelanggan yang sesuai dengan daftar ID pelanggan yang didapat sebelumnya
        $suppliers = $this->Suppliers->find('list', ['keyField' => 'id', 'valueField' => 'name']);

        $this->set(compact('invoiceEntry', 'data', 'suppliers', 'purchasingLines'));
    }

    public function add_old()
    {
        $invoiceEntry = $this->InvoiceEntries->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['dates'])); 
            $dueDate = array('due_date' => $this->Krs->dateTo($dataRow['due_dates'])); 

            $purchasings = array();
            if ($dataRow['purchasings']) {
                foreach ($dataRow['purchasings'] as $index => $value) {
                    $purchasings['purchasings'][$index]['deliver_pays'] = $this->Krs->nom2Dec($value['ship_payments']);
                    $purchasings['purchasings'][$index]['discount'] = $value['discounts'];
                    $purchasings['purchasings'][$index]['grandtotal'] = $this->Krs->nom2Dec($value['grandtotal']);
                }
            }

            $purchasing_lines = array();
            if ($dataRow['purchasing_lines']) {
                foreach ($dataRow['purchasing_lines'] as $index => $value) {
                    $purchasing_lines['purchasing_lines'][$index]['price'] = $this->Krs->nom2Dec($value['price']);
                    $purchasing_lines['purchasing_lines'][$index]['discount'] = $value['discount'];
                    $purchasing_lines['purchasing_lines'][$index]['subtotal'] = $this->Krs->nom2Dec($value['subtotal']);
                }
            }

            $dataRow['purchasings'] = $purchasings;
            $dataRow['purchasing_lines'] = $purchasing_lines;

            $tablePurchasings = $this->getTableLocator()->get('Purchasings');
            $purchase = $tablePurchasings->get($dataRow['purchasing_id']);

            pr($dataRow);

            // $invoiceEntry = $this->InvoiceEntries->patchEntity($invoiceEntry, array_merge($dataRow, $dataAuditLog, $date, $dueDate, $code, $purchasings, $purchasing_lines));

            // if ($this->InvoiceEntries->save($invoiceEntry)) {
            //     $id = $invoiceEntry->id;

            //     $purchase->invoice_entry_id = $id;
            //     $tablePurchasings->save($purchase);
            //     $this->Flash->success(__('The invoice entry has been saved.'));

            //     return $this->redirect(['action' => 'add']);
            // }
            // $this->Flash->error(__('The invoice entry could not be saved. Please, try again.'));
        }
        $data['lastNumber'] = $this->get_last_number();


        $this->loadModel('Purchasings');
        $this->loadModel('Suppliers');
        $this->loadModel('PurchasingLines');

        $purchasingLines = $this->PurchasingLines->find()
            ->contain('Items')
            ->toList();

        // Ambil daftar ID pesanan yang statusnya "Wait"
        $purchasingIds = $this->Purchasings->find('list', ['keyField' => 'id', 'valueField' => 'id'])
            ->where(['Purchasings.status_wait' => 'Wait'])
            ->toArray();

        // Ambil daftar ID pelanggan yang terkait dengan pesanan "Wait"
        $supplierIds = Hash::extract($purchasingIds, '{n}.supplier_id');

        // Ambil daftar pelanggan yang sesuai dengan daftar ID pelanggan yang didapat sebelumnya
        $suppliers = $this->Suppliers->find('list', ['keyField' => 'id', 'valueField' => 'name']);

        $this->set(compact('invoiceEntry', 'data', 'suppliers', 'purchasingLines'));

    }

    /**
     * Edit method
     *
     * @param string|null $id Invoice Entry id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) 
    {
        $invoiceEntry = $this->InvoiceEntries->get($id, [
            'contain' => ['Purchasings.PurchasingLines.Items', 'Purchasings'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['dates']));
            $dueDate = array('due_date' => $this->Krs->dateTo($dataRow['due_dates']));
            $codes = array('code' => $dataRow['codes']);

            $invoiceEntry = $this->InvoiceEntries->patchEntity($invoiceEntry, array_merge($dataRow, $dataAuditLog, $date, $dueDate, $codes));
            if ($this->InvoiceEntries->save($invoiceEntry)) {
                $this->Flash->success(__('The invoice entry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice entry could not be saved. Please, try again.'));
        }
        $branches = $this->InvoiceEntries->Branches->find('list', ['limit' => 200]);
        $purchasings = $this->InvoiceEntries->Purchasings->find('list', ['limit' => 200]);
        $this->set(compact('invoiceEntry', 'branches', 'purchasings'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoice Entry id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoiceEntry = $this->InvoiceEntries->get($id);
        if ($this->InvoiceEntries->delete($invoiceEntry)) {
            $this->Flash->success(__('The invoice entry has been deleted.'));
        } else {
            $this->Flash->error(__('The invoice entry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function payment()
    {
        $invoiceEntries = $this->InvoiceEntries->find('all')->contain(['Purchasings']);

        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');
        $code = $this->request->getQuery('code');
        $po = $this->request->getQuery('po');
        $company = $this->request->getQuery('company');

        $dataWhere = array();
        if (!empty($company)) {
            $dataWhere['InvoiceEntries.company like'] = '%' . $company . '%';
        }

        if (!empty($code)) {
            $dataWhere['InvoiceEntries.code like'] = '%' . $code . '%';
        }

        if (!empty($po)) {
            $dataWhere['Purchasings.number like'] = '%' . $po . '%';
        }

        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(InvoiceEntries.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }


        $queries = (!empty($dataWhere)) ? $invoiceEntries->where([$dataWhere, 'InvoiceEntries.payment_status IN' => ['N', 'NP']])->order(['InvoiceEntries.created' => 'Desc']) : $invoiceEntries->where(['InvoiceEntries.id' => 0]);

        $this->set(['invoiceEntries' => $this->paginate($queries, ['limit' => '10'])]);

        $dataSending = array();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "InvoiceEntries payment");

            $invoiceTables = $this->getTableLocator()->get('InvoiceEntries');
            foreach ($dataRow['data'] as $index => $data) {
                $obj = (object) $data;

                $nominalBayar1 = $this->Krs->nom2Dec($data['payment_nominal']);
                $nominalBayar2 = $this->Krs->nom2Dec($data['payment_1_nominal']);
                $selisih = ($nominalBayar1 + $nominalBayar2) - $this->Krs->nom2Dec($data['payment_total']);

                $dataSending[$index] = $invoiceTables->get($obj->id);

                $dataSending[$index]['payment_status'] = ($selisih >= 0) ? 'Y' : 'NP';
                $dataSending[$index]['payment_date'] = ($data['payment_date'] == '' || $data['payment_date'] == null) ? null : $this->Krs->dateTo($data['payment_date']);
                $dataSending[$index]['payment_nominal'] = ($data['payment_nominal'] == '' || $data['payment_nominal'] == null) ? null : $nominalBayar1;
                $dataSending[$index]['payment_type'] = ($data['payment_type'] == '' || $data['payment_type'] == null) ? null : $data['payment_type'];

                $dataSending[$index]['payment_1_date'] =  ($data['payment_1_date'] == '' || $data['payment_1_date'] == null) ? null : $this->Krs->dateTo($data['payment_1_date']);
                $dataSending[$index]['payment_1_nominal'] =  ($data['payment_1_nominal'] == '' || $data['payment_1_nominal'] == null) ? null : $nominalBayar2;
                $dataSending[$index]['payment_1_type'] =  ($data['payment_1_type'] == '' || $data['payment_1_type'] == null) ? null : $data['payment_1_type'];

                $dataSending[$index]['description'] = $data['description'];
            }

            if ($invoiceTables->saveMany($dataSending)) {
                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                return $this->redirect(['action' => 'payment']);
            }
            $this->Flash->error(__('Maaf data gagal disimpan, silakan masukkan data dengan benar!!'));
        }

        $this->set(compact('dataSending'));
    }


    public function getpo()
    {
        $this->autoRender = false;
        $this->loadModel('Purchasings');

        $search = $this->request->getQuery('search');

        $purchase = $this->Purchasings->find('all')
            ->where(['number LIKE' => '%' . $search . '%'])
            ->andWhere(['Purchasings.invoice_entry_id' => 0]);

        $result = array();
        foreach ($purchase as $key => $data) {
            $result[$key]['id'] = (int) $data['id'];
            $result[$key]['text'] = $data['number'];
        }

        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }

    public function setpo()
    {
        $this->autoRender = false;
        $this->loadModel('Purchasings');
        $purchase = $this->Purchasings->find('all')->contain(['Warehouses', 'Suppliers', 'PurchasingLines.Items'])->where(['Purchasings.id' => $this->request->getQuery('id')])->first();

        if ($purchase) {
        $data = array();
        $a = 0;
        $grandtotals = 0;

        foreach ($purchase->purchasing_lines as $key => $dataRow) {
            $items = $dataRow->item;
            $subtotals = $dataRow->subtotal;
            $grandtotals += $subtotals;
            $data[$a]['purchasing_id'] = $purchase['id'];
            $data[$a]['purchasing_line_id'] = $dataRow['id'];
            $data[$a]['id'] = $dataRow->id;
            $data[$a]['produk'] = $items->name;
            $data[$a]['unit'] = $items->unit;
            $data[$a]['harga'] = $this->Krs->_currency($dataRow->price);
            $data[$a]['jumlah'] = $this->Krs->_currency($dataRow->quantity);
            $data[$a]['diskon'] = $this->Krs->_currency($dataRow->discount);
            $data[$a]['subtotal'] = $this->Krs->_currency($dataRow->subtotal);
            $a++;

            $data['grandtotal'] = $this->Krs->_currency($grandtotals);
        }

        return $this->response->withType("application/json")->withStringBody(json_encode(['purchase' => $purchase, 'result' => $data]));
        } else {
            // Jika data tidak ditemukan
            return $this->response->withType("application/json")->withStringBody(json_encode(['error' => 'Data not found']));
        }
    }

    public function print($id = null)
    {
        $invoiceEntries = $this->InvoiceEntries->get($id, [
            'contain' => ['Purchasings.PurchasingLines', 'Purchasings.Suppliers', 'Purchasings.PurchasingLines.Items'], 
        ]);

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption('pdfConfig', [
            [
                'orientation' => 'potrait',
                'download' => true,
                'filename' => 'invoice_masuk.pdf'
            ]
        ]);

        $invoiceEntriTable = $this->getTableLocator()->get('InvoiceEntries');
        $invoiceEntri = $invoiceEntriTable->get($id);

        $invoiceEntri->rpt_invoice = $invoiceEntri->rpt_invoice + 1;
        $invoiceEntri->rpt_invoice_date = date('Y-m-d H:i:s');
        $invoiceEntriTable->save($invoiceEntri);

        $this->set(array('report' => $invoiceEntries));
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
        $sheet->setCellValue('A1', 'No. Invoice Masuk');
        $sheet->setCellValue('B1', 'Supplier');
        $sheet->setCellValue('C1', 'Tanggal Invoice Masuk');
        $sheet->setCellValue('D1', 'Tanggal Jatuh Tempo'); 
        $sheet->setCellValue('E1', 'Status');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }


        $report = $this->InvoiceEntries->find('all')->contain(['Purchasings.Suppliers'])->where([$condition])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $purchasings = $data->purchasing;

            $sheet->setCellValue('A' . $row, $data->code);
            $sheet->setCellValue('B' . $row, (!empty($data->purchasing_id) ? $purchasings->supplier->name : '-'));
            $sheet->setCellValue('C' . $row,  $this->Krs->fDate($data->date, 'd-m-Y'));
            $sheet->setCellValue('D' . $row, $this->Krs->fDate($data->due_date, 'd-m-Y'));
            $sheet->setCellValue('E' . $row, $this->Krs->statusInvoice($data->payment_status));
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Invoice Masuk - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
