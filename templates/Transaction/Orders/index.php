<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
//pr($orders);
?>
<?= $this->Krs->breadcrumb_('Data', 'Order', 'Tampilkan') ?> 
 
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
                        <?= $this->Form->control('filtercode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No order...', 'value' => $this->request->getQuery('filtercode')]); ?>
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
                        <?= $this->Form->control('filterstatus', ['label' => false, 'class' => 'form-control slc', 'data-placeholder' => 'Status...', 'empty' => 'Status...', 'options' => $this->Krs->statusWait(), 'value' => $this->request->getQuery('filterstatus')]); ?>
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
                            <th class="text-center" width="100">No. Order</th>
                            <th class="text-center">Customer</th>
                            <th class="text-center">Tgl. Buat</th> 
                            <th class="text-center">Total</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Admin</th>
                            <th class="actions text-center" width="80"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        // pr(count($orders));
                        if (count($orders) > 0) {
                            // pr($orders);
                            foreach ($orders as $rowData) {
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
                                        $box = 'bg-light';
                                        $table = '';
                                        break;
                                    case 'Yes':
                                        $status = 'Terkirim';
                                        $badge = 'bg-success';
                                        $box = 'bg-light';
                                        $table = 'table-success';
                                        break;
                                    default:
                                        $status = 'Batal';
                                        $badge = 'bg-danger';
                                        $box = 'bg-light';
                                        $table = 'table-danger';
                                        break;
                                }
                        ?>
                                <tr class="<?= $table ?>">
                                    <td class="text-center"><?php echo (!empty($no) ? $no : '-') ?></td> 
                                    <td><strong><?php echo (!empty($rowData->code) ? $rowData->code : '-') ?></strong></td>
                                    <td><span class="badge border border-dark text-dark px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center <?= $box ?>"><i class="fa fa-circle fs-9px fa-fw me-5px"></i><?= ((!empty($rowData->pelanggan)) ? $rowData->pelanggan->name : '-')  ?></span></td>
                                    <td class="text-center"><?= ($rowData->date == null) ? '-' : date_format($rowData->date, 'd-m-Y') ?></td>
                                    
                                    <?php if ($rowData->with_price !== 'N') { ?> 
                                        <td class="text-end"><strong><?= $this->Krs->_currency($rowData->grandtotal); ?></strong></td> 
                                    <?php } else { ?>
                                        <td class="text-end"><strong>(Tanpa harga)</strong></td>
                                    <?php } ?>

                                    <td class="text-center"><span class="badge <?= $badge ?>"><?= $status ?></span></td>
                                    <td class="text-center"><?= (!empty($rowData->user) ? $rowData->user->code : '-') ?></td>
                                    <td class="with-btn text-center" nowrap>
                                        <?= $this->Krs->btn('preview', $linkPreview, $rowData['id']); ?> 

                                        <?php
                                        if (($checkUrl['orders']['edit'] == 1) && ($rowData->status_wait == 'Wait') && ($rowData->permit_id == 0) && ($rowData->invoice_id == 0)) {
                                            echo $this->Krs->btn('edit', $linkEdit);
                                        }
                                        ?>

                                        <?php
                                        if (($checkUrl['orders']['approve'] == 1) && ($rowData->status_wait == 'Wait')) {
                                            echo $this->Krs->btn('approve', $linkApprove);
                                        }
                                        ?>

                                        <?php
                                        //if (($checkUrl['orders']['delivery'] == 1) && ($rowData->permit_id == 0)) {
                                        //    echo $this->Krs->btn('delivery', $linkDelivery);
                                        //}
                                        ?>

                                    </td>
                                </tr>
                        <?php $no++;
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
$urlGetData = $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Orders', 'action' => 'view', '_full' => true]);
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
        foreach ($orders as $rs) {
            echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
        }
        ?>

    });
</script>
