<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PermitOrderLine $permitOrderLine
 * @var string[]|\Cake\Collection\CollectionInterface $permits
 * @var string[]|\Cake\Collection\CollectionInterface $orderLines
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $permitOrderLine->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $permitOrderLine->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Permit Order Lines'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="permitOrderLines form content">
            <?= $this->Form->create($permitOrderLine) ?>
            <fieldset>
                <legend><?= __('Edit Permit Order Line') ?></legend>
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
