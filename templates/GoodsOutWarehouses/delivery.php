<?php
//pr($warehouses);

$dataChild = $this->Html->link('Barang Keluar Gudang', ['prefix' => false, 'controller' => 'GoodsOutWarehouses', 'action' => 'index'], ['full_base'=>true]);
?>
 
<?= $this->Krs->breadcrumb_($dataChild, 'Pengiriman', '') ?>
<?= $this->Form->create($goodsOutWarehouse, []) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center"> 
        <i class="fas fa-search fa-lg me-2 text-gray text-opacity-50"></i>
        Cari Surat Jalan
    </div>
    <div class="card-body">
        <?= $this->Form->control('permit_id', ['label' => false, 'class' => 'form-control finding', 'data-placeholder' => 'Cari nomor surat jalan...', 'empty' => 'Cari nomor surat jalan...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'No. surat jalan harus dipilih !', 'data-parsley-errors-container' => '#check-item']); ?>
        <div id="check-item"></div>
    </div>
</div> 
 
<div class="card border-0">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fas fa-truck-loading fa-lg me-2 text-gray text-opacity-50"></i> 
        Pengiriman
    </div>
    <div class="card-body">
            <div class="row">
                    <div class="col-1 col-sm-1 mb-1 d-flex align-items-center">
                        <b>Customer</b>
                    </div>
                    <div class="col-1 col-sm-1 mb-1 d-flex align-items-center">: </div>
                    <div class="col-10 col-sm-10 mb-2">
                        <?= $this->Form->control('customer', ['label' => false, 'class' => 'form-control customer', 'placeholder' => 'Customer...', 'readonly']); ?>
                        <?= $this->Form->control('gudang', ['label' => false, 'type' => 'hidden', 'class' => 'form-control gudang', 'placeholder' => 'Gudang...', 'readonly']); ?>
                        <?= $this->Form->control('is_to', ['label' => false, 'type' => 'hidden', 'class' => 'form-control slcb', 'empty' => 'Pilih...', 'options' => $this->Krs->_to()]); ?>
                    </div>

                    <div class="col-1 col-sm-1 mb-1 d-flex align-items-center">
                        <b>Telepon</b>
                    </div>
                    <div class="col-1 col-sm-1 mb-1 d-flex align-items-center">: </div>
                    <div class="col-10 col-sm-10 mb-2">
                        <?= $this->Form->control('telepon', ['label' => false, 'class' => 'form-control telepon', 'placeholder' => 'Telepon...', 'readonly']); ?>
                    </div>

                    <div class="col-1 col-sm-1 mb-1 d-flex align-items-center">
                        <b>PIC</b>
                    </div>
                    <div class="col-1 col-sm-1 mb-1 d-flex align-items-center">: </div>
                    <div class="col-10 col-sm-10 mb-2">
                        <?= $this->Form->control('pic', ['label' => false, 'class' => 'form-control pic', 'placeholder' => 'PIC...', 'readonly']); ?>
                    </div>

                    <div class="col-1 col-sm-1 mb-1 d-flex align-items-center">
                        <b>Alamat</b>
                    </div>
                    <div class="col-1 col-sm-1 mb-1 d-flex align-items-center">: </div>
                    <div class="col-10 col-sm-10 mb-2">
                        <?= $this->Form->control('address', ['label' => false, 'class' => 'form-control address', 'placeholder' => 'Alamat...', 'readonly']); ?>
                    </div>

                </div>
        <hr>
        <div class="table-responsive mb-3" style="overflow: auto; height: 200px;">
            <table class="table table-hover table-panel text-nowrap align-middle mb-3 order" id="hideTable">
                <thead style="position: sticky; top: 0; z-index: 1;">
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="30%" class="text-center">Produk</th>
                        <th width="10%" class="text-center">Jumlah</th>
                        <th class="text-center" width="10%">Unit</th>
                        <th class="text-center" width="45%">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $this->Krs->dataNull(); ?> 
                </tbody>
            </table>
            <table class="table table-hover table-panel text-nowrap align-middle mb-3 order">
                <tbody>
                    <div id="tableContainer"></div>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="form-group">
            <label for="" class="form-label">Keterangan</label>
            <?= $this->Form->control('description', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Keterangan...']); ?>
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

    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }

    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsOutWarehouses', 'action' => 'delivery'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);


        // Inisialisasi Select2 dengan AJAX untuk mengambil data surat jalan
        $('.finding').select2({
            minimumInputLength: 2, // Minimal karakter untuk memulai pencarian
            ajax: {
                url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsOutWarehouses', 'action' => 'getorder']); ?>",
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
                url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsOutWarehouses', 'action' => 'setorder']); ?>",
                method: "get",
                data: {
                    id: ids
                },
                success: function(data) {
                    if (data) {
                        // Memperbarui elemen halaman dengan detail pesanan yang diterima
                        $('.customer').val(data.permit.order.pelanggan.name); 
                        $('.telepon').val(data.permit.order.pelanggan.telp_person);
                        $('.pic').val(data.permit.order.pelanggan.contact_person); 
                        $('.address').val(data.permit.order.pelanggan.address_penghasil);
                        $('.gudang').val(data.permit.order.warehouse.id); 

                        // Tampilkan data permit
                        displayData(data);

                        // Sembunyikan data dengan id = hideTable 
                        hideData(data);
                    } 
                }
            });
        });
    });

        // Fungsi javascript untuk menampilkan produk
        function displayData(data) {
            // Ambil elemen tabel sesuai dengan ID elemen tabel 
            var tableContainer = $('#tableContainer');
            
            // Hapus konten tabel sebelumnya
            tableContainer.empty(); 

            // Bangun tabel HTML
            var tableHtml = '';
            var tableHtml = '<table class="table m-b-0 table-advance table-hover" cellspacing="0" cellpadding="1" border="0" align="center">';
            tableHtml += '<thead class="thead-dark text-center">';
            tableHtml += '<tr>';
            tableHtml += '<th>#</th>';
            tableHtml += '<th>Produk</th>';
            tableHtml += '<th>Jumlah</th>';
            tableHtml += '<th>Unit</th>'; 
            tableHtml += '<th>Deskripsi</th>';
            tableHtml += '</tr>';
            tableHtml += '</thead>';
            tableHtml += '<tbody>';

            for (var i = 0; i < data.result.length; i++) {
                //var dataArray = data.result[i].item_id + '^' + data.result[i].name + '^' + data.result[i].quantity + '^' + data.result[i].unit + '^' + data.result[i].deskripsi;
                //alert(dataArray);

                var dataItemId = data.result[i].item_id;
                var dataName = data.result[i].name;
                var dataQuantity = data.result[i].quantity;
                var dataUnit = data.result[i].unit;
                var dataDeskripsi = data.result[i].deskripsi;

                // Buat baris tabel dengan data
                tableHtml += '<tr>';
                tableHtml += '<td width="5%" align="center">' + (i + 1) + '<input type="hidden" name="goods_out_warehouse_lines[' + i + '][item_id]" autocomplete="off" value="' + dataItemId + '"/></td>';
                tableHtml += '<td width="25%">' + data.result[i].name + '<input type="hidden" name="goods_out_warehouse_lines[' + i + '][name]" autocomplete="off" value="' + dataName + '"/></td>';
                tableHtml += '<td width="10%" align="center">' + data.result[i].quantity + '<input type="hidden" name="goods_out_warehouse_lines[' + i + '][qty]" autocomplete="off" value="' + dataQuantity + '"/></td>';
                tableHtml += '<td width="10%" align="center">' + data.result[i].unit + '<input type="hidden" name="goods_out_warehouse_lines[' + i + '][unit]" autocomplete="off" value="' + dataUnit + '"/></td>';
                tableHtml += '<td width="50%" align="left">' + data.result[i].deskripsi + '<input type="hidden" name="goods_out_warehouse_lines[' + i + '][description]" autocomplete="off" value="' + dataDeskripsi + '"/></td>';
                tableHtml += '</tr>';
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

</script>
