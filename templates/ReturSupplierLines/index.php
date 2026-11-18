<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReturSupplierLine[]|\Cake\Collection\CollectionInterface $returSupplierLines
 */
?>
<div class="returSupplierLines index content">
    <?= $this->Html->link(__('New Retur Supplier Line'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Retur Supplier Lines') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('retur_supplier_id') ?></th>
                    <th><?= $this->Paginator->sort('purchasing_lines_id') ?></th>
                    <th><?= $this->Paginator->sort('warehouse_stock_id') ?></th>
                    <th><?= $this->Paginator->sort('branch_stock_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('nominal') ?></th>
                    <th><?= $this->Paginator->sort('reason') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($returSupplierLines as $returSupplierLine): ?>
                <tr>
                    <td><?= $this->Number->format($returSupplierLine->id) ?></td>
                    <td><?= $returSupplierLine->has('retur_supplier') ? $this->Html->link($returSupplierLine->retur_supplier->id, ['controller' => 'ReturSuppliers', 'action' => 'view', $returSupplierLine->retur_supplier->id]) : '' ?></td>
                    <td><?= $returSupplierLine->has('purchasing_line') ? $this->Html->link($returSupplierLine->purchasing_line->id, ['controller' => 'PurchasingLines', 'action' => 'view', $returSupplierLine->purchasing_line->id]) : '' ?></td>
                    <td><?= $returSupplierLine->has('warehouse_stock') ? $this->Html->link($returSupplierLine->warehouse_stock->id, ['controller' => 'WarehouseStocks', 'action' => 'view', $returSupplierLine->warehouse_stock->id]) : '' ?></td>
                    <td><?= $returSupplierLine->has('branch_stock') ? $this->Html->link($returSupplierLine->branch_stock->id, ['controller' => 'BranchStocks', 'action' => 'view', $returSupplierLine->branch_stock->id]) : '' ?></td>
                    <td><?= $this->Number->format($returSupplierLine->quantity) ?></td>
                    <td><?= $this->Number->format($returSupplierLine->nominal) ?></td>
                    <td><?= h($returSupplierLine->reason) ?></td>
                    <td><?= $this->Number->format($returSupplierLine->is_create) ?></td>
                    <td><?= $this->Number->format($returSupplierLine->is_update) ?></td>
                    <td><?= h($returSupplierLine->created) ?></td>
                    <td><?= h($returSupplierLine->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $returSupplierLine->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $returSupplierLine->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $returSupplierLine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $returSupplierLine->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
