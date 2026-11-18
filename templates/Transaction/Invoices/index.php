<?php

use Cake\Utility\Hash;

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */

$cross = '<i class="fa fa-times"></i>';
$tick = '<i class="fa fa-check"></i>';
$hourglass = '<i class="fa fa-hourglass-half"></i>';

?>
<?= $this->Krs->breadcrumb_('Cetak', 'Invoices', '') ?>

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
                        <?= $this->Form->control('filtercode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No invoice...', 'value' => $this->request->getQuery('filtercode')]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('filtercustomer', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Customer...', 'value' => $this->request->getQuery('filtercustomer')]); ?>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <?php
                            echo $this->Krs->inputDateRange('filterstart', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. buat..', 'value' => $this->request->getQuery('filterstart')), 'filterend', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. buat..', 'value' => $this->request->getQuery('filterend')), 's/d', 'resetDateReceive');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filterstatus', ['label' => false, 'class' => 'form-control status', 'data-placeholder' => 'Status...', 'empty' => 'Status...', 'options' => $this->Krs->statusInvoices(), 'value' => $this->request->getQuery('filterstatus')]); ?>
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
                            <th class="text-center" width="30">#</th>
                            <th width="100">No. Invoice</th> 
                            <th class="text-center">Customer</th>
                            <th class="text-center" width="50">DPP</th>
                            <th class="text-center" width="50">PPN</th>
                            <th class="text-center" width="50">Total</th>
                            <th class="text-center" width="200">Tgl. Buat</th>
                            <th class="text-center" width="100">Status Pembayaran</th>
                            <th class="text-center" width="100">Tgl. Cetak</th>
                            <th class="text-center" width="80">Admin</th>
                            <th class="actions text-center" width="80"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($invoices) > 0) {
                            foreach ($invoices as $index => $data) :
                                // pr($data);
                                $deliveryStatus = $data->delivery;
                                $deliveryDate = !empty($data->delivery_date) ? date_format($data->delivery_date, 'd-m-Y') : '-';

                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                                $linkChild = array('action' => 'child', $data->id);
                                $linkChildEdit = array('action' => 'childEdit', $data->id);
                                $linkChildPreview = array('action' => 'childView', $data->id);

                                $status = ''; 
                                $badge = '';
                                $table = '';

                                if ($data->payment == 'N') {
                                    if ($data->parent_id > 0) {
                                        $status = 'Invoice Proforma';
                                        $tanggal = '';
                                        $badge = 'bg-yellow';
                                        $box = 'bg-light';
                                        $table = '';
                                    } else {
                                        $status = 'Belum Terbayar';
                                        $tanggal = '';
                                        $badge = 'bg-warning';
                                        $box = 'bg-light';
                                        $table = '';
                                    }
                                } elseif ($data->payment == 'Y') {
                                    $status = 'Terbayar';
                                    $tanggal = !empty($data->payment_date_1) ? date_format($data->payment_date_1, 'd-m-Y') : '';
                                    $badge = 'bg-success';
                                    $box = 'bg-light';
                                    $table = 'table-success';
                                } else {
                                    $status = 'Kurang Bayar';
                                    $tanggal = empty($data->payment_date_2) && empty($data->payment_date_3)
                                                ? (!empty($data->payment_date_1) ? date_format($data->payment_date_1, 'd-m-Y') : '')
                                                : (!empty($data->payment_date_1) && empty($data->payment_date_3)
                                                    ? (!empty($data->payment_date_2) ? date_format($data->payment_date_2, 'd-m-Y') : '')
                                                    : (!empty($data->payment_date_3) ? date_format($data->payment_date_3, 'd-m-Y') : ''));
                                    $badge = 'bg-lime';
                                    $box = 'bg-light';
                                    $table = 'table-lime';
                                }

                        if($deliveryStatus !== NULL) {
                            $statusDeliveryStatus = $tick.' ('.$deliveryDate.')';
                        } else {
                            $statusDeliveryStatus = $cross;
                        }

                        if ($data->dp_nominal !== null && $data->dp_nominal > 0) {
                            $dpNominal = $data->dp_nominal;
                            $dpPpn = ($data->dp_ppn > 0) ? ($data->dp_nominal * 11) / 100 : 0;
                            $dpTotal = $data->dp_nominal + $dpPpn;
                        } elseif ($data->proforma_nominal !== null && $data->proforma_nominal > 0) {
                            $dpNominal = $data->proforma_nominal;
                            $dpPpn = ($data->proforma_ppn > 0) ? ($data->proforma_nominal * 11) / 100 : 0;
                            $dpTotal = $data->proforma_nominal + $dpPpn;
                        } else {
                            if ($data->ppn > 0) {
                                $dpTotal = $data->grandtotal;
                                $dpNominal = $dpTotal / 1.11;
                                $dpPpn = $dpTotal - $dpNominal;
                            } else {
                                $dpNominal = $data->grandtotal;
                                $dpTotal = $data->grandtotal;
                            }
                        
                        }
                                     
                        ?>
                                <tr class="<?= $table ?>">
                                    <td class="text-center"><?= $no ?></td>
                                    <td><b><?= (!empty($data->code) ? $data->code : '-') ?></b></td>

                                    <td>
                                        <span class="badge border border-dark text-dark px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center <?= $box ?>" 
                                              style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word; text-align: center; 
                                                     width: 140px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                            <?= (!empty($data->order) ? $data->order->pelanggan->name : '-') ?>
                                        </span>
                                    </td>
                                    <td class="text-end"><b><?= $this->Krs->_currency($dpNominal) ?></b></td>
                                    <td class="text-end"><b><?= (($data->ppn > 0 ) ? $this->Krs->_currency($dpPpn) : '-') ?></b></td>
                                    <td class="text-end"><b><?= $this->Krs->_currency($dpTotal) ?></b></td>
                                    <td class="text-center"><?= ($data->date == null ? '-' : date_format($data->date, 'd-m-Y')) ?></td>
                                    <!-- <td class="text-center"><?= $statusDeliveryStatus ?></td> -->
                                    <td class="text-center">
                                        <div>
                                            <span class="badge <?= $badge ?>"><?= $status ?></span>
                                        </div>
                                        <div>
                                            <small style="color: gray;"><i><b><?= $tanggal ?></b></i></small>
                                        </div>
                                    </td>
                                    <td class="text-center"><?= ($data->rpt_invoice_date == null ? '-' : date_format($data->rpt_invoice_date, 'd-m-Y') . ' (' . $data->rpt_invoice . ')') ?></td>
                                    <td class="text-center"><?= (!empty($data->is_create) ? $data->user->code : '-') ?></td>
                                    <td class="with-btn text-center" nowrap>

                                        <?php
                                            if ($data->parent_id == 0) {
                                                echo $this->Krs->btn('preview', $linkPreview, $data['id']);
                                            } elseif ($data->parent_id > 0) {
                                                echo $this->Krs->btn('preview', $linkChildPreview, $data['id']);
                                            }
                                        ?>

                                        <?php
                                            if ($data->parent_id == 0 && $checkUrl['invoices']['edit'] == 1) {
                                                echo $this->Krs->btn('edit', $linkEdit);
                                            } elseif ($data->parent_id > 0 && $checkUrl['invoices']['childEdit'] == 1) {
                                                echo $this->Krs->btn('edit', $linkChildEdit);
                                            }
                                        ?>

                                        <?php
                                        if ($data->parent_id == 0) {
                                            echo $this->Krs->btn('child', $linkChild, $data['id']);
                                        }
                                        ?>

                                    </td>
                                </tr>
                        <?php $no++;
                            endforeach;
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
$urlGetData = $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Invoices', 'action' => 'view', '_full' => true]);
$urlGetDataChild = $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Invoices', 'action' => 'childView', '_full' => true]);
?>

<!-- modal  -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<script>
    $(document).ready(function() {

        datePickerReset('input-daterange', 'resetDateReceive', 'filterDateReceive', 'dd-mm-yyyy');

        $('.status').select2({
            allowClear: true
        });

        $('.slc').select2({
            allowClear: true
        });

        <?php
        foreach ($invoices as $rs) {
            // Pastikan data yang digunakan adalah $rs, bukan $data
            if ($rs->parent_id == 0) {
                echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
            } elseif ($rs->parent_id > 0) {
                echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetDataChild . '/' . $rs->id . '");';
            }
        }
        ?>

    });
</script>
