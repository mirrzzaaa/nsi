<?php

//pr($returs);

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
?>
<?= $this->Krs->breadcrumb_('Data', 'Retur Customer', 'Tampilkan') ?>  

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
                        <?= $this->Form->control('filtercode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No retur...', 'value' => $this->request->getQuery('filtercode')]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('filtercustomer', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Customer...', 'value' => $this->request->getQuery('filtercustomer')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filtercodeorder', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No order...', 'value' => $this->request->getQuery('filtercodeorder')]); ?>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <?php
                            echo $this->Krs->inputDateRange('filterstart', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. buat..', 'value' => $this->request->getQuery('filterstart')), 'filterend', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. buat..', 'value' => $this->request->getQuery('filterend')), 's/d', 'resetDateReceive');
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
                            <th width="50">#</th>
                            <th width="250">No. Retur</th>
                            <th width="250">Customer</th>
                            <th width="150">No. Order</th>
                            <th class="text-center">Tgl. Retur</th>
                            <th class="actions text-center" width="80"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($returs) > 0) {
                            foreach ($returs as $index => $data) :
                                //pr($data->reason);
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkDelivery = array('action' => 'delivery', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);

                        ?>

                        <tr>
                            <td><?= $no ?></td>
                            <td><b><?= $data->code ?></b></td>
                            <td><span class="badge border border-dark text-dark px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i><?= (!empty($data->order->customer_id) ? $data->customer->name : '-') ?></span></td>
                            <td><b><?= (!empty($data->order) ? $data->order->code : '-') ?></b></td>
                            <td class="text-center"><?= ($data->date == null ? '-' : date_format($data->date, 'd-m-Y')) ?></td>
                            <td class="with-btn text-center" nowrap>
                                <?= $this->Krs->btn('preview', $linkPreview, $data['id']); ?>

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
$urlGetData = $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Returs', 'action' => 'view', '_full' => true]);
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
        foreach ($returs as $rs) {
            echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
        }
        ?>

    });
</script>
