<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Letter $letter
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Letter'), ['action' => 'edit', $letter->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Letter'), ['action' => 'delete', $letter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $letter->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Letters'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Letter'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="letters view content">
            <h3><?= h($letter->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $letter->has('branch') ? $this->Html->link($letter->branch->name, ['controller' => 'Branches', 'action' => 'view', $letter->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Number') ?></th>
                    <td><?= h($letter->number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($letter->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Project') ?></th>
                    <td><?= h($letter->project) ?></td>
                </tr>
                <tr>
                    <th><?= __('Coded') ?></th>
                    <td><?= h($letter->coded) ?></td>
                </tr>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= h($letter->branch) ?></td>
                </tr>
                <tr>
                    <th><?= __('Purpose') ?></th>
                    <td><?= h($letter->purpose) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($letter->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($letter->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= h($letter->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($letter->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($letter->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Applicant') ?></th>
                    <td><?= $this->Number->format($letter->applicant) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved') ?></th>
                    <td><?= $this->Number->format($letter->approved) ?></td>
                </tr>
                <tr>
                    <th><?= __('Knowing') ?></th>
                    <td><?= $this->Number->format($letter->knowing) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Ceo') ?></th>
                    <td><?= $this->Number->format($letter->approved_ceo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($letter->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Date') ?></th>
                    <td><?= h($letter->approved_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Ceo Date') ?></th>
                    <td><?= h($letter->approved_ceo_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($letter->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($letter->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($letter->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($letter->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($letter->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
