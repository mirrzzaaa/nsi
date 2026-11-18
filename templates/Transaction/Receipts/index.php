<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */

// pr($receipts);

?>
<?= $this->Krs->breadcrumb_('Data', 'Kwitansi', 'Tampilkan') ?> 

<style type="text/css">

    /* Gaya umum untuk grup tombol */
    .btn-group {
        position: relative;
        display: inline-block;
    }

    /* Gaya tombol */
    .bttn {
        background-color: #FF9500; /* Warna latar belakang tombol */
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
                        <!-- $this->Krs->addButton();  -->
                        <?= $this->Krs->downloadButton(); ?>   
                    </div>
                </div>
            </div>
            <br>
            <?= $this->Form->create(null, ['type' => 'get']) ?> 
            <div class="panel-body bg-info">
                <div class="row">
                    <div class="col-md-2">
                        <?= $this->Form->control('filtercode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No kwitansi...', 'value' => $this->request->getQuery('filtercode')]); ?>
                    </div>
                    <div class="col-md-4">
                        <?= $this->Form->control('filtercustomer', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Customer...', 'value' => $this->request->getQuery('filtercustomer')]); ?>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <?php
                            echo $this->Krs->inputDateRange('filterstart', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. bayar..', 'value' => $this->request->getQuery('filterstart')), 'filterend', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. bayar..', 'value' => $this->request->getQuery('filterend')), 's/d', 'resetDateReceive');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="btn-group w-100">
                            <?= $this->Krs->searchButton(); ?> 
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
            <br>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" width="20">#</th>
                            <th class="text-center">No. Kwitansi</th>
                            <th class="text-center">Nama Customer</th>
                            <th class="text-center">No. Invoices</th>
                            <th class="text-center" width="80">Pembayaran</th> 
                            <th class="text-center" width="90">Tgl. Bayar</th>
                            <th class="text-center">Nominal</th>
                            <th class="text-center">Cetak</th>
                            <th class="actions text-center" width="20"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $invoiceGroups = [];

                        if (count($receipts) > 0) {
                            foreach ($receipts as $rowData) {
                                $orders = $rowData->order;
                                $grandtotals = $orders->grandtotal;
                                $invoices = $rowData->invoice;
                                $paymentNominal = $invoices->payment_nominal_1;

                                if (!isset($invoiceGroups[$rowData->invoice_id])) {
                                    $invoiceGroups[$rowData->invoice_id] = 1;
                                } else {
                                    $invoiceGroups[$rowData->invoice_id]++;
                                }
                                
                                $paymentTypeWithNumber = !empty($rowData->payment_type) ? $rowData->payment_type . ' ' . $invoiceGroups[$rowData->invoice_id] : '-';

                                $displayPaymentType = ($paymentNominal == $grandtotals) ? 'Normal' : $paymentTypeWithNumber;

                                $linkPreview = array('action' => 'preview', $rowData->id);
                                $linkDelivery = array('action' => 'delivery', $rowData->id); 
                                $linkEdit = array('action' => 'edit', $rowData->id);
                                $linkApprove = array('action' => 'approve', $rowData->id);
                                $linkCancel = array('action' => 'cancel', $rowData->id);

                                $status = ''; 
                                $badge = '';
                                $table = '';
                                switch ($rowData->status_wait) {
                                    case 'Wait':
                                        $status = 'Diproses';
                                        $badge = 'bg-warning';
                                        $table = '';
                                        break;
                                    case 'Yes':
                                        $status = 'Terkirim';
                                        $badge = 'bg-success';
                                        $table = 'table-success';
                                        break;
                                    default:
                                        $status = 'Batal';
                                        $badge = 'bg-danger';
                                        $table = 'table-danger';
                                        break;
                                }
                        ?>
                                <tr>
                                    <td class="text-center"><?php echo $no++; ?></td> 
                                    <td><strong><?php echo (!empty($rowData->code) ? $rowData->code : '-') ?></strong></td>
                                    <td><span class="badge border border-dark text-dark px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i><?= ((!empty($rowData->customer)) ? $rowData->customer->name : '-')  ?></span></td>
                                    <td class="text-center"><?php echo (!empty($rowData->invoice) ? $rowData->invoice->code : '-') ?></td>
                                    <td class="text-center"><?= $displayPaymentType ?></td>
                                    <td class="text-center"><?= ($rowData->date == null) ? '-' : date_format($rowData->date, 'd-m-Y') ?></td>
                                    <td class="text-center"><?= $this->Krs->_currency($rowData->nominal); ?></td>
                                    <td width="80" class="text-center"><?= $rowData->print > 0 ? '<strong>(' . $rowData->print . ')</strong> ' . date_format($rowData->print_date, 'd-m-Y') : '-'; ?></td>
                                    <td class="text-center" width="90">
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="bttn btn-orange dropdown-toggle" id="dropdownMenuButton">
                                                    <i class="fa fa-print"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a href="<?= $this->Url->build(['action' => 'print', $rowData->id]); ?>" class="dropdown-item" target="_blank">Dengan header footer</a>
                                                    <a href="<?= $this->Url->build(['action' => 'printOut', $rowData->id]); ?>" class="dropdown-item" target="_blank">Tanpa header footer</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if ($invoices->payment !== 'Y') {
                                            echo $this->Krs->btn('edit', $linkEdit);
                                        }
                                        ?>
                                    </td>
                                </tr>
                        <?php
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



<?php
$urlGetData = $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Receipts', 'action' => 'view', '_full' => true]);
?>

<!-- modal  -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<script>
    $(document).ready(function() {

        datePickerReset('input-daterange', 'resetDateReceive', 'filterDateReceive', 'dd-mm-yyyy');

        $('.slc').select2({
            allowClear: true
        });

        <?php
        foreach ($receipts as $rs) {
            echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
        }
        ?>

    });
</script>
