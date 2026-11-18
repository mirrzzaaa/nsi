<?php

declare(strict_types=1);

namespace App\Controller\Transaction;

use App\Controller\AppController;

// export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;  

/**
 * Returs Controller
 *
 * @property \App\Model\Table\RetursTable $Returs
 * @method \App\Model\Entity\Retur[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RetursController extends AppController
{ 
    /** 
     * Index method 
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $returs = $this->Returs->find('all')->contain(['Branches', 'Customers', 'Orders']);

        $code = $this->request->getQuery('filtercode');
        $customer = $this->request->getQuery('filtercustomer');
        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');
        $codeOrder = $this->request->getQuery('filtercodeorder');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Returs.code like'] = '%' . $code . '%';
        }
        if (!empty($customer)) {
            $dataWhere['Customers.name like'] = '%' . $customer . '%';
        }
        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(Returs.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }
        if (!empty($codeOrder)) {
            $dataWhere['Orders.code like'] = '%' . $codeOrder . '%';
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $returs->where([$dataWhere])->order(['Returs.code' => 'DESC']) : $returs->order(['Returs.code' => 'DESC']);

        $this->set('returs', $this->paginate($queries, ['limit' => '10'])); 
    }

    /**
     * View method
     *
     * @param string|null $id Retur id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $retur = $this->Returs->get($id, [
            'contain' => ['Customers', 'Branches', 'Orders', 'Orders.OrderLines', 'Orders.OrderLines.Items', 'ReturLines', 'ReturLines.Items', 'ReturLines.OrderLines', 'ReturLines.OrderLines.Items', 'ReturLines.WarehouseStocks', 'ReturLines.BranchStocks'],
        ]);

        $returLines = $this->Returs->ReturLines->find('all')->toArray();
        $this->set(compact('retur', 'returLines'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function get_last_number() 
    {
        $dataRows = $this->Returs->find('all', [
            'fields' => array('codes' => 'MAX(Returs.code)'),
        ])->first();
        $code = (!empty($dataRows->codes) ? explode("/", $dataRows['codes']) : array());
        $dataResult = isset($code[0]) ? ($code[0] + 1) : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = $result . '/RETUR-CUSTOMER/NSI/' . $this->Krs->numToRome(date('m')) . '/' . date('Y');
        return $number;
    }

    public function add()
    {
        $retur = $this->Returs->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['date']));
            $customerId = array('customer_id' => $dataRow['customer_id']);
            $orderId = array('order_id' => $dataRow['order_id']);
            $code = array('code' => $this->get_last_number());

            $retur = $this->Returs->patchEntity($retur, array_merge($dataRow, $dataAuditLog, $date, $customerId, $orderId, $code), ['associated' => ['ReturLines' => ['validate' => true]]]);
            //pr($dataRow);

            if ($this->Returs->save($retur)) {
            $id = $retur->id;
                foreach ($dataRow['retur_lines'] as $index => $value) {
                    if ($value['reason'] > '0') {
                        $dataArr = array();
                        $dataArr[$index]['retur_id'] = $id; 
                        $dataArr[$index]['item_id'] = $value['item_id'];
                        $dataArr[$index]['quantity'] = $value['quantity'];
                        $dataArr[$index]['nominal'] = $value['nominal'];
                        $dataArr[$index]['reason'] = $value['reason'];
                        $dataArr[$index]['nomor_seri'] = $value['nomor_seri'];
                        $dataArr[$index]['kode_produk'] = $value['kode_produk'];
                        $dataArr[$index]['supplier_code'] = $value['supplier_code'];
                        $dataArr[$index]['supplier_name'] = $value['supplier_name'];
                    } else {
                        if (isset($dataRow['branch_id'])) {
                            $tableBranch = $this->getTableLocator()->get('BranchStocks');
                            $branch = $tableBranch->find('all')->where(['branch_id' => $dataRow['branch_id'], 'item_id' => $value['item_id']])->first();
                            $branch->stock = $branch->stock + $value['quantity'];
                            $tableBranch->save($branch);
                        } else {
                            $tableWarehouse = $this->getTableLocator()->get('WarehouseStocks');
                            $warehouse = $tableWarehouse->find('all')->where(['warehouse_id' => $dataRow['warehouse_id'], 'item_id' => $value['item_id']])->first();
                            $warehouse->stock = $warehouse->stock + $value['quantity'];
                            $tableWarehouse->save($warehouse);
                        }
                    }
                }
                    $tableOrders = $this->getTableLocator()->get('Orders');
                    $order = $tableOrders->get($dataRow['order_id']);
                    $order->is_active = 'N';

                    $tableOrders->save($order);

                    $this->Flash->success(__('The retur has been saved.'));

                    return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The retur could not be saved. Please, try again.'));
        }
        $data['lastNumber'] = $this->get_last_number();
        $branches = $this->Returs->Branches->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $warehouses = $this->Returs->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $customers = $this->Returs->Customers->find('all')->toArray();
        $orders = $this->Returs->Orders->find('all')->toArray();
        $this->set(compact('retur', 'data', 'branches', 'warehouses', 'customers', 'orders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Retur id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function edit($id = null)
    {
        $retur = $this->Returs->get($id, [
            'contain' => ['Customers', 'Branches', 'ReturLines.Items', 'Orders.OrderLines', 'Orders.OrderLines.Items', 'ReturLines.WarehouseStocks', 'ReturLines.BranchStocks', 'Orders'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "Edit");
            $dataAuditLog = ['is_log' => $auditLog];
            $date = ['date' => $this->Krs->dateTo($dataRow['date'])];
            $customerId = ['customer_id' => $dataRow['customer_id']];
            $orderId = ['order_id' => $dataRow['order_id']];
            $code = ['code' => $dataRow['code']];

            $retur = $this->Returs->patchEntity($retur, array_merge($dataRow, $dataAuditLog, $date, $customerId, $orderId, $code));
            //pr($dataRow);

            if ($this->Returs->save($retur)) {
                //$id = $retur->id;
                $dataArr = [];
                
                if (!empty($dataRow['returLines'])) {
                    foreach ($dataRow['returLines'] as $index => $value) {
                        if ($value['reason'] > 0) {
                            $dataArr[] = [
                                'id' => $value['id'],
                                'retur_id' => $id,
                                'item_id' => $value['item_id'],
                                'quantity' => $value['quantity'],
                                'nominal' => $value['nominal'],
                                'reason' => $value['reason']
                            ];

                        // $returLine = $this->Returs->ReturLines->get($value['id']);
                        // $this->Returs->ReturLines->patchEntity($returLine, $value);
                        // $this->Returs->ReturLines->save($returLine);

                        // mengupdate retur line
                        $this->loadModel('ReturLines');
                        $this->ReturLines->updateAll(['retur_id' => $id, 'item_id' => $value['item_id'], 'quantity' => $value['quantity'], 'nominal' => $value['nominal'], 'reason' => $value['reason']], ['id' => $value['id']]);
                        } 

                        // $tableReturLines = $this->getTableLocator()->get('ReturLines');
                        // $returLine = $tableReturLines->get($dataArr['id']);
                        // $returLine->id = $value['id'];
                        // $tableReturLines->save($returLine);

                    }

                }

                // Mengupdate status order
                $tableOrders = $this->getTableLocator()->get('Orders');
                $order = $tableOrders->get($dataRow['order_id']);
                $order->is_active = 'N';
                $tableOrders->save($order);

                $this->Flash->success(__('The retur has been saved.'));
                //return $this->redirect(['action' => 'add']);
            }

            $this->Flash->error(__('The retur could not be saved. Please, try again.'));
        }

        $data['lastNumber'] = $this->get_last_number();
        $branches = $this->Returs->Branches->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $warehouses = $this->Returs->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $customers = $this->Returs->Customers->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $orders = $this->Returs->Orders->find('list', ['keyField' => 'id', 'valueField' => 'code'])->toArray();
        $this->set(compact('retur', 'data', 'branches', 'warehouses', 'customers', 'orders'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Retur id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $retur = $this->Returs->get($id);
        if ($this->Returs->delete($retur)) {
            $this->Flash->success(__('The retur has been deleted.'));
        } else {
            $this->Flash->error(__('The retur could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getorder()
    {
        $this->autoRender = false;
        $this->loadModel('Orders');

        $search = $this->request->getQuery('search');

        $orders = $this->Orders->find('all')->where(['Orders.code like' => '%' . $search . '%', 'Orders.is_active' => 'Y']);

        $result = array();
        foreach ($orders as $key => $data) {
            $result[] = array("value" =>  $data->code, "data" => (object) array('id' => $data->id, 'label' => $data->code));
        }

        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }


    public function setorder()
    {
        $this->autoRender = false;
        $this->loadModel('Orders');
        $order = $this->Orders->find('all')->contain(['OrderLines.Items', 'Customers', 'Warehouses', 'Branches'])->where(['Orders.id' => $this->request->getQuery('id')])->first();

        return $this->response->withType("application/json")->withStringBody(json_encode($order));
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
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID Produk');
        $sheet->setCellValue('C1', 'Nama Produk');
        $sheet->setCellValue('D1', 'Nomor Izin Edar');
        $sheet->setCellValue('E1', 'Tipe dan Ukuran');
        $sheet->setCellValue('F1', 'Nomor Seri');
        $sheet->setCellValue('G1', 'Kode Produk');
        $sheet->setCellValue('H1', 'Jumlah Retur Keluar');
        $sheet->setCellValue('I1', 'Tanggal Retur Keluar');
        $sheet->setCellValue('J1', 'Tanggal Kadaluwarsa');
        $sheet->setCellValue('K1', 'ID Upline');
        $sheet->setCellValue('L1', 'Nama Upline');
        $sheet->setCellValue('M1', 'Alasan Retur');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $report = $this->Returs->find('all')->contain(['Customers', 'Orders', 'ReturLines.Items'])->where([$condition])->toArray();

        $row = 2;
        $no = 1;

        foreach ($report as $data) {
            foreach ($data->retur_lines as $line) {
                $item = $line->item ?? null;

                $sheet->setCellValue('A' . $row, $no++);
                $sheet->setCellValue('B' . $row, $item->code_internal ?? '');
                $sheet->setCellValue('C' . $row, $item->name ?? '');
                $sheet->setCellValueExplicit('D' . $row, $item->izin_edar ?? '', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('E' . $row, ($item ? $item->type . ' ' . $item->ukuran : ''));
                $sheet->setCellValue('F' . $row, $line->nomor_seri ?? '');
                $sheet->setCellValue('G' . $row, $line->kode_produk ?? '');
                $sheet->setCellValue('H' . $row, $line->quantity ?? '');
                $sheet->setCellValue('I' . $row, ($data->date ? $this->Krs->fDate($data->date, 'Y-m-d') : ''));
                $sheet->setCellValue('J' . $row, ($item && $item->expired_date ? $this->Krs->fDate($item->expired_date, 'Y-m-d') : ''));
                $sheet->setCellValue('K' . $row, $line->supplier_code ?? '');
                $sheet->setCellValue('L' . $row, $line->supplier_name ?? '');
                $sheet->setCellValue('M' . $row, $line->reason ?? '');

                $row++;
            }
        }


        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Retur Customer - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
