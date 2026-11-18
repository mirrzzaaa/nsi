<?php
$dataChild = $this->Html->link('Masuk Toko', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Tambah') ?>
<?= $this->Form->create($goodsInStore, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>
<?= $this->Form->control('goods_out_warehouse_id', ['type' => 'hidden', 'class' => 'goodswh']); ?>
<?= $this->Form->control('goods_out_store_id', ['type' => 'hidden', 'class' => 'goodsso']); ?>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fas fa-search fa-lg me-2 text-gray text-opacity-50"></i>
        Cari Data
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Dari</label>
                <?= $this->Form->control('is_from', ['label' => false, 'class' => 'form-control from', 'options' => $this->Krs->typeItem(), 'data-parsley-required' => true, 'data-parsley-errors-container' => '#check-from', 'data-parsley-required-message' => 'Asal Produk harus dipilih !']); ?>
                <div id="check-from"></div>
            </div>
            <div class="col-md-8 mb-3">
                <label for="" class="form-label">Ke Toko</label>
                <?= $this->Form->control('branch_id', ['label' => false, 'class' => 'form-control slc', 'options' => $branches, 'data-placeholder' => 'Pilih salah satu',  'empty' => 'Pilih salah satu', 'data-parsley-required' => true, 'data-parsley-errors-container' => '#check-to', 'data-parsley-required-message' => 'Tujuan Produk harus dipilih !']); ?>
                <div id="check-from"></div>
            </div>
        </div>

        <!-- dari gudang  -->
        <div class="spo">
            <div class="form-group">
                <?= $this->Form->control('codes', ['label' => false, 'type' => 'text', 'class' => 'form-control codepo', 'id' => 'jquery-autocompleteSt', 'placeholder' => 'No. Keluar Toko...', 'autofocus']); ?>
            </div>
        </div>
        <!-- dari toko  -->
        <div class="sws">
            <div class="form-group">
                <?= $this->Form->control('codes', ['label' => false, 'type' => 'text', 'class' => 'form-control codewhout', 'id' => 'jquery-autocompleteWh', 'placeholder' => 'No. Keluar Gudang...', 'autofocus']); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-truck-loading fa-lg me-2 text-gray text-opacity-50"></i>
                Barang Masuk
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="" class="form-label">Kode</label>
                    <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $data['lastNumber'], 'disabled']); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Tanggal</label>
                    <?= $this->Form->control('date', ['label' => false, 'class' => 'form-control tgl', 'value' => date('d-m-Y'), 'type' => 'text', 'readonly']); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 mb-3">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-briefcase-medical fa-lg me-2 text-gray text-opacity-50"></i>
                Produk Masuk
            </div>
            <div class="card-body">
                <div class="table-responsive mb-3" style="overflow: auto; height: 230px;">
                    <table class="table table-hover table-panel text-nowrap align-middle mb-0 po">
                        <thead style="position: sticky; top: 0; z-index: 1;">
                            <tr>
                                <th width="500">Produk</th>
                                <th width="80" class="text-center">Jumlah</th>
                                <th width="100" class="text-center">Unit</th>
                                <th width="200">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center">
                                    <h6>Data Kosong</h6>
                                </td>
                            </tr>
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


<?= $this->Form->end() ?>

<script>
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }

    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsInStores', 'action' => 'add'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $('.spo').hide();
        $('.sws').hide();
        // $('.codewhout').focus();

        $('.slc').select2({
            placeholder: "Pilih salah satu"
        });

        $('.from').select2({
            placeholder: "Pilih salah satu"
        }).on('select2:select', function(e) {
            $('.po>tbody').html('');

            var key = e.params.data.id;

            if (key == 'Warehouse') {
                $('.sws').show();
                $('.spo').hide();
                $('.codewhout').focus();
            } else {
                $('.spo').show();
                $('.sws').hide();
                $('.codepo').focus();
            }
        });

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        // cari dari gudang keluar
        $("#jquery-autocompleteWh").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsInStores', 'action' => 'getwhout']); ?>",
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
                    url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsInWarehouses', 'action' => 'setwhout']); ?>",
                    method: "get",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data) {
                            $('.goodswh').val(data.id);
                            if ((data.goods_out_warehouse_lines).length > 0) {
                                $('.po>tbody').html('');
                                $.each(data.goods_out_warehouse_lines, function(i, val) {
                                        $('.po>tbody').append('<tr><td><input type="hidden" name="goods_in_store_lines[' + i + '][item_id]" value="' + val.id + '"><input type="hidden" name="goods_in_store_lines[' + i + '][goods_out_warehouse_line_id]" value="' + val.id + '"><input type="hidden" name="goods_in_store_lines[' + i + '][goods_out_warehouse_line_id]" value="' + val.id + '"><input class="form-control" value="' + ((val) ? val.name : '-') + '" disabled></td><td><input type="number" class="form-control text-end qty" name="goods_in_store_lines[' + i + '][qty]" value="' + rupiah(val.qty) + '" max="' + val.qty + '" min="0"></td><td><input name="goods_in_store_lines[' + i + '][unit]" value="' + val.unit + '" class="form-control" readonly></td><td><input class="form-control" placeholder="Keterangan..." name="goods_in_store_lines[' + i + '][description]"></td></tr>');
                                });
                            } else {
                                $('.po>tbody').append('<tr><td colspan="5" class="text-center">Data Kosong</td></tr>');
                            }
                        } else {
                            $('.po>tbody').append('<tr><td colspan="5" class="text-center">Data Kosong</td></tr>');
                        }
                    }
                });

            }
        });


        // cari dari toko keluar
        $("#jquery-autocompleteSt").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsInStores', 'action' => 'getsout']); ?>",
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
                    url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsInStores', 'action' => 'setsout']); ?>",
                    method: "get",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data) {
                            $('.goodsso').val(data.id);
                            if ((data.goods_out_store_lines).length > 0) {
                                $('.po>tbody').html('');
                                $.each(data.goods_out_store_lines, function(i, val) {
                                    $('.po>tbody').append('<tr><td><input type="hidden" name="goods_in_store_lines[' + i + '][item_id]" value="' + val.item.id + '"><input type="hidden" name="goods_in_store_lines[' + i + '][goods_out_store_line_id]" value="' + val.id + '"><input class="form-control" value="' + ((val.item) ? val.item.name : '-') + '" disabled></td><td><input type="number" class="form-control text-end qty" name="goods_in_store_lines[' + i + '][qty]" value="' + rupiah(val.qty) + '" max="' + val.qty + '" min="0" readonly></td><td><input name="goods_in_store_lines[' + i + '][unit]" value="' + val.item.unit + '" class="form-control" readonly></td><td><input class="form-control" placeholder="Keterangan..." name="goods_in_store_lines[' + i + '][description]"></td></tr>');
                                });
                            } else {
                                $('.po>tbody').append('<tr><td colspan="5" class="text-center">Data Kosong</td></tr>');
                            }
                        } else {
                            $('.po>tbody').append('<tr><td colspan="5" class="text-center">Data Kosong</td></tr>');
                        }
                    }
                });

            }
        });

        $(document).on('click', '.btn-remove', function(index) {
            $(this).closest('tr').remove();

        });
    });
</script>
