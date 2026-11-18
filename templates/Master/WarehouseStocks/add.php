<?php
$dataChild = $this->Html->link('Item Gudang', ['action' => 'index'], ['full_base'=>true]);
//pr($warehouseStock);
?>

<?= $this->Krs->breadcrumb_('Master', $dataChild, 'Buat') ?>
<?= $this->Form->create($warehouseStock, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fa fa-briefcase-medical fa-lg me-2 text-gray text-opacity-50"></i>
        Item Gudang
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4"> 
                <label for="" class="form-label">Produk <span class="text-danger">*</span></label>
                <?= $this->Form->control('item_id', ['label' => false, 'class' => 'form-control items', 'data-placeholder' => 'Cari produk...', 'empty' => 'Cari produk...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Produk harus dipilih !', 'data-parsley-errors-container' => '#check-item']); ?>
                <div id="check-item"></div>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Barcode</label>
                <?= $this->Form->control('barcode', ['label' => false, 'class' => 'form-control barcode', 'placeholder' => 'Barcode produk...', 'readonly']); ?>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Unit <span class="text-danger">*</span></label>
                <?= $this->Form->control('unit', ['label' => false, 'class' => 'form-control unit', 'placeholder' => 'Satuan produk...', 'readonly', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Unit harus diisi !']); ?>
            </div>

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
                <?= $this->Form->control('warehouse_id', ['label' => false, 'class' => 'form-control slc wh', 'options' => $warehouses, 'empty' => 'Pilih data...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Gudang harus dipilih !', 'data-parsley-errors-container' => '#check-wh']); ?>
                <div id="check-wh"></div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Tanggal Expired <span class="text-danger">*</span></label>
                <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal masuk...', 'value' => date('d-m-Y'), 'data-parsley-required' => true, 'data-parsley-error-message' => 'Tanggal harus diisi !', 'data-parsley-errors-container' => '#check-tgl']); ?>
                <div id="check-tgl"></div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Stok Awal</label>
                <?= $this->Form->control('stocks', ['label' => false, 'class' => 'form-control text-end stok nom', 'placeholder' => '0']); ?>
            </div>
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Harga Beli</label>
                <?= $this->Form->control('buys', ['label' => false, 'class' => 'form-control text-end buy nom', 'placeholder' => '0']); ?>
            </div>
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Harga Jual</label>
                <?= $this->Form->control('sells', ['label' => false, 'class' => 'form-control text-end sell nom', 'placeholder' => '0']); ?>
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
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }


    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'WarehouseStocks', 'action' => 'add'], ['fullBase' => true]); ?>";
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

        $('.items').select2({
            placeholder: 'Masukkan 2 digit produk',
            minimumInputLength: 2,
            ajax: {
                dataType: 'json',
                url: '<?php echo $this->Url->build(['prefix' => "Master", 'controller' => 'WarehouseStocks', 'action' => 'getitem']); ?>',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function(data, page) {
                    return {
                        results: data
                    };
                },
                cache: true,
            }
        }).on('select2:select', function(e) {
            var data = e.params.data;
            var ids = data.id;
            $.ajax({
                url: "<?php echo $this->url->build(['prefix' => 'Master', 'controller' => 'WarehouseStocks', 'action' => 'setitem']); ?>",
                method: "get",
                data: {
                    id: ids
                },
                success: function(data) {
                    if (data) {
                        $('.barcode').val(data.barcode); 
                        $('.unit').val(data.unit);
                        $('.buy').val(rupiah(data.buying_price > 0 ? data.buying_price : 0));
                        $('.sell').val(rupiah(data.selling_price > 0 ? data.selling_price : 0));
                        $('.stok').val(rupiah(data.stock));
                    }
                },
                error: function(err) {
                    console.log(err, 'eror get data');
                }
            });
        });
    });
</script>
