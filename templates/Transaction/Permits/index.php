<?php
// pr($permits);

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
$dataChild = $this->Html->link('Surat Jalan', ['action' => 'add'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Cetak', 'Surat Jalan') ?>

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
                        <?= $this->Form->control('filtercode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No surat jalan...', 'value' => $this->request->getQuery('filtercode')]); ?>
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
                        <?= $this->Form->control('filterdeliver', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Pengirim...', 'value' => $this->request->getQuery('filterdeliver')]); ?>
                    </div>
                    <div class="col-md-1">
                        <div class="btn-group w-100">
                            <?php
                            echo $this->Form->button('<i class="fas fa-search"></i>', array('class' => 'btn btn-yellow', 'type' => 'submit', 'id' => 'btnSearch', 'escapeTitle' => false, 'data-toggle' => 'tooltip', 'data-original-title' => "Cari"));
                            ?>
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
                            <th width="150">No. Surat Jalan</th>
                            <th>Customer</th>
                            <th width="150">No. Invoice</th>
                            <th>Pengirim</th>
                            <th class="text-center">Tgl. Buat</th>
                            <th class="text-center">Tgl. Cetak</th>
                            <th class="text-center">Admin</th>
                            <th class="actions text-center" width="80"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1; 
                        if (count($permits) > 0) {
                            foreach ($permits as $index => $data) :
                                // pr($data);
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                        ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><b><?= $data->code ?></b></td>
                                    <td><span class="badge border border-dark text-dark px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i><?= (!empty($data->order) ? $data->order->pelanggan->name : '-') ?></span></td>
                                    <td><?= (!empty($data->order->invoice->code) ? $data->order->invoice->code : '-') ?></td>
                                    <td><?= (!empty($data->truck_id) ? $data->truck->name : $data->delivered) ?></td>
                                    <td class="text-center"><?= ($data->date == null ? '-' : date_format($data->date, 'd-m-Y')) ?></td>
                                    <td class="text-center"><?= ($data->date_print == null ? '-' : date_format($data->date_print, 'd-m-Y') . ' (' . $data->is_print . ')') ?></td>
                                    <td class="text-center"><?= (!empty($data->is_create) ? $data->user->code : '-') ?></td>
                                    <td class="with-btn text-center" nowrap>
                                        <?= $this->Krs->btn('preview', $linkPreview, $data['id']); ?>

                                        <?php
                                        if (($data->is_print == 0)) {
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
$urlGetData = $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Permits', 'action' => 'view', '_full' => true]);
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
        foreach ($permits as $rs) {
            echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
        }
        ?>

    });
</script>
