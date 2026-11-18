<?php
$rp = function ($v) {
    return number_format((float) $v, 0, ',', '.');
};
$tgl = function ($d) {
    return $d ? $d->format('d/m/Y') : '';
};
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Buku Kas Kecil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
        }

        th {
            background: #e9f3f3;
        }

        td.angka {
            text-align: right;
            white-space: nowrap;
        }

        tr.tebal td {
            font-weight: bold;
            background: #f4f4f4;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <button class="no-print" onclick="window.print()">Cetak / Simpan PDF</button>
    <h3>BUKU KAS KECIL
        <?php if ($dari || $sampai): ?>
            <small>(<?= h($dari ?: '...') ?> s/d <?= h($sampai ?: '...') ?>)</small>
        <?php endif; ?>
    </h3>
    <table>
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
                <th>NO KAS</th>
                <th>KTGR</th>
                <th>KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($dari)): ?>
                <tr class="tebal">
                    <td></td>
                    <td></td>
                    <td>SALDO AWAL</td>
                    <td class="angka"><?= $rp($saldoAwalPeriode) ?></td>
                    <td></td>
                    <td class="angka"><?= $rp($saldoAwalPeriode) ?></td>
                    <td colspan="5"></td>
                </tr>
            <?php endif; ?>
            <?php foreach ($rows as $row): ?>
                <tr class="<?= $row->is_saldo_awal ? 'tebal' : '' ?>">
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
                </tr>
            <?php endforeach; ?>
            <tr class="tebal">
                <td colspan="5" style="text-align:right">SALDO AKHIR</td>
                <td class="angka"><?= $rp($saldoAkhir) ?></td>
                <td colspan="5"></td>
            </tr>
        </tbody>
    </table>
</body>

</html>