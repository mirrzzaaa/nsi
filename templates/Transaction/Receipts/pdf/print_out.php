<?php
ini_set('precision', 14);

//pr($report);

$subtotals = array();
    foreach ($report->order->order_lines as $index => $value) {
        $subtotals[$index] = is_numeric($value->subtotal) ? $value->subtotal : 0;
    }
    $subtotalSum = array_sum($subtotals);
    $ppn = (is_numeric($report->ppn) && $report->ppn > 0) ? ((11 * $subtotalSum) / 100) : 0;
    //pr($ppn); 
$orders = $report->order; 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>kuitansi</title>
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
            padding: 20px 15px 15px 15px;
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
            font-size: 10;
            font-family: Arial, Helvetica, sans-serif;
            /* padding-left: 15px; */
            /* padding-right: 50px; */
        }

        table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 10;
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
            font-size: 10;
        }

        td {
            padding: 4px;
            font-size: 10;

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
        }

        /* Footer */
        .invoice-footer {
            margin-top: 20px;
            padding: 10px;
        }

        .text-center {
            text-align: center;
            font-size: 10px;
        }

        .mb-5px {
            margin-bottom: 2px;
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
    <main>
        <div class="container">
            <div style="border: 1px solid #000; padding: 5px; margin: 10px 50px 20px 20px;">
                <h2 style="color: #000000; text-align: center; background-color: #d0d0d0;">KUITANSI</h2>
                <div style="padding-left: 25px;padding-right: 50px;">
                    <table>
                        <tbody>
                            <tr valign="top">
                                <td width="23%">No. Kuitansi</td>
                                <br><br>
                                <td width="5%">:</td>
                                <br><br>
                                <td width="67%"><?= $report->code ?></td>
                            </tr>
                            <tr valign="top">
                                <td width="23%">Telah terima dari</td>
                                <br><br>
                                <td width="5%">:</td>
                                <br><br>
                                <td width="67%"><?= $report->order->pelanggan->name ?></td>
                            </tr>
                            
                            <tr valign="top">
                                <td width="23%">Terbilang</td>
                                <br><br>
                                <td width="5%">:</td>
                                <br><br>
                                <td width="67%"># <?= ucwords($this->Krs->terbilang($report->nominal)) ?> Rupiah</td>
                            </tr>
                            <tr valign="top">
                                <td width="23%">Untuk pembayaran</td>
                                <br><br>
                                <td width="5%">:</td>
                                <br><br>
                                <td width="67%"><?= $report->description ?></td>
                            </tr>
                        </tbody>
                        <br>
                    </table>
                    <table>
                        <br>
                        <tbody>
                            <tr>
                                <td width="35%" style="text-align: left;"> 
                                    <br><br><br><br><br><br><br><br><br><br>
                                    <div style="border: 2px solid #000; padding: 10px; text-align: center; display: inline-block; position: relative; overflow: hidden; background: linear-gradient(45deg, #e0e0e0 25%, transparent 25%, transparent 50%, #e0e0e0 50%, #e0e0e0 75%, transparent 75%, transparent); background-size: 10px 10px;">
                                        <span style="position: relative; z-index: 1;"><strong><i>Jumlah Uang: Rp. <?= $this->Krs->_currency($report->nominal) ?></i></strong></span>
                                    </div>

                                </td>
                                <td width="5%">&nbsp;</td>
                                <td width="25%" style="text-align: right;">
                                    <div style="text-align: center;">
                                        <span style="display: block; margin-bottom: 150px;">Gresik, <?= date('d') . ' ' . $this->Krs->getMonth(date('n')) . ' ' . date('Y'); ?></span>
                                        <u><strong>Bennazier Kusuma Pradhani</strong></u>
                                        <br>
                                        <span>Administrasi</span>
                                    </div>
                                </td>
                                <td width="5%">&nbsp;</td>
                            </tr>
                        </tbody>
                        <br>
                    </table>
                </div>
            </div>
        </div>
    </main>

</body>

</html>
