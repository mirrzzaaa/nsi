<?= $this->Krs->breadcrumb_('Master', 'Member', 'Add') ?>
<?= $this->Form->create($member, []) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="row">
    <div class="col-lg-8 mb-3">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-users fa-lg me-2 text-gray text-opacity-50"></i>
                Member
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Kode</label>
                        <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $data['lastNumber'], 'readonly']); ?>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="" class="form-label">Nama</label>
                        <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama member...']); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Alamat</label>
                    <?= $this->Form->control('address', ['label' => false, 'class' => 'form-control']); ?>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">NPWP</label>
                        <?= $this->Form->control('npwp', ['label' => false, 'class' => 'form-control', 'placeholder' => 'NPWP...']); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Pajak</label>
                        <?= $this->Form->control('tax', ['label' => false, 'class' => 'form-control', 'options' => ['y' => 'Menggunakan', 'n' => 'Tidak Menggunakan']]); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">PpN</label>
                        <div class="form-check">
                            <input class="form-check-input" type="hidden" name="ppn" value="0" />
                            <input class="form-check-input" type="checkbox" name="ppn" value="1" />
                            <label class="form-check-label" for="checkbox1">(Centang jika ppn include)</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="" class="form-label">Website</label>
                    <?= $this->Form->control('website', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat website...']); ?>
                </div>
            </div>
            <div class="card-footer bg-none d-flex p-3">
                <button class="btn btn-primary ms-auto" type="submit" id='btn-add'>Simpan</button>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-3">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-user-tie fa-lg me-2 text-gray text-opacity-50"></i>
                PIC
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="" class="form-label">Nama</label>
                    <?= $this->Form->control('pic', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama pic...']); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Telepon</label>
                    <?= $this->Form->control('telp', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor telepon...']); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Email</label>
                    <?= $this->Form->control('email', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat email...']); ?>
                </div>
            </div>
        </div>
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-calendar-alt fa-lg me-2 text-gray text-opacity-50"></i>
                Tanggal
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="" class="form-label">Registrasi</label>
                    <?= $this->Form->control('date_registries', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal registrasi...', 'type' => 'text']); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Expired</label>
                    <?= $this->Form->control('date_expires', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal expired...', 'type' => 'text']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

<script>
    $(document).ready(function() {

        $('.slc').select2({
            placeholder: "Pilih salah satu"
        });

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose : true,
            todayHighlight: true,
        });
    });
</script>
