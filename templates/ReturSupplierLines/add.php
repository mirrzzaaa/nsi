<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReturSupplierLine $returSupplierLine
 * @var \Cake\Collection\CollectionInterface|string[] $returSuppliers
 * @var \Cake\Collection\CollectionInterface|string[] $purchasingLines
 * @var \Cake\Collection\CollectionInterface|string[] $warehouseStocks
 * @var \Cake\Collection\CollectionInterface|string[] $branchStocks
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Retur Supplier Lines'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="returSupplierLines form content">
            <?= $this->Form->create($returSupplierLine) ?>
            <fieldset>
                <legend><?= __('Add Retur Supplier Line') ?></legend>
                <?php
                    echo $this->Form->control('retur_supplier_id', ['options' => $returSuppliers]);
                    echo $this->Form->control('purchasing_lines_id', ['options' => $purchasingLines]);
                    echo $this->Form->control('warehouse_stock_id', ['options' => $warehouseStocks]);
                    echo $this->Form->control('branch_stock_id', ['options' => $branchStocks]);
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('nominal');
                    echo $this->Form->control('reason');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
