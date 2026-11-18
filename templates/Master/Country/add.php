<?php
$dataChild = $this->Html->link('Negara', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Master', $dataChild, 'Buat') ?>
<?= $this->Form->create($country, ['data-parsley-validate' => true]) ?>

<div class="card border-0">
    <div class="card-header bg-info p-3 h6 m-0 d-flex align-items-center">
        <i class="fa fa-object-group fa-lg me-2 text-gray text-opacity-50"></i>
        Negara
    </div> 
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Kode <span class="text-danger">*</span></label>
                <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Kode negara...', 'autofocus', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Kode negara harus diisi !']); ?>
            </div>
            <div class="col-md-8 mb-3">
                <label for="" class="form-label">Nama <span class="text-danger">*</span></label>
                <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama negara...', 'autofocus', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nama negara harus diisi !']); ?>
            </div>
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
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'Country', 'action' => 'add'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

    });
</script>
