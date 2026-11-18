<?php
ini_set('precision', 14);
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-yellow">
            <h4 class="modal-title">Barang Masuk Gudang</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="row m-b-15">
                <div class="col-2 col-sm-2">
                    <b>No. Masuk Gudang</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo $goodsInWarehouse->code ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Dari</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo $this->Krs->_from($goodsInWarehouse->is_from); ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Tgl. Masuk</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (($goodsInWarehouse->date != null) ? $this->Krs->fDate($goodsInWarehouse->date, 'd-m-Y') : '') ?></i></div>

                <div class="col-2 col-sm-2"> 
                    <b>Gudang</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (($goodsInWarehouse->warehouse_id > 0) ? (!empty($goodsInWarehouse->warehouse) ? $goodsInWarehouse->warehouse->name : '-') : '-') ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Keterangan</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($goodsInWarehouse->description) ? $goodsInWarehouse->description : '-') ?></i></div>

            </div>
            <br>
            <div class="table-responsive mb-3" style="overflow: auto; height: 280px;">
                <table class="table table-hover table-panel text-nowrap align-middle mb-0 po">
                    <thead style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th width="300">Produk</th>
                            <th class="text-center" width="100">Jumlah</th>
                            <th class="text-center" width="100">Unit</th>
                            <th class="text-center" width="100">Nomor Seri</th>
                            <th class="text-center" width="100">Kode Produk</th>
                            <th class="text-center" width="100">Supplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($goodsInWarehouse->purchasing->purchasing_lines as $value) {
                                // cari baris warehouse line yang cocok
                                $line = null;
                                foreach ($goodsInWarehouse->goods_in_warehouse_lines as $dataLine) {
                                    if ($dataLine->purchasing_line_id === $value->id) {
                                        $line = $dataLine;
                                        break;
                                    }
                                }
                            ?>
                                <tr>
                                    <td><?= !empty($value->item_id) ? $value->item->name : '-'; ?></td>
                                    <td class="text-center"><?= $this->Krs->_currency($value->quantity); ?></td>
                                    <td class="text-center"><?= !empty($value->item_id) ? $value->item->unit : '-'; ?></td>
                                    <td class="text-center"><?= !empty($line->nomor_seri) ? $line->nomor_seri : '-'; ?></td>
                                    <td class="text-center"><?= !empty($line->kode_produk) ? $line->kode_produk : '-'; ?></td>
                                    <td class="text-center"><?= !empty($line->supplier_name) ? $line->supplier_name : '-'; ?></td>
                                </tr>
                            <?php
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
