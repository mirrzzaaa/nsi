<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
// pr($letters)
?>
<?= $this->Krs->breadcrumb_('Data', 'No. Surat', 'Tampilkan') ?> 

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
                        <?= $this->Form->control('filtertujuan', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Tujuan advance...', 'value' => $this->request->getQuery('filtertujuan')]); ?>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <?php
                            echo $this->Krs->inputDateRange('filterstart', array("class" => "form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tgl. buat..', 'value' => $this->request->getQuery('filterstart')), 'filterend', array("class" => "form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tgl. buat..', 'value' => $this->request->getQuery('filterend')), 's/d', 'resetDate');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filteruser', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Admin...', 'value' => $this->request->getQuery('filteruser')]); ?>
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
                            <th width="90" class="text-center">Kode</th>
                            <th width="90" class="text-center">Project</th>
                            <th width="100" class="text-center">Tanggal</th>
                            <th class="text-center">Tujuan Advance</th>
                            <th class="text-center">Admin</th>
                            <th width="80" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;

                        if (count($letters) > 0) {

                            foreach ($letters as $index => $data) {
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
                                    <td class="text-center"><?= $data->project ?></td>
                                    <td class="text-center"><?= date('d M Y', strtotime($data->date)); ?></td>
                                    <td><?= $data->description ?></td>
                                    <td class="text-center"><?= (!empty($data->is_create) ? ($data->user->code) : '-') ?></td>
                                    <td class="with-btn text-center" nowrap>
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
