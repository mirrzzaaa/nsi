<?php
$dataChild = $this->Html->link('Invoice Masuk', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_($dataChild, 'Pembayaran', '') ?>

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
                <?= $this->Form->text('code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor invoice...', 'value' => $this->request->getQuery('code')]); ?>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Nama Perusahaan</label>
                <?= $this->Form->text('company', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama perusahaan...', 'value' => $this->request->getQuery('company')]); ?>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Tgl. Invoice</label>
                <?php
                echo $this->Krs->inputDateRange('filterstart', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. mulai..', 'value' => $this->request->getQuery('filterstart')), 'filterend', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. sampai..', 'value' => $this->request->getQuery('filterend')), 's/d', 'resetDateReceive');
                ?>
            </div>
        </div>
    </div>
    <div class="card-footer bg-none d-flex p-3 mt-2">
        <?php
        echo $this->Form->button('Cari Data', ['class' => 'btn btn-yellow  ms-auto', 'type' => 'submit', 'escape' => false]);
        ?>
    </div>
</div>
<?= $this->Form->end() ?>



<?= $this->Form->create($dataSending, ['data-parsley-validate' => true]) ?>
<?php echo $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>
<?php
if (count($invoiceEntries) != 0) { ?>
    <div class="panel panel-inverse rekap">
        <div class="panel-heading ui-sortable-handle">
            <h4 class="panel-title">Data Invoice Masuk</h4>
        </div>
        <div class="panel-body">
            <div class="portlet-body form">
                <br>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped rekaplist">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" width="50">#</th>
                                <th class="text-center" width="300">Pembayaran 1</th>
                                <th class="text-center" width="300">Pembayaran 2</th>
                                <th class="text-center" width="200">Keterangan</th>
                                <th class="text-center" width="200">Selisih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $subtotal = array();
                            $customerList  = array();
                            $customer_list = array();
                            foreach ($invoiceEntries as $index => $data) {
                                $ppn = !empty($data->purchasing) ? $data->purchasing->ppn : 0;
                                $selisih = !empty($data->purchasing) ? (($data->purchasing->grandtotal) - $data->payment_nominal + $data->payment_1_nominal) : 0;
                            ?>
                                <tr class="<?= $index % 2 ? 'table-info' : ''; ?>">
                                    <td class="text-center"><?= $no; ?></td>
                                    <td colspan="2">
                                        <strong>No. Invoice : </strong> <?= $data->code ?>
                                        <br>
                                        <strong>Tgl. Invoice : </strong> <?= date_format($data->date, 'd M Y') ?>
                                        <br>
                                        <strong>Perusahaan : </strong> <?= $data->company ?>
                                    </td>
                                    <td class="text-end">
                                        <strong>Grand Total : </strong>
                                    </td>
                                    <td class="text-end">
                                        <strong><?= $this->Krs->_currency($data->purchasing->grandtotal); ?></strong>
                                    </td>
                                </tr>
                                <tr class="sum">
                                    <td>&nbsp;<input type="hidden" name="data[<?= $index ?>][id]" value="<?= $data->id ?>"></td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" name="data[<?= $index ?>][payment_date]" class="form-control mb-2" id="Data<?= $data->id ?>Payment" placeholder="Tgl. pembayaran 1..." value="<?= $data->payment_date == null ? '' : date_format($data->payment_date, 'd-m-Y'); ?>" readonly>
                                            <button type="button" class="btn btn-danger mb-2" id="Reset<?= $data->id ?>Payment" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="data[<?= $index ?>][payment_nominal]" class="form-control mb-2 auto nominalPayment" value="<?= $data->payment_nominal == null ? '' : $this->Krs->_currency($data->payment_nominal); ?>" placeholder="Nominal 1...">
                                        <select name="data[<?= $index ?>][payment_type]" class="form-control mb-2 slc">
                                            <option value=""></option>
                                            <?php foreach ($this->Krs->methodPayment() as $key => $value) { ?>
                                                <option value="<?= $key ?>" <?= $data->payment_type == $key ? 'selected' : '' ?>>
                                                    <?= $value ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <script>
                                            $(function() {
                                                $.datepicker.setDefaults($.datepicker.regional['id']);
                                                $('#Data<?= $data->id ?>Payment').datepicker({
                                                    format: 'dd-mm-yyyy',
                                                    autoclose: true,
                                                    orientation: 'bottom',
                                                    todayHighlight: !0
                                                });
                                                $('#Reset<?= $data->id ?>Payment').on('click', function() {
                                                    $('#Data<?= $data->id ?>Payment').val('');
                                                });
                                            });
                                        </script>
                                    </td>
                                    <td>
                                        <div class="input-group"><input type="text" name="data[<?= $index ?>][payment_1_date]" class="form-control mb-2" id="Data<?= $data->id ?>Payment1" placeholder="Tgl. pembayaran 1..." value="<?= $data->payment_1_date == null ? '' : date_format($data->payment_1_date, 'd-m-Y'); ?>" readonly>
                                            <button type="button" class="btn btn-danger mb-2" id="Reset<?= $data->id ?>Payment1" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="data[<?= $index ?>][payment_1_nominal]" class="form-control mb-2 auto nominalPayment1" value="<?= $data->payment_1_nominal === null ? '' : $this->Krs->_currency($data->payment_1_nominal); ?>" placeholder="Nominal 2...">
                                        <select name="data[<?= $index ?>][payment_1_type]" class="form-control mb-2 slc">
                                            <option value=""></option>
                                            <?php foreach ($this->Krs->methodPayment() as $key => $value) { ?>
                                                <option value="<?= $key ?>" <?= $data->payment_1_type == $key ? 'selected' : '' ?>>
                                                    <?= $value ?>
                                                </option>
                                            <?php } ?>
                                        </select>

                                        <script>
                                            $(function() {
                                                $.datepicker.setDefaults($.datepicker.regional['id']);
                                                $('#Data<?= $data->id ?>Payment1').datepicker({
                                                    format: 'dd-mm-yyyy',
                                                    autoclose: true,
                                                    orientation: 'bottom',
                                                    todayHighlight: !0
                                                });
                                                $('#Reset<?= $data->id ?>Payment1').on('click', function() {
                                                    $('#Data<?= $data->id ?>Payment1').val('');
                                                });
                                            });
                                        </script>
                                    </td>
                                    <td>
                                        <?= $this->Form->control('data[' . $index . '][description]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Keterangan pembayaran...', 'type' => 'textarea', 'value' => $data->description]); ?>
                                    </td>
                                    <td class="table-danger text-end paymentColor">
                                        <h5 class="totalPayment"><?= $this->Krs->_currency($data->purchasing->grandtotal); ?></h5>
                                        <input type="hidden" name="data[<?= $index ?>][payment_total]" class="grandTotal" value="<?= $this->Krs->_currency($data->purchasing->grandtotal) ?>">
                                    </td>

                                    <script>
                                        $(function() {
                                            $.datepicker.setDefaults($.datepicker.regional['id']);
                                            $('#Data<?= $data->id ?>Pca').datepicker({
                                                format: 'dd-mm-yyyy',
                                                autoclose: true,
                                                orientation: 'bottom',
                                                todayHighlight: !0
                                            });
                                            $('#Reset<?= $data->id ?>Pca').on('click', function() {
                                                $('#Data<?= $data->id ?>Pca').val('');
                                            });
                                        });
                                    </script>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?= $this->Krs->paginators() ?>
            </div>
        </div>
        <div class="panel-footer  bg-none d-flex p-3">
            <?php
            echo $this->Form->button('Simpan', ['class' => 'btn btn-yellow ms-auto', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
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
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'InvoiceEntries', 'action' => 'payment'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

        $('.slc').select2({
            placeholder: 'Pilih tipe pembayaran...',
            allowClear: true,
        });

        datePickerReset('input-daterange', 'resetDateReceive', 'filterDateReceive', 'dd-mm-yyyy');

        $('input.auto').autoNumeric({
            aSep: '.',
            aDec: ','
        });

        function calcRow() {
            var overall = 0;

            $("tr.sum").each(function() {
                var nominalGrandTotal = parseFloat($(this).find(".grandTotal").val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                var nominalPayment1 = parseFloat($(this).find(".nominalPayment1").val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                var nominalPayment = parseFloat($(this).find(".nominalPayment").val().replace(/[^0-9\,]+/g, "").replace(",", "."));

                if (isNaN(nominalGrandTotal)) {
                    nominalGrandTotal = 0;
                }

                if (isNaN(nominalPayment1)) {
                    nominalPayment1 = 0;
                }

                if (isNaN(nominalPayment)) {
                    nominalPayment = 0;
                }

                var sum = nominalGrandTotal - nominalPayment1 - nominalPayment;

                if (isNaN(sum)) {
                    sum = 0;
                }

                // console.log(sum);
                var sums = parseFloat(sum).toFixed(2);
                var rus = sums.replace(/\./g, ',');
                $(this).find(".totalPayment").number(rus, 2, ",", ".");

                //$(this).find(".totalSum").number( sum, 2, ",", "." );

                if (sums == nominalGrandTotal || sums < 0) {
                    $(this).find(".paymentColor").remove('table-success');
                    $(this).find(".paymentColor").addClass('table-danger');
                } else if (sums == 0) {
                    $(this).find(".paymentColor").removeClass('table-danger');
                    $(this).find(".paymentColor").addClass('table-success');
                } else {
                    $(this).find(".paymentColor").css("background-color", "");
                }

                overall += sum;

            });
        }

        $(function() {
            calcRow();
            $('input.nominalPayment1').bind('change keyup', function() {
                calcRow();
            });
            $('input.nominalPayment').bind('change keyup', function() {
                calcRow();
            });

        });


    });
</script>
