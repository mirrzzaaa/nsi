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
 * Receipts Controller
 *
 * @property \App\Model\Table\ReceiptsTable $Receipts
 * @method \App\Model\Entity\Receipt[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReceiptsController extends AppController
{ 
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    public function index()
    {
        $session = $this->getRequest()->getSession(); // get session
        $receipts = $this->Receipts->find('all')
            ->contain(['Orders', 'Customers', 'Invoices']); // Mengambil data terkait

        $code = $this->request->getQuery('filtercode');
        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');
        $customer = $this->request->getQuery('filtercustomer');
        $status = $this->request->getQuery('filterstatus');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Receipts.code like'] = '%' . $code . '%';
        }

        if (!empty($customer)) {
            $dataWhere['Customers.name like'] = '%' . $customer . '%';
        }

        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(Receipts.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }

        if (!empty($status)) {
            $dataWhere['Receipts.payment_type'] = $status;
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $receipts->where([$dataWhere])->order(['Receipts.code' => 'DESC']) : $receipts->order(['Receipts.code' => 'DESC']);

        // Paginate results
        $this->set('receipts', $this->paginate($queries, ['limit' => '10'])); 
    }

    /**
     * View method
     *
     * @param string|null $id Receipt id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $receipt = $this->Receipts->get($id, [
            'contain' => ['Branches', 'Invoices', 'Customers', 'Orders'],
        ]);

        $this->set(compact('receipt'));
    }

    public function get_last_number()
    {
        // Ambil kode terakhir dari database
        $dataRows = $this->Receipts->find('all', [
            'fields' => ['codes' => 'MAX(Receipts.code)'],
        ])->first();

        $dataResult = 1;
        if (!empty($dataRows->codes)) {
            $codeParts = explode("/", $dataRows->codes);
            if (isset($codeParts[0])) {
                $numberPart = str_replace('K.', '', $codeParts[0]);
                if (is_numeric($numberPart)) {
                    $dataResult = (int)$numberPart + 1;
                }
            }
        }

        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = 'K.' . $result . '/NSI/' . $this->Krs->numToRome(date('m')) . '/' . date('Y');
        
        return $number;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $receipt = $this->Receipts->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData(); 
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "Add");
            $dataAuditLog = ['is_log' => $auditLog];
            $date = ['date' => $this->Krs->dateTo($dataRow['dates'])];
            $nom = ['nominal' => $this->Krs->nom2Dec($dataRow['nominals'])];
            $description = ['description' => $dataRow['descriptions']];
            $code = ['code' => $dataRow['codes']];
            $paymentType = ['payment_type' => $dataRow['payment_type']];
            $presentase = ['presentase' => $dataRow['presentase']];

            $receipt = $this->Receipts->patchEntity($receipt, array_merge($dataRow, $dataAuditLog, $date, $nom, $description, $code, $paymentType, $presentase));

            if ($this->Receipts->save($receipt)) {
                $this->Flash->success(__('The receipt has been saved.'));

                // Save nominal to the related invoice
                $invoice = $this->Receipts->Invoices->get($dataRow['invoice_id']); 
                $nominal = $this->Krs->nom2Dec($dataRow['nominals']);

                if ($invoice->payment_nominal_1 == 0) {
                    $invoice->payment_nominal_1 = $nominal;
                } elseif ($invoice->payment_nominal_2 == 0) {
                    $invoice->payment_nominal_2 = $nominal;
                } elseif ($invoice->payment_nominal_3 == 0) {
                    $invoice->payment_nominal_3 = $nominal;
                } else {
                    // Handle the case where all columns are already filled
                    $this->Flash->error(__('All payment nominal fields are already filled.'));
                    return $this->redirect(['action' => 'index']);
                }

                if ($this->Receipts->Invoices->save($invoice)) {
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The invoice could not be updated. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
            }
        }

        $data['lastNumber'] = $this->get_last_number();
        $branches = $this->Receipts->Branches->find('list', ['limit' => 200]);
        $invoices = $this->Receipts->Invoices->find('list', ['keyField' => 'id', 'valueField' => 'code']);
        $customers = $this->Receipts->Customers->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        $orders = $this->Receipts->Orders->find('list', ['keyField' => 'id', 'valueField' => 'code']);
        $this->set(compact('receipt', 'branches', 'invoices', 'customers', 'orders', 'data'));
    } 

    /**
     * Edit method
     *
     * @param string|null $id Receipt id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $receipt = $this->Receipts->get($id, [
            'contain' => ['Invoices', 'Orders', 'Customers'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "Add");
            $dataAuditLog = ['is_log' => $auditLog];
            $newNominal = $this->Krs->nom2Dec($dataRow['nominals']);
            $description = ['description' => $dataRow['descriptions']];

            // Ambil nilai nominal sebelum diubah
            $oldNominal = $receipt->nominal;

            // Patch data pada entity receipt
            $receipt = $this->Receipts->patchEntity($receipt, array_merge($dataRow, $dataAuditLog, ['nominal' => $newNominal], $description));

            if ($this->Receipts->save($receipt)) {
                // Jika nilai nominal berubah, perbarui tabel invoices
                if ($oldNominal != $newNominal) {
                    $invoice = $this->Receipts->Invoices->get($receipt->invoice_id);

                    // Perbarui kolom yang sesuai dengan nilai nominal lama
                    if ($invoice->payment_nominal_1 == $oldNominal) {
                        $invoice->payment_nominal_1 = $newNominal;
                    } elseif ($invoice->payment_nominal_2 == $oldNominal) {
                        $invoice->payment_nominal_2 = $newNominal;
                    } elseif ($invoice->payment_nominal_3 == $oldNominal) {
                        $invoice->payment_nominal_3 = $newNominal;
                    }

                    // Cek jika newNominal sama dengan grandtotal
                    if ($invoice->grandtotal == $newNominal) {
                        $invoice->payment = 'Y'; // Atur kolom payment menjadi 'Y'
                    } else {
                        $invoice->payment = 'NP'; // Atur kolom payment menjadi 'NP'
                    }

                    if (!$this->Receipts->Invoices->save($invoice)) {
                        $this->Flash->error(__('The invoice could not be updated. Please, try again.'));
                    }
                }

                $this->Flash->success(__('The receipt has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
        }

        $data['lastNumber'] = $this->get_last_number();
        $branches = $this->Receipts->Branches->find('list', ['limit' => 200]);
        $invoices = $this->Receipts->Invoices->find('list', ['keyField' => 'id', 'valueField' => 'code']);
        $customers = $this->Receipts->Customers->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        $orders = $this->Receipts->Orders->find('all')->contain(['Customers'])->toArray();
        $this->set(compact('receipt', 'branches', 'invoices', 'customers', 'orders', 'data'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Receipt id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $receipt = $this->Receipts->get($id);
        if ($this->Receipts->delete($receipt)) {
            $this->Flash->success(__('The receipt has been deleted.'));
        } else {
            $this->Flash->error(__('The receipt could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function setkwitansi()
    {
        $invoice = $this->request->getQuery('invoice');

        $this->loadModel('Customers');
        $this->loadModel('Orders');
        $this->loadModel('Invoices');

        $receipts = $this->Invoices->find('all')
            ->contain(['Customers', 'Orders'])
            ->where([
                'OR' => [
                    ['Invoices.id' => $invoice]
                ]
            ])
            ->order(['Invoices.id' => 'DESC'])
            ->toArray();

        // Format data sesuai dengan yang dibutuhkan oleh JavaScript
        $result = [];
        foreach ($receipts as $receipt) {
            $orders = $receipt->order;
            $customers = $receipt->customer;
            $result[] = [
                'id' => $receipt->id,
                'code' => $receipt->code,
                'code_order' => $orders->code,
                'customer_id' => $customers->id,
                'order_id' => $orders->id,
                'name' => $customers->name,
                'grandtotal' => $orders->grandtotal,
                'date' => $orders->date->format('Y-m-d'),
                'payment_nominal_1' => $receipt->payment_nominal_1,
                'payment_nominal_2' => $receipt->payment_nominal_2,
                'payment_nominal_3' => $receipt->payment_nominal_3
            ];
        }

        return $this->response->withType("application/json")->withStringBody(json_encode($result));
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
        $sheet->setCellValue('A1', 'No. Kwitansi');
        $sheet->setCellValue('B1', 'Customer');
        $sheet->setCellValue('C1', 'No. Order');
        $sheet->setCellValue('D1', 'Tanggal Bayar');
        $sheet->setCellValue('E1', 'Pembayaran');
        $sheet->setCellValue('F1', 'Nominal');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }


        $report = $this->Receipts->find('all')->contain(['Customers', 'Orders'])->where([$condition])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $dataGrandTotal = $this->Krs->_currency($data->nominal);

            $sheet->setCellValue('A' . $row, $data->code);
            $sheet->setCellValue('B' . $row, (!empty($data->customer) ? $data->customer->name : '-'));
            $sheet->setCellValue('C' . $row, (!empty($data->order) ? $data->order->code : '-'));
            $sheet->setCellValue('D' . $row, $this->Krs->fDate($data->date, 'd-m-Y'));
            $sheet->setCellValue('E' . $row, $data->payment_type);
            $sheet->setCellValue('F' . $row, $dataGrandTotal);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Receipt - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }

    public function print($id = null)  
    {
        $receipts = $this->Receipts->get($id, [
            'contain' => ['Orders.OrderLines', 'Orders.Customers', 'Orders.OrderLines.Items', 'Invoices'], 
        ]);

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption('pdfConfig', [
            [
                'orientation' => 'potrait',
                'download' => true,
                'filename' => 'print.pdf'
            ]
        ]);

        $receiptTable = $this->getTableLocator()->get('Receipts');
        $receipt = $receiptTable->get($id);

        $receipt->print = $receipt->print + 1;
        $receipt->print_date = date('Y-m-d H:i:s');
        $receiptTable->save($receipt);

        $this->set(array('report' => $receipts));
    }

    public function printOut($id = null)  
    {
        $receipts = $this->Receipts->get($id, [
            'contain' => ['Orders.OrderLines', 'Orders.Customers', 'Orders.OrderLines.Items', 'Invoices'], 
        ]);

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption('pdfConfig', [
            [
                'orientation' => 'potrait',
                'download' => true,
                'filename' => 'print.pdf'
            ]
        ]);

        $receiptTable = $this->getTableLocator()->get('Receipts');
        $receipt = $receiptTable->get($id);

        $receipt->print = $receipt->print + 1;
        $receipt->print_date = date('Y-m-d H:i:s');
        $receiptTable->save($receipt);

        $this->set(array('report' => $receipts));
    }

}
