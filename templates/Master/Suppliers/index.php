<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
?>
<?= $this->Krs->breadcrumb_('Master', 'Supplier', 'Tampilkan') ?>  

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
                        <?= $this->Form->control('filtername', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Supplier...', 'value' => $this->request->getQuery('filtername')]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('filteraddress', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat...', 'value' => $this->request->getQuery('filteraddress')]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('filterpic', ['label' => false, 'class' => 'form-control', 'placeholder' => 'PIC...', 'value' => $this->request->getQuery('filterpic')]); ?>
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
                            <th width="50">#</th>
                            <th width="100">Kode</th>
                            <th>Supplier</th>
                            <th>Alamat</th>
                            <th>PIC</th>
                            <th class="text-center">Pajak</th>
                            <th class="text-center">Status</th>
                            <th class="actions text-center" width="80"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($suppliers) > 0) {
                            foreach ($suppliers as $key => $data) :
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                        ?>
                                <tr>
                                    <td><?php echo (!empty($no) ? $no : '-') ?></td>  
                                    <td><strong><?php echo (!empty($data->code) ? $data->code : '-') ?></strong></td>
                                    <td><?php echo (!empty($data->name) ? $data->name : '-') ?></td>
                                    <td><?php echo (!empty($data->address) ? $data->address : '-') ?></td>
                                    <td><?= (($data->pic == null) && ($data->telp == null)) ? '-' : '(' . $data->telp . ') - ' . $data->pic; ?></td>
                                    <td class="text-center"><?= ($data->ppn > 0) ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>"; ?></td>
                                    <td class="text-center">
                                        <div id='statusSpin<?= $data->id ?>'></div>
                                        <div id='statusActive<?= $data->id ?>' style=""><a href="javascript:;" id="link<?= $data->id ?>" onclick="changeStatus({'id' : <?= $data->id ?>, 'status' : <?= $data->active ?>, 'is_update' : <?= $getUser->id ?> })" class="btn <?= $data->active ==  "1" ? "btn-lime" : "btn-danger"; ?> btn-icon btn-circle btn-sm"><i id="icon<?= $data->id ?>" class="<?= $data->active ==  "1" ? "fa fa-check" : "fa fa-times"; ?>"></i></a></div>
                                    </td>
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
$urlGetData = $this->Url->build(['prefix' => 'Master', 'controller' => 'Suppliers', 'action' => 'view', '_full' => true]);
?>

<!-- modal  -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<script>
    $(document).ready(function() {

        $('.status').select2({
            allowClear: true
        });

        <?php
        foreach ($suppliers as $idSupplier) {
            echo 'handleFormPreview("btn-preview' . $idSupplier->id . '", "' . $urlGetData . '/' . $idSupplier->id . '");';
        }
        ?>

    });


    function changeStatus(val) {
        $('#statusSpin' + val.id + '').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').show();
        $('#statusActive' + val.id + '').hide();

        $.ajax({
            type: "POST",
            url: '<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'Suppliers', 'action' => 'changestatus', '_full' => true]) ?>',
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
