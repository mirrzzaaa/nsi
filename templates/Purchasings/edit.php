<?php
$dataChild = $this->Html->link('Purchase Order', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Ubah') ?>
<?= $this->Form->create($purchasing, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>
<?= $this->Form->control('supplier_id', ['type' => 'hidden', 'class' => '_supplier']); ?>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fas fa-store-alt fa-lg me-2 text-gray text-opacity-50"></i> 
        Purchase Order
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="form-group">
                    <label class="form-label">No. PO</label>
                    <?= $this->Form->text('number', ['label' => false, 'class' => 'form-control', 'disabled']); ?>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="form-group">
                    <label for="" class="form-label">Gudang</label>
                    <?= $this->Form->control('warehouse_id', ['label' => false, 'class' => 'form-control slc', 'options' => $warehouses, 'data-placeholder' => 'Pilih gudang...', 'empty' => 'Pilih gudang...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Gudang harus dipilih !', 'data-parsley-errors-container' => '#check-gudang']); ?>
                    <div id="check-gudang"></div>
                </div>
            </div>
            <div class="col-md-4 mb-4">  
                <div class="form-group">
                    <label for="" class="form-label">Tanggal</label>
                    <?= $this->Form->control('date', ['label' => false, 'class' => 'form-control tgl', 'type' => 'text', 'value' => $this->Krs->fDate($purchasing->date, 'd-m-Y')]); ?>
                </div>
            </div>
            <div class="col-md-8 mb-8">
                <div class="form-group">
                    <label for="" class="form-label">Supplier</label>
                    <?= $this->Form->control('supplier', ['label' => false, 'class' => 'form-control', 'type' => 'textarea', 'value' => $purchasing->supplier->name . ' (' . $purchasing->supplier->address . ')', 'placeholder' => 'Pilih supplier...', 'disabled', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Supplier harus dipilih !', 'data-parsley-errors-container' => '#check-supplier']); ?>
                    <div id="check-supplier"></div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <p>&nbsp;</p>
                        <?= $this->Form->checkbox('with_price', ['label' => false, 'value' => 'N', 'class' => 'form-check-input', 'hiddenField' => true, 'checked' => ($purchasing->with_price == 'N'), 'uncheck' => 'Y']); ?> 
                        <label class="form-check-label text-danger">(Centang jika tanpa harga)</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fa fa-briefcase-medical fa-lg me-2 text-gray text-opacity-50"></i>
        Produk
        <button class="ms-auto btn btn-inverse btn-sm" type="button" id="insert"><i class="fas fa-plus-square"></i></button>
    </div>
    <div class="card-body">
        <div class="table-responsive mb-3" style="overflow: auto;">
            <table class="table table-hover table-panel text-nowrap align-middle mb-0 order">
                <thead style="position: sticky; top: 0; z-index: 1;">
                    <tr class="text-center">
                        <th width="5%">#</th>
                        <th width="30%">Produk</th>
                        <th width="20%">Harga</th>
                        <th width="10%">Jumlah</th>
                        <th width="13%">Diskon (%)</th>
                        <th width="20%">Subtotal</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($purchasing->purchasing_lines as $index => $data) {
                        $dataItem = $data->item;
                        $itemId = $dataItem->id;
                        $itemName = $dataItem->name;
                        $itemStock = $dataItem->stock;
                        $itemUnit =$dataItem->unit;
                        //pr($purchasing);
                    ?>
                        <tr>
                            <td class="text-center"><strong><?= $no ?></strong><?= $this->Form->hidden('purchasing_lines['.$index.'][id]', ['value' => $data->id]); ?></td>
                            <td>
                                <?= $this->Form->control('purchasing_lines[' . $index . '][item_name]', ['label' => false, 'class' => 'form-control', 'value' => $itemName, 'disabled']); ?>
                                <?= $this->Form->text('purchasing_lines[' . $index . '][item_id]', ['label' => false, 'type' => 'hidden', 'class' => 'form-control', 'value' => $itemId]); ?>
                            </td>
                            <td><?= $this->Form->control('purchasing_lines[' . $index . '][price]', ['label' => false, 'type' => 'text', 'value' => $this->Krs->_currency($data->price), 'class' => 'form-control text-end price']); ?></td>
                            <td><?= $this->Form->control('purchasing_lines[' . $index . '][quantity]', ['label' => false, 'type' => 'number', 'value' => $this->Krs->_currency($data->quantity), 'class' => 'form-control text-end quantity', 'min' => 1]); ?></td>
                            <td>
                                <div class="input-group">
                                    <?= $this->Form->text('purchasing_lines[' . $index . '][discount]', ['label' => false, 'type' => 'number', 'value' => rtrim(rtrim(str_replace(',', '.', $data->discount), '0'), '.'), 'class' => 'form-control text-end discounts', 'max' => '100']); ?><span class="input-group-text input-group-addon"><i class="fas fa-percent"></i></span>
                                </div>
                            </td>
                            <td><?= $this->Form->control('purchasing_lines[' . $index . '][subtotal]', ['label' => false, 'type' => 'text', 'value' => $this->Krs->_currency($data->subtotal), 'class' => 'form-control text-end subtotal0', 'readonly']); ?></td>
                            <td class="text-center"><button class="btn btn-pink btn-sm" id="del" type="button"><i class="far fa-trash-alt"></i></button></td>
                        </tr>
                    <?php
                        $no++;
                    }
                    ?> 
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Diskon (%)</label>
                <div class="input-group mb-3">
                    <?= $this->Form->text('discounts', ['label' => false, 'class' => 'form-control text-end diskon', 'placeholder' => '0', 'type' => 'number', 'max' => '100', 'value' => $this->Krs->_currency($purchasing->discount)]); ?>
                    <span class="input-group-text input-group-addon"><i class="fas fa-percent"></i></span>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="" class="form-label">Biaya Pengiriman</label>
                    <?= $this->Form->control('ship_payments', ['label' => false, 'class' => 'form-control text-end nom ship', 'placeholder' => '0', 'value' => $this->Krs->_currency($purchasing->ship_payment)]); ?>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="" class="form-label">Ppn</label>
                    <?= $this->Form->control('ppns', ['label' => false, 'class' => 'form-control ppn', 'options' => $this->Krs->_tax(), 'value' => ($purchasing->ppn > 0) ? '1' : '0']); ?>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td width="60%" class="table-info"><strong>Subtotal</strong></td>
                            <td width="40%" class="text-end"><strong><span id="subtotals">0</span></strong></td>
                        </tr>
                        <tr>
                            <td width="60%" class="table-info"><strong>Diskon (%)</strong></td>
                            <td width="40%" class="text-end"><strong><span id="disc">0</span> %</strong></td>
                        </tr>
                        <tr>
                            <td width="60%" class="table-info"><strong>Biaya Pengiriman</strong></td>
                            <td width="40%" class="text-end"><strong><span id="ship">0</span></strong></td>
                        </tr>
                        <tr>
                            <td width="60%" class="table-info"><strong>Ppn (12%)</strong></td>
                            <td width="40%" class="text-end"><input type="hidden" name="ppn" class="_ppn"><strong><span id="tax">0</span></strong></td>
                        </tr>
                        <tr>
                            <td width="60%" class="table-info"><strong>GRAND TOTAL</strong></td>
                            <td width="40%" class="text-end"><input type="hidden" name="grandtotal" class="grandtotal"><strong><span id="grandtotal">0</span></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <label for="" class="form-label">Note :</label>
            <?= $this->Form->control('description', ['label' => false, 'class' => 'ckeditor', 'id' => 'editor1']); ?>
        </div>
    </div>
    <div class="card-footer bg-yellow d-flex p-3">
        <?php
        echo $this->Form->button('Simpan', ['class' => 'btn btn-primary  ms-auto', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
        ?>
    </div>
</div>

<?= $this->Form->end() ?>

<script>
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }

    CKEDITOR.replace('editor1', {
        height: 200
    });

    $(document).on('click', '#del', function() {
        // Hapus elemen <tr> yang merupakan parent dari tombol yang diklik
        $(this).closest('tr').remove();
    });

    $(document).ready(function() {
        var dataItem = [];
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'Purchasings', 'action' => 'edit', $purchasing->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        calculate(0, 0);

        $('.slc').select2({
            placeholder: "Pilih salah satu"
        });

        $('.ppn').select2({
            placeholder: "Pilih salah satu"
        }).on('select2:select', function(e) {
            calculate(0, 0);
        });

        $('input.nom').autoNumeric({
            aSep: '.',
            aDec: ','
        }).on('keyup', function(e) {
            calculate(0, 0);
        });

        $(".diskon").on('keyup change', function() {
            if ($('.diskon').val() < 0) $('.diskon').val(0);
            if ($('.diskon').val() > 100) $('.diskon').val(100);

            $('#disc').text($(this).val() + ' ' + '%');
            calculate(0, 0);
        });

        $(".diskon").on('keyup change', function() {
            $('#disc').text($(this).val() + ' ' + '%');
            calculate(0, 0);
        });

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        $(".disc").on('keyup change', function() {
            if ($('.disc').val() < 0) $('.disc').val(0);
            if ($('.disc').val() > 100) $('.disc').val(100);

            $('.disc').text($(this).val() + ' ' + '%');
            calculate(0, 0);
        });

        // Event listener untuk perubahan harga
        $('.price').autoNumeric({
            aSep: '.',
            aDec: ',',
            aPad: false
        }).on('keyup change', function(e) {
            var tr = $(this).closest('tr'); // Mengidentifikasi baris saat ini
            var qty = parseFloat(tr.find('.quantity').val()) || 0;
            var disc = parseFloat(tr.find('.discounts').val()) || 0;

            var price = parseFloat($(this).val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            var discValue = (price * disc) / 100;
            var priceDisc = price - discValue;

            var subtotal = qty * priceDisc;

            tr.find('.subtotal0').val(rupiah(subtotal));
            calculate();
        });

        // Event listener untuk perubahan quantity
        $('.order').delegate('.quantity', 'keyup change', function() {
            var tr = $(this).closest('tr');
            var qty = parseFloat($(this).val()) || 0;

            var price = parseFloat(tr.find('.price').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            var disc = parseFloat(tr.find('.discounts').val()) || 0;

            var discValue = (price * disc) / 100;
            var priceDisc = price - discValue;

            if (qty > parseInt(tr.find('.stock').val())) {
                swal('warning', 'Jumlah melebihi stock, harap transaksikan jumlah kurang dari stok', 'warning');
                qty = 1;
                $(this).val(1);
            }

            var subtotal = qty * priceDisc;
            tr.find('.subtotal0').val(rupiah(subtotal));
            calculate();
        });

        // Event listener untuk perubahan diskon
        $('.order').delegate('.discounts', 'keyup change', function() {
            var tr = $(this).closest('tr'); 
            var disc = parseFloat($(this).val()) || 0;

            if (disc < 0) {
                $(this).val(0);
                disc = 0;
            } else if (disc > 100) {
                $(this).val(100);
                disc = 100;
            }

            var qty = parseFloat(tr.find('.quantity').val()) || 0;
            var price = parseFloat(tr.find('.price').val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            var discValue = (price * disc) / 100;
            var priceDisc = price - discValue;

            var subtotal = qty * priceDisc;

            tr.find('.subtotal0').val(rupiah(subtotal));
            calculate();
        });

        var counter = $('.order tr').length;
        $("#insert").on("click", function(event) {
            event.preventDefault();

            var cols = '';
            cols += '<tr>'
            cols += '<td class="text-center"><strong>' + counter + '</strong><input type="hidden" name="purchasing_lines[' + counter + '][id]"></td>';
            cols += '<td><select class="form-control item" name="purchasing_lines[' + counter + '][item_id]" data-parsley-required="true" data-parsley-error-message="Produk harus dipilih !" data-parsley-errors-container="#check-produk"><option value="">Pilih produk...</option><?php foreach ($items as $rowItem) : ?> <option value="<?= $rowItem->id ?>"><?= $rowItem->name ?></option> <?php endforeach; ?></select><div id="check-produk"></div></td>';
            cols += '<td><input class="form-control text-end price" name="purchasing_lines[' + counter + '][price]" type="text" placeholder="0" data-parsley-required="true" data-parsley-error-message="Harga harus diisi !"></td>';
            cols += '<td><input type="number" min="1" class="form-control text-end qty" placeholder="0"disabled  name="purchasing_lines[' + counter + '][quantity]" data-parsley-required="true" data-parsley-error-message="Jumlah harus diisi !"></td>';
            cols += '<td><div class="input-group"><input type="number" min="1" min="100" class="form-control text-end discount" placeholder="0" disabled  name="purchasing_lines[' + counter + '][discount]"> <span class="input-group-text input-group-addon"><i class="fas fa-percent"></i></span></div></td>';
            cols += '<td><input class="form-control text-end subtotal" type="text" name="purchasing_lines[' + counter + '][subtotal]" readonly placeholder="0" data-parsley-required="true" data-parsley-error-message="Subtotal harus diisi !"></td>';
            cols += '<td class="text-center"><button class="btn btn-pink btn-sm" id="del" type="button"><i class="far fa-trash-alt"></i></button></td>';
            cols += '</tr>';

            // nambah baris didalam tabel
            $(".order>tbody").append(cols);

            $('.item').select2({
                placeholder: 'Pilih produk'
            }).on('select2:select', function(e) {
                var id = e.params.data.id;
                var tr = $(this).parent().parent();
                $.ajax({
                    url: "<?php echo $this->url->build(['prefix' => false, 'controller' => 'Purchasings', 'action' => 'setitem']); ?>",
                    method: "get",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        tr.find('.price').val(rupiah(data.item.buying_price));

                        var price = tr.find('.price').val();

                        price = parseFloat(price.replace(/[^0-9\,]+/g, "").replace(",", "."));

                        tr.find(".qty").val(1);
                        tr.find('.qty').prop('disabled', false);
                        tr.find('.discount').prop('disabled', false);
                        tr.find('.qty').prop('autofocus', true);
                        $('.disc').prop('disabled', false);
                        $('.ship').prop('disabled', false);
                        $('.ppn').prop('disabled', false);
                        tr.find(".subtotal").val(rupiah(tr.find('.qty').val() * price));
                        calculate(0, 0);
                    }
                });
            });

            $('.price').autoNumeric({
                aSep: '.',
                aDec: ',',
                aPad: false
            }).on('keyup', function(e) {
                calculate(0, 0);
            });

            $(".order").delegate(".price", "keyup change", function() {
                var tr = $(this).closest('tr'); // Mengidentifikasi baris saat ini
                var qty = parseFloat(tr.find('.qty').val()) || 0;
                var disc = parseFloat(tr.find('.discount').val()) || 0;

                var price = parseFloat($(this).val().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            
                disc = (price * disc) / 100;

                var priceDisc = price - disc;

                tr.find(".subtotal").val(rupiah(qty * priceDisc));
                calculate(0, 0);
            });

            $(".order").delegate(".qty", "keyup change", function() {
                var qty = $(this);
                var tr = $(this).parent().parent();
                var disc = tr.find('.discount').val();

                var price = parseFloat((tr.find('.price').val()).replace(/[^0-9\,]+/g, "").replace(",", "."));
                disc = (price * disc) / 100;

                var priceDisc = price - disc;

                tr.find(".subtotal").val(rupiah(qty.val() * priceDisc));
                calculate(0, 0);
            });

            $(".order").delegate(".discount", "keyup change", function() {
                if ($('.discount').val() < 0) $('.discount').val(0);
                if ($('.discount').val() > 100) $('.discount').val(100);

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
    });

    function calculate() {
        var net_total = 0;

        // Menghitung total dari elemen dengan kelas .subtotal0
        $(".subtotal0").each(function(data) {
            net_total = net_total + (parseFloat(($(this).val()).replace(/[^0-9\,]+/g, "").replace(",", ".")) * 1);
        });

        // Menghitung total dari elemen dengan kelas .subtotal
        $(".subtotal").each(function(data) {
            net_total = net_total + (parseFloat(($(this).val()).replace(/[^0-9\,]+/g, "").replace(",", ".")) * 1);
        });

        var disc = ($('.diskon').val() == '') ? 0 : $('.diskon').val();
        var ship = ($('.ship').val() == '') ? 0 : parseFloat(($('.ship').val()).replace(/[^0-9\,]+/g, "").replace(",", "."));
        var ppn = (($('.ppn').val() == '') || ($('.ppn').val() == '0')) ? 0 : ((11 * net_total) / 100);

        $('#disc').text(disc);
        $('#ship').number(($('.ship').val() == '') ? 0 : parseFloat(($('.ship').val()).replace(/[^0-9\,]+/g, "").replace(",", ".")), 2, ",", ".");

        var discSubtotal = (net_total * disc) / 100;
        var subtotal = net_total - discSubtotal;

        $('#subtotals').number(net_total, 2, ",", ".");
        $('#tax').number(ppn, 2, ",", ".");
        $('#grandtotal').number((subtotal + ship + ppn), 2, ",", ".");
        $('.grandtotal').val((subtotal) + ship + ppn);
        $('._ppn').val(ppn);
    }
</script>
