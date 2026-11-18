<?php
//pr($orderLine);
$dataChild = $this->Html->link('Keluar Gudang', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Tambah') ?>
<?= $this->Form->create($goodsOutWarehouse, []) ?> 
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?> 

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3">
        <div class="row"> 
            <div class="col-md-3 mb-3">
                <div class="row">
                    <label class="form-label col-form-label col-md-4">Gudang</label>
                    <div class="col-md-12">
                        <?= $this->Form->control('warehouse_id', ['label' => false, 'class' => 'form-control whs', 'options' => $warehouses, 'empty' => 'Pilih...']); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="row">
                    <label class="form-label col-form-label col-md-4">Untuk</label>
                    <div class="col-md-12">
                        <?= $this->Form->control('is_to', ['label' => false, 'class' => 'form-control slcb', 'options' => $this->Krs->_to()]); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="row">
                    <label class="form-label col-form-label col-md-4">Nomor</label>
                    <div class="col-md-12">
                        <?= $this->Form->text('code', ['label' => false, 'class' => 'form-control', 'value' => $data['lastNumber'], 'disabled']); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="row">
                    <label class="form-label col-form-label col-md-4">Tanggal</label>
                    <div class="col-md-12">
                        <?= $this->Form->text('date', ['label' => false, 'class' => 'form-control tgl', 'value' => date('d-m-Y'), 'readonly']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fas fa-truck-loading fa-lg me-2 text-gray text-opacity-50"></i>
        Produk
        <button class="ms-auto btn btn-inverse btn-sm" type="button" id="insert"><i class="fas fa-plus-square"></i></button>
    </div>
    <div class="card-body">
        <div class="table-responsive mb-3" style="overflow: auto; height: 200px;">
            <div style="overflow-x: auto; width: 100%;">
                <table class="table table-hover table-panel text-nowrap align-middle mb-3 order">
                    <thead style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th width="25%">Produk</th>
                            <th width="20%" class="text-center">Stok</th>
                            <th width="15%" class="text-center">Jumlah</th>
                            <th class="text-center" width="15%">Unit</th>
                            <th class="text-center" width="15%">Nomor Seri</th>
                            <th class="text-center" width="15%">Kode Produk</th>
                            <th class="text-center" width="15%">Kode Supplier</th>
                            <th class="text-center" width="15%">Nama Supplier</th>
                            <th class="text-center" width="4%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
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
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsOutWarehouses', 'action' => 'add'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        // $('.order').hide();

        $('.whs').select2({
            placeholder: "Pilih..."
        }).on('select2:select', function(e) {
            let id = e.params.data.id;

            $.ajax({
                url: "<?php echo $this->url->build(['prefix' => false, 'controller' => 'GoodsOutWarehouses', 'action' => 'getitem']); ?>",
                method: "get",
                data: {
                    id: id,
                },
                success: function(data) {
                    if (data.length !== 0) {  
                        dataArr = data;
                        $('#insert').prop('disabled', false);
                        $('.order>tbody').html('');
                    } else {
                        swal("Informasi", "Gudang ini belum memiliki produk, silahkan cari data lainnya", "info");
                        $('#insert').prop('disabled', true);
                    }
                },
                error: function(err) {
                    swal("Informasi", "Error pengambilan data", "error");
                }
            });
        });


        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });


        $('.slcb').select2({
            placeholder: "Pilih..."
        });


        var counter = ($('.order tr').length) - 1;
        $("#insert").on("click", function(e) {
            if (e.originalEvent.defaultPrevented) return;

            var cols = ''; 
            cols += '<tr>'
            cols += '<td><input type="hidden" name="goods_out_warehouse_lines[' + counter + '][warehouse_stock_id]" class="whout"><input type="hidden" name="goods_out_warehouse_lines[' + counter + '][item_id]" class="items"><select class="form-control item" name="" data-parsley-required="true" data-parsley-error-message="Produk harus dipilih !" data-parsley-errors-container="#check-produk"><option value="">Pilih produk...</option></select><div id="check-produk"></div></td>';
            cols += '<td><input type="number" min="1" class="form-control text-end stok" placeholder="0" disabled  name=""></td>';
            cols += '<td><input type="number" min="1" class="form-control text-end qty" placeholder="0" name="goods_out_warehouse_lines[' + counter + '][qty]" data-parsley-required="true" data-parsley-error-message="Jumlah harus diisi !"></td>';

            cols += '<td><input type="text" class="form-control unit" placeholder="Unit..." readonly  name="goods_out_warehouse_lines[' + counter + '][unit]"></td>';

            cols += '<td><input class="form-control" type="text" name="goods_out_warehouse_lines[' + counter + '][nomor_seri]" placeholder="Nomor seri..."></td>';

            cols += '<td><input class="form-control" type="text" name="goods_out_warehouse_lines[' + counter + '][kode_produk]" placeholder="Kode produk..."></td>';

            cols += '<td><input class="form-control" type="text" name="goods_out_warehouse_lines[' + counter + '][supplier_code]" placeholder="Kode supplier..."></td>';

            cols += '<td><input class="form-control" type="text" name="goods_out_warehouse_lines[' + counter + '][supplier_name]" placeholder="Nama supplier..."></td>';

            cols += '<td><input class="form-control name" type="hidden" name="goods_out_warehouse_lines[' + counter + '][name]" placeholder="Name..."></td>';

            cols += '<td class="text-center"><button class="btn btn-pink btn-sm" id="del" type="button"><i class="far fa-trash-alt"></i></button></td>';
            cols += '</tr>';

            // nambah baris didalam tabel
            $(".order>tbody").append(cols);

            $('.item').select2({
                data: dataArr,
                placeholder: 'Pilih produk...'
            }).on('select2:select', function(e) {
                var id = e.params.data.id;
                var tr = $(this).parent().parent();
                $.ajax({
                    url: "<?php echo $this->url->build(['prefix' => false, 'controller' => 'GoodsOutWarehouses', 'action' => 'setitem']); ?>",
                    method: "get",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data) {
                            tr.find('.stok').val(rupiah(data.stock));
                            tr.find('.qty').val(1);
                            tr.find('.unit').val(data.item.unit);
                            tr.find('.items').val(data.item.id);
                            tr.find('.whout').val(data.id);
                            tr.find('.description').val(data.item.description);
                            tr.find('.name').val(data.item.name);
                        }
                    }
                });
            });

            $(".order").delegate(".qty", "keyup change", function() {
                var qty = $(this).val();
                var tr = $(this).parent().parent().parent();

                if (qty > parseInt(tr.find('.stok').val())) {
                    swal('Peringatan', 'Pengambilan melebihi stok', 'warning');
                    tr.find('.qty').val(1);
                }

            });

            counter++;
        });

        $(document).on("click", "#del", function(event) {
            $(this).closest("tr").remove();
            counter -= 1
        });
    });
</script>
