<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PettyCash $pettyCash
 * @var \Cake\Collection\CollectionInterface|string[] $branches
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Petty Cashes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pettyCashes form content">
            <?= $this->Form->create($pettyCash) ?>
            <fieldset>
                <legend><?= __('Add Petty Cash') ?></legend>
                <?php
                    echo $this->Form->control('branch_id', ['options' => $branches]);
                    echo $this->Form->control('code_old');
                    echo $this->Form->control('code');
                    echo $this->Form->control('project');
                    echo $this->Form->control('coded');
                    echo $this->Form->control('date', ['empty' => true]);
                    echo $this->Form->control('due_date', ['empty' => true]);
                    echo $this->Form->control('devision');
                    echo $this->Form->control('purpose_of_advancing');
                    echo $this->Form->control('description');
                    echo $this->Form->control('applicant');
                    echo $this->Form->control('approved');
                    echo $this->Form->control('approved_date', ['empty' => true]);
                    echo $this->Form->control('knowing');
                    echo $this->Form->control('approved_acc');
                    echo $this->Form->control('approved_acc_date', ['empty' => true]);
                    echo $this->Form->control('approved_ceo');
                    echo $this->Form->control('approved_ceo_date', ['empty' => true]);
                    echo $this->Form->control('payment');
                    echo $this->Form->control('payment_date', ['empty' => true]);
                    echo $this->Form->control('payment_date_now', ['empty' => true]);
                    echo $this->Form->control('payment_type');
                    echo $this->Form->control('payment_last');
                    echo $this->Form->control('payment_nominal');
                    echo $this->Form->control('payment_desc');
                    echo $this->Form->control('payment_status');
                    echo $this->Form->control('accountability_date', ['empty' => true]);
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('deleted', ['empty' => true]);
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_log');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
