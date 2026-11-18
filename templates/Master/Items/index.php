<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
?>
<?= $this->Krs->breadcrumb_('Master', 'Produk', 'Tampilkan') ?>
 
<div class="panel">
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Krs->addButton(); ?>  
                    </div> &nbsp;
                    <div class="dropdown">
                        <button class="btn btn-green dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-download"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item" href="<?= $this->Url->build(['prefix' => 'Master', 'controller' => 'Items', 'action' => 'excel']); ?>">
                                    Download
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= $this->Url->build(['prefix' => 'Master', 'controller' => 'Items', 'action' => 'template']); ?>">
                                    Template Farmalkes
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <br>
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-body bg-info">
                <div class="row">
                    <div class="col-md-3">
                        <?= $this->Form->control('filtercode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Kode internal...', 'value' => $this->request->getQuery('filtercode')]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('filtername', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Produk...', 'value' => $this->request->getQuery('filtername')]); ?>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <?php
                            echo $this->Krs->inputDateRange('filterstart', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. expired..', 'value' => $this->request->getQuery('filterstart')), 'filterend', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. expired..', 'value' => $this->request->getQuery('filterend')), 's/d', 'resetDateReceive');
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
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr class="bg-black text-white">
                            <th width="30" class="text-center">#</th>
                            <th width="50" class="text-center">Kode</th>
                            <th>Kategori</th>
                            <th width="100" class="text-center">Kode Internal</th>
                            <th>Produk</th>
                            <th width="100" class="text-center">Tgl. Expired</th>
                            <th class="text-center">Stock</th>
                            <th width="70" class="text-center">Gudang</th>
                            <th width="100" class="text-center">Harga Jual</th>
                            <th class="actions text-center" width="80"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($items) > 0) {
                            foreach ($items as $index => $data) :
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                        ?>
                                <tr>
                                    <td><?php echo (!empty($no) ? $no : '-') ?></td>
                                    <td><strong><?php echo (!empty($data->code) ? $data->code : '-') ?></strong></td>
                                    <td><?= (($data->category_id > 0) ? ((!empty($data->category)) ? $data->category->name : '-') : '-') ?></td>
                                    <td><strong><?php echo (!empty($data->code_internal) ? $data->code_internal : '-') ?></strong></td>
                                    <td><?= $data->name ?></td>
                                    <td class="text-center"><?php echo (($data->expired_date != null) ? $this->Krs->fDate($data->expired_date, 'd-m-Y') : '') ?></td>
                                    <td class="text-center"><strong><?= $this->Krs->_currency($data->stock) . ' ' . $data->unit; ?></strong></td>
                                    <td><span class="badge bg-danger"><?= ($data->warehouse_id > 0) ? $data->warehouse->name : '-' ?></span></td>
                                    <td><i>IDR. <?php echo (!empty($data->selling_price) ? $this->Krs->_currency($data->selling_price) : '-') ?></i></td>
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
    
    <div class="panel-footer">
        <div class="table-toolbar">
            <div class="btn-group">
                <?= $this->Form->create($items, ['type' => 'file', 'url' => ['action' => 'dataExportImport', 'save']]) ?>
                <div class="portlet-body">
                    <div class="note note-yellow"> 
                        <div class="note-icon"><i class="fas fa-upload"></i></div>
                        <div class="note-content text-end">                             
                            <h4><b>Upload Data melalui file Excel...</b></h4>
                            <?php
                            echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
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
$urlGetData = $this->Url->build(['prefix' => 'Master', 'controller' => 'Items', 'action' => 'view', '_full' => true]);
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
        foreach ($items as $rs) {
            echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
        }
        ?>

    });
</script>
