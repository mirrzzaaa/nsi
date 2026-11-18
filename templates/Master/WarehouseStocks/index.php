<?php
//pr($warehouseStocks);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */ 
?>
<?= $this->Krs->breadcrumb_('Master', 'Item Gudang', 'Tampilkan') ?>

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
                        <?= $this->Form->control('filtername', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Produk...', 'value' => $this->request->getQuery('filtername')]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('filtersupplier', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Supplier...', 'value' => $this->request->getQuery('filtersupplier')]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('filterwh', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Gudang penempatan...', 'value' => $this->request->getQuery('filterwh')]); ?>
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
                            <th width="30">#</th>
                            <th width="100">Kode Internal</th>
                            <th>Produk</th>
                            <th class="text-center">Tgl. Expired</th>
                            <th class="text-center">Stock</th>
                            <th>Gudang</th>
                            <th>Harga Jual</th>
                            <th class="actions text-center" width="80"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($warehouseStocks) > 0) {
                            foreach ($warehouseStocks as $index => $data) :
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                        ?>
                                <tr>
                                    <td><?php echo (!empty($no) ? $no : '-') ?></td>
                                    <td><strong><?php echo (!empty($data->code) ? $data->code : '-') ?></strong></td>
                                    <td><?= (($data->item_id > 0) ? ((!empty($data->item)) ? $data->item->name : '-') : '-') ?></td>
                                    <td class="text-center"><?php echo (($data->expired_date != null) ? $this->Krs->fDate($data->expired_date, 'd-m-Y') : '') ?></td>
                                    <td class="text-center"><strong><?php echo (!empty($data->stock) ? $this->Krs->_currency($data->stock) : '-') ?></strong></td>
                                    <td><span class="badge bg-danger"><?= ($data->warehouse_id > 0) ? (!empty($data->warehouse) ? $data->warehouse->name : '-') : '-' ?></span></td>
                                    <td><i>IDR. <?php echo (!empty($data->sell) ? $this->Krs->_currency($data->sell) : '-') ?></i></td>
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
$urlGetData = $this->Url->build(['prefix' => 'Master', 'controller' => 'WarehouseStocks', 'action' => 'view', '_full' => true]);
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
        foreach ($warehouseStocks as $rs) {
            echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
        }
        ?>

    });
</script>
