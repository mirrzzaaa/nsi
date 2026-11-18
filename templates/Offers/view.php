<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Offer $offer
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Offer'), ['action' => 'edit', $offer->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Offer'), ['action' => 'delete', $offer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $offer->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Offers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Offer'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="offers view content">
            <h3><?= h($offer->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $offer->has('branch') ? $this->Html->link($offer->branch->name, ['controller' => 'Branches', 'action' => 'view', $offer->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Number') ?></th>
                    <td><?= h($offer->number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($offer->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $offer->has('customer') ? $this->Html->link($offer->customer->name, ['controller' => 'Customers', 'action' => 'view', $offer->customer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer Name') ?></th>
                    <td><?= h($offer->customer_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer Address') ?></th>
                    <td><?= h($offer->customer_address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Attn 1') ?></th>
                    <td><?= h($offer->attn_1) ?></td>
                </tr>
                <tr>
                    <th><?= __('Attn 2') ?></th>
                    <td><?= h($offer->attn_2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Perihal') ?></th>
                    <td><?= h($offer->perihal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Info') ?></th>
                    <td><?= h($offer->info) ?></td>
                </tr>
                <tr>
                    <th><?= __('Klasifikasi') ?></th>
                    <td><?= h($offer->klasifikasi) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($offer->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($offer->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($offer->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Active') ?></th>
                    <td><?= h($offer->active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($offer->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($offer->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Kabupaten Id') ?></th>
                    <td><?= $this->Number->format($offer->kabupaten_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Kabupaten Price Trip') ?></th>
                    <td><?= $this->Number->format($offer->kabupaten_price_trip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Print') ?></th>
                    <td><?= $this->Number->format($offer->print) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Marketing') ?></th>
                    <td><?= $this->Number->format($offer->is_marketing) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Approve') ?></th>
                    <td><?= $this->Number->format($offer->is_approve) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Print') ?></th>
                    <td><?= $this->Number->format($offer->is_print) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($offer->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($offer->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approve Date') ?></th>
                    <td><?= h($offer->approve_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Print Date') ?></th>
                    <td><?= h($offer->print_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($offer->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($offer->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($offer->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($offer->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($offer->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
