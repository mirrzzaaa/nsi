<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PettyCashBook $pettyCashBook
 */
$rp = function ($v) {
    return number_format((float) $v, 0, ',', '.');
};
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Menu') ?></h4>
            <?= $this->Html->link(__('Ubah'), ['action' => 'edit', $pettyCashBook->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Buku Kas Kecil'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pettyCashBooks view content">
            <h3><?= h($pettyCashBook->no_kas ?: 'Saldo Awal') ?></h3>
            <table>
                <tr>
                    <th>Tgl Input</th>
                    <td><?= h($pettyCashBook->tgl_input) ?></td>
                </tr>
                <tr>
                    <th>Tgl Trx</th>
                    <td><?= h($pettyCashBook->tgl_trx) ?></td>
                </tr>
                <tr>
                    <th>Uraian</th>
                    <td><?= h($pettyCashBook->uraian) ?></td>
                </tr>
                <tr>
                    <th>Debet</th>
                    <td><?= $rp($pettyCashBook->debet) ?></td>
                </tr>
                <tr>
                    <th>Kredit</th>
                    <td><?= $rp($pettyCashBook->kredit) ?></td>
                </tr>
                <tr>
                    <th>PJ</th>
                    <td><?= h($pettyCashBook->pj) ?></td>
                </tr>
                <tr>
                    <th>PCA</th>
                    <td><?= h($pettyCashBook->pca) ?></td>
                </tr>
                <tr>
                    <th>No Kas</th>
                    <td><?= h($pettyCashBook->no_kas) ?></td>
                </tr>
                <tr>
                    <th>KTGR</th>
                    <td><?= h($pettyCashBook->ktgr) ?></td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td><?= h($pettyCashBook->keterangan) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>