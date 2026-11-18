<?php
ini_set('precision', 14);
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-yellow">
            <h4 class="modal-title">Detail Satuan</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="row m-b-15">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="row">
                            <div class="col-2 col-sm-2">
                                <b>Kode</b>
                            </div>
                            <div class="col-8 col-sm-8">: <i><?php echo (!empty($unit->code) ? $unit->code : '-') ?></i></div>
                        </div>
                        <div class="row">
                            <div class="col-2 col-sm-2">
                                <b>Nama Satuan</b>
                            </div>
                            <div class="col-8 col-sm-8">: <i><?php echo (!empty($unit->name) ? $unit->name : '-') ?></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
        </div>
    </div>
</div>
