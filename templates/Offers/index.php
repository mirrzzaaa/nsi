<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
?>
<?= $this->Krs->breadcrumb_('Data', 'Penawaran', 'Tampilkan') ?> 

<style type="text/css">

    /* Gaya umum untuk grup tombol */
    .btn-group {
        position: relative;
        display: inline-block;
    }

    /* Gaya tombol */ 
    .bttn {
        background-color: #BBE244; /* Warna latar belakang tombol */
        color: white; /* Warna teks tombol */
        padding: 6px 11px;
        font-size: 12px;
        border: none; /* Menghapus border tombol */
        cursor: pointer; /* Kursor pointer saat hover */
        border-radius: 4px;
    }

    /* Gaya tombol dropdown */
    .dropdown-toggle {
        border-left: 1px solid #ddd; /* Garis pemisah */
    }

    /* Konten dropdown (tersembunyi secara default) */
    .dropdown-menu {
        display: none; /* Menyembunyikan konten secara default */
        position: absolute; /* Posisi absolut untuk mengatur posisi dropdown */
        background-color: #f9f9f9; /* Warna latar belakang dropdown */
        min-width: 160px; /* Lebar minimum dropdown */
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); /* Bayangan dropdown */
        z-index: 1; /* Agar konten dropdown berada di atas elemen lain */
        border-radius: 4px; /* Radius border untuk sudut dropdown */
        top: 100%; /* Menempatkan dropdown tepat di bawah tombol */
        right: 0;
    }

    /* Item dropdown */
    .dropdown-menu a {
        color: black; /* Warna teks item dropdown */
        padding: 12px 16px; /* Padding item dropdown */
        text-decoration: none; /* Menghapus garis bawah teks */
        display: block; /* Membuat setiap item berada di baris sendiri */
    }

    /* Gaya saat hover pada item dropdown */
    .dropdown-menu a:hover {
        background-color: #ddd; /* Warna latar belakang saat hover */
    }

    /* Menampilkan konten dropdown saat tombol diklik */
    .btn-group .dropdown-toggle:focus + .dropdown-menu,
    .btn-group .dropdown:hover .dropdown-menu {
        display: block;
    }

</style>

<div class="panel">
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Krs->addButton(); ?> 
                        <?= $this->Krs->downloadButton(); ?> 
                    </div>
                </div>
            </div>
            <br>
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-body bg-info">
                <div class="row">
                    <div class="col-md-2">
                        <?= $this->Form->control('filtercode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No. ref...', 'value' => $this->request->getQuery('filtercode')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filtercustomer', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Customer...', 'value' => $this->request->getQuery('filtercustomer')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filtermkt', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Marketing...', 'value' => $this->request->getQuery('filtermkt')]); ?>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <?php 
                            echo $this->Krs->inputDateRange('filterstart', array("class" => "form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tgl. buat..', 'value' => $this->request->getQuery('filterstart')), 'filterend', array("class" => "form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tgl. buat..', 'value' => $this->request->getQuery('filterend')), 's/d', 'resetDate');
                            ?>
                        </div> 
                    </div>
                    <div class="col-md-1">
                        <?= $this->Form->button('Cari', ['class' => 'btn btn-yellow btn-block', 'type' => 'submit', 'id' => 'carimanifest_out']); ?>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th width="200" class="text-center">No. Ref</th>
                            <th width="300">Customer</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Marketing</th>
                            <th class="text-center">Approve</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;

                        if (count($offers) > 0) {

                            foreach ($offers as $index => $data) {
                                $checkAppr = "";

                                if ($data->is_approve == null) {
                                    $checkAppr = '<i class="fa fa-times"></i>';
                                } else {
                                    $checkAppr = '<i class="fa fa-check"></i>' . ' (' . $this->Krs->fDate($data->approve_date, 'd-m-Y') . ')';
                                }

                                $linkEdit = array('action' => 'edit', $data->id);
                                $linkApprove = array('action' => 'approve', $data->id);
                                $linkPrint = array('action' => 'print', $data->id);
                        ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td class="text-center"><b><?= $data->code ?></b></td>
                                    <td><i><?= $data->customer_name == '' ? '-' : $data->customer_name; ?></i></td>
                                    <td class="text-center"><?= $this->Krs->fDate($data->date, 'd-m-Y'); ?></td>
                                    <td class="text-center"><?= $data->marketing->name ?></td>
                                    <td class="text-center"><?= $checkAppr ?></td>
                                    <td class="with-btn text-center" nowrap>
                                        <?php
                                        if ($data->is_approve == null) {
                                            echo $this->Krs->btn('approve', $linkApprove);
                                        }
                                        ?>

                                        <?php if ($data->is_approve != null): ?>
                                            <div class="btn-group">
                                                <div class="dropdown">
                                                    <button class="bttn btn-orange dropdown-toggle" id="dropdownMenuButton">
                                                        <i class="fa fa-print"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a href="<?= $this->Url->build(['action' => 'print', $data->id]); ?>" class="dropdown-item" target="_blank">Dengan header footer</a>
                                                        <a href="<?= $this->Url->build(['action' => 'printOut', $data->id]); ?>" class="dropdown-item" target="_blank">Tanpa header footer</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?= $this->Krs->btn('edit', $linkEdit) ?>
                                    </td>
                                </tr>
                        <?php
                                $no++;
                            }
                        } else {
                            echo $this->Krs->dataNull();
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?= $this->Krs->paginators() ?>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        datePickerReset('input-daterange', 'resetDate', 'filterDate', 'dd-mm-yyyy');

    });
</script>
