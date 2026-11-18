<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Offers Controller
 *
 * @property \App\Model\Table\OffersTable $Offers
 * @method \App\Model\Entity\Offer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OffersController extends AppController
{
    public function checkBranch() 
    { 
        
        $usr = $this->request->getAttribute('identity');
        $dt = array_map('intval', explode(',', $usr->branch_id));

        $this->loadModel('Branches');
        $branches = $this->Branches->find('all')->where(['Branches.id IN' => $dt])->toArray();
        // $result = $this->Authentication->getResult()->getData();
        // $b_ex = explode(',', $result['branch_id']);
        // $b_arr = array();

        // $brn = $this->getTableLocator()->get('Branches');

        // foreach ($b_ex as $key => $value) {
        //     $obj = (object) $value;
        //     $b_arr[$key] = $brn->get($obj);
        // }

        return $branches;
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $offers = $this->Offers->find('all')->contain(['Branches', 'Marketing']);
        $code = $this->request->getQuery('filtercode');
        $marketing = $this->request->getQuery('filtermkt');
        $cs = $this->request->getQuery('filtercustomer');
        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Offers.code like'] = '%' . $code . '%';
        }
        if (!empty($marketing)) {
            $dataWhere['Marketing.name like'] = '%' . $marketing . '%';
        }
        if (!empty($cs)) {
            $dataWhere['Offers.customer_name like'] = '%' . $cs . '%';
        }
        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(Offers.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }
        $queries = (!empty($dataWhere)) ? $offers->where([$dataWhere])->order(['Offers.date' => 'DESC']) : $offers->order(['Offers.date' => 'DESC']);

        $this->set('offers', $this->paginate($queries, ['limit' => '10']));
    }

    /** 
     * View method
     *
     * @param string|null $id Offer id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $offer = $this->Offers->get($id, [
            'contain' => ['Branches', 'Customers', 'Kabupatens'],
        ]);

        $this->set(compact('offer'));
    }

    public function get_last_number()
    {
        $dataRows = $this->Offers->find('all', [ 
            'fields' => array('codes' => 'MAX(Offers.code)'),
        ])->first();
        $code = (!empty($dataRows->codes) ? explode("/", $dataRows['codes']) : array());
        $dataResult = isset($code[0]) ? ($code[0] + 1) : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = $result . '/QTN/NSI/' . $this->Krs->numToRome(date('m')) . '/' . date('Y');
        return $number;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $offer = $this->Offers->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = $this->Krs->dateTo($dataRow['dates']);
            $dataDate = array('date' => $date);
            $dataAddress = array('customer_address' => $dataRow['address']);
            $dataDesc = array('description' => base64_encode($dataRow['description']));

            // buat nomor surats
            $data = $this->Offers->find('all', ['fields' => array('number' => 'MAX(Offers.number)')])->first();
            $dataNumber = array('number' => $data['number']);

            $offer = $this->Offers->patchEntity($offer, array_merge($dataRow, $dataAuditLog, $dataDate, $dataDesc, $dataAddress, $dataNumber));

            // pr($dataRow);

            if ($this->Offers->save($offer)) {
                $this->Flash->success(__('The offer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The offer could not be saved. Please, try again.'));
        }

        $this->loadModel('Branches');

        $data['lastNumber'] = $this->get_last_number(); 
        $marketings = $this->Offers->Customers->Users->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Users.devision' => 'Marketing'])->toArray();
        $branch = $this->Branches->find('list', ['keyField' => 'id', 'valueField' => 'company_name'])->where(['is_active' => 'Y'])->toArray();

        $this->set(compact('offer', 'marketings', 'data', 'branch'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Offer id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $offer = $this->Offers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id,  $isUser, "edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = $this->Krs->dateTo($dataRow['dates']);
            $dataDate = array('date' => $date);
            $dataAddress = array('customer_address' => $dataRow['customer_address']);
            $dataDesc = array('description' => base64_encode($dataRow['description']));

            $offer = $this->Offers->patchEntity($offer, array_merge($dataRow, $dataAuditLog, $dataDate, $dataAddress, $dataDesc));
            if ($this->Offers->save($offer)) {
                $this->Flash->success(__('The offer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The offer could not be saved. Please, try again.'));
        }

        $this->loadModel('Branches');
        
        $data['lastNumber'] = $this->get_last_number();
        $marketings = $this->Offers->Customers->Users->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Users.devision' => 'Marketing'])->toArray();
        $branch = $this->Branches->find('list', ['keyField' => 'id', 'valueField' => 'company_name'])->where(['is_active' => 'Y'])->toArray();

        $this->set(compact('offer', 'marketings', 'data', 'branch'));
    }


    public function approve($id = null)
    {
        $offer = $this->Offers->get($id, [
            'contain' => [], 
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_approve'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id,  $isUser, "approve");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = $this->Krs->dateTo($dataRow['dates']);
            $dataDate = array('approve_date' => date('Y-m-d H:i:s'));
            $dataAddress = array('customer_address' => $dataRow['customer_address']);
            $dataDesc = array('description' => base64_encode($dataRow['description']));

            $offer = $this->Offers->patchEntity($offer, array_merge($dataRow, $dataAuditLog, $dataDate, $dataAddress, $dataDesc));

            // pr($dataRow);

            if ($this->Offers->save($offer)) {
                $this->Flash->success(__('The offer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The offer could not be saved. Please, try again.'));
        }

        $this->loadModel('Branches');
        
        $data['lastNumber'] = $this->get_last_number();
        $marketings = $this->Offers->Customers->Users->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Users.devision' => 'Marketing'])->toArray();
        $branch = $this->Branches->find('list', ['keyField' => 'id', 'valueField' => 'company_name'])->where(['is_active' => 'Y'])->toArray();
        
        $this->set(compact('offer', 'marketings', 'data', 'branch'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Offer id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $offer = $this->Offers->get($id);
        if ($this->Offers->delete($offer)) {
            $this->Flash->success(__('The offer has been deleted.'));
        } else {
            $this->Flash->error(__('The offer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function print($id = null)
    {
        $print = $this->Offers->find('all')->contain(['Marketing', 'Branches'])->where(['Offers.id' => $id])->first();

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->set(compact('print'));
    }

    public function printOut($id = null)
    {
        $print = $this->Offers->find('all')->contain(['Marketing', 'Branches'])->where(['Offers.id' => $id])->first();

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->set(compact('print'));
    }


    public function excel()
    {
        ini_set('memory_limit', '2048M');
        $session = $this->getRequest()->getSession(); //get session
        $condition = $session->read('condition');
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Sheet pertama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'No. Ref');
        $sheet->setCellValue('B1', 'Customer');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Marketing');
        $sheet->setCellValue('E1', 'Tanggal Setuju');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $report = $this->Offers->find('all')->contain(['Users'])->where([$condition])->toArray();
 
        // Inisialisasi baris awal
        $row = 2;

        foreach ($report as $index => $data) {            
            // Memastikan bahwa setiap field yang mungkin kosong memiliki nilai default
            $code = !empty($data->code) ? $data->code : '-';
            $customer = !empty($data->customer_name) ? $data->customer_name : '-';
            $date = !empty($data->date) ? $data->date->format('d-m-Y') : '-';
            $marketing = !empty($data->is_marketing) ? $data->user->name : '-';
            $approveDate = !empty($data->approve_date) ? $data->approve_date->format('d-m-Y') : '-';
            
            // Menulis data ke dalam sheet
            $sheet->setCellValue('A' . $row, $code);
            $sheet->setCellValue('B' . $row, $customer);
            $sheet->setCellValue('C' . $row, $date);
            $sheet->setCellValue('D' . $row, $marketing);
            $sheet->setCellValue('E' . $row, $approveDate);

            // Increment baris setelah setiap iterasi
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Rekap Penawaran-' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
