<!-- Tambah onvoice dan mengambil data order dengan harga -->

<?php
//pr($orderLines);
$dataChild = $this->Html->link('Invoices', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Buat') ?>
<?= $this->Form->create($invoice, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<?= $this->Form->control('number', ['type' => 'hidden', 'value' => $data['lastNumber']]); ?>
<div class="row">
    <div class="col-md-4">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-receipt fa-lg me-2 text-gray text-opacity-50"></i>
                Invoice
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="" class="form-label">No. Invoice</label>
                    <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $data['lastNumber'], 'disabled']); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Referensi PO</label>
                    <?= $this->Form->control('referense_po', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Referensi nomor PO...']); ?>
                </div>
                <div class="form-group mb-3">
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

    <div class="col-md-8">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-search fa-lg me-2 text-gray text-opacity-50"></i>
                Data Order
            </div>
            <div class="card-body">
                <div class="form-group row m-b-15 mb-3">
                    <label class="col-form-label col-md-2">Tanggal Order</label>
                    <div class="col-md-6">
                        <div class="input-daterange input-group" id=" date-picker">
                            <?php
                            echo $this->Krs->inputDateRange('filterstart', array("class" => "form-control filterDateReceive", 'id' => 'start', 'readonly' => true, 'placeholder' => 'Tgl. mulai..', 'value' => $this->request->getQuery('filterstart')), 'filterend', array("class" => "form-control filterDateReceive", 'id' => 'end', 'readonly' => true, 'placeholder' => 'Tgl. sampai..', 'value' => $this->request->getQuery('filterend')), 's/d', 'resetDateReceive');
                            ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row m-b-15 mb-3">
                    <label class="col-form-label col-md-2">Customer</label>
                    <div class="col-md-9">
                        <?= $this->Form->control('customer_id', ['label' => false, 'class' => 'form-control slc cs', 'empty' => 'Pilih customer...', 'options' => $customers, 'data-parsley-required' => true, 'data-parsley-error-message' => 'Customer harus dipilih !', 'id' => 'customer_id', 'data-parsley-errors-container' => '#check-cs']); ?>

                        <?= $this->Form->control('order_id', ['type' => 'hidden', 'class' => 'form-control orders']); ?>
                    </div>
                    <div class="col-md-1">
                        <div class="btn-group w-100">
                            <?php
                            echo $this->Form->button('<i class="fas fa-search"></i>', array('class' => 'btn btn-yellow', 'type' => 'button', 'id' => 'btnSearch', 'escapeTitle' => false, 'data-toggle' => 'tooltip', 'data-original-title' => "Cari"));
                            ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="table-responsive" style="overflow: auto; height: 250px;">
                    <div id="tableContainerProduk"></div>
                    <div id="tableContainerRincian"></div>
                    <table class="table table-hover table-bordered order" id="hideTable">
                        <thead class="bg-default">
                            <tr class="text-center">
                                <th width="5%">#</th>
                                <th width="25%">Item</th>
                                <th width="15%">Harga</th>
                                <th width="20%">Jumlah</th>
                                <th width="10%">Diskon (%)</th>
                                <th width="25%">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center" colspan="6">Data Kosong</td>
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


        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        $(document).on('click', '#btnSearch', () => {

            $.ajax({
                url: "<?php echo $this->Url->build(['prefix' => "Transaction", 'controller' => 'Invoices', 'action' => 'getOrder']); ?>",
                method: "GET",
                dataType: "json",
                data: {
                    start: $('#start').val(),
                    end: $('#end').val(),
                    customer: $('#customer_id').val()
                },
                success: function(data) {
                    if (data) {
                        //alert(data.result[0].id);
                        $('#totalTagihan').text(data.result[0].grandtotal);
                        $('.orders').val(data.result[0].id); 

                        // Tampilkan data produk order
                        displayDataProduk(data);

                        // Tampilkan data rincian order
                        displayDataRincian(data);

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

        // Fungsi javascript untuk menampilkan produk
        function displayDataProduk(data) {
            // Ambil elemen tabel sesuai dengan ID elemen tabel 
            var tableContainerProduk = $('#tableContainerProduk');
            
            // Hapus konten tabel sebelumnya
            tableContainerProduk.empty();

            // Bangun tabel HTML
            var tableHtml = '<table class="table table-hover table-bordered order" align="center">';
            tableHtml += '<thead class="bg-default">';
            tableHtml += '<tr class="text-center">';
            tableHtml += '<th width="5%">#</th>';
            tableHtml += '<th width="25%">Item</th>';
            tableHtml += '<th width="15%">Harga</th>';
            tableHtml += '<th width="20%">Jumlah</th>';
            tableHtml += '<th width="10%">Diskon</th>';
            tableHtml += '<th width="25%">Total</th>';
            tableHtml += '</tr>';
            tableHtml += '</thead>';
            tableHtml += '<tbody>';

            for (var i = 0; i < data.result.length; i++) {
                tableHtml += '<tr>';
                tableHtml += '<td align="center">' + (i + 1) + '</td>';
                tableHtml += '<td align="left">' + (data.result[i].item) + '</td>';
                tableHtml += '<td align="right">' + (data.result[i].harga) + '</td>';
                tableHtml += '<td align="center">' + (data.result[i].jumlah) + ' ' + (data.result[i].unit) + '</td>';
                tableHtml += '<td align="center">' + (data.result[i].diskon_item) + ' %' + '</td>';
                tableHtml += '<td align="right">' + (data.result[i].total) + '</td>';
                tableHtml += '</tr>';
            }

            tableHtml += '</tbody>';
            tableHtml += '</table>';

            // Tampilkan tabel di dalam elemen '#tableContainerProduk'
            tableContainerProduk.html(tableHtml);
        }

        // Fungsi javascript untuk menampilkan produk
        function displayDataRincian(data) {
            // Ambil elemen tabel sesuai dengan ID elemen tabel 
            var tableContainerRincian = $('#tableContainerRincian');
            
            // Hapus konten tabel sebelumnya
            tableContainerRincian.empty();

            // Bangun tabel HTML
            var tableHtml = '<div class="row">';
            tableHtml = '<div class="col-md-4">&nbsp;</div>';
            tableHtml = '<div class="col-md-8">';
            tableHtml = '<table class="table table-bordered">';
            tableHtml += '<tbody>';
            tableHtml += '<tr>';
            tableHtml += '<td width="60%" class="table-info"><strong>Subtotal</strong></td>';
            tableHtml += '<td width="40%" class="text-end"><strong>' + (data.result[0].total) + '</strong></td>';
            tableHtml += '</tr>';
            tableHtml += '<tr>';
            tableHtml += '<td width="60%" class="table-info"><strong>Biaya Pengiriman</strong></td>';
            tableHtml += '<td width="40%" class="text-end"><strong>' + (data.result[0].biaya_pengiriman) + '</strong></td>';
            tableHtml += '</tr>';

            tableHtml += '<tr>';
            tableHtml += '<td width="60%" class="table-info"><strong>Diskon (%)</strong></td>';
            tableHtml += '<td width="40%" class="text-end"><strong>' + (data.result[0].diskon) + ' %' + '</strong></td>';
            tableHtml += '</tr>';
            tableHtml += '<tr>';
            tableHtml += '<td width="60%" class="table-info"><strong>GRAND TOTAL</strong></td>';
            tableHtml += '<td width="40%" class="text-end"><input type="hidden" name="grandtotal" class="grandtotal"><strong>' + (data.result[0].grandtotal) + '</strong></td>';
            tableHtml += '</tr>';
            tableHtml += '</tbody>';
            tableHtml += '</table>';
            tableHtml += '</div>';
            tableHtml += '</div>';

            // Tampilkan tabel di dalam elemen '#tableContainerRincian'
            tableContainerRincian.html(tableHtml);
        }

        // Fungsi javascript untuk hide table
        function hideData(data) {
            // Logika untuk menyembunyikan elemen dengan ID hideTable
            $('#hideTable').hide();
        }

</script>
