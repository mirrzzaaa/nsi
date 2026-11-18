<?php
ini_set('precision', 14);

// pr($order);

$subtotals = array();
    foreach ($order->order_lines as $index => $value) {
        $subtotals[$index] = is_numeric($value->subtotal) ? $value->subtotal : 0;
    }
    $subtotalSum = array_sum($subtotals);

    if ($order->with_price == 'Y' && $order->invoice_id > 0) {
        $ppn = (is_numeric($order->invoice->ppn) && $order->invoice->ppn > 0) ? ((11 * $subtotalSum) / 100) : 0;
    } elseif ($order->with_price == 'Y') {
        $ppn = (is_numeric($order->ppn) && $order->ppn > 0) ? ((11 * $subtotalSum) / 100) : 0;
    }
                        
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-yellow">
            <h4 class="modal-title">Order</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="row m-b-15">
                <div class="col-2 col-sm-2">
                    <b>No. Order</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($order->code) ? $order->code : '-') ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Customer</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($order->pelanggan) ? $order->pelanggan->name : '-') ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Tgl. Order</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (($order->date != null) ? $this->Krs->fDate($order->date, 'd-m-Y') : '') ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Admin</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($order->user) ? $order->user->code : '-')  ?></i></div>
            </div>
            <br>
            <div class="table-responsive mb-3">
                <table class="table table-hover table-panel mb-0 po">
                    <thead style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th width="300">Produk</th>
                            <?php if ($order->with_price === 'Y') { ?>
                                <th width="200">Keterangan</th>
                                <th class="text-center" width="100">Tgl. Expired</th>
                                <th class="text-center" width="80">Harga</th>
                                <th class="text-center" width="100">Jumlah</th>
                                <th class="text-center" width="80">Diskon</th>
                                <th class="text-center" width="100">Subtotal</th>
                            <?php } elseif ($order->with_price === 'N') { ?>
                                <th class="text-center">Jumlah</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $subtotal = array();
                        foreach ($order->order_lines as $index => $value) {
                            $subtotal[$index] = $value->subtotal;
                            ?>
                            <tr>
                                <td><?= (!empty($value->item_id) ? $value->item->name : '-') ?></td>
                                <?php if ($order->with_price === 'Y') { ?>
                                <td><?= (!empty($value->comment) ? $value->comment : '-') ?></td>
                                <td class="text-center"><?= (!empty($value->expired_date) ? $this->Krs->fDate($value->expired_date, 'd-m-Y') : '-') ?></td>
                                <td class="text-end"><?= (!empty($value->price_t) ? $this->Krs->_currency($value->price_t) : '-') ?></td>
                                <td class="text-center"><?php echo (!empty($value->quantity) ? $value->quantity : '-') . ' ' . (!empty($value->unit) ? $value->unit : '-') ?></td>
                                <td class="text-end"><?= (!empty($value->discount) ? $this->Krs->_currency($value->discount) : '0') ?></td>
                                <td class="text-end"><?= (!empty($value->subtotal) ? $this->Krs->_currency($value->subtotal) : '-') ?></td>
                                <?php } elseif ($order->with_price === 'N') { ?>
                                    <td class="text-center"><?php echo (!empty($value->quantity) ? $value->quantity : '-') . ' ' . (!empty($value->unit) ? $value->unit : '-') ?></td>
                                <?php } ?>
                            </tr>
                        <?php
                            $no++;
                        }
                        //$ppn = ($order->ppn > 0) ? ((11 * ($subtotal)) / 100) :  0 ;
                        ?>
                    </tbody>
                </table>
            </div>

            <?php if ($order->with_price !== 'N') { ?>
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div> 
                <div class="col-md-8">
                    <table class="table table-bordered"> 
                        <tbody>
                            <tr>
                                <td width="60%" class="table-info"><strong>Total</strong></td>
                                <td width="40%" class="text-end"><strong><span id="subtotals"><?= $this->Krs->_currency(array_sum($subtotal)); ?></span></strong></td>
                            </tr>
                            <!-- <tr>
                                <td width="60%" class="table-info"><strong>Diskon (%)</strong></td>
                                <td width="40%" class="text-end"><strong><span id="disc">$this->Krs->_currency($order->discount);</span> %</strong></td>
                            </tr> -->
                            <tr>
                                <td width="60%" class="table-info"><strong>Biaya Pengiriman</strong></td>
                                <td width="40%" class="text-end"><strong><span id="shipment"><?= $this->Krs->_currency($order->deliver_pays); ?></span></strong></td>
                            </tr>
                            <tr>
                                <td width="60%" class="table-info"><strong>Ppn (12%)</strong></td>
                                <td width="40%" class="text-end"><strong><span id="ppn"><?= $this->Krs->_currency($ppn); ?></span></strong></td>
                            </tr>
                            <tr>
                                <td width="60%" class="table-info"><strong>GRAND TOTAL</strong></td>
                                <td width="40%" class="text-end">
                                    <?php 
                                    $grandtotals = array_sum($subtotal) + $ppn;
                                    ?>
                                    <!-- Input Hidden untuk grandtotal -->
                                    <input type="hidden" name="grandtotal" class="grandtotal" value="<?= $grandtotals; ?>">
                                    
                                    <!-- Menampilkan Grand Total dengan format currency -->
                                    <strong><span id="grandtotal"><?= $this->Krs->_currency(floor($grandtotals)); ?></span></strong>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>

            <div class="row" style="padding-left: 1rem;">
                <div class="col-12 col-sm-12">
                    <span><b>Note :</b></span> <br> 
                    <span><?= (!empty($order->keterangan) ? $order->keterangan : '-') ?></span>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
        </div>
    </div>
</div>
