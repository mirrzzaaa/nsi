<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $user->has('branch') ? $this->Html->link($user->branch->name, ['controller' => 'Branches', 'action' => 'view', $user->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($user->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Staff') ?></th>
                    <td><?= h($user->staff) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($user->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Password') ?></th>
                    <td><?= h($user->password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pass New') ?></th>
                    <td><?= h($user->pass_new) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telp') ?></th>
                    <td><?= h($user->telp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Devision') ?></th>
                    <td><?= h($user->devision) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pettycash Devision') ?></th>
                    <td><?= h($user->pettycash_devision) ?></td>
                </tr>
                <tr>
                    <th><?= __('Position') ?></th>
                    <td><?= h($user->position) ?></td>
                </tr>
                <tr>
                    <th><?= __('Marketing Code') ?></th>
                    <td><?= h($user->marketing_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved') ?></th>
                    <td><?= h($user->approved) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Acc') ?></th>
                    <td><?= h($user->approved_acc) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Ceo') ?></th>
                    <td><?= h($user->approved_ceo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment') ?></th>
                    <td><?= h($user->payment) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pettycash Full Access') ?></th>
                    <td><?= h($user->pettycash_full_access) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hris Approved') ?></th>
                    <td><?= h($user->hris_approved) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hris Knowing') ?></th>
                    <td><?= h($user->hris_knowing) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hris Full Access') ?></th>
                    <td><?= h($user->hris_full_access) ?></td>
                </tr>
                <tr>
                    <th><?= __('Jurnal Type Acc') ?></th>
                    <td><?= h($user->jurnal_type_acc) ?></td>
                </tr>
                <tr>
                    <th><?= __('Change Password') ?></th>
                    <td><?= h($user->change_password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($user->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($user->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= h($user->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($user->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Who Create') ?></th>
                    <td><?= h($user->who_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Who Update') ?></th>
                    <td><?= h($user->who_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($user->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Level') ?></th>
                    <td><?= h($user->level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Driver Id') ?></th>
                    <td><?= $this->Number->format($user->driver_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Reset') ?></th>
                    <td><?= $this->Number->format($user->reset) ?></td>
                </tr>
                <tr>
                    <th><?= __('Visited') ?></th>
                    <td><?= $this->Number->format($user->visited) ?></td>
                </tr>
                <tr>
                    <th><?= __('Change Password Date') ?></th>
                    <td><?= h($user->change_password_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Reset Date') ?></th>
                    <td><?= h($user->reset_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($user->deleted) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($user->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Login') ?></th>
                    <td><?= h($user->last_login) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Rule') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($user->rule)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Rules') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($user->rules)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Rule Acc') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($user->rule_acc)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($user->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
