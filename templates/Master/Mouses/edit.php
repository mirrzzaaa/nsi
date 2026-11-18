<?php
$dataChild = $this->Html->link('MOU', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Master', $dataChild, 'Buat') ?>
<?= $this->Form->create($mouse, ['data-parsley-validate' => 'true']) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>
<?= $this->Form->control('customer_id', ['type' => 'hidden', 'value' => $mouse->customer_id]); ?>

<div class="row mb-3">
    <div class="col-md-8">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-file-alt fa-lg me-2 text-gray text-opacity-50"></i>
                MOU
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">No. MOU <span class="text-danger">*</span></label>
                            <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No MOU...', 'data-parsley-error-message' => "No. MOU tidak boleh kosong !", 'required' => true]); ?>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="" class="form-label">Customer <span class="text-danger">*</span></label>
                            <?= $this->Form->control('customer', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Data customer...', 'value' => ($mouse->customer_id > 0) ? $mouse->customer->name : '', 'disabled']); ?>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">PIC <span class="text-danger">*</span></label>
                            <?= $this->Form->control('pic_name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama pic...', 'data-parsley-error-message' => "Nama pic tidak boleh kosong !", 'required' => true]); ?>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Email</label>
                            <?= $this->Form->control('pic_email', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Email pic...']); ?>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Telepon <span class="text-danger">*</span></label>
                            <?= $this->Form->control('pic_telp', ['label' => false, 'class' => 'form-control telp', 'placeholder' => 'Telepon pic...', 'data-parsley-error-message' => "Telepon pic tidak boleh kosong !", 'required' => true]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-calendar-alt fa-lg me-2 text-gray text-opacity-50"></i>
                Periode
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="" class="form-label">Tgl. Kontrak <span class="text-danger">*</span></label>
                    <?= $this->Form->control('date_contracts', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tgl kontrak...', 'value' => ($mouse->date_contract == null) ? date('d-m-Y') : date_format($mouse->date_contract, 'd-m-Y'), 'readonly']); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Tgl. Expired <span class="text-danger">*</span></label>
                    <?= $this->Form->control('date_expireds', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tgl expired...', 'readonly', 'value' => ($mouse->date_expired == null) ? date('d-m-Y') : date_format($mouse->date_expired, 'd-m-Y')]); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fa fa-briefcase-medical fa-lg me-2 text-gray text-opacity-50"></i>
        Produk
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped mouse_items">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th width="30%">Produk</th>
                        <th class="text-center" width="13%">Harga</th>
                        <th class="text-center"width="10%">Per/Unit</th>
                        <th width="37%">Keterangan</th>
                        <th class="actions text-center" width="10%"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = count($mouse->mouse_items) - 1;
                    foreach ($mouse->mouse_items as $index => $rowMouse) { ?>
                        <tr>
                            <td><?= $this->Form->hidden('mouse_items[' . $index . '][id]', ['value' => $rowMouse->id]); ?><?= $this->Form->hidden('mouse_items[' . $index . '][item_id]', ['value' => $rowMouse->item_id]); ?><?= (!empty($rowMouse->item) ? $rowMouse->item->name : '-') ?></td>
                            <td class="text-end"><?= $this->Form->hidden('mouse_items[' . $index . '][price]', ['value' => $rowMouse->price, 'disabled']); ?><?= $this->Krs->_currency($rowMouse->price); ?></td>
                            <td class="text-center"><?= $this->Form->hidden('mouse_items[' . $index . '][unit]', ['value' => $rowMouse->unit, 'disabled']); ?><?= $rowMouse->unit; ?></td>
                            <td><?= $this->Form->hidden('mouse_items[' . $index . '][description]', ['value' => $rowMouse->description, 'disabled']); ?><?= $rowMouse->description; ?></td>
                            <td class="text-center"><?= ($total == $index) ? '<button class="btn btn-inverse btn-sm addRow" id="" type="button"><i class="fas fa-plus-square"></i></button>' : ''; ?></td>
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

<?= $this->Form->end() ?>

<script>
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }

    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'Mouses', 'action' => 'edit', $mouse->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $('.npwp').mask('999.999.999.9-999.999', {
            autoclear: false
        });

        $('.telp').mask('999999999999', {
            autoclear: false
        });

        $('.slc').select2().on('select2:select', function(e) {
            var id = e.params.data.id;
            var tr = $(this).parent().parent().parent();
            $.ajax({
                url: "<?php echo $this->url->build(['prefix' => 'Master', 'controller' => 'WarehouseStocks', 'action' => 'setitem']); ?>",
                method: "get",
                data: {
                    id: id
                },
                success: function(data) {
                    tr.find('.nom').val(rupiah(data.selling_price));
                    tr.find('.unit').val(data.unit);
                }
            });
        });

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        $('input.nom').autoNumeric({
            aSep: '.',
            aDec: ','
        });

        var counter = ($('.mouse_items tr').length) - 1;
        $(".addRow").on("click", function(e) {
            if (e.originalEvent.defaultPrevented) return;

            var cols = '';
            cols += '<tr>'
            cols += '<td><input type="hidden" name="mouse_items[' + counter + '][id]" value="0"><select class="form-control slc" name="mouse_items[' + counter + '][item_id]" data-parsley-required="true" data-parsley-error-message="Produk harus dipilih !" data-parsley-errors-container="#check-produk" data-placeholder="Cari produk..."><option value=""></option><?php foreach ($items as $key => $value) : ?><option value="<?= $key ?>"><?= $value ?></option><?php endforeach; ?></select><div id="check-produk"></div></td>';
            cols += '<td><input type="text" name="mouse_items[' + counter + '][price]" class="form-control nom text-end" placeholder="0" data-parsley-required="true" data-parsley-error-message="Harga harus diisi !"></td>';
            cols += '<td><input type="text" name="mouse_items[' + counter + '][unit]" class="form-control unit" placeholder="Unit..." readonly></td>';
            cols += '<td><input type="text" name="mouse_items[' + counter + '][description]" class="form-control" placeholder="Deskripsi..."></td>';
            cols += '<td class="text-center"><button class="btn btn-pink btn-sm" id="del" type="button"><i class="far fa-trash-alt"></i></button></td>';
            cols += '</tr>';

            // nambah baris didalam tabel
            $(".mouse_items>tbody").append(cols);

            $('.slc').select2().on('select2:select', function(e) {
                var id = e.params.data.id;
                var tr = $(this).parent().parent();
                $.ajax({
                    url: "<?php echo $this->url->build(['prefix' => 'Master', 'controller' => 'WarehouseStocks', 'action' => 'setitem']); ?>",
                    method: "get",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        tr.find('.nom').val(rupiah(data.selling_price));
                        tr.find('.unit').val(data.unit);
                    }
                });
            });

            $('input.nom').autoNumeric({
                aSep: '.',
                aDec: ','
            });


            counter++;
        });

        // Javascript menghapus kalau di klik
        $(document).on("click", "#del", function(event) {
            $(this).closest("tr").remove();
            counter -= 1
        });
    });
</script>
