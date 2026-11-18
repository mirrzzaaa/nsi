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
            <h4 class="modal-title">Detail Supplier </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="row mb-2">
                <div class="col-2 col-sm-2">
                    <b>Kode</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($supplier->code) ? $supplier->code : '-') ?></i></div>
                <div class="col-2 col-sm-2">
                    <b>Nama Supplier</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($supplier->name) ? $supplier->name : '-') ?></i></div>
            </div>
            <div class="row mb-2">
                <div class="col-2 col-sm-2">
                    <b>PIC</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?= (($supplier->pic == null) && ($supplier->telp == null)) ? '-' : '(' . $supplier->telp . ') - ' . $supplier->pic ?></i></div>
                <div class="col-2 col-sm-2">
                    <b>Email</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($supplier->email) ? $supplier->email : '-') ?></i></div>
                
                
            </div>
            <div class="row mb-2">
                <div class="col-2 col-sm-2">
                    <b>Alamat Supplier</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($supplier->address) ? $supplier->address : '-') ?></i></div>
                <div class="col-2 col-sm-2">
                    <b>NPWP</b>
                    
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($supplier->npwp) ? $supplier->npwp : '-') ?></i></div>
                
            </div>
 

        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
        </div>
    </div>
</div>
