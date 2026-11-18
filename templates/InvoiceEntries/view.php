<?php
ini_set('precision', 14);
//pr($invoiceEntry);

$subtotals = array();
    foreach ($invoiceEntry->purchasing->purchasing_lines as $index => $value) {
        $subtotals[$index] = is_numeric($value->subtotal) ? $value->subtotal : 0;
    }
    $subtotalSum = array_sum($subtotals);
    $ppn = (is_numeric($invoiceEntry->ppn) && $invoiceEntry->ppn > 0) ? ((11 * $subtotalSum) / 100) : 0;
    //pr($ppn);
$purchasings = $invoiceEntry->purchasing; 

?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">No : <?php echo $invoiceEntry->code ?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <a href="<?= $this->Url->build(['action' => 'print', $invoiceEntry->id]); ?>" class="btn btn-success"><i class="fas fa-print"></i> &nbsp;Cetak</a>
            <h2 class="text-center mb-3"><strong>INVOICE MASUK</strong></h2> <br>

            <div class="row m-b-15">
                <div class="col-2 col-sm-2 mb-1">
                    <b>No. Invoice Masuk</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo $invoiceEntry->code ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>Tgl. Invoice Masuk</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (($invoiceEntry->date != null) ? $this->Krs->fDate($invoiceEntry->date, 'd-m-Y') : '-') ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>Supplier</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (!empty($invoiceEntry->purchasing->supplier) ? $invoiceEntry->purchasing->supplier->name : '-') ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>Tgl. Jatuh Tempo</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (($invoiceEntry->due_date != null) ? $this->Krs->fDate($invoiceEntry->due_date, 'd-m-Y') : '-') ?></i></div>

            </div> <br>
            <p class="mb-3">Telah terima produk sebagai berikut :</p>
            <div class="table-responsive mb-3">
                <table class="table table-hover table-panel mb-0">
                    <thead>
                        <tr class="text-center">
                            <th width="50">No</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Diskon</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $subtotals = array();
                        foreach ($invoiceEntry->purchasing->purchasing_lines as $index => $rowOrder) {
                            $subtotals[$index] = $rowOrder->subtotal;
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td><?= (!empty($rowOrder->item) ? $rowOrder->item->name : '') ?></td>
                                <td class="text-end"><?= $this->Krs->_currency($rowOrder->price); ?></td>
                                <td class="text-center"><?= $this->Krs->_currency($rowOrder->quantity) . ' ' . (!empty($rowOrder->item) ? $rowOrder->item->unit : ''); ?></td>
                                <td class="text-center"><?= $this->Krs->_currency($rowOrder->discount); ?> %</td>
                                <td class="text-end"><?= $this->Krs->_currency($rowOrder->subtotal); ?></td>
                            </tr>
                        <?php
                            $no++;
                        }
                        // $ppn = $invoiceEntry->purchasing->ppn;
                        // $gTotal = $invoiceEntry->purchasing->grandtotal;
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="60%" class="table-info"><strong>Subtotal</strong></td>
                                <td width="40%" class="text-end"><?= $this->Krs->_currency(array_sum($subtotals)); ?></td>
                            </tr>
                            <tr>
                                <td width="60%" class="table-info"><strong>Biaya Pengiriman</strong></td>
                                <td width="40%" class="text-end"><?= $this->Krs->_currency($invoiceEntry->purchasing->ship_payment); ?></td>
                            </tr>
                            <tr>
                                <td width="60%" class="table-info"><strong>Diskon</strong></td>
                                <td width="40%" class="text-end"><?= $this->Krs->_currency($invoiceEntry->purchasing->discount); ?> %</td>
                            </tr>
                            <tr>
                                <td width="60%" class="table-info"><strong>PPn (12%)</strong></td>
                                <td width="40%" class="text-end"><?= $this->Krs->_currency($ppn); ?></td>
                            </tr>
                            <tr>
                                <td width="60%" class="table-info"><strong>Total</strong></td>
                                <td width="40%" class="text-end"><strong><?= $this->Krs->_currency($purchasings->grandtotal); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
        </div>
    </div>
</div>
