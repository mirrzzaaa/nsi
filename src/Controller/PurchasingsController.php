<?php

declare(strict_types=1);

namespace App\Controller;

// export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Purchasings Controller
 *
 * @property \App\Model\Table\PurchasingsTable $Purchasings
 * @method \App\Model\Entity\Purchasing[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchasingsController extends AppController
{ 
    /**
     * Index method
     * 
     * @return \Cake\Http\Response|null|void Renders view
     */ 
    public function index()
    {
        $session = $this->getRequest()->getSession(); //get session
        $purchasings = $this->Purchasings->find('all')->contain(['Suppliers', 'Warehouses']);

        $code = $this->request->getQuery('filtercode');
        $warehouse = $this->request->getQuery('filterwarehouse');
        $supplier = $this->request->getQuery('filtersupplier');

        $start = $this->request->getQuery('filterstart'); 
        $end = $this->request->getQuery('filterend'); 

        $status = $this->request->getQuery('filterstatus');

        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Purchasings.number like'] = '%' . $code . '%';
        } 
        if (!empty($warehouse)) {
            $dataWhere['Warehouses.name like'] = '%' . $warehouse . '%';
        }
        if (!empty($supplier)) {
            $dataWhere['Suppliers.name like'] = '%' . $supplier . '%';
        }

        if (!empty($start) && !empty($end)) {
            $dataWhere[] = 'DATE(Purchasings.date) BETWEEN "' . $this->Krs->dateTo($start) . '" AND "' . $this->Krs->dateTo($end) . '"';
        }
        if (!empty($status)) {
            $dataWhere['Purchasings.status_wait'] = $status;
        }

        $session->write(['condition' => $dataWhere]);
        $queries = (!empty($dataWhere)) ? $purchasings->where([$dataWhere])->order(['Purchasings.id' => 'Desc']) : $purchasings->order(['Purchasings.id' => 'DESC']);

        $this->set('purchasings', $this->paginate($queries, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Purchasing id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $purchasing = $this->Purchasings->get($id, [
            'contain' => ['Suppliers', 'Warehouses', 'PurchasingLines.Items', 'InvoiceEntries'],
        ]);

        $this->set(compact('purchasing'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function get_last_number()
    {
        $dataRows = $this->Purchasings->find('all', [
            'fields' => array('code' => 'MAX(Purchasings.number)'),
        ])->first();

        $code = (!empty($dataRows->code) ? explode("/", $dataRows['code']) : array());
        $dataResult = (isset($code[0]) ? ((date('d-m') != '01-01') ? ($code[0] + 1) : 1 ) : 1);
        $result = str_pad(strval($dataResult), 4, "0", STR_PAD_LEFT);
        $number = $result . '/PO/NSI/' . $this->Krs->numToRome(date('m')) . '/' . date('Y');
        return $number;
    }

    public function add()
    {
        $purchasing = $this->Purchasings->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('date' => $this->Krs->dateTo($dataRow['date']));
            $grandtotal = array('grandtotal' => $dataRow['grandtotal']);
            $ppn = array('ppn' => $dataRow['ppns']);
            $discount = array('discount' => $this->Krs->nom2Dec($dataRow['discounts']));
            $ship_payment = array('ship_payment' => $this->Krs->nom2Dec($dataRow['ship_payments']));
            $with_price = !empty($dataRow['with_price']) ? 'N' : 'Y';

            $po_lines = array();
            foreach ($dataRow['purchasing_lines'] as $index => $value) {
                $po_lines['purchasing_lines'][$index]['item_id'] = $value['item_id'];
                $po_lines['purchasing_lines'][$index]['quantity'] = $value['quantity'];
                $po_lines['purchasing_lines'][$index]['quantity_in'] = $value['quantity'];
                $po_lines['purchasing_lines'][$index]['price'] = $this->Krs->nom2Dec($value['price']);
                $po_lines['purchasing_lines'][$index]['discount'] = $value['discount'];
                $po_lines['purchasing_lines'][$index]['subtotal'] = $this->Krs->nom2Dec($value['subtotal']); 
            }
            $purchasing = $this->Purchasings->patchEntity($purchasing, array_merge($dataRow, $dataAuditLog, $date, $grandtotal, $ppn, $discount, $ship_payment, $po_lines, ['with_price' => $with_price]));

            // pr($dataRow);
 
            if ($this->Purchasings->save($purchasing)) {
                $this->Flash->success(__('The purchasing has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchasing could not be saved. Please, try again.'));
        }

        $warehouses = $this->Purchasings->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $suppliers = $this->Purchasings->Suppliers->find('list', [
            'keyField' => 'id', 
            'valueField' => function ($row) {
                return $row->name . ' (' . $row->address . ')';
            }
        ])->toArray();
        $data['lastNumber'] = $this->get_last_number();
        $this->set(compact('purchasing', 'warehouses', 'suppliers', 'data'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchasing id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $purchasing = $this->Purchasings->get($id, [
            'contain' => ['PurchasingLines.Items', 'Suppliers'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "Edit");
            $dataAuditLog = ['is_log' => $auditLog];
            $date = ['date' => $this->Krs->dateTo($dataRow['date'])];
            $grandtotal = ['grandtotal' => $dataRow['grandtotal']];
            $ppn = ['ppn' => $dataRow['ppns']];
            $discount = ['discount' => $this->Krs->nom2Dec($dataRow['discounts'])];
            $ship_payment = ['ship_payment' => $this->Krs->nom2Dec($dataRow['ship_payments'])];
            $with_price = !empty($dataRow['with_price']) ? 'N' : 'Y';

            $po_lines = [];
            $existingLineIds = []; // Untuk melacak ID yang ada di array baru

            if (!empty($dataRow['purchasing_lines'])) {
                foreach ($dataRow['purchasing_lines'] as $index => $line) {
                    if (empty($line['id'])) {
                        // Tambahkan data baru
                        $po_lines['purchasing_lines'][$index] = [
                            'item_id' => $line['item_id'],
                            'quantity' => $line['quantity'],
                            'discount' => $line['discount'],
                            'price' => $this->Krs->nom2Dec($line['price']),
                            'subtotal' => $this->Krs->nom2Dec($line['subtotal']),
                        ];
                    } else {
                        // Perbarui data yang ada
                        $po_lines['purchasing_lines'][$index] = [
                            'id' => $line['id'],
                            'item_id' => $line['item_id'],
                            'quantity' => $line['quantity'],
                            'discount' => $line['discount'],
                            'price' => $this->Krs->nom2Dec($line['price']),
                            'subtotal' => $this->Krs->nom2Dec($line['subtotal']),
                        ];
                        $existingLineIds[] = $line['id'];
                    }
                }
            }

            // Hapus purchasing lines yang tidak ada di array baru
            $this->loadModel('PurchasingLines');
            $this->PurchasingLines->deleteAll([
                'purchasing_id' => $id,
                'id NOT IN' => $existingLineIds,
            ]);

            // Update data utama purchasing
            $purchasing = $this->Purchasings->patchEntity(
                $purchasing,
                array_merge($dataRow, $dataAuditLog, $date, $grandtotal, $ppn, $discount, $ship_payment, $po_lines, ['with_price' => $with_price])
            );

            if ($this->Purchasings->save($purchasing)) {
                $this->Flash->success(__('The purchasing has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The purchasing could not be saved. Please, try again.'));
        }

        $this->loadModel('Items');
        $items = $this->Items->find('all')->where(['Items.supplier_id' => $purchasing->supplier_id]);
        $warehouses = $this->Purchasings->Warehouses->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

        $this->set(compact('purchasing', 'warehouses', 'items'));
    }

    public function approve($id = null)
    {
        $purchasing = $this->Purchasings->get($id, [
            'contain' => ['PurchasingLines.Items', 'Suppliers', 'Warehouses'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {  


            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_approve'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Approve");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('status_date' => date('Y-m-d'));
            $status = array('status_wait' => 'Yes');

            $purchasing = $this->Purchasings->patchEntity($purchasing, array_merge($dataRow, $dataAuditLog, $date, $status));
            if ($this->Purchasings->save($purchasing)) {
                $this->Flash->success(__('The purchasing has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchasing could not be saved. Please, try again.'));
        }
        $this->set(compact('purchasing'));
    }

    public function cancel($id = null)
    {
        $purchasing = $this->Purchasings->get($id, [
            'contain' => ['PurchasingLines.Items', 'Suppliers', 'Warehouses'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {


            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_cancel'];
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Cancel");
            $dataAuditLog = array('is_log' => $auditLog);
            $date = array('status_date' => date('Y-m-d'));
            $status = array('status_wait' => 'Cancel');

            $purchasing = $this->Purchasings->patchEntity($purchasing, array_merge($dataRow, $dataAuditLog, $date, $status));
            if ($this->Purchasings->save($purchasing)) {
                $this->Flash->success(__('The purchasing has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchasing could not be saved. Please, try again.'));
        }
        $this->set(compact('purchasing'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Purchasing id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchasing = $this->Purchasings->get($id);
        if ($this->Purchasings->delete($purchasing)) {
            $this->Flash->success(__('The purchasing has been deleted.'));
        } else {
            $this->Flash->error(__('The purchasing could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getitem()
    {
        $this->autoRender = false;
        $this->loadModel('WarehouseStocks');

        $idw = $this->request->getQuery('idw'); // Warehouse ID
        $idSupplier = $this->request->getQuery('id'); // Supplier ID yang dicari

        $items = $this->WarehouseStocks->find()
            ->contain(['Items'])
            ->where([
                'WarehouseStocks.warehouse_id' => $idw,
                "FIND_IN_SET('$idSupplier', Items.supplier_id) > 0"
            ]);

        $itemList = [];
        foreach ($items as $index => $value) {
            $itemList[$index]['id'] = $value->item->id;
            $itemList[$index]['text'] = $value->item->name;
        }

        return $this->response->withType("application/json")->withStringBody(json_encode($itemList));
    }

    public function setitem()
    {
        $this->autoRender = false;
        $this->loadModel('WarehouseStocks');

        $item = $this->WarehouseStocks->find('all')->contain(['Items'])->where(['WarehouseStocks.item_id' => $this->request->getQuery('id')])->first();

        return $this->response->withType("application/json")->withStringBody(json_encode($item));
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
        $sheet->setCellValue('A1', 'No. Purchase Order');
        $sheet->setCellValue('B1', 'Gudang Penempatan');
        $sheet->setCellValue('C1', 'Supplier');
        $sheet->setCellValue('D1', 'Tanggal Buat');
        $sheet->setCellValue('E1', 'Deskripsi Barang');
        $sheet->setCellValue('F1', 'Qty');
        $sheet->setCellValue('G1', 'Price');
        $sheet->setCellValue('H1', 'Discount');
        $sheet->setCellValue('I1', 'Subtotal');
        $sheet->setCellValue('J1', 'Total');
        $sheet->setCellValue('K1', 'PPN');
        $sheet->setCellValue('L1', 'Nominal');
        $sheet->setCellValue('M1', 'Status');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $report = $this->Purchasings->find('all')->contain(['Suppliers', 'Warehouses', 'PurchasingLines.Items'])->where([$condition])->toArray();

        $prevPurchaseId = null;
        $mergeStartRow = 2;
        $row = 2;
        foreach ($report as $index => $data) {
            $ppn = $data->ppn;
            $grandTotal = $data->grandtotal;
            $total = $grandTotal / 1.11;
            $dataPpn = ($ppn > 0) ? ($total * 11) / 100 : 0;
            $status = $this->Krs->statusWait($data->status_wait);

            // Cek apakah invoice_id sama dengan sebelumnya
            if ($prevPurchaseId === $data->id) {
                // Jika sama, hanya isi kolom Item, Quantity, Price, Discount, dan Subtotal
                $mergeEndRow = $row;
            } else {
                // Jika tidak sama, merge kolom sebelumnya jika ada
                if ($mergeStartRow < $row - 1) {
                    $sheet->mergeCells("A{$mergeStartRow}:A" . ($row - 1)); // No. PO
                    $sheet->mergeCells("B{$mergeStartRow}:B" . ($row - 1)); // Gudang Penempatan
                    $sheet->mergeCells("C{$mergeStartRow}:C" . ($row - 1)); // Supplier
                    $sheet->mergeCells("D{$mergeStartRow}:D" . ($row - 1)); // Tanggal Buat
                    $sheet->mergeCells("J{$mergeStartRow}:J" . ($row - 1)); // Total
                    $sheet->mergeCells("K{$mergeStartRow}:K" . ($row - 1)); // PPN
                    $sheet->mergeCells("L{$mergeStartRow}:L" . ($row - 1)); // Nominal
                    $sheet->mergeCells("M{$mergeStartRow}:M" . ($row - 1)); // Status
                }
                $mergeStartRow = $row; // Set awal merge baru

                // Isi kolom utama
                $sheet->setCellValue('A' . $row, $data->number);
                $sheet->setCellValue('B' . $row, (($data->warehouse_id > 0) ? ((!empty($data->warehouse)) ? $data->warehouse->name : '-') : '-'));
                $sheet->setCellValue('C' . $row, (($data->supplier_id > 0) ? ((!empty($data->supplier)) ? $data->supplier->name : '-') : '-'));
                $sheet->setCellValue('D' . $row, $this->Krs->fDate($data->date, 'd-m-Y'));

                if ($data->with_price == 'Y') {
                    $sheet->setCellValueExplicit('J' . $row, $this->Krs->_currency($total), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit('K' . $row, $this->Krs->_currency($dataPpn), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit('L' . $row, $this->Krs->_currency($data->grandtotal), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                } else {
                    $sheet->setCellValue('J' . $row, '');
                    $sheet->setCellValue('K' . $row, '');
                    $sheet->setCellValue('L' . $row, 'Tanpa Harga');
                }

                $sheet->setCellValue('M' . $row, $status);

                // Loop untuk menampilkan detail item
                foreach ($data->purchasing_lines as $purchasingLines) {
                    $itemName = $purchasingLines->item->name ?? '-';
                    $quantity = $purchasingLines->quantity ?? 0;
                    $price = $purchasingLines->price ?? 0;
                    $disc = $purchasingLines->discount ?? 0;
                    $discount = ($price * $disc) / 100;
                    $subtotal = $purchasingLines->subtotal ?? 0;

                    $sheet->setCellValue('E' . $row, $itemName);
                    $sheet->setCellValue('F' . $row, $quantity);

                    if ($data->with_price == 'Y') {
                        $sheet->setCellValueExplicit('G' . $row, $this->Krs->_currency($price), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $sheet->setCellValueExplicit('H' . $row, $this->Krs->_currency($discount), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $sheet->setCellValueExplicit('I' . $row, $this->Krs->_currency($subtotal), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    } else {
                        $sheet->setCellValue('G' . $row, '');
                        $sheet->setCellValue('H' . $row, '');
                        $sheet->setCellValue('I' . $row, '');
                    }

                    $row++;
                }

                $prevPurchaseId = $data->id;
            }

            // Merge terakhir jika masih ada yang belum di-merge
            if ($mergeStartRow < $row - 1) {
                $sheet->mergeCells("A{$mergeStartRow}:A" . ($row - 1));
                $sheet->mergeCells("B{$mergeStartRow}:B" . ($row - 1));
                $sheet->mergeCells("C{$mergeStartRow}:C" . ($row - 1));
                $sheet->mergeCells("D{$mergeStartRow}:D" . ($row - 1));
                $sheet->mergeCells("J{$mergeStartRow}:J" . ($row - 1));
                $sheet->mergeCells("K{$mergeStartRow}:K" . ($row - 1));
                $sheet->mergeCells("L{$mergeStartRow}:L" . ($row - 1));
                $sheet->mergeCells("M{$mergeStartRow}:M" . ($row - 1));
            }
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Purchase Order - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }

    public function print($id = null) 
    {
        $purchasings = $this->Purchasings->get($id, [
            'contain' => ['PurchasingLines.Items', 'Suppliers', 'Warehouses'], 
        ]);

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption('pdfConfig', [
            [
                'orientation' => 'landscape',
                'download' => true,
                'filename' => 'purchase order.pdf'
            ] 
        ]);

        $purchasingTable = $this->getTableLocator()->get('Purchasings');
        $purchasing = $purchasingTable->get($id);

        $purchasingTable->save($purchasing);

        $this->set(array('report' => $purchasings));
    }

    public function printEnglish($id = null) 
    {
        $purchasings = $this->Purchasings->get($id, [
            'contain' => ['PurchasingLines.Items', 'Suppliers', 'Warehouses'], 
        ]);

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption('pdfConfig', [
            [
                'orientation' => 'landscape',
                'download' => true,
                'filename' => 'purchase order.pdf'
            ]
        ]);

        $purchasingTable = $this->getTableLocator()->get('Purchasings');
        $purchasing = $purchasingTable->get($id);

        $purchasingTable->save($purchasing);

        $this->set(array('report' => $purchasings));
    }
}
