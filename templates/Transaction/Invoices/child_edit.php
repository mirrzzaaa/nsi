<?php
// pr($invoice);
$dataChild = $this->Html->link('Invoice Proforma', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Ubah') ?>
<?= $this->Form->create($invoice, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center justify-content-center", style="font-style: italic;">
                <h4>Invoice Parent : &nbsp;<strong><?= $parentInvoiceCode ?></strong></h4>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-receipt fa-lg me-2 text-gray text-opacity-50"></i>   
                Invoice
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="" class="form-label">No. Invoice</label>
                        <?= $this->Form->control('codes', ['label' => false, 'class' => 'form-control', 'value' => $invoice->code, 'disabled']); ?>
                    </div>
                    <div class="col-md-5">
                        <label for="" class="form-label">Tanggal</label> 
                        <div class="input-daterange input-group" id="datepicker">
                            <?= $this->Form->input('dates', ['label' => false, 'class' => 'form-control', 'value' => $this->Krs->fDate($invoice->date, 'd-m-Y'), 'placeholder' => 'Tgl. buat...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Tgl buat harus diisi !']); ?>
                            <span class="input-group-text">s/d</span>
                            <?= $this->Form->input('expireds', ['label' => false, 'class' => 'form-control', 'value' => $this->Krs->fDate($invoice->expired, 'd-m-Y'), 'placeholder' => 'Tgl. jatuh tempo...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Tgl jatuh tempo harus diisi !']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-search fa-lg me-2 text-gray text-opacity-50"></i>
                Data Order
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="col-form-label">Tanggal Order</label>
                        <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control', 'value' => date('d-m-Y', strtotime($invoice->order->date)), 'disabled']); ?>
                    </div>
                    <div class="col-md-4">
                        <label class="col-form-label">No. Order</label>
                        <?= $this->Form->control('order_id', ['label' => false, 'class' => 'form-control', 'disabled']); ?>
                    </div>
                    <div class="col-md-4">
                        <label class="col-form-label">Customer</label>
                        <?= $this->Form->control('customer_id', ['label' => false, 'class' => 'form-control', 'disabled']); ?>
                    </div>
                </div>
                <hr>
                <div class="table-responsive" style="overflow: auto; height: 200px;">
                    <div id="tableContainerProduk"></div>
                    <table class="table table-hover table-bordered order" id="hideTable">
                        <thead class="bg-default">
                            <tr class="text-center">
                                <th width="5%">#</th>
                                <th width="35%">Item</th>
                                <th width="12%">Tgl. Expired</th>
                                <th width="12%">Harga</th>
                                <th width="10%">Jumlah</th>
                                <th width="12%">Diskon</th>
                                <th width="12%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($invoice->order->order_lines as $index => $data) { 
                                $items = $data->item;
                                $itemId = $items->id;
                                $itemName = $items->name;
                                $itemStock = $items->stock;
                                $itemUnit =$items->unit;
                                $idOrderLine = $data->id;
                                $qty = $this->Krs->_currency($data->quantity);
                                $dataQty = $qty . ' ' . $itemUnit;

                                // pr($items);
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no ?></td>
                                    <td><?= (!empty($data->item_id) ? $itemName : '-') ?></td>
                                    <td class="text-center"><?= ($data->expired_date == null ? '-' : date_format($data->expired_date, 'd-m-Y')) ?></td>
                                    <td class="text-end"><?= (!empty($data->price_t) ? $this->Krs->_currency($data->price_t) : '-') ?></td>
                                    <td class="text-center"><?= (!empty($data->item_id) ? $dataQty : '-') ?></td>
                                    <td class="text-end"><?= (!empty($data->discount) ? $this->Krs->_currency($data->discount) : '-') ?></td>
                                    <td class="text-end"><?= (!empty($data->subtotal) ? $this->Krs->_currency($data->subtotal) : '-') ?></td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-8"> <br>
                            <table class="table table-bordered mt-2">
                                <tbody>
                                    <?php
                                    $total = 0; 
                                    foreach ($invoice->order->order_lines as $index => $data) { 
                                        $subtotal = $data->subtotal; 
                                        $total += $subtotal; 
                                    }
                                    ?>
                                    <tr>
                                        <td width="60%" class="table-info"><strong>Total</strong></td>
                                        <td width="40%" class="text-end"><strong><span id="subtotals"><?= $this->Krs->_currency($total) ?></span></strong></td>
                                    </tr>
                                    <tr>
                                        <td width="60%" class="table-info"><strong>Biaya Pengiriman</strong></td>
                                        <td width="40%" class="text-end"><strong><span id="ship"><?= ($invoice->order->deliver_pays == 0 ? '-' : $this->Krs->_currency($invoice->order->deliver_pays))?></span></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="60%" class="table-info"><strong>Ppn (12%)</strong></td>
                                        <td width="40%" class="text-end">
                                            <strong>
                                                <span id="tax">
                                                    <?php 
                                                    // Menghitung PPN
                                                    $ppn = ($total * 11) / 100; 

                                                    // Menampilkan PPN jika ada
                                                    echo ($invoice->order->ppn > 0) ? $this->Krs->_currency($ppn) : '-'; 
                                                    ?>
                                                </span>
                                            </strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="panel bg-info p-3 mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="text-white">Total Tagihan</h3>
                            </div>
                            <div class="col-md-6 text-end">
                                <h3 class="text-white">Rp. <span id="totalTagihan"><?= $this->Krs->_currency($invoice->order->grandtotal) ?></span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <hr> <br>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="form-label">Metode Pembayaran</label>
                            <?= $this->Form->control("proforma_method", ["label" => false, "class" => "form-control ppn slc", "options" => $this->Krs->metodePembayaran(), 'empty' => true]); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="form-label">Nominal Pembayaran</label>
                            <?= $this->Form->control("nominals", ["label" => false, "class" => "form-control text-end nom", "id" => "nominals", "value" => $this->Krs->_currency($invoice->proforma_nominal)]); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="form-label">Ppn</label>
                            <?= $this->Form->control("ppns", ["label" => false, "class" => "form-control ppn", "id" => "ppns", "options" => $this->Krs->_tax(), 'value' => ($invoice->proforma_ppn > 0) ? '1' : '0']); ?>
                            <?= $this->Form->control("grandtotal", ["label" => false, "type" => "hidden", "class" => "form-control total", "id" => "total", "value" => $invoice->grandtotal]); ?>
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
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }

    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Invoices', 'action' => 'childEdit', $invoice->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        datePickerReset('input-daterange', 'resetDateReceive', 'filterDateReceive', 'dd-mm-yyyy');

        $('.input-daterange').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        $('.slc').select2({
            placeholder: "Pilih...",
            position: 'below'
        });

        $('.nom').autoNumeric({
            aSep: '.',
            aDec: ',',
            mDec: '0'
        });

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        // Inisialisasi select2 pada `ppns`
        $('#ppns').select2({
            placeholder: "Pilih...",
            position: 'below'
        });

        // Event listener untuk perubahan pada `ppns`
        $('#ppns').on('change', function() {
            calculate(); // Memanggil fungsi calculate saat nilai ppns berubah
        });

        // Event listener untuk perubahan pada input dengan id yang dimulai dengan `nominals`
        $("input[id^='nominals']").on('change', function() {
            calculate(); // Memanggil fungsi calculate saat nilai nominals berubah
        });

        function calculate() {
            var net_total = 0;

            // Ambil nilai dari input `nominals`
            $("input[id^='nominals']").each(function() {
                // Gantikan koma dengan titik dan konversi ke angka desimal
                net_total += parseFloat(($(this).val()).replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            });

            // Cek dan log nilai `ppns`
            var ppn_value = $('#ppns').val();

            // Hitung ppn dan total
            // var ppn = (ppn_value === '1') ? ((11 * net_total) / 100) : 0;

            var dpp = (ppn_value === '1') ? Math.round((11 * net_total) / 12) : 0;
            var ppn = (ppn_value === '1') ? Math.round((12 * dpp) / 100) : 0;
            var total = (ppn_value === '1') ? (net_total + ppn) : net_total;

            // Update nilai `proforma_total` dan `ppns`
            $('.total').val(total.toFixed(0).replace('.', ','));
            $('.ppns').val(ppn.toFixed(0).replace('.', ','));
        }


        $(document).on('click', '#btnSearch', () => {

            $.ajax({
                url: "<?php echo $this->Url->build(['prefix' => "Transaction", 'controller' => 'Invoices', 'action' => 'getOrder']); ?>",
                method: "GET",
                dataType: "json",
                data: {
                    start: $('#filterstart').val(),
                    end: $('#filterend').val(),
                    customer: $('#customer_id').val(),
                    order: $('#order_id').val()
                },
                success: function(data) {
                    if (data) {
                        $('.orders').val(data.result[0].order_id); 

                        // Tampilkan data produk order
                        displayDataProduk(data);

                        // Sembunyikan data dengan id = hideTable 
                        hideData(data);
                    }

                },
                error: function(err) { 
                    console.log(err, 'error get data');
                }
            });
        });
    });


</script>
