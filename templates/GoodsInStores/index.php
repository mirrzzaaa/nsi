<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
?>
<?= $this->Krs->breadcrumb_('Data', 'Masuk Toko', 'Tampilkan') ?>

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
                        <?= $this->Form->control('filtercode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Kode...', 'value' => $this->request->getQuery('filtercode')]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('filterdesc', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Keterangan...', 'value' => $this->request->getQuery('filterdesc')]); ?>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <?php
                            echo $this->Krs->inputDateRange('filterstart', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. masuk..', 'value' => $this->request->getQuery('filterstart')), 'filterend', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. masuk..', 'value' => $this->request->getQuery('filterend')), 's/d', 'resetDateReceive');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filterwarehouse', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Gudang...', 'value' => $this->request->getQuery('filterwarehouse')]); ?>
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
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr class="bg-black text-white">
                            <th class="text-center" width="50">#</th>
                            <th width="250">Kode</th>
                            <th class="text-center" width="100">Dari</th>
                            <th class="text-center">Tgl. Masuk</th>
                            <th class="text-center">Toko</th>
                            <th class="actions text-center" width="80"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($goodsInStores) > 0) {
                            foreach ($goodsInStores as $index => $data) : 
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                        ?>
                                <tr>
                                    <td class="text-center"><?= $no ?></td>
                                    <td><strong><?= (!empty($data->code) ? $data->code : '-') ?></strong></td>
                                    <td class="text-center"><span class="badge bg-danger"><?= $this->Krs->typeItem($data->is_from);  ?> </span></td>
                                    <td class="text-center"><?= (($data->date != null) ? $this->Krs->fDate($data->date, 'd-m-Y') : '') ?></td>
                                    <td class="text-center"><b><?= (($data->branch_id > 0) ? (!empty($data->branch) ? $data->branch->name : '-') : '-') ?></b></td>
                                    <td class="with-btn" nowrap>
                                        <?= $this->Krs->btn('preview', $linkPreview, $data['id']); ?>
                                        <?= $this->Krs->btn('edit', $linkEdit) ?>
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
$urlGetData = $this->Url->build(['prefix' => false, 'controller' => 'GoodsInStores', 'action' => 'view', '_full' => true]);
?>

<!-- modal  -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<script>
    $(document).ready(function() {

        datePickerReset('input-daterange', 'resetDateReceive', 'filterDateReceive', 'dd-mm-yyyy');

        <?php
        foreach ($goodsInStores as $rs) {
            echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
        }
        ?>

    });
</script>
