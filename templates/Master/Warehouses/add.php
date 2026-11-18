<?php
$dataChild = $this->Html->link('Gudang', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Master', $dataChild, 'Buat') ?>
<?= $this->Form->create($warehouse, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?> 

<div class="row">
    <div class="col-md-8">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-warehouse fa-lg me-2 text-gray text-opacity-50"></i>
                Gudang
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Kode <span class="text-danger">*</span></label>
                        <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $data['lastNumber'], 'disabled']); ?>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="" class="form-label">Nama <span class="text-danger">*</span></label>
                        <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama gudang...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nama gudang harus diisi !']); ?>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <?= $this->Form->control('address', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat lengkap gudang...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Alamat gudang harus diisi !']); ?>
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
    <div class="col-lg-4 mb-3">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-user-tie fa-lg me-2 text-gray text-opacity-50"></i>
                PIC
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="" class="form-label">Nama <span class="text-danger">*</span></label>
                    <?= $this->Form->control('pic', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama pic...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nama pic harus diisi !']); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Telepon <span class="text-danger">*</span></label>
                    <?= $this->Form->control('telp', ['label' => false, 'class' => 'form-control telp', 'placeholder' => 'Nomor telepon...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nomor telepon harus diisi !']); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->end() ?>

<script>
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'Warehouses', 'action' => 'add'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

        $(".telp").mask("999999999999", {
            autoclear: false
        });
    });
</script>
