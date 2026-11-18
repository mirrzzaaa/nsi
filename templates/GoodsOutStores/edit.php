<?= $this->Krs->breadcrumb_('Transaksi', 'Keluar Toko', '') ?>
<?= $this->Form->create($goodsOutStore, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3">
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="row">
                    <label class="form-label col-form-label">Toko</label>
                        <!-- <?= $this->Form->control('branch_id', ['label' => false, 'class' => 'form-control slc', 'options' => $branches, 'data-placeholder' => 'Pilih asal...',  'empty' => 'Pilih tujuan...', 'data-parsley-required' => true, 'data-parsley-errors-container' => '#check-from', 'data-parsley-required-message' => 'Tujuan Produk harus dipilih !']); ?>
                        <div id="check-from"></div> -->
                        <?= $this->Form->control('branch_id', ['label' => false, 'class' => 'form-control', 'value' => (!empty($goodsOutStore->branch) ? $goodsOutStore->branch->name : '-'), 'placeholder' => 'Toko...', 'disabled']); ?>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="row">
                    <label class="form-label col-form-label">Kirim Ke</label>
                        <!-- <?= $this->Form->control('is_to', ['label' => false, 'class' => 'form-control slcb', 'options' => $this->Krs->_to(), 'data-parsley-required' => true, 'data-parsley-errors-container' => '#check-to', 'data-parsley-required-message' => 'Tujuan Produk harus dipilih !']); ?>
                        <div id="check-from"></div> -->
                        <?= $this->Form->control('is_to', ['label' => false, 'class' => 'form-control', 'options' => $this->Krs->_to(), 'disabled']); ?>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="row">
                    <label class="form-label col-form-label">Nomor</label>
                        <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $goodsOutStore->code, 'readonly']); ?>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="row">
                    <label class="form-label col-form-label">Tanggal</label>
                        <?= $this->Form->control('date', ['label' => false, 'class' => 'form-control tgl', 'value' => ($goodsOutStore->date == null) ? '' : date_format($goodsOutStore->date, 'd-m-Y'), 'type' => 'text', 'readonly']); ?>
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
        <div class="table-responsive" style="overflow: auto; height: 200px;">
            <table class="table table-hover table-panel text-nowrap align-middle mb-3 order">
                <thead style="position: sticky; top: 0; z-index: 1;">
                    <tr>
                        <th width="25%">Produk</th>
                        <th width="10%" class="text-center">Stok</th>
                        <th width="10%" class="text-center">Jumlah</th>
                        <th width="10%">Unit</th>
                        <th width="40%">Deskripsi</th>
                        <th class="text-center" width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($goodsOutStore->goods_out_store_lines as $index => $rowGoods) { ?>
                        <tr>
                            <td><?= (!empty($rowGoods->item) ? $rowGoods->item->name : '-') ?></td>
                            <td class="text-center"><?= $this->Krs->_currency(!empty($rowGoods->item) ? $rowGoods->item->stock : 0); ?></td>
                            <td class="text-center"><?= $this->Krs->_currency($rowGoods->qty); ?></td>
                            <td><?= (!empty($rowGoods->item) ? $rowGoods->item->unit : '-') ?></td>
                            <td><?= $rowGoods->description ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
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
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsOutStores', 'action' => 'edit', $goodsOutStore->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $('.slc').select2({
            placeholder: "Pilih..."
        }).on('select2:select', function(e) {
            let id = e.params.data.id;

            $.ajax({
                url: "<?php echo $this->url->build(['prefix' => false, 'controller' => 'GoodsOutStores', 'action' => 'getitem']); ?>",
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
                        swal("Informasi", "Toko ini belum memiliki produk, silahkan cari data lainnya", "info");
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

        var counter = ($('.order tr').length) - 1;
        $("#insert").on("click", function(e) {
            if (e.originalEvent.defaultPrevented) return;

            var cols = '';
            cols += '<tr>'
            cols += '<td><input type="hidden" name="goods_out_store_lines[' + counter + '][item_id]" class="items"><select class="form-control item" name="" data-parsley-required="true" data-parsley-error-message="Produk harus dipilih !" data-parsley-errors-container="#check-produk"><option value="">Pilih produk...</option><?php foreach ($items as $rowItem) : ?> <option value="<?= $rowItem->id ?>"><?= $rowItem->name ?></option> <?php endforeach; ?></select><div id="check-produk"></div></td>';
            cols += '<td><input type="number" min="1" class="form-control text-end stok" placeholder="0" disabled  name=""></td>';
            cols += '<td><input type="number" min="1" class="form-control text-end qty" placeholder="0" name="goods_out_store_lines[' + counter + '][qty]" data-parsley-required="true" data-parsley-error-message="Jumlah harus diisi !"></td>';
            cols += '<td><input type="text" class="form-control unit" placeholder="Unit..." readonly  name="goods_out_store_lines[' + counter + '][unit]"></td>';
            cols += '<td><input class="form-control" type="text" name="goods_out_store_lines[' + counter + '][description]" placeholder="Deskripsi..." data-parsley-required="true" data-parsley-error-message="Deskripsi harus diisi !"></td>';
            cols += '<td class="text-center"><button class="btn btn-pink btn-sm" id="del" type="button"><i class="far fa-trash-alt"></i></button></td>';
            cols += '</tr>';

            // nambah baris didalam tabel
            $(".order>tbody").append(cols);

            $('.item').select2({
                placeholder: 'Pilih produk...'
            }).on('select2:select', function(e) {
                var id = e.params.data.id;
                var tr = $(this).parent().parent();
                $.ajax({
                    url: "<?php echo $this->url->build(['prefix' => false, 'controller' => 'GoodsOutStores', 'action' => 'setitem']); ?>",
                    method: "get",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data) {
                            tr.find('.stok').val(rupiah(data.stock));
                            tr.find('.qty').val(1);
                            tr.find('.unit').val(data.unit);
                            tr.find('.items').val(data.id);
                            tr.find('.whout').val(data.id);
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
