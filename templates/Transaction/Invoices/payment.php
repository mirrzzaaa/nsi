<?php
$dataChild = $this->Html->link('Invoice', ['action' => 'index'], ['full_base'=>true]);

// pr($invoices);

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
            <div class="col-md-3">
                <label for="" class="form-label">No. Invoice</label> 
                <?= $this->Form->control('filtercode', ['label' => false, 'class' => 'form-control', 'value' => $this->request->getQuery('filtercode'), 'placeholder' => 'Masukkan nomor invoice...']); ?>
            </div>

            <div class="col-md-3">
                <label for="" class="form-label">Customer</label>
                <?= $this->Form->control('filtercustomer', ['label' => false, 'class' => 'form-control slc', 'value' => $this->request->getQuery('filtercustomer'), 'data-placeholder' => 'Pilih customer...', 'empty' => 'Pilih customer...', 'options' => $customers]); ?>
            </div>

            <div class="col-md-5">
                <label for="" class="form-label">Tgl. Invoice</label>
                <div class="input-daterange input-group" id=" date-picker">
                    <?php
                    echo $this->Krs->inputDateRange('filterstart', array("class" => "form-control filterDateReceive", 'id' => 'start', 'readonly' => true, 'placeholder' => 'Tgl. mulai..', 'value' => $this->request->getQuery('filterstart')), 'filterend', array("class" => "form-control filterDateReceive", 'id' => 'end', 'readonly' => true, 'placeholder' => 'Tgl. sampai..', 'value' => $this->request->getQuery('filterend')), 's/d', 'resetDateReceive');
                    ?> 
                </div>
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
    <?php
$showPanel = false; // Variabel untuk menentukan apakah panel harus ditampilkan

foreach ($invoices as $index => $rowInvoice) {
    $payment1 = $rowInvoice->payment_nominal_1;
    $payment2 = $rowInvoice->payment_nominal_2;
    $payment3 = $rowInvoice->payment_nominal_3;
    $totalPayment = $payment1 + $payment2 + $payment3;
    $grandTotal = $rowInvoice->order->grandtotal;

    // Mengecek apakah total pembayaran sama dengan grand total
    if ($totalPayment < $grandTotal) {
        $showPanel = true;
        break; // Keluar dari loop jika panel perlu ditampilkan
    }
}

if ($showPanel): ?>
    <div class="panel panel-inverse rekap">
        <div class="panel-heading ui-sortable-handle">
            <h4 class="panel-title">Data Invoice Masuk</h4>
        </div>
        <div class="card border-0 mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">#</th>
                                <th width="20%">Pembayaran</th>
                                <th width="20%">PPh 23</th>
                                <th width="20%">PPn 900</th> 
                                <th width="20%">Biaya Bank</th>
                                <th width="15%">Selisih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($invoices as $index => $rowInvoice) {
                                $ppn = 0;
                                if ($rowInvoice->order->pelanggan->ppn == 1) {
                                    $ppn = (($rowInvoice->order->grandtotal * 11) / 100);
                                } else {
                                    $ppn = 0;
                                }
                                $total = $rowInvoice->order->grandtotal;

                                $grandTotal = $rowInvoice->grandtotal;
                                $payment1 = $rowInvoice->payment_nominal_1;
                                $payment2 = $rowInvoice->payment_nominal_2;
                                $payment3 = $rowInvoice->payment_nominal_3;
                                $totalPayment = $payment1 + $payment2 + $payment3;
                                $kekurangan = $grandTotal - $totalPayment;

                                // Mengecek kondisi dan menetapkan status pembayaran
                                if ($totalPayment === null || $totalPayment == 0) {
                                    $statusPayment = 'Belum Bayar';
                                } elseif ($totalPayment < $grandTotal) {
                                    $statusPayment = 'Kurang Bayar';
                                } elseif ($totalPayment == $grandTotal) {
                                    $statusPayment = 'Lunas';
                                } else {
                                    $statusPayment = 'Status tidak ditemukan'; 
                                }

                                $showKekuranganColumn = ($totalPayment < $grandTotal && $totalPayment != null && $totalPayment != 0);
                                $paymentType = ($totalPayment == $grandTotal) ? 'Normal' : 'Termin';
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td colspan="5">
                                        <table class="table table-hover table-bordered table-td-valign-middle table-striped">
                                            <thead class="bg-info">
                                                <tr class="text-center">
                                                    <th width="200">No. Invoice</th>
                                                    <th width="150">Tgl. Invoice</th>
                                                    <th width="300">Customer</th>
                                                    <th width="200">Status</th>
                                                    <?php if ($showKekuranganColumn): ?>
                                                        <th width="150">Kekurangan</th>
                                                    <?php endif; ?>
                                                    <th width="200">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center"><strong><?= $rowInvoice->code ?></strong></td>
                                                    <td class="text-center"><?= ($rowInvoice->date == null) ? '-' : date_format($rowInvoice->date, 'd-m-Y') ?></td>
                                                    <td class="text-center"><span class="badge border border-dark text-dark px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i><?= (!empty($rowInvoice->order) ? $rowInvoice->order->pelanggan->name : '-') ?></span></td>
                                                    <td class="text-center"><strong><?= $statusPayment; ?></strong></td>
                                                    <?php if ($showKekuranganColumn): ?>
                                                        <td class="text-center"><strong><?= $this->Krs->_currency($kekurangan); ?></strong></td>
                                                    <?php endif; ?>
                                                    <td class="text-center"><strong><?= $this->Krs->_currency($total); ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <input type="text" class="form-control" name="data[<?= $rowInvoice->id ?>][payment_desc]" placeholder="Keterangan...">
                                                        <input type="hidden" class="form-control" name="data[<?= $rowInvoice->id ?>][payment_type]" value="<?= $paymentType ?>">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr class="sum">
                                    <td>&nbsp;</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" name="data[<?= $rowInvoice->id ?>][payment_date]" class="form-control mb-2" id="Data<?= $rowInvoice->id ?>Delivery" placeholder="Tgl. pembayaran..." readonly>
                                            <button type="button" class="btn btn-inverse mb-2" id="Reset<?= $rowInvoice->id ?>Delivery" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="data[<?= $rowInvoice->id ?>][payment_jumlah]" class="form-control mb-2 nominal nominalPayment" placeholder="Nominal jumlah...">
                                        <?= $this->Form->control('data[' . $rowInvoice->id . '][payment_method]', ['label' => false, 'class' => 'form-control mb-2 slc', 'data-placeholder' => 'Metode pembayaran...', 'empty' => 'Metode pembayaran...', 'options' => $this->Krs->methodPayment()]); ?>

                                        <?= $this->Form->control('data[' . $rowInvoice->id . '][grandtotal_nominal]', ['type' => 'hidden', 'value' => $this->Krs->_currency($total)]); ?>

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
                                        <!-- PPh 23 -->
                                        <div class="input-group">
                                            <input type="text" name="data[<?= $rowInvoice->id ?>][pph_date]" class="form-control mb-2" id="Data<?= $rowInvoice->id ?>Pph" placeholder="Tgl. pph 23..." readonly>
                                            <button type="button" class="btn btn-inverse mb-2" id="Reset<?= $rowInvoice->id ?>Pph" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="data[<?= $rowInvoice->id ?>][pph_jumlah]" class="form-control mb-2 nominal nominalPPh" placeholder="Nominal pph 23...">
                                        <input type="text" name="data[<?= $rowInvoice->id ?>][pph_no]" class="form-control mb-2" placeholder="Nomor pph 23...">
                                        <script>
                                            $(function() {
                                                $.datepicker.setDefaults($.datepicker.regional['id']);
                                                $('#Data<?= $rowInvoice->id ?>Pph').datepicker({
                                                    format: 'dd-mm-yyyy',
                                                    autoclose: true,
                                                    orientation: 'bottom',
                                                    todayHighlight: !0
                                                });
                                                $('#Reset<?= $rowInvoice->id ?>Pph').on('click', function() {
                                                    $('#Data<?= $rowInvoice->id ?>Pph').val('');
                                                });
                                            });
                                        </script>
                                    </td>
                                    <td>
                                        <!-- PPn 900 -->
                                        <div class="input-group">
                                            <input type="text" name="data[<?= $rowInvoice->id ?>][ppn_900_date]" class="form-control mb-2 tgl" id="Data<?= $rowInvoice->id ?>Ppn" placeholder="Tgl. ppn 900..." readonly>
                                            <button type="button" class="btn btn-inverse mb-2" id="Reset<?= $rowInvoice->id ?>Ppn" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="data[<?= $rowInvoice->id ?>][ppn_900_jumlah]" class="form-control mb-2 nominal nominalPpn900" placeholder="Nominal ppn 900...">&nbsp;<br>&nbsp;

                                        <script>
                                            $(function() {
                                                $.datepicker.setDefaults($.datepicker.regional['id']);
                                                $('#Data<?= $rowInvoice->id ?>Ppn').datepicker({
                                                    format: 'dd-mm-yyyy',
                                                    autoclose: true,
                                                    orientation: 'bottom',
                                                    todayHighlight: !0
                                                });
                                                $('#Reset<?= $rowInvoice->id ?>Ppn').on('click', function() {
                                                    $('#Data<?= $rowInvoice->id ?>Ppn').val('');
                                                });
                                            });
                                        </script>
                                    </td>
                                    <td><input type="text" name="data[<?= $rowInvoice->id ?>][biaya_bank]" class="form-control mb-2 nominal nominalBiayaBank" placeholder="Biaya bank...">
                                        <input type="hidden" name="data[<?= $rowInvoice->id ?>][jumlah_nominal]" class="form-control mb-2 nominal nominalJumlah" placeholder="Jumlah nominal...">
                                        <input type="text" name="data[<?= $rowInvoice->id ?>][pembulatan]" class="form-control mb-2 pembulatan nominalPembulatan" placeholder="Pembulatan..."><br>&nbsp;<br>&nbsp;<br>
                                    </td>

                                    <td class="table-danger text-center paymentColor">
                                        <?php if ($totalPayment === null || $totalPayment == 0): ?>
                                            <h3 class="totalPayment"><?= $this->Krs->_currency($total); ?></h3>
                                            <?php $inputValue = $total; ?>
                                        <?php elseif ($totalPayment < $grandTotal): ?>
                                            <h3 class="totalPayment"><?= $this->Krs->_currency($kekurangan); ?></h3>
                                            <?php $inputValue = $kekurangan; ?>
                                        <?php elseif ($totalPayment == $grandTotal): ?>
                                            <h3 class="totalPayment">0,00</h3>
                                            <?php $inputValue = 0.00; ?>
                                        <?php endif; ?>
                                        <input type="hidden" name="data[<?= $rowInvoice->id ?>][grandtotal]" class="grandTotal" value="<?= $this->Krs->_currency($inputValue) ?>">
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
        </div>
    </div>
    <?php endif; ?>

    <?php
    $grandTotal = $rowInvoice->grandtotal;
    $totalNominal = 0;

    foreach ($invoices as $index => $rowInvoices) {
        $receipts = $rowInvoices->receipts; 
        foreach ($receipts as $receipt) { 
            $totalNominal += $receipt->nominal; // Tambahkan nominal dari setiap receipt
        }
    }

    // Tentukan status pembayaran
    $statusPembayaran = ($totalNominal >= $grandTotal) ? 'LUNAS' : 'BELUM LUNAS';
    ?>

    <div class="panel panel-inverse rekap">
        <div class="panel-heading ui-sortable-handle">
            <h4 class="panel-title">Riwayat Pembayaran</h4>
        </div>
        <div class="card border-0 mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <?php
                    // Pastikan receipt_id adalah bagian dari $invoice
                    if ($rowInvoices->payment_nominal_1 !== null): ?>
                        <h6 class="text-end" style="margin-right: 10px;">
                            Status Pembayaran : <strong><?= $statusPembayaran; ?></strong>
                        </h6>
                    <?php endif; ?>
                    <table class="table table-hover table-bordered table-striped">
                        <thead class="bg-info">
                            <tr class="text-center">
                                <th width="40%">No. Kuitansi</th>
                                <th width="20%">Pembayaran</th>
                                <th width="20%">Tanggal</th>
                                <th width="20%">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        foreach ($invoices as $index => $rowInvoices) {
                            $receipts = $rowInvoices->receipts; 
                            $hasReceipts = false; // Flag untuk memeriksa apakah ada pembayaran
                            
                            foreach ($receipts as $receipt) { 
                                $hasReceipts = true;
                                ?>
                                <tr>
                                    <td><?= !empty($receipt->code) ? ($receipt->code) : '-' ?></td>
                                    <td class="text-center"><?= !empty($receipt->payment_type) ? ($receipt->payment_type) . ' ' . $no++ : '-' ?></td>
                                    <td class="text-center"><?= !empty($receipt->date) ? $this->Krs->fDate($receipt->date, 'd-m-Y') : '-' ?></td>
                                    <td class="text-end" style="padding-right: 60px;"><?= !empty($receipt->nominal) ? $this->Krs->_currency($receipt->nominal) : '-' ?></td>
                                </tr>
                                <?php
                            }

                            // Jika tidak ada pembayaran, tampilkan baris informasi
                            if (!$hasReceipts) {
                                ?>
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada pembayaran</td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer bg-yellow d-flex p-3">
        <?php
        echo $this->Form->button('Simpan', ['class' => 'btn btn-primary  ms-auto', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
        ?>
    </div>

<?php
}
?>
<?= $this->Form->end() ?>
<script>
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Invoices', 'action' => 'payment'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

        datePickerReset('input-daterange', 'resetDateReceive', 'filterDateReceive', 'dd-mm-yyyy');

        $('.slc').select2({
            placeholder: 'Pilih data...',
            allowClear: true,
        });

        $('input.nominal').autoNumeric({
            aSep: '.',
            aDec: ',',
            vMin: '-9999999999999.99',
            vMax: '9999999999999.99'
        });

        $('input.pembulatan').autoNumeric({
            aSep: '.',
            aDec: ',',
            vMin: '-9999999999999.99',
            vMax: '9999999999999.99'
        });

        function calcRow() {
            var overall = 0;

            $("tr.sum").each(function() {

                var nominalGrandTotal = $(this).find(".grandTotal");

                var nominalPpn900 = $(this).find(".nominalPpn900");
                var nominalPayment = $(this).find(".nominalPayment");
                var nominalPPh = $(this).find(".nominalPPh");
                var nominalBiayaBank = $(this).find(".nominalBiayaBank");
                var nominalPembulatan = $(this).find(".nominalPembulatan");

                nominalGrandTotal = parseFloat(nominalGrandTotal.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                nominalPpn900 = parseFloat(nominalPpn900.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                nominalPayment = parseFloat(nominalPayment.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                nominalPPh = parseFloat(nominalPPh.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                nominalBiayaBank = parseFloat(nominalBiayaBank.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                nominalPembulatan = parseFloat(nominalPembulatan.val().replace(/[^0-9\,-]+/g, "").replace(",", "."));

                var jumlah = nominalPayment + nominalPpn900 + nominalBiayaBank + nominalPembulatan + nominalPPh;
                $(this).find(".nominalJumlah").val(jumlah.toFixed(2).replace(".", ","));

                if (isNaN(nominalGrandTotal)) {
                    nominalGrandTotal = 0;
                }

                if (isNaN(nominalPpn900)) {
                    nominalPpn900 = 0;
                }

                if (isNaN(nominalPayment)) {
                    nominalPayment = 0;
                }

                if (isNaN(nominalPPh)) {
                    nominalPPh = 0;
                }

                if (isNaN(nominalBiayaBank)) {
                    nominalBiayaBank = 0;
                }

                if (isNaN(nominalPembulatan)) {
                    nominalPembulatan = 0;
                }

                var sum = nominalGrandTotal - nominalPpn900 - nominalPayment - nominalBiayaBank - nominalPembulatan - nominalPPh;
                //  var sum = parseFloat(nominalGrandTotal.val()) - parseFloat(nominalPayment.val()) - parseFloat(nominalPPh.val());

                if (isNaN(sum)) {
                    sum = 0;
                }

                var sums = parseFloat(sum).toFixed(2);
                var rus = sums.replace(/\./g, ',');
                $(this).find(".totalPayment").number(rus, 2, ",", ".");

                if (sums == nominalGrandTotal || sums < 0) {
                    $(this).find(".paymentColor").remove('table-success');
                    $(this).find(".paymentColor").addClass('table-danger');
                } else if (sums == 0) {
                    $(this).find(".paymentColor").removeClass('table-danger');
                    $(this).find(".paymentColor").addClass('table-success');
                } else {
                    $(this).find(".paymentColor").css("background-color", "");
                }

            });

        }

        $(function() {

            calcRow();
            $('input.nominalPayment').bind('change keyup', function() {
                calcRow();
            });
            $('input.nominalPpn900').bind('change keyup', function() {
                calcRow();
            });
            $('input.nominalPPh').bind('change keyup', function() {
                calcRow();
            });
            $('input.nominalBiayaBank').bind('change keyup', function() {
                calcRow();
            });
            $('input.nominalPembulatan').bind('change keyup', function() {
                calcRow();
            });

        });
    });
</script>
