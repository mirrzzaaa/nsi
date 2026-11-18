<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;

// export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * ReturSuppliers Controller
 *
 * @property \App\Model\Table\ReturSuppliersTable $ReturSuppliers
 * @method \App\Model\Entity\ReturSupplier[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReturSuppliersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view  
     */

    public function index()
    { 
        $session = $this->getRequest()->getSession(); //get session
        $returSuppliers = $this->ReturSuppliers->find('all')->contain(['Suppliers', 'Purchasings']);

        $code = $this->request->getQuery('filtercode');
        $supplier = $this->request->getQuery('filtersupplier');
        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');
        $codePO = $this->request->getQuery('filtercodepo');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['ReturSuppliers.code like'] = '%' . $code . '%';
        }
        if (!empty($supplier)) {
            $dataWhere['Suppliers.name like'] = '%' . $supplier . '%';
        }
        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(ReturSuppliers.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }
        if (!empty($codePO)) {
            $dataWhere['Purchasings.number like'] = '%' . $codePO . '%';
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $returSuppliers->where([$dataWhere])->order(['ReturSuppliers.code' => 'DESC']) : $returSuppliers->order(['ReturSuppliers.code' => 'DESC']);

        $this->set('returSuppliers', $this->paginate($queries, ['limit' => '10'])); 
    }


    /**
     * View method
     *
     * @param string|null $id Retur Supplier id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $returSupplier = $this->ReturSuppliers->get($id, [
            'contain' => ['Suppliers', 'Purchasings', 'ReturSupplierLines', 'ReturSupplierLines.Items', 'Purchasings.PurchasingLines', 'Purchasings.PurchasingLines.Items'],
        ]);

        $returSupplierLines = $this->ReturSuppliers->ReturSupplierLines->find('all')->toArray();
        $this->set(compact('returSupplier', 'returSupplierLines'));
    }

    public function get_last_number() 
    {
        $dataRows = $this->ReturSuppliers->find('all', [
            'fields' => array('codes' => 'MAX(ReturSuppliers.code)'),
        ])->first();
        $code = (!empty($dataRows->codes) ? explode("/", $dataRows['codes']) : array());
        $dataResult = isset($code[0]) ? ($code[0] + 1) : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = $result . '/RETUR-SUPPLIER/NSI/' . $this->Krs->numToRome(date('m')) . '/' . date('Y');
        return $number;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $returSupplier = $this->ReturSuppliers->newEmptyEntity();

        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['date']));
            $supplierId = array('supplier_id' => $dataRow['supplier_id']);
            $purchaseId = array('purchasing_id' => $dataRow['purchasing_id']);
            $code = array('code' => $this->get_last_number());

            $returSupplier = $this->ReturSuppliers->patchEntity($returSupplier, array_merge($dataRow, $dataAuditLog, $date, $supplierId, $purchaseId, $code), ['associated' => ['ReturSupplierLines' => ['validate' => true]]]);

            //pr($dataRow);

            if ($this->ReturSuppliers->save($returSupplier)) {
                $id = $returSupplier->id;
                foreach ($dataRow['retur_supplier_lines'] as $index => $value) {
                    if ($value['reason'] > '0') {
                        $dataArr = array();
                        $dataArr[$index]['retur_supplier_id'] = $id;
                        $dataArr[$index]['item_id'] = $value['item_id'];
                        $dataArr[$index]['quantity'] = $value['quantity'];
                        $dataArr[$index]['nominal'] = $value['nominal'];
                        $dataArr[$index]['reason'] = $value['reason'];
                    } 
                    // else {
                    //     if (isset($dataRow['branch_id'])) {
                    //         $tableBranch = $this->getTableLocator()->get('BranchStocks');
                    //         $branch = $tableBranch->find('all')->where(['branch_id' => $dataRow['branch_id'], 'item_id' => $value['item_id']])->first();
                    //         $branch->stock = $branch->stock + $value['quantity'];
                    //         $tableBranch->save($branch);
                    //     } else {
                    //         $tableWarehouse = $this->getTableLocator()->get('WarehouseStocks');
                    //         $warehouse = $tableWarehouse->find('all')->where(['warehouse_id' => $dataRow['warehouse_id'], 'item_id' => $value['item_id']])->first();
                    //         $warehouse->stock = $warehouse->stock + $value['quantity'];
                    //         $tableWarehouse->save($warehouse);
                    //     }
                    // }
                }
                $tablePurchaseOrders = $this->getTableLocator()->get('Purchasings');
                $purchase = $tablePurchaseOrders->get($dataRow['purchasing_id']);
                $purchase->is_active = 'N';

                $tablePurchaseOrders->save($purchase);

                $this->Flash->success(__('The retur has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The retur could not be saved. Please, try again.'));
        }

        $data['lastNumber'] = $this->get_last_number();
        $suppliers = $this->ReturSuppliers->Suppliers->find('list', ['limit' => 200]);
        $purchasings = $this->ReturSuppliers->Purchasings->find('list', ['limit' => 200]);
        $branches = $this->ReturSuppliers->Branches->find('list', ['limit' => 200]);
        $warehouses = $this->ReturSuppliers->Warehouses->find('list', ['limit' => 200]);
        $this->set(compact('returSupplier', 'suppliers', 'purchasings', 'branches', 'warehouses', 'data'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Retur Supplier id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $returSupplier = $this->ReturSuppliers->get($id, [
            'contain' => ['Suppliers', 'Purchasings', 'ReturSupplierLines', 'ReturSupplierLines.Items', 'Purchasings.PurchasingLines', 'Purchasings.PurchasingLines.Items'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['date']));
            $supplierId = array('supplier_id' => $dataRow['supplier_id']);
            $purchaseId = array('purchasing_id' => $dataRow['purchasing_id']);
            $code = array('code' => $this->get_last_number());

            $returSupplier = $this->ReturSuppliers->patchEntity($returSupplier, array_merge($dataRow, $dataAuditLog, $date, $supplierId, $purchaseId, $code), ['associated' => ['ReturSupplierLines' => ['validate' => true]]]);

            //pr($dataRow);

            if ($this->ReturSuppliers->save($returSupplier)) {
                $id = $returSupplier->id;
                foreach ($dataRow['retur_supplier_lines'] as $index => $value) {
                    if ($value['reason'] > '0') {
                        $dataArr = array();
                        $dataArr[$index]['retur_supplier_id'] = $id;
                        $dataArr[$index]['item_id'] = $value['item_id'];
                        $dataArr[$index]['quantity'] = $value['quantity'];
                        $dataArr[$index]['nominal'] = $value['nominal'];
                        $dataArr[$index]['reason'] = $value['reason'];
                    } 
                    // else {
                    //     if (isset($dataRow['branch_id'])) {
                    //         $tableBranch = $this->getTableLocator()->get('BranchStocks');
                    //         $branch = $tableBranch->find('all')->where(['branch_id' => $dataRow['branch_id'], 'item_id' => $value['item_id']])->first();
                    //         $branch->stock = $branch->stock + $value['quantity'];
                    //         $tableBranch->save($branch);
                    //     } else {
                    //         $tableWarehouse = $this->getTableLocator()->get('WarehouseStocks');
                    //         $warehouse = $tableWarehouse->find('all')->where(['warehouse_id' => $dataRow['warehouse_id'], 'item_id' => $value['item_id']])->first();
                    //         $warehouse->stock = $warehouse->stock + $value['quantity'];
                    //         $tableWarehouse->save($warehouse);
                    //     }
                    // }
                }
                $tablePurchaseOrders = $this->getTableLocator()->get('Purchasings');
                $purchase = $tablePurchaseOrders->get($dataRow['purchasing_id']);
                $purchase->is_active = 'N';

                $tablePurchaseOrders->save($purchase);

                $this->Flash->success(__('The retur has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The retur could not be saved. Please, try again.'));
        }

        $data['lastNumber'] = $this->get_last_number();
        $suppliers = $this->ReturSuppliers->Suppliers->find('list', ['limit' => 200]);
        $purchasings = $this->ReturSuppliers->Purchasings->find('list', ['limit' => 200]);
        $branches = $this->ReturSuppliers->Branches->find('list', ['limit' => 200]);
        $warehouses = $this->ReturSuppliers->Warehouses->find('list', ['limit' => 200]);
        $this->set(compact('returSupplier', 'suppliers', 'purchasings', 'branches', 'warehouses', 'data'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Retur Supplier id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $returSupplier = $this->ReturSuppliers->get($id);
        if ($this->ReturSuppliers->delete($returSupplier)) {
            $this->Flash->success(__('The retur supplier has been deleted.'));
        } else {
            $this->Flash->error(__('The retur supplier could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getorder()
    {
        $this->autoRender = false;
        $this->loadModel('Purchasings');

        $search = $this->request->getQuery('search');

        $purchase = $this->Purchasings->find('all')->where(['Purchasings.number like' => '%' . $search . '%', 'Purchasings.is_active' => 'Y']);

        $result = array();
        foreach ($purchase as $key => $data) {
            $result[] = array("value" =>  $data->number, "data" => (object) array('id' => $data->id, 'label' => $data->number));
        }

        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }

    public function setorder()
    {
        $this->autoRender = false;
        $this->loadModel('Purchasings');
        $purchase = $this->Purchasings->find('all')->contain(['PurchasingLines.Items', 'Suppliers', 'Warehouses', 'Branches'])->where(['Purchasings.id' => $this->request->getQuery('id')])->first();

        return $this->response->withType("application/json")->withStringBody(json_encode($purchase));
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
        $sheet->setCellValue('A1', 'No. Retur');
        $sheet->setCellValue('B1', 'Supplier');
        $sheet->setCellValue('C1', 'No. Purchase Order');
        $sheet->setCellValue('D1', 'Tanggal');
        $sheet->setCellValue('E1', 'Keterangan');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }


        $report = $this->ReturSuppliers->find('all')->contain(['Suppliers', 'Purchasings'])->where([$condition])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->code);
            $sheet->setCellValue('B' . $row, (!empty($data->supplier_id) ? $data->supplier->name : '-'));
            $sheet->setCellValue('C' . $row, (!empty($data->purchasing_id) ? $data->purchasing->number : '-'));
            $sheet->setCellValue('D' . $row, $this->Krs->fDate($data->date, 'd-m-Y'));
            $sheet->setCellValue('E' . $row, $data->reason);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Retur Supplier - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
