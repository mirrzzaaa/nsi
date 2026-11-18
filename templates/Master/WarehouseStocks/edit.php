<?php
//pr($warehouseStock->warehouse->name);
$dataChild = $this->Html->link('Item Gudang', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Master', $dataChild, 'Ubah') ?>
<?= $this->Form->create($warehouseStock, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fa fa-briefcase-medical fa-lg me-2 text-gray text-opacity-50"></i>
        Item Gudang
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-1 col-sm-1">
                <b>Produk </b><span class="text-danger">*</span>
            </div>
            <div class="col-3 col-sm-3">: <i><?php echo (!empty($warehouseStock->item) ? $warehouseStock->item->name : '-') ?></i></div>
            <div class="col-1 col-sm-1">
                <b>Barcode</b>
            </div>
            <div class="col-3 col-sm-3">: <i><?php echo (!empty($warehouseStock->item->barcode) ? $warehouseStock->item->barcode : '-') ?></i></div>
            <div class="col-1 col-sm-1">
                <b>Unit </b><span class="text-danger">*</span>
            </div>
            <div class="col-3 col-sm-3">: <i><?php echo (!empty($warehouseStock->item) ? $warehouseStock->item->unit : '-') ?></i></div>
        </div>
    </div>
</div>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fa fa-life-ring fa-lg me-2 text-gray text-opacity-50"></i>
        General
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Kode Internal <span class="text-danger">*</span></label>
                <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Kode internal...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Kode internal harus diisi !']); ?>
            </div>
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Gudang <span class="text-danger">*</span></label>
                <?= $this->Form->control('warehouse_id', ['label' => false, 'class' => 'form-control', 'value' => $warehouseStock->warehouse->id, 'disabled']); ?>
                <div id="check-wh"></div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Tanggal Expired <span class="text-danger">*</span></label>
                <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal masuk...', 'value' => ($warehouseStock->expired_date == null) ? '' : date_format($warehouseStock->expired_date, 'd-m-Y')]); ?>
            </div>
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Stok Awal</label>
                <?= $this->Form->control('stocks', ['label' => false, 'class' => 'form-control text-end nom', 'placeholder' => '0', 'value' => $this->Krs->_currency($warehouseStock->stock)]); ?>
            </div>
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Harga Beli</label>
                <?= $this->Form->control('buys', ['label' => false, 'class' => 'form-control text-end buy nom', 'placeholder' => '0', 'value' => $this->Krs->_currency($warehouseStock->buy)]); ?>
            </div>
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Harga Jual</label>
                <?= $this->Form->control('sells', ['label' => false, 'class' => 'form-control text-end sell nom', 'placeholder' => '0', 'value' => $this->Krs->_currency($warehouseStock->sell)]); ?>
            </div>
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
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'WarehouseStocks', 'action' => 'edit', $warehouseStock->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

        $('.slc').select2({
            placeholder: "Pilih salah satu",
            position: 'below'
        });

        $('.nom').autoNumeric({
            aSep: '.',
            aDec: ','
        });

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });


    });
</script>
