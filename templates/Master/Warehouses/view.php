<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Processor $processor
 */
?>
<?php
ini_set('precision', 14);
?>


<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-yellow">
            <h4 class="modal-title">Detail Gudang </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="row mb-2">
                <div class="col-2 col-sm-2">
                    <b>Kode</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($warehouse->code) ? $warehouse->code : '-') ?></i></div>
                <div class="col-2 col-sm-2">
                    <b>Nama Gudang</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($warehouse->name) ? $warehouse->name : '-') ?></i></div>
            </div>
            <div class="row">
                <div class="col-2 col-sm-2">
                    <b>Alamat</b>
                </div>
                <div class="col-10 col-sm-10">: <i><?php echo (!empty($warehouse->address) ? $warehouse->address : '-') ?></i></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-2 col-sm-2">
                    <b>PIC</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($warehouse->pic) ? $warehouse->pic : '-') ?></i></div>
                <div class="col-2 col-sm-2">
                    <b>Telepon</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($warehouse->telp) ? $warehouse->telp : '-') ?></i></div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
        </div>
    </div>
</div>
