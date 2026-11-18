<?php

declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Trucks Controller
 *
 * @property \App\Model\Table\TrucksTable $Trucks
 * @method \App\Model\Entity\Truck[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrucksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view 
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $trucks = $this->Trucks->find('all');

        $nopol = $this->request->getQuery('filternopol');
        $merek = $this->request->getQuery('filtermerek');
        $rangka = $this->request->getQuery('filterrangka');
        $mesin = $this->request->getQuery('filtermesin');
        $asuransi = $this->request->getQuery('filterasuransi');
        $status = $this->request->getQuery('filterstatus');

        $dataWhere = array();
        if (!empty($nopol)) {
            $dataWhere['Trucks.name like'] = '%' . $nopol . '%';
        }
        if (!empty($merek)) {
            $dataWhere[] = ['OR' => ['Trucks.merk like"' . '%' . $merek . '%"', 'Trucks.types like"' . '%' . $merek . '%"']];
        }
        if (!empty($rangka)) {
            $dataWhere['Trucks.chassis_no like'] = '%' . $rangka . '%';
        }
        if (!empty($mesin)) {
            $dataWhere['Trucks.machine_no like'] = '%' . $mesin . '%';
        }
        if (!empty($asuransi)) {
            $dataWhere['Trucks.insurance like'] = '%' . $asuransi . '%';
        }
        if (($status != '')) {
            $dataWhere['Trucks.active'] = $status;
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $trucks->where([$dataWhere])->order(['Trucks.id' => 'Desc']) : $trucks->order(['Trucks.id' => 'Desc']);

        $this->set('trucks', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $truck = $this->Trucks->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('truck'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function add()
    {
        $truck = $this->Trucks->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);

            if (!$truck->getErrors) {

                // truck
                $truck_path = WWW_ROOT . 'upload/truck' . DS;
                $truck_ = $dataRow['image'];
                $truck_photo = array();
                if ($truck_->getClientFilename()) {
                    $truck_img = $this->Image->uploadimage($truck_path, $truck_);
                    $truck_photo = array('image' => $truck_img);
                } else {
                    $truck_photo = array('image' => null);
                }

                // no rangka
                $chassis_path = WWW_ROOT . 'upload/truck' . DS;
                $chassis = $dataRow['chassis_no_img'];
                $chassis_photo = array();
                if ($chassis->getClientFilename()) {
                    $chassis_img = $this->Image->uploadimage($chassis_path, $chassis);
                    $chassis_photo = array('chassis_no_img' => $chassis_img);
                } else {
                    $chassis_photo = array('chassis_no_img' => null);
                }

                //  no mesin
                $machine_path = WWW_ROOT . 'upload/truck' . DS;
                $machine = $dataRow['machine_no_img'];
                $machine_photo = array();
                if ($machine->getClientFilename()) {
                    $machine_img = $this->Image->uploadimage($machine_path, $machine);
                    $machine_photo = array('machine_no_img' => $machine_img);;
                } else {
                    $machine_photo = array('machine_no_img' => null);
                }
            }

            $truck = $this->Trucks->patchEntity($truck, array_merge($dataRow, $dataAuditLog, $truck_photo, $chassis_photo, $machine_photo));
            if ($this->Trucks->save($truck)) {
                $this->Flash->success(__('The truck has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The truck could not be saved. Please, try again.'));
        }

        $users = $this->Trucks->Users->find('list', ['limit' => 200]);

        $this->set(compact('truck', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $truck = $this->Trucks->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog("Trucks", 'N', $this->request->getParam('controller'),  $isUser, "Trucks add");
            $dataAuditLog = array('is_log' => $auditLog);
            $typeTruk = array('types' => $dataRow['types']);

            if (!$truck->getErrors) {

                // truck
                $truck_path = WWW_ROOT . 'upload/truck' . DS;
                $truck_ = $dataRow['image'];
                $truck_photo = array();
                if ($truck_->getClientFilename()) {
                    $truck_img = $this->Image->uploadimage($truck_path, $truck_);
                    $truck_photo = array('image' => $truck_img);
                } else if ($truck['image'] !== null) {
                    $truck_photo = array('image' => $truck['image']);
                } else {
                    $truck_photo = array('image' => null);
                }

                // no rangka
                $chassis_path = WWW_ROOT . 'upload/truck' . DS;
                $chassis = $dataRow['chassis_no_img'];
                $chassis_photo = array();
                if ($chassis->getClientFilename()) {
                    $chassis_img = $this->Image->uploadimage($chassis_path, $chassis);
                    $chassis_photo = array('chassis_no_img' => $chassis_img);
                } else if ($truck['chassis_no_img'] !== null) {
                    $chassis_photo = array('chassis_no_img' => $truck['chassis_no_img']);
                } else {
                    $chassis_photo = array('chassis_no_img' => null);
                }

                //  no mesin
                $machine_path = WWW_ROOT . 'upload/truck' . DS;
                $machine = $dataRow['machine_no_img'];
                $machine_photo = array();
                if ($machine->getClientFilename()) {
                    $machine_img = $this->Image->uploadimage($machine_path, $machine);
                    $machine_photo = array('machine_no_img' => $machine_img);;
                } else if ($truck['machine_no_img'] !== null) {
                    $machine_photo = array('machine_no_img' => $truck['machine_no_img']);
                } else {
                    $machine_photo = array('machine_no_img' => null);
                }
            }

            $truck = $this->Trucks->patchEntity($truck, array_merge($dataRow, $dataAuditLog, $truck_photo, $chassis_photo, $machine_photo, $typeTruk));

            if ($this->Trucks->save($truck)) {
                $this->Flash->success(__('The truck has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The truck could not be saved. Please, try again.'));
        }

        $this->set(compact('truck'));
    }

    public function changestatus()
    {
        $id = $this->request->getData('id');
        $active = $this->request->getData('status');
        $is_update = $this->request->getData('is_update');

        $trucks = $this->Trucks->get($id, [ 
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $trucks = $this->Trucks->patchEntity($trucks, ['active' => $active, 'is_update' => $is_update]);

            if ($this->Trucks->save($trucks)) {

                $response = array('status' => 'success', 'active' => $trucks->active);
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            } else {
                $response = array('status' => 'error');
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $truck = $this->Trucks->get($id);
        if ($this->Trucks->delete($truck)) {
            $this->Flash->success(__('The truck has been deleted.'));
        } else {
            $this->Flash->error(__('The truck could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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
        $sheet->setCellValue('A1', 'Merk');
        $sheet->setCellValue('B1', 'Tipe');
        $sheet->setCellValue('C1', 'Model');
        $sheet->setCellValue('D1', 'Nopol');
        $sheet->setCellValue('E1', 'No. Rangka');
        $sheet->setCellValue('F1', 'No. Mesin');
        $sheet->setCellValue('G1', 'Warna');
        $sheet->setCellValue('H1', 'Ban');
        $sheet->setCellValue('I1', 'Tahun Produksi');
        $sheet->setCellValue('J1', 'Asuransi');
        $sheet->setCellValue('K1', 'Bapedal');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }


        $vn = $this->Trucks->find('all')->where([$condition])->toArray();
        $row = 2;
        foreach ($vn as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->merk);
            $sheet->setCellValue('B' . $row, $data->types);
            $sheet->setCellValue('C' . $row, $data->model);
            $sheet->setCellValue('D' . $row, $data->name);
            $sheet->setCellValue('E' . $row, $data->chassis_no);
            $sheet->setCellValue('F' . $row, $data->machine_no);
            $sheet->setCellValue('G' . $row, $data->color);
            $sheet->setCellValue('H' . $row, $data->tire);
            $sheet->setCellValue('I' . $row, $data->production_year);
            $sheet->setCellValue('J' . $row, $data->insurance);
            $sheet->setCellValue('K' . $row, $data->bapedal_registration);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Trucks - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
