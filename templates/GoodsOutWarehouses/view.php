<?php
ini_set('precision', 14);
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-yellow">
            <h4 class="modal-title">Barang Keluar Gudang</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="row m-b-15">
                <div class="col-2 col-sm-2">
                    <b>No. Keluar Gudang</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo $goodsOutWarehouse->code ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Tujuan</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo $this->Krs->_toEdit($goodsOutWarehouse->is_to); ?></i></div>  

                <div class="col-2 col-sm-2">
                    <b>Tgl. Keluar</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (($goodsOutWarehouse->date != null) ? $this->Krs->fDate($goodsOutWarehouse->date, 'd-m-Y') : '') ?></i></div> 

                <div class="col-2 col-sm-2">
                    <b>Gudang</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (($goodsOutWarehouse->warehouse_id > 0) ? (!empty($goodsOutWarehouse->warehouse) ? $goodsOutWarehouse->warehouse->name : '-') : '-') ?></i></div>
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
                        $no = 1;
                        foreach ($goodsOutWarehouse->goods_out_warehouse_lines as $index => $value) { ?>
                            <tr>
                                <td><?= (($value->warehouse_stock_id > 0) ? (!empty($value->warehouse_stock) ? $value->warehouse_stock->item->name : '-') : ($value->name)); ?></td>
                                <td class="text-center"><?= $this->Krs->_currency($value->qty) ?></td>
                                <td class="text-center"><?= $value->unit ?></td>
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
