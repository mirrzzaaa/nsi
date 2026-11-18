<?php


/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
?>
<?= $this->Krs->breadcrumb_('Master', 'Kategori Jenis Produk', 'Tampilkan') ?>

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
                        <?= $this->Form->control('filtername', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Jenis Produk...', 'value' => $this->request->getQuery('filtername')]); ?>
                    </div>
                    <div class="col-md-5">
                        <?= $this->Form->control('filternote', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Keterangan...', 'value' => $this->request->getQuery('filternote')]); ?>
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
                            <th>Kode</th>
                            <th>Nama Kategori</th>
                            <th>Keterangan</th>
                            <th class="actions text-center" width="100"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($categories) > 0) {
                            foreach ($categories as $index => $data) :
                                $linkPreview = array('action' => 'preview', $data->id); 
                                $linkEdit = array('action' => 'edit', $data->id);
                        ?>
                                <tr>
                                    <td><?php echo (!empty($no) ? $no : '-') ?></td>
                                    <td><strong><?php echo (!empty($data->code) ? $data->code : '-') ?></strong></td>
                                    <td><?php echo (!empty($data->name) ? $data->name : '-') ?></td>
                                    <td><?php echo (!empty($data->note) ? $data->note : '-') ?></td>
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
$urlGetData = $this->Url->build(['prefix' => 'Master', 'controller' => 'Categories', 'action' => 'view', '_full' => true]);
?>

<!-- modal  -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<script>
    $(document).ready(function() {

        
        <?php
        foreach ($categories as $rs) {
            echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
        }
        ?>


    });
</script>
