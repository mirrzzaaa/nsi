<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PettyCashBook[] $rows
 * @var float $saldoAwalPeriode
 * @var float $saldoAkhir
 * @var string|null $dari
 * @var string|null $sampai
 */
$rp = function ($v) {
    return number_format((float) $v, 0, ',', '.');
};
$tgl = function ($d) {
    return $d ? $d->format('d-m-Y') : '';
};
$jumlah = count($rows);
?>
<style>
    .tabel-kas thead th {
        background: #343a40;
        color: #fff;
        text-align: center;
        vertical-align: middle;
        border-color: #4a5158;
    }

    .tabel-kas td {
        vertical-align: top;
    }

    .tabel-kas td.angka {
        text-align: right;
        white-space: nowrap;
    }

    .tabel-kas tr.baris-saldo td {
        background: #f1f1f1;
        font-weight: bold;
    }

    .tabel-kas tr.baris-hijau td {
        background: #dcf5e1;
    }

    .filter-bar {
        background: #5bc0fa;
        padding: 30px;
        margin: 20px 0;
    }

    .filter-bar .form-control {
        height: 46px;
    }

    .filter-bar .btn {
        height: 46px;
    }
</style>

<ol class="breadcrumb mb-1" style="background:none;padding:0">
    <li class="breadcrumb-item">Keuangan</li>
    <li class="breadcrumb-item active">Buku Kas Kecil</li>
</ol>
<h1 class="page-header mb-3">Buku Kas Kecil <small>kumpulan data . . .</small></h1>

<div class="card">
    <div class="card-body">

        <div class="mb-3">
            <?= $this->Html->link(
                '<i class="fa fa-plus-square"></i>',
                ['action' => 'add'],
                ['class' => 'btn btn-dark btn-lg', 'escape' => false, 'title' => 'Tambah Transaksi']
            ) ?>
            <?= $this->Html->link(
                '<i class="fa fa-download"></i>',
                ['action' => 'cetak', '?' => ['dari' => $dari, 'sampai' => $sampai]],
                ['class' => 'btn btn-success btn-lg', 'escape' => false, 'target' => '_blank', 'title' => 'Cetak']
            ) ?>
        </div>

        <form method="get" action="<?= $this->Url->build(['action' => 'index']) ?>">
            <div class="filter-bar">
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="date" name="dari" class="form-control" placeholder="Tgl Input.."
                                value="<?= h($dari) ?>">
                            <span class="input-group-text">s/d</span>
                            <input type="date" name="sampai" class="form-control" placeholder="Tgl Input.."
                                value="<?= h($sampai) ?>">
                            <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-dark"
                                title="Reset">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-warning" title="Cari"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered tabel-kas">
                <thead>
                    <tr>
                        <th>Tgl Input</th>
                        <th>Tgl Trx.</th>
                        <th>Uraian Trx.</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Total</th>
                        <th>PJ</th>
                        <th>PCA</th>
                        <th>No Kas</th>
                        <th>KTGR</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dari)): ?>
                        <tr class="baris-saldo">
                            <td></td>
                            <td></td>
                            <td>SALDO AWAL</td>
                            <td class="angka"><?= $rp($saldoAwalPeriode) ?></td>
                            <td></td>
                            <td class="angka"><?= $rp($saldoAwalPeriode) ?></td>
                            <td colspan="6"></td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($rows as $row): ?>
                        <tr class="<?= $row->is_saldo_awal ? 'baris-saldo' : '' ?>">
                            <td><?= $tgl($row->tgl_input) ?></td>
                            <td><?= $tgl($row->tgl_trx) ?></td>
                            <td><?= h($row->uraian) ?></td>
                            <td class="angka"><?= (float) $row->debet > 0 ? $rp($row->debet) : '' ?></td>
                            <td class="angka"><?= (float) $row->kredit > 0 ? $rp($row->kredit) : '' ?></td>
                            <td class="angka"><strong><?= $rp($row->total) ?></strong></td>
                            <td><?= h($row->pj) ?></td>
                            <td><?= h($row->pca) ?></td>
                            <td><?= h($row->no_kas) ?></td>
                            <td><?= h($row->ktgr) ?></td>
                            <td><?= h($row->keterangan) ?></td>
                            <td style="white-space:nowrap">
                                <?= $this->Html->link('<i class="fa fa-pencil-alt"></i>', ['action' => 'edit', $row->id], ['class' => 'btn btn-info btn-sm', 'escape' => false, 'title' => 'Ubah']) ?>
                                <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['action' => 'delete', $row->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'title' => 'Hapus', 'confirm' => __('Yakin hapus transaksi ini?')]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if ($jumlah === 0): ?>
                        <tr>
                            <td colspan="12" class="text-center">Belum ada data.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="baris-saldo">
                        <td colspan="5" class="text-end">SALDO AKHIR</td>
                        <td class="angka"><?= $rp($saldoAkhir) ?></td>
                        <td colspan="6"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <p class="mt-3 mb-0">Menampilkan <?= $jumlah ?> baris dengan jumlah total <?= $jumlah ?> baris</p>
    </div>
</div>