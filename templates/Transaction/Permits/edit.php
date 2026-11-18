<?php
$dataChild = $this->Html->link('Surat Jalan', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Ubah') ?>
<?= $this->Form->create($permit, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<?php
$customer = $permit->order->pelanggan;
$namaCustomer = $customer->name;
$alamatCustomer = $customer->address_penghasil;

// pr($permit);

?>

<div class="row">
    <div class="col-md-6"> 
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-file-alt fa-lg me-2 text-gray text-opacity-50"></i>
                Surat Jalan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">No. Surat Jalan</label>
                        <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $permit->code, 'readonly']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Tgl. Pengiriman</label>
                        <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tgl. surat jalan', 'value' => ($permit->date == null ? '' : date_format($permit->date, 'd-m-Y')), 'readonly']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Pengirim</label>
                        <?= $this->Form->control('delivered', ['label' => false, 'class' => 'form-control delivered', 'placeholder' => 'Contoh : Resi Expedisi, Nopol truck, admin pengiriman...', 'onkeyup' => 'isikan()']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Truck</label>
                        <?= $this->Form->control('truck_id', ['label' => false, 'class' => 'form-control slc', 'data-placeholder' => 'Pilih salah satu truk', 'empty' => 'Pilih salah satu truk', 'options' => $trucks]); ?> 
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Catatan</label>
                        <?= $this->Form->control('description', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Catatan...', 'type' => 'textarea']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-truck-loading fa-lg me-2 text-gray text-opacity-50"></i>
                Data Order
            </div>
            <div class="card-body">
                <div class="row m-b-15">
                    <div class="col-3 col-sm-3 mb-1 d-flex align-items-center">
                        <b>Cari Order</b>
                    </div>
                    <div class="col-9 col-sm-9 mb-1">
                        <?= $this->Form->control('order_id', ['label' => false, 'class' => 'form-control order', 'data-placeholder' => 'No. Order...', 'empty' => 'No. Order...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'No. Order harus dipilih !', 'data-parsley-errors-container' => '#check-item']); ?>
                        <div id="check-item"></div>
                    </div>
                </div>
                <hr>
                <div class="row m-b-15">
                    <div class="col-3 col-sm-3 mb-1 d-flex align-items-center">
                        <b>No. Order</b>
                    </div>
                    <div class="col-1 col-sm-1 mb-1 d-flex align-items-center">: </div>
                    <div class="col-8 col-sm-8 mb-2">
                        <?= $this->Form->control('code_order)', ['label' => false, 'class' => 'form-control code', 'placeholder' => 'No. Order...', 'readonly', 'value' => $permit->code]); ?>
                    </div>

                    <div class="col-3 col-sm-3 mb-1 d-flex align-items-center">
                        <b>Customer</b>
                    </div>
                    <div class="col-1 col-sm-1 mb-1 d-flex align-items-center">: </div>
                    <div class="col-8 col-sm-8 mb-2">
                        <?= $this->Form->control('nama_customer', ['label' => false, 'class' => 'form-control customer', 'placeholder' => 'Customer...', 'readonly', 'value' => $namaCustomer]); ?>
                    </div>

                    <div class="col-3 col-sm-3 mb-1 d-flex align-items-center">
                        <b>Alamat</b>
                    </div>
                    <div class="col-1 col-sm-1 mb-1 d-flex align-items-center">: </div>
                    <div class="col-8 col-sm-8 mb-1">
                        <?= $this->Form->control('alamat_customer', ['label' => false, 'class' => 'form-control address', 'placeholder' => 'Alamat...', 'readonly', 'value' => $alamatCustomer]); ?>
                    </div>

                </div>
                <hr>
                <div id="tableContainer"></div>

                <div class="table-responsive" id="rincian">
                    <table class="table m-b-0 table-advance table-hover">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>#</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (!empty($permit->permit_order_lines)) {
                                foreach ($permit->permit_order_lines as $permitOrderLine) { 
                                    // Ambil order_line dari relasi OrderLines
                                    $orderLine = $permitOrderLine->order_line ?? null;
                                    if ($orderLine) {
                            ?>
                                    <tr>
                                        <td class="text-center"><?= $no; ?></td>
                                        <td><?= ($orderLine->item->name) ?></td>
                                        <td class="text-center"><?= $this->Krs->_currency($orderLine->quantity) . ' ' . $orderLine->unit; ?> </td>
                                    </tr>
                            <?php
                                        $no++;
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center'>Data tidak ditemukan</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
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
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Permits', 'action' => 'edit', $permit->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        $('.slc').select2().on('select2:select', (e) => {
            $('.delivered').val('');
            $('.delivered').prop('disabled', true);
        });

        // Inisialisasi Select2 dengan AJAX untuk mengambil data pesanan
        $('.order').select2({
            minimumInputLength: 2, // Minimal karakter untuk memulai pencarian
            ajax: {
                url: "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Permits', 'action' => 'getorder']); ?>",
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
                url: "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Permits', 'action' => 'setorder']); ?>",
                method: "get",
                data: {
                    id: ids
                },
                success: function(data) {
                    if (data) {
                        // Memperbarui elemen halaman dengan detail pesanan yang diterima
                        $('.code').val(data.order.code); 
                        $('.customer').val(data.order.pelanggan.name);
                        $('.address').val(data.order.pelanggan.address_penghasil); 

                        // Tampilkan data order
                        displayTampilProduk(data);

                        // Sembunyikan elemen data order
                        hideElemen(data) 
                    }
                }
            });
        });

        // Fungsi javascript untuk menampilkan produk
        function displayTampilProduk(data) {
            // Ambil elemen tabel sesuai dengan ID elemen tabel 
            var tableContainer = $('#tableContainer');
            
            // Hapus konten tabel sebelumnya
            tableContainer.empty();

            // Bangun tabel HTML
            var tableHtml = '<table class="table m-b-0 table-advance table-hover" cellspacing="0" cellpadding="1" border="0" align="center">';
            tableHtml += '<thead class="thead-dark text-center">';
            tableHtml += '<tr>';
            tableHtml += '<th>#</th>';
            tableHtml += '<th>Produk</th>';
            tableHtml += '<th>Jumlah</th>';
            tableHtml += '</tr>';
            tableHtml += '</thead>';
            tableHtml += '<tbody>';

            for (var i = 0; i < data.result.length; i++) {
                tableHtml += '<tr>';
                tableHtml += '<td align="center">' + (i + 1) + '</td>';
                tableHtml += '<td>' + (data.result[i].name) + '</td>';
                tableHtml += '<td align="center">' + (data.result[i].quantity) + ' ' + (data.result[i].unit) + '</td>';
                tableHtml += '</tr>';
            }

            tableHtml += '</tbody>';
            tableHtml += '</table>';

            // Tampilkan tabel di dalam elemen '#tableContainer'
            tableContainer.html(tableHtml);
        }

        function hideElemen(data) {
            var elemen = document.getElementById("rincian");
            elemen.style.display = "none";
        }

    });

    function isikan() {
        $('.slc').prop('disabled', true);
    }
</script>
