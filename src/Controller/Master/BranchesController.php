<?php

declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

// export 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Branches Controller
 *
 * @property \App\Model\Table\BranchesTable $Branches
 * @method \App\Model\Entity\Branch[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BranchesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view 
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $branches = $this->Branches->find('all');

        $code = $this->request->getQuery('filtercode');
        $name = $this->request->getQuery('filtername');
        $address = $this->request->getQuery('filteraddress');
        $telp = $this->request->getQuery('filtertelp');
        $status = $this->request->getQuery('filterstatus');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Branches.code like'] = '%' . $code . '%';
        }
        if (!empty($name)) {
            $dataWhere['Branches.company_name like'] = '%' . $name . '%';
        }
        if (!empty($address)) {
            $dataWhere['Branches.company_address like'] = '%' . $address . '%';
        }
        if (!empty($telp)) {
            $dataWhere['Branches.company_telp like'] = '%' . $telp . '%';
        }
        if (($status != '')) {
            $dataWhere['Branches.is_active'] = $status;
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $branches->where([$dataWhere])->order(['Branches.code' => 'DESC']) : $branches->order(['Branches.code' => 'DESC']);

        $this->set('branches', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $branch = $this->Branches->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('branch'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function get_last_number()
    {
        $dataRows = $this->Branches->find('all', [
            'fields' => array('codes' => 'MAX(CAST(Branches.code AS UNSIGNED))+1'),
        ]);
        $dataRows = $dataRows->first();
        $dataResult = isset($dataRows->codes) ? $dataRows->codes : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        return $result;
    }


    public function add()
    {
        $branch = $this->Branches->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $code = array('code' => $this->get_last_number());

            $branch = $this->Branches->patchEntity($branch, array_merge($dataRow, $dataAuditLog, $code));
            if ($this->Branches->save($branch)) {
                $this->Flash->success(__('The branch has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The branch could not be saved. Please, try again.'));
        }
        $data['lastNumber'] = $this->get_last_number();
        $this->set(compact('branch', 'data'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $branch = $this->Branches->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Edit");
            $dataAuditLog = array('is_log' => $auditLog);

            $branch = $this->Branches->patchEntity($branch, array_merge($dataRow, $dataAuditLog));
            if ($this->Branches->save($branch)) {
                $this->Flash->success(__('The branch has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The branch could not be saved. Please, try again.'));
        }
        $this->set(compact('branch'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $branch = $this->Branches->get($id);
        if ($this->Branches->delete($branch)) {
            $this->Flash->success(__('The branch has been deleted.'));
        } else {
            $this->Flash->error(__('The branch could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function changestatus()
    {
        $id = $this->request->getData('id');
        $active = $this->request->getData('status');
        $is_update = $this->request->getData('is_update');

        $branch = $this->Branches->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $branch = $this->Branches->patchEntity($branch, ['is_active' => $active, 'is_update' => $is_update]);

            if ($this->Branches->save($branch)) {

                $response = array('status' => 'success', 'is_active' => $branch->is_active);
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
        ini_set('memory_limit', '2048M');
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'Kode');
        $sheet->setCellValue('B1', 'Nama Cabang');
        $sheet->setCellValue('C1', 'Alamat');
        $sheet->setCellValue('D1', 'Telepon');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $report = $this->Branches->find('all')->where([$condition])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->code);
            $sheet->setCellValue('B' . $row, $data->company_name);
            $sheet->setCellValue('C' . $row, $data->company_address);
            $sheet->setCellValue('D' . $row, $data->company_telp);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Cabang - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
