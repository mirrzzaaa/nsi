<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PettyCashBook $pettyCashBook
 */
?>
<ol class="breadcrumb mb-1" style="background:none;padding:0">
    <li class="breadcrumb-item">Keuangan</li>
    <li class="breadcrumb-item"><?= $this->Html->link('Buku Kas Kecil', ['action' => 'index']) ?></li>
    <li class="breadcrumb-item active">Ubah</li>
</ol>
<h1 class="page-header mb-3">Buku Kas Kecil <small>kumpulan data . . .</small></h1>

<?= $this->element('petty_cash_book_form') ?>