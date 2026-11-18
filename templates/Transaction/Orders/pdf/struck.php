<!DOCTYPE html>
<html lang="ar">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Express Wash Customer Invoice</title>
    <style>
        @page {
            margin: 0;
            /* size: 58mm 210mm; */
        }

        body {
            margin: 0;
            font-size: 10px;
            font-family: sans-serif;
        }

        td {
            font-size: 10px;
        }

        .sheet {
            margin: 0;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
            page-break-after: always;
        }

        /** Paper sizes **/
        body.struk .sheet {
            width: 58mm;
        }

        body.struk .sheet {
            /* padding: 2mm; */
        }

        .txt-left {
            text-align: left;
        }

        .txt-center {
            text-align: center;
        }

        .txt-right {
            text-align: right;
        }

        /** For screen preview **/
        @media screen {
            body {
                /* background: #e0e0e0; */
                font-family: sans-serif;
            }

            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3);
                margin: 5mm;
            }
        }

        /** Fix for Chrome issue #273306 **/
        @media print {
            body {
                font-family: sans-serif;
            }

            body.struk {
                width: 58mm;
                text-align: left;
            }

            body.struk .sheet {
                padding: 2mm;
            }

            .txt-left {
                text-align: left;
            }

            .txt-center {
                text-align: center;
            }

            .txt-right {
                text-align: right;
            }
        }
    </style>
</head>

<body class="struk" onload="printOut()">
    <section class="sheet">
        <table cellpadding="0" cellspacing="0" style="width:100%">
            <tr>
                <td align="left" class="txt-left">
                    <h2>RetailPOS</h2>
                </td>
            </tr>
            <tr>
                <td align="left" class="txt-left">Jl. Merdeka, No. 17, Kec. Sooko, Kota Mojokerto</td>
            </tr>
            <tr>
                <td align="left" class="txt-left">Telp : 085782999002</td>
            </tr>
        </table>
        <?php
        echo (str_repeat("=", 32) . "<br/>");
        $invoice = $report->code;
        $kasir = $report->user->code;
        $tgl = date_format($report->created, 'd-m-Y H:i:s');
        ?>

        <table cellpadding="0" cellspacing="0" style="width:100%">
            <tr>
                <td align="left" class="txt-left">Nota&nbsp;</td>
                <td align="left" class="txt-left">:</td>
                <td align="left" class="txt-left">&nbsp; <?= $invoice ?></td>
            </tr>
            <tr>
                <td align="left" class="txt-left">Kasir</td>
                <td align="left" class="txt-left">:</td>
                <td align="left" class="txt-left">&nbsp; <?= $kasir ?></td>
            </tr>
            <tr>
                <td align="left" class="txt-left">Tgl</td>
                <td align="left" class="txt-left">:</td>
                <td align="left" class="txt-left">&nbsp; <?= $tgl ?></td>
            </tr>
        </table>
        <br>

        <?php
        $tItem = 'Item' . str_repeat("&nbsp;", (13 - strlen('Item')));
        $tQty  = 'Qty' . str_repeat("&nbsp;", (6 - strlen('Qty')));
        $tHarga = str_repeat("&nbsp;", (9 - strlen('Harga'))) . 'Harga';
        $tTotal = str_repeat("&nbsp;", (10 - strlen('Total'))) . 'Total';
        $caption = $tItem . $tQty . $tHarga . $tTotal;

        // subtotal
        $titleST = 'Subtotal';
        $titleST = $titleST . str_repeat("&nbsp;", (23 - strlen($titleST)));
        $ST      = $this->Krs->_currency($report->subtotal);
        $ST      = str_repeat("&nbsp;", (23 - strlen($ST))) . $ST;

        // discount
        $titleDisc = 'Discount';
        $titleDisc = $titleDisc . str_repeat("&nbsp;", (23 - strlen($titleDisc)));
        $DC      = $this->Krs->_currency($report->discount);
        $DC      = str_repeat("&nbsp;", (23 - strlen($DC))) . $DC;

        // tax
        $titleTax = 'Ppn (12%)';
        $titleTax = $titleTax . str_repeat("&nbsp;", (21 - strlen($titleTax)));
        $TAX      = $this->Krs->_currency($report->tax);
        $TAX      = str_repeat("&nbsp;", (23 - strlen($TAX))) . $TAX;

        // total
        $titleTot = 'Grandtotal';
        $titleTot = $titleTot . str_repeat("&nbsp;", (21 - strlen($titleTot)));
        $TOT      = $this->Krs->_currency($report->grandtotal);
        $TOT      = str_repeat("&nbsp;", (23 - strlen($TOT))) . $TOT;

        // bayar
        $titlePay = 'BAYAR';
        $titlePay = $titlePay . str_repeat("&nbsp;", (22 - strlen($titlePay)));
        $PAY      = $this->Krs->_currency($report->pay);
        $PAY      = str_repeat("&nbsp;", (22 - strlen($PAY))) . $PAY;

        // total
        $titleDiff = 'KEMBALI';
        $titleDiff = $titleDiff . str_repeat("&nbsp;", (23 - strlen($titleDiff)));
        $DIFF      = $this->Krs->_currency($report->diff);
        $DIFF      = str_repeat("&nbsp;", (22 - strlen($DIFF))) . $DIFF;
        ?>

        <table cellpadding="0" cellspacing="0" style="width:100%">
            <thead>
                <tr>
                    <th align="left" class="txt-left" width="500"><?= $caption ?></th>
                </tr>
            </thead>
            <tr>
                <td align="left" class="txt-left"><?= str_repeat("=", 32) ?></td>
            </tr>

            <?php
            foreach ($report->order_lines as $key => $value) {

                $item        = $value->item_line->name;
                $item        = $item . str_repeat("&nbsp;", (13 - strlen($item)));

                $qty        = $value->quantity . 'x';
                $qty        = $qty . str_repeat("&nbsp;", (6 - strlen($qty)));

                $price      = $this->Krs->_currency($value->price_t);
                $price      = str_repeat("&nbsp;", (9 - strlen($price))) . $price;

                $total      = $this->Krs->_currency($value->subtotal);
                $lentotal   = strlen($total);
                $total      = str_repeat("&nbsp;", (10 - $lentotal)) . $total;
            ?>
                <tr>
                    <td align="left" class="txt-left" colspan="4"><?= $value->item_line->item->name ?></td>
                </tr>
                <tr>
                    <td align="left" class="txt-left" style="padding-bottom: 5px;"><?= $item . $qty . $price . $total  ?></td>
                </tr>
            <?php
            }
            ?>

            <tr>
                <td><?= str_repeat('=', 32) ?></td>
            </tr>
            <tr>
                <td><?= $titleST . $ST ?></td>
            </tr>
            <tr>
                <td><?= $titleDisc . $DC ?></td>
            </tr>
            <tr>
                <td><?= $titleTax . $TAX ?></td>
            </tr>
            <tr>
                <td><?= $titleTot . $TOT ?></td>
            </tr>
            <tr>
                <td><?= str_repeat('=', 32) ?></td>
            </tr>
            <tr>
                <td><?= $titlePay . $PAY ?></td>
            </tr>
            <tr>
                <td><?= $titleDiff . $DIFF ?></td>
            </tr>
        </table>
        <br>
        <?php
        $footer = 'Terima kasih atas kunjungan anda';
        $starSpace = (32 - strlen($footer)) / 2;
        $starFooter = str_repeat('*', $starSpace + 1);
        echo ($starFooter . '&nbsp;' . $footer . '&nbsp;' . $starFooter . "<br/><br/><br/><br/>");
        echo '<p>&nbsp;</p>';
        ?>
    </section>
</body>

</html>
