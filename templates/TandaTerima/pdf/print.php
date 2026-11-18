<?php
ini_set('precision', 14);

?> 

<!DOCTYPE html>
<html lang="en"> 

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>tanda terima</title>
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
            bottom: 20px;
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
            padding: 4px;
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
        <img src="<?php echo WWW_ROOT ?>img/logo/header_tt.png" width="100%" alt="" style="">
    </div>
    <main>
        <div class="container">
            <h2 style="color: #000000; text-align: center; margin-bottom: 5px;"><u>TANDA TERIMA</u></h2>
            <span style="color: #000000; text-align: center; display: block; margin-top: 0;">No : <?= (!empty($report->code) ? $report->code : '-') ?></span>
            <br>
            <div style="padding-left: 100px; padding-right: 100px;">
                <br>
                <span>Dengan ini kami serahkan kepada</span>
                <br>
                <span><strong><?= (!empty($report->invoice->customer) ? $report->invoice->customer->name : '') ?></strong> dan telah diterima dengan baik berupa :</span>
                <br>
                <table style="line-height: 2;">
                    <tbody>
                        <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="30%" style="text-align: left;">Invoice No.</td>
                            <td width="1%">:</td>
                            <td width="55%"><?= (!empty($report->invoice_id) ? $report->invoice->code : '-') ?></td>
                        </tr>
                        <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="30%" style="text-align: left;">Faktur Pajak No.</td>
                            <td width="1%">:</td>
                            <td width="55%"><?= (!empty($report->no_faktur) ? $report->no_faktur : '-') ?></td>
                        </tr>
                        <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="30%" style="text-align: left;">Berita Acara No.</td>
                            <td width="1%">:</td>
                            <td width="55%"><?= (!empty($report->no_ba) ? $report->no_ba : '-') ?></td>
                        </tr>
                        <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="30%" style="text-align: left;">Lain-lain</td>
                            <td width="1%">:</td>
                            <td width="55%"><?= (!empty($report->permit_id) ? $report->permit->code : '-') ?></td>
                        </tr>
                        <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="30%" style="text-align: left; vertical-align: middle;"><strong>Rencana Tanggal Pembayaran</strong></td>
                            <td width="1%">:</td>
                            <td width="55%">............................................</td>
                        </tr>
                        <br><br>
                        <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="30%" style="text-align: left;">Gresik, <?= $this->Krs->_fDate($report->date); ?></td>
                            <td width="1%">&nbsp;</td>
                            <td width="55%">&nbsp;</td>
                        </tr>

                    </tbody>
                </table>

                <table>
                    <tbody>
                        <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="30%" style="text-align: center;">
                                Menyerahkan <br><br><br><br><br><br><br><br>(..............................................)
                                <br>&nbsp;
                            </td>
                            <td>&nbsp;</td>
                            <td width="30%" style="text-align: center;">
                                Menerima <br><br><br><br><br><br><br><br>(..............................................)
                                <br><span style="font-size: 10px;">Tanda tangan & Stampel</span>
                            </td>
                            <td width="1%">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</body>

</html>
