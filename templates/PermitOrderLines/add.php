<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PermitOrderLine $permitOrderLine
 * @var \Cake\Collection\CollectionInterface|string[] $permits
 * @var \Cake\Collection\CollectionInterface|string[] $orderLines
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Permit Order Lines'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="permitOrderLines form content">
            <?= $this->Form->create($permitOrderLine) ?>
            <fieldset>
                <legend><?= __('Add Permit Order Line') ?></legend>
                <?php
                    echo $this->Form->control('permit_id', ['options' => $permits]);
                    echo $this->Form->control('order_line_id', ['options' => $orderLines]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
