<?php
ini_set('precision', 14);
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-yellow"> 
            <h4 class="modal-title">Detail Item Toko</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="row m-b-15">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>Kode Internal</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($branchStock->code) ? $branchStock->code : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Toko</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($branchStock->branch->name) ? $branchStock->branch->name : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Item</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($branchStock->item->name) ? $branchStock->item->name : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Barcode</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($branchStock->item->barcode) ?$branchStock->item->barcode : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Stok</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($branchStock->stock) ? $this->Krs->_currency($branchStock->stock) : '-') . ' ' . (!empty($branchStock->unit) ? $branchStock->unit : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Supplier</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($branchStock->item->supplier->name) ? $branchStock->item->supplier->name : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Harga Beli</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i>IDR. <?php echo (!empty($branchStock->buy) ? $this->Krs->_currency($branchStock->buy) : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Harga Jual</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i>IDR. <?php echo (!empty($branchStock->sell) ? $this->Krs->_currency($branchStock->sell) : '-') ?></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
        </div>
    </div>
</div>
