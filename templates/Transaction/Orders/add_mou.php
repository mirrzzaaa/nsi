<?php
$dataChild = $this->Html->link('Order', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Buat') ?>
<?= $this->Form->create($order, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3">
        <div class="row"> 

            <div class="col-md-3">
                <label for="" class="form-label">No. PO</label>
                <?= $this->Form->control('po_number', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor po dari customer...']); ?>
            </div>

            <div class="col-md-3">
                <label for="" class="form-label">Customer</label>
                <?= $this->Form->control('customer_id', ['label' => false, 'class' => 'form-control cs', 'options' => $customers, 'data-placeholder' => 'Pilih customer...', 'empty' => 'Pilih customer...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Customer harus dipilih !', 'data-parsley-errors-container' => '#check-cs']); ?>
                <div id="check-cs"></div>
            </div>

            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio" id="radio1" disabled />
                    <label class="text-danger form-label" for="">Pilih jika order di toko</label>
                </div>
                <?= $this->Form->control('branch_id', ['label' => false, 'class' => 'form-control branch', 'options' => $branches, 'data-placeholder' => 'Pilih toko...', 'empty' => 'Pilih toko...', 'disabled']); ?>
            </div>

            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio" id="radio2" disabled />
                    <label class="text-danger form-label" for="">Pilih jika order di gudang</label>
                </div>
                <?= $this->Form->control('warehouse_id', ['label' => false, 'class' => 'form-control warehouse', 'options' => $warehouses, 'data-placeholder' => 'Pilih gudang...', 'empty' => 'Pilih gudang...', 'disabled']); ?>
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
            <table class="table table-hover table-panel mb-0 order">
                <thead>
                    <tr class="text-center">
                        <th width="30%">Produk</th>
                        <th width="20%">Harga</th>
                        <th width="10%">Stok</th>
                        <th width="10%">Jumlah</th>
                        <th width="13%">Diskon (%)</th>
                        <th width="15%">Subtotal</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $this->Form->control('order_lines[0][mouse_item_id]', ['label' => false, 'class' => 'form-control item', 'data-placeholder' => 'Pilih produk...', 'options' => [], 'empty' => 'Pilih produk...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Produk harus dipilih !', 'data-parsley-errors-container' => '#check-item', 'disabled']); ?><div id="check-item"></div>
                        </td>
                        <td><?= $this->Form->control('order_lines[0][price_t]', ['label' => false, 'class' => 'form-control text-end price', 'placeholder' => '0', 'readonly']); ?></td>
                        <td><?= $this->Form->control('order_lines[0][stock]', ['label' => false, 'class' => 'form-control text-end stock', 'placeholder' => '0', 'disabled']); ?></td>
                        <td><?= $this->Form->control('order_lines[0][quantity]', ['label' => false, 'class' => 'form-control text-end quantity', 'placeholder' => '0', 'type' => 'number', 'disabled']); ?></td>
                        <td>
                            <div class="input-group"><?= $this->Form->text('order_lines[0][discount]', ['label' => false, 'class' => 'form-control text-end discounts', 'placeholder' => '0', 'type' => 'number', 'max' => '100', 'min' => '0', 'step' => '0.1', 'disabled']); ?><span class="input-group-text input-group-addon"><i class="fas fa-percent"></i></span></div>
                        </td>
                        <td><?= $this->Form->control('order_lines[0][subtotal]', ['label' => false, 'class' => 'form-control text-end subtotal', 'id' => 'subtotal0', 'placeholder' => '0', 'readonly']); ?></td>
                        <td class="text-center"><button class="btn btn-inverse btn-sm addRow" id="" type="button" disabled><i class="fas fa-plus-square"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                &nbsp;
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td width="60%" class="table-info text-end"><strong>Subtotal</strong></td>
                            <td width="40%" class="text-end"><strong><span id="subtotals">0,00</span></strong></td>
                        </tr>
                        <tr>
                            <td width="60%" class="table-info  text-end"><strong>Biaya Pengiriman</strong></td>
                            <td width="40%" class="text-end">
                                <?= $this->Form->control('deliver_pays', ['label' => false, 'class' => 'form-control text-end nom ship', 'placeholder' => '0', 'disabled']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="60%" class="table-info  text-end"><strong>Diskon (%)</strong></td>
                            <td width="40%" class="text-end">
                                <div class="input-group">
                                    <?= $this->Form->text('discounts', ['label' => false, 'class' => 'form-control text-end discount', 'placeholder' => '0', 'disabled', 'type' => 'number', 'max' => '100', 'min' => '0', 'step' => '0.1']); ?>
                                    <span class="input-group-text input-group-addon"><i class="fas fa-percent"></i></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="60%" class="table-info  text-end"><strong>GRAND TOTAL</strong></td>
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
    let type = '';
    let itemId = 0;
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }


    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Orders', 'action' => 'add'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);


        $('.cs').select2().on('select2:select', (e) => {
            $('#radio1').prop('disabled', false);
            $('#radio2').prop('disabled', false);

        });


        $("#radio1, #radio2").change(function() {
            if ($("#radio1").is(":checked")) {
                $('.branch').prop('disabled', false);
                $('.warehouse').prop('disabled', true);
                $('.warehouse').val(null).trigger('change');
            } else {
                $('.branch').prop('disabled', true);
                $('.warehouse').prop('disabled', false);
                $('.branch').val(null).trigger('change');
            }
        });


        $('.branch').select2().on('select2:select', (e) => {
            itemId = e.params.data.id;
            type = 'branch';
            $.ajax({
                url: "<?php echo $this->url->build(['prefix' => 'Transaction', 'controller' => 'Orders', 'action' => 'getitem']); ?>",
                method: "get",
                data: {
                    id: itemId,
                    csid: $('.cs').val(),
                    type: 'branch'
                },
                success: function(data) {
                    dataArr = data;
                    $('.item').prop('disabled', false);
                    $('.item').html('<option></option>');
                    $.each(data, function(i, val) {
                        $('.item').append('<option value="' + val.id + '">' + val.text + '</option>');
                    });
                },
                error: function(err) {
                    swal("Informasi", "Data Kosong", "error");
                }
            });
        });

        $('.warehouse').select2().on('select2:select', (e) => {
            itemId = e.params.data.id;
            type = 'warehouse';
            $.ajax({
                url: "<?php echo $this->url->build(['prefix' => 'Transaction', 'controller' => 'Orders', 'action' => 'getitem']); ?>",
                method: "get",
                data: {
                    id: itemId,
                    csid: $('.cs').val(),
                    type: 'warehouse'
                },
                success: function(data) {
                    dataArr = data;
                    $('.item').prop('disabled', false);
                    $('.item').html('<option></option>');
                    $.each(data, function(i, val) {
                        $('.item').append('<option value="' + val.id + '">' + val.text + '</option>');
                    });
                },
                error: function(err) {
                    swal("Informasi", "Data Kosong", "error");
                }
            });
        });


        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });


        $('.item').select2().on('select2:select', (e) => {
            let id = e.params.data.id;

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

                        $('.price').val(rupiah(data[0].price));
                        $('.quantity').val(1);
                        $('.stock').val(rupiah(data[1].stock));
                        $('.quantity').prop('autofocus', true);
                        $('.discounts').prop('disabled', false);
                        $('.quantity').prop('disabled', false);
                        $('.discount').prop('disabled', false);
                        $('.ship').prop('disabled', false);
                        $('.ppn').prop('disabled', false);
                        $('.ship').prop('disabled', false);
                        $('.addRow').prop('disabled', false);
                        $('.subtotal').val(rupiah($('.quantity').val() * price));
                        calculate(0, 0);
                    } else {
                        swal('warning', 'Data kosong !', 'warning');
                    }

                },
                error: function(err) {
                    swal("Informasi", "Error pengambilan data", "error");
                }
            });
        });


        $(".order").delegate(".quantity", "keyup change", function() {
            var qty = $(this);

            var disc = $('.discounts').val();

            var price = parseFloat(($('.price').val()).replace(/[^0-9\,]+/g, "").replace(",", "."));
            disc = (price * disc) / 100;

            var priceDisc = price - disc;

            if (qty.val() > parseInt($('.stock').val())) {
                swal('warning', 'Jumlah melebihi stock, harap transaksikan jumlah kurang dari stok', 'warning');
                qty.val(1);
            }


            $("#subtotal0").val(rupiah(qty.val() * priceDisc));
            calculate(0, 0);
        });


        $(".order").delegate(".discounts", "keyup change", function() {
            if ($('.discounts').val() < 0) $('.discounts').val(0);
            if ($('.discounts').val() > 100) $('.discounts').val(100);

            var disc = $(this).val();
            var qty = $('.quantity').val();

            var price = parseFloat(($('.price').val()).replace(/[^0-9\,]+/g, "").replace(",", "."));
            disc = (price * disc) / 100;

            var priceDisc = price - disc;

            $("#subtotal0").val(rupiah(qty * priceDisc));
            calculate(0, 0);
        });


        var counter = ($('.order tr').length) - 1;
        $(".addRow").on("click", function(e) {
            if (e.originalEvent.defaultPrevented) return;

            var cols = '';
            cols += '<tr>'
            cols += '<td><select class="form-control item" name="order_lines[' + counter + '][mouse_item_id]" data-parsley-required="true" data-parsley-error-message="Produk harus dipilih !" data-parsley-errors-container="#check-produk"><option value="">Pilih produk...</option></select><div id="check-produk"></div></td>';
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
