<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
// pr($tandaTerima)
?>
<?= $this->Krs->breadcrumb_('Data', 'Tanda Terima', 'Tampilkan') ?> 

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
                        <?= $this->Form->control('filteruser', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Customer...', 'value' => $this->request->getQuery('filteruser')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filterinvoice', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No. invoice...', 'value' => $this->request->getQuery('filterinvoice')]); ?>
                    </div>
                    <div class="col-md-4">
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
                            <th width="30"class="text-center">#</th>
                            <th>Kode</th>
                            <th>Customer</th>
                            <th>No. Invoice</th>
                            <th width="100" class="text-center">Tanggal</th>
                            <th width="80" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;

                        if (count($tandaTerima) > 0) {

                            foreach ($tandaTerima as $index => $data) {
                                // pr($data);
                                $checkAppr = "";

                                if ($data->is_approve == null) {
                                    $checkAppr = '<i class="fa fa-times"></i>';
                                } else {
                                    $checkAppr = '<i class="fa fa-check"></i>' . ' (' . $this->Krs->fDate($data->approve_date, 'd-m-Y') . ')';
                                }

                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                                $linkApprove = array('action' => 'approve', $data->id);
                                $linkPrint = array('action' => 'print', $data->id);
                        ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td><?= (!empty($data->code) ? $data->code : '-') ?></td>
                                    <td><?= (!empty($data->invoice_id) ? $data->invoice->customer->name : '-') ?></td>
                                    <td><?= (!empty($data->invoice_id) ? $data->invoice->code : '-') ?></td>
                                    <td class="text-center"><?= ($data->date == null ? '-' : date_format($data->date, 'd-m-Y')) ?></td>
                                    <td class="with-btn text-center" nowrap>
                                        <?= $this->Krs->btn('preview', $linkPreview, $data['id']); ?>
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

<?php
$urlGetData = $this->Url->build(['prefix' => false, 'controller' => 'TandaTerima', 'action' => 'view', '_full' => true]);
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
        foreach ($tandaTerima as $rs) {
            echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
        }
        ?>

    });
</script>
