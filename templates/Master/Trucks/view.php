<?php
$dataChild = $this->Html->link('Armada', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Master', $dataChild, 'Lihat') ?>

<div class="row">
    <div class="col-lg-8 mb3">
        <div class="card border-0">
            <div class="card-header bg-yellow p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-truck fa-lg me-2 text-gray text-opacity-50"></i>
                Armada
            </div>
            <div class="card-body align-items-center">
                <?php
                if ($truck->image !== null) { ?>
                    <a href="<?= $this->request->getAttribute('webroot'); ?>upload/truck/<?= $truck->image ?>" data-lightbox="gallery-group-1">
                        <img src="<?= $this->request->getAttribute('webroot'); ?>upload/truck/<?= $truck->image ?>" width="70%" alt="img">
                    </a>
                <?php
                } else {
                    echo "<strong>Gambar Kosong</strong>";
                }
                ?>
                <hr>
                <div class="row">
                    <div class="col-2 col-sm-2 mb-2">
                        <b>Nopol</b>
                    </div>
                    <div class="col-4 col-sm-4 mb-2">: <i><?php echo (!empty($truck->name) ? $truck->name : '-') ?></i></div>
                    <div class="col-2 col-sm-2 mb-2">
                        <b>Merek</b>
                    </div>
                    <div class="col-4 col-sm-4 mb-2">: <i><?php echo (!empty($truck->merk) ? $truck->merk : '-') . ' ' . (!empty($truck->types) ? $truck->types : '-') ?></i></div>
                    <div class="col-2 col-sm-2 mb-2">
                        <b>Model</b>
                    </div>
                    <div class="col-4 col-sm-4 mb-2">: <i><?php echo (!empty($truck->model) ? $truck->model : '-') ?></i></div>
                    <div class="col-2 col-sm-2 mb-2">
                        <b>Warna</b>
                    </div>
                    <div class="col-4 col-sm-4 mb-2">: <i><?php echo (!empty($truck->color) ? $truck->color : '-') ?></i></div>
                    <div class="col-2 col-sm-2 mb-2">
                        <b>Jumlah Ban</b>
                    </div>
                    <div class="col-4 col-sm-4 mb-2">: <i><?php echo (!empty($truck->tire) ? $truck->tire : '-') ?></i></div>
                    <div class="col-2 col-sm-2 mb-2">
                        <b>Produksi</b>
                    </div>
                    <div class="col-4 col-sm-4 mb-2">: <i><?php echo (!empty($truck->production_year) ? $truck->production_year : '-') ?></i></div>
                    <div class="col-2 col-sm-2 mb-2">
                        <b>No. Bapedal</b>
                    </div>
                    <div class="col-4 col-sm-4 mb-2">: <i><?php echo (!empty($truck->bapedal_registration) ? $truck->bapedal_registration : '-') ?></i></div>
                    <div class="col-2 col-sm-2 mb-2">
                        <b>No. Asuransi</b>
                    </div>
                    <div class="col-4 col-sm-4 mb-2">: <i><?php echo (!empty($truck->insurance) ? $truck->insurance : '-') ?></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 mb-3">
            <div class="card-header bg-yellow p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-bezier-curve fa-lg me-2 text-gray text-opacity-50"></i>
                No. Rangka
            </div>
            <div class="card-body">
                <?php
                if ($truck->chassis_no_img !== null) { ?>
                    <a href="<?= $this->request->getAttribute('webroot'); ?>upload/truck/<?php echo (!empty($truck->chassis_no_img) ? $truck->chassis_no_img : '-') ?>" data-lightbox="gallery-group-1">
                        <img src="<?= $this->request->getAttribute('webroot'); ?>upload/truck/<?php echo (!empty($truck->chassis_no_img) ? $truck->chassis_no_img : '-') ?>" width="70%" alt="img">
                    </a>
                <?php
                } else {
                    echo "<strong>Gambar Kosong</strong>";
                }
                ?>
                <br> <br>
                <div class="row">
                    <div class="col-4 col-sm-4 mb-2">
                        <b>No. Rangka</b>
                    </div>
                    
                    <div class="col-8 col-sm-8 mb-2">: <i><?php echo (!empty($truck->chassis_no) ? $truck->chassis_no : '-') ?></i></div>
                </div>
            </div>
        </div>
        <div class="card border-0 mb-3">
            <div class="card-header bg-yellow p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-memory fa-lg me-2 text-gray text-opacity-50"></i>
                No. Mesin
            </div>
            <div class="card-body">
                <?php
                if ($truck->machine_no_img !== null) { ?>
                    <a href="<?= $this->request->getAttribute('webroot'); ?>upload/truck/<?php echo (!empty($truck->machine_no_img) ? $truck->machine_no_img : '-') ?>" data-lightbox="gallery-group-1">
                        <img src="<?= $this->request->getAttribute('webroot'); ?>upload/truck/<?php echo (!empty($truck->machine_no_img) ? $truck->machine_no_img : '-') ?>" width="70%" alt="img">
                    </a>
                <?php
                } else {
                    echo "<strong>Gambar Kosong</strong>";
                }
                ?>
                <br> <br>
                <div class="row">
                    <div class="col-4 col-sm-4 mb-2">
                        <b>No. Mesin</b>
                    </div>
                    <div class="col-8 col-sm-8 mb-2">: <i><?php echo (!empty($truck->machine_no) ? $truck->machine_no : '-') ?></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
