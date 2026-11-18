<?php

// pr($orders);

$dataChild = $this->Html->link('Kwitansi', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Buat') ?>
<?= $this->Form->create($receipt, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>  

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-money-check-dollar fa-lg me-2 text-gray text-opacity-50"></i> 
                Kwitansi
            </div>
            <div class="card-body"> 
                <div class="row">
                    <div class="col-md-4">
                        <label for="" class="form-label">No. Kwitansi</label>
                        <?= $this->Form->control('code_display', ['label' => false, 'class' => 'form-control', 'value' => $data['lastNumber'], 'disabled']); ?>
                        <?= $this->Form->control('codes', ['type' => 'hidden', 'value' => $data['lastNumber']]); ?> 
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label">Tanggal Pembayaran</label>
                        <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control date', 'type' => 'text', 'autocomplete' => 'off', 'readonly']); ?>
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label">Jenis Pembayaran</label>
                        <?= $this->Form->control('payment_type', ['label' => false, 'class' => 'form-control slc', 'empty' => 'Pilih jenis pembayaran...', 'options' => $this->Krs->payment_type()]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-search fa-lg me-2 text-gray text-opacity-50"></i>
                Cari Invoice
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="col-form-label">Nomor Invoice</label>
                        <?= $this->Form->control('invoice_id', ['label' => false, 'class' => 'form-control slc', 'empty' => 'Pilih nomor order...', 'options' => $invoices, 'data-parsley-required' => true, 'data-parsley-error-message' => 'No Order harus dipilih !', 'id' => 'invoice_id']); ?>
                        <?= $this->Form->control('order_id', ['type' => 'hidden', 'options' => $orders, 'id' => 'order_id']); ?>
                        <?= $this->Form->control('customer_id', ['type' => 'hidden', 'options' => $customers, 'id' => 'customer_id']); ?>
                    </div>
                    <div class="col-md-1">
                        <label class="col-form-label">&nbsp;</label>
                        <div class="btn-group w-100">
                            <?php
                            echo $this->Form->button('<i class="fas fa-search"></i>', array('class' => 'btn btn-yellow', 'type' => 'button', 'id' => 'btnSearch', 'escapeTitle' => false, 'data-toggle' => 'tooltip', 'data-original-title' => "Cari"));
                            ?>
                        </div>
                    </div>
                </div>
                <hr class="mt-4">
                <h6 class="text-inverse">Detail Data</h6>
                <div class="table-responsive" style="overflow: auto;">
                    <div id="tableContainerProduk"></div>
                    <table class="table table-hover table-bordered" id="normal"> 
                        <thead class="bg-gradient-silver">
                            <tr class="text-center">
                                <th width="200">No. Order</th>
                                <th>Customer</th>
                                <th width="150">Kekurangan</th>
                                <th width="150">Status</th>
                                <th width="120">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center" colspan="5">Data Kosong</td>
                            </tr>
                        </tbody> 
                    </table>
                </div>
                <div id="rincian">
                    <hr>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label mb-2">Nominal Pembayaran</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <?= $this->Form->control('presentase', ['label' => false, 'class' => 'form-control text-end discount', 'placeholder' => '0', 'type' => 'number', 'max' => '100', 'min' => '0', 'required' => false]); ?>
                                        <span class="input-group-text input-group-addon"><i class="fas fa-percent"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <?= $this->Form->control('nominals', ['label' => false, 'type' => 'text', 'class' => 'form-control nom price', 'placeholder' => '0', 'value' => '']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label mb-2">Keterangan</label>
                            <?= $this->Form->control('descriptions', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Keterangan...', 'type' => 'textarea']); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-yellow d-flex p-3">
                <?php
                echo $this->Form->button('Simpan', ['class' => 'btn btn-primary  ms-auto', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
                ?>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->end(); ?>

<script>
    let dataArr = [];
    let type = '';
    let itemId = 0;
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }

    const dateFormat = (dateData) => {
        return moment(dateData, 'YYYY-MM-DD').format('DD-MM-YYYY');
    }

    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Receipts', 'action' => 'add'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $('#rincian').hide();

        $('.date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            orientation: 'bottom',
            todayHighlight: true
        }).datepicker('setDate', 'today');

        $('.slc').select2({
            placeholder: "Pilih...",
            position: 'below'
        });

        $('.nom').autoNumeric({
            aSep: '.',
            aDec: ',',
            aPad: false
        });

        $(document).on('click', '#btnSearch', () => {
            $.ajax({
                url: "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Receipts', 'action' => 'setkwitansi']); ?>",
                method: "get",
                dataType: "json",
                data: {
                    invoice: $('#invoice_id').val()
                },
                success: function(data) {
                    $('#normal tbody').html('');
                    $('#rincian').show();

                    // Reset nilai discount dan price
                    $('.discount').val('0');
                    $('.price').val(rupiah(0));

                    let grandTotal = 0;
                    let paymentNominal1 = 0;
                    let paymentNominal2 = 0;
                    let paymentNominal3 = 0;
                    let totalNominal = 0;
                    let kurang;

                    if (data.length > 0) {
                        $.each(data, (i, val) => {
                            grandTotal = parseFloat(val.grandtotal) || 0;
                            paymentNominal1 = parseFloat(val.payment_nominal_1) || 0;
                            paymentNominal2 = parseFloat(val.payment_nominal_2) || 0;
                            paymentNominal3 = parseFloat(val.payment_nominal_3) || 0;
                            totalNominal = paymentNominal1 + paymentNominal2 + paymentNominal3;

                            kurang = grandTotal - totalNominal;

                            // Tentukan status berdasarkan totalNominal dan grandTotal
                            let status;
                            if (totalNominal === 0) {
                                status = 'Belum Bayar';
                            } else if (totalNominal < grandTotal) {
                                status = 'Kurang Bayar';
                            } else if (totalNominal >= grandTotal) {
                                status = 'Lunas';
                                $('#rincian').hide();
                            }

                            let newRow = '<tr class="text-center">' +
                                '<td>' + val.code_order + '</td>' +
                                '<td>' + val.name + '</td>' +
                                '<td>' + rupiah(kurang) + '</td>' +
                                '<td>' + status + '</td>' +
                                '<td>' + dateFormat(val.date) + '</td>' +
                                '</tr>';

                            $('#order_id').val(val.order_id);
                            $('#customer_id').val(val.customer_id);

                            $('#normal tbody').append(newRow);
                        });

                        // Bind event for discount input after appending rows
                        $('.discount').on('input', function() {
                            // Pastikan placeholder tetap 0 saat input kosong
                            if ($(this).val() === '') {
                                $(this).attr('placeholder', '0');
                            } else {
                                $(this).removeAttr('placeholder');
                            }

                            // Validasi nilai input
                            let presentase = parseFloat($(this).val()) || 0;
                            if (presentase < 0) presentase = 0;
                            if (presentase > 100) presentase = 100;

                            let presentaseAmount = (presentase / 100) * kurang; 
                            $('.price').val(rupiah(presentaseAmount)); // Update input price
                        });

                    } else {
                        $('#normal tbody').append('<tr><td class="text-center" colspan="5">Data Kosong</td></tr>');
                    }
                },
                error: function(err) {
                    console.log(err, 'error get data');
                }
            });
        });

    });


</script>
