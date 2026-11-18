<?php
ini_set('precision', 14);

// pr($report);

$subtotals = array();
    foreach ($report->purchasing_lines as $index => $value) {
        $subtotals[$index] = is_numeric($value->subtotal) ? $value->subtotal : 0;
    }
    $subtotalSum = array_sum($subtotals);
    $ppn = (is_numeric($report->ppn) && $report->ppn > 0) ? ((11 * $subtotalSum) / 100) : 0;

    $discount = (is_numeric($report->discount) && $report->discount > 0) ? (($report->discount * $subtotalSum) / 100) : 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>purchase order</title>
    <style>
        @page {
            size: 210mm 297mm potrait;
            margin: 0cm 0cm 0cm 0cm !important;
        }

        body {
            padding-top: 100px;
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
            font-size: 5;
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
            padding: 2px;
            font-size: 9;

        }

        tr:last-child {
            page-break-after: never;
        }

        .border-custom {
            border-collapse: collapse;
            border: 1px solid black;
            padding: 10px; /* Padding untuk memastikan ruang antara teks dan border */
            vertical-align: top; /* Untuk memastikan teks mulai dari atas */
            height: auto;
            font-size: 0.5em;
        }

        /* Footer */
        .invoice-footer {
            padding: 10px;
        }

        .text-center {
            text-align: center;
            font-size: 9px;
        }

        .mb-5px {
            margin-bottom: 1px;
        }

        .fw-bold {
            font-weight: bold;
        }

        .me-10px {
            margin-right: 10px;
            color: #6c757d;
            font-size: 13px !important;
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
        echo WWW_ROOT ?>img/logo/footer1.png" width="100%" alt="">
    </div>
    <main>
        <div class="container">
            <div style="padding-left: 25px;padding-right: 50px; margin-top: 30px;">
                <table>
                    <tbody>
                        <tr>
                            <td width="54%">
                                <span>Company Phone : +6231-99026591, +628113624031</span> <br> 
                                <span>Website : www.nusasaraya.co.id</span> <br>
                                <span>Email : info@nusasaraya.co.id</span> <br>
                                <span>Company Address Goes Here</span> <br>
                                <span>Kawasan Pergudangan dan Industri Meiko Abadi <br> VI – Block G 01, Gresik, East Java, Indonesia, 61228</span>
                            </td>
                            <td width="10%">&nbsp;</td>
                            <td width="30%" style="text-align: right;">
                                <span style="font-size: 18;"><strong>Purchase Order</strong></span>
                                <br>
                                <span>
                                    <?= 
                                        $this->Krs->getMonth(date('n', strtotime($report->date))) . ' ' . 
                                        date('d', strtotime($report->date)) . 
                                        (date('d', strtotime($report->date)) % 10 == 1 && date('d', strtotime($report->date)) != 11 ? '<sup>st</sup>' : 
                                        (date('d', strtotime($report->date)) % 10 == 2 && date('d', strtotime($report->date)) != 12 ? '<sup>nd</sup>' : 
                                        (date('d', strtotime($report->date)) % 10 == 3 && date('d', strtotime($report->date)) != 13 ? '<sup>rd</sup>' : '<sup>th</sup>'))) . 
                                        ', ' . 
                                        date('Y', strtotime($report->date)); 
                                    ?>
                                </span>
                                <br>
                                <span>No : <?= $report->number ?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <table>
                    <br>
                    <tbody>
                        <tr>
                            <td><strong>About Vendor</strong></td>
                        </tr>
                        <tr>
                            <td width="15%">Name</td>
                            <td width="2%">:</td>
                            <td width="83%"><?= $report->supplier->pic ?></td>
                        </tr>
                        <?php if (!empty($report->supplier->pic_dept)) { ?>
                            <tr>
                                <td width="15%">Position</td>
                                <td width="2%">:</td>
                                <td width="10%"><?= $report->supplier->pic_dept ?></td>
                            </tr>
                        <?php } else { ?>
                        <?php } ?>
                        <tr> 
                            <td width="15%">Vendor Name</td>
                            <td width="2%">:</td>
                            <td width="83%"><?= $report->supplier->name ?></td>
                        </tr>
                        <tr>
                            <td width="15%">Address</td>
                            <td width="2%">:</td>
                            <td width="83%"><?= $report->supplier->address ?></td>
                        </tr>
                        <tr>
                            <td width="15%">Email</td>
                            <td width="2%">:</td>
                            <td width="83%"><?= $report->supplier->email ?></td>
                        </tr>
                        <?php if (!empty($report->supplier->fax)) { ?>
                            <tr>
                                <td width="15%">Phone</td>
                                <td width="2%">:</td>
                                <td width="10%"><?= $report->supplier->telp ?> &nbsp;&nbsp; Fax : <?= $report->supplier->fax ?></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td width="15%">Phone</td>
                                <td width="2%">:</td>
                                <td width="10%"><?= $report->supplier->telp ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <br><br>
                    <tbody>
                        <tr>
                            <td><strong>Ship To</strong></td>
                        </tr>
                        <tr>
                            <td width="15%">Name</td>
                            <td width="2%">:</td>
                            <td width="83%">Nanang Triono</td>
                        </tr>
                        <tr>
                            <td width="15%">Position</td>
                            <td width="2%">:</td>
                            <td width="83%">Sales Manager</td>
                        </tr>
                        <tr>
                            <td width="15%">Company Name</td>
                            <td width="2%">:</td>
                            <td width="83%">PT Nusa Saraya Indonesia</td>
                        </tr>
                        <tr>
                            <td width="15%">Address</td>
                            <td width="2%">:</td>
                            <td width="83%">Kawasan Pergudangan dan Industri Meiko Abadi VI – Block G 01, Gresik, East Java, Indonesia, 61228</td>
                        </tr>
                        <tr>
                            <td width="15%">Email</td>
                            <td width="2%">:</td>
                            <td width="83%">nanang.triono@nusasaraya.co.id</td>
                        </tr>
                        <tr>
                            <td width="15%">Phone</td>
                            <td width="2%">:</td>
                            <td width="83%">+62813 3404 0848</td>
                        </tr>
                    </tbody>
                    <br><br>
                </table>

                <span style="padding-left: 3px;">Please assist in fulfilling the order for the following items :</span>
                <table style="padding-left: 3px; padding-top: 5px; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th width="20">No</th>
                            <th>Details</th>
                            <?php if ($report->with_price === 'Y') { ?>
                                <th width="40">Quantity</th>
                                <th width="40">Unit</th>
                                <th width="70">Price</th>
                                <th width="70">Discount</th>
                                <th width="70">Subtotal</th>
                            <?php } elseif ($report->with_price === 'N') { ?>
                                <th>Quantity</th>
                                <th>Unit</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $subtotals = array();
                        foreach ($report->purchasing_lines as $index => $rowOrder) {
                            $subtotals[$index] = $rowOrder->subtotal;
                        ?>
                            <tr>
                                <td style="text-align: center; border: 1 solid #000;"><?= $no; ?></td>
                                <td style=" border: 1 solid #000;"><?= (!empty($rowOrder->item) ? $rowOrder->item->name : '') ?></td>

                                <?php if ($report->with_price === 'Y') { ?>
                                    <td style="text-align: center;  border: 1 solid #000;"><?= $this->Krs->_currency($rowOrder->quantity); ?></td>
                                    <td style="text-align: center;  border: 1 solid #000;"><?= (!empty($rowOrder->item) ? $rowOrder->item->unit : '') ?></td>
                                    <td style="text-align: right;  border: 1 solid #000;"><?= $this->Krs->_currency($rowOrder->price); ?></td>
                                    <td style="text-align: center;  border: 1 solid #000;"><?= $this->Krs->_currency($rowOrder->discount); ?>%</td>
                                    <td style="text-align: right;  border: 1 solid #000;"><?= $this->Krs->_currency($rowOrder->subtotal); ?></td>
                                <?php } elseif ($report->with_price === 'N') { ?>
                                    <td style="text-align: center;  border: 1 solid #000;"><?= $this->Krs->_currency($rowOrder->quantity); ?></td>
                                    <td style="text-align: center;  border: 1 solid #000;"><?= (!empty($rowOrder->item) ? $rowOrder->item->unit : '') ?></td>
                                <?php } ?>
                            </tr>
                        <?php
                            $no++; 
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <?php if ($report->with_price !== 'N') { ?>
                        <tr>
                            <td colspan="7">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="5">&nbsp;</td>
                            <td colspan="1">Subtotal</td>
                            <td style="text-align: right;"><?= $this->Krs->_currency(array_sum($subtotals)); ?></td>
                        </tr>

                        <?php
                        if ($report->discount > 0) { ?>
                            <tr>
                                <td colspan="5">&nbsp;</td>
                                <td colspan="1">Discount (<?= $this->Krs->_currency($report->discount); ?>%)</td>
                                <td style="text-align: right;"><?= $this->Krs->_currency($discount); ?></td>
                            </tr>
                        <?php
                        }
                        ?>

                        <?php
                        if ($report->ship_payment > 0) { ?>
                            <tr>
                                <td colspan="5">&nbsp;</td>
                                <td colspan="1">Biaya Pengiriman</td>
                                <td style="text-align: right;"><?= $this->Krs->_currency($report->ship_payment); ?></td>
                            </tr>
                        <?php
                        }
                        ?>

                        <?php
                        if ($ppn > 0) { ?>
                            <tr>
                                <td colspan="5">&nbsp;</td>
                                <td colspan="1">PPN (12%)</td>
                                <td style="text-align: right;"><?= $this->Krs->_currency($ppn); ?></td>
                            </tr>
                        <?php
                        }
                        ?>

                        <tr>
                            <td colspan="5">&nbsp;</td>
                            <td colspan="1"><strong><u>GRANDTOTAL</u></strong></td>
                            <td style="text-align: right;"><strong><u><?= $this->Krs->_currency($report->grandtotal); ?></u></strong></td>
                        </tr>
                        <?php } else { ?>
                        <tr>
                            <td colspan="4" style="border-top: 1px solid #000;">&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <br><br><br>
                    </tfoot>
                </table>

                <table>
                    <tbody>
                        <tr>
                            <td width="54%">
                                <div class="border-custom" style="padding-top: 2px;">
                                    <span><strong>Additional Notes :</strong></span>
                                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                </div>
                            </td>
                            <td width="10%">&nbsp;</td>
                            <td width="30%" style="text-align: left;">
                                <span>Sincerelly Your,</span>
                                <br>
                                <span>Purchase,</span>
                                <span><img src="<?php echo WWW_ROOT ?>img/ttd/benna.png" width="200px" alt="" style=""></span>
                                <span>(Bennazier Kusuma Pradhani)</span>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </main>

</body>

</html>
