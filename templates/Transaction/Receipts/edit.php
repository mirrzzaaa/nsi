<?php

// pr($receipt);

$dataChild = $this->Html->link('Kwitansi', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Ubah') ?>
<?= $this->Form->create($receipt, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>  

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
                        <?= $this->Form->control('codes', ['label' => false, 'class' => 'form-control', 'value' => $receipt->code, 'disabled']); ?>
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label">Tanggal Pembayaran</label>
                        <?= $this->Form->control('date', ['label' => false, 'class' => 'form-control date', 'value' => $this->Krs->fDate($receipt->date, 'd-m-Y'), 'type' => 'text', 'autocomplete' => 'off', 'disabled']); ?>
                    </div>
                    <!-- <div class="col-md-4">
                        <label for="" class="form-label">Jenis Pembayaran</label>
                        $this->Form->control('payment_type', ['label' => false, 'class' => 'form-control', 'empty' => 'Pilih jenis pembayaran...', 'value' => $receipt->payment_type, 'disabled']); 
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-receipt fa-lg me-2 text-gray text-opacity-50"></i>
                Data Invoice
            </div>
            <div class="card-body">
                <div class="row">
                        <?= $this->Form->control('order_id', ['type' => 'hidden', 'options' => $orders, 'id' => 'order_id']); ?>
                        <?= $this->Form->control('customer_id', ['type' => 'hidden', 'options' => $customers, 'id' => 'customer_id']); ?>
                </div>
                <div class="table-responsive" style="overflow: auto;">
                    <div id="tableContainerProduk"></div>
                    <table class="table table-hover table-bordered" id="normal">
                        <thead class="bg-gradient-silver">
                            <tr class="text-center">
                                <th width="200">No. Invoice</th>
                                <th>Customer</th>
                                <th width="150">Kekurangan</th>
                                <th width="150">Status</th>
                                <th width="120">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $paymentTotal = 0; 
                            ?>
                            <tr class="text-center">
                                <td><?= !empty($receipt->invoice_id) ? $receipt->invoice->code : '-'; ?></td>
                                <td><?= !empty($receipt->customer_id) ? $receipt->customer->name : '-'; ?></td>
                                <td>
                                    <?php 
                                        $payment1 = $receipt->payment_jumlah_1;
                                        $payment2 = $receipt->payment_jumlah_2;
                                        $payment3 = $receipt->payment_jumlah_3;
                                        $paymentTotal += $payment1 + $payment2 + $payment3;
                                        $dataGrandtotal = $receipt->nominal;
                                        $grandtotals = $dataGrandtotal - $paymentTotal;
                                    echo $this->Krs->_currency($grandtotals);  
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($paymentTotal < $grandtotals) {
                                        echo "Belum Lunas";
                                    } else {
                                        echo "Lunas";
                                    }
                                    ?>
                                </td>
                                <td><?= $receipt->date ? $this->Krs->fDate($receipt->date, 'd-m-Y') : ''; ?></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                <div id="rincian">
                    <hr>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label mb-2">Nominal Pembayaran</label>
                            <?= $this->Form->control('nominals', ['label' => false, 'type' => 'text', 'class' => 'form-control nom price', 'placeholder' => '0', 'value' => $this->Krs->_currency($receipt->nominal)]); ?>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="" class="form-label mb-2">Keterangan</label>
                            <?= $this->Form->control('descriptions', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Keterangan...', 'type' => 'text', 'value' => $receipt->description]); ?>
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
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Receipts', 'action' => 'edit', $receipt->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $('#rincian').show();

        $('.date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            orientation: 'bottom',
            todayHighlight: true
        });

        $('.slc').select2({
            placeholder: "Pilih...",
            position: 'below'
        });

        $('.nom').autoNumeric({
            aSep: '.',
            aDec: ',',
            aPad: false
        });

        var grandTotal = <?= $dataGrandtotal; ?>;

        $('.discount').on('input', function() {
            // Pastikan placeholder tetap 0 saat input kosong
            if ($(this).val() === '') {
                $(this).attr('placeholder', '0');
            } else {
                $(this).removeAttr('placeholder');
            }

            // Validasi nilai input
            if ($('.discount').val() < 0) $('.discount').val(0);
            if ($('.discount').val() > 100) $('.discount').val(100);

            let presentase = parseFloat($(this).val()) || 0; // Ambil nilai presentase
            let nominalPresentase = (presentase / 100) * grandTotal; // Hitung jumlah presentase
            $('.price').val(rupiah(nominalPresentase)); // Update input price
        });

    });


</script>
