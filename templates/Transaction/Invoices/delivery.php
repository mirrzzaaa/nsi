<?php
$dataChild = $this->Html->link('Invoice', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_($dataChild, 'Pengiriman', '') ?>

<?= $this->Form->create(null, ['type' => 'get']) ?>
<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fas fa-search fa-lg me-2 text-gray text-opacity-50"></i>
        Cari Invoice
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <label for="" class="form-label">No. Invoice</label>
                <?= $this->Form->control('filtercode', ['label' => false, 'class' => 'form-control', 'value' => $this->request->getQuery('filtercode'), 'placeholder' => 'Masukkan nomor invoice...']); ?>
            </div>
            <!-- <div class="col-md-2">
                <label for="" class="form-label">Customer</label>

                //$this->Form->control('filtercustomer', ['label' => false, 'class' => 'form-control slc', 'value' => $this->request->getQuery('filtercustomer'), 'data-placeholder' => 'Pilih customer...', 'empty' => 'Pilih customer...', 'options' => $customers]); 
                
            </div> -->
            <div class="col-md-4">
                <label for="" class="form-label">Tgl. Invoice</label>
                <div class="input-daterange input-group" id=" date-picker">
                    <?php
                    echo $this->Krs->inputDateRange('filterstart', array("class" => "form-control filterDateReceive", 'id' => 'start', 'readonly' => true, 'placeholder' => 'Tgl. mulai..', 'value' => $this->request->getQuery('filterstart')), 'filterend', array("class" => "form-control filterDateReceive", 'id' => 'end', 'readonly' => true, 'placeholder' => 'Tgl. sampai..', 'value' => $this->request->getQuery('filterend')), 's/d', 'resetDateReceive');
                    ?>
                </div>
            </div>
            <div class="col-md-3"> 
                <label for="" class="form-label">Status Pengiriman</label>
                <?= $this->Form->control('filterstatus', ['label' => false, 'class' => 'form-control slc', 'value' => $this->request->getQuery('filterstatus'), 'data-placeholder' => 'Status pengiriman...', 'empty' => 'Pilih status...', 'options' => $this->Krs->invoiceDelivery()]); ?>
            </div>
            <div class="col-md-1">
                <label for="" class="form-label">&nbsp;</label>
                <div class="btn-group w-100">
                    <?= $this->Krs->searchButton(); ?> 
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

<?= $this->Form->create($dataSending, []) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<?php
if (count($invoices) != 0) { ?>
    <div class="card border-0 mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr class="">
                            <th width="5%" class="text-center">#</th>
                            <th width="20%">Invoice</th>
                            <th width="25%">Customer</th>
                            <th width="20%">Pengiriman</th>
                            <th width="30%">Keterangan</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($invoices as $index => $rowInvoice) { ?>
                            <tr>
                                <td class="text-center"><?= $no ?></td>
                                <td><strong>No. Invoice</strong> : <i><?= $rowInvoice->code ?></i> <br> <strong>Tgl. Invoice</strong> : <i><?= ($rowInvoice->date != null ? date_format($rowInvoice->date, 'd-m-Y') : '-') ?></i></td>
                                <td><?= (!empty($rowInvoice->order->pelanggan)) ? $rowInvoice->order->pelanggan->name : '-' ?></td>
                                <td>
                                    <?php if ($rowInvoice->delivery_date == null || $rowInvoice->delivery_date == '') { ?>
                                        <div class="input-group">
                                            <input type="text" name="data[<?= $rowInvoice->id ?>][delivery_date]" class="form-control mb-2 tgl" id="Data<?= $rowInvoice->id ?>Delivery" placeholder="Tgl. pengiriman..." readonly>
                                            <button type="button" class="btn btn-inverse mb-2" id="Reset<?= $rowInvoice->id ?>Delivery" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    <?php } else { ?>
                                        <label class="col-md-12 mb-1"><strong>Tgl. Kirim : </strong> <i><?= date_format($rowInvoice->delivery_date, 'd M Y') ?></i></label>
                                        <input type="hidden" name="data[<?= $index ?>][delivery_date]" value="<?= $rowInvoice->delivery_date != '' || $rowInvoice->delivery_date != null ? date_format($rowInvoice->delivery_date, 'd-m-Y') : null; ?>" />
                                    <?php
                                    } ?>

                                    <?php if ($rowInvoice->delivery == null || $rowInvoice->delivery == '') { ?>
                                        <input type="text" name="data[<?= $rowInvoice->id ?>][delivery]" class="form-control mb-2" placeholder="Pengirim...">
                                    <?php } else { ?>
                                        <label class="col-md-12 mb-1"><strong>Pengirim : </strong> <?= $rowInvoice->delivery ?></label>
                                        <input type="hidden" name="data[<?= $index ?>][delivery]" value="<?= $rowInvoice->delivery != '' || $rowInvoice->delivery != null ? $rowInvoice->delivery : null; ?>" />
                                    <?php } ?>

                                    <?php if ($rowInvoice->delivery_media == null || $rowInvoice->delivery_media == '') { ?>
                                        <?= $this->Form->text('data[' . $rowInvoice->id . '][delivery_media]', ['label' => false, 'class' => 'form-control', 'type' => 'text', 'placeholder' => 'Media pengiriman', 'value' => $rowInvoice->delivery_media]); ?>
                                    <?php } else { ?>
                                        <label class="col-md-12 mb-1"><strong>Media Pengiriman: </strong> <?= $rowInvoice->delivery_media ?></label>
                                        <input type="hidden" name="data[<?= $index ?>][delivery_media]" value="<?= $rowInvoice->delivery_media != '' || $rowInvoice->delivery_media != null ? $rowInvoice->delivery_media : null; ?>" />
                                    <?php } ?>
                                    <script>
                                        $(function() {
                                            $.datepicker.setDefaults($.datepicker.regional['id']);
                                            $('#Data<?= $rowInvoice->id ?>Delivery').datepicker({
                                                format: 'dd-mm-yyyy',
                                                autoclose: true,
                                                orientation: 'bottom',
                                                todayHighlight: !0
                                            });
                                            $('#Reset<?= $rowInvoice->id ?>Delivery').on('click', function() {
                                                $('#Data<?= $rowInvoice->id ?>Delivery').val('');
                                            });
                                        });
                                    </script>
                                </td>
                                <td>
                                    <?= $this->Form->control('data[' . $rowInvoice->id . '][delivery_desc]', ['label' => false, 'class' => 'form-control', 'type' => 'textarea', 'placeholder' => 'Keterangan', 'value' => $rowInvoice->delivery_desc]); ?>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-yellow d-flex p-3">
            <?php
            echo $this->Form->button('Simpan', ['class' => 'btn btn-primary  ms-auto', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
            ?>
        </div>
    </div>
<?php
}
?>
<?= $this->Form->end() ?>
<script>
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Invoices', 'action' => 'delivery'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

        datePickerReset('input-daterange', 'resetDateReceive', 'filterDateReceive', 'dd-mm-yyyy');

        $('.slc').select2({
            placeholder: "Pilih...",
            position: 'below'
        });

    });
</script>
