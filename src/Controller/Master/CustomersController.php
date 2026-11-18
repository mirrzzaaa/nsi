<?php

declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomersController extends AppController
{ 
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */ 
    public function index()
    { 
        $session = $this->getRequest()->getSession(); //get session
        $customers = $this->Customers->find('all')->contain(['Users']);

        $code = $this->request->getQuery('filtercode');
        $name = $this->request->getQuery('filtername');
        $marketing = $this->request->getQuery('filtermarketing');
        $va = $this->request->getQuery('filterva');
        $status = $this->request->getQuery('filterstatus');
        $ppn = $this->request->getQuery('filterppn');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Customers.code like'] = '%' . $code . '%'; 
        }
        if (!empty($name)) {
            $dataWhere['Customers.name like'] = '%' . $name . '%';
        }
        if (!empty($marketing)) {
            $dataWhere['Users.name like'] = '%' . $marketing . '%';
        }
        if (!empty($va)) {
            $dataWhere[] = ['OR' => ['Customers.va_name like"' . '%' . $va . '%"', 'Customers.va_no like"' . '%' . $va . '%"']];
        }
        if (($status != '')) {
            $dataWhere['Customers.active'] = $status;
        }

        if (($ppn != '')) {
            $dataWhere['Customers.ppn'] = $ppn;
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $customers->where([$dataWhere])->order(['Customers.id' => 'Desc']) : $customers->order(['Customers.id' => 'Desc']);

        $this->set('customers', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => ['Users'], 
        ]);

        $this->set(compact('customer'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function get_last_number()
    {
        $dataRows = $this->Customers->find('all', [
            'fields' => array('codes' => 'MAX(CAST(Customers.code AS UNSIGNED))+1'),
        ]);
        $dataRows = $dataRows->first();
        $dataResult = isset($dataRows->codes) ? $dataRows->codes : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        return $result;
    }

    public function add()
    {
        $customer = $this->Customers->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $telp_person = array('telp_person' => str_replace("_", "", $dataRow['telp_person']));
            $phone_invoice = array('phone_invoice' => str_replace("_", "", $dataRow['phone_invoice']));
            $phone_tax_invoice = array('phone_tax_invoice' => str_replace("_", "", $dataRow['phone_tax_invoice']));
            $npwp = array('npwp' => str_replace("_", "", $dataRow['npwp']));
            $code = array('code' => $this->get_last_number());  

            $customer = $this->Customers->patchEntity($customer, array_merge($dataRow, $dataAuditLog, $telp_person, $phone_invoice, $phone_tax_invoice, $npwp, $code));

            // pr($dataRow);

            if ($this->Customers->save($customer)) { 
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }

        $data['lastNumber'] = $this->get_last_number();
        $marketings = $this->Customers->Users->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Users.devision' => 'Marketing'])->toArray();

        $this->loadModel('DaerahProvinsis');
        $provinsi = $this->DaerahProvinsis->find('list', ['keyField' => 'id_prov', 'valueField' => 'nama'])->toArray();

        $users = $this->Customers->Users->find('list', ['limit' => 200]);

        $this->set(compact('customer', 'data', 'marketings', 'users', 'provinsi'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog("Customers", 'N', $this->request->getParam('controller'),  $isUser, "Customers edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $telp_person = array('telp_person' => str_replace("_", "", $dataRow['telp_person']));
            $phone_invoice = array('phone_invoice' => str_replace("_", "", $dataRow['phone_invoice']));
            $phone_tax_invoice = array('phone_tax_invoice' => str_replace("_", "", $dataRow['phone_tax_invoice']));
            $npwp = array('npwp' => str_replace("_", "", $dataRow['npwp']));

            $customer = $this->Customers->patchEntity($customer, array_merge($dataRow, $dataAuditLog, $telp_person, $phone_invoice, $phone_tax_invoice, $npwp));
            // pr($customer);
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $marketings = $this->Customers->Users->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Users.devision' => 'Marketing'])->toArray();

        $this->loadModel('DaerahProvinsis');
        $provinsi = $this->DaerahProvinsis->find('list', ['keyField' => 'id_prov', 'valueField' => 'nama'])->toArray();

        $this->loadModel('DaerahKabupatens');
        $districts = $this->DaerahKabupatens->find('list', ['keyField' => 'id_kab', 'valueField' => 'nama'])->where(['id_prov' => $customer->province])->toArray();
        $this->set(compact('customer', 'marketings', 'provinsi', 'districts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customer = $this->Customers->get($id);
        if ($this->Customers->delete($customer)) {
            $this->Flash->success(__('The customer has been deleted.'));
        } else {
            $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getkabupaten()
    {
        $this->loadModel('DaerahKabupatens');
        $label = $this->DaerahKabupatens->find('list', ['keyField' => 'id_kab', 'valueField' => 'nama'])->where(['DaerahKabupatens.id_prov' => $this->request->getQuery('id')])->toArray();

        return $this->response->withType("application/json")->withStringBody(json_encode($label));
    }


    public function changestatus() 
    {
        $id = $this->request->getData('id');
        $active = $this->request->getData('status');
        $is_update = $this->request->getData('is_update');

        $customer = $this->Customers->get($id, [
            'contain' => []
        ]);
 
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, ['active' => $active, 'is_update' => $is_update]);

            if ($this->Customers->save($customer)) {

                $response = array('status' => 'success', 'active' => $customer->active);
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
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'Nama');
        $sheet->setCellValue('B1', 'Alamat');
        $sheet->setCellValue('C1', 'Area');
        $sheet->setCellValue('D1', 'Marketing');
        $sheet->setCellValue('E1', 'Contact Person');
        $sheet->setCellValue('F1', 'Telepon Contact Person');
        $sheet->setCellValue('G1', 'NPWP');
        $sheet->setCellValue('H1', 'Bank');
        $sheet->setCellValue('I1', 'No. Rekening');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }


        $vn = $this->Customers->find('all')->contain(['Users'])->where([$condition])->toArray();
        $row = 2;
        foreach ($vn as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->name);
            $sheet->setCellValue('B' . $row, $data->address_penghasil);
            $sheet->setCellValue('C' . $row, $data->area);
            $sheet->setCellValue('D' . $row, (($data->marketing_id > 0) && (!empty($data->user)) ? $data->user->name : '-'));
            $sheet->setCellValue('E' . $row, $data->contact_person);
            $sheet->setCellValue('F' . $row, $data->telp_person);
            $sheet->setCellValue('G' . $row, $data->npwp);
            $sheet->setCellValue('H' . $row, $data->bank_name_ori);
            $sheet->setCellValue('I' . $row, $data->bank_norek_ori);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Customers - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
