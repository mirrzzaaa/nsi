<?php

//pr($goodsOutWarehouse);

$dataChild = $this->Html->link('Keluar Gudang', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Transaksi', $dataChild, 'Edit') ?>
<?= $this->Form->create($goodsOutWarehouse, []) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3">
        <div class="row">
            <div class="col-md-3">
                <div class="row">
                    <label class="form-label col-form-label col-md-4">Gudang</label>
                    <div class="col-md-12">
                        <?= $this->Form->control('warehouse', ['label' => false, 'class' => 'form-control', 'value' => $warehouses, 'disabled']); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3"> 
                <div class="row">
                    <label class="form-label col-form-label col-md-4">Kirim Ke</label>
                    <div class="col-md-12">
                        <?= $this->Form->control('is_to', ['label' => false, 'class' => 'form-control slcb', 'options' => $this->Krs->_toEdit()]); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="row">
                    <label class="form-label col-form-label col-md-4">Nomor</label>
                    <div class="col-md-12">
                        <?= $this->Form->text('code', ['label' => false, 'class' => 'form-control', 'value' => $goodsOutWarehouse->code, 'disabled']); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="row">
                    <label class="form-label col-form-label col-md-4">Tanggal</label>
                    <div class="col-md-12">
                        <?= $this->Form->text('date', ['label' => false, 'class' => 'form-control tgl', 'value' => ($goodsOutWarehouse->date == null ? '' : date_format($goodsOutWarehouse->date, 'd-m-Y')), 'readonly']); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="card border-0">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fas fa-truck-loading fa-lg me-2 text-gray text-opacity-50"></i>
        Produk Dipickup
    </div>
    <div class="card-body">
        <div class="table-responsive mb-3" style="overflow: auto; height: 200px;">
            <table class="table table-hover table-panel align-middle mb-3 order">
                <thead style="position: sticky; top: 0; z-index: 1;">
                    <tr>
                        <th width="30%">Produk</th>
                        <th class="text-center" width="5%">Jumlah</th>
                        <th class="text-center" width="5%">Unit</th>
                        <th class="text-center" width="15%">Nomor Seri</th>
                        <th class="text-center" width="15%">Kode Produk</th>
                        <th class="text-center" width="15%">Supplier</th> 
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($goodsOutWarehouse->goods_out_warehouse_lines as $index => $rowWhot) { ?>
                        <tr>
                            <td><?= (($rowWhot->warehouse_stock_id > 0) ? (!empty($rowWhot->warehouse_stock) ? $rowWhot->warehouse_stock->item->name : '-') : ($rowWhot->name)); ?></td>
                            <td class="text-center"><?= $this->Krs->_currency($rowWhot->qty); ?></td>
                            <td class="text-center"><?= (($rowWhot->warehouse_stock_id > 0) ? (!empty($rowWhot->warehouse_stock) ? $rowWhot->warehouse_stock->item->unit : '-') : ($rowWhot->unit)); ?></td>
                            <td class="text-center"><?= !empty($rowWhot->nomor_seri) ? $rowWhot->nomor_seri : '-'; ?></td>
                            <td class="text-center"><?= !empty($rowWhot->kode_produk) ? $rowWhot->kode_produk : '-'; ?></td>
                            <td class="text-center"><?= !empty($rowWhot->supplier_name) ? $rowWhot->supplier_name : '-'; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="form-group">
            <label for="" class="form-label">Deskripsi</label>
            <?= $this->Form->control('description', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Deskripsi...']); ?>
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
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsOutWarehouses', 'action' => 'edit', $goodsOutWarehouse->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

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


        $('.slcb').select2({
            placeholder: "Pilih..."
        });


        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });



        $(document).on("click", "#del", function(event) {
            $(this).closest("tr").remove();
            counter -= 1
        });
    });
</script>
