<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
?>
<?= $this->Krs->breadcrumb_('Data', 'Purchase Order', 'Tampilkan') ?>
 
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
                        <?= $this->Form->control('filtercode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No PO...', 'value' => $this->request->getQuery('filtercode')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filterwarehouse', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Gudang...', 'value' => $this->request->getQuery('filterwarehouse')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filtersupplier', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Supplier...', 'value' => $this->request->getQuery('filtersupplier')]); ?>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <?php
                            echo $this->Krs->inputDateRange('filterstart', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. buat..', 'value' => $this->request->getQuery('filterstart')), 'filterend', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. buat..', 'value' => $this->request->getQuery('filterend')), 's/d', 'resetDateReceive');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filterstatus', ['label' => false, 'class' => 'form-control slc', 'data-placeholder' => 'Status...', 'empty' => 'Status...', 'options' => $this->Krs->statusPO(), 'value' => $this->request->getQuery('filterstatus')]); ?>
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
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" width="30">#</th>
                            <th class="text-center" width="150">No. PO</th>
                            <th>Gudang</th>
                            <th>Supplier</th>
                            <th class="text-center">Tgl. Buat</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Status</th>
                            <th class="actions text-center" width="80"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($purchasings) > 0) {
                            foreach ($purchasings as $index => $data) :
                                //pr($data);
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                                $linkApprove = array('action' => 'approve', $data->id);
                                $linkCancel = array('action' => 'cancel', $data->id);

                                $status = '';
                                $badge = '';
                                $table = '';
                                switch ($data->status_wait) {
                                    case 'Wait':
                                        $status = 'Menunggu';
                                        $badge = 'bg-warning';
                                        $table = '';
                                        break;
                                    case 'Yes':
                                        $status = 'Diproses';
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
                                <tr class="<?= $table ?>">
                                    <td class="text-center"><?= $no ?></td>
                                    <td><strong><?= $data->number ?></strong></td>
                                    <td><?= (($data->warehouse_id > 0) ? ((!empty($data->warehouse)) ? $data->warehouse->name : '-') : '-') ?></td>
                                    <td><span class="badge border border-dark text-dark px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i><?= (($data->supplier_id > 0) ? ((!empty($data->supplier)) ? $data->supplier->name : '-') : '-') ?></span></td>
                                    <td class="text-center"><?= ($data->date == null) ? '-' : date_format($data->date, 'd-m-Y') ?></td>

                                    <?php if ($data->with_price !== 'N') { ?>
                                        <td class="text-end"><strong><?= $this->Krs->_currency($data->grandtotal); ?></strong></td>
                                    <?php } else { ?>
                                        <td class="text-end"><strong>(Tanpa harga)</strong></td>
                                    <?php } ?>

                                    <td class="text-center"><span class="badge <?= $badge ?>"><?= $status ?></span></td>
                                    <td class="with-btn text-center" nowrap>
                                        <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Purchasings', 'action' => 'view', $data->id]);  ?>" class="btn btn-yellow btn-sm btn-preview p-l-15 p-r-15" data-toggle="tooltip" data-placement="top" data-original-title="Tampilkan"><i class="fa fa-tv"></i></a>

                                        <?php
                                        if (($checkUrl['purchasings']['approve'] == 1) && ($data->status_wait == 'Wait')) {
                                            echo $this->Krs->btn('approve', $linkApprove);
                                        }
                                        ?>

                                        <?php
                                        if (($checkUrl['purchasings']['cancel'] == 1) && ($data->status_wait == 'Wait')) {
                                            echo $this->Krs->btn('cancel', $linkCancel);
                                        }
                                        ?>

                                        <?php
                                        if (($checkUrl['purchasings']['edit'] == 1) && ($data->invoice_entry_id == '0')) {
                                            echo $this->Krs->btn('edit', $linkEdit);
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
$urlGetData = $this->Url->build(['prefix' => false, 'controller' => 'Purchasings', 'action' => 'view', '_full' => true]);
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
        foreach ($purchasings as $rs) {
            echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
        }
        ?>

    });
</script>
