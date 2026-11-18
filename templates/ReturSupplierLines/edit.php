<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReturSupplierLine $returSupplierLine
 * @var string[]|\Cake\Collection\CollectionInterface $returSuppliers
 * @var string[]|\Cake\Collection\CollectionInterface $purchasingLines
 * @var string[]|\Cake\Collection\CollectionInterface $warehouseStocks
 * @var string[]|\Cake\Collection\CollectionInterface $branchStocks
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $returSupplierLine->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $returSupplierLine->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Retur Supplier Lines'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="returSupplierLines form content">
            <?= $this->Form->create($returSupplierLine) ?>
            <fieldset>
                <legend><?= __('Edit Retur Supplier Line') ?></legend>
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
