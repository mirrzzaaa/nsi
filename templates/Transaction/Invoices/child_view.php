<?php
ini_set('precision', 14);

// pr($invoice);

$subtotals = array();
    foreach ($invoice->order->order_lines as $index => $value) {
        $subtotals[$index] = is_numeric($value->subtotal) ? $value->subtotal : 0;
    }
    $subtotalSum = array_sum($subtotals);
    $ppn = (is_numeric($invoice->ppn) && $invoice->ppn > 0) ? ((11 * $subtotalSum) / 100) : 0;
    //pr($ppn);
    $orders = $invoice->order; 
    $orderLine = $orders->order_lines;
    // pr($orderLine);

?>

<style type="text/css">
    .payment-history-title {
        font-size: 16px; 
        font-weight: bold; 
        color: #2c3e50; 
        padding: 5px;
        border: 2px solid #2980b9; 
        border-radius: 5px; 
        background-color: #ecf0f1; 
        display: inline-block;
        text-align: center; 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        width: 230px;
        text-align: center;
    }

    /* Gaya umum untuk grup tombol */
    .btn-group {
        position: relative;
        display: inline-block;
    }

    /* Gaya tombol */
    .bttn {
        background-color: #4CAF50; /* Warna latar belakang tombol */
        color: white; /* Warna teks tombol */
        padding: 6px 12px;
        font-size: 12px;
        border: none; /* Menghapus border tombol */
        cursor: pointer; /* Kursor pointer saat hover */
        border-radius: 4px;
    }

    /* Gaya tombol dropdown */
    .dropdown-toggle {
        border-left: 1px solid #ddd; /* Garis pemisah */
    }

    /* Konten dropdown (tersembunyi secara default) */
    .dropdown-menu {
        display: none; /* Menyembunyikan konten secara default */
        position: absolute; /* Posisi absolut untuk mengatur posisi dropdown */
        background-color: #f9f9f9; /* Warna latar belakang dropdown */
        min-width: 160px; /* Lebar minimum dropdown */
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); /* Bayangan dropdown */
        z-index: 1; /* Agar konten dropdown berada di atas elemen lain */
        border-radius: 4px; /* Radius border untuk sudut dropdown */
    }

    /* Item dropdown */
    .dropdown-menu a {
        color: black; /* Warna teks item dropdown */
        padding: 12px 16px; /* Padding item dropdown */
        text-decoration: none; /* Menghapus garis bawah teks */
        display: block; /* Membuat setiap item berada di baris sendiri */
    }

    /* Gaya saat hover pada item dropdown */
    .dropdown-menu a:hover {
        background-color: #ddd; /* Warna latar belakang saat hover */
    }

    /* Menampilkan konten dropdown saat tombol diklik */
    .btn-group .dropdown-toggle:focus + .dropdown-menu,
    .btn-group .dropdown:hover .dropdown-menu {
        display: block;
    }

</style>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">No : <?php echo $invoice->code ?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body"> 

            <div class="btn-group">
                <div class="dropdown">
                    <button class="bttn btn-green dropdown-toggle" id="dropdownMenuButton">
                        <i class="fa fa-print"></i>&nbsp;&nbsp;Cetak
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="<?= $this->Url->build(['action' => 'childPrint', $invoice->id]); ?>" class="dropdown-item" target="_blank">Dengan header footer</a>
                        <a href="<?= $this->Url->build(['action' => 'childPrintOut', $invoice->id]); ?>" class="dropdown-item" target="_blank">Tanpa header footer</a>
                    </div> 
                </div>
            </div>

            <h2 class="text-center"><strong>INVOICE PROFORMA</strong></h2>
            <h6 class="text-center mb-3"><i>Invoice Parent : &nbsp;<strong><?= $parentInvoiceCode ?></strong></i></h6> <br>

            <div class="row m-b-15">
                <div class="col-2 col-sm-2 mb-1">
                    <b>No. Invoice</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo $invoice->code ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>Tgl. Invoice</b>
                </div> 
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (($invoice->date != null) ? $this->Krs->fDate($invoice->date, 'd-m-Y') : '') ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>Referensi PO</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (!empty($invoice->referense_po) ? $invoice->referense_po : '-') ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>Tgl. Jatuh Tempo</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (($invoice->expired != null) ? $this->Krs->fDate($invoice->expired, 'd-m-Y') : '') ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>Customer</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (!empty($invoice->order->pelanggan) ? $invoice->order->pelanggan->name : '') ?></i></div>

            </div> <br>
            <div class="table-responsive mb-3">
                <table class="table table-hover table-panel mb-0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Produk</th>
                            <th>Keterangan</th>
                            <th width="90" class="text-center">Tgl. Expired</th>
                            <th width="70" class="text-center">Harga</th>
                            <th width="60" class="text-center">Jumlah</th>
                            <th width="70" class="text-center">Diskon</th>
                            <th width="70" class="text-center">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $subtotals = array();
                        foreach ($invoice->order->order_lines as $index => $rowOrder) {
                            $subtotals[$index] = $rowOrder->subtotal; 
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td><?= (!empty($rowOrder->item) ? $rowOrder->item->name : '') ?></td>
                                <td><?= (!empty($rowOrder->comment) ? $rowOrder->comment : '-') ?></td>
                                <td class="text-center"><?= (!empty($rowOrder->expired_date) ? $this->Krs->fDate($rowOrder->expired_date, 'd-m-Y') : '-') ?></td>
                                <td class="text-end"><?= $this->Krs->_currency($rowOrder->price_t); ?></td>
                                <td class="text-center"><?= $this->Krs->_currency($rowOrder->quantity) . ' ' . (!empty($rowOrder->item) ? $rowOrder->item->unit : ''); ?></td>
                                <td class="text-end"><?= $this->Krs->_currency($rowOrder->discount); ?></td>
                                <td class="text-end"><?= $this->Krs->_currency($rowOrder->subtotal); ?></td>
                            </tr>
                        <?php
                            $no++;
                        }
                        // $ppn = ($invoice->order->pelanggan->ppn == '1') ? ((11 * $invoice->order->grandtotal) / 100) :  0;
                        // $gTotal = $invoice->order->grandtotal + $ppn;
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
                                <td width="60%" class="table-info"><strong>Total</strong></td>
                                <td width="40%" class="text-end"><?= $this->Krs->_currency(array_sum($subtotals)); ?></td>
                            </tr>
                            <tr>
                                <td width="60%" class="table-info"><strong>Biaya Pengiriman</strong></td>
                                <td width="40%" class="text-end"><?= $this->Krs->_currency($invoice->order->deliver_pays); ?></td>
                            </tr>
                            <tr>
                                <td width="60%" class="table-info"><strong>PPn (12%)</strong></td>
                                <td width="40%" class="text-end"><?= $this->Krs->_currency($ppn); ?></td>
                            </tr>
                            <tr>
                                <td width="60%" class="table-info"><strong>Grandtotal</strong></td>
                                <td width="40%" class="text-end"><strong><?= $this->Krs->_currency($orders->grandtotal); ?></strong></td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>

            <div class="row" style="padding-left: 1rem;">
                <div class="col-12 col-sm-12">
                    <span><b>Note :</b></span> <br> 
                    <span><?= (!empty($orders->keterangan) ? $orders->keterangan : '-') ?></span>
                </div>
            </div>

            <?php if ($invoice->parent_id > 0): ?>
                <hr>
                <div class="row">
                    <span class="text-center"><b>PEMBAYARAN</b></span>
                    <hr style="width: 100px; border: 0; border-top: 1px solid #2980b9; margin: 0 auto; display: block; margin-top: 5px;">
                    <br>
                    <div class="table-responsive mb-3">
                        <table class="table table-hover table-panel mb-0">
                            <thead style="background-color: #DEF4FE; color: black;">
                                <tr class="text-center">
                                    <th width="200">Metode Pembayaran</th>
                                    <th width="200">Nominal</th>
                                    <th width="200">PPN</th>
                                    <th width="200">Total Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody style="background-color: #E4E7E8; color: black;">
                                <?php
                                $nominal = $invoice->proforma_nominal;
                                $ppn = ($invoice->proforma_nominal * 11) / 100;
                                $total = $nominal + $ppn;
                                ?>
                                <tr>
                                    <td class="text-center"><?= !empty($invoice->proforma_method) ? ($invoice->proforma_method) : '-' ?></td>
                                    <td class="text-center"><?= !empty($invoice->proforma_nominal) ? $this->Krs->_currency($invoice->proforma_nominal) : '-' ?></td>
                                    <td class="text-center"><?= ($invoice->proforma_ppn > 0) ? $this->Krs->_currency($ppn) : '-'  ?></td>
                                    <td class="text-center"><?= !empty($total) ? $this->Krs->_currency($total) : '-' ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
            <?php endif; ?>

            <?php if ($invoice->payment_nominal_1 !== null): ?>
                <hr>
                <div class="row">
                    <span class="text-center"><b>RIWAYAT PEMBAYARAN</b></span>
                    <hr style="width: 100px; border: 0; border-top: 1px solid #2980b9; margin: 0 auto; display: block; margin-top: 5px;">
                    <br>

                    <?php 
                    $totalNominal = 0;

                    foreach ($invoice->receipts as $index => $rowReceipt) {
                        $totalNominal += $rowReceipt->nominal; 
                    }

                    $statusPembayaran = ($this->Krs->_currency($totalNominal) == $this->Krs->_currency($orders->grandtotal)) ? 'LUNAS' : 'BELUM LUNAS';
                    ?>
                    
                    <span><b>Status Pembayaran : <?= $statusPembayaran ?></b></span>
                    <br><br>
                    <div class="table-responsive mb-3">
                        <table class="table table-hover table-panel mb-0">
                            <thead style="background-color: #DEF4FE; color: black;">
                                <tr class="text-center">
                                    <th>No. Kuitansi</th>
                                    <th width="150">Pembayaran</th>
                                    <th width="150">Tanggal</th>
                                    <th width="100">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                            foreach ($invoice->receipts as $index => $rowReceipt) { 
                            ?>
                                <tr>
                                    <td><?= !empty($rowReceipt->code) ? ($rowReceipt->code) : '-' ?></td>
                                    <td class="text-center"><?= !empty($rowReceipt->payment_type) ? ($rowReceipt->payment_type) . ' ' . $no++ : '-' ?></td>
                                    <td class="text-center"><?= !empty($rowReceipt->date) ? $this->Krs->fDate($rowReceipt->date, 'd-m-Y') : '-' ?></td>
                                    <td class="text-end"><?= !empty($rowReceipt->nominal) ? $this->Krs->_currency($rowReceipt->nominal) : '-' ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                            <tfoot style="border: 0px solid transparent; background-color: #f9f9f9; padding: 5px;">
                                <tr>
                                    <td class="text-end" colspan="2">&nbsp;</td>
                                    <td class="text-center"><strong>Total Pembayaran</strong></td>
                                    <td class="text-end"><strong><?= $this->Krs->_currency($totalNominal) ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <br>
            <?php endif; ?>
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
        </div>
    </div>
</div>
