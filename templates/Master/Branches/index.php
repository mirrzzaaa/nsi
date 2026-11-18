<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
?>
<?= $this->Krs->breadcrumb_('Master', 'Cabang', 'Tampilkan') ?>

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
                    <div class="col-md-1">
                        <?= $this->Form->control('filtercode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Kode...', 'value' => $this->request->getQuery('filtercode')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filtername', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Cabang...', 'value' => $this->request->getQuery('filtername')]); ?>
                    </div>
                    <div class="col-md-4">
                        <?= $this->Form->control('filteraddress', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat...', 'value' => $this->request->getQuery('filteraddress')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filtertelp', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Telepon...', 'value' => $this->request->getQuery('filtertelp')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filterstatus', ['label' => false, 'class' => 'form-control slc', 'data-placeholder' => 'Status...', 'empty' => 'Status...', 'options' => $this->Krs->is_active(), 'value' => $this->request->getQuery('filterstatus')]); ?>
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
                            <th class="text-center" width="30">#</th>
                            <th class="text-center" width="80">Kode</th>
                            <th>Cabang</th>
                            <th>Alamat</th>
                            <th class="text-center">Telepon</th>
                            <th class="text-center">Status</th>
                            <th class="actions text-center" width="100"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($branches) > 0) {
                            foreach ($branches as $index => $data) :
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                        ?>
                                <tr>
                                    <td class="text-center"><?php echo (!empty($no) ? $no : '-') ?></td>
                                    <td class="text-center"><strong><?php echo (!empty($data->code) ? $data->code : '-') ?></strong></td>
                                    <td><?php echo (!empty($data->company_name) ? $data->company_name : '-') ?></td>
                                    <td><?php echo (!empty($data->company_address) ? $data->company_address : '-') ?></td>
                                    <td class="text-center"><?php echo (!empty($data->company_telp) ? $data->company_telp : '-') ?></td>
                                    <td class="text-center">
                                        <div id='statusSpin<?= $data->id ?>'></div>
                                        <div id='statusActive<?= $data->id ?>' style=""><a href="javascript:;" id="link<?= $data->id ?>" onclick="changeStatus({'id' : <?= $data->id ?>, 'status' : '<?= $data->is_active ?>', 'is_update' : <?= $getUser->id ?> })" class="btn <?= $data->is_active ==  "Y" ? "btn-lime" : "btn-danger"; ?> btn-icon btn-circle btn-sm"><i id="icon<?= $data->id ?>" class="<?= $data->is_active ==  "Y" ? "fa fa-check" : "fa fa-times"; ?>"></i></a></div>
                                    </td>
                                    <td class="with-btn text-center" nowrap>
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
$urlGetData = $this->Url->build(['prefix' => 'Master', 'controller' => 'Branches', 'action' => 'view', '_full' => true]);
?>

<!-- modal  -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<script>
    $(document).ready(function() {
        $('.slc').select2({
            allowClear: true
        });

        <?php
        foreach ($branches as $rs) {
            echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
        }
        ?>

    });


    function changeStatus(val) {
        $('#statusSpin' + val.id + '').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').show();
        $('#statusActive' + val.id + '').hide();

        $.ajax({
            type: "POST",
            url: '<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'Branches', 'action' => 'changestatus', '_full' => true]) ?>',
            dataType: 'json',
            data: {
                id: val.id,
                status: val.status == "Y" ? "N" : "Y",
                is_update: val.is_update
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
            },
            success: function(data) {
                if (data.status == 'success') {
                    $('#statusSpin' + val.id + '').html('').hide();
                    $('#statusActive' + val.id + '').show();
                    if (data.is_active == "Y") {
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
