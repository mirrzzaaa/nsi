<?php
ini_set('precision', 14);
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-yellow">
            <h4 class="modal-title">Detail MOU</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="row m-b-15">
                <div class="col-2 col-sm-2">
                    <b>No. MOU</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($mouse->code) ? $mouse->code : '-') ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Status</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($mouse->is_active) ? $this->Krs->is_active($mouse->is_active) : '-') ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>Customer</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($mouse->customer) ? $mouse->customer->name : '-') ?></i></div>

                <div class="col-2 col-sm-2">
                    <b>PIC</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?php echo (!empty($mouse->pic_name) ? $mouse->pic_name : '-') . ' ( ' . (!empty($mouse->pic_telp) ? $mouse->pic_telp : '-') . ' )' ?></i></div>
            </div>
            <br>
            <div class="table-responsive mb-3" style="overflow: auto; height: 280px;">
                <table class="table table-hover table-panel text-nowrap align-middle mb-0 po">
                    <thead style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th class="text-center">#</th>
                            <th width="300">Produk</th>
                            <th class="text-center"width="100">Harga</th>
                            <th class="text-center"width="100">Unit</th>
                            <th width="500">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($mouse->mouse_items as $index => $value) { ?>
                            <tr>
                                <td class="text-center"><?php echo (!empty($no) ? $no : '-') ?></td>
                                <td><?= (!empty($value->item) ? $value->item->name : '-') ?></td>
                                <td class="text-end"><?php echo (!empty($value->price) ? $this->Krs->_currency($value->price) : '-') ?></td>
                                <td class="text-center"><?php echo (!empty($value->unit) ? $value->unit : '-') ?></td>
                                <td><?php echo (!empty($value->description) ? $value->description : '-') ?></td>
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
