<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
?>

<?= $this->Krs->breadcrumb_('Master', 'Armada', 'Tampilkan') ?>

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
                        <?= $this->Form->text('filternopol', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nopol...', 'value' => $this->request->getQuery('filternopol')]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->text('filtermerek', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Merek...', 'value' => $this->request->getQuery('filtermerek')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filterrangka', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No rangka...', 'value' => $this->request->getQuery('filterrangka')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filtermesin', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No mesin...', 'value' => $this->request->getQuery('filtermesin')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filterstatus', ['label' => false, 'class' => 'form-control status', 'data-placeholder' => 'Status...', 'empty' => 'Status...', 'options' => $this->Krs->_status(), 'value' => $this->request->getQuery('filterstatus')]); ?>
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
                            <th class="text-center">#</th>
                            <th width="150">Nopol</th>
                            <th>Merek</th>
                            <th>No. Rangka</th>
                            <th>No. Mesin</th>
                            <th>Asuransi</th>
                            <th>Bapedal</th>
                            <th class="text-center">Status</th>
                            <th class="actions text-center" width="80"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($trucks) > 0) {
                            foreach ($trucks as $index => $data) :
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                        ?>
                                <tr>
                                    <td class="text-center"><?php echo (!empty($no) ? $no : '-') ?></td>
                                    <td><strong><?php echo (!empty($data->name) ? $data->name : '-') ?></strong></td>
                                    <td><?php echo (!empty($data->merk) ? $data->merk : '-') . ' ' . (!empty($data->types) ? $data->types : '-') ?></td>
                                    <td><?php echo (!empty($data->chassis_no) ? $data->chassis_no : '-') ?></td>
                                    <td><?php echo (!empty($data->machine_no) ? $data->machine_no : '-') ?></td>
                                    <td><?php echo (!empty($data->insurance) ? $data->insurance : '-') ?></td>
                                    <td><?php echo (!empty($data->bapedal_registration) ? $data->bapedal_registration : '-') ?></td>
                                    <td class="text-center">
                                        <div id='statusSpin<?= $data->id ?>'></div>
                                        <div id='statusActive<?= $data->id ?>' style=""><a href="javascript:;" id="link<?= $data->id ?>" onclick="changeStatus({'id' : <?= $data->id ?>, 'status' : <?= $data->active ?>, 'is_update' : <?= $getUser->id ?> })" class="btn <?= $data->active ==  "1" ? "btn-lime" : "btn-danger"; ?> btn-icon btn-circle btn-sm"><i id="icon<?= $data->id ?>" class="<?= $data->active ==  "1" ? "fa fa-check" : "fa fa-times"; ?>"></i></a></div>
                                    </td>
                                    <td class="with-btn" nowrap>
                                        <a href="<?= $this->Url->build(['prefix' => 'Master', 'controller' => 'Trucks', 'action' => 'view', $data->id]);  ?>" class="btn btn-yellow btn-sm btn-preview p-l-15 p-r-15" data-toggle="tooltip" data-placement="top" data-original-title="Tampilkan"><i class="fa fa-tv"></i></a>
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



<!-- modal  -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<?php
$urlGetData = $this->Url->build(['prefix' => 'Master', 'controller' => 'Customers', 'action' => 'view', '_full' => true]);
?>


<script>
    $(document).ready(function() {
        $('.status').select2({
            allowClear: true
        });

        <?php
        foreach ($trucks as $rs) {
            echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
        }
        ?>

    });

    function changeStatus(val) {
        $('#statusSpin' + val.id + '').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').show();
        $('#statusActive' + val.id + '').hide();

        $.ajax({
            type: "POST",
            url: '<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'Trucks', 'action' => 'changestatus', '_full' => true]) ?>',
            dataType: 'json',
            data: {
                id: val.id,
                status: val.status == "1" ? "0" : "1",
                is_update: val.is_update
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
            },
            success: function(data) {
                if (data.status == 'success') {
                    $('#statusSpin' + val.id + '').html('').hide();
                    $('#statusActive' + val.id + '').show();
                    if (data.active == "1") {
                        $('#link' + val.id + '').toggleClass('btn-danger btn-lime');
                        $('#icon' + val.id + '').toggleClass('fa-times fa-check');
                    } else {
                        $('#link' + val.id + '').toggleClass('btn-lime btn-danger');
                        $('#icon' + val.id + '').toggleClass('fa-check fa-times');
                    }
                    // $('#statusActive' + val.id + '').show();
                } else {
                    alert('error mengirim data')
                }
            },
            error: function(err) {
                alert('error ambil data');
            }
        });
    }
</script>
