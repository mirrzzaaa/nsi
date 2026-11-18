<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PettyCashBook $pettyCashBook
 */
$this->Form->setTemplates([
    'inputContainer' => '{{content}}',
    'inputContainerError' => '{{content}}{{error}}',
    'error' => '<div class="text-danger small mt-1">{{content}}</div>',
]);
?>
<style>
    .form-kas .form-label {
        font-weight: bold;
    }

    .form-kas .form-control,
    .form-kas .form-select {
        height: 46px;
    }

    .form-kas textarea.form-control {
        height: auto;
    }

    .footer-kuning {
        background: #ffcc00;
        padding: 28px 30px;
        text-align: right;
    }
</style>

<?= $this->Form->create($pettyCashBook, ['class' => 'form-kas']) ?>
<div class="card">
    <div class="card-header bg-dark text-white" style="padding:25px 30px">
        <strong>Perincian</strong>
    </div>

    <div class="card-body" style="padding:30px">
        <div class="row mb-4">
            <div class="col-md-3">
                <label class="form-label">Tgl Input</label>
                <?= $this->Form->control('tgl_input', [
                    'type' => 'date',
                    'label' => false,
                    'class' => 'form-control',
                    'default' => date('Y-m-d'),
                ]) ?>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tgl Transaksi</label>
                <?= $this->Form->control('tgl_trx', [
                    'type' => 'date',
                    'label' => false,
                    'class' => 'form-control',
                    'empty' => true,
                ]) ?>
            </div>
            <div class="col-md-3">
                <label class="form-label">Debet (uang masuk)</label>
                <?= $this->Form->control('debet', [
                    'type' => 'number',
                    'label' => false,
                    'class' => 'form-control',
                    'step' => '0.01',
                    'min' => 0,
                    'default' => 0,
                    'placeholder' => 'Debet..',
                ]) ?>
            </div>
            <div class="col-md-3">
                <label class="form-label">Kredit (uang keluar)</label>
                <?= $this->Form->control('kredit', [
                    'type' => 'number',
                    'label' => false,
                    'class' => 'form-control',
                    'step' => '0.01',
                    'min' => 0,
                    'default' => 0,
                    'placeholder' => 'Kredit..',
                ]) ?>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Uraian Transaksi</label>
            <?= $this->Form->control('uraian', [
                'type' => 'text',
                'label' => false,
                'class' => 'form-control',
                'placeholder' => 'Uraian Transaksi..',
            ]) ?>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label">PJ (Penanggung Jawab)</label>
                <?= $this->Form->control('pj', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'PJ..',
                ]) ?>
            </div>
            <div class="col-md-5">
                <label class="form-label">PCA</label>
                <?= $this->Form->control('pca', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'contoh: 0010/PCA-NSI/I/2026',
                ]) ?>
            </div>
            <div class="col-md-3">
                <label class="form-label">Kategori</label>
                <?= $this->Form->control('ktgr', [
                    'type' => 'select',
                    'label' => false,
                    'class' => 'form-select',
                    'options' => ['NON' => 'NON', 'BHP' => 'BHP'],
                    'empty' => 'KTGR..',
                ]) ?>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Keterangan</label>
            <?= $this->Form->control('keterangan', [
                'type' => 'textarea',
                'label' => false,
                'class' => 'form-control',
                'rows' => 5,
                'placeholder' => 'Keterangan',
            ]) ?>
        </div>

        <div class="form-check">
            <?= $this->Form->checkbox('is_saldo_awal', ['class' => 'form-check-input', 'id' => 'is-saldo-awal']) ?>
            <label class="form-check-label" for="is-saldo-awal">
                Ini baris Saldo Awal (tanpa No Kas)
            </label>
        </div>
    </div>

    <div class="footer-kuning">
        <?php if (!$pettyCashBook->isNew()): ?>
            <?= $this->Form->postLink(
                'Hapus',
                ['action' => 'delete', $pettyCashBook->id],
                [
                    'class' => 'btn btn-danger btn-lg me-2',
                    'confirm' => __('Yakin hapus transaksi ini?'),
                    'block' => true,
                ]
            ) ?>
        <?php endif; ?>
        <?= $this->Html->link('Batal', ['action' => 'index'], ['class' => 'btn btn-dark btn-lg me-2']) ?>
        <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
    </div>
</div>
<?= $this->Form->end() ?>
<?= $this->fetch('postLink') ?>