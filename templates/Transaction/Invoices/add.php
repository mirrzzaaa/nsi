<?php
// pr($customers);
$dataChild = $this->Html->link('Invoices', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Buat') ?>
<?= $this->Form->create($invoice, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<?= $this->Form->control('code', ['type' => 'hidden', 'value' => $data['lastNumber']]); ?> 
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
                        <?= $this->Form->control('codes', ['label' => false, 'class' => 'form-control', 'value' => $data['lastNumber'], 'disabled']); ?>
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label">Referensi PO</label>
                        <?= $this->Form->control('referense_po', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Referensi nomor PO...']); ?>
                    </div>
                    <div class="col-md-5">
                        <label for="" class="form-label">Tanggal</label>
                        <div class="input-daterange input-group" id="datepicker">
                            <?= $this->Form->input('dates', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Tgl. buat...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Tgl buat harus diisi !']); ?>
                            <span class="input-group-text">s/d</span>
                            <?= $this->Form->input('expireds', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Tgl. jatuh tempo...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Tgl jatuh tempo harus diisi !']); ?>
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
                    <div class="col-md-5">
                        <label class="col-form-label">Tanggal Order</label>
                        <div class="input-daterange input-group" id=" date-picker"> 
                            <?php
                            echo $this->Krs->inputDateRange('filterstart', array("class" => "form-control filterDateReceive", 'id' => 'filterstart', 'readonly' => true, 'placeholder' => 'Tgl. mulai..'), 'filterend', array("class" => "form-control filterDateReceive", 'id' => 'filterend', 'readonly' => true, 'placeholder' => 'Tgl. sampai..'), 's/d', 'resetDateReceive');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="col-form-label">No. Order</label>
                        <?= $this->Form->control('order_id', ['label' => false, 'class' => 'form-control slc orders', 'empty' => 'Pilih no order...', 'options' => $orders, 'data-parsley-required' => true, 'data-parsley-error-message' => 'No order harus dipilih !', 'id' => 'order_id']); ?>
                    </div>
                    <div class="col-md-3">
                        <label class="col-form-label">Customer</label>
                        <?= $this->Form->control('customer_id', ['label' => false, 'class' => 'form-control slc cs', 'empty' => 'Pilih customer...', 'options' => $customers, 'id' => 'customer_id', 'data-parsley-errors-container' => '#check-cs']); ?>
                        <?= $this->Form->control('grandtotal', ['type' => 'hidden', 'class' => 'totals']); ?>
                    </div>
                    <div class="col-md-1">
                        <label class="col-form-label">&nbsp;</label>
                        <div class="btn-group w-100">
                            <?php
                            echo $this->Form->button('<i class="fas fa-search"></i>', array('class' => 'btn btn-yellow', 'type' => 'button', 'id' => 'btnSearch', 'escapeTitle' => false, 'data-toggle' => 'tooltip', 'data-original-title' => "Cari"));
                            ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="table-responsive" style="overflow: auto; height: 400px;">
                    <div id="tableContainerProduk"></div>
                    <table class="table table-hover table-bordered order" id="hideTable">
                        <thead class="bg-default">
                            <tr class="text-center">
                                <th width="5%">#</th>
                                <th width="25%">Item</th>
                                <th width="17%">Keterangan</th>
                                <th width="10%">Tgl. Expired</th>
                                <th width="12%">Harga</th>
                                <th width="8%">Jumlah</th>
                                <th width="11%">Diskon</th>
                                <th width="12%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center" colspan="7">Data Kosong</td>
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
                <hr> <br>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="form-label">Metode Pembayaran</label>
                            <?= $this->Form->control("dp_methods", ["label" => false, "class" => "form-control slc", "options" => $this->Krs->metodePembayaran(), 'empty' => true]); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="form-label">Nominal Pembayaran</label>
                            <?= $this->Form->control("nominals", ["label" => false, "class" => "form-control text-end nom", "id" => "nominals", "placeholder" => "0"]); ?>
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dp_ppns" class="form-label">Ppn</label>
                            <?= $this->Form->control("dp_ppns", ["label" => false, "class" => "form-control", "id" => "dp_ppns", "options" => $this->Krs->_tax(), 'empty' => true]); ?>
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
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Invoices', 'action' => 'add'], ['fullBase' => true]); ?>";
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
            aDec: ','
        });


        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        // Inisialisasi select2 pada `dp_ppns`
        $('#dp_ppns').select2({
            placeholder: "Pilih...",
            position: 'below'
        });

        // Event listener untuk perubahan pada `dp_ppns`
        $('#dp_ppns').on('change', function() {
            calculate(); // Memanggil fungsi calculate saat nilai dp_ppns berubah
        });

        function calculate() {
            var net_total = 0;

            // Ambil nilai dari input `nominals`
            $("input[id^='nominals']").each(function() {
                net_total += parseFloat(($(this).val()).replace(/[^0-9\,]+/g, "").replace(",", ".")) || 0;
            });

            // Cek dan log nilai `dp_ppns`
            var ppn_value = $('#dp_ppns').val();

            // Hitung ppn dan total
            // var ppn = (ppn_value === '1') ? ((11 * net_total) / 100) : 0;

            var dpp = (ppn_value === '1') ? Math.round((11 * net_total) / 12) : 0;
            var ppn = (ppn_value === '1') ? Math.round((12 * dpp) / 100) : 0;
            var total = (ppn_value === '1') ? (net_total + ppn) : net_total;

            // Update nilai `proforma_total` dan `dp_ppns`
            $('.total').val(total.toFixed(0).replace('.', ','));
            $('.dp_ppns').val(ppn.toFixed(0).replace('.', ','));
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

        // Fungsi javascript untuk hide table
        function hideData(data) {
            // Logika untuk menyembunyikan elemen dengan ID hideTable
            $('#hideTable').hide();
        }

        // Fungsi javascript untuk menampilkan produk
        function displayDataProduk(data) {
            // Ambil elemen tabel sesuai dengan ID elemen tabel 
            var tableContainerProduk = $('#tableContainerProduk');
            
            // Hapus konten tabel sebelumnya
            tableContainerProduk.empty();

            // Bangun tabel HTML
            var tableHtml = '';
            tableHtml = '<table id="productTable" class="table table-hover table-bordered order" align="center">';
            tableHtml += '<thead class="bg-default">';
            tableHtml += '<tr class="text-center">';
            tableHtml += '<th width="5%">#</th>';
            tableHtml += '<th width="25%">Item</th>';
            tableHtml += '<th width="17%">Keterangan</th>';
            tableHtml += '<th width="10%">Tgl. Expired</th>';
            tableHtml += '<th width="12%">Harga</th>';
            tableHtml += '<th width="8%">Jumlah</th>';
            tableHtml += '<th width="11%">Diskon</th>';
            tableHtml += '<th width="12%">Subtotal</th>';
            tableHtml += '</tr>';
            tableHtml += '</thead>';
            tableHtml += '<tbody>';

            for (var i = 0; i < data.result.length; i++) {
                var harga = data.result[i].harga.replace(/\./g, "");
                var jumlah = data.result[i].jumlah; 
                var diskon = data.result[i].diskon_item.replace(/\./g, "").replace(",", ".");
                
                var total = harga * jumlah; 
                var subtotal = total - diskon;
 
                var totalNominal = subtotal.toLocaleString('id-ID');

                let date = data.result[i].expired_date; 
                let formattedDate = date.split('-').reverse().join('-');
                
                tableHtml += '<tr>';
                tableHtml += '<td align="center" width="50"><input type="checkbox" class="select-item" value="' + data.result[i].order_line_id + '"></td>';
                tableHtml += '<input type="hidden" name="order_lines[' + i + '][order_line_id]" value="' + data.result[i].order_line_id + '">';
                tableHtml += '<td align="left">' + data.result[i].item + '</td>';
                tableHtml += '<td align="left">' + (data.result[i].keterangan === null || data.result[i].keterangan === '' ? '-' : data.result[i].keterangan) + '</td>';
                tableHtml += '<td align="center">' + formattedDate + '</td>';
                tableHtml += '<td align="right"><input type="text" class="form-control text-end nom" id="data-price" name="order_lines[' + i + '][price_t]" value="' + data.result[i].harga + '"></td>';
                tableHtml += '<td align="center">' + data.result[i].jumlah + ' ' + data.result[i].unit + '</td>';
                tableHtml += '<td align="right"><input type="text" class="form-control text-end nom" id="data-discount" name="order_lines[' + i + '][discount]" value="' + data.result[i].diskon_item + '"></td>';
                tableHtml += '<td align="right"><input type="text" class="form-control text-end nom" id="totals" name="order_lines[' + i + '][subtotal]" value="' + data.result[i].subtotal + '"></td>';
                tableHtml += '</tr>';
            }

            tableHtml += '</tbody>';
            tableHtml += '</table>';

            tableHtml += '<div class="row">';
            tableHtml += '<div class="col-md-4">';
            tableHtml += '<div class="col-md-12">'; 
            tableHtml += '<div class="form-group">';
            tableHtml += '<label for="" class="form-label">Biaya Pengiriman</label>';
            tableHtml += '<?= $this->Form->control("orders[0][ship_payments]", ["label" => false, "class" => "form-control text-end nom ship", "placeholder" => "0"]); ?>';
            tableHtml += '</div>';
            tableHtml += '</div>';
            tableHtml += '<div class="col-md-12 mt-2">';
            tableHtml += '<div class="form-group">';
            tableHtml += '<label for="" class="form-label">Ppn</label>';
            tableHtml += '<?= $this->Form->control("ppns", ["label" => false, "class" => "form-control ppn", "options" => $this->Krs->_tax(), "empty" => "true"]); ?>';
            tableHtml += '</div>';
            tableHtml += '</div>';
            tableHtml += '</div>';
            tableHtml += '<div class="col-md-8"> <br>';
            tableHtml += '<table class="table table-bordered">';
            tableHtml += '<tbody>';

            // Subtotal
            tableHtml += '<tr>';
            tableHtml += '<td width="60%" class="table-info"><strong>Total</strong></td>';
            tableHtml += '<td width="40%" class="text-end"><input type="hidden" id="subtotal-hidden"><strong><span id="subtotals">0</span></strong></td>';
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

            tableHtml += '</tbody>';
            tableHtml += '</table>';
            tableHtml += '</div>';
            tableHtml += '</div>';

            tableHtml += '<div class="row mb-4">';
            tableHtml += '<div class="col-md-12">';
            tableHtml += '<div class="col-md-12">';
            tableHtml += '<div class="form-group">';
            tableHtml += '<label for="" class="form-label">Keterangan :</label>';
            tableHtml += '<br>';
            tableHtml += '<textarea class="form-control">';
            tableHtml += (data.result[0].note === null || data.result[0].note === '') ? '-' : data.result[0].note;
            tableHtml += '</textarea>';
            tableHtml += '</div>';
            tableHtml += '</div>';
            tableHtml += '</div>';
            tableHtml += '</div>';

            // Tampilkan tabel di dalam elemen '#tableContainerProduk'
            tableContainerProduk.html(tableHtml);

            $(document).on('change', 'input.select-item', function() {
                calcGrandTotal();
            });

            $('.nom').autoNumeric({
                aSep: '.',
                aDec: ',',
                aPad: false
            }).on('keyup', function(e) {
                calculate(0, 0);
            });

            $('.ppn').select2({
                placeholder: "Pilih..."
            }).on('select2:select', function(e) {
                var ppnValue = $(this).val(); 
                $('#ppn').text(ppnValue); 
                calcGrandTotal(); 
            });

            $('.disc').on('change', function() {
                // Mengambil nilai dan mengganti koma dengan titik
                var value = $(this).val().replace(',', '.');

                // Mengkonversi ke float dan memastikan validitas
                value = parseFloat(value);
                if (isNaN(value)) value = 0;
                if (value < 0) value = 0;
                if (value > 100) value = 100;

                // Mengatur nilai input
                $(this).val(value); 

                // Memperbarui elemen lain
                $('#disc').text(value); 
                calculate(0, 0); 
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

            // Iterasi untuk setiap baris yang checkbox-nya tercentang
            $('#productTable').find('input.select-item:checked').each(function() {
                var row = $(this).closest('tr'); // Ambil baris terdekat dari checkbox yang tercentang
                var subtotalValue = row.find('input[id^="totals"]').val(); // Temukan input subtotal di dalam baris yang tercentang
                
                // Hapus format pemisah ribuan dan ganti koma dengan titik untuk parsing
                subtotalValue = subtotalValue.replace(/\./g, '').replace(/,/g, '.');
                grandTotal += parseFloat(subtotalValue) || 0; // Tambahkan ke grandTotal
            });

            // Update elemen subtotal dengan nilai grand total yang telah dihitung
            $('#subtotals').text(grandTotal.toLocaleString('id-ID'));

            // Panggil fungsi calculate untuk memperbarui elemen lain
            calculate();
        }

        function calculate() { 
            var net_total = 0;
            var net_totals = 0;

            // Menghitung total nilai dari semua subtotal
            $("#subtotals").each(function() {
                var raw_value = $(this).text().replace(/\./g, "").replace(",", ".");
                net_total += parseFloat(raw_value) || 0;
                var raw_value = $(this).text().replace(/\./g, "").replace(",", ".");
                net_totals += parseFloat(raw_value) || 0;
            });

            var disc = ($('.disc').val() == '') ? 0 : $('.disc').val();
            var ships = ($('.ship').val() == '') ? 0 : $('.ship').val();
            var ship = ($('.ship').val() == '') ? 0 : parseFloat($('.ship').val().replace(/[^0-9\,]+/g, "").replace(",", "."));
            var dpp = (($('.ppn').val() == '') || ($('.ppn').val() == '0')) ? 0 : Math.round((11 * net_total) / 12);
            var ppn = (($('.ppn').val() == '') || ($('.ppn').val() == '0')) ? 0 : Math.round((12 * dpp) / 100);

            $('#disc').text(disc);
            $('#ship').number(ship, 0, ",", ".");

            var subtotal = net_totals;
            var grandtotals = subtotal + ship + ppn;

            $('#ppn').number(ppn, 0, ",", ".");
            $('#grandtotal').number((subtotal + ship + ppn), 0, ",", ".");
            $('.grandtotal').val(grandtotals.toFixed(0).replace('.', ','));
            $('#totalTagihan').number((subtotal + ship + ppn), 0, ",", ".");
            $('.totals').val(grandtotals.toFixed(0).replace('.', ','));
        } 

</script>
