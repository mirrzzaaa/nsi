<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PettyCash $pettyCash
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Petty Cash'), ['action' => 'edit', $pettyCash->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Petty Cash'), ['action' => 'delete', $pettyCash->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pettyCash->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Petty Cashes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Petty Cash'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pettyCashes view content">
            <h3><?= h($pettyCash->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $pettyCash->has('branch') ? $this->Html->link($pettyCash->branch->name, ['controller' => 'Branches', 'action' => 'view', $pettyCash->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($pettyCash->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Coded') ?></th>
                    <td><?= h($pettyCash->coded) ?></td>
                </tr>
                <tr>
                    <th><?= __('Devision') ?></th>
                    <td><?= h($pettyCash->devision) ?></td>
                </tr>
                <tr>
                    <th><?= __('Purpose Of Advancing') ?></th>
                    <td><?= h($pettyCash->purpose_of_advancing) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Type') ?></th>
                    <td><?= h($pettyCash->payment_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Desc') ?></th>
                    <td><?= h($pettyCash->payment_desc) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Status') ?></th>
                    <td><?= h($pettyCash->payment_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($pettyCash->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($pettyCash->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= h($pettyCash->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($pettyCash->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($pettyCash->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Applicant') ?></th>
                    <td><?= $this->Number->format($pettyCash->applicant) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved') ?></th>
                    <td><?= $this->Number->format($pettyCash->approved) ?></td>
                </tr>
                <tr>
                    <th><?= __('Knowing') ?></th>
                    <td><?= $this->Number->format($pettyCash->knowing) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Ceo') ?></th>
                    <td><?= $this->Number->format($pettyCash->approved_ceo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment') ?></th>
                    <td><?= $this->Number->format($pettyCash->payment) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Last') ?></th>
                    <td><?= $this->Number->format($pettyCash->payment_last) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Nominal') ?></th>
                    <td><?= $this->Number->format($pettyCash->payment_nominal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($pettyCash->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Due Date') ?></th>
                    <td><?= h($pettyCash->due_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Date') ?></th>
                    <td><?= h($pettyCash->approved_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Ceo Date') ?></th>
                    <td><?= h($pettyCash->approved_ceo_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Date') ?></th>
                    <td><?= h($pettyCash->payment_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Date Now') ?></th>
                    <td><?= h($pettyCash->payment_date_now) ?></td>
                </tr>
                <tr>
                    <th><?= __('Accountability Date') ?></th>
                    <td><?= h($pettyCash->accountability_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($pettyCash->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($pettyCash->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($pettyCash->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($pettyCash->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($pettyCash->is_log)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Petty Cash Lines') ?></h4>
                <?php if (!empty($pettyCash->petty_cash_lines)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Petty Cash Id') ?></th>
                            <th><?= __('Petty Cash No') ?></th>
                            <th><?= __('Detail Of Request') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($pettyCash->petty_cash_lines as $pettyCashLines) : ?>
                        <tr>
                            <td><?= h($pettyCashLines->id) ?></td>
                            <td><?= h($pettyCashLines->petty_cash_id) ?></td>
                            <td><?= h($pettyCashLines->petty_cash_no) ?></td>
                            <td><?= h($pettyCashLines->detail_of_request) ?></td>
                            <td><?= h($pettyCashLines->quantity) ?></td>
                            <td><?= h($pettyCashLines->price) ?></td>
                            <td><?= h($pettyCashLines->amount) ?></td>
                            <td><?= h($pettyCashLines->description) ?></td>
                            <td><?= h($pettyCashLines->is_create) ?></td>
                            <td><?= h($pettyCashLines->created) ?></td>
                            <td><?= h($pettyCashLines->is_update) ?></td>
                            <td><?= h($pettyCashLines->modified) ?></td>
                            <td><?= h($pettyCashLines->is_delete) ?></td>
                            <td><?= h($pettyCashLines->deleted) ?></td>
                            <td><?= h($pettyCashLines->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PettyCashLines', 'action' => 'view', $pettyCashLines->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PettyCashLines', 'action' => 'edit', $pettyCashLines->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PettyCashLines', 'action' => 'delete', $pettyCashLines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pettyCashLines->id)]) ?>
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
