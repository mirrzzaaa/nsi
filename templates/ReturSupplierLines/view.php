<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReturSupplierLine $returSupplierLine
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Retur Supplier Line'), ['action' => 'edit', $returSupplierLine->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Retur Supplier Line'), ['action' => 'delete', $returSupplierLine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $returSupplierLine->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Retur Supplier Lines'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Retur Supplier Line'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="returSupplierLines view content">
            <h3><?= h($returSupplierLine->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Retur Supplier') ?></th>
                    <td><?= $returSupplierLine->has('retur_supplier') ? $this->Html->link($returSupplierLine->retur_supplier->id, ['controller' => 'ReturSuppliers', 'action' => 'view', $returSupplierLine->retur_supplier->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Purchasing Line') ?></th>
                    <td><?= $returSupplierLine->has('purchasing_line') ? $this->Html->link($returSupplierLine->purchasing_line->id, ['controller' => 'PurchasingLines', 'action' => 'view', $returSupplierLine->purchasing_line->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Warehouse Stock') ?></th>
                    <td><?= $returSupplierLine->has('warehouse_stock') ? $this->Html->link($returSupplierLine->warehouse_stock->id, ['controller' => 'WarehouseStocks', 'action' => 'view', $returSupplierLine->warehouse_stock->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Branch Stock') ?></th>
                    <td><?= $returSupplierLine->has('branch_stock') ? $this->Html->link($returSupplierLine->branch_stock->id, ['controller' => 'BranchStocks', 'action' => 'view', $returSupplierLine->branch_stock->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Reason') ?></th>
                    <td><?= h($returSupplierLine->reason) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($returSupplierLine->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($returSupplierLine->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nominal') ?></th>
                    <td><?= $this->Number->format($returSupplierLine->nominal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($returSupplierLine->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($returSupplierLine->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($returSupplierLine->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($returSupplierLine->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
