<!-- Tambahkan ini di file CSS Anda -->
<style>
    .text-bold {
        font-weight: bold;
    }
</style>

<?php
$dataChild = $this->Html->link('Invoice Masuk', ['action' => 'index'], ['full_base'=>true]);

$purchase = $invoiceEntry->purchasing;

foreach ($invoiceEntry->purchasing->purchasing_lines as $rowOrder) {
    $subtotals = $rowOrder->subtotal;
    $grandtotals[] = $subtotals;
}

$grandtotal = array_sum($grandtotals);
//pr($grandtotal);

?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Edit') ?>
<?= $this->Form->create($invoiceEntry, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fas fa-search fa-lg me-2 text-gray text-opacity-50"></i>
        Cari No. Purchase Order
    </div>
    <div class="card-body">
        <?= $this->Form->control('purchasing_id', ['label' => false, 'class' => 'form-control', 'id'=>'purchasingSelect', 'data-parsley-required' => true, 'data-parsley-error-message' => 'No. Purchase Order harus dipilih !', 'data-parsley-errors-container' => '#check-item']); ?>
        <div id="check-item"></div>
    </div>
</div>  

<div class="row">
    <div class="col-md-3">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-receipt fa-lg me-2 text-gray text-opacity-50"></i>
                Invoice Masuk 
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="" class="form-label">No. Invoice Masuk</label>
                    <?= $this->Form->control('codes', ['label' => false, 'class' => 'form-control', 'value' => $invoiceEntry->code, 'readonly']); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Perusahaan</label>
                    <?= $this->Form->control('company', ['label' => false, 'class' => 'form-control company', 'placeholder' => 'Nama perusahaan...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Nama perusahaan harus diisi !', 'value' => $invoiceEntry->company]); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Tgl. Terima</label>
                    <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal terima...', 'readonly', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Tgl. terima harus diisi !', 'value' => ($invoiceEntry->date == null ? '' : date_format($invoiceEntry->date, 'd-m-Y')),]); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Tgl. Jatuh Tempo</label>
                    <?= $this->Form->control('due_dates', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal jatuh tempo...', 'readonly', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Tgl. jatuh tempo harus diisi !', 'value' => ($invoiceEntry->due_date == null ? '' : date_format($invoiceEntry->due_date, 'd-m-Y')),]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-wallet fa-lg me-2 text-gray text-opacity-50"></i>
                Detail Invoice Masuk
            </div>
            <div class="card-body">
                <div class="table-responsive mb-3" style="overflow: auto; height: 200px;">
                    <div id="tableContainer"></div>
                    <table class="table table-hover table-panel text-nowrap align-middle mb-0 detail" id="hideTable">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">#</th>
                                <th class="text-center" width="35%">Produk</th>
                                <th class="text-center" width="15%">Harga</th>
                                <th class="text-center" width="15%">Jumlah</th>
                                <th class="text-center" width="15%">Diskon (%)</th>
                                <th class="text-center" width="15%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($invoiceEntry->purchasing->purchasing_lines as $rowItem) { 
                                $items = $rowItem->item;
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td><?= (!empty($items->name) ? $items->name : '-') ?></td>
                                    <td class="text-end"><?= (!empty($rowItem->price) ? $this->Krs->_currency($rowItem->price) : '-') ?></td>
                                    <td class="text-center"><?= $this->Krs->_currency($rowItem->quantity) . ' ' . $items->unit; ?> </td>
                                    <td class="text-center"><?= (!empty($rowItem->discount) ? $this->Krs->_currency($rowItem->discount) . ' %' : '-')  ?></td>
                                    <td class="text-end"><?= (!empty($rowItem->subtotal) ? $this->Krs->_currency($rowItem->subtotal) : '-') ?></td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                    
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        &nbsp;
                    </div>
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td width="60%" class="table-info"><strong>Subtotal</strong></td>
                                    <td width="40%" class="text-end text-bold">
                                        <span id="subtotals" class="text-bold"><?= $this->Krs->_currency($grandtotal) ?></span>
                                        <?= $this->Form->control('discount', ['label' => false, 'type' => 'hidden', 'class' => 'form-control text-end text-bold', 'placeholder' => '0']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="60%" class="table-info"><strong>Diskon (%)</strong></td>
                                    <td width="40%" class="text-end text-bold">
                                        <strong>
                                            <span id="disc" class="text-bold"><?= $this->Krs->_currency($purchase->discount)?> %</span>
                                            <?= $this->Form->control('discount', ['label' => false, 'type' => 'hidden', 'class' => 'form-control text-end text-bold', 'placeholder' => '0']); ?>
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="60%" class="table-info"><strong>Biaya Pengiriman</strong></td>
                                    <td width="40%" class="text-end text-bold">
                                    <span id="ship" class="text-bold"><?= $this->Krs->_currency($purchase->ship_payment) ?></span>
                                    <?= $this->Form->control('ship_payment', ['label' => false, 'type' => 'hidden', 'class' => 'form-control text-end text-bold', 'placeholder' => '0']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="60%" class="table-info"><strong>Ppn (12%)</strong></td>
                                    <td width="40%" class="text-end text-bold">
                                        <span id="tax" class="text-bold"><?= $this->Krs->_currency($purchase->ppn) ?></span>
                                        <?= $this->Form->control('ppn', ['label' => false, 'type' => 'hidden', 'class' => 'form-control text-end text-bold', 'placeholder' => '0']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="60%" class="table-info"><strong>GRAND TOTAL</strong></td>
                                    <td width="40%" class="text-end text-bold">
                                        <span id="grandtotal" class="text-bold"><?= $this->Krs->_currency($purchase->grandtotal) ?></span>
                                        <?= $this->Form->control('grandtotal', ['label' => false, 'type' => 'hidden', 'class' => 'form-control text-end text-bold', 'placeholder' => '0']); ?>
                                    </td>
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
    </div>
</div>


<?= $this->Form->end() ?>

<script>
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }


    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'InvoiceEntries', 'action' => 'add'], ['fullBase' => true]); ?>";
        var dataItem = [];
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        datePickerReset('input-daterange', 'resetDateReceive', 'filterDateReceive', 'dd-mm-yyyy');


        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        // Inisialisasi Select2 dengan AJAX untuk mengambil data pesanan
        $('#purchasingSelect').select2({
            placeholder: "Cari Data PO",
            minimumInputLength: 2, // Minimal karakter untuk memulai pencarian
            ajax: {
                url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'InvoiceEntries', 'action' => 'getpo']); ?>",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term // Mengirimkan istilah pencarian
                    };
                },
                processResults: function(data, page) {
                    return {
                        results: data // Memproses data yang diterima dari server
                    };
                },
                cache: true
            } 
        }).on('select2:select', function(e) {
            var data = e.params.data; 
            var ids = data.id;
 
            // Mengirim permintaan AJAX untuk mendapatkan detail pesanan
            $.ajax({
                url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'InvoiceEntries', 'action' => 'setpo']); ?>",
                method: "get",
                data: {
                    id: ids
                },
                success: function(data) {
                    if (data) { 
                        // Memperbarui elemen halaman dengan detail pesanan yang diterima
                        $('.company').val(data.purchase.supplier.name); 
                        //$('#finding').val(data.purchase.number); 
                        $('#subtotals').text(data.result.grandtotal);
                        $('#disc').text(rupiah(data.purchase.discount) + ' %');
                        $('#ship').text(rupiah(data.purchase.ship_payment));
                        $('#tax').text(rupiah(data.purchase.ppn));
                        $('#grandtotal').text(rupiah(data.purchase.grandtotal));

                        // Tampilkan data order
                        displayData(data);

                        // Sembunyikan data dengan id = hideTable 
                        hideData(data);
                    }
                }
            });
        });

        // Fungsi javascript untuk menampilkan produk
        function displayData(data) {
            // Ambil elemen tabel sesuai dengan ID elemen tabel 
            var tableContainer = $('#tableContainer');
            
            // Hapus konten tabel sebelumnya
            tableContainer.empty();

            // Bangun tabel HTML
            var tableHtml = '<table class="table table-hover table-panel text-nowrap align-middle mb-0 detail">';
            tableHtml += '<thead class="thead-dark text-center">';
            tableHtml += '<tr>';
            tableHtml += '<th class="text-center" width="5%">#</th>';
            tableHtml += '<th width="35%">Produk</th>';
            tableHtml += '<th class="text-center" width="15%">Harga</th>';
            tableHtml += '<th class="text-center" width="15%">Jumlah</th>';
            tableHtml += '<th class="text-center" width="15%">Diskon (%)</th>';
            tableHtml += '<th class="text-center" width="15%">Subtotal</th>';
            tableHtml += '</tr>';
            tableHtml += '</thead>';
            tableHtml += '<tbody>';

            for (var key in data.result) {
                // Periksa apakah kunci adalah angka (menghindari 'grandtotal')
                if (!isNaN(key)) {
                    var item = data.result[key];
                    tableHtml += '<tr>';
                    tableHtml += '<td align="center">' + (parseInt(key) + 1) + '</td>';
                    tableHtml += '<td>' + item.produk + '</td>';
                    tableHtml += '<td align="right">' + item.harga + '</td>';
                    tableHtml += '<td align="center">' + item.jumlah + ' ' + item.unit + '</td>';
                    tableHtml += '<td align="center">' + item.diskon + ' %' + '</td>';
                    tableHtml += '<td align="right">' + item.subtotal + '</td>';
                    tableHtml += '</tr>';
                }
            }

            tableHtml += '</tbody>';
            tableHtml += '</table>';

            // Tampilkan tabel di dalam elemen '#tableContainer'
            tableContainer.html(tableHtml);
        }

        // Fungsi javascript untuk hide table
        function hideData(data) {
            // Logika untuk menyembunyikan elemen dengan ID hideTable
            $('#hideTable').hide();
        }


        $("#jquery-autocomplete").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'InvoiceEntries', 'action' => 'getpo']); ?>",
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(e, i) {
                var id = i.item.data.id;
                $.ajax({
                    url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'InvoiceEntries', 'action' => 'setpo']); ?>",
                    method: "get",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        dataItem = data.items;
                        if (data.purchase) {
                            $('.save').prop('disabled', false);
                            if (data.branch_id > 0) {
                                $("#dataId").append('<input type="hidden" name="branch_id" value="' + data.branch_id + '">' );
                            } else {
                                $("#dataId").append('<input type="hidden" name="warehouse_id" value="' + data.warehouse_id + '">');
                            }
                            $('.purchasing_id').val(data.purchase.id);
                            $('.company').val(((data.purchase.supplier_id > 0) ? data.purchase.supplier.name : '-'));

                            $('#disc').text(rupiah(data.purchase.discount));
                            $('#ship').text(rupiah(data.purchase.ship_payment) + ',00');
                            $('#tax').text(rupiah(data.purchase.ppn) + ',00');
                            $('#grandtotal').text(rupiah(data.purchase.grandtotal) + ',00');

                            if ((data.purchase.purchasing_lines).length > 0) {
                                $('.detail>tbody').html('');
                                let max = (data.purchase.purchasing_lines).length;
                                let total = 0;

                                $.each(data.purchase.purchasing_lines, function(i, val) {
                                    let condButton = '';
                                    total = total + (parseFloat((val.subtotal).replace(",", ".")) * 1);

                                    if (i == (max - 1)) {
                                        condButton = '<button class="btn btn-inverse btn-sm addRow" id="" type="button"><i class="fas fa-plus-square"></i></button>';
                                    } else {
                                        condButton = "";
                                    }

                                    $('.detail>tbody').append('<tr><td>' + ((val.item) ? val.item.name : '-') + '</td><td class="text-end">' + rupiah(val.price) + '</td><td class="text-end">' + rupiah(val.quantity) + '</td><td class="text-end">' + rupiah(val.discount) + ' %</td><td class="text-end"><input type="hidden" class="subtotal" value="' + rupiah(val.subtotal) + '">' + rupiah(val.subtotal) + '</td><td class="text-center">' + condButton + '</td></tr>');
                                });

                                $('#subtotals').text(rupiah(total) + ',00');
                            } else {
                                $('.detail>tbody').append('<tr><td colspan="6" class="text-center">Data Kosong</td></tr>');
                            }
                        } else {
                            $('.detail>tbody').append('<tr><td colspan="6" class="text-center">Data Kosong</td></tr>');
                        }


                        var counter = ($('.detail tr').length) - 1;
                        $(".addRow").on("click", function(e) {
                            if (e.originalEvent.defaultPrevented) return;

                            var cols = '';
                            cols += '<tr>'
                            cols += '<td><select class="form-control item" name="purchasing_lines[' + counter + '][item_id]" data-parsley-required="true" data-parsley-error-message="Produk harus dipilih !" data-parsley-errors-container="#check-produk"><option value="">Pilih produk...</option></select><div id="check-produk"></div></td>';
                            cols += '<td><input class="form-control text-end price" name="purchasing_lines[' + counter + '][price]" type="text" placeholder="0" readonly data-parsley-required="true" data-parsley-error-message="Harga harus diisi !"></td>';
                            cols += '<td><input type="number" min="1" class="form-control text-end qty" placeholder="0"disabled  name="purchasing_lines[' + counter + '][quantity]" data-parsley-required="true" data-parsley-error-message="Jumlah harus diisi !"></td>';
                            cols += '<td><div class="input-group"><input type="number" min="1" min="100" class="form-control text-end discount" placeholder="0" disabled  name="purchasing_lines[' + counter + '][discount]"> <span class="input-group-text input-group-addon"><i class="fas fa-percent"></i></span></div></td>';
                            cols += '<td><input class="form-control text-end subtotal" type="text" name="purchasing_lines[' + counter + '][subtotal]" readonly placeholder="0" data-parsley-required="true" data-parsley-error-message="Subtotal harus diisi !"></td>';
                            cols += '<td class="text-center"><button class="btn btn-pink btn-sm" id="del" type="button"><i class="far fa-trash-alt"></i></button></td>';
                            cols += '</tr>';

                            // nambah baris didalam tabel
                            $(".detail>tbody").append(cols);

                            $('.item').select2({
                                data: dataItem,
                                placeholder: 'Pilih produk...'
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
                                        tr.find('.price').val(rupiah(data.selling_price));

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


                            $(".detail").delegate(".qty", "keyup change", function() {
                                var qty = $(this);
                                var tr = $(this).parent().parent();
                                var disc = tr.find('.discount').val();

                                var price = parseFloat((tr.find('.price').val()).replace(/[^0-9\,]+/g, "").replace(",", "."));
                                disc = (price * disc) / 100;

                                var priceDisc = price - disc;

                                tr.find(".subtotal").val(rupiah(qty.val() * priceDisc));
                                calculate(0, 0);
                            });

                            $(".detail").delegate(".discount", "keyup change", function() {
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
                    }
                });

            }

        });

    });

    function calculate() {
        var net_total = 0;

        $(".subtotal").each(function(data) {
            net_total = net_total + (parseFloat(($(this).val()).replace(/[^0-9\,]+/g, "").replace(",", ".")) * 1);
        });

        var disc = ($('#disc').text() == '') ? 0 : $('#disc').text();
        var ship = ($('#ship').text() == '') ? 0 : parseFloat(($('#ship').text()).replace(/[^0-9\,]+/g, "").replace(",", "."));
        var ppn = (($('#tax').text() == '') || ($('#tax').text() == '0')) ? 0 : ((11 * net_total) / 100);

        var discSubtotal = (net_total * disc) / 100;
        var subtotal = net_total - discSubtotal;

        console.log('disc :' + disc, 'ship :' + ship, 'ppn :' + ppn);

        $('#subtotals').number(net_total, 2, ",", ".");
        $('#grandtotal').number((subtotal + ship + ppn), 2, ",", ".");
        $('.grandtotal').val((subtotal) + ship + ppn);
    }
</script>
