<?php
$dataChild = $this->Html->link('User', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Setting', $dataChild, 'Edit') ?>
<?= $this->Form->create($user, []) ?>
<input type="hidden" name="is_update" value="<?= $getUser->id ?>">
<div class="row">
    <div class="col-md-8">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fa fa-user fa-lg me-2 text-gray text-opacity-50"></i>
                User
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Nama</label>
                        <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama lengkap...']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Staff</label>
                        <?= $this->Form->control('devision', ['label' => false, 'class' => 'form-control slc', 'options' => $this->Krs->_staff()]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">No. Telepon</label>
                        <?= $this->Form->control('telp', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor telepon aktif...', 'type' => 'number']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Email</label>
                        <?= $this->Form->control('email', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat email...', 'type' => 'email']); ?>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-none d-flex p-3">
                <button class="btn btn-primary ms-auto" type="button" id='btn-add'>Simpan</button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fa fa-unlock fa-lg me-2 text-gray text-opacity-50"></i>
                Login
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="" class="form-label">Kode</label>
                    <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Kode username...', 'type' => 'text', 'disabled']); ?>
                </div>
                <br>
                <div class="form-group">
                    <label for="" class="form-label">Password</label>
                    <?= $this->Form->control('password_new', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Password...', 'type' => 'password', 'disabled']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

<script>
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'edit', $user->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $('.slc').select2();
    });
</script>
