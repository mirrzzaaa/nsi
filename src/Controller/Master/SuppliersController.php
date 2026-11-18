<?php

declare(strict_types=1);

namespace App\Controller\Master; 

use App\Controller\AppController;

// export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

/**
 * Suppliers Controller
 *
 * @property \App\Model\Table\SuppliersTable $Suppliers
 * @method \App\Model\Entity\Supplier[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SuppliersController extends AppController 
{ 
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $suppliers = $this->Suppliers->find('all')->contain(['Users']);

        $code = $this->request->getQuery('filtercode');
        $name = $this->request->getQuery('filtername');
        $address = $this->request->getQuery('filteraddress');
        $pic = $this->request->getQuery('filterpic');
        $status = $this->request->getQuery('filterstatus');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Suppliers.code like'] = '%' . $code . '%';
        }
        if (!empty($name)) {
            $dataWhere['Suppliers.name like'] = '%' . $name . '%';
        }
        if (!empty($address)) {
            $dataWhere['Suppliers.address like'] = '%' . $address . '%';
        }
        if (!empty($pic)) {
            $dataWhere[] = ['OR' => ['Suppliers.pic like"' . '%' . $pic . '%"', 'Suppliers.telp like"' . '%' . $pic . '%"']];
        }
        if (($status != '')) {
            $dataWhere['Suppliers.active'] = $status;
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $suppliers->where([$dataWhere])->order(['Suppliers.code' => 'DESC']) : $suppliers->order(['Suppliers.code' => 'DESC']);

        $this->set('suppliers', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $supplier = $this->Suppliers->get($id, [
            'contain' => ['Users', 'Items', 'Purchasings'],
        ]);

        $this->set(compact('supplier'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function get_last_number()
    {
        $dataRows = $this->Suppliers->find('all', [
            'fields' => array('codes' => 'MAX(CAST(Suppliers.code AS UNSIGNED))+1'),
        ]);
        $dataRows = $dataRows->first();
        $dataResult = isset($dataRows->codes) ? $dataRows->codes : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        return $result;
    }

    public function add()
    {
        $supplier = $this->Suppliers->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add"); 
            $dataAuditLog = array('is_log' => $auditLog);
            $npwp = array('npwp' => str_replace("_", "", $dataRow['npwp']));
            $telp_person = array('telp' => str_replace("_", "", $dataRow['telp']));
            $code = array('code' => $this->get_last_number());
            // $countries = array('country_id' => $dataRow['country_ids']);
            // $areas = array('area_id' => $dataRow['area_ids']);

            $supplier = $this->Suppliers->patchEntity($supplier, array_merge($dataRow, $dataAuditLog, $code, $npwp, $telp_person));
            //, $countries, $areas
            // pr($dataRow);

            if ($this->Suppliers->save($supplier)) {
                $this->Flash->success(__('The supplier has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
        }
        $users = $this->Suppliers->Users->find('list', ['limit' => 200]);
        // $country = $this->Suppliers->Country->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        // $area = $this->Suppliers->Area->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        //, 'country', 'area'
        $data['lastNumber'] = $this->get_last_number(); 
        $this->set(compact('supplier', 'users', 'data')); 
    }

    /**
     * Edit method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $supplier = $this->Suppliers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $npwp = array('npwp' => str_replace("_", "", $dataRow['npwp']));
            $telp_person = array('telp' => str_replace("_", "", $dataRow['telp']));

            $supplier = $this->Suppliers->patchEntity($supplier, array_merge($dataRow, $dataAuditLog, $npwp, $telp_person));
            if ($this->Suppliers->save($supplier)) {
                $this->Flash->success(__('The supplier has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
        }
        $users = $this->Suppliers->Users->find('list', ['limit' => 200]);
        // $country = $this->Suppliers->Country->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        // $area = $this->Suppliers->Area->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        //, 'country', 'area'
        $this->set(compact('supplier', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $supplier = $this->Suppliers->get($id);
        if ($this->Suppliers->delete($supplier)) {
            $this->Flash->success(__('The supplier has been deleted.'));
        } else {
            $this->Flash->error(__('The supplier could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function changestatus()
    {
        $id = $this->request->getData('id');
        $active = $this->request->getData('status');
        $is_update = $this->request->getData('is_update');

        $supplier = $this->Suppliers->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $supplier = $this->Suppliers->patchEntity($supplier, ['active' => $active, 'is_update' => $is_update]);

            if ($this->Suppliers->save($supplier)) {

                $response = array('status' => 'success', 'active' => $supplier->active);
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            } else {
                $response = array('status' => 'error');
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }
        }
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
        $sheet->setCellValue('B1', 'Jenis Upline');
        $sheet->setCellValue('C1', 'Nama Perusahaan');
        $sheet->setCellValue('D1', 'Nomor Sertifikat Produksi / Izin PAK');
        $sheet->setCellValue('E1', 'PIC/Nama Penanggung Jawab');
        $sheet->setCellValue('F1', 'Email Perusahaan');
        $sheet->setCellValue('G1', 'Alamat');
        $sheet->setCellValue('H1', 'Negara');
        $sheet->setCellValue('I1', 'Kabupaten/Kota');
        $sheet->setCellValue('J1', 'Telepon');
        $sheet->setCellValue('K1', 'Fax');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $report = $this->Suppliers->find('all')->contain(['Country', 'Area'])->where([$condition])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->code);
            $sheet->setCellValue('B' . $row, $data->category);
            $sheet->setCellValue('C' . $row, $data->name);
            $sheet->setCellValueExplicit('D' . $row, $data->izin_edar, DataType::TYPE_STRING);
            $sheet->setCellValue('E' . $row, $data->pic);
            $sheet->setCellValue('F' . $row, $data->email);
            $sheet->setCellValue('G' . $row, $data->address);
            $sheet->setCellValue('H' . $row, (($data->country_id > 0) ? ((!empty($data->country)) ? $data->country->name : '') : ''));
            $sheet->setCellValue('I' . $row, (($data->area_id > 0) ? ((!empty($data->area)) ? $data->area->name : '') : ''));
            $sheet->setCellValue('J' . $row, $data->telp);
            $sheet->setCellValue('K' . $row, $data->fax);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Supplier-' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
