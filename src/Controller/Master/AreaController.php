<?php
declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Area Controller
 *
 * @property \App\Model\Table\AreaTable $Area
 * @method \App\Model\Entity\Area[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AreaController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session

        $area = $this->Area->find('all');
        $code = $this->request->getQuery('filtercode');
        $name = $this->request->getQuery('filtername');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Area.code like'] = '%' . $code . '%';
        }
        if (!empty($name)) {
            $dataWhere['Area.name like'] = '%' . $name . '%';
        }

        $session->write(['condition' => $dataWhere]);

        $queries = (!empty($dataWhere)) ? $area->where([$dataWhere])->order(['Area.code' => 'ASC']) : $area->order(['Area.code' => 'ASC']);

        $this->set('area', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $area = $this->Area->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('area'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $area = $this->Area->newEmptyEntity();
        if ($this->request->is('post')) {
            $area = $this->Area->patchEntity($area, $this->request->getData());
            if ($this->Area->save($area)) {
                $this->Flash->success(__('The area has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The area could not be saved. Please, try again.'));
        }
        $this->set(compact('area'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $area = $this->Area->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $area = $this->Area->patchEntity($area, $this->request->getData());
            if ($this->Area->save($area)) {
                $this->Flash->success(__('The area has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The area could not be saved. Please, try again.'));
        }
        $this->set(compact('area'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $area = $this->Area->get($id);
        if ($this->Area->delete($area)) {
            $this->Flash->success(__('The area has been deleted.'));
        } else {
            $this->Flash->error(__('The area could not be deleted. Please, try again.'));
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
        $sheet->setCellValue('A1', 'Kode Daerah');
        $sheet->setCellValue('B1', 'Nama Daerah');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $report = $this->Area->find('all')->where([$condition])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->code);
            $sheet->setCellValue('B' . $row, $data->name);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Areas - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }

    public function dataExportImport($condition = null)
    {
        $this->autoRender = false;

        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($condition == "save") {
                $maxFile = 502400; // Max 500 KB
                $files = $this->request->getUploadedFiles();

                if (!empty($files['filename'])) {
                    $uploadedFile = $files['filename'];
                    $fileNameUpload = $uploadedFile->getClientFilename();
                    $fileSize = $uploadedFile->getSize();
                    $mimeType = $uploadedFile->getClientMediaType();

                    // Validasi MIME type file Excel
                    $allowedMimeTypes = [
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    ];
                    if (!in_array($mimeType, $allowedMimeTypes)) {
                        $this->Flash->error(__('Format file tidak diperbolehkan.'));
                        return $this->redirect(['action' => 'index']);
                    }

                    // Cek ukuran file
                    if ($fileSize > $maxFile) {
                        $this->Flash->error(__('Ukuran file melebihi batas maksimum.'));
                        return $this->redirect(['action' => 'index']);
                    }

                    // Siapkan nama dan path penyimpanan
                    $extension = strtolower(pathinfo($fileNameUpload, PATHINFO_EXTENSION));
                    $newName = time() . '_' . $fileNameUpload;
                    $uploadPath = 'upload/imports/' . $newName;
                    $fullPath = WWW_ROOT . $uploadPath;

                    // Pindahkan file
                    $uploadedFile->moveTo($fullPath);

                    // Pilih reader sesuai ekstensi
                    if ($extension === 'xls') {
                        $reader = new Xls();
                    } elseif ($extension === 'xlsx') {
                        $reader = new Xlsx();
                    } else {
                        $this->Flash->error(__('Ekstensi file tidak didukung.'));
                        return $this->redirect(['action' => 'index']);
                    }

                    // Load spreadsheet
                    $spreadsheet = $reader->load($fullPath);
                    $rows = $spreadsheet->getActiveSheet()->toArray();

                    if (count($rows) <= 1) {
                        $this->Flash->error(__('Data tidak ditemukan di file.'));
                        return $this->redirect(['action' => 'index']);
                    }

                    // Hapus header
                    array_shift($rows);

                    $areaTable = TableRegistry::getTableLocator()->get('Area');
                    foreach ($rows as $row) {
                        if (count($row)) {
                            $xlsCode = (empty($row[0])) ? null : intval($row[0]);
                            $xlsName = empty($row[1]) ? null : trim($row[1]);

                            if ($xlsCode !== null) {
                                $existing = $areaTable->find()
                                    ->where(['code' => $xlsCode])
                                    ->first();

                                if ($existing) {
                                    // Update data jika ada
                                    $areaTable->updateAll(
                                        ['name' => $xlsName],
                                        ['code' => $xlsCode]
                                    );
                                } else {
                                    // Insert data jika belum ada
                                    $entity = $areaTable->newEntity([
                                        'code' => $xlsCode,
                                        'name' => $xlsName
                                    ]);
                                    $areaTable->save($entity);
                                }
                            }
                        }
                    }

                    $this->Flash->success(__('Terimakasih, data berhasil disimpan.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('Tidak ada file yang diupload.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }
}
