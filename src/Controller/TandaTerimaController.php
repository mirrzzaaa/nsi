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
 * TandaTerima Controller
 *
 * @property \App\Model\Table\TandaTerimaTable $TandaTerima
 * @method \App\Model\Entity\TandaTerima[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TandaTerimaController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view 
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session

        $tandaTerima = $this->TandaTerima->find('all')->contain(['Invoices', 'Invoices.Customers', 'Permits']); 
        $code = $this->request->getQuery('filtercode');
        $user = $this->request->getQuery('filteruser');
        $invoice = $this->request->getQuery('filterinvoice');
        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['TandaTerima.code like'] = '%' . $code . '%';
        } 
        if (!empty($user)) {
            $dataWhere['Customers.name like'] = '%' . $user . '%'; 
        }
        if (!empty($invoice)) {
            $dataWhere['Invoices.code like'] = '%' . $invoice . '%';
        }
        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(TandaTerima.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $tandaTerima->where([$dataWhere])->order(['TandaTerima.date' => 'DESC']) : $tandaTerima->order(['TandaTerima.date' => 'DESC']);

        $this->set('tandaTerima', $this->paginate($queries, ['limit' => '10'])); 

    }

    /**
     * View method
     *
     * @param string|null $id Tanda Terima id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tandaTerima = $this->TandaTerima->get($id, [
            'contain' => ['Invoices', 'Invoices.Customers', 'Invoices.Orders.OrderLines.Items', 'Permits'],
        ]);

        $this->set(compact('tandaTerima'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function get_last_tt()
    {
        $this->loadModel('TandaTerima');
        $dataRows = $this->TandaTerima->find('all', [
            'fields' => array('codes' => 'MAX(TandaTerima.code)'),
        ])->first();
        $code = (!empty($dataRows->codes) ? explode("/", $dataRows['codes']) : array());
        $dataResult = isset($code[0]) ? ($code[0] + 1) : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = $result . '/TT/NSI/' . $this->Krs->numToRome(date('m')) . '/' . date('Y');
        return $number;
    }

    public function add()
    { 
        $tandaTerima = $this->TandaTerima->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create']; 
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $codes = array('code' => $this->get_last_tt());
            $date = array('date' => $this->Krs->dateTo($dataRow['dates']));

            $tandaTerima = $this->TandaTerima->patchEntity($tandaTerima, array_merge($dataRow, $dataAuditLog, $date, $codes));

            // pr($dataRow);

            if ($this->TandaTerima->save($tandaTerima)) {
                $id = $tandaTerima->id;

                $tableInvoice = $this->getTableLocator()->get('Invoices');
                $invoice = $tableInvoice->get($dataRow['invoice_id']);

                $invoice->tanda_terima_id = $id;
                $tableInvoice->save($invoice);
                $this->Flash->success(__('The tanda terima has been saved.'));
 
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tanda terima could not be saved. Please, try again.')); 
        }

        $invoices = $this->TandaTerima->Invoices->find('list', ['keyField' => 'id', 'valueField' => 'code'])->toArray();
        $permits = $this->TandaTerima->Permits->find('list', ['keyField' => 'id', 'valueField' => 'code'])->toArray();
        $data['lastNumber'] = $this->get_last_tt();
        $this->set(compact('tandaTerima', 'data', 'invoices', 'permits'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tanda Terima id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tandaTerima = $this->TandaTerima->get($id, [
            'contain' => ['Invoices', 'Invoices.Customers', 'Invoices.Orders.OrderLines.Items', 'Permits'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update']; 
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['dates']));

            $tandaTerima = $this->TandaTerima->patchEntity($tandaTerima, array_merge($dataRow, $dataAuditLog, $date));

            // pr($dataRow);

            if ($this->TandaTerima->save($tandaTerima)) {
                $this->Flash->success(__('The tanda terima has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tanda terima could not be saved. Please, try again.'));
        }
        $invoices = $this->TandaTerima->Invoices->find('list', ['keyField' => 'id', 'valueField' => 'code'])->toArray();
        $permits = $this->TandaTerima->Permits->find('list', ['keyField' => 'id', 'valueField' => 'code'])->toArray();
        $this->set(compact('tandaTerima', 'invoices', 'permits'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tanda Terima id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tandaTerima = $this->TandaTerima->get($id);
        if ($this->TandaTerima->delete($tandaTerima)) {
            $this->Flash->success(__('The tanda terima has been deleted.'));
        } else {
            $this->Flash->error(__('The tanda terima could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getinvoice()
    {
        $this->autoRender = false;
        $this->loadModel('Invoices');

        $search = $this->request->getQuery('search');

        $invoice = $this->Invoices->find('all')->where(['OR' => ['code like' => '%' . $search . '%']]);

        $result = array();
        foreach ($invoice as $key => $data) {
            $result[$key]['id'] = (int) $data['id'];
            $result[$key]['text'] = $data['code']; 
        }
        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }

    public function setinvoice()
    {
        $this->autoRender = false;

        // Load model 
        $this->loadModel('Invoices');
        $this->loadModel('Orders');

        // Ambil id dari parameter request
        $id = $this->request->getQuery('id');

        try {
            // Ambil data invoice dengan relasi
            $invoice = $this->Invoices->get($id, [
                'contain' => ['Orders', 'Orders.OrderLines.Items'],
            ]);

            // Pastikan data order_lines ada
            if (!empty($invoice->order->order_lines)) {
                $data = [];
                $a = 0;

                // Loop melalui order_lines
                foreach ($invoice->order->order_lines as $key => $dataRow) {
                    if (!empty($dataRow->item)) {
                        $items = $dataRow->item;
                        $data[$a]['id'] = $items->id;
                        $data[$a]['name'] = $items->name;
                        $data[$a]['quantity'] = $dataRow->quantity;
                        $data[$a]['unit'] = $items->unit;
                        $a++;
                    }
                }

                // Gabungkan data customers dan invoice dalam satu array untuk di-encode
                $response_data = [
                    'result' => $data,
                    'invoice' => $invoice,
                ];

                // Mengembalikan response JSON
                return $this->response
                    ->withType("application/json")
                    ->withStringBody(json_encode($response_data));
            } else {
                // Jika order_lines kosong
                return $this->response
                    ->withType("application/json")
                    ->withStringBody(json_encode(['error' => 'No order lines found']));
            }
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            // Jika data tidak ditemukan
            return $this->response
                ->withType("application/json")
                ->withStringBody(json_encode(['error' => 'Data not found']));
        }
    }

    public function print($id = null) 
    {
        $tandaTerima = $this->TandaTerima->get($id, [
            'contain' => ['Invoices', 'Invoices.Customers', 'Invoices.Orders.OrderLines.Items', 'Permits'],
        ]);

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');

        $tandaTerimaTable = $this->getTableLocator()->get('TandaTerima');
        $tandaTerimas = $tandaTerimaTable->get($id);

        $tandaTerimas->is_print = $tandaTerimas->is_print + 1;
        $tandaTerimas->date_print = date('Y-m-d H:i:s');
        $tandaTerimaTable->save($tandaTerimas);

        $this->set(array('report' => $tandaTerima));
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
        $sheet->setCellValue('A1', 'No. Tanda Terima');
        $sheet->setCellValue('B1', 'Customer');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'No. Invoice');
        $sheet->setCellValue('E1', 'No. Faktur Pajak');
        $sheet->setCellValue('F1', 'No. Berita Acara');
        $sheet->setCellValue('G1', 'No. Surat Jalan');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }


        $report = $this->TandaTerima->find('all')->contain(['Invoices', 'Invoices.Customers', 'Invoices.Orders.OrderLines.Items', 'Permits'])->where([$condition])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $invoices = $data->invoice;
            $permits = $data->permit;

            $sheet->setCellValue('A' . $row, $data->code);
            $sheet->setCellValue('B' . $row, (!empty($data->invoice_id) ? $invoices->customer->name : '-'));
            $sheet->setCellValue('C' . $row, $this->Krs->fDate($data->date, 'd-m-Y'));
            $sheet->setCellValue('D' . $row, (!empty($data->invoice_id) ? $invoices->code : '-')); 
            $sheet->setCellValue('E' . $row, (!empty($data->no_faktur) ? $data->no_faktur : '-'));
            $sheet->setCellValue('F' . $row, (!empty($data->no_ba) ? $data->no_ba : '-'));
            $sheet->setCellValue('G' . $row, (!empty($data->permit_id) ? $permits->code : '-'));
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) { 
            $writer->save('php://output');
        });
        $filename = 'Tanda Terima - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }

}
