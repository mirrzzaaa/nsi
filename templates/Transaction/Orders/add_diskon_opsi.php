<?php
//pr($nameCustomers);
$dataChild = $this->Html->link('Order', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Buat') ?>
<?= $this->Form->create($order, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>  

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center"> 
        <i class="fas fa-shopping-bag fa-lg me-2 text-gray text-opacity-50"></i> 
        Order
    </div>
    <div class="card-body">
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
                <label for="" class="form-label">Gudang</label>
                <?= $this->Form->control('warehouse_id', ['label' => false, 'class' => 'form-control warehouse', 'options' => $warehouses, 'data-placeholder' => 'Pilih gudang...', 'empty' => 'Pilih gudang...', 'disabled']); ?>
            </div>

            <!-- <div class="col-md-4 mt-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio" id="radio1" disabled />
                    <label class="text-danger form-label" for="">Pilih jika order di toko</label>
                </div>
                $this->Form->control('branch_id', ['label' => false, 'class' => 'form-control branch', 'options' => $branches, 'data-placeholder' => 'Pilih toko...', 'empty' => 'Pilih toko...', 'disabled']);
            </div>

            <div class="col-md-4 mt-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio" id="radio2" disabled />
                    <label class="text-danger form-label" for="">Pilih jika order di gudang</label>
                </div>
                $this->Form->control('warehouse_id', ['label' => false, 'class' => 'form-control warehouse', 'options' => $warehouses, 'data-placeholder' => 'Pilih gudang...', 'empty' => 'Pilih gudang...', 'disabled']);
            </div> -->

            <div class="col-md-3">
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <p>&nbsp;</p> 
                        <?= $this->Form->checkbox('with_price', ['label' => false, 'value' => 'N', 'class' => 'form-check-input', 'hiddenField' => 'Y']); ?>
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
            <table class="table table-hover table-panel mb-0 order">
                <thead>
                    <tr class="text-center">
                        <th width="27%">Produk</th>
                        <th width="13%">Tgl. Expired</th>
                        <th width="15%">Harga</th>
                        <th width="8%">Stok</th>
                        <th width="9%">Jumlah</th>
                        <th width="14%">Diskon</th>
                        <th width="15%">Subtotal</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $this->Form->control('order_lines[0][item_id]', ['label' => false, 'class' => 'form-control item', 'data-placeholder' => 'Pilih produk...', 'options' => [], 'empty' => 'Pilih produk...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Produk harus dipilih !', 'data-parsley-errors-container' => '#check-item', 'disabled']); ?><div id="check-item"></div>
                        </td>
                        <td><?= $this->Form->control('order_lines[0][expired_date]', ['label' => false, 'class' => 'form-control expired', 'placeholder' => 'Tgl. Expired']); ?></td>
                        <td><?= $this->Form->control('order_lines[0][price_t]', ['label' => false, 'class' => 'form-control text-end price', 'placeholder' => '0']); ?></td>
                        <td><?= $this->Form->control('order_lines[0][stock]', ['label' => false, 'class' => 'form-control text-end stock text-center', 'placeholder' => '0', 'disabled']); ?></td>
                        <td>
                            <?= $this->Form->control('order_lines[0][quantity]', ['label' => false, 'class' => 'form-control text-end quantity', 'placeholder' => '0', 'type' => 'number', 'disabled']); ?>
                            <?= $this->Form->control('order_lines[0][unit]', ['label' => false, 'type' => 'hidden', 'class' => 'form-control text-end unit', 'placeholder' => '0']); ?>
                        </td>
                        
                        <td>
                            <!-- Dropdown untuk memilih tipe diskon -->
                            <select class="form-control slc" id="discountTypeSelect">
                                <option value="" disabled selected>Pilih Tipe</option>
                                <option value="nominal">Nominal</option>
                                <option value="percentage">Persentase</option>
                            </select> 
                            <!-- Kontainer untuk input diskon dinamis -->
                            <div class="mt-2" id="dynamic-discount-container" style="display: none;">
                                <!-- Konten akan diubah berdasarkan pilihan -->
                            </div>
                        </td>

                        <td><?= $this->Form->control('order_lines[0][subtotal]', ['label' => false, 'class' => 'form-control text-end subtotal', 'id' => 'subtotal0', 'placeholder' => '0', 'readonly']); ?></td>
                        <td class="text-center"><button class="btn btn-inverse btn-sm addRow" id="" type="button" disabled><i class="fas fa-plus-square"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="form-label">Biaya Pengiriman</label>
                        <?= $this->Form->control('ship_payments', ['label' => false, 'class' => 'form-control text-end nom ship', 'placeholder' => '0', 'disabled']); ?>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <label for="" class="form-label">Ppn</label>
                        <?= $this->Form->control('ppns', ['label' => false, 'class' => 'form-control ppn', 'options' => $this->Krs->_tax(), 'disabled']); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8"> <br>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td width="60%" class="table-info"><strong>Total</strong></td>
                            <td width="40%" class="text-end"><strong><span id="subtotals">0,00</span></strong></td>
                        </tr>
                        <!-- <tr>
                            <td width="60%" class="table-info"><strong>Diskon (%)</strong></td>
                            <td width="40%" class="text-end"><strong><span id="disc">0</span> %</strong></td>
                        </tr> -->
                        <tr>
                            <td width="60%" class="table-info"><strong>Biaya Pengiriman</strong></td>
                            <td width="40%" class="text-end"><strong><span id="ship">0,00</span></strong></td>
                        </tr>
                        <tr>
                            <td width="60%" class="table-info"><strong>Ppn (12%)</strong></td>
                            <td width="40%" class="text-end"><input type="hidden" name="ppn" class="_ppn"><strong><span id="tax">0,00</span></strong></td>
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
    let type = '';
    let itemId = 0;
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Seleksi elemen dropdown tipe diskon dan container dinamis
        const discountTypeSelect = document.getElementById('discountTypeSelect');
        const dynamicDiscountContainer = document.getElementById('dynamic-discount-container');

        // Inisialisasi Select2 (jika menggunakan jQuery)
        $(discountTypeSelect).select2({
            placeholder: "Pilih tipe...",
            position: 'below'
        });

        // Event listener untuk perubahan pada dropdown tipe diskon
        $(discountTypeSelect).on('change', function () {
            const selectedType = this.value;

            if (selectedType) {
                // Sembunyikan dropdown
                discountTypeSelect.style.display = 'none';

                // Tampilkan elemen container dinamis
                dynamicDiscountContainer.style.display = 'block';

                // Perbarui konten container berdasarkan pilihan
                if (selectedType === 'nominal') {
                    // Jika dipilih 'nominal', tampilkan input nominal
                    dynamicDiscountContainer.innerHTML = `
                        <input type="number" name="order_lines[0][discount]" class="form-control text-end" placeholder="0" />
                    `;
                } else if (selectedType === 'percentage') {
                    // Jika dipilih 'persentase', tampilkan input persentase
                    dynamicDiscountContainer.innerHTML = `
                        <div class="input-group">
                            <input type="number" name="order_lines[0][discount]" class="form-control text-end" placeholder="0" max="100" min="0" step="0.1" />
                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                        </div>
                    `;
                }
            } else {
                // Jika tidak ada pilihan yang valid, sembunyikan container dan tampilkan dropdown
                dynamicDiscountContainer.style.display = 'none';
                discountTypeSelect.style.display = 'block';
            }
        });
    });

    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Orders', 'action' => 'add'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $('input.nom').autoNumeric({
            aSep: '.',
            aDec: ','
        }).on('keyup', function(e) {
            calculate(0, 0);
        });

        $('.ppn').select2({
            placeholder: "Pilih salah satu"
        }).on('select2:select', function(e) {
            calculate(0, 0);
        });


        $('.cs').select2().on('select2:select', (e) => {
            $('#radio1').prop('disabled', false);
            $('#radio2').prop('disabled', false);
            $('.warehouse').prop('disabled', false);

        });

        $(".disc").on('keyup change', function() {
            if ($('.disc').val() < 0) $('.disc').val(0);
            if ($('.disc').val() > 100) $('.disc').val(100);

            $('.disc').text($(this).val() + ' ' + '%');
            calculate(0, 0);
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
                        let price = parseFloat(data[0].selling_price.replace(",", "."));
                        let date = data[1].expired_date;
                        let formattedDate = date.split('-').reverse().join('-');

                        $('.price').val(rupiah(data[0].selling_price)); 
                        $('.quantity').val(1);
                        $('.stock').val(rupiah(data[1].stock));
                        $('.unit').val(data[1].unit);
                        $('.expired').val(formattedDate);
                        $('.quantity').prop('autofocus', true);
                        $('.discounts').prop('disabled', false);
                        $('.quantity').prop('disabled', false);
                        $('.discount').prop('disabled', false);
                        $('.disc').prop('disabled', false);
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

        $('.diskon').autoNumeric({
            aSep: '.',
            aDec: ',',
            aPad: false
        }).on('keyup', function(e) {
            calculate(0, 0);
        });

        $('.price').autoNumeric({
            aSep: '.',
            aDec: ',',
            aPad: false
        }).on('keyup', function(e) {
            calculate(0, 0);
        });

        $(".order").delegate(".price", "keyup change", function() {
            var qty = $('.quantity').val();
            var disc = parseFloat(($('.diskon').val()).replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;

            var price = $(this).val().replace(/[^0-9\,]+/g, "").replace(",", ".");

            var priceDisc = price - disc;

            $("#subtotal0").val(rupiah(qty * priceDisc));
            calculate(0, 0);
        });


        $(".order").delegate(".quantity", "keyup change", function() {
            var qty = $(this);

            var disc = parseFloat(($('.diskon').val()).replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;

            var price = parseFloat(($('.price').val()).replace(/[^0-9\,]+/g, "").replace(",", "."));

            var priceDisc = price - disc;

            if (qty.val() > parseInt($('.stock').val())) {
                swal('warning', 'Jumlah melebihi stock, harap transaksikan jumlah kurang dari stok', 'warning');
                qty.val(1);
            }


            $("#subtotal0").val(rupiah(qty.val() * priceDisc));
            calculate(0, 0);
        });


        $(".order").delegate(".diskon", "keyup change", function() {
            var disc = $(this).val().replace(/[^0-9\,]+/g, "").replace(",", ".");
            var qty = $('.quantity').val();

            var price = parseFloat(($('.price').val()).replace(/[^0-9\,]+/g, "").replace(",", "."));

            var priceDisc = price - disc;

            $("#subtotal0").val(rupiah(qty * priceDisc));
            calculate(0, 0);
        });


        var counter = ($('.order tr').length) - 1;
        $(".addRow").on("click", function(e) {
            if (e.originalEvent.defaultPrevented) return;

            var cols = '';
    cols += '<tr>';
    cols += '<td><select class="form-control item" name="order_lines[' + counter + '][item_id]" data-parsley-required="true" data-parsley-error-message="Produk harus dipilih !" data-parsley-errors-container="#check-produk"><option value="">Pilih produk...</option></select><div id="check-produk"></div></td>';
    cols += '<td><input class="form-control text-end expired" name="order_lines[' + counter + '][expired_date]" type="text" placeholder="Tgl. Expired"></td>';
    cols += '<td><input class="form-control text-end prices" name="order_lines[' + counter + '][price_t]" type="text" placeholder="0" data-parsley-required="true" data-parsley-error-message="Harga harus diisi !"></td>';
    cols += '<td><input class="form-control text-end stocks text-center" placeholder="0" disabled name="order_lines[' + counter + '][stock]"></td>';
    cols += '<td><input type="number" min="1" class="form-control text-end qty" placeholder="0" disabled name="order_lines[' + counter + '][quantity]" data-parsley-required="true" data-parsley-error-message="Jumlah harus diisi !"></td>';
    cols += `
        <td>
            <select class="form-control slc" id="discountTypeSelect_${counter}">
                <option value="" disabled selected>Pilih Tipe Diskon</option>
                <option value="nominal">Nominal</option>
                <option value="percentage">Persentase</option>
            </select>
            <div class="mt-2" id="dynamic-discount-container-${counter}" style="display: none;"></div>
        </td>`;
    cols += '<td><input class="form-control text-end subtotal subs" type="text" name="order_lines[' + counter + '][subtotal]" id="subtotal' + counter + '" readonly placeholder="0" data-parsley-required="true" data-parsley-error-message="Subtotal harus diisi !"></td>';
    cols += '<td class="text-center"><button class="btn btn-pink btn-sm" id="del" type="button"><i class="far fa-trash-alt"></i></button></td>';
    cols += '</tr>';

    // Tambahkan baris ke tabel
    $(".order>tbody").append(cols);

    // Tangani perubahan pada dropdown tipe diskon setelah baris ditambahkan
    const discountTypeSelect = document.getElementById(`discountTypeSelect_${counter}`);
    const dynamicDiscountContainer = document.getElementById(`dynamic-discount-container-${counter}`);

    // Inisialisasi Select2 (jika menggunakan jQuery)
    $(discountTypeSelect).select2({
        placeholder: "Pilih tipe...",
        position: 'below'
    });

    $(discountTypeSelect).on('change', function () {
        const selectedType = this.value;

        if (selectedType) {
            // Sembunyikan dropdown
            discountTypeSelect.style.display = 'none';

            // Tampilkan elemen container dinamis
            dynamicDiscountContainer.style.display = 'block';

            // Perbarui konten container berdasarkan pilihan
            if (selectedType === 'nominal') {
                dynamicDiscountContainer.innerHTML = `
                    <input type="number" name="order_lines[${counter}][discount]" class="form-control text-end" placeholder="0" />
                `;
            } else if (selectedType === 'percentage') {
                dynamicDiscountContainer.innerHTML = `
                    <div class="input-group">
                        <input type="number" name="order_lines[${counter}][discount]" class="form-control text-end" placeholder="0" max="100" min="0" step="0.1" />
                        <span class="input-group-text"><i class="fas fa-percent"></i></span>
                    </div>
                `;
            }
        } else {
            // Jika tidak ada pilihan yang valid, sembunyikan container dan tampilkan dropdown
            dynamicDiscountContainer.style.display = 'none';
            discountTypeSelect.style.display = 'block';
        }
    });

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
                            tr.find('.qty').prop('disabled', false);
                            tr.find('.disc').prop('disabled', false);
                            tr.find('.units').val(data[1].unit);
                            tr.find('.expired').val(formattedDate);
                            tr.find('.qty').prop('autofocus', true);

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

        $(".subtotal").each(function(data) {
            net_total = net_total + (parseFloat(($(this).val()).replace(/[^0-9\,]+/g, "").replace(",", ".")) * 1);
        });

        var disc = ($('.discount').val() == '') ? 0 : $('.discount').val();
        var ship = ($('.ship').val() == '') ? 0 : parseFloat(($('.ship').val()).replace(/[^0-9\,]+/g, "").replace(",", "."));
        var ppn = (($('.ppn').val() == '') || ($('.ppn').val() == '0')) ? 0 : ((11 * net_total) / 100);

        $('#disc').text(disc);
        $('#ship').number(($('.ship').val() == '') ? 0 : parseFloat(($('.ship').val()).replace(/[^0-9\,]+/g, "").replace(",", ".")), 2, ",", ".");

        // var discSubtotal = (net_total * disc) / 100;
        // var subtotal = net_total - discSubtotal;

        $('#subtotals').number(net_total, 2, ",", ".");;
        $('#tax').number(ppn, 2, ",", ".");
        $('#grandtotal').number((net_total + ship + ppn), 2, ",", "."); 
        $('.grandtotal').val((net_total) + ship + ppn);
        //$('._ppn').val(ppn);
    }

</script>
