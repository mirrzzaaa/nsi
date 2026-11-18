<?php
ini_set('precision', 14);
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-yellow">
            <h4 class="modal-title">Barang Masuk Toko</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="row m-b-15">
                <div class="col-2 col-sm-2">
                    <b>No. Barang Masuk</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo $goodsInStore->code ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Dari</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo $this->Krs->_from($goodsInStore->is_from); ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Tgl. Masuk</b> 
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (($goodsInStore->date != null) ? $this->Krs->fDate($goodsInStore->date, 'd-m-Y') : '') ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Toko</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (($goodsInStore->branch_id > 0) ? (!empty($goodsInStore->branch) ? $goodsInStore->branch->name : '-') : '-') ?></i></div>
            </div>
            <br>
            <!-- <div class="table-responsive mb-3" style="overflow: auto; height: 280px;">
                <table class="table table-hover table-panel text-nowrap align-middle mb-0 po">
                    <thead style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th class="text-center">#</th>
                            <th width="300">Produk</th>
                            <th width="100">Jumlah</th>
                            <th width="100">Unit</th>
                            <th width="500">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($goodsInWarehouse->goods_in_warehouse_lines as $index => $value) { ?>
                            <tr>
                                <td class="text-center"><?= $no ?></td>
                                <td><?= (!empty($value->item) ? $value->item->name : '-') ?></td>
                                <td><?= $this->Krs->_currency($value->qty) ?></td>
                                <td><?= $value->unit ?></td>
                                <td><?= $value->description ?></td>
                            </tr>
                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div> -->
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
        </div>
    </div>
</div>
