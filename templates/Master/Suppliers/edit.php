<?php
$dataChild = $this->Html->link('Supplier', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Master', $dataChild, 'Ubah') ?>
<?= $this->Form->create($supplier, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="col">
    <div class="col-lg-0 mb-3">
        <div class="card border-0">
            <div class="card-header bg-info p-3 h6 m-0 d-flex align-items-center ">
                <i class="fas fa-truck-loading fa-lg me-2 text-gray text-opacity-50"></i>
                Supplier
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Kode <span class="text-danger">*</span></label>
                        <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'disabled']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Nama <span class="text-danger">*</span></label>
                        <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama supplier...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nama supplier harus diisi !']); ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Jenis Upline <span class="text-danger">*</span></label>
                        <?= $this->Form->control('category', ['label' => false, 'class' => 'form-control slc', 'options' => $this->Krs->upline(), 'data-parsley-required' => true, 'data-parsley-required-message' => 'Jenis upline harus diisi!']); ?>
                    </div>  

                    
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">NPWP</label>
                        <?= $this->Form->control('npwp', ['label' => false, 'class' => 'form-control npwp', 'placeholder' => 'Nomor pokok wajib pajak...']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Pajak <span class="text-danger">*</span></label>
                        <?= $this->Form->control('tax', ['label' => false, 'class' => 'form-control slc', 'options' => $this->Krs->tax(), 'data-parsley-required' => true, 'data-parsley-required-message' => 'Pajak harus diisi !']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-check form-check-inline">
                            <p>&nbsp;</p>
                            <?= $this->Form->checkbox('ppn', ['label' => false, 'value' => '1', 'class' => 'form-check-input', 'hiddenField' => true, 'checked' => ($supplier->ppn == '1' ? 'checked' : '')]); ?>
                            <label class="form-check-label text-danger">(Centang jika include Ppn)</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">No. Izin Edar</label>
                        <?= $this->Form->control('izin_edar', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor izin edar...']); ?>
                    </div>
                    <?php
                    /*
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Negara <span class="text-danger">*</span></label>
                        <?= $this->Form->control('country_id', ['label' => false, 'class' => 'form-control slc', 'options' => $country, 'empty' => true, 'data-parsley-required' => true, 'data-parsley-error-message' => 'Negara harus dipilih !']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                        <?= $this->Form->control('area_id', ['label' => false, 'class' => 'form-control slc', 'options' => $area, 'empty' => true, 'data-parsley-required' => true, 'data-parsley-error-message' => 'Kabupaten/Kota harus dipilih !']); ?>
                    </div>
                    */
                    ?>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <?= $this->Form->control('address', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat lengkap...', 'type' => 'text', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Alamat supplier harus diisi !']); ?>
                    </div>
                </div>
                
            </div>
    
        </div>
    </div>
    <div class="col-lg-0 mb-3">
        <div class="card border-0">
            <div class="card-header bg-info p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-user-tie fa-lg me-2 text-gray text-opacity-50"></i>
                PIC
            </div>
            <div class="card-body">
                <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="" class="form-label">Nama <span class="text-danger">*</span></label>
                    <?= $this->Form->control('pic', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama pic...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nama pic harus diisi !']); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="" class="form-label">Jabatan</label>
                    <?= $this->Form->control('pic_dept', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Jabatan...']); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="" class="form-label">Telepon <span class="text-danger">*</span></label>
                    <?= $this->Form->control('telp', ['label' => false, 'class' => 'form-control telp', 'placeholder' => 'Nomor telepon...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nomor telepon pic harus diisi !']); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="" class="form-label">Fax</label>
                    <?= $this->Form->control('fax', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Faksimile...']); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="" class="form-label">Email</label>
                    <?= $this->Form->control('email', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat email...', 'type' => 'email']); ?>
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
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'Suppliers', 'action' => 'edit', $supplier->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

        $('.slc').select2({
            placeholder: "Pilih salah satu"
        });

        ('.pajak').select2({
            placeholder: "Pilih salah satu"
        });

        $('.kategori').select2({
            placeholder: "Pilih salah satu"
        });

        $('.npwp').mask('999.999.999.9-999.999', {
            autoclear: false
        });

        $(".telp").mask("999999999999", {
            autoclear: false
        });
    });
</script>
