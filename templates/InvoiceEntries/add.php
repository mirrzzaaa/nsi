<?php
//pr($orderLines);
$dataChild = $this->Html->link('Invoice Masuk', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Buat') ?>
<?= $this->Form->create($invoiceEntry, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<?= $this->Form->control('code', ['type' => 'hidden', 'value' => $data['lastNumber']]); ?>
<div class="col-md-12">
    <div class="card border-0 mb-3">
        <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
            <i class="fas fa-receipt fa-lg me-2 text-gray text-opacity-50"></i>
            Invoice Masuk 
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="form-label">No. Invoice Masuk</label>
                    <?= $this->Form->control('codes', ['label' => false, 'class' => 'form-control', 'value' => $data['lastNumber'], 'disabled']); ?>
                </div>
                <div class="col-md-3">
                    <label for="" class="form-label">Perusahaan</label>
                    <?= $this->Form->control('company', ['label' => false, 'class' => 'form-control company', 'placeholder' => 'Nama perusahaan...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Nama perusahaan harus diisi !']); ?>
                </div>
                <div class="col-md-3">
                    <label for="" class="form-label">Tgl. Terima</label>
                    <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal terima...', 'readonly', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Tgl. terima harus diisi !']); ?>
                </div>
                <div class="col-md-3">
                    <label for="" class="form-label">Tgl. Jatuh Tempo</label>
                    <?= $this->Form->control('due_dates', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal jatuh tempo...', 'readonly', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Tgl. jatuh tempo harus diisi !']); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fas fa-search fa-lg me-2 text-gray text-opacity-50"></i>
        Cari No. Purchase Order
    </div>
    <div class="card-body">
        <?= $this->Form->control('purchasing_id', ['label' => false, 'class' => 'form-control finding', 'data-placeholder' => 'Cari nomor purchase order (PO)...', 'empty' => 'No. Purchase Order...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'No. Purchase Order harus dipilih !', 'data-parsley-errors-container' => '#check-item']); ?>
        <div id="check-item"></div>
    </div>
</div>  

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-wallet fa-lg me-2 text-gray text-opacity-50"></i>
                Detail Invoice Masuk
            </div>
            <div class="card-body">
                <div class="table-responsive mb-3" style="overflow: auto; height: 400px;">
                    <div id="tableContainer"></div>
                    <table class="table table-hover table-panel text-nowrap align-middle mb-0 detail" id="hideTable">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">#</th>
                                <th width="35%">Produk</th>
                                <th class="text-center" width="15%">Harga</th>
                                <th class="text-center" width="15%">Jumlah</th>
                                <th class="text-center" width="15%">Diskon (%)</th>
                                <th class="text-center" width="15%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center" colspan="6">DATA KOSONG</td>
                            </tr>
                        </tbody>
                    </table>
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
        $('.finding').select2({
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

                        // Tampilkan data order
                        displayData(data);

                        // Sembunyikan data dengan id = hideTable 
                        hideData(data);
                    }
                }
            });
        });
    });

        // Fungsi javascript untuk hide table
        function hideData(data) {
            // Logika untuk menyembunyikan elemen dengan ID hideTable
            $('#hideTable').hide();
        }

        function displayData(data) {
            // Ambil elemen tabel sesuai dengan ID elemen tabel 
            var tableContainer = $('#tableContainer');
            
            // Hapus konten tabel sebelumnya
            tableContainer.empty();

            // Bangun tabel HTML
            var tableHtml = '';
            tableHtml = '<table id="productTable" class="table table-hover table-panel text-nowrap align-middle mb-3 detail">';
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

                    var price = item.harga.replace(/\./g, "");
                    var qty = item.jumlah; 
                    var diskon = item.diskon.replace(/\./g, "").replace(",", ".");

                    var total = price * qty; 

                    var discSubtotal = 0; // Inisialisasi diskon subtotal ke 0
                    if (diskon > 0) {
                        discSubtotal = (total * diskon) / 100;
                    }

                    var subtotal = total - discSubtotal;
                    
                    var totalNominal = subtotal.toLocaleString('id-ID');

                    tableHtml += '<tr>';
                    tableHtml += '<td align="center">' + (parseInt(key) + 1) + '</td>';
                    tableHtml += '<input type="hidden" name="purchasing_lines[' + key + '][purchasing_line_id]" value="' + item.purchasing_line_id + '">';
                    tableHtml += '<td>' + item.produk + '</td>';
                    tableHtml += '<td align="right"><input type="text" class="form-control text-end nom" id="data-price" name="purchasing_lines[' + key + '][price]" value="' + item.harga + '"></td>';
                    tableHtml += '<td align="center">' + item.jumlah + ' ' + item.unit + '</td>';
                    tableHtml += '<td align="center">';
                    tableHtml += '<div class="input-group">';
                    tableHtml += '<input type="number" class="form-control text-end" id="data-discount" name="purchasing_lines[' + key + '][discount]" value="' + diskon + '" placeholder="0" min="0" max="100" step="0.1">';
                    tableHtml += '<span class="input-group-text input-group-addon"><i class="fas fa-percent"></i></span>';
                    tableHtml += '</div>';
                    tableHtml += '</td>';
                    tableHtml += '<td align="right"><input type="text" class="form-control text-end nom" id="totals" name="purchasing_lines[' + key + '][subtotal]" value="' + totalNominal + '"></td>';
                    tableHtml += '</tr>';
                }
            }

            tableHtml += '</tbody>';
            tableHtml += '</table>';

            tableHtml += '<div class="row col-md-12">';
            tableHtml += '<div class="col-md-4 mb-3">';
            tableHtml += '<label for="" class="form-label">Diskon (%)</label>';
            tableHtml += '<div class="input-group mb-3">';
            tableHtml += '<?= $this->Form->text("purchasings[0][discounts]", ["label" => false, "class" => "form-control text-end disc", "placeholder" => "0", "type" => "number", "max" => "100", "min" => "0", "step" => "0.1"]); ?>';
            tableHtml += '<span class="input-group-text input-group-addon"><i class="fas fa-percent"></i></span>';
            tableHtml += '</div>';
            tableHtml += '</div>';
            tableHtml += '<div class="col-md-4 mb-3">';
            tableHtml += '<div class="form-group">';
            tableHtml += '<label for="" class="form-label">Biaya Pengiriman</label>';
            tableHtml += '<?= $this->Form->control("purchasings[0][ship_payments]", ["label" => false, "class" => "form-control text-end nom ship", "placeholder" => "0"]); ?>';
            tableHtml += '</div>';
            tableHtml += '</div>';
            tableHtml += '<div class="col-md-4 mb-3">';
            tableHtml += '<div class="form-group">';
            tableHtml += '<label for="" class="form-label">Ppn</label>';
            tableHtml += '<?= $this->Form->control("ppns", ["label" => false, "class" => "form-control ppn", "options" => $this->Krs->_tax()]); ?>';
            tableHtml += '</div>';
            tableHtml += '</div>';
            tableHtml += '</div>';

            tableHtml += '<div class="row">';
            tableHtml += '<div class="col-md-4 mb-3">';
            tableHtml += '&nbsp;';
            tableHtml += '</div>';
            tableHtml += '<div class="col-md-8">';
            tableHtml += '<table class="table table-bordered">';
            tableHtml += '<tbody>';

            // Subtotal
            tableHtml += '<tr>';
            tableHtml += '<td width="60%" class="table-info"><strong>Subtotal</strong></td>';
            tableHtml += '<td width="40%" class="text-end"><input type="hidden" id="subtotal-hidden"><strong><span id="subtotals">0</span></strong></td>';
            tableHtml += '</tr>';

            // Diskon
            tableHtml += '<tr>';
            tableHtml += '<td width="60%" class="table-info"><strong>Diskon (%)</strong></td>';
            tableHtml += '<td width="40%" class="text-end"><input type="hidden" id="discount-hidden"><strong><span id="disc">0</span> %</strong></td>';
            tableHtml += '</tr>';

            // Biaya Pengiriman
            tableHtml += '<tr>';
            tableHtml += '<td width="60%" class="table-info"><strong>Biaya Pengiriman</strong></td>';
            tableHtml += '<td width="40%" class="text-end"><input type="hidden" id="ship-hidden"><strong><span id="ship">0</span></strong></td>';
            tableHtml += '</tr>';

            // Ppn (12%)
            tableHtml += '<tr>';
            tableHtml += '<td width="60%" class="table-info"><strong>Ppn (12%)</strong></td>';
            tableHtml += '<td width="40%" class="text-end"><input type="hidden" id="ppn-hidden"><strong><span id="ppn">0</span></strong></td>';
            tableHtml += '</tr>';

            // Grand Total
            tableHtml += '<tr>';
            tableHtml += '<td width="60%" class="table-info"><strong>GRAND TOTAL</strong></td>';
            tableHtml += '<td width="40%" class="text-end"><input type="hidden" name="purchasings[0][grandtotal]" class="grandtotal" id="grandtotal-hidden"><strong><span id="grandtotal">0</span></strong></td>';
            tableHtml += '</tr>';

            tableHtml += '</tbody>';
            tableHtml += '</table>';
            tableHtml += '</div>';
            tableHtml += '</div>';

            // Tampilkan tabel di dalam elemen '#tableContainer'
            tableContainer.html(tableHtml);

            $('.nom').autoNumeric({
                aSep: '.',
                aDec: ',',
                aPad: false
            }).on('keyup', function(e) {
                calculate(0, 0);
            });

            $('.ppn').select2({
                placeholder: "Pilih salah satu"
            }).on('select2:select', function(e) {
                var ppnValue = $(this).val(); 
                $('#ppn').text(ppnValue); 
                calcGrandTotal(); 
            });

            $('.disc').on('change', function() {
                if ($('.disc').val() < 0) $('.disc').val(0);
                if ($('.disc').val() > 100) $('.disc').val(100);

                $('#disc').text($(this).val());
                calcGrandTotal();
            });

            $("#data-discount").on('keyup change', function() {
                if ($('#data-discount').val() < 0) $('#data-discount').val(0);
                if ($('#data-discount').val() > 100) $('#data-discount').val(100);

                $('#data-discount').text($(this).val());
                calculate(0, 0);
            });

            calcRows();
            calcGrandTotal();
        }

        function calcRows() {
            $(document).on('change', 'input[id^="data-price"], input[id^="data-discount"]', function() {
                var row = $(this).closest('tr');
                calcRow(row);
            });
        }

        function calcRow(row) {
            var prices = row.find('input[id^="data-price"]').val().replace(/(?!^-)[^0-9\,]+/g, "");
            var price = parseFloat(prices.replace(/,/g, '.')) || 0;
            var disc = (row.find('input[id^="data-discount"]').val() == '') ? 0 : row.find('input[id^="data-discount"]').val();
            var qty = parseFloat(row.find('td').eq(3).text().replace(/[^0-9]/g, '')) || 1; // Mengambil jumlah dari kolom ke-4 (jumlah)
            var totalLine = price * qty;
            var discSubtotal = (totalLine * disc) / 100;
            var subtotal = totalLine - discSubtotal;

            var totalNominal = subtotal.toLocaleString('id-ID');

            row.find('input[id^="totals"]').val(totalNominal);
            calcGrandTotal();
            calculate(0, 0);
        }

        function calcGrandTotal() {
            var grandTotal = 0;
            $('#productTable').find('input[id^="totals"]').each(function() {
                var value = $(this).val().replace(/\./g, '').replace(/,/g, '.');
                grandTotal += parseFloat(value) || 0;
            });
            $('#subtotals').text(grandTotal.toLocaleString('id-ID'));
            calculate(0, 0);
        }

        function calculate() { 
            var net_total = 0;

            // Menghitung total nilai dari semua subtotal
            $("#subtotals").each(function() {
                net_total += parseFloat($(this).text().replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            });

            var disc = ($('.disc').val() == '') ? 0 : $('.disc').val();
            var ship = ($('.ship').val() == '') ? 0 : parseFloat($('.ship').val().replace(/[^0-9\,]+/g, "").replace(",", "."));
            var ppn = (($('.ppn').val() == '') || ($('.ppn').val() == '0')) ? 0 : ((11 * net_total) / 100);

            $('#disc').text(disc);
            $('#ship').number(ship, 0, ",", ".");

            var discSubtotal = (net_total * disc) / 100;
            var subtotal = net_total - discSubtotal;

            $('#ppn').number(ppn, 0, ",", ".");
            $('#grandtotal').number((subtotal + ship + ppn), 0, ",", ".");
            $('.grandtotal').val(subtotal + ship + ppn);
            $('#totalTagihan').number((subtotal + ship + ppn), 0, ",", ".");
        }

</script>
