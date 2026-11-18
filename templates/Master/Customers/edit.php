<?php
$dataChild = $this->Html->link('Customer', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Master', $dataChild, 'Ubah') ?>
<?= $this->Form->create($customer, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="card border-0">
    <div class="card-header bg-info p-3 h6 m-0 d-flex align-items-center">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active">Data Personal</a>
            </li>
            <li class="nav-item">
                <a href="#default-tab-2" data-bs-toggle="tab" class="nav-link">Data Invoice</a>
            </li>
            <li class="nav-item">
                <a href="#default-tab-3" data-bs-toggle="tab" class="nav-link">Data Bank</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content panel p-3 rounded">
            <div class="tab-pane fade active show" id="default-tab-1">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Kode <span class="text-danger">*</span></h6>
                            <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $customer->code, 'disabled']); ?>
                        </div>
                    </div>
                    <div class="col-md-8 mb-3">
                        <div class="form-group">
                            <h6>Nama Customer <span class="text-danger">*</span></h6>
                            <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nama customer . . .', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nama customer harus diisi !']); ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Title <span class="text-danger">*</span></h6>
                            <?= $this->Form->control('title', ['label' => false, 'class' => 'form-control cs', 'options' => $this->Krs->titleCustomer(), 'data-placeholder' => 'Pilih title...', 'empty' => 'Pilih title...', 'data-parsley-required' => true, 'data-parsley-errors-container' => '#check-title', 'data-parsley-required-message' => 'Title harus dipilih !']); ?>
                            <div id="check-title"></div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Nama Panggilan <span class="text-danger">*</span></h6>
                            <?= $this->Form->control('nickname', ['label' => false, 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nama panggilan . . .', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nama panggilan harus diisi !']); ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Marketing <span class="text-danger">*</span></h6>
                            <?= $this->Form->control('marketing_id', ['label' => false, 'class' => 'form-control cs', 'autocomplete' => 'off', 'options' => $marketings, 'data-placeholder' => 'Pilih marketing...', 'empty' => 'Pilih marketing...', 'data-parsley-required' => true, 'data-parsley-errors-container' => '#check-marketing', 'data-parsley-required-message' => 'Marketing harus dipilih !']); ?>
                            <div id="check-marketing"></div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Contact Person <span class="text-danger">*</span></h6>
                            <?= $this->Form->control('contact_person', ['label' => false, 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nama contact person . . .', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nama contact person harus diisi !']); ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Jabatan / Departemen <span class="text-danger">*</span></h6>
                            <?= $this->Form->control('dept_person', ['label' => false, 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Jabatan / nama departemen . . .', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Jabatan contact person harus diisi !']); ?>
                        </div>
                    </div>
                    <div class="col-md-4  mb-3">
                        <div class="form-group">
                            <h6>No. Telepon <span class="text-danger">*</span></h6>
                            <?= $this->Form->control('telp_person', ['label' => false, 'class' => 'form-control telp', 'autocomplete' => 'off', 'placeholder' => 'Nomor telepon . . .', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nomor telepon contact person harus diisi !']); ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Provinsi <span class="text-danger">*</span></h6>
                            <?= $this->Form->control('province', ['label' => false, 'class' => 'form-control povinsi', 'options' => $provinsi, 'data-parsley-required' => true, 'data-parsley-errors-container' => '#check-provinsi', 'data-parsley-required-message' => 'Provinsi harus dipilih !']); ?>
                            <div id="check-provinsi"></div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Kabupaten <span class="text-danger">*</span></h6>
                            <?= $this->Form->control('district', ['label' => false, 'class' => 'form-control kab', 'options' => $districts, 'data-parsley-required' => true, 'data-parsley-errors-container' => '#check-district', 'data-parsley-required-message' => 'Kabupaten harus dipilih !']); ?>
                            <div id="check-district"></div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Kode Pos</h6>
                            <?= $this->Form->control('postal', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Kode pos sesuai alamat customer']); ?>
                        </div>
                    </div>
                    <div class="col-md-8 mb-3">
                        <div class="form-group">
                            <h6>Alamat Lengkap <span class="text-danger">*</span></h6>
                            <?= $this->Form->control('address_penghasil', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat lengkap...', 'type' => 'text', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Alamat customer harus diisi !']); ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Area <span class="text-danger">*</span></h6>
                            <?= $this->Form->control('area', ['label' => false, 'class' => 'form-control slc', 'options' => $this->Krs->area(), 'data-placeholder' => 'Pilih area produk . . .', 'empty' => 'Pilih area produk . . .', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Area harus dipilih !', 'data-parsley-errors-container' => '#check-area']); ?>
                            <div id="check-area"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <h6>Website</h6>
                            <?= $this->Form->control('website', ['label' => false, 'class' => 'form-control', 'placeholder' => 'URL website . . .']); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <h6>Email 1</h6>
                            <?= $this->Form->control('email1', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Email 1 . . .']); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <h6>Email 2</h6>
                            <?= $this->Form->control('email2', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Email 2 . . .']); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="default-tab-2">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Nama Invoice <span class="text-danger">*</span></h6>
                            <?= $this->Form->control('name_invoice', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama invoice customer . . .', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nama invoice customer harus diisi !']); ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>No. Telepon Invoice</h6>
                            <?= $this->Form->control('phone_invoice', ['label' => false, 'class' => 'form-control telp', 'placeholder' => 'Nomor telepon invoice . . .']); ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Fax Invoice</h6>
                            <?= $this->Form->control('fax_invoice', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor faximile invoice . . .']); ?>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <h6>Alamat Invoice</h6>
                            <?= $this->Form->control('address_invoice', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat invoice...', 'type' => 'text']); ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Nama Faktur <span class="text-danger">*</span></h6>
                            <?= $this->Form->control('name_tax_invoice', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama faktur customer . . .', 'data-parsley-required' => true, 'data-parsley-required-message' => 'Nama faktur customer harus diisi !']); ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>No. Telepon Faktur</h6>
                            <?= $this->Form->control('phone_tax_invoice', ['label' => false, 'class' => 'form-control telp', 'placeholder' => 'Nomor telepon faktur . . .']); ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Fax Faktur</h6>
                            <?= $this->Form->control('fax_tax_invoice', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor faximile faktur . . .']); ?>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <h6>Alamat Faktur</h6>
                            <?= $this->Form->control('address_tax_invoice', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat faktur...', 'type' => 'text']); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="default-tab-3">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>NPWP</h6>
                            <?= $this->Form->control('npwp', ['label' => false, 'class' => 'form-control npwp', 'placeholder' => 'Nomor Pokok Wajib Pajak . . .']); ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>Nama Bank</h6>
                            <?= $this->Form->control('bank_name_ori', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama bank . . .']); ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <h6>No. Rekening</h6>
                            <?= $this->Form->control('bank_norek_ori', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor rekening bank . . .']); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <h6>No. Virtual Account</h6>
                            <?= $this->Form->control('va_no', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor Virtual Account . . .']); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <h6>Nama Virtual Account</h6>
                            <?= $this->Form->control('va_name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama virtual account . . .']); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check form-check-inline">
                            <p>&nbsp;</p>
                            <?= $this->Form->checkbox('ppn', ['label' => false, 'value' => '1', 'class' => 'form-check-input', 'hiddenField' => true, 'checked' => ($customer->ppn == '1' ? 'checked' : '')]); ?>
                            <label class="form-check-label text-danger">(Centang jika include Ppn)</label>
                        </div>
                    </div> 
                </div>
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
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'Customers', 'action' => 'edit', $customer->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

        $('.cs').select2({
            placeholder: "Tanpa title . . ."
        });

        $(".telp").mask("999999999999", {
            autoclear: false
        });

        $('.npwp').mask('999.999.999.9-999.999', {
            autoclear: false
        });

        $('.slc').select2({
            position: 'below'
        });

        $('.povinsi').select2({
            placeholder: "Cari provinsi . . .",

        }).on('select2:select', (e) => {
            let id = e.params.data.id;
            $('#prov').val(e.params.data.text);
            $.ajax({
                url: "<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'Customers', 'action' => 'getkabupaten']); ?>",
                method: "get",
                data: {
                    id: id
                },
                success: function(data) {
                    $('.kab').html('');
                    $('.kab').prop('disabled', false);
                    $.each(data, (i, val) => {
                        $(".kab").append('<option value="' + i + '">' + val + '</option>');
                    });
                }
            });
        });

        $('.kab').select2({
            placeholder: "Pilih kabupaten . . ."
        }).on('select2:select', (e) => {
            $('#kab').val(e.params.data.text);
        });
    });
</script>
