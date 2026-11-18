<?php
ini_set('precision', 14);
//pr($report);

$subtotals = array();
    foreach ($report->purchasing->purchasing_lines as $index => $value) {
        $subtotals[$index] = is_numeric($value->subtotal) ? $value->subtotal : 0;
    }
    $subtotalSum = array_sum($subtotals);
    $ppn = (is_numeric($report->ppn) && $report->ppn > 0) ? ((11 * $subtotalSum) / 100) : 0;
    //pr($ppn);
$purchasings = $report->purchasing; 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>invoice masuk</title>
    <style>
        @page {
            size: 210mm 297mm potrait;
            margin: 0cm 0cm 0cm 0cm !important;
        }

        body {
            padding-top: 120px;
            padding-bottom: 120px;
        }

        .fixed-header,
        .fixed-footer {
            width: 100%;
            position: fixed;
        }

        .fixed-header {
            top: 0;
        }

        .fixed-footer {
            bottom: 0;
        }

        .container {
            width: 100%;
            padding: 0px 15px 15px 15px;
            /* Center the DIV horizontally */
        }

        p {
            line-height: 1.5;
            font-size: 9;
            font-family: Arial, Helvetica, sans-serif;
            /* padding-left: 15px; */
            /* padding-right: 50px; */
        }

        span {
            line-height: 1.5;
            font-size: 9;
            font-family: Arial, Helvetica, sans-serif;
            /* padding-left: 15px; */
            /* padding-right: 50px; */
        }

        table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 9;
            /* padding-left: 15px;
            padding-right: 15px;
            padding-top: 15px;
            padding-bottom: 15px; */
        }

        thead {
            background-color: #dddddd;
        }

        th {
            border: 1.5px solid #000;
            text-align: center;
            padding: 2px;
            font-size: 9;
        }

        td {
            padding: 4px;
            font-size: 9;

        }

        tr:last-child {
            page-break-after: never;
        }
    </style>
</head>

<body style="">
    <div class="fixed-header">
        <img src="<?php
                    echo WWW_ROOT ?>img/logo/header.png" width="100%" alt="" style="">
    </div>
    <div class="fixed-footer">
        <img src="<?php
                    echo WWW_ROOT ?>img/logo/footer.png" width="100%" alt="">
    </div>
    <main>
        <div class="container">
            <div style="text-align: right; padding-right: 50px;">
                <span><strong>Gresik, <?= date('d') . ' ' . $this->Krs->getMonth(date('n')) . ' ' . date('Y'); ?></strong></span>
            </div>

            <h2 style="color: #000000; text-align: center;">INVOICE MASUK</h2>
            <br>
            <table>
                <tbody>
                    <tr>
                        <td width="25%">&nbsp;</td>
                        <td width="25%" style="border-left: 1 solid #000;border-top: 1 solid #000;">Nomor</td>
                        <td width="25%" style="text-align: right;border-right: 1 solid #000;border-top: 1 solid #000;"><?= $report->code ?></td>
                        <td width="25%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="25%">&nbsp;</td>
                        <td width="25%" style="border-left: 1 solid #000;">Tanggal</td>
                        <td width="25%" style="text-align: right;border-right: 1 solid #000;"><?= ($report->date !== null ? date_format($report->date, 'd-m-Y') : '') ?></td>
                        <td width="25%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="25%">&nbsp;</td>
                        <td width="25%" style="border-left: 1 solid #000;border-bottom: 1 solid #000;">Jatuh Tempo</td>
                        <td width="25%" style="text-align: right;border-right: 1 solid #000;border-bottom: 1 solid #000;"><?= ($report->due_date !== null ? date_format($report->due_date, 'd-m-Y') : '') ?></td>
                        <td width="25%">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
            <div style="padding-left: 25px;padding-right: 50px;">
                <p>Telah terima produk dari <b><?= $report->purchasing->supplier->name ?></b> sebagai berikut :</p>
                <table>
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Disc</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $subtotals = array();
                        foreach ($report->purchasing->purchasing_lines as $index => $rowOrder) {
                            $subtotals[$index] = $rowOrder->subtotal;
                        ?>
                            <tr>
                                <td style="text-align: center; border: 1 solid #000;"><?= $no; ?></td>
                                <td style=" border: 1 solid #000;"><?= (!empty($rowOrder->item) ? $rowOrder->item->name : '') ?></td>
                                <td style="text-align: center;  border: 1 solid #000;"><?= $this->Krs->_currency($rowOrder->quantity) . ' ' . (!empty($rowOrder->item) ? $rowOrder->item->unit : ''); ?></td>
                                <td style="text-align: right;  border: 1 solid #000;"><?= $this->Krs->_currency($rowOrder->price); ?></td>
                                <td style="text-align: right;  border: 1 solid #000;"><?= $this->Krs->_currency($rowOrder->discount); ?> %</td>
                                <td style="text-align: right;  border: 1 solid #000;"><?= $this->Krs->_currency($rowOrder->subtotal); ?></td>
                            </tr>
                        <?php
                            $no++;
                        }
                        // $ppn = $report->purchasing->ppn;
                        // $gTotal = $report->purchasing->grandtotal;
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4">&nbsp;</td>
                            <td colspan="1">Subtotal</td>
                            <td style="text-align: right;"><?= $this->Krs->_currency(array_sum($subtotals)); ?></td>
                        </tr>
                        <?php
                        if ($report->purchasing->ship_payment > 0) { ?>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                                <td colspan="1">Biaya Pengiriman</td>
                                <td style="text-align: right;"><?= $this->Krs->_currency($report->purchasing->ship_payment); ?></td>
                            </tr>
                        <?php
                        }
                        ?>

                        <?php
                        if ($report->purchasing->discount > 0) { ?>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                                <td colspan="1">Disc</td>
                                <td style="text-align: right;"><?= $this->Krs->_currency($report->purchasing->discount); ?> %</td>
                            </tr>
                        <?php
                        }
                        ?>

                        <?php
                        if ($ppn > 0) { ?>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                                <td colspan="1">PPN (12%)</td>
                                <td style="text-align: right;"><?= $this->Krs->_currency($ppn); ?></td>
                            </tr>
                        <?php
                        }
                        ?>

                        <tr>
                            <td colspan="4">&nbsp;</td>
                            <td colspan="1"><strong><u>TOTAL</u></strong></td>
                            <td style="text-align: right;"><strong><u><?= $this->Krs->_currency($purchasings->grandtotal); ?></u></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </main>

</body>

</html>
