<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PettyCashLine[]|\Cake\Collection\CollectionInterface $pettyCashLines
 */
?>
<div class="pettyCashLines index content">
    <?= $this->Html->link(__('New Petty Cash Line'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Petty Cash Lines') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('petty_cash_id') ?></th>
                    <th><?= $this->Paginator->sort('petty_cash_no') ?></th>
                    <th><?= $this->Paginator->sort('detail_of_request') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('price') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('deleted') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pettyCashLines as $pettyCashLine): ?>
                <tr>
                    <td><?= $this->Number->format($pettyCashLine->id) ?></td>
                    <td><?= $pettyCashLine->has('petty_cash') ? $this->Html->link($pettyCashLine->petty_cash->id, ['controller' => 'PettyCashes', 'action' => 'view', $pettyCashLine->petty_cash->id]) : '' ?></td>
                    <td><?= $this->Number->format($pettyCashLine->petty_cash_no) ?></td>
                    <td><?= h($pettyCashLine->detail_of_request) ?></td>
                    <td><?= $this->Number->format($pettyCashLine->quantity) ?></td>
                    <td><?= $this->Number->format($pettyCashLine->price) ?></td>
                    <td><?= $this->Number->format($pettyCashLine->amount) ?></td>
                    <td><?= h($pettyCashLine->description) ?></td>
                    <td><?= h($pettyCashLine->is_create) ?></td>
                    <td><?= h($pettyCashLine->created) ?></td>
                    <td><?= h($pettyCashLine->is_update) ?></td>
                    <td><?= h($pettyCashLine->modified) ?></td>
                    <td><?= h($pettyCashLine->is_delete) ?></td>
                    <td><?= h($pettyCashLine->deleted) ?></td>
                    <td><?= h($pettyCashLine->is_active) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $pettyCashLine->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pettyCashLine->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pettyCashLine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pettyCashLine->id)]) ?>
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
