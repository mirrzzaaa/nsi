<?php
$dataChild = $this->Html->link('Kategori Jenis Produk', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Master', $dataChild, 'Ubah') ?>
<?= $this->Form->create($category, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>
<div class="card border-0">
    <div class="card-header bg-info p-3 h6 m-0 d-flex align-items-center">
        <i class="fa fa-object-group fa-lg me-2 text-gray text-opacity-50"></i>
        Kategori
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Kode <span class="text-danger">*</span></label>
                <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $category->code, 'disabled' => true]); ?>
            </div>
            <div class="col-md-8 mb-3">
                <label for="" class="form-label">Nama <span class="text-danger">*</span></label>
                <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama kategori...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nama kategori harus diisi !']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="form-label">Catatan</label>
            <?= $this->Form->control('note', ['label' => false, 'class' => 'form-control', 'type' => 'textarea', 'placeholder' => 'Catatan...']); ?>
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
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'Categories', 'action' => 'edit', $category->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

    });
</script>
