<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Member $member
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Member'), ['action' => 'edit', $member->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Member'), ['action' => 'delete', $member->id], ['confirm' => __('Are you sure you want to delete # {0}?', $member->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Members'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Member'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="members view content">
            <h3><?= h($member->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($member->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($member->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telp') ?></th>
                    <td><?= h($member->telp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hp') ?></th>
                    <td><?= h($member->hp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fax') ?></th>
                    <td><?= h($member->fax) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($member->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Npwp') ?></th>
                    <td><?= h($member->npwp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tax') ?></th>
                    <td><?= h($member->tax) ?></td>
                </tr>
                <tr>
                    <th><?= __('City') ?></th>
                    <td><?= h($member->city) ?></td>
                </tr>
                <tr>
                    <th><?= __('Province') ?></th>
                    <td><?= h($member->province) ?></td>
                </tr>
                <tr>
                    <th><?= __('Country') ?></th>
                    <td><?= h($member->country) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pic') ?></th>
                    <td><?= h($member->pic) ?></td>
                </tr>
                <tr>
                    <th><?= __('Website') ?></th>
                    <td><?= h($member->website) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($member->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($member->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($member->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Points') ?></th>
                    <td><?= $this->Number->format($member->points) ?></td>
                </tr>
                <tr>
                    <th><?= __('Postal') ?></th>
                    <td><?= $this->Number->format($member->postal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($member->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($member->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($member->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Registry') ?></th>
                    <td><?= h($member->date_registry) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Expired') ?></th>
                    <td><?= h($member->date_expired) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($member->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($member->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($member->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Address') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($member->address)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($member->is_log)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Orders') ?></h4>
                <?php if (!empty($member->orders)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Member Id') ?></th>
                            <th><?= __('Table Id') ?></th>
                            <th><?= __('Customer') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Subtotal') ?></th>
                            <th><?= __('Addon') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('Grandtotal') ?></th>
                            <th><?= __('Pay') ?></th>
                            <th><?= __('Diff') ?></th>
                            <th><?= __('Discount') ?></th>
                            <th><?= __('Payment Method') ?></th>
                            <th><?= __('Status Wait') ?></th>
                            <th><?= __('Status Approve') ?></th>
                            <th><?= __('Status Date') ?></th>
                            <th><?= __('Status Desc') ?></th>
                            <th><?= __('Waste Id') ?></th>
                            <th><?= __('Waste Type Id') ?></th>
                            <th><?= __('Processor Id') ?></th>
                            <th><?= __('Unit') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Order') ?></th>
                            <th><?= __('Cashier Id') ?></th>
                            <th><?= __('Date Order') ?></th>
                            <th><?= __('Manifest Id') ?></th>
                            <th><?= __('Date Manifest') ?></th>
                            <th><?= __('Date Estimate Schedule') ?></th>
                            <th><?= __('Permit Id') ?></th>
                            <th><?= __('Date Permit') ?></th>
                            <th><?= __('Sjp Id') ?></th>
                            <th><?= __('Date Sjp') ?></th>
                            <th><?= __('Truck Schedule Id') ?></th>
                            <th><?= __('Truck Schedule Date') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($member->orders as $orders) : ?>
                        <tr>
                            <td><?= h($orders->id) ?></td>
                            <td><?= h($orders->branch_id) ?></td>
                            <td><?= h($orders->customer_id) ?></td>
                            <td><?= h($orders->member_id) ?></td>
                            <td><?= h($orders->table_id) ?></td>
                            <td><?= h($orders->customer) ?></td>
                            <td><?= h($orders->code) ?></td>
                            <td><?= h($orders->number) ?></td>
                            <td><?= h($orders->date) ?></td>
                            <td><?= h($orders->subtotal) ?></td>
                            <td><?= h($orders->addon) ?></td>
                            <td><?= h($orders->tax) ?></td>
                            <td><?= h($orders->grandtotal) ?></td>
                            <td><?= h($orders->pay) ?></td>
                            <td><?= h($orders->diff) ?></td>
                            <td><?= h($orders->discount) ?></td>
                            <td><?= h($orders->payment_method) ?></td>
                            <td><?= h($orders->status_wait) ?></td>
                            <td><?= h($orders->status_approve) ?></td>
                            <td><?= h($orders->status_date) ?></td>
                            <td><?= h($orders->status_desc) ?></td>
                            <td><?= h($orders->waste_id) ?></td>
                            <td><?= h($orders->waste_type_id) ?></td>
                            <td><?= h($orders->processor_id) ?></td>
                            <td><?= h($orders->unit) ?></td>
                            <td><?= h($orders->quantity) ?></td>
                            <td><?= h($orders->order) ?></td>
                            <td><?= h($orders->cashier_id) ?></td>
                            <td><?= h($orders->date_order) ?></td>
                            <td><?= h($orders->manifest_id) ?></td>
                            <td><?= h($orders->date_manifest) ?></td>
                            <td><?= h($orders->date_estimate_schedule) ?></td>
                            <td><?= h($orders->permit_id) ?></td>
                            <td><?= h($orders->date_permit) ?></td>
                            <td><?= h($orders->sjp_id) ?></td>
                            <td><?= h($orders->date_sjp) ?></td>
                            <td><?= h($orders->truck_schedule_id) ?></td>
                            <td><?= h($orders->truck_schedule_date) ?></td>
                            <td><?= h($orders->who_create) ?></td>
                            <td><?= h($orders->created) ?></td>
                            <td><?= h($orders->who_update) ?></td>
                            <td><?= h($orders->modified) ?></td>
                            <td><?= h($orders->active) ?></td>
                            <td><?= h($orders->status) ?></td>
                            <td><?= h($orders->is_create) ?></td>
                            <td><?= h($orders->is_update) ?></td>
                            <td><?= h($orders->is_delete) ?></td>
                            <td><?= h($orders->deleted) ?></td>
                            <td><?= h($orders->is_active) ?></td>
                            <td><?= h($orders->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Orders', 'action' => 'view', $orders->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Orders', 'action' => 'edit', $orders->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Orders', 'action' => 'delete', $orders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orders->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
