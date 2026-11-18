<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PettyCash[]|\Cake\Collection\CollectionInterface $pettyCashes
 */
?>
<div class="pettyCashes index content">
    <?= $this->Html->link(__('New Petty Cash'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Petty Cashes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('branch_id') ?></th>
                    <th><?= $this->Paginator->sort('code_old') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('project') ?></th>
                    <th><?= $this->Paginator->sort('coded') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('due_date') ?></th>
                    <th><?= $this->Paginator->sort('devision') ?></th>
                    <th><?= $this->Paginator->sort('purpose_of_advancing') ?></th>
                    <th><?= $this->Paginator->sort('applicant') ?></th>
                    <th><?= $this->Paginator->sort('approved') ?></th>
                    <th><?= $this->Paginator->sort('approved_date') ?></th>
                    <th><?= $this->Paginator->sort('knowing') ?></th>
                    <th><?= $this->Paginator->sort('approved_acc') ?></th>
                    <th><?= $this->Paginator->sort('approved_acc_date') ?></th>
                    <th><?= $this->Paginator->sort('approved_ceo') ?></th>
                    <th><?= $this->Paginator->sort('approved_ceo_date') ?></th>
                    <th><?= $this->Paginator->sort('payment') ?></th>
                    <th><?= $this->Paginator->sort('payment_date') ?></th>
                    <th><?= $this->Paginator->sort('payment_date_now') ?></th>
                    <th><?= $this->Paginator->sort('payment_type') ?></th>
                    <th><?= $this->Paginator->sort('payment_last') ?></th>
                    <th><?= $this->Paginator->sort('payment_nominal') ?></th>
                    <th><?= $this->Paginator->sort('payment_desc') ?></th>
                    <th><?= $this->Paginator->sort('payment_status') ?></th>
                    <th><?= $this->Paginator->sort('accountability_date') ?></th>
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
                <?php foreach ($pettyCashes as $pettyCash): ?>
                <tr>
                    <td><?= $this->Number->format($pettyCash->id) ?></td>
                    <td><?= $pettyCash->has('branch') ? $this->Html->link($pettyCash->branch->name, ['controller' => 'Branches', 'action' => 'view', $pettyCash->branch->id]) : '' ?></td>
                    <td><?= h($pettyCash->code_old) ?></td>
                    <td><?= h($pettyCash->code) ?></td>
                    <td><?= h($pettyCash->project) ?></td>
                    <td><?= h($pettyCash->coded) ?></td>
                    <td><?= h($pettyCash->date) ?></td>
                    <td><?= h($pettyCash->due_date) ?></td>
                    <td><?= h($pettyCash->devision) ?></td>
                    <td><?= h($pettyCash->purpose_of_advancing) ?></td>
                    <td><?= $this->Number->format($pettyCash->applicant) ?></td>
                    <td><?= $this->Number->format($pettyCash->approved) ?></td>
                    <td><?= h($pettyCash->approved_date) ?></td>
                    <td><?= $this->Number->format($pettyCash->knowing) ?></td>
                    <td><?= $this->Number->format($pettyCash->approved_acc) ?></td>
                    <td><?= h($pettyCash->approved_acc_date) ?></td>
                    <td><?= $this->Number->format($pettyCash->approved_ceo) ?></td>
                    <td><?= h($pettyCash->approved_ceo_date) ?></td>
                    <td><?= $this->Number->format($pettyCash->payment) ?></td>
                    <td><?= h($pettyCash->payment_date) ?></td>
                    <td><?= h($pettyCash->payment_date_now) ?></td>
                    <td><?= h($pettyCash->payment_type) ?></td>
                    <td><?= $this->Number->format($pettyCash->payment_last) ?></td>
                    <td><?= $this->Number->format($pettyCash->payment_nominal) ?></td>
                    <td><?= h($pettyCash->payment_desc) ?></td>
                    <td><?= h($pettyCash->payment_status) ?></td>
                    <td><?= h($pettyCash->accountability_date) ?></td>
                    <td><?= h($pettyCash->is_create) ?></td>
                    <td><?= h($pettyCash->created) ?></td>
                    <td><?= h($pettyCash->is_update) ?></td>
                    <td><?= h($pettyCash->modified) ?></td>
                    <td><?= h($pettyCash->is_delete) ?></td>
                    <td><?= h($pettyCash->deleted) ?></td>
                    <td><?= h($pettyCash->is_active) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $pettyCash->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pettyCash->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pettyCash->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pettyCash->id)]) ?>
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
