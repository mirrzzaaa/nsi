<?php
ini_set('precision', 14);
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-yellow">
            <h4 class="modal-title">Detail Produk</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="row m-b-15">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>Kode</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($item->code) ? $item->code : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Barcode</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo ($item->barcode == null) ? '-' : $item->barcode ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Kategori</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (($item->category_id > 0) ? ((!empty($item->category)) ? $item->category->name : '-') : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Kode Internal</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($item->code_internal) ? $item->code_internal : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Nama Produk</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($item->name) ? $item->name : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Supplier</b>
                        </div>
                        <div class="col-4 col-sm-4">
                            <i>
                                <?php 
                                $supplierNames = [];

                                if (!empty($suppliers)) {
                                    foreach ($suppliers as $supplier) {
                                        $supplierNames[] = $supplier->name;
                                    }
                                }

                                echo !empty($supplierNames) ? implode(', ', $supplierNames) : '-';
                                ?>
                            </i>
                        </div>
                        <div class="col-2 col-sm-2">
                            <b>Tgl. Expired Barang</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (($item->expired_date != null) ? $this->Krs->fDate($item->expired_date, 'd-m-Y') : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Gudang</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo ($item->warehouse_id > 0) ? $item->warehouse->name : '-' ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Harga Beli</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i>IDR <?php echo (!empty($item->buying_price) ? $this->Krs->_currency($item->buying_price) : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Stock Barang</b> 
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($item->stock) ? $this->Krs->_currency($item->stock) : '-') . ' ' . (!empty($item->unit) ? $item->unit : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Harga Jual</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i>IDR <?php echo (!empty($item->selling_price) ? $this->Krs->_currency($item->selling_price, 'd-m-Y') : '') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Keterangan</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i><?php echo (!empty($item->description) ? $item->description : '-') ?></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
        </div>
    </div>
</div>
