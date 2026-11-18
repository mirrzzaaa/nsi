<?php
$dataChild = $this->Html->link('Armada', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Master', $dataChild, 'Ubah') ?>
<?= $this->Form->create($truck, ['type' => 'file', 'data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="row">
    <div class="col-lg-8 mb-3">
        <div class="card border-0">
            <div class="card-header bg-info p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-truck fa-lg me-2 text-gray text-opacity-50"></i>
                Armada <span class="text-danger">&nbsp;*</span>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="" class="form-label">Foto Truck <span class="text-danger">*</span></label>
                    <?php echo $this->Form->control("image", ['label' => false, 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text', 'id' => 'image']); ?>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Nopol <span class="text-danger">*</span></label>
                        <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nopol / Plat nomor...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nopol harus diisi !']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Merek <span class="text-danger">*</span></label>
                        <?= $this->Form->control('merk', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Contoh : Isuzu...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Merek harus diisi !']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Tipe <span class="text-danger">*</span></label>
                        <?= $this->Form->control('types', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Contoh : Traga...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Tipe harus diisi !']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Model <span class="text-danger">*</span></label>
                        <?= $this->Form->control('model', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Contoh : Truck Box...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Model harus diisi !']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Warna <span class="text-danger">*</span></label>
                        <?= $this->Form->control('color', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Contoh : Merah...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Warna harus diisi !']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Jumlah Ban <span class="text-danger">*</span></label>
                        <?= $this->Form->control('tire', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Contoh : 6...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Jumlah ban harus diisi !']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Tahun Produksi <span class="text-danger">*</span></label>
                        <?= $this->Form->control('production_year', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Contoh : 2012...', 'type' => 'text', 'value' => ($truck->production_year == null) ? date('Y') : $truck->production_year, 'data-parsley-required' => true, 'data-parsley-required-message' => 'Tahun produksi harus diisi !', 'readonly']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">No. Bapedal <span class="text-danger">*</span></label>
                        <?= $this->Form->control('bapedal_registration', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor bapedal...', 'type' => 'text', 'data-parsley-required' => true, 'data-parsley-required-message' => 'No. Bapedal harus diisi !']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">No. Asuransi <span class="text-danger">*</span></label>
                        <?= $this->Form->control('insurance', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor asuransi...', 'type' => 'text', 'data-parsley-required' => true, 'data-parsley-required-message' => 'No. Asuransi harus diisi !']); ?>
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

        <div class="card border-0 mb-3">
            <div class="card-header bg-info p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-bezier-curve fa-lg me-2 text-gray text-opacity-50"></i>
                No. Rangka <span class="text-danger">&nbsp;*</span>
            </div>
            <div class="card-body">
                <?php echo $this->Form->control("chassis_no_img", ['label' => false, 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text', 'id' => 'chassis']); ?>
                <br>
                <?= $this->Form->control('chassis_no', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No. rangka...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'No. rangka harus diisi !']); ?>
            </div>
        </div>
        <div class="card border-0 mb-3">
            <div class="card-header bg-info p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-memory fa-lg me-2 text-gray text-opacity-50"></i>
                No. Mesin <span class="text-danger">&nbsp;*</span>
            </div>
            <div class="card-body">
                <?php echo $this->Form->control("machine_no_img", ['label' => false, 'type' => 'file', 'class' => 'file', 'data-preview-file-type' => 'text', 'id' => 'machine']); ?>
                <br>
                <?= $this->Form->control('machine_no', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No. mesin...', 'data-parsley-required' => true, 'data-parsley-required-message' => 'No. mesin harus diisi !']); ?>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

<script>
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'Trucks', 'action' => 'edit', $truck->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

        $(".slc").select2({
            placeholder: "Pilih salah satu..."
        });

        $('.tgl').datepicker({
            autoclose: true,
            format: "yyyy",
            weekStart: 1,
            orientation: "bottom",
            language: "{{ app.request.locale }}",
            keyboardNavigation: false,
            viewMode: "years",
            minViewMode: "years"
        });

        $("#chassis").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($truck->chassis_no_img, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $truck->chassis_no_img ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/truck/<?= $truck->chassis_no_img ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/truck/<?= $truck->chassis_no_img ?>' class='file-preview-image'>"
        <?php
                                }
        ?>
        });


        $("#machine").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($truck->machine_no_img, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $truck->machine_no_img ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/truck/<?= $truck->machine_no_img ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/truck/<?= $truck->machine_no_img ?>' class='file-preview-image'>"
        <?php
                                }
        ?>
        });


        $("#image").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($truck->image, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $truck->image ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/truck/<?= $truck->image ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/truck/<?= $truck->image ?>' class='file-preview-image'>"
        <?php
                                }
        ?>
        });

        $('.nom').number({
            thousands: '.',
            decimal: '.',
            precision: 0
        });
    });
</script>
