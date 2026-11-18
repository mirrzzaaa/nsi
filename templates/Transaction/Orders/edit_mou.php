<?php
$dataChild = $this->Html->link('Order', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Ubah') ?>
<?= $this->Form->create($order, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3">
        <div class="row">

            <div class="col-md-4">
                <div class="row">
                    <label class="form-label col-form-label col-md-1"><i class="fas fa-envelope-open-text fa-lg text-gray text-opacity-50"></i></label>
                    <div class="col-md-11">
                        <?= $this->Form->control('po_number', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor po dari customer...']); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <label class="form-label col-form-label col-md-1"><i class="fas fa-user-alt fa-lg text-gray text-opacity-50"></i></label>
                    <div class="col-md-11">
                        <?= $this->Form->control('customer', ['label' => false, 'class' => 'form-control', 'value' => $order->pelanggan->name, 'placeholder' => 'Pilih customer...', 'readonly']); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <label class="form-label col-form-label col-md-1"><i class="fas fa-store fa-lg text-gray text-opacity-50"></i></label>
                    <div class="col-md-11">
                        <?= $this->Form->control('from', ['label' => false, 'class' => 'form-control', 'value' => ($order->branch_id > 0) ? $order->branch->name : $order->warehouse->name, 'readonly']); ?>
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
                        <th width="20%">Harga</th>
                        <th width="10%">Stok</th>
                        <th width="10%">Jumlah</th>
                        <th width="10%">Diskon (%)</th>
                        <th width="15%">Subtotal</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = count($order->order_lines) - 1;
                    foreach ($order->order_lines as $index => $data) { ?>
                        <tr>
                            <td><?= $this->Form->hidden('order_lines[' . $index . '][mouse_item_id]', ['label' => false, 'value' => $data->mouse_item_id]); ?><?= $this->Form->hidden('order_lines[' . $index . '][id]', ['label' => false, 'value' => $data->id]); ?><?= $this->Form->control('mouse_item', ['label' => false, 'class' => 'form-control', 'value' => $data->mouse_item->item->name, 'disabled']); ?></td>
                            <td><?= $this->Form->control('order_lines[' . $index . '][price_t]', ['label' => false, 'class' => 'form-control text-end price', 'placeholder' => '0', 'readonly', 'value' => $this->Krs->_currency($data->price_t), 'disabled']); ?></td>
                            <td><?= $this->Form->control('order_lines[' . $index . '][stock]', ['label' => false, 'class' => 'form-control text-end stock', 'placeholder' => '0', 'disabled', 'value' => $this->Krs->_currency($data->mouse_item->item->stock)]); ?></td>
                            <td><?= $this->Form->control('order_lines[' . $index . '][quantity]', ['label' => false, 'class' => 'form-control text-end quantity', 'placeholder' => '0', 'type' => 'number', 'disabled', 'value' => $this->Krs->_currency($data->quantity)]); ?></td>
                            <td>
                                <div class="input-group"><?= $this->Form->text('order_lines[' . $index . '][discount]', ['label' => false, 'class' => 'form-control text-end discounts', 'placeholder' => '0', 'type' => 'number', 'max' => '100', 'min' => '0', 'step' => '0.1', 'disabled', 'value' => $this->Krs->_currency($data->discount)]); ?><span class="input-group-text input-group-addon"><i class="fas fa-percent"></i></span></div>
                            </td>
                            <td><?= $this->Form->control('order_lines[' . $index . '][subtotal]', ['label' => false, 'class' => 'form-control text-end subtotal', 'placeholder' => '0', 'disabled', 'value' => $this->Krs->_currency($data->subtotal)]); ?></td>
                            <td class="text-center"><?= ($total == $index) ? '<button class="btn btn-inverse btn-sm addRow" id="" type="button"><i class="fas fa-plus-square"></i></button>' : ''; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td width="60%" class="table-info"><strong>Subtotal</strong></td>
                            <td width="40%" class="text-end"><strong><span id="subtotals">0,00</span></strong></td>
                        </tr>
                        <tr>
                            <td width="60%" class="table-info"><strong>Biaya Pengiriman</strong></td>
                            <td width="40%" class="text-end">
                                <?= $this->Form->control('deliver_pays', ['label' => false, 'class' => 'form-control text-end nom ship', 'placeholder' => '0', 'value' => $this->Krs->_currency($order->deliver_pay)]); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="60%" class="table-info"><strong>Diskon (%)</strong></td>
                            <td width="40%" class="text-end">
                                <div class="input-group">
                                    <?= $this->Form->text('discounts', ['label' => false, 'class' => 'form-control text-end discount', 'placeholder' => '0', 'type' => 'number', 'max' => '100', 'min' => '0', 'step' => '0.1', 'value' => $this->Krs->_currency($order->discount)]); ?>
                                    <span class="input-group-text input-group-addon"><i class="fas fa-percent"></i></span>
                                </div>
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


        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });


        var counter = ($('.order tr').length) - 1;
        $(".addRow").on("click", function(e) {
            if (e.originalEvent.defaultPrevented) return;

            var cols = '';
            cols += '<tr>'
            cols += '<td><select class="form-control item" name="order_lines[' + counter + '][mouse_item_id]" data-parsley-required="true" data-parsley-error-message="Produk harus dipilih !" data-parsley-errors-container="#check-produk"><option value="">Pilih produk...</option><?php foreach ($item as $rowItem) : ?><option value="<?= $rowItem['id'] ?>"><?= $rowItem['text'] ?></option><?php endforeach; ?></select><div id="check-produk"></div></td>';
            cols += '<td><input class="form-control text-end price" name="order_lines[' + counter + '][price_t]" type="text" placeholder="0" readonly data-parsley-required="true" data-parsley-error-message="Harga harus diisi !"></td>';
            cols += '<td><input class="form-control text-end stocks" placeholder="0" disabled  name="order_lines[' + counter + '][stock]"></td>';
            cols += '<td><input type="number" min="1" class="form-control text-end qty" placeholder="0" disabled  name="order_lines[' + counter + '][quantity]" data-parsley-required="true" data-parsley-error-message="Jumlah harus diisi !"></td>';
            cols += '<td><div class="input-group"><input type="number" max="100" min="0" step="0.1" class="form-control text-end disc" placeholder="0" disabled  name="order_lines[' + counter + '][discount]"> <span class="input-group-text input-group-addon"><i class="fas fa-percent"></i></span></div></td>';
            cols += '<td><input class="form-control text-end subtotal" type="text" name="order_lines[' + counter + '][subtotal]" id="subtotal' + counter + '" readonly placeholder="0" data-parsley-required="true" data-parsley-error-message="Subtotal harus diisi !"></td>';
            cols += '<td class="text-center"><button class="btn btn-pink btn-sm" id="del" type="button"><i class="far fa-trash-alt"></i></button></td>';
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
                            let price = parseFloat(data[0].price.replace(",", "."));

                            tr.find(".qty").val(1);
                            tr.find('.stocks').val(rupiah(data[1].stock));
                            tr.find(".price").val(rupiah(data[0].price));
                            tr.find('.qty').prop('disabled', false);
                            tr.find('.disc').prop('disabled', false);
                            tr.find('.qty').prop('autofocus', true);

                            tr.find('.subtotal').val(rupiah(tr.find('.qty').val() * price));
                            calculate(0, 0);
                        } else {
                            swal('warning', 'Data kosong !', 'warning');
                        }
                    }
                });
            });


            $(".order").delegate(".qty", "keyup change", function() {
                var tr = $(this).parent().parent();
                var qty = $(this).val();

                var disc = tr.find('.disc').val();

                var price = parseFloat((tr.find('.price').val()).replace(/[^0-9\,]+/g, "").replace(",", "."));
                disc = (price * disc) / 100;

                var priceDisc = price - disc;

                if (qty > parseInt(tr.find('.stocks').val())) {
                    swal('warning', 'Jumlah melebihi stock, harap transaksikan jumlah kurang dari stok', 'warning');
                    qty.val(1);
                }


                tr.find(".subtotal").val(rupiah(qty * priceDisc));
                calculate(0, 0);
            });

            $(".order").delegate(".disc", "keyup change", function() {
                if ($('.disc').val() < 0) $('.disc').val(0);
                if ($('.disc').val() > 100) $('.disc').val(100);

                var disc = $(this).val();
                var tr = $(this).parent().parent().parent();
                var qty = tr.find('.qty').val();

                var price = parseFloat((tr.find('.price').val()).replace(/[^0-9\,]+/g, "").replace(",", "."));
                disc = (price * disc) / 100;

                var priceDisc = price - disc;

                tr.find(".subtotal").val(rupiah(qty * priceDisc));
                calculate(0, 0);
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

        $(".discount").on('keyup change', function() {
            if ($('.discount').val() < 0) $('.discount').val(0);
            if ($('.discount').val() > 100) $('.discount').val(100);

            $('#disc').text($(this).val() + ' ' + '%');
            calculate(0, 0);
        });

    });



    function calculate() {
        var net_total = 0;

        $(".subtotal").each(function(data) {
            net_total = net_total + (parseFloat(($(this).val()).replace(/[^0-9\,]+/g, "").replace(",", ".")) * 1);
        });

        var disc = ($('.discount').val() == '') ? 0 : $('.discount').val();
        var ship = ($('.ship').val() == '') ? 0 : parseFloat(($('.ship').val()).replace(/[^0-9\,]+/g, "").replace(",", "."));
        // var ppn = (($('.ppn').val() == '') || ($('.ppn').val() == '0')) ? 0 : ((11 * net_total) / 100);

        $('#discount').text(disc);
        $('#ship').number(($('.ship').val() == '') ? 0 : parseFloat(($('.ship').val()).replace(/[^0-9\,]+/g, "").replace(",", ".")), 2, ",", ".");

        var total = (net_total + ship);
        var discSubtotal = (total * disc) / 100;
        var subtotal = total - discSubtotal;

        $('#subtotals').number(net_total, 2, ",", ".");
        $('#grandtotal').number((subtotal), 2, ",", ".");
        $('.grandtotal').val((subtotal));
        // $('#tax').number(ppn, 2, ",", ".");
        // $('#grandtotal').number((subtotal + ship + ppn), 2, ",", ".");
        // $('.grandtotal').val((subtotal) + ship + ppn);
        // $('._ppn').val(ppn);
    }
</script>
