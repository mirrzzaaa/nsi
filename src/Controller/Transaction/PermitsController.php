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
 * Permits Controller
 *
 * @property \App\Model\Table\PermitsTable $Permits
 * @method \App\Model\Entity\Permit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PermitsController extends AppController 
{  
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $permits = $this->Permits->find('all')->contain(['Orders.Customers', 'Orders.Invoices', 'Trucks', 'Users']);

        $code = $this->request->getQuery('filtercode');
        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');
        $customer = $this->request->getQuery('filtercustomer');
        $deliver = $this->request->getQuery('filterdeliver');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Permits.code like'] = '%' . $code . '%';
        }

        if (!empty($customer)) { 
            $dataWhere['Customers.name like'] = '%' . $customer . '%'; 
        }

        if (!empty($deliver)) {
            $dataWhere['Permits.delivered like'] = '%' . $deliver . '%';
        }
        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(Permits.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $permits->where([$dataWhere])->order(['Permits.code' => 'DESC']) : $permits->order(['Permits.code' => 'DESC']);

        $this->set('permits', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Permit id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    { 
        $permit = $this->Permits->get($id, [
            'contain' => ['Orders.Customers', 'Orders.Invoices', 'Orders.OrderLines.Items', 'Trucks', 'PermitOrderLines.OrderLines.Items'],
        ]);
 
        $this->set(compact('permit'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

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


    // public function add()
    // { 
    //     $permit = $this->Permits->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $dataRow = $this->request->getData();
    //         $isUser = $dataRow['is_create']; 
    //         $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
    //         $dataAuditLog = array('is_log' => $auditLog);
    //         $codes = array('code' => $this->get_last_permit());
    //         $date = array('date' => $this->Krs->dateTo($dataRow['dates']));

    //         $permit = $this->Permits->patchEntity($permit, array_merge($dataRow, $dataAuditLog, $date, $codes));

    //         // pr($dataRow);

    //         if ($this->Permits->save($permit)) {
    //             $id = $permit->id;

    //             $tableOrder = $this->getTableLocator()->get('Orders');
    //             $order = $tableOrder->get($dataRow['order_id']);

    //             $order->permit_id = $id;
    //             $tableOrder->save($order);
    //             $this->Flash->success(__('The permit has been saved.'));
 
    //             return $this->redirect(['action' => 'index']);
    //         } 
    //         $this->Flash->error(__('The permit could not be saved. Please, try again.'));
    //     }
    //     $trucks = $this->Permits->Trucks->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
    //     $orders = $this->Permits->Orders->find('list', ['keyField' => 'id', 'valueField' => 'code'])->toArray();
    //     $customers = $this->Permits->Customers->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
    //     $data['lastNumber'] = $this->get_last_permit();
    //     $this->set(compact('permit', 'data', 'trucks', 'orders', 'customers'));
    // }

    public function add()
    { 
        $permit = $this->Permits->newEmptyEntity();

        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create']; 
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $codes = array('code' => $this->get_last_permit());
            $date = array('date' => $this->Krs->dateTo($dataRow['dates']));

            // Simpan data permit
            $permit = $this->Permits->patchEntity($permit, array_merge($dataRow, $dataAuditLog, $date, $codes));

            if ($this->Permits->save($permit)) {
            $permitId = $permit->id;

            // Simpan hubungan ke tabel permit_order_lines
            if (!empty($dataRow['order_lines'])) {
                $tablePermitOrderLines = $this->getTableLocator()->get('PermitOrderLines');
                $tableOrderLines = $this->getTableLocator()->get('OrderLines'); // Tambahan

                foreach ($dataRow['order_lines'] as $line) {
                    // Simpan ke permit_order_lines
                    $permitOrderLine = $tablePermitOrderLines->newEntity([
                        'permit_id' => $permitId,
                        'order_line_id' => $line['order_line_ids'],
                        'description' => $dataRow['description']
                    ]);
                    $tablePermitOrderLines->save($permitOrderLine);

                    // Update ke order_lines
                    $orderLine = $tableOrderLines->get($line['order_line_ids']);
                    $orderLine->permit_id = $permitId;
                    $orderLine->date_permit = $this->Krs->dateTo($dataRow['dates']); // Format tanggal
                    $tableOrderLines->save($orderLine);
                }
            }

            // Update order dengan permit_id
            $tableOrder = $this->getTableLocator()->get('Orders');
            $order = $tableOrder->get($dataRow['order_id']);
            $order->permit_id = $permitId;
            $tableOrder->save($order);

            $this->Flash->success(__('The permit has been saved.'));
            return $this->redirect(['action' => 'index']);
        }

            $this->Flash->error(__('The permit could not be saved. Please, try again.'));
        }

        $trucks = $this->Permits->Trucks->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $orders = $this->Permits->Orders->find('list', ['keyField' => 'id', 'valueField' => 'code'])->toArray();
        $customers = $this->Permits->Customers->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $data['lastNumber'] = $this->get_last_permit();

        $this->set(compact('permit', 'data', 'trucks', 'orders', 'customers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Permit id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $permit = $this->Permits->get($id, [
            'contain' => ['Orders.Customers', 'Orders.OrderLines.Items', 'Orders', 'PermitOrderLines.OrderLines.Items'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['dates']));
            $codes = array('code' => $dataRow['code']);

            $permit = $this->Permits->patchEntity($permit, array_merge($dataRow, $dataAuditLog, $date, $codes));
            if ($this->Permits->save($permit)) {
                $this->Flash->success(__('The permit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The permit could not be saved. Please, try again.'));
        }
        $trucks = $this->Permits->Trucks->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $customers = $this->Permits->Customers->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $orders = $this->Permits->Orders->find('list', ['keyField' => 'id', 'valueField' => 'code'])->toArray();
        $this->set(compact('permit', 'trucks', 'customers', 'orders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Permit id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $permit = $this->Permits->get($id);
        if ($this->Permits->delete($permit)) {
            $this->Flash->success(__('The permit has been deleted.'));
        } else {
            $this->Flash->error(__('The permit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getorder()
    {
        $this->autoRender = false;
        $this->loadModel('Orders');

        $search = $this->request->getQuery('search');

        $orders = $this->Orders->find('all')->where(['OR' => ['code like' => '%' . $search . '%']]);

        $result = array();
        foreach ($orders as $key => $data) {
            $result[$key]['id'] = (int) $data['id'];
            $result[$key]['text'] = $data['code']; 
        }
        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }

    public function setorder()
    {
        $this->autoRender = false;

        // Load model 
        $this->loadModel('Orders');
        $this->loadModel('OrderLines');
        $this->loadModel('Customers');

        // Ambil id dari parameter request
        $id = $this->request->getQuery('id');

        $order = $this->Orders->get($id, [
            'contain' => ['Customers', 'OrderLines.Items'], 
        ]);

        if ($order) {
            $data = []; 
            $a = 0;
            foreach ($order->order_lines as $key => $dataRow) {
                // Tambahkan pengecekan permit_id
                if ($dataRow->permit_id == null) {
                    $items = $dataRow->item;

                    $data[$a]['id'] = $items->id;
                    $data[$a]['name'] = $items->name;
                    $data[$a]['quantity'] = $dataRow->quantity;
                    $data[$a]['unit'] = $items->unit;
                    $data[$a]['order_line_id'] = $dataRow->id;
                    $a++;
                }
            }

            $response_data = [
                'result' => $data,
                'order' => $order
            ];

            return $this->response
                ->withType("application/json")
                ->withStringBody(json_encode($response_data));
        } else {
            return $this->response
                ->withType("application/json")
                ->withStringBody(json_encode(['error' => 'Data not found']));
        }
    }



    public function print($id = null) 
    {
        $permit = $this->Permits->get($id, [
            'contain' => ['Orders.Customers', 'Orders.Invoices', 'Orders.OrderLines.Items', 'Trucks', 'PermitOrderLines.OrderLines.Items'],
        ]);

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');

        $permitTable = $this->getTableLocator()->get('Permits');
        $permits = $permitTable->get($id);

        $permits->is_print = $permits->is_print + 1;
        $permits->date_print = date('Y-m-d H:i:s');
        $permitTable->save($permits);

        $this->set(array('report' => $permit));
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
        $sheet->setCellValue('A1', 'No. Surat Jalan');
        $sheet->setCellValue('B1', 'Customer');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Pengirim');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }


        $report = $this->Permits->find('all')->contain(['Orders.Customers', 'Trucks'])->where([$condition])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $orders = $data->order;

            $sheet->setCellValue('A' . $row, $data->code);
            $sheet->setCellValue('B' . $row, (!empty($data->order_id) ? $orders->pelanggan->name : '-'));
            $sheet->setCellValue('C' . $row, $this->Krs->fDate($data->date, 'd-m-Y'));
            $sheet->setCellValue('D' . $row, (!empty($data->truck_id) ? $data->truck->name : $data->delivered)); 
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) { 
            $writer->save('php://output');
        });
        $filename = 'Surat Jalan - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
