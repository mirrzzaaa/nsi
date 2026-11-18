<?php
$dataChild = $this->Html->link('Produk', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Master', $dataChild, 'Buat') ?>
<?= $this->Form->create($item, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-briefcase-medical fa-lg me-2 text-gray text-opacity-50"></i>
                Produk
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Kode <span class="text-danger">*</span></label>
                        <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $data['lastNumber'], 'disabled']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Barcode</label>
                        <?= $this->Form->control('barcode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Barcode produk...']); ?> 
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Nama <span class="text-danger">*</span></label>
                        <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama produk...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Nama produk harus diisi !']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <?= $this->Form->control('category_id', ['label' => false, 'class' => 'form-control slc', 'options' => $categories, 'data-placeholder' => 'Pilih kategori produk...', 'empty' => 'Pilih kategori produk...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Kategori produk harus dipilih !', 'data-parsley-errors-container' => '#check-categori']); ?>
                        <div id="check-categori"></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Gudang <span class="text-danger">*</span></label>
                        <?= $this->Form->control('warehouse_id', ['label' => false, 'class' => 'form-control wh', 'options' => $warehouses, 'empty' => 'Pilih data...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Gudang harus dipilih !', 'data-parsley-errors-container' => '#check-wh']); ?>
                        <div id="check-wh"></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <!-- <label for="" class="form-label">Supplier</label>
                        $this->Form->control('supplier_id', ['label' => false, 'class' => 'form-control slc', 'options' => $suppliers, 'data-placeholder' => 'Pilih supplier produk...', 'empty' => 'Pilih supplier produk...', 'data-parsley-errors-container' => '#check-supplier']);
                        <div id="check-supplier"></div> -->

                        <label class="form-label">Supplier <span class="text-danger">*</span></label>
                        <div>
                            <?php
                            // Ambil nilai supplier yang sudah tersimpan sebelumnya
                            $selectedSuppliers = !empty($item->supplier_id) ? explode(",", $item->supplier_id) : [];

                            echo $this->Form->control('supplierId', [
                                'type' => 'select',
                                'label' => false,
                                'options' => $supplierList, 
                                'multiple' => 'multiple', 
                                'class' => 'form-control select2Form',
                                'data-placeholder' => 'Pilih Supplier...',
                                'value' => $selectedSuppliers, 
                                'error' => false
                            ]);
                            ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Keterangan</label>
                        <?= $this->Form->control('description', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Keterangan...']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fa fa-tags fa-lg me-2 text-gray text-opacity-50"></i>
                Detail
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">ID Produk <span class="text-danger">*</span></label>
                        <?= $this->Form->control('code_internal', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Id produk...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Kode internal harus diisi !']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Tanggal Expired <span class="text-danger">*</span></label>
                        <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal masuk...', 'value' => date('d-m-Y'), 'data-parsley-required' => true, 'data-parsley-error-message' => 'Tanggal harus diisi !', 'data-parsley-errors-container' => '#check-tgl']); ?>
                        <div id="check-tgl"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Harga Beli</label>
                        <?= $this->Form->control('buying_prices', ['label' => false, 'class' => 'form-control text-end nom', 'placeholder' => '0']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Harga Jual</label>
                        <?= $this->Form->control('selling_prices', ['label' => false, 'class' => 'form-control text-end nom', 'placeholder' => '0']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Stock Barang</label> 
                        <?= $this->Form->control('stocks', ['label' => false, 'class' => 'form-control text-end weight', 'placeholder' => '0']); ?>
                    </div>
                    <div class="col-md-6 mb-3"> 
                        <label for="" class="form-label">Satuan <span class="text-danger">*</span></label> 
                        <?= $this->Form->control('unit', ['label' => false, 'class' => 'form-control slc', 'options' => $this->Krs->_unit(), 'data-placeholder' => 'Pilih satuan produk...', 'empty' => 'Pilih satuan produk...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Satuan produk harus dipilih !', 'data-parsley-errors-container' => '#check-unit']); ?> 
                        <div id="check-unit"></div>  
                    </div> 
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">No. Izin Edar</label>
                        <?= $this->Form->control('izin_edar', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No. izin edar...']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Type</label>
                        <?= $this->Form->control('type', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Type...']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Ukuran</label>
                        <?= $this->Form->control('ukuran', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Ukuran...']); ?>
                    </div>
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
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'Items', 'action' => 'add'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        $('.slc').select2({
            position: 'below'
        });

        $('.wh').select2({
            placeholder: "Pilih salah satu",
            position: 'below'
        });

        $('.nom').autoNumeric({
            aSep: '.',
            aDec: ',',
            mDec: 0
        });
        
        $('.weight').autoNumeric({
            aSep: '.',
            aDec: ',',
            mDec: 0
        });

        $('.select2Form').select2({
            placeholder: "Pilih Supplier...",
            allowClear: true
        });

    });
</script>
