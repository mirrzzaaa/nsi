<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher; //Memanggil PasswordHaser


// export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $users = $this->Users->find('all')->contain(['Branches']);
        $code = $this->request->getQuery('code');
        $name = $this->request->getQuery('name');
        $staff = $this->request->getQuery('staff');
        $telp = $this->request->getQuery('telp');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Users.code like'] = '%' . $code . '%';
        }
        if (!empty($name)) {
            $dataWhere['Users.name like'] = '%' . $name . '%';
        }
        if (!empty($staff)) {
            $dataWhere['Users.devision like'] = '%' . $staff . '%';
        }
        if (!empty($telp)) {
            $dataWhere['Users.telp like'] = '%' . $telp . '%';
        }

        $queries = (!empty($dataWhere)) ? $users->where([$dataWhere])->order(['Users.code' => 'DESC']) : $users->order(['Users.code' => 'DESC']);

        $this->set('users', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Branches'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $hasher = new DefaultPasswordHasher(); // Memanggil class PasswordHasher

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $dataHint = array('help_hint_pwd' => $dataRow['password_news']);
            $dataName = array('name' => $dataRow['names']);
            $dataDiv = array('devision' => $dataRow['devisions']);
            $dataCode = array('code' => $dataRow['codes']);
            $dataPassword = (empty($dataRow['password_news'])) ? array() : array('password_new' => $hasher->hash($dataRow['password_news']));
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");

            $dataAuditLog = array('is_log' => $auditLog);

            $user = $this->Users->patchEntity($user, array_merge($dataPassword, $dataHint, $dataName, $dataDiv, $dataCode, $dataRow, $dataAuditLog));
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $branches = $this->Users->Branches->find('list', ['limit' => 200]);
        $this->set(compact('user', 'branches'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Edit");

            $dataAuditLog = array('is_log' => $auditLog);

            $user = $this->Users->patchEntity($user, array_merge($dataRow, $dataAuditLog));
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $branches = $this->Users->Branches->find('list', ['limit' => 200]);
        $this->set(compact('user', 'branches'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function reset($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $hasher = new DefaultPasswordHasher(); // Memanggil class PasswordHasher
            $dataRow = $this->request->getData();

            $isUser = $dataRow['user_id'];
            $dataUserId = array('is_update' => $isUser);
            $dataPassword = (empty($dataRow['passwordNew'])) ? array() : array('password_new' => $hasher->hash($dataRow['passwordNew']));

            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id,  $isUser, "Reset Password");
            $dataAuditLog = array('is_log' => "'" . $auditLog . "'");

            $user = $this->Users->patchEntity($user, array_merge($dataUserId, $dataPassword, $dataAuditLog));

            if ($this->Users->save($user)) {
                $this->Flash->success('Terima kasih, sandi berhasil disimpan');

                return $this->redirect(['controller' => 'users']);
            }
            $this->Flash->error('Maaf, sandi tidak dapat disimpan!');
        }
        $this->set(compact('user'));
    }

    public function change($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $hasher = new DefaultPasswordHasher(); // Memanggil class PasswordHasher
            $dataRow = $this->request->getData();
            $isUser = $dataRow['user_id'];
            $dataUserId = array('is_update' => $isUser);
            $dataPassword = (empty($dataRow['passwordNew'])) ? array() : array('password_new' => $hasher->hash($dataRow['passwordNew']));

            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id,  $isUser, "Change Password");
            $dataAuditLog = array('is_log' => $auditLog);

            $user = $this->Users->patchEntity($user, array_merge($dataUserId, $dataPassword, $dataAuditLog));

            if ($this->Users->save($user)) {
                $this->Flash->success('Terima kasih, sandi berhasil disimpan');

                return $this->redirect(['controller' => 'home']);
            }
            $this->Flash->error('Maaf, sandi tidak dapat disimpan!');
        }
        $this->set(compact('user'));
    }

    public function access($id = null)
    {
        $userData = $this->request->getAttribute('identity');

        $this->loadModel('Branches');
        $branch = $this->Branches
            ->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])
            ->toArray();

        $users = $this->Users->get($id);

        $rules = $this->Krs->_rule($users->rules);
        $this->set(compact('users', 'branch', 'rules'));

        if ($this->request->is(['patch', 'post', 'put'])) { 
            $dataRow = $this->request->getData();
            $isUser = $dataRow['user_id'];
            $dataUserId = array('is_update' => $dataRow['user_id']);
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id,  $isUser, "Edit Access");

            $dataBranchId = (!empty($dataRow['branch_ids'])) ? array('branch_id' => implode(",", $dataRow['branch_ids'])) : array();

            $dataRules = $this->Krs->createRule($dataRow['Rule']);

            $dataAuditLog = array('is_log' => $auditLog);
            $dataRule = array('rules' => $dataRules);
            $dataIsActive = array('is_active' => $dataRow['is_active']);
            $dataApprove1 = array('approved' => $dataRow['approved']);
            $dataApprove2 = array('approved_ceo' => $dataRow['approved_ceo']);
            $dataPembayaran = array('payment' => $dataRow['payment']);
            $dataFullAkses = array('pettycash_full_access' => $dataRow['pettycash_full_access']);

            $users = $this->Users->patchEntity($users, array_merge($dataUserId, $dataAuditLog, $dataRule, $dataBranchId, $dataIsActive, $dataApprove1, $dataApprove2, $dataPembayaran, $dataFullAkses));

            // pr($users);
            if ($this->Users->save($users)) {
                $this->Flash->success('Terima kasih, hak akses berhasil disimpan');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf, sandi tidak dapat disimpan!');
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
        $sheet->setCellValue('A1', 'Kode');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Staff');
        $sheet->setCellValue('D1', 'Telepon');
        $sheet->setCellValue('E1', 'Email');
        $sheet->setCellValue('F1', 'Tanggal Gabung');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $report = $this->Users->find('all')->contain(['Branches'])->select(['code' => 'Users.code', 'name' => 'Users.name',  'staff' => 'Users.devision',  'telp' => 'Users.telp',  'email' => 'Users.email',  'date' => 'Users.created'])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->code);
            $sheet->setCellValue('B' . $row, $data->name);
            $sheet->setCellValue('C' . $row, $data->staff);
            $sheet->setCellValue('D' . $row, $data->telp);
            $sheet->setCellValue('E' . $row, $data->email);
            $sheet->setCellValue('F' . $row, date_format($data->date, 'd-m-Y'));
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Users-' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
