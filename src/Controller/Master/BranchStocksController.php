<?php

declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

// export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 

/**
 * BranchStocks Controller
 *
 * @property \App\Model\Table\BranchStocksTable $BranchStocks
 * @method \App\Model\Entity\BranchStock[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BranchStocksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $branchStocks = $this->BranchStocks->find('all')->contain(['Items.Suppliers', 'Branches', 'Items']);

        $code = $this->request->getQuery('filtercode');
        $name = $this->request->getQuery('filtername');
        $supplier = $this->request->getQuery('filtersupplier');
        $branch = $this->request->getQuery('filterbranch');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['BranchStocks.code like'] = '%' . $code . '%';
        }
        if (!empty($name)) {
            $dataWhere['Items.name like'] = '%' . $name . '%';
        }
        if (!empty($supplier)) {
            $dataWhere['Suppliers.name like'] = '%' . $supplier . '%';
        }
        if (!empty($branch)) {
            $dataWhere['Branches.name like'] = '%' . $branch . '%';
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $branchStocks->where([$dataWhere])->order(['BranchStocks.code' => 'DESC']) : $branchStocks->order(['BranchStocks.code' => 'DESC']);

        $this->set('branchStocks', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Branch Stock id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $branchStock = $this->BranchStocks->get($id, [
            'contain' => ['Branches', 'Items', 'Items.Suppliers'],
        ]);

        $this->set(compact('branchStock'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $branchStock = $this->BranchStocks->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['dates']));
            $stock = array('stock' => $this->Krs->nom2Dec($dataRow['stocks']));
            $buy = array('buy' => $this->Krs->nom2Dec($dataRow['buys']));
            $sell = array('sell' => $this->Krs->nom2Dec($dataRow['sells']));

            $branchStock = $this->BranchStocks->patchEntity($branchStock, array_merge($dataRow, $dataAuditLog, $date, $stock, $buy, $sell));
            if ($this->BranchStocks->save($branchStock)) {
                $this->Flash->success(__('The branch stock has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The branch stock could not be saved. Please, try again.'));
        }
        $branches = $this->BranchStocks->Branches->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $itemsLines = $this->BranchStocks->Items->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $this->set(compact('branchStock', 'branches', 'itemsLines'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Branch Stock id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $branchStock = $this->BranchStocks->get($id, [
            'contain' => ['Items', 'Branches'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['dates']));
            $buy = array('buy' => $this->Krs->nom2Dec($dataRow['buys']));
            $sell = array('sell' => $this->Krs->nom2Dec($dataRow['sells']));

            $branchStock = $this->BranchStocks->patchEntity($branchStock, array_merge($dataRow, $dataAuditLog, $date, $buy, $sell));
            if ($this->BranchStocks->save($branchStock)) {
                $this->Flash->success(__('The branch stock has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The branch stock could not be saved. Please, try again.'));
        }

        $this->set(compact('branchStock'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Branch Stock id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $branchStock = $this->BranchStocks->get($id);
        if ($this->BranchStocks->delete($branchStock)) {
            $this->Flash->success(__('The branch stock has been deleted.'));
        } else {
            $this->Flash->error(__('The branch stock could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function getitem()
    {
        $this->autoRender = false;
        $this->loadModel('Items');

        $search = $this->request->getQuery('search');

        $items = $this->Items->find('all')->where(['OR' => ['name like' => '%' . $search . '%']]);

        $result = array();
        foreach ($items as $key => $data) {
            $result[$key]['id'] = (int) $data['id'];
            $result[$key]['text'] = $data['name'];
        }
        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }

    public function setitem()
    {
        $this->autoRender = false;
        $this->loadModel('Items'); 

        $items = $this->Items->find('all')->where(['Items.id' => $this->request->getQuery('id')])->first();

        return $this->response->withType("application/json")->withStringBody(json_encode($items));
    }


    public function excel()
    {
        $session = $this->getRequest()->getSession(); //get session
        $condition = $session->read('condition');
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'Barcode');
        $sheet->setCellValue('B1', 'Nama Produk');
        $sheet->setCellValue('C1', 'Supplier');
        $sheet->setCellValue('D1', 'Stock');
        $sheet->setCellValue('E1', 'Satuan');
        $sheet->setCellValue('F1', 'Harga Beli');
        $sheet->setCellValue('G1', 'Harga Jual');
        $sheet->setCellValue('H1', 'Toko');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $report = $this->BranchStocks->find('all')->contain(['Items.Suppliers', 'Branches'])->where([$condition])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            
            $sheet->setCellValue('A' . $row, (!empty($data->item->barcode) ? $data->item->barcode : '-'));
            $sheet->setCellValue('B' . $row, (!empty($data->item->name) ? $data->item->name : '-'));
            $sheet->setCellValue('C' . $row, (!empty($data->item->supplier->name) ? $data->item->supplier->name : '-'));
            $sheet->setCellValue('D' . $row, (!empty($data->stock) ? $data->stock : '-'));
            $sheet->setCellValue('E' . $row, (!empty($data->item->unit) ? $data->item->unit : '-'));
            $sheet->setCellValue('F' . $row, (!empty($data->buy) ? $this->Krs->nom($data->buy) : '-'));
            $sheet->setCellValue('G' . $row, (!empty($data->sell) ? $this->Krs->nom($data->sell) : '-'));
            $sheet->setCellValue('H' . $row, (!empty($data->branch->name) ? $data->branch->name : '-'));
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Item Toko - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
