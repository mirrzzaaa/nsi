<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PermitOrderLine $permitOrderLine
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Permit Order Line'), ['action' => 'edit', $permitOrderLine->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Permit Order Line'), ['action' => 'delete', $permitOrderLine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $permitOrderLine->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Permit Order Lines'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Permit Order Line'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="permitOrderLines view content">
            <h3><?= h($permitOrderLine->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Permit') ?></th>
                    <td><?= $permitOrderLine->has('permit') ? $this->Html->link($permitOrderLine->permit->id, ['controller' => 'Permits', 'action' => 'view', $permitOrderLine->permit->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Order Line') ?></th>
                    <td><?= $permitOrderLine->has('order_line') ? $this->Html->link($permitOrderLine->order_line->id, ['controller' => 'OrderLines', 'action' => 'view', $permitOrderLine->order_line->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($permitOrderLine->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
