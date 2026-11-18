<?php

declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController; 


// export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/** 
 * Warehouses Controller
 *
 * @property \App\Model\Table\WarehousesTable $Warehouses
 * @method \App\Model\Entity\Warehouse[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WarehousesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $warehouses = $this->Warehouses->find('all');

        $code = $this->request->getQuery('filtercode');
        $name = $this->request->getQuery('filtername');
        $address = $this->request->getQuery('filteraddress');
        $pic = $this->request->getQuery('filterpic');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Warehouses.code like'] = '%' . $code . '%';
        }
        if (!empty($name)) {
            $dataWhere['Warehouses.name like'] = '%' . $name . '%';
        }
        if (!empty($address)) {
            $dataWhere['Warehouses.address like'] = '%' . $address . '%';
        }
        if (!empty($pic)) {
            $dataWhere[] = ['OR' => ['Warehouses.pic like"' . '%' . $pic . '%"', 'Warehouses.telp like"' . '%' . $pic . '%"']];
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $warehouses->where([$dataWhere])->order(['Warehouses.code' => 'DESC']) : $warehouses->order(['Warehouses.code' => 'DESC']);

        $this->set('warehouses', $this->paginate($queries, ['limit' => '10']));

    }

    /**
     * View method
     *
     * @param string|null $id Warehouse id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $warehouse = $this->Warehouses->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('warehouse'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function get_last_number()
    {
        $dataRows = $this->Warehouses->find('all', [
            'fields' => array('codes' => 'MAX(CAST(Warehouses.code AS UNSIGNED))+1'),
        ]);
        $dataRows = $dataRows->first();
        $dataResult = isset($dataRows->codes) ? $dataRows->codes : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        return $result;
    }

    public function add()
    {
        $warehouse = $this->Warehouses->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $telp_person = array('telp' => str_replace("_", "", $dataRow['telp']));
            $code = array('code' => $this->get_last_number());

            $warehouse = $this->Warehouses->patchEntity($warehouse, array_merge($dataRow, $dataAuditLog, $telp_person, $code));
            if ($this->Warehouses->save($warehouse)) {
                $this->Flash->success(__('The warehouse has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The warehouse could not be saved. Please, try again.'));
        }
        $data['lastNumber'] = $this->get_last_number();
        $branches = $this->Warehouses->Branches->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $this->set(compact('warehouse', 'branches', 'data'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Warehouse id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $warehouse = $this->Warehouses->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);

            $warehouse = $this->Warehouses->patchEntity($warehouse, array_merge($dataRow, $dataAuditLog));
            if ($this->Warehouses->save($warehouse)) {
                $this->Flash->success(__('The warehouse has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The warehouse could not be saved. Please, try again.'));
        }
        $branches = $this->Warehouses->Branches->find('list', ['limit' => 200]);
        $this->set(compact('warehouse', 'branches'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Warehouse id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $warehouse = $this->Warehouses->get($id);
        if ($this->Warehouses->delete($warehouse)) {
            $this->Flash->success(__('The warehouse has been deleted.'));
        } else {
            $this->Flash->error(__('The warehouse could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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
        $sheet->setCellValue('A1', 'Kode');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Alamat');
        $sheet->setCellValue('D1', 'PIC');
        $sheet->setCellValue('E1', 'Telepon');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }


        $report = $this->Warehouses->find('all')->where([$condition])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->code);
            $sheet->setCellValue('B' . $row, $data->name);
            $sheet->setCellValue('C' . $row, $data->address);
            $sheet->setCellValue('D' . $row, $data->pic);
            $sheet->setCellValue('E' . $row, $data->telp);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Warehouses - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
