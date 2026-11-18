<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PettyCashLine $pettyCashLine
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Petty Cash Line'), ['action' => 'edit', $pettyCashLine->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Petty Cash Line'), ['action' => 'delete', $pettyCashLine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pettyCashLine->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Petty Cash Lines'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Petty Cash Line'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pettyCashLines view content">
            <h3><?= h($pettyCashLine->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Petty Cash') ?></th>
                    <td><?= $pettyCashLine->has('petty_cash') ? $this->Html->link($pettyCashLine->petty_cash->id, ['controller' => 'PettyCashes', 'action' => 'view', $pettyCashLine->petty_cash->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Detail Of Request') ?></th>
                    <td><?= h($pettyCashLine->detail_of_request) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($pettyCashLine->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($pettyCashLine->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($pettyCashLine->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= h($pettyCashLine->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($pettyCashLine->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($pettyCashLine->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Petty Cash No') ?></th>
                    <td><?= $this->Number->format($pettyCashLine->petty_cash_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($pettyCashLine->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $this->Number->format($pettyCashLine->price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($pettyCashLine->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($pettyCashLine->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($pettyCashLine->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($pettyCashLine->deleted) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
