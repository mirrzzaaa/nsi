<?php

declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

// export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  

/**
 * Mouses Controller 
 *
 * @property \App\Model\Table\MousesTable $Mouses
 * @method \App\Model\Entity\Mouse[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MousesController extends AppController
{
    /**
     * Index method 
     * 
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $mouses = $this->Mouses->find('all')->contain(['Customers']);

        $code = $this->request->getQuery('filtercode');
        $customer = $this->request->getQuery('filtercustomer');
        $pic = $this->request->getQuery('filterpic');
        $telp = $this->request->getQuery('filtertelp');
        $status = $this->request->getQuery('filterstatus');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Mouses.code like'] = '%' . $code . '%';
        }
        if (!empty($customer)) {
            $dataWhere['Customers.name like'] = '%' . $customer . '%';
        }
        if (!empty($pic)) {
            $dataWhere['Mouses.pic_name like'] = '%' . $pic . '%';
        }
        if (!empty($telp)) {
            $dataWhere['Mouses.pic_telp like'] = '%' . $telp . '%';
        }
        if (($status != '')) {
            $dataWhere['Mouses.active'] = $status;
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $mouses->where([$dataWhere])->order(['Mouses.id' => 'Desc']) : $mouses->order(['Mouses.id' => 'Desc']);

        $this->set('mouses', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Mouse id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mouse = $this->Mouses->get($id, [
            'contain' => [ 'Customers', 'MouseItems.Items'],
        ]);

        $this->set(compact('mouse'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mouse = $this->Mouses->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $date_contract = array('date_contract' => $this->Krs->dateTo($dataRow['date_contracts']));
            $date_expired = array('date_expired' => $this->Krs->dateTo($dataRow['date_expireds']));
            $telp = array('pic_telp' => str_replace("_", "", $dataRow['pic_telp'])); 

            $mouse_items = array();
            foreach ($dataRow['mouse_items'] as $index => $value) {
                $mouse_items['mouse_items'][$index]['item_id'] = $value['item_id'];
                $mouse_items['mouse_items'][$index]['customer_id'] = $dataRow['customer_id'];
                $mouse_items['mouse_items'][$index]['price'] = $this->Krs->nom2Dec($value['price']);
                $mouse_items['mouse_items'][$index]['unit'] = $value['unit'];
                $mouse_items['mouse_items'][$index]['description'] = $value['description'];
            }
            $mouse = $this->Mouses->patchEntity($mouse, array_merge($dataRow, $dataAuditLog, $date_contract, $date_expired, $telp, $mouse_items));
            if ($this->Mouses->save($mouse)) {
                $this->Flash->success(__('The mouse has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mouse could not be saved. Please, try again.'));
        }

        $this->loadModel('Items');
        $items = $this->Items->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $customers = $this->Mouses->Customers->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $this->set(compact('mouse', 'items', 'customers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Mouse id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mouse = $this->Mouses->get($id, [
            'contain' => ['MouseItems.Items', 'Customers'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $date_contract = array('date_contract' => $this->Krs->dateTo($dataRow['date_contracts']));
            $date_expired = array('date_expired' => $this->Krs->dateTo($dataRow['date_expireds']));
            $telp = array('pic_telp' => str_replace("_", "", $dataRow['pic_telp']));

            $mouse_items = array();
            foreach ($dataRow['mouse_items'] as $index => $value) {
                if ($value['id'] == 0) {
                    $mouse_items['mouse_items'][$index]['item_id'] = $value['item_id'];
                    $mouse_items['mouse_items'][$index]['customer_id'] = $dataRow['customer_id'];
                    $mouse_items['mouse_items'][$index]['price'] = $this->Krs->nom2Dec($value['price']);
                    $mouse_items['mouse_items'][$index]['unit'] = $value['unit'];
                    $mouse_items['mouse_items'][$index]['description'] = $value['description'];
                }
            }
            $mouse = $this->Mouses->patchEntity($mouse, array_merge($dataRow, $dataAuditLog, $date_contract, $date_expired, $telp, $mouse_items));
            if ($this->Mouses->save($mouse)) {
                $this->Flash->success(__('The mouse has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mouse could not be saved. Please, try again.'));
        }
        $this->loadModel('Items');
        $items = $this->Items->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $this->set(compact('mouse', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Mouse id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mouse = $this->Mouses->get($id);
        if ($this->Mouses->delete($mouse)) {
            $this->Flash->success(__('The mouse has been deleted.'));
        } else {
            $this->Flash->error(__('The mouse could not be deleted. Please, try again.'));
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
            $result[$key]['text'] = $data['name'] . ' - ' . $data['unit'];
            $result[$key]['unit'] = $data['unit'];
            $result[$key]['selling_price'] = $data['selling_price'];
        }
        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }
    
    public function setitem()
    {
        $this->autoRender = false;
        $this->loadModel('Items');

        // Ambil id dari parameter request
        $id = $this->request->getQuery('id');

        $items = $this->ActualCosts->get($id, [
            'contain' => ['Items'], 
        ]);

        return $this->response->withType("application/json")->withStringBody(json_encode($items));
    }

    public function changestatus() 
    {
        $id = $this->request->getData('id');
        $active = $this->request->getData('status');
        $is_update = $this->request->getData('is_update');

        $mouse = $this->Mouses->get($id, [
            'contain' => []
        ]);
 
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mouse = $this->Mouses->patchEntity($mouse, ['active' => $active, 'is_update' => $is_update]);

            if ($this->Mouses->save($mouse)) {

                $response = array('status' => 'success', 'active' => $mouse->active);
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
        $sheet->setCellValue('A1', 'No. MOU');
        $sheet->setCellValue('B1', 'Customer');
        $sheet->setCellValue('C1', 'PIC');
        $sheet->setCellValue('D1', 'Telepon');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }


        $report = $this->Mouses->find('all')->contain(['Customers'])->where([$condition])->toArray();
        $row = 2;
        foreach ($report as $index => $data) {
            $sheet->setCellValue('A' . $row, (!empty($data->code) ? $data->code : '-'));
            $sheet->setCellValue('B' . $row, (($data->customer_id > 0) ? ((!empty($data->customer)) ? $data->customer->name : '-') : '-'));
            $sheet->setCellValue('C' . $row, (!empty($data->pic_name) ? $data->pic_name : '-'));
            $sheet->setCellValue('D' . $row, (!empty($data->pic_telp) ? $data->pic_telp : '-'));
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'MOU - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
} 
