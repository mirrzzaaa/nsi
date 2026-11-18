<?php
$dataChild = $this->Html->link('Invoices', ['action' => 'index'], ['full_base'=>true]);

$orders = $invoice->order;
$orderLines = $invoice->order_line;
$idOrder = $orders->id;
// pr($idOrder);

// foreach ($orders->order_lines as $index => $dataOrderLine) {
//     $idOrderLine = $dataOrderLine->id;
//     pr($idOrderLine);
// }

?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Ubah') ?>
<?= $this->Form->create($invoice, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-receipt fa-lg me-2 text-gray text-opacity-50"></i>  
                Invoice
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="" class="form-label">No. Invoice</label>
                        <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $invoice->code, 'disabled']); ?>
                        <?= $this->Form->control('order_id', ['type' => 'hidden', 'value' => $idOrder]); ?> 
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label">Referensi PO</label>
                        <?= $this->Form->control('referense_po', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Referensi nomor PO...']); ?>
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
                    <div class="col-md-3">
                        <label class="col-form-label">Tanggal Order</label>
                        <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control', 'value' => date('d-m-Y', strtotime($invoice->order->date)), 'disabled']); ?>
                    </div>
                    <div class="col-md-3">
                        <label class="col-form-label">No. Order</label>
                        <?= $this->Form->control('order_id', ['label' => false, 'class' => 'form-control', 'disabled']); ?>
                    </div>
                    <div class="col-md-3">
                        <label class="col-form-label">Customer</label>
                        <?= $this->Form->control('customer_id', ['label' => false, 'class' => 'form-control', 'disabled']); ?>
                        <?= $this->Form->control('grandtotal', ['type' => 'hidden', 'class' => 'total']); ?>
                    </div>
                </div>
                <hr>
                <div class="table-responsive" style="overflow: auto; height: 200px;">
                    <div id="tableContainerProduk"></div>
                    <table class="table table-hover table-bordered order" id="hideTable">
                        <thead class="bg-default">
                            <tr class="text-center">
                                <th width="30%">Item</th>
                                <th width="12%">Tgl. Expired</th>
                                <th width="15%">Harga</th>
                                <th width="10%">Jumlah</th>
                                <th width="13%">Diskon</th>
                                <th width="15%">Subtotal</th>
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
                                    <td>
                                        <?= $this->Form->text('order_lines[' . $index . '][item_name]', ['label' => false, 'type' => 'text', 'class' => 'form-control', 'value' => $itemName, 'disabled']); ?>
                                        <?= $this->Form->text('order_lines[' . $index . '][item_id]', ['label' => false, 'type' => 'hidden', 'class' => 'form-control', 'value' => $itemId]); ?>
                                        <?= $this->Form->text('order_lines[' . $index . '][order_line_id]', ['type' => 'hidden', 'value' => $idOrderLine]); ?>
                                    </td>
                                    <td><?= $this->Form->text('order_lines[' . $index . '][expired_date]', ['label' => false, 'type' => 'text', 'value' => date('d-m-Y', strtotime($data->expired_date)), 'class' => 'form-control text-center expired']); ?>
                                        
                                    </td>
                                    <td><?= $this->Form->text('order_lines[' . $index . '][price_t]', ['label' => false, 'type' => 'text', 'value' => $this->Krs->_currency($data->price_t), 'class' => 'form-control text-end price']); ?>
                                        
                                    </td>
                                    <td>
                                        <?= $this->Form->text('order_lines[' . $index . '][quantity]', ['label' => false, 'type' => 'text', 'value' => $qty, 'class' => 'form-control text-center quantity']); ?>
                                        <?= $this->Form->text('order_lines[' . $index . '][unit]', ['label' => false, 'type' => 'hidden', 'class' => 'form-control', 'value' => $itemUnit]); ?>
                                    </td>
                                    <td><?= $this->Form->text('order_lines[' . $index . '][discount]', ['label' => false, 'type' => 'text', 'value' => $this->Krs->_currency($data->discount), 'class' => 'form-control text-end nom diskon']); ?>
                                        
                                    </td>
                                    <td><?= $this->Form->text('order_lines[' . $index . '][subtotal]', ['label' => false, 'type' => 'text', 'value' => $this->Krs->_currency($data->subtotal), 'class' => 'form-control text-end subtotal', 'id' => 'subtotal0' . $index]); ?>
                                    </td>


                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-label">Biaya Pengiriman</label>
                                    <?= $this->Form->control("orders[0][ship_payments]", ["label" => false, "class" => "form-control text-end nom ship", "placeholder" => "0", 'value' => $this->Krs->_currency($orders->deliver_pays)]); ?>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Ppn</label>
                                    <?= $this->Form->control("ppns", ["label" => false, "class" => "form-control ppn slc", "options" => $this->Krs->_tax(), 'value' => ($invoice->ppn > 0) ? '1' : '0']); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8"> <br>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td width="60%" class="table-info"><strong>Total</strong></td>
                                        <td width="40%" class="text-end"><strong><span id="subtotals">0</span></strong></td>
                                    </tr>
                                    <tr>
                                        <td width="60%" class="table-info"><strong>Biaya Pengiriman</strong></td>
                                        <td width="40%" class="text-end"><strong><span id="ship">0</span></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="60%" class="table-info"><strong>Ppn (12%)</strong></td>
                                        <td width="40%" class="text-end"><strong><span id="tax">0</span></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel bg-info p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="text-white">Total Tagihan</h3>
                            </div>
                            <div class="col-md-6 text-end">
                                <h3 class="text-white">Rp. <span id="totalTagihan">0</span></h3>
                            </div>
                        </div>
                    </div>
                </div> <br>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="form-label">Metode Pembayaran</label>
                            <?= $this->Form->control("dp_method", ["label" => false, "class" => "form-control slc", "options" => $this->Krs->metodePembayaran(), 'empty' => true]); ?> 
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="form-label">Nominal Pembayaran</label>
                            <?= $this->Form->control("nominals", ["label" => false, "class" => "form-control text-end nom", "id" => "nominals", "value" => $this->Krs->_currency($invoice->dp_nominal)]); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="form-label">Ppn</label>
                            <?= $this->Form->control("dp_ppns", ["label" => false, "class" => "form-control ppn", "id" => "ppns", "options" => $this->Krs->_tax(), 'value' => ($invoice->dp_ppn > 0) ? '1' : '0']); ?>
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

<?= $this->Form->end(); ?>

<script>
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }

    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Invoices', 'action' => 'edit', $invoice->id], ['fullBase' => true]); ?>";
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


        $('input.nom').autoNumeric({
            aSep: '.',
            aDec: ',',
            mDec: '0'
        }).on('keyup', function(e) {
            calculate(0, 0);
        });


        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        $('.ppn').select2({
            placeholder: "Pilih salah satu"
        }).on('select2:select', function(e) {
            calculate(0, 0);
        });

        $('.price').autoNumeric({
            aSep: '.',
            aDec: ',',
            aPad: false
        }).on('keyup', function(e) {
            calculate(0, 0);
        });

        calculateSubtotals();

       $(".order").delegate(".price", "keyup change", function() {
            var tr = $(this).closest('tr');
            var qty = tr.find('.quantity').val();
            var disc = parseFloat(tr.find('.diskon').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            var price = parseFloat(tr.find('.price').val().replace(/[^0-9\,]+/g, "").replace(",", "."));
            var priceDisc = price - disc;

            $("#subtotal0" + tr.index()).val(rupiah(qty * priceDisc));
            calculate(0, 0);
        });

        $(".order").delegate(".quantity", "keyup change", function() {
            var tr = $(this).closest('tr');
            var qty = $(this).val();
            var disc = parseFloat(tr.find('.diskon').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            var price = parseFloat(tr.find('.price').val().replace(/[^0-9\,]+/g, "").replace(",", "."));
            var priceDisc = price - disc;

            if (qty > parseInt(tr.find('.stock').val())) {
                swal('warning', 'Jumlah melebihi stock, harap transaksikan jumlah kurang dari stok', 'warning');
                $(this).val(1);
                qty = 1;
            }

            $("#subtotal0" + tr.index()).val(rupiah(qty * priceDisc));
            calculate(0, 0);
        });

        $(".order").delegate(".diskon", "keyup change", function() {
            var tr = $(this).closest('tr');
            var disc = parseFloat(tr.find('.diskon').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            var qty = tr.find('.quantity').val();
            var price = parseFloat(tr.find('.price').val().replace(/[^0-9\,]+/g, "").replace(",", "."));
            var priceDisc = price - disc;

            $("#subtotal0" + tr.index()).val(rupiah(qty * priceDisc));
            calculate(0, 0);
        });

        $(".order").delegate(".price, .quantity, .diskon", "keyup change", function() {
            var tr = $(this).closest('tr');
            var qty = parseFloat(tr.find('.quantity').val()) || 0;
            var disc = parseFloat(tr.find('.diskon').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            var price = parseFloat(tr.find('.price').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            var priceDisc = price - disc;

            if (qty > parseInt(tr.find('.stock').val())) {
                swal('warning', 'Jumlah melebihi stock, harap transaksikan jumlah kurang dari stok', 'warning');
                tr.find('.quantity').val(1);
                qty = 1;
            }

            // Update subtotal dengan ID dinamis
            var index = tr.index(); // Mengambil indeks baris
            $("#subtotal0" + index).val(rupiah(qty * priceDisc));
            
            calculate(); // Memanggil fungsi calculate untuk menghitung total
        });

    });

    function calculateSubtotals() {
        var net_total = 0;
        
        // Menghitung total nilai dari semua elemen subtotal
        $("input[id^='subtotal0']").each(function() {
            var subtotal = parseFloat($(this).val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            net_total += subtotal;
        });

        // Mengambil nilai biaya pengiriman
        var ship = ($('.ship').val() == '') ? 0 : parseFloat($('.ship').val().replace(/[^0-9\,]+/g, "").replace(",", "."));
        
        // Menghitung PPN 11%
        var ppn = (($('.ppn').val() == '') || ($('.ppn').val() == '0')) ? 0 : ((11 * net_total) / 100);

        // Menghitung total tagihan akhir (subtotal + pengiriman + ppn)
        var totalTagihan = net_total + ship + ppn;

        // Memperbarui elemen HTML dengan nilai yang dihitung
        $("#subtotals").text(rupiah(net_total));  // Total Subtotal
        $("#ship").text(rupiah(ship));            // Biaya Pengiriman
        $("#tax").text(rupiah(ppn));              // PPN
        $("#totalTagihan").text(rupiah(totalTagihan));  // Total Tagihan Akhir
    }


    function calculate() {
        var net_total = 0;

        // Menghitung total nilai dari semua elemen subtotal
        $("input[id^='subtotal0']").each(function() {
            net_total += parseFloat(($(this).val()).replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
        });

        // Proses hitung lainnya...
        var ship = ($('.ship').val() == '') ? 0 : parseFloat($('.ship').val().replace(/[^0-9\,]+/g, "").replace(",", "."));
        var dpp = (($('.ppn').val() == '') || ($('.ppn').val() == '0')) ? 0 : Math.round((11 * net_total) / 12);
        var ppn = (($('.ppn').val() == '') || ($('.ppn').val() == '0')) ? 0 : Math.round((12 * dpp) / 100);

        $('#ship').number(($('.ship').val() == '') ? 0 : parseFloat($('.ship').val().replace(/[^0-9\,]+/g, "").replace(",", ".")), 0, ",", ".");

        $('#subtotals').number(net_total, 0, ",", ".");
        $('#tax').number(ppn, 0, ",", ".");
        $('#grandtotal').number((net_total + ship + ppn), 0, ",", ".");
        $('.grandtotal').val((net_total + ship + ppn).toFixed(0).replace('.', ','));
        $('#totalTagihan').number((net_total + ship + ppn), 0, ",", ".");
        $('.total').val((net_total + ship + ppn).toFixed(0).replace('.', ','));
        $('.ppns').val(ppn);
    }


</script>
