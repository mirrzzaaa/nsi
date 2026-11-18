<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PermitOrderLine[]|\Cake\Collection\CollectionInterface $permitOrderLines
 */
?>
<div class="permitOrderLines index content">
    <?= $this->Html->link(__('New Permit Order Line'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Permit Order Lines') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('permit_id') ?></th>
                    <th><?= $this->Paginator->sort('order_line_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($permitOrderLines as $permitOrderLine): ?>
                <tr>
                    <td><?= $this->Number->format($permitOrderLine->id) ?></td>
                    <td><?= $permitOrderLine->has('permit') ? $this->Html->link($permitOrderLine->permit->id, ['controller' => 'Permits', 'action' => 'view', $permitOrderLine->permit->id]) : '' ?></td>
                    <td><?= $permitOrderLine->has('order_line') ? $this->Html->link($permitOrderLine->order_line->id, ['controller' => 'OrderLines', 'action' => 'view', $permitOrderLine->order_line->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $permitOrderLine->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $permitOrderLine->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $permitOrderLine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $permitOrderLine->id)]) ?>
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
