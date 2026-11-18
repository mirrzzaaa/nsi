<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PettyCashLine $pettyCashLine
 * @var \Cake\Collection\CollectionInterface|string[] $pettyCashes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Petty Cash Lines'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pettyCashLines form content">
            <?= $this->Form->create($pettyCashLine) ?>
            <fieldset>
                <legend><?= __('Add Petty Cash Line') ?></legend>
                <?php
                    echo $this->Form->control('petty_cash_id', ['options' => $pettyCashes]);
                    echo $this->Form->control('petty_cash_no');
                    echo $this->Form->control('detail_of_request');
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('price');
                    echo $this->Form->control('amount');
                    echo $this->Form->control('description');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('deleted', ['empty' => true]);
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
