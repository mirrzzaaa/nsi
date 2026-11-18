<?php
ini_set('precision', 14);

?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-yellow">
            <h4 class="modal-title">Detail Retur</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="row m-b-15">
                <div class="col-2 col-sm-2">
                    <b>No. Retur</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($returSupplier->code) ? $returSupplier->code : '-') ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>No. Purchase Order</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($returSupplier->purchasing) ? $returSupplier->purchasing->number : '-')  ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Supplier</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($returSupplier->supplier) ? $returSupplier->supplier->name : '-') ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Tgl. Retur</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (($returSupplier->date != null) ? $this->Krs->fDate($returSupplier->date, 'd-m-Y') : '') ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Keterangan</b>
                </div>
                <div class="col-8 col-sm-8">: <i><?php echo (!empty($returSupplier->reason) ? $returSupplier->reason : '-')  ?></i></div>

            </div>
            <br>
            <div class="table-responsive mb-3">
                <table class="table table-hover table-panel mb-0 po">
                    <thead style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th width="50">Kode</th>
                            <th class="text-center" width="200">Produk</th>
                            <th class="text-center" width="80">Harga</th>
                            <th class="text-center" width="100">Jumlah Retur</th>
                            <th class="text-center" width="100">Nomor Seri</th>
                            <th class="text-center" width="100">Kode Produk</th>
                            <th class="text-center" width="100">Supplier</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($returSupplier->retur_supplier_lines as $index => $value) {
                            $items = $value->item;
                            //pr($value);
                        ?>
                            <tr>
                                <td><?= (!empty($items->code) ? $items->code : '-') ?></td>
                                <td><?= (!empty($items->name) ? $items->name : '-') ?></td>
                                <td class="text-end"><?= (!empty($value->nominal) ? $this->Krs->_currency($value->nominal) : '-') ?></td>
                                <td class="text-center"><?php echo (!empty($value->quantity) ? $this->Krs->_currency($value->quantity) : '-') . ' ' . (!empty($items->unit) ? $items->unit : '-') ?></td>
                                <td class="text-center"><?= !empty($value->nomor_seri) ? $value->nomor_seri : '-'; ?></td>
                                <td class="text-center"><?= !empty($value->kode_produk) ? $value->kode_produk : '-'; ?></td>
                                <td class="text-center"><?= !empty($value->supplier_name) ? $value->supplier_name : '-'; ?></td>
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
