<?php
ini_set('precision', 14);
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-yellow">
            <h4 class="modal-title">Detail Item Gudang</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="row m-b-15">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>Kode Internal</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($warehouseStock->code) ? $warehouseStock->code : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Gudang</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($warehouseStock->warehouse->name) ? $warehouseStock->warehouse->name : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Item</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($warehouseStock->item->name) ? $warehouseStock->item->name : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Barcode</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($warehouseStock->item->barcode) ?$warehouseStock->item->barcode : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Stok</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($warehouseStock->stock) ? $this->Krs->_currency($warehouseStock->stock) : '-') . ' ' . (!empty($warehouseStock->unit) ? $warehouseStock->unit : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Supplier</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($warehouseStock->item) ? $warehouseStock->item->supplier->name : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Harga Beli</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i>IDR. <?php echo (!empty($warehouseStock->buy) ? $this->Krs->_currency($warehouseStock->buy) : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Harga Jual</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i>IDR. <?php echo (!empty($warehouseStock->sell) ? $this->Krs->_currency($warehouseStock->sell) : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Tgl. Expired Barang</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (($warehouseStock->expired_date != null) ? $this->Krs->fDate($warehouseStock->expired_date, 'd-m-Y') : '-') ?></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
        </div>
    </div>
</div>
