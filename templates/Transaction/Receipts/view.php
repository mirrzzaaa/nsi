<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receipt $receipt
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Receipt'), ['action' => 'edit', $receipt->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Receipt'), ['action' => 'delete', $receipt->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receipt->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Receipts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Receipt'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="receipts view content">
            <h3><?= h($receipt->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $receipt->has('branch') ? $this->Html->link($receipt->branch->name, ['controller' => 'Branches', 'action' => 'view', $receipt->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Invoice') ?></th>
                    <td><?= $receipt->has('invoice') ? $this->Html->link($receipt->invoice->id, ['controller' => 'Invoices', 'action' => 'view', $receipt->invoice->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $receipt->has('customer') ? $this->Html->link($receipt->customer->name, ['controller' => 'Customers', 'action' => 'view', $receipt->customer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Order') ?></th>
                    <td><?= $receipt->has('order') ? $this->Html->link($receipt->order->id, ['controller' => 'Orders', 'action' => 'view', $receipt->order->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($receipt->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($receipt->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Type') ?></th>
                    <td><?= h($receipt->payment_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($receipt->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($receipt->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nominal') ?></th>
                    <td><?= $this->Number->format($receipt->nominal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($receipt->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($receipt->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($receipt->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Print') ?></th>
                    <td><?= $this->Number->format($receipt->is_print) ?></td>
                </tr>
                <tr>
                    <th><?= __('Print') ?></th>
                    <td><?= $this->Number->format($receipt->print) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($receipt->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($receipt->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($receipt->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($receipt->deleted) ?></td>
                </tr>
                <tr>
                    <th><?= __('Print Date') ?></th>
                    <td><?= h($receipt->print_date) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
