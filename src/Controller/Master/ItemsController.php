<?php

declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

 
// export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
  
/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{ 
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $items = $this->Items->find('all')->contain(['Categories', 'Suppliers', 'Warehouses']);

        $code = $this->request->getQuery('filtercode');
        $name = $this->request->getQuery('filtername');
        $start = $this->request->getQuery('filterstart');
        $end = $this->request->getQuery('filterend');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Items.code_internal like'] = '%' . $code . '%';
        }
        if (!empty($name)) {
            $dataWhere['Items.name like'] = '%' . $name . '%';
        } 
        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(Items.expired_date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $items->where([$dataWhere])->order(['Items.code' => 'DESC']) : $items->order(['Items.code' => 'DESC']);

        $this->set('items', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Categories', 'Warehouses'], // Tidak pakai Suppliers karena supplier_id dalam bentuk string
        ]);

        // Jika supplier_id dalam bentuk "11,12", ubah jadi array [11, 12]
        $supplierIds = !empty($item->supplier_id) ? explode(',', $item->supplier_id) : [];

        // Ambil model Suppliers secara manual
        $suppliersTable = $this->getTableLocator()->get('Suppliers');

        // Query untuk mendapatkan daftar supplier
        $suppliers = $suppliersTable->find()
            ->where(['id IN' => $supplierIds])
            ->all()
            ->toArray();

        $this->set(compact('item', 'suppliers')); // Kirim ke View
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function get_last_number()
    {
        $dataRows = $this->Items->find('all', [
            'fields' => array('codes' => 'MAX(CAST(Items.code AS UNSIGNED))+1'),
        ]);
        $dataRows = $dataRows->first();
        $dataResult = isset($dataRows->codes) ? $dataRows->codes : 1;
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        return $result;
    }

    public function add()
    {
        $item = $this->Items->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataSupplierId = (!empty($dataRow['supplierId'])) ? ['supplier_id' => implode(",", $dataRow['supplierId'])] :[];
            $dataAuditLog = ['is_log' => $auditLog];
            $code = ['code' => $this->get_last_number()];
            $hargaJual = ['selling_price' => $this->Krs->nom2Dec($dataRow['selling_prices'])];
            $hargaBeli = ['buying_price' => $this->Krs->nom2Dec($dataRow['buying_prices'])];
            $stock = ['stock' => $this->Krs->nom2Dec($dataRow['stocks'])];
            $expiredDate = ['expired_date' => $this->Krs->dateTo($dataRow['dates'])];
            $kodeInternal = ['code_internal' => $dataRow['code_internal']];
            $izinEdar = ['izin_edar' => $dataRow['izin_edar']];
            
            $item = $this->Items->patchEntity($item, array_merge($dataAuditLog, $dataSupplierId, $code, $hargaJual, $hargaBeli, $stock, $expiredDate, $kodeInternal, $izinEdar, $dataRow));

            // pr($item);

            if ($this->Items->save($item)) {
                // Ambil ID item yang baru disimpan
                $itemId = $item->id;

                // Simpan data ke tabel warehouse_stocks
                $warehouseStocksTable = $this->getTableLocator()->get('WarehouseStocks');
                $warehouseStockData = [
                    'item_id' => $itemId,
                    'warehouse_id' => $dataRow['warehouse_id'],
                    'code' => $dataRow['code_internal'],
                    'buy' => $this->Krs->nom2Dec($dataRow['buying_prices']),
                    'sell' => $this->Krs->nom2Dec($dataRow['selling_prices']),
                    'stock' => $this->Krs->nom2Dec($dataRow['stocks']),
                    'unit' => $dataRow['unit'],
                    'izin_edar' => $dataRow['izin_edar'],
                    'type' => $dataRow['type'],
                    'ukuran' => $dataRow['ukuran'],
                    'date' => date('Y-m-d'),
                    'expired_date' => $this->Krs->dateTo($dataRow['dates']),
                    'is_log' => $auditLog,
                ];
                $warehouseStock = $warehouseStocksTable->newEntity($warehouseStockData);

                if ($warehouseStocksTable->save($warehouseStock)) {
                    $this->Flash->success(__('The item and warehouse stock have been saved.'));
                } else {
                    $this->Flash->error(__('The warehouse stock could not be saved. Please, try again.'));
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }

        // Ambil daftar kategori dan gudang
        $categories = $this->Items->Categories->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $warehouses = $this->Items->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

        // Ambil daftar supplier
        $suppliersTable = $this->getTableLocator()->get('Suppliers');
        $supplierList = $suppliersTable->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

        $data['lastNumber'] = $this->get_last_number();
        
        $this->set(compact('item', 'categories', 'data', 'warehouses', 'supplierList'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function edit($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Warehouses'], 
        ]); 
        
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "Edit");
            $dataAuditLog = ['is_log' => $auditLog];
            $dataSupplierId = (!empty($dataRow['supplierId'])) ? ['supplier_id' => implode(",", $dataRow['supplierId'])] :[];
            $hargaJual = ['selling_price' => $this->Krs->nom2Dec($dataRow['selling_prices'])];
            $hargaBeli = ['buying_price' => $this->Krs->nom2Dec($dataRow['buying_prices'])];
            $stock = ['stock' => $this->Krs->nom2Dec($dataRow['stocks'])];
            $expiredDate = array('expired_date' => $this->Krs->dateTo($dataRow['dates']));
            $kodeInternal = array('code_internal' => $dataRow['code_internal']);
            $izinEdar = ['izin_edar' => $dataRow['izin_edar']];

            $item = $this->Items->patchEntity($item, array_merge($dataAuditLog, $dataSupplierId, $hargaJual, $hargaBeli, $stock, $expiredDate, $kodeInternal, $izinEdar, $dataRow));

            if ($this->Items->save($item)) {
                // Data item berhasil disimpan, lanjutkan ke warehouse_stocks
                $warehouseStocksTable = $this->getTableLocator()->get('WarehouseStocks');
                $existingStock = $warehouseStocksTable->find()
                    ->where(['item_id' => $id])
                    ->first();

                $warehouseStockData = [
                    'item_id' => $id,
                    'warehouse_id' => $dataRow['warehouse_id'],
                    'code' => $dataRow['code_internal'],
                    'buy' => $this->Krs->nom2Dec($dataRow['buying_prices']),
                    'sell' => $this->Krs->nom2Dec($dataRow['selling_prices']),
                    'stock' => $this->Krs->nom2Dec($dataRow['stocks']),
                    'unit' => $dataRow['unit'],
                    'izin_edar' => $dataRow['izin_edar'],
                    'type' => $dataRow['type'],
                    'ukuran' => $dataRow['ukuran'],
                    'date' => date('Y-m-d'),
                    'expired_date' => $this->Krs->dateTo($dataRow['dates']),
                    'is_log' => $auditLog,
                ];

                if ($existingStock) {
                    // Update data warehouse_stocks
                    $warehouseStock = $warehouseStocksTable->patchEntity($existingStock, $warehouseStockData);
                } else {
                    // Insert data baru ke warehouse_stocks
                    $warehouseStock = $warehouseStocksTable->newEntity($warehouseStockData);
                }

                if ($warehouseStocksTable->save($warehouseStock)) {
                    $this->Flash->success(__('The item and warehouse stock have been saved.'));
                } else {
                    $this->Flash->error(__('The item was saved but warehouse stock could not be updated. Please try again.'));
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }

        $categories = $this->Items->Categories->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $branches = $this->Items->Branches->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $warehouses = $this->Items->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

        // Ambil daftar supplier
        $suppliersTable = $this->getTableLocator()->get('Suppliers');
        $supplierList = $suppliersTable->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

        $this->set(compact('item', 'categories', 'branches', 'warehouses', 'supplierList'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
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
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Kode');
        $sheet->setCellValue('C1', 'Barcode');
        $sheet->setCellValue('D1', 'Kode Internal');
        $sheet->setCellValue('E1', 'Kategori');
        $sheet->setCellValue('F1', 'Nama Barang');
        $sheet->setCellValue('G1', 'Jumlah Stok');
        $sheet->setCellValue('H1', 'Satuan');
        $sheet->setCellValue('I1', 'Tgl. Expired');
        $sheet->setCellValue('J1', 'Harga Beli');
        $sheet->setCellValue('K1', 'Harga Jual');
        $sheet->setCellValue('L1', 'Supplier');
        $sheet->setCellValue('M1', 'Keterangan');
        $sheet->setCellValue('N1', 'Penempatan');


        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $report = $this->Items->find('all')->contain(['Categories', 'Suppliers', 'Warehouses'])->where([$condition])->toArray();
        $suppliersTable = $this->getTableLocator()->get('Suppliers');
        $supplierList = $suppliersTable->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $selectedSuppliers = !empty($data->supplier_id) ? explode(",", $data->supplier_id) : [];
            $supplierNames = [];
            foreach ($selectedSuppliers as $supplierId) {
                if (isset($supplierList[$supplierId])) {
                    $supplierNames[] = $supplierList[$supplierId];
                }
            }

            $sheet->setCellValue('A' . $row, (!empty($data->id) ? $data->id : ''));
            $sheet->setCellValue('B' . $row, (!empty($data->code) ? $data->code : ''));
            $sheet->setCellValue('C' . $row, (!empty($data->barcode) ? $data->barcode : ''));
            $sheet->setCellValue('D' . $row, (!empty($data->code_internal) ? $data->code_internal : ''));
            $sheet->setCellValue('E' . $row, (($data->category_id > 0) ? ((!empty($data->category)) ? $data->category->name : '') : ''));
            $sheet->setCellValue('F' . $row, (!empty($data->name) ? $data->name : ''));
            $sheet->setCellValue('G' . $row, (!empty($data->stock) ? $this->Krs->_currency($data->stock) : ''));
            $sheet->setCellValue('H' . $row, (!empty($data->unit) ? $data->unit : ''));
            $sheet->setCellValue('I' . $row, ($data->expired_date != null) ? $this->Krs->fDate($data->expired_date, 'd-m-Y') : '');
            $sheet->setCellValue('J' . $row, (!empty($data->buying_price) ? $this->Krs->nom($data->buying_price) : ''));
            $sheet->setCellValue('K' . $row, (!empty($data->selling_price) ? $this->Krs->nom($data->selling_price) : ''));
            $sheet->setCellValue('L' . $row, implode(", ", $supplierNames));
            $sheet->setCellValue('M' . $row, (!empty($data->description) ? $data->description : ''));
            $sheet->setCellValue('N' . $row, (($data->warehouse_id > 0) ? ((!empty($data->warehouse)) ? $data->warehouse->name : '') : ''));

            $sheet->getStyle('A' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('D5D5D5');
            $sheet->getStyle('B' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('D5D5D5');
            $sheet->getStyle('E' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('D5D5D5');
            $sheet->getStyle('L' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('D5D5D5');
            $sheet->getStyle('N' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('D5D5D5');

            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Product - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }

    public function template()
    {
        $session = $this->getRequest()->getSession(); //get session
        $condition = $session->read('condition');
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'Kode');
        $sheet->setCellValue('B1', 'Nama Barang');
        $sheet->setCellValue('C1', 'Nomor Izin Edar');
        $sheet->setCellValue('D1', 'Tipe');
        $sheet->setCellValue('E1', 'Ukuran');
        $sheet->setCellValue('F1', 'Kemasan');
        $sheet->setCellValue('G1', 'Stok');


        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $report = $this->Items->find('all')->contain(['Categories', 'Suppliers', 'Warehouses'])->where([$condition])->toArray();
        $suppliersTable = $this->getTableLocator()->get('Suppliers');
        $supplierList = $suppliersTable->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $selectedSuppliers = !empty($data->supplier_id) ? explode(",", $data->supplier_id) : [];
            $supplierNames = [];
            foreach ($selectedSuppliers as $supplierId) {
                if (isset($supplierList[$supplierId])) {
                    $supplierNames[] = $supplierList[$supplierId];
                }
            }

            $sheet->setCellValue('A' . $row, (!empty($data->code) ? $data->code : ''));
            $sheet->setCellValue('B' . $row, (!empty($data->name) ? $data->name : ''));
            $sheet->setCellValue('C' . $row, (!empty($data->izin_edar) ? $data->izin_edar : ''));
            $sheet->setCellValue('D' . $row, (!empty($data->type) ? $data->type : ''));
            $sheet->setCellValue('E' . $row, (!empty($data->ukuran) ? $data->ukuran : ''));
            $sheet->setCellValue('F' . $row, (!empty($data->unit) ? $data->unit : ''));
            $sheet->setCellValue('G' . $row, (!empty($data->stock) ? $data->stock : ''));

            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Template Farmalkes - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }

    function convertToFloat($value) 
    {
        // Menghapus titik (.) yang digunakan sebagai pemisah ribuan
        $value = str_replace('.', '', $value);
        // Mengganti koma (,) dengan titik (.) sebagai pemisah desimal
        $value = str_replace(',', '.', $value);
        
        // Mengonversi string ke tipe float
        return floatval($value);
    }

    public function dataExportImport($condition = null)
    {
        $this->autoRender = false;
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Authentication->getIdentity();

            if ($condition == "save") {
                $maxFile = 502400; // Ukuran maksimum file

                $dataRow = $this->request->getData();
                $isUser = $dataRow['user_id'];

                $files = $this->request->getUploadedFiles();
                $fileNameUpload = $files['filename']->getClientFileName();

                if (!empty($fileNameUpload)) {
                    $files['filename']->getStream();
                    $sizeFile = $files['filename']->getSize();
                    
                    if ($maxFile >= $sizeFile) {
                        // Ambil nama dan ekstensi file
                        $myname = $this->request->getData()['filename']->getClientFileName();
                        $myext = substr(strchr($myname, "."), 1);
                        $mypath = "upload/imports/" . $myname; // Path untuk menaruh file yang diupload

                        // Pindahkan file upload ke path yang ditentukan
                        $files['filename']->moveTo(WWW_ROOT . $mypath);

                        // Memilih reader berdasarkan ekstensi file
                        if ($myext == 'xls') {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                        } elseif ($myext == 'xlsx') { 
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        }

                        // Membaca file yang diupload
                        $spreadsheet = $reader->load(WWW_ROOT . $mypath);
                        $sheets = $spreadsheet->getActiveSheet()->toArray();

                        // Menghapus header dari data
                        $sheet = array_splice($sheets, 1);
                        $dataItems = array();

                        foreach ($sheet as $keys => $row) {
                            // Mendapatkan data dari tiap baris Excel
                            $xlsId = intval($row[0]); 
                            $xlsCode = ($row[1] == 0 || empty($row[1])) ? null : $row[1];
                            $xlsBarcode = (empty($row[2])) ? null : $row[2];
                            $xlsCodeInternal = (empty($row[3])) ? null : $row[3];
                            $xlsCategory = (empty($row[4])) ? null : intval($row[4]);
                            $xlsName = (empty($row[5])) ? null : $row[5];
                            $xlsStock = ($row[6] == 0 || empty($row[6])) ? 0 : intval($row[6]);
                            $xlsUnit = (empty($row[7])) ? null : $row[7];
                            $xlsExpiredDate = (empty($row[8])) ? null : $row[8];
                            if (!empty($xlsExpiredDate)) {
                                $xlsExpiredDate = date('Y-m-d', strtotime($xlsExpiredDate));
                            }
                            $xlsBuyPrice = ($row[9] == 0 || empty($row[9])) ? null : $this->convertToFloat($row[9]);
                            $xlsSellPrice = ($row[10] == 0 || empty($row[10])) ? null : $this->convertToFloat($row[10]);
                            $xlsSupplier = (empty($row[11])) ? null : intval($row[11]);
                            $xlsDescription = (empty($row[12])) ? null : $row[12];
                            $xlsWarehouse = (empty($row[13])) ? null : intval($row[13]); 
                            $xlsDate = date('Y-m-d');
                            $isUser = $user->getIdentifier();

                            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $xlsId,  $isUser, "edit from upload excel"); 

                            $this->Items->updateAll([
                                'id' => $xlsId,
                                'code' => $xlsCode,
                                'barcode' => $xlsBarcode,
                                'code_internal' => $xlsCodeInternal,
                                'name' => $xlsName,
                                'stock' => $xlsStock,
                                'unit' => $xlsUnit,
                                'expired_date' => $xlsExpiredDate,
                                'buying_price' => $xlsBuyPrice,
                                'selling_price' => $xlsSellPrice,
                                'description' => $xlsDescription,
                                'is_create' => $isUser,
                                'is_log' => $auditLog
                            ], 
                            ['id' => $xlsId]
                            );

                        }
                        $this->Flash->success(__('Terimakasih, Data berhasil disimpan.'));
                        return $this->redirect(['action' => 'index']);
                    }
                } else {
                    $this->Flash->error(__('Maaf, Data gagal disimpan, silakan coba kembali.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }
} 
