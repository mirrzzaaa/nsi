<?php
$dataChild = $this->Html->link('Order', ['action' => 'index'], ['full_base'=>true]);
//pr($order);

$subtotals = array();
    foreach ($order->order_lines as $index => $value) {
        $subtotals[$index] = is_numeric($value->subtotal) ? $value->subtotal : 0;
    }
    $subtotalSum = array_sum($subtotals);
    $ppn = (is_numeric($order->ppn) && $order->ppn > 0) ? ((11 * $subtotalSum) / 100) : 0;
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Ubah') ?>
<?= $this->Form->create($order, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fas fa-store-alt fa-lg me-2 text-gray text-opacity-50"></i> 
        Order
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label col-form-label"><i class="fas fa-envelope-open-text fa-lg text-gray text-opacity-50"></i>&nbsp; No. PO</label>
                        <?= $this->Form->control('po_number', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor po dari customer...']); ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label col-form-label"><i class="fas fa-user-alt fa-lg text-gray text-opacity-50"></i>&nbsp; Customer</label>
                        <?= $this->Form->control('customer', ['label' => false, 'class' => 'form-control', 'value' => $order->pelanggan->name, 'placeholder' => 'Pilih customer...', 'readonly']); ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label col-form-label"><i class="fas fa-store fa-lg text-gray text-opacity-50"></i>&nbsp; Gudang</label>
                        <?= $this->Form->control('from', ['label' => false, 'class' => 'form-control', 'value' => ($order->branch_id > 0) ? $order->branch->name : $order->warehouse->name, 'readonly']); ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <p>&nbsp;</p>
                        <?= $this->Form->checkbox('with_price', ['label' => false, 'value' => 'N', 'class' => 'form-check-input', 'hiddenField' => true, 'checked' => ($order->with_price == 'N'), 'uncheck' => 'Y']); ?> 
                        <label class="form-check-label text-danger">(Centang jika tanpa harga)</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fa fa-briefcase-medical fa-lg me-2 text-gray text-opacity-50"></i>
        Produk
    </div>
    <div class="card-body">
        <div class="table-responsive mb-3" style="overflow: auto;">
            <table class="table table-hover mb-0 order"> 
                <thead>
                    <tr class="text-center">
                        <th width="30%">Produk</th>
                        <th width="13%">Tgl. Expired</th>
                        <th width="15%">Harga</th>
                        <th width="8%">Stok</th>
                        <th width="8%">Jumlah</th>
                        <th width="13%">Diskon</th>
                        <th width="15%">Subtotal</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = count($order->order_lines) - 1;
                    foreach ($order->order_lines as $index => $data) { 
                        $items = $data->item;
                        $itemId = $items->id;
                        $itemName = $items->name; 
                        $itemStock = $items->stock;
                        $itemUnit =$items->unit;
                        $itemKeterangan = (!empty($data->comment) ? $data->comment : '-');
                        // pr($items);
                        ?>
                        <tr>
                            <td>
                                <?= $this->Form->text('order_lines[' . $index . '][item_name]', ['label' => false, 'type' => 'text', 'class' => 'form-control', 'value' => $itemName, 'disabled']); ?>
                                <?= $this->Form->text('order_lines[' . $index . '][item_id]', ['label' => false, 'type' => 'hidden', 'class' => 'form-control', 'value' => $itemId]); ?>
                            </td>
                            <td><?= $this->Form->text('order_lines[' . $index . '][expired_date]', ['label' => false, 'type' => 'text', 'value' => date('d-m-Y', strtotime($data->expired_date)), 'class' => 'form-control expired']); ?>
                                
                            </td>
                            <td><?= $this->Form->text('order_lines[' . $index . '][price_t]', ['label' => false, 'type' => 'text', 'value' => $this->Krs->_currency($data->price_t), 'class' => 'form-control text-end price']); ?>
                                
                            </td>
                            <td>
                                <?= $this->Form->text('stock', ['label' => false, 'type' => 'text', 'value' => $this->Krs->_currency($itemStock), 'class' => 'form-control text-center', 'disabled']); ?>
                                <?= $this->Form->text('order_lines[' . $index . '][unit]', ['label' => false, 'type' => 'hidden', 'class' => 'form-control', 'value' => $itemUnit]); ?>
                                
                            </td>
                            <td><?= $this->Form->text('order_lines[' . $index . '][quantity]', ['label' => false, 'type' => 'number', 'value' => $this->Krs->_currency($data->quantity), 'class' => 'form-control text-end quantity', 'min' => 1]); ?></td>
                            <td><?= $this->Form->text('order_lines[' . $index . '][discount]', ['label' => false, 'type' => 'text', 'value' => $this->Krs->_currency($data->discount), 'class' => 'form-control text-end diskon']); ?>
                                
                            </td>
                            <td><?= $this->Form->text('order_lines[' . $index . '][subtotal]', ['label' => false, 'type' => 'text', 'value' => $this->Krs->_currency($data->subtotal), 'class' => 'form-control text-end subtotal', 'id' => 'subtotal0']); ?></td>
                            <td class="text-center" rowspan="2"><?= ($total == $index) ? '<button class="btn btn-inverse btn-sm addRow" id="" type="button"><i class="fas fa-plus-square"></i></button>' : ''; ?></td>
                        </tr>
                        <tr>
                            <td colspan="7"><?= $this->Form->text('order_lines[' . $index . '][comment]', ['label' => false, 'class' => 'form-control', 'value' => $itemKeterangan]); ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="form-label">Biaya Pengiriman</label>
                        <?= $this->Form->control('ship_payments', ['label' => false, 'class' => 'form-control text-end nom ship', 'placeholder' => '0', 'value' => $this->Krs->_currency($order->deliver_pays)]); ?>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <label for="" class="form-label">Ppn</label>
                        <?= $this->Form->control('ppns', ['label' => false, 'class' => 'form-control ppn', 'options' => $this->Krs->_tax(), 'value' => ($order->ppn > 0) ? '1' : '0']); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td width="60%" class="table-info"><strong>Total</strong></td>
                            <td width="40%" class="text-end"><strong><span id="subtotals">0,00</span></strong></td>
                        </tr>
                        <tr>
                            <td width="60%" class="table-info"><strong>Biaya Pengiriman</strong></td>
                            <td width="40%" class="text-end"><strong><span id="ship">0,00</span></strong>
                            </td>
                        </tr>
                        <tr>
                            <td width="60%" class="table-info"><strong>Ppn (12%)</strong></td>
                            <td width="40%" class="text-end"><strong><span id="tax">0,00</span></strong>
                            </td>
                        </tr>
                        <tr>
                            <td width="60%" class="table-info"><strong>GRAND TOTAL</strong></td>
                            <td width="40%" class="text-end"><input type="hidden" name="grandtotal" class="grandtotal"><strong><span id="grandtotal">0,00</span></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="form-label">Keterangan</label>
                        <?= $this->Form->control('keterangan', ['label' => false, 'type' => 'textarea', 'class' => 'form-control keterangan', 'value' => (!empty($order->keterangan) ? $order->keterangan : '-')]); ?>
                    </div>
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

<?= $this->Form->end(); ?>

<script>
    let dataArr = [];
    let type = '<?= ($order->branch_id > 0) ? "branch" : "warehouse" ?>';
    let itemId = <?= ($order->branch_id > 0) ? $order->branch_id : $order->warehouse_id ?>;
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }


    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Orders', 'action' => 'edit', $order->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        calculate(0, 0);

        $('.slc').select2({
            placeholder: "Pilih..."
        });

        $('.ppn').select2({
            placeholder: "Pilih salah satu"
        }).on('select2:select', function(e) {
            calculate(0, 0);
        });

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        $('.diskon').autoNumeric({
            aSep: '.',
            aDec: ',',
            aPad: false
        }).on('keyup', function(e) {
            calculate(0, 0);
        });

        // Event listener untuk perubahan harga
        $('.price').autoNumeric({
            aSep: '.',
            aDec: ',',
            aPad: false
        }).on('keyup', function(e) {
            calculate(0, 0);
        });

        $(".order").delegate(".price", "keyup change", function() {
            var tr = $(this).closest('tr'); // Mengidentifikasi baris saat ini
            var qty = parseFloat(tr.find('.quantity').val()) || 0;
            var disc = parseFloat(tr.find('.diskon').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;

            var price = parseFloat($(this).val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            var priceDisc = price - disc;

            var subtotal = qty * priceDisc;

            tr.find('#subtotal0').val(rupiah(subtotal));
            calculate();
        });

        // Event listener untuk perubahan quantity
        $('.order').delegate('.quantity', 'keyup change', function() {
            var tr = $(this).closest('tr');
            var qty = parseFloat($(this).val()) || 0;

            var price = parseFloat(tr.find('.price').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            var disc = parseFloat(tr.find('.diskon').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;

            var priceDisc = price - disc;

            if (qty > parseInt(tr.find('.stock').val())) {
                swal('warning', 'Jumlah melebihi stock, harap transaksikan jumlah kurang dari stok', 'warning');
                qty = 1;
                $(this).val(1);
            }

            var subtotal = qty * priceDisc;
            tr.find('#subtotal0').val(rupiah(subtotal));
            calculate();
        });

        // Event listener untuk perubahan diskon
        $('.order').delegate('.diskon', 'keyup change', function() {
            var tr = $(this).closest('tr'); 
            var disc = parseFloat($(this).val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0
            var qty = parseFloat(tr.find('.quantity').val()) || 0;
            var price = parseFloat(tr.find('.price').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            
            var priceDisc = price - disc;

            var subtotal = qty * priceDisc;

            tr.find('#subtotal0').val(rupiah(subtotal));
            calculate();
        });

        var counter = ($('.order tr').length) - 1;
        $(".addRow").on("click", function(e) {
            if (e.originalEvent.defaultPrevented) return;

            var cols = '';
            cols += '<tr>'
            cols += '<td><select class="form-control item" name="order_lines[' + counter + '][item_id]" data-parsley-required="true" data-parsley-error-message="Produk harus dipilih !" data-parsley-errors-container="#check-produk"><option value="">Pilih produk...</option><?php foreach ($item as $rowItem) : ?><option value="<?= $rowItem['id'] ?>"><?= $rowItem['text'] ?></option><?php endforeach; ?></select><div id="check-item"></div></td>';
            cols += '<td><input class="form-control text-end expired" name="order_lines[' + counter + '][expired_date]" type="text" placeholder="Tgl. Expired"></td>';
            cols += '<td><input class="form-control text-end prices" name="order_lines[' + counter + '][price_t]" type="text" placeholder="0" data-parsley-required="true" data-parsley-error-message="Harga harus diisi !"></td>';
            cols += '<td><input class="form-control text-end stocks text-center" placeholder="0" disabled  name="order_lines[' + counter + '][stock]"></td>';
            cols += '<td><input type="number" min="1" class="form-control text-end qty" placeholder="0" disabled  name="order_lines[' + counter + '][quantity]" data-parsley-required="true" data-parsley-error-message="Jumlah harus diisi !"></td>';

            cols += '<td><input class="form-control text-end disc" placeholder="0" name="order_lines[' + counter + '][discount]" type="text"> <input class="form-control units" name="order_lines[' + counter + '][unit]" type="hidden"> </td>';

            cols += '<td><input class="form-control text-end subtotal subs" type="text" name="order_lines[' + counter + '][subtotal]" id="subtotal' + counter + '" readonly placeholder="0" data-parsley-required="true" data-parsley-error-message="Subtotal harus diisi !"></td>';
            cols += '<td class="text-center" rowspan="2"><button class="btn btn-pink btn-sm" id="del" type="button"><i class="far fa-trash-alt"></i></button></td>';
            cols += '</tr>'
            cols += '<tr>'
            cols += '<td colspan="7"><input class="form-control" name="order_lines[' + counter + '][comment]" type="text" placeholder="Keterangan..."></td>';
            cols += '</tr>';

            // nambah baris didalam tabel
            $(".order>tbody").append(cols);

            $('.item').select2({
                data: dataArr,
                placeholder: 'Pilih produk...'
            }).on('select2:select', function(e) {
                var id = e.params.data.id;
                var tr = $(this).parent().parent();
                $.ajax({
                    url: "<?php echo $this->url->build(['prefix' => 'Transaction', 'controller' => 'Orders', 'action' => 'setitem']); ?>",
                    method: "get",
                    data: {
                        id: id,
                        type: type,
                        itemId: itemId
                    },
                    success: function(data) {
                        if (data) {
                            let prices = parseFloat(data[0].selling_price.replace(",", "."));
                            let date = data[1].expired_date;
                            let formattedDate = date.split('-').reverse().join('-');

                            tr.find(".qty").val(1);
                            tr.find('.stocks').val(rupiah(data[1].stock));
                            tr.find(".prices").val(rupiah(data[0].selling_price));
                            tr.find('.units').val(data[1].unit);
                            tr.find('.expired').val(formattedDate);
                            tr.find('.qty').prop('disabled', false);
                            tr.find('.discount').prop('disabled', false);
                            tr.find('.qty').prop('autofocus', true);
                            tr.find('.disc').prop('disabled', false);
                            $('.diskon').prop('disabled', false);
                            $('.disc').prop('disabled', false);
                            $('.ship').prop('disabled', false);
                            $('.ppn').prop('disabled', false);
                            tr.find('.subtotal').val(rupiah(tr.find('.qty').val() * prices));
                            calculate(0, 0);
                        } else {
                            swal('warning', 'Data kosong !', 'warning');
                        }
                    }
                });
            });

            $('.prices').autoNumeric({
                aSep: '.',
                aDec: ',',
                aPad: false
            }).on('keyup', function(e) {
                calculate(0, 0);
            });

            $('.disc').autoNumeric({
                aSep: '.',
                aDec: ',',
                aPad: false
            }).on('keyup', function(e) {
                calculate(0, 0);
            });

            $(".order").delegate(".disc", "keyup change", function() {
                var tr = $(this).closest('tr'); // Mengambil baris yang terkait dengan elemen diskon
                var disc = parseFloat($(this).val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
                var qty = parseFloat(tr.find('.qty').val()) || 0;
                var prices = parseFloat(tr.find('.prices').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;

                var priceDisc = prices - disc;

                if (!isNaN(priceDisc) && !isNaN(qty)) {
                    tr.find(".subs").val(rupiah(qty * priceDisc)); // Meng-update hanya subtotal di baris terkait
                }

                calculate(0, 0); // Jika ada kalkulasi total di luar subtotal, tetap lakukan
            });

            $(".order").delegate(".qty", "keyup change", function() {
                var tr = $(this).closest('tr'); // Mengambil baris yang terkait dengan elemen kuantitas
                var qty = parseInt($(this).val()) || 0;
                var disc = parseFloat(tr.find('.disc').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
                var prices = parseFloat(tr.find('.prices').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;

                var priceDisc = prices - disc;

                if (qty > parseInt(tr.find('.stocks').val())) {
                    swal('warning', 'Jumlah melebihi stock, harap transaksikan jumlah kurang dari stok', 'warning');
                    $(this).val(1); // Reset ke 1 jika lebih dari stok
                    qty = 1;
                }

                if (!isNaN(priceDisc) && !isNaN(qty)) {
                    tr.find(".subs").val(rupiah(qty * priceDisc)); // Meng-update hanya subtotal di baris terkait
                }

                calculate(0, 0); // Kalkulasi total
            });

            $(".order").delegate(".prices", "keyup change", function() {
                var tr = $(this).closest('tr'); // Mengambil baris yang terkait dengan elemen harga
                var qty = parseFloat(tr.find('.qty').val()) || 0;
                var disc = parseFloat(tr.find('.disc').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
                var prices = parseFloat($(this).val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;

                var priceDisc = prices - disc;

                if (!isNaN(priceDisc) && !isNaN(qty)) {
                    tr.find(".subs").val(rupiah(qty * priceDisc)); // Meng-update hanya subtotal di baris terkait
                }

                calculate(0, 0); // Kalkulasi total
            });

            counter++;
        });

        // Javascript menghapus kalau di klik
        $(document).on("click", "#del", function(event) {
            $(this).closest("tr").remove();
            counter -= 1
            calculate(0, 0);
        });


        $('input.nom').autoNumeric({
            aSep: '.',
            aDec: ','
        }).on('keyup', function(e) {
            calculate(0, 0);
        });

    });

    function calculate() { 
        var net_total = 0;

        // Menghitung total dari elemen dengan kelas .subtotal
        $(".subtotal").each(function(data) {
            net_total = net_total + (parseFloat(($(this).val()).replace(/[^0-9\,]+/g, "").replace(",", ".")) * 1);
        });

        var disc = ($('.diskon').val() == '') ? 0 : $('.diskon').val();
        var ship = ($('.ship').val() == '') ? 0 : parseFloat($('.ship').val().replace(/\./g, '').replace(',', '.'));
        var dpp = (($('.ppn').val() == '') || ($('.ppn').val() == '0')) ? 0 : Math.round((11 * net_total) / 12);
        var ppn = (($('.ppn').val() == '') || ($('.ppn').val() == '0')) ? 0 : Math.round((12 * dpp) / 100);

        $('#disc').text(disc);
        $('#ship').number(($('.ship').val() == '') ? 0 : parseFloat(($('.ship').val()).replace(/[^0-9\,]+/g, "").replace(",", ".")), 2, ",", ".");

        var discSubtotal = (net_total * disc) / 100;
        var subtotal = net_total - discSubtotal;

        $('#subtotals').number(net_total, 2, ",", ".");;
        $('#tax').number(ppn, 2, ",", ".");
        $('#grandtotal').number((net_total + ship + ppn), 2, ",", ".");
        $('.grandtotal').val((net_total) + ship + ppn);
        // $('._ppn').val(ppn);
    }

</script>
