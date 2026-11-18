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
            <h4 class="modal-title">Detail Cabang </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="row mb-2">
                <div class="col-2 col-sm-2">
                    <b>Kode</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($branch->code) ? $branch->code : '-') ?></i></div>
            </div>
            <div class="row mb-2">
                <div class="col-2 col-sm-2">
                    <b>Cabang</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($branch->company_name) ? $branch->company_name : '-') ?></i></div>
            </div>
            <div class="row mb-2">
                <div class="col-2 col-sm-2">
                    <b>Telepon</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($branch->company_telp) ? $branch->company_telp : '-') ?></i></div>
            </div>
            <div class="row mb-2">
                <div class="col-2 col-sm-2">
                    <b>Alamat Cabang</b>
                </div>
                <div class="col-10 col-sm-10">: <i><?php echo (!empty($branch->company_address) ? $branch->company_address : '-') ?></i></div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
        </div>
    </div>
</div>
