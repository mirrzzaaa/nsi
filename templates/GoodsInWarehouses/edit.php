<?php
//pr($orderLine);
$dataChild = $this->Html->link('Masuk Gudang', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Ubah') ?>
<?= $this->Form->create($goodsInWarehouse, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>
<?= $this->Form->control('purchasing_id', ['type' => 'hidden', 'value' => $goodsInWarehouse->purchasing_id]); ?>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3"> 
        <div class="row d-flex">
            <div class="col-md-4">
                <strong><i class="fas fa-receipt fa-lg text-gray text-opacity-50"></i></i>&nbsp;&nbsp;&nbsp; : <?= (($goodsInWarehouse->purchasing_id > 0) ? (!empty($goodsInWarehouse->purchasing) ? $goodsInWarehouse->purchasing->number : '-') : '-') ?></strong>
            </div>
            <div class="col-md-4">
                <strong><i class="fas fa-warehouse fa-lg text-gray text-opacity-50"></i>&nbsp;&nbsp;&nbsp; : <?= (($goodsInWarehouse->warehouse_id > 0) ? (!empty($goodsInWarehouse->warehouse) ? $goodsInWarehouse->warehouse->name : '-') : '-') ?></strong>
            </div>
            <div class="col-md-4 align-items-right">
                <strong class="text-right"><i class="fas fa-calendar-alt fa-lg text-gray text-opacity-50"></i>&nbsp;&nbsp;&nbsp; : <?= (($goodsInWarehouse->purchasing_id > 0) ? (!empty($goodsInWarehouse->purchasing) ? $this->Krs->fDate($goodsInWarehouse->purchasing->date, 'd F Y') : '-') : '-'); ?></strong>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-truck-loading fa-lg me-2 text-gray text-opacity-50"></i>
                Masuk Gudang
            </div>
            <div class="card-body">
                <div class="row"> 
                    <div class="col-md-3 mb-3">
                        <label for="" class="form-label">Kode</label>
                        <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $goodsInWarehouse->number, 'disabled']); ?>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="" class="form-label">Tanggal</label>
                        <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control tgl', 'value' => (($goodsInWarehouse->date != null) ? $this->Krs->fDate($goodsInWarehouse->date, 'd-m-Y') : ''), 'type' => 'text']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Deskripsi</label>
                        <?= $this->Form->control('description', ['label' => false, 'class' => 'form-control', 'type' => 'text', 'placeholder' => 'Keterangan...']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-briefcase-medical fa-lg me-2 text-gray text-opacity-50"></i>
                Purchase Order (PO)
            </div>
            <div class="card-body">
                <div class="table-responsive mb-3" style="overflow: auto; height: 280px;">
                    <table class="table table-hover table-panel text-nowrap align-middle mb-0 po">
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
                            foreach ($goodsInWarehouse->purchasing->purchasing_lines as $value) {
                                // cari baris warehouse line yang cocok
                                $line = null;
                                foreach ($goodsInWarehouse->goods_in_warehouse_lines as $l) {
                                    if ($l->purchasing_line_id === $value->id) {
                                        $line = $l;
                                        break;
                                    }
                                }
                            ?>
                                <tr>
                                    <td><?= !empty($value->item_id) ? $value->item->name : '-'; ?></td>
                                    <td class="text-center"><?= $this->Krs->_currency($value->quantity); ?></td>
                                    <td class="text-center"><?= !empty($value->item_id) ? $value->item->unit : '-'; ?></td>
                                    <td class="text-center"><?= !empty($line->nomor_seri) ? $line->nomor_seri : '-'; ?></td>
                                    <td class="text-center"><?= !empty($line->kode_produk) ? $line->kode_produk : '-'; ?></td>
                                    <td class="text-center"><?= !empty($line->supplier_name) ? $line->supplier_name : '-'; ?></td>
                                </tr>
                            <?php
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

<?= $this->Form->end() ?>

<script>
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }

    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsInWarehouses', 'action' => 'edit', $goodsInWarehouse->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $('.slc').select2({
            placeholder: "Pilih salah satu"
        });

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        var counter = ($('.po tr').length) - 1;
        $(".addRow").on("click", function(e) {
            if (e.originalEvent.defaultPrevented) return;

            var cols = '';
            cols += '<tr>'
            cols += '<td><select class="form-control item" name="" data-parsley-required="true" data-parsley-error-message="Produk harus dipilih !" data-parsley-errors-container="#check-produk"><option value="">Pilih produk...</option><?php foreach ($purchasings as $rowPO) : ?><option value="<?= $rowPO->id ?>"><?= $rowPO->item->name ?></option><?php endforeach; ?></select><div id="check-produk"></div><input type="hidden" name="goods_in_warehouse_lines[' + counter + '][item_id]" class="item_id"></td>';
            cols += '<td><input type="number" min="1" class="form-control text-end qty" placeholder="0"  name="goods_in_warehouse_lines[' + counter + '][qty]" data-parsley-required="true" data-parsley-error-message="Jumlah harus diisi !"></td>';
            cols += '<td><div class="input-group"><input class="form-control unit" placeholder="Unit..." readonly  name="goods_in_warehouse_lines[' + counter + '][unit]"></div></td>';
            cols += '<td><input class="form-control desc" type="text" name="goods_in_warehouse_lines[' + counter + '][description]" placeholder="Keterangan..." data-parsley-required="true" data-parsley-error-message="Keterangan harus diisi !"></td>';
            cols += '<td class="text-center"><button class="btn btn-pink btn-sm" id="del" type="button"><i class="far fa-trash-alt"></i></button></td>';
            cols += '</tr>';

            // nambah baris didalam tabel
            $(".po>tbody").append(cols);

            $('.item').select2({
                placeholder: 'Pilih produk...'
            }).on('select2:select', function(e) {
                var id = e.params.data.id;
                var tr = $(this).parent().parent();
                $.ajax({
                    url: "<?php echo $this->url->build(['prefix' => false, 'controller' => 'GoodsInWarehouses', 'action' => 'setitem']); ?>",
                    method: "get",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        tr.find(".qty").val(rupiah(data.quantity));
                        tr.find(".unit").val(data.item.unit);
                        tr.find(".item_id").val(data.item.id);
                    }
                });
            });

            counter++;
        });

        $(document).on("click", "#del", function(event) {
            $(this).closest("tr").remove();
            counter -= 1
        });

    });
</script>
