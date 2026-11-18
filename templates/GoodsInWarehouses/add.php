<?php
// pr($data['lastNumber']);
$dataChild = $this->Html->link('Masuk Gudang', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Tambah') ?> 
<?= $this->Form->create($goodsInWarehouse, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-truck-loading fa-lg me-2 text-gray text-opacity-50"></i>
                Barang Masuk
            </div>
            <div class="card-body">
                <div class="row"> 
                    <div class="col-md-3 mb-3">
                        <label for="" class="form-label">Kode</label>
                        <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $data['lastCode'], 'disabled']); ?>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="" class="form-label">Tanggal</label>
                        <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control tgl', 'value' => date('d-m-Y'), 'type' => 'text', 'readonly']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Keterangan</label>
                        <?= $this->Form->control('description', ['label' => false, 'class' => 'form-control', 'type' => 'text', 'placeholder' => 'Keterangan...']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center"> 
        <i class="fas fa-search fa-lg me-2 text-gray text-opacity-50"></i>
        Cari Data
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Dari</label>  
                <?= $this->Form->control('is_from', ['label' => false, 'class' => 'form-control from', 'options' => $this->Krs->_from()]); ?>
            </div>
            <div class="col-md-8 mb-3">
                <label for="" class="form-label">Ke Gudang</label>
                <?= $this->Form->control('warehouse_id', ['label' => false, 'class' => 'form-control slc wh', 'options' => $warehouses, 'empty' => 'Pilih data...']); ?>
            </div>
        </div>

        <!-- dari po  -->
        <div class="spo">
            <?= $this->Form->text('purchasing_ids', ['label' => false, 'class' => 'form-control finding', 'placeholder' => 'Cari nomor purchase order (PO)...', 'id' => "jquery-autocompletePo"]); ?>
            <?= $this->Form->hidden('purchasing_id', ['class' => 'purchasing_id']); ?>
        </div>
        <!-- dari gudang  -->
        <!-- <div class="sws">
            $this->Form->text('goods_out_warehouse_ids', ['label' => false, 'class' => 'form-control findingWhot', 'placeholder' => 'Cari nomor keluar gudang...', 'id' => "jquery-autocompleteWhot"]);
            $this->Form->hidden('goods_out_warehouse_id', ['class' => 'goods_out_warehouse_id']);
        </div> -->
        <!-- dari toko  -->
        <!-- <div class="stws">
            $this->Form->text('goods_out_store_ids', ['label' => false, 'class' => 'form-control findingStout', 'placeholder' => 'Cari nomor keluar toko...', 'id' => "jquery-autocompleteSout"]);
            $this->Form->hidden('goods_out_store_id', ['class' => 'goods_out_store_id', 'value' => !empty($this->request->getData('goods_out_store_id')) ? $this->request->getData('goods_out_store_id') : 0]);

        </div> -->
    </div>
</div>


<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-briefcase-medical fa-lg me-2 text-gray text-opacity-50"></i>
                Produk Masuk
            </div>
            <div class="card-body">
                <div class="table-responsive mb-3" style="overflow: auto; height: 230px;">
                    <table class="table table-hover table-panel text-nowrap align-middle mb-0 po">
                        <thead>
                            <tr>
                                <th width="250">Produk</th>
                                <th width="50" class="text-center">Jumlah</th>
                                <th width="60" class="text-center">Unit</th>
                                <th width="100">Nomor Seri</th>
                                <th width="100">Kode Produk</th>
                                <th width="100">Kode Supplier</th>
                                <th width="100">Nama Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center">
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
        $('.spo').hide();
        $('.sws').hide();
        $('.stws').hide();

        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsInWarehouses', 'action' => 'add'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);



        $('.slc').select2({
            placeholder: "Pilih salah satu"
        });

        $('.from').select2({
            placeholder: "Pilih salah satu"
        }).on('select2:select', function(e) {
            $('.po>tbody').html('');

            var key = e.params.data.id;

            if (key == 'Purchasing') {
                $('.spo').show();
                $('.sws').hide();
                $('.stws').hide();
                $('.codepo').focus();
            } else if (key == 'Warehouse') {
                $('.sws').show();
                $('.spo').hide();
                $('.stws').hide();
                $('.codewhout').focus();
            } else {
                $('.stws').show();
                $('.spo').hide();
                $('.sws').hide();
                $('.codesout').focus();
            }
        });

        // javascript barang dari purchasing
        $("#jquery-autocompletePo").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsInWarehouses', 'action' => 'getpo']); ?>",
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
                    url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsInWarehouses', 'action' => 'setpo']); ?>",
                    method: "get",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data) {
                            $('.wh').val(data.warehouse_id).trigger("change");
                            $('.wh').prop('readonly', true);
                            // $('.warehouse_id').val(data.warehouse_id);
                            $('.purchasing_id').val(data.id).trigger("change");
                            if ((data.purchasing_lines).length > 0) {
                                $('.po>tbody').html('');
                                $.each(data.purchasing_lines, function(i, val) {
                                    if (val.quantity > 0) {
                                        $('.po>tbody').append('<tr><td><input type="hidden" name="goods_in_warehouse_lines[' + i + '][item_id]" value="' + val.item.id + '"><input type="hidden" name="goods_in_warehouse_lines[' + i + '][purchasing_line_id]" value="' + val.id + '"><input class="form-control" value="' + ((val.item) ? val.item.name : '-') + '" disabled></td><td><input class="form-control text-center qty" name="goods_in_warehouse_lines[' + i + '][qty]" value="' + rupiah(val.quantity) + '" max="' + val.quantity + '" min="0" readonly></td><td><input name="goods_in_warehouse_lines[' + i + '][unit]" value="' + val.item.unit + '" class="form-control text-center" readonly></td><td><input class="form-control" placeholder="Nomor seri..." name="goods_in_warehouse_lines[' + i + '][nomor_seri]"></td><td><input class="form-control" placeholder="Kode produk..." name="goods_in_warehouse_lines[' + i + '][kode_produk]"></td><td><input class="form-control" placeholder="Kode supplier..." name="goods_in_warehouse_lines[' + i + '][supplier_code]"></td><td><input class="form-control" placeholder="Nama supplier..." name="goods_in_warehouse_lines[' + i + '][supplier_name]"></td></tr>');
                                    }
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


        // javascript barang dari gudang
        $("#jquery-autocompleteWhot").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsInWarehouses', 'action' => 'getwhout']); ?>",
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
                //alert(id);
                $.ajax({
                    url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsInWarehouses', 'action' => 'setwhout']); ?>",
                    method: "get",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data) {
                            $('.goods_out_warehouse_id').val(data.id).trigger("change");
                            if ((data.goods_out_warehouse_lines).length > 0) {
                                $('.po>tbody').html('');
                                $.each(data.goods_out_warehouse_lines, function(i, val) {
                                    $('.po>tbody').append('<tr><td><input type="hidden" name="goods_in_warehouse_lines[' + i + '][item_id]" value="' + val.item_id + '"><input type="hidden" name="goods_in_warehouse_lines[' + i + '][goods_out_warehouse_line_id]" value="' + val.id + '"><input type="hidden" name="goods_in_warehouse_lines[' + i + '][goods_out_store_line_id]" value="0"><input type="hidden" name="goods_in_warehouse_lines[' + i + '][purchasing_line_id]" value="0"><input class="form-control" value="' + ((val) ? val.name : '-') + '" disabled></td><td><input type="number" class="form-control text-end qty" name="goods_in_warehouse_lines[' + i + '][qty]" value="' + rupiah(val.qty) + '" max="' + val.qty + '" min="0"></td><td><input name="goods_in_warehouse_lines[' + i + '][unit]" value="' + val.unit + '" class="form-control" readonly></td><td><input class="form-control" placeholder="Keterangan..." name="goods_in_warehouse_lines[' + i + '][description]"></td></tr>');
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

        // javascript barang dari toko
        $("#jquery-autocompleteSout").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsInWarehouses', 'action' => 'getsout']); ?>",
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
                    url: "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsInWarehouses', 'action' => 'setsout']); ?>",
                    method: "get",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data) { 
                            $('.goods_out_store_id').val(data.id).trigger("change");
                            if ((data.goods_out_store_lines).length > 0) {
                                $('.po>tbody').html(''); 
                                $.each(data.goods_out_store_lines, function(i, val) {
                                    $('.po>tbody').append('<tr><td><input type="hidden" name="goods_in_warehouse_lines[' + i + '][item_id]" value="' + val.item.id + '"><input type="hidden" name="goods_in_warehouse_lines[' + i + '][goods_out_warehouse_line_id]" value="0"><input type="hidden" name="goods_in_warehouse_lines[' + i + '][goods_out_store_line_id]" value="' + val.id + '"><input type="hidden" name="goods_in_warehouse_lines[' + i + '][purchasing_line_id]" value="0"><input class="form-control" value="' + ((val.item) ? val.item.name : '-') + '" disabled></td><td><input type="number" class="form-control text-end qty" name="goods_in_warehouse_lines[' + i + '][qty]" value="' + rupiah(val.qty) + '" max="' + val.qty + '" min="0"></td><td><input name="goods_in_warehouse_lines[' + i + '][unit]" value="' + val.item.unit + '" class="form-control" readonly></td><td><input class="form-control" placeholder="Keterangan..." name="goods_in_warehouse_lines[' + i + '][description]"></td></tr>');
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

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });


        $(document).on('click', '.btn-remove', function(index) {
            $(this).closest('tr').remove();

        });
    });
</script>
