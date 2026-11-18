<?php

declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

// export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Members Controller
 *
 * @property \App\Model\Table\MembersTable $Members
 * @method \App\Model\Entity\Member[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MembersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $members = $this->Members->find('all');
        $code = $this->request->getQuery('code');
        $name = $this->request->getQuery('name');
        $telp = $this->request->getQuery('telp');
        $npwp = $this->request->getQuery('npwp');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Members.code like'] = '%' . $code . '%';
        }
        if (!empty($name)) {
            $dataWhere['Members.name like'] = '%' . $name . '%';
        }
        if (!empty($telp)) {
            $dataWhere['Members.telp like'] = '%' . $telp . '%';
        }
        if (!empty($npwp)) {
            $dataWhere['Members.npwp like'] = '%' . $npwp . '%';
        }

        $queries = (!empty($dataWhere)) ? $members->where([$dataWhere])->order(['Members.code' => 'DESC']) : $members->order(['Members.code' => 'DESC']);

        $this->set('members', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Member id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $member = $this->Members->get($id, [
            'contain' => ['Orders'],
        ]);

        $this->set(compact('member'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function get_last_number()
    {
        $dataRows = $this->Members->find('all', [
            'fields' => array('codes' => 'MAX(CAST(Members.code AS UNSIGNED))+1'),
        ]);
        $dataRows = $dataRows->first();
        $dataResult = isset($dataRows->codes) ? $dataRows->codes : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        return $result;
    }

    public function add()
    {
        $member = $this->Members->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $dateReg = array('date_registry' => $this->Krs->dateTo($dataRow['date_registries']));
            $dateExp = array('date_expired' => $this->Krs->dateTo($dataRow['date_expires']));

            $member = $this->Members->patchEntity($member, array_merge($dataRow, $dataAuditLog, $dateExp, $dateReg));
            if ($this->Members->save($member)) {
                $this->Flash->success(__('The member has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The member could not be saved. Please, try again.'));
        }
        $data['lastNumber'] = $this->get_last_number();
        $this->set(compact('member', 'data'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Member id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $member = $this->Members->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $dateReg = array('date_registry' => $this->Krs->dateTo($dataRow['date_registries']));
            $dateExp = array('date_expired' => $this->Krs->dateTo($dataRow['date_expires']));

            $member = $this->Members->patchEntity($member, array_merge($dataRow, $dataAuditLog, $dateExp, $dateReg));
            if ($this->Members->save($member)) {
                $this->Flash->success(__('The member has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The member could not be saved. Please, try again.'));
        }
        $this->set(compact('member'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Member id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $member = $this->Members->get($id);
        if ($this->Members->delete($member)) {
            $this->Flash->success(__('The member has been deleted.'));
        } else {
            $this->Flash->error(__('The member could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function excel()
    {
        ini_set('memory_limit', '2048M');
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'Kode');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Telepon');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Alamat');
        $sheet->setCellValue('F1', 'Tanggal Registrasi');
        $sheet->setCellValue('G1', 'Tanggal Expired');
        $sheet->setCellValue('H1', 'NPWP');
        $sheet->setCellValue('I1', 'PPN');
        $sheet->setCellValue('J1', 'PIC');
        $sheet->setCellValue('K1', 'Status');

        $report = $this->Members->find('all')->select(['telepon' => 'Members.telp', 'code' => 'Members.code', 'name' => 'Members.name', 'email' => 'Members.email', 'address' => 'Members.address',  'regist' => 'Members.date_registry',  'expired' => 'Members.date_expired',  'npwp' => 'Members.npwp',  'Ppn' => 'Members.tax',  'pic' => 'Members.pic',  'status' => 'Members.status'])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->code);
            $sheet->setCellValue('B' . $row, $data->name);
            $sheet->setCellValue('C' . $row, $data->telepon);
            $sheet->setCellValue('D' . $row, $data->email);
            $sheet->setCellValue('E' . $row, $data->address);
            $sheet->setCellValue('F' . $row, $data->regist);
            $sheet->setCellValue('G' . $row, $data->expired);
            $sheet->setCellValue('H' . $row, $data->npwp);
            $sheet->setCellValue('I' . $row, $data->Ppn);
            $sheet->setCellValue('J' . $row, $data->pic);
            $sheet->setCellValue('K' . $row, $data->status);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Member-' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
