<?php
ini_set('precision', 14);
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">No : <?php echo $permit->code ?></h4> 
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <a href="<?= $this->Url->build(['action' => 'print', $permit->id]); ?>" class="btn btn-success"><i class="fas fa-print"></i> &nbsp;Cetak</a>
            <h2 class="text-center mb-3"><strong>SURAT JALAN PENGIRIMAN</strong></h2> <br>
            <div class="row m-b-15">
                <div class="col-2 col-sm-2 mb-1">
                    <b>No. Surat Jalan</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo $permit->code ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>Tgl. Pengiriman</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (($permit->date != null) ? $this->Krs->fDate($permit->date, 'd-m-Y') : '') ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>Customer</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (!empty($permit->order->pelanggan) ? $permit->order->pelanggan->title . ' - ' . $permit->order->pelanggan->name : '-') ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>Pengirim</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (!empty($permit->delivered) ? $permit->delivered : $permit->truck->name) ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>No. Invoice</b>
                </div>
                <div class="col-10 col-sm-10 mb-1">: <i><?php echo (($permit->order->invoice_id > 0) ? $permit->order->invoice->code : '-') ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>Alamat</b>
                </div>
                <div class="col-10 col-sm-10 mb-1">: <i><?php echo (!empty($permit->order->pelanggan) ? $permit->order->pelanggan->address_penghasil : '-') ?></i></div>

            </div>
            <br>
            <div class="table-responsive mb-3">
                <table class="table table-hover table-panel mb-0 po">
                    <thead style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th width="50">#</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (!empty($permit->permit_order_lines)) {
                            foreach ($permit->permit_order_lines as $permitOrderLine) { 
                                // Ambil order_line dari relasi OrderLines
                                $orderLine = $permitOrderLine->order_line ?? null;
                                if ($orderLine) {
                        ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td><?= ($orderLine->item->name) ?></td>
                                    <td class="text-center"><?= $this->Krs->_currency($orderLine->quantity) . ' ' . $orderLine->unit; ?> </td>
                                </tr>
                        <?php
                                    $no++;
                                }
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center'>Data tidak ditemukan</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
        </div>
    </div>
</div>
