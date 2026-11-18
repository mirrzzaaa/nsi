<?php


/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
?>
<?= $this->Krs->breadcrumb_('Master', 'Daerah', 'Tampilkan') ?>

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
                    <div class="col-md-4">
                        <?= $this->Form->control('filtername', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama Daerah...', 'value' => $this->request->getQuery('filtername')]); ?>
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
                            <th>Kode Daerah</th>
                            <th>Nama Daerah</th>
                            <th class="actions text-center" width="100"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($area) > 0) {
                            foreach ($area as $index => $data) :
                                $linkPreview = array('action' => 'preview', $data->id); 
                                $linkEdit = array('action' => 'edit', $data->id);
                        ?>
                                <tr>
                                    <td class="text-center"><?php echo (!empty($no) ? $no : '-') ?></td>
                                    <td ><strong><?php echo (!empty($data->code) ? $data->code : '-') ?></strong></td>
                                    <td><?php echo (!empty($data->name) ? $data->name : '-') ?></td>
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

    <div class="panel-footer">
        <div class="table-toolbar">
            <div class="btn-group">
                <?= $this->Form->create($area, ['type' => 'file', 'url' => ['action' => 'dataExportImport', 'save']]) ?>
                <div class="portlet-body">
                    <div class="note note-yellow">
                        <div class="note-icon"><i class="fas fa-upload"></i></div>
                        <div class="note-content text-end">                             
                            <h4><b>Upload Data melalui file Excel...</b></h4>
                            <?php
                            echo $this->Form->file('filename', array('label' => false, 'size' => '50'));                            
                            
                            echo $this->Form->button('Upload', ['class'=>'btn btn-primary', 'type'=>'submit', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Upload", 'id'=> 'btn-upload']);
                            ?>
                        </div>
                    </div>                      
                </div>
                <?php echo $this->Form->end(); ?>
            </div> 
        </div>
    </div>

</div>


 
<?php
$urlGetData = $this->Url->build(['prefix' => 'Master', 'controller' => 'Area', 'action' => 'view', '_full' => true]);
?>

<!-- modal  -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<script>
    $(document).ready(function() {

        
        <?php
        foreach ($area as $rs) {
            echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
        }
        ?>


    });
</script>
