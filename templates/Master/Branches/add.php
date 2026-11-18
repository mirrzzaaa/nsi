<?php
$dataChild = $this->Html->link('Cabang', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Master', $dataChild, 'Buat') ?>
<?= $this->Form->create($branch, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-store fa-lg me-2 text-gray text-opacity-50"></i>
                Cabang
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Kode <span class="text-danger">*</span></label> 
                        <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Kode...', 'value' => $data['lastNumber'], 'disabled']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Nama Cabang <span class="text-danger">*</span></label>
                        <?= $this->Form->control('company_name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama cabang...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nama cabang harus diisi !']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Telepon</label>
                        <?= $this->Form->control('company_telp', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor telepon...']); ?>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Alamat Cabang</label>
                    <?= $this->Form->control('company_address', ['label' => false, 'class' => 'form-control', 'type' => 'textarea', 'placeholder' => 'Alamat cabang...']); ?>
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
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'Branches', 'action' => 'add'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $('.npwp').mask('999.999.999.9-999.999', {
            autoclear: false
        });
    });
</script>
