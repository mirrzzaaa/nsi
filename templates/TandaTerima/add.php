<?php
//pr($customers);
$dataChild = $this->Html->link('Tanda Terima', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Buat') ?>
<?= $this->Form->create($tandaTerima, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?> 

<div class="row"> 
    <div class="col-md-6">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-file-alt fa-lg me-2 text-gray text-opacity-50"></i> 
                Tanda Terima
            </div>  
            <div class="card-body">
                <div class="row"> 
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">No. Tanda Terima</label>
                        <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $data['lastNumber'], 'disabled']); ?>
                    </div> 
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Tgl. Buat</label>
                        <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tgl. tanda terima', 'value' => date('d-m-Y'), 'readonly']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">No. Faktur Pajak</label>
                        <?= $this->Form->control('no_faktur', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No. faktur pajak...']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">No. Berita Acara</label>
                        <?= $this->Form->control('no_ba', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No. berita acara...']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">No. Surat Jalan</label>
                        <?= $this->Form->control('permit_id', ['label' => false, 'class' => 'form-control slc', 'data-placeholder' => 'Pilih no. surat jalan', 'empty' => 'Pilih no. surat jalan', 'options' => $permits]); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Catatan</label>
                        <?= $this->Form->control('description', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Catatan...']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-truck-loading fa-lg me-2 text-gray text-opacity-50"></i>
                Data Invoice
            </div>
            <div class="card-body">
                <div class="row m-b-15 mt-2">
                    <div class="col-3 col-sm-3 mb-1 d-flex align-items-center">
                        <b>Cari Invoice</b>
                    </div>
                    <div class="col-9 col-sm-9 mb-1">
                        <?= $this->Form->control('invoice_id', ['label' => false, 'class' => 'form-control inv', 'data-placeholder' => 'No. invoice...', 'empty' => 'No. invoice...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'No. invoice harus dipilih !', 'data-parsley-errors-container' => '#check-item']); ?>
                        <div id="check-item"></div>
                    </div>
                </div>
                <br>
                <hr>
                <table class="table m-b-0 table-advance table-hover" cellspacing="0" cellpadding="1" border="0" align="center" id="tableHead">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                </table>
                <div id="tableContainer"></div>
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
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'TandaTerima', 'action' => 'add'], ['fullBase' => true]); ?>";
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
        $('.inv').select2({
            minimumInputLength: 2, // Minimal karakter untuk memulai pencarian
            ajax: {
                url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'TandaTerima', 'action' => 'getinvoice']); ?>",
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
                url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'TandaTerima', 'action' => 'setinvoice']); ?>",
                method: "get",
                data: {
                    id: ids
                },
                success: function(data) {
                    if (data) { 
                        // Tampilkan data order
                        displayData(data);
                    }
                }
            });
        });

        // Fungsi javascript untuk menampilkan produk
        function displayData(data) {
            $('#tableHead').hide(); 

            // Ambil elemen tabel sesuai dengan ID elemen tabel 
            var tableContainer = $('#tableContainer');
            
            // Hapus konten tabel sebelumnya
            tableContainer.empty();

            // Bangun tabel HTML
            var tableHtml = '<div>';
            tableHtml += '<table class="table m-b-0 table-advance table-hover" cellspacing="0" cellpadding="1" border="0" align="center">';
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
            tableHtml += '</div>';

            // Tampilkan tabel di dalam elemen '#tableContainer'
            tableContainer.html(tableHtml);
        }

    });

    function isikan() {
      $('.slc').val('');
      $('.slc').prop('disabled', true);
    }
</script>
