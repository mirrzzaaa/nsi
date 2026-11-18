<?php
ini_set('precision', 14);
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">No : <?php echo $tandaTerima->code ?></h4> 
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <a href="<?= $this->Url->build(['action' => 'print', $tandaTerima->id]); ?>" class="btn btn-success"><i class="fas fa-print"></i> &nbsp;Cetak</a> 
            <h2 class="text-center mb-3"><strong>TANDA TERIMA</strong></h2> <br>
            <div class="row m-b-15">
                <div class="col-2 col-sm-2 mb-1">
                    <b>No. Tanda Terima</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo $tandaTerima->code ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>No. Faktur Pajak</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (!empty($tandaTerima->no_faktur) ? $tandaTerima->no_faktur : '-') ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>Tgl. Buat</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (($tandaTerima->date != null) ? $this->Krs->fDate($tandaTerima->date, 'd-m-Y') : '') ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>No. Invoice</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (!empty($tandaTerima->invoice_id) ? $tandaTerima->invoice->code : '-') ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>Customer</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (!empty($tandaTerima->invoice->customer) ? $tandaTerima->invoice->customer->title . ' - ' . $tandaTerima->invoice->customer->name : '-') ?></i></div> 

                <div class="col-2 col-sm-2 mb-1">
                    <b>No. Surat Jalan</b>
                </div>
                <div class="col-4 col-sm-4 mb-1">: <i><?php echo (!empty($tandaTerima->permit_id) ? $tandaTerima->permit->code : '-') ?></i></div>

                <div class="col-2 col-sm-2 mb-1">
                    <b>Alamat</b>
                </div>
                <div class="col-10 col-sm-10 mb-1">: <i><?php echo (!empty($tandaTerima->invoice->customer) ? $tandaTerima->invoice->customer->address_penghasil : '-') ?></i></div>

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
                        foreach ($tandaTerima->invoice->order->order_lines as $rowOrder) { ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $rowOrder->item->name ?></td>
                                <td><?= $this->Krs->_currency($rowOrder->quantity) . ' ' . $rowOrder->unit; ?> </td>
                            </tr>
                        <?php
                            $no++;
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
