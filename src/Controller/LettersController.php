<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash; 

// export 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Letters Controller
 *
 * @property \App\Model\Table\LettersTable $Letters
 * @method \App\Model\Entity\Letter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LettersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $letters = $this->Letters->find('all')->contain(['Users']); 
        $code = $this->request->getQuery('filtercode');
        $user = $this->request->getQuery('filteruser');
        $tujuan = $this->request->getQuery('filtertujuan');
        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Letters.code like'] = '%' . $code . '%';
        }
        if (!empty($user)) {
            $dataWhere['Users.code like'] = '%' . $user . '%'; 
        }
        if (!empty($tujuan)) {
            $dataWhere['Letters.description like'] = '%' . $tujuan . '%';
        }
        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(Letters.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }
        $queries = (!empty($dataWhere)) ? $letters->where([$dataWhere])->order(['Letters.date' => 'DESC']) : $letters->order(['Letters.date' => 'DESC']);

        $this->set('letters', $this->paginate($queries, ['limit' => '10']));

    }

    /**
     * View method
     *
     * @param string|null $id Letter id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $letter = $this->Letters->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('letter'));
    }

    public function get_last_number()
    {
        $dataRows = $this->Letters->find('all', [ 
            'fields' => array('codes' => 'MAX(Letters.code)'),
        ])->first();
        $code = (!empty($dataRows->codes) ? explode("/", $dataRows['codes']) : array());
        $dataResult = isset($code[0]) ? ($code[0] + 1) : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = $result;
        return $number;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $letter = $this->Letters->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = $this->Krs->dateTo($dataRow['dates']);
            $dataDate = array('date' => $date);

            $letter = $this->Letters->patchEntity($letter, array_merge($dataRow, $dataAuditLog, $dataDate));

            // pr($dataRow);

            if ($this->Letters->save($letter)) {
                $this->Flash->success(__('The letter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The letter could not be saved. Please, try again.'));
        }

        $data['lastNumber'] = $this->get_last_number();
 
        $this->set(compact('letter', 'data'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Letter id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $letter = $this->Letters->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = $this->Krs->dateTo($dataRow['dates']);
            $dataDate = array('date' => $date);

            $letter = $this->Letters->patchEntity($letter, array_merge($dataRow, $dataAuditLog, $dataDate));

            // pr($dataRow);

            if ($this->Letters->save($letter)) {
                $this->Flash->success(__('The letter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The letter could not be saved. Please, try again.'));
        }
        $data['lastNumber'] = $this->get_last_number();

        $this->set(compact('letter', 'data'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Letter id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $letter = $this->Letters->get($id);
        if ($this->Letters->delete($letter)) {
            $this->Flash->success(__('The letter has been deleted.'));
        } else {
            $this->Flash->error(__('The letter could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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
        $sheet->setCellValue('A1', 'No. Surat');
        $sheet->setCellValue('B1', 'Project');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Tujuan');
        $sheet->setCellValue('E1', 'Admin');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }


        $report = $this->Letters->find('all')->contain('Users')->where([$condition])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {

            $sheet->setCellValue('A' . $row, $data->code);
            $sheet->setCellValue('B' . $row, (!empty($data->project) ? $data->project : '-'));
            $sheet->setCellValue('C' . $row, $this->Krs->fDate($data->date, 'd-m-Y'));
            $sheet->setCellValue('D' . $row, (!empty($data->description) ? $data->description : '-'));
            $sheet->setCellValue('E' . $row, ($data->is_create > 0) ? $data->user->code : '-');
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) { 
            $writer->save('php://output');
        });
        $filename = 'No. Surat - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
