<?php
ini_set('precision', 14);

// pr($receipt);

$subtotals = array();
    foreach ($report->order->order_lines as $index => $value) {
        $subtotals[$index] = is_numeric($value->subtotal) ? $value->subtotal : 0;
    }
    $subtotalSum = array_sum($subtotals);
    $dpp = round((is_numeric($report->ppn) && $report->ppn > 0) ? ((11 * $subtotalSum) / 12) : 0);
    $ppn = round((is_numeric($report->ppn) && $report->ppn > 0) ? ((12 * $dpp) / 100) : 0);
    $grandtotals = $subtotalSum + $ppn;

    // $ppn = (is_numeric($report->ppn) && $report->ppn > 0) ? ((11 * $subtotalSum) / 100) : 0;
    //pr($ppn); 
$orders = $report->order; 

?> 

<!DOCTYPE html>
<html lang="en"> 

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>invoice</title>
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
        <img src="<?php echo WWW_ROOT ?>img/logo/header.png" width="100%" alt="" style="">
    </div>
    <div class="fixed-footer">
        <img src="<?php echo WWW_ROOT ?>img/logo/footer.png" width="100%" alt="">
    </div>
    <main>
        <div class="container">
            <?php if (isset($report->payment_nominal_1) && $report->payment_nominal_1 > 0) { ?>
                <h2 style="color: #000000; text-align: center;">INVOICE</h2>
            <?php } else { ?>
                <h2 style="color: #000000; text-align: center;">INVOICE PROFORMA</h2>
            <?php } ?>
            <table style="margin-top: 2px;">
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
                        <td width="25%" style="text-align: right;border-right: 1 solid #000;"><?= ($report->date !== null ? $this->Krs->_fDate($report->date) : '-') ?></td>
                        <td width="25%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="25%">&nbsp;</td>
                        <td width="25%" style="border-left: 1 solid #000;border-bottom: 1 solid #000;">Jatuh Tempo</td>
                        <td width="25%" style="text-align: right;border-right: 1 solid #000;border-bottom: 1 solid #000;"><?= ($report->expired !== null ? $this->Krs->_fDate($report->expired) : '-') ?></td>
                        <td width="25%">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
            <div style="padding-left: 25px;padding-right: 50px;">
                <br>
                <span>Kami tagihkan invoice/tagihan belanja alat kesehatan kepada :</span>
                <br>
                <span><strong><?= (!empty($report->order->pelanggan) ? $report->order->pelanggan->name : '') ?></strong></span>
                <br>
                <span><?= (!empty($report->order->pelanggan) ? $report->order->pelanggan->address_penghasil : '') ?></span>
                <p>Telah terima produk sebagai berikut :</p>
                <table>
                    <thead>
                        <tr>
                            <th width="30">No</th>
                            <th>Produk</th>
                            <th>Keterangan</th>
                            <th width="50">Jumlah</th>
                            <th width="75">Harga</th>
                            <th width="60">Diskon</th>
                            <th width="75">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $subtotals = array();
                        foreach ($report->order->order_lines as $index => $rowOrder) {
                            $subtotals[$index] = $rowOrder->subtotal;
                        ?>
                            <tr>
                                <td style="text-align: center; border: 1 solid #000;"><?= $no; ?></td>
                                <td style=" border: 1 solid #000;"><?= (!empty($rowOrder->item) ? $rowOrder->item->name : '-') ?></td>
                                <td style=" border: 1 solid #000;"><?= (!empty($rowOrder->comment) ? $rowOrder->comment : '-') ?></td>
                                <td style="text-align: center;  border: 1 solid #000;"><?= $this->Krs->_currency($rowOrder->quantity) . ' ' . (!empty($rowOrder->item) ? $rowOrder->item->unit : ''); ?></td>
                                <td style="text-align: right;  border: 1 solid #000;"><?= $this->Krs->_currency($rowOrder->price_t); ?></td>
                                <td style="text-align: right;  border: 1 solid #000;"><?= $this->Krs->_currency($rowOrder->discount); ?></td>
                                <td style="text-align: right;  border: 1 solid #000;"><?= $this->Krs->_currency($rowOrder->subtotal); ?></td>
                            </tr>
                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>

                    <br>

                    <?php if (!empty($report->order->keterangan)) { ?>
                        <div>
                            <span><strong>Note : </strong><?= $report->order->keterangan ?></span>
                        </div>
                    <?php } ?>

                <table>
                    <tfoot>
                        <tr>
                            <td width="55%">&nbsp;</td>
                            <td width="30%">Total Harga Jual</td>
                            <td style="text-align: right;"><?= $this->Krs->_currency(array_sum($subtotals)); ?></td>
                        </tr>

                        <?php if ($ppn > 0) { ?>
                            <tr>
                                <td width="55%">&nbsp;</td>
                                <td width="30%">DPP Nilai Lain (11/12*total harga jual)</td>
                                <td style="text-align: right;"><?= $this->Krs->_currency($dpp); ?></td>
                            </tr>
                            <tr>
                                <td width="55%">&nbsp;</td>
                                <td width="30%">PPN (12%)</td>
                                <td style="text-align: right;"><?= $this->Krs->_currency($ppn); ?></td>
                            </tr>
                        <?php } ?>

                        <?php if ($report->order->deliver_pays > 0) { ?>
                            <tr>
                                <td width="55%">&nbsp;</td>
                                <td width="30%">Biaya Pengiriman</td>
                                <td style="text-align: right;"><?= $this->Krs->_currency($report->order->deliver_pays); ?></td>
                            </tr>
                        <?php } ?>

                        <?php if ($report->order->discount > 0) { ?>
                            <tr>
                                <td width="55%">&nbsp;</td>
                                <td width="30%">Discount</td>
                                <td style="text-align: right;"><?= $this->Krs->_currency($report->order->discount); ?> %</td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td width="55%">&nbsp;</td>
                            <td width="30%"><strong><u>GRANDTOTAL</u></strong></td>
                            <td style="text-align: right;"><strong><u>Rp. <?= $this->Krs->_currency($orders->grandtotal); ?></u></strong></td>
                        </tr>

                        <?php if ($report->dp_nominal !== null && $report->dp_nominal > 0) { ?>
                            <tr>
                                <td width="55%">&nbsp;</td>
                                <td width="30%"><?= (!empty($report->dp_method) ? $report->dp_method : 'DP/Termin') ?></td>
                                <td style="text-align: right;"><?= $this->Krs->_currency($report->dp_nominal); ?></td>
                            </tr>
                            <?php if ($report->dp_ppn > 0) { 
                                $ddpDP = round(($report->dp_nominal * 11) / 12);
                                $ppnDP = round(($ddpDP * 12) / 100);
                                // $ppnDP = ($report->dp_nominal * 11) / 100;
                            ?>
                                <tr>
                                    <td width="55%">&nbsp;</td>
                                    <td width="30%">DPP Nilai Lain (11/12*DP)</td>
                                    <td style="text-align: right;"><?= $this->Krs->_currency($ddpDP); ?></td>
                                </tr>
                                <tr>
                                    <td width="55%">&nbsp;</td>
                                    <td width="30%">PPN (12%)</td>
                                    <td style="text-align: right;"><?= $this->Krs->_currency($ppnDP); ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td width="55%">&nbsp;</td>
                                <td width="30%"><strong><u>NOMINAL PEMBAYARAN</u></strong></td>
                                <td style="text-align: right;"><strong><u>Rp. <?= $this->Krs->_currency($report->dp_nominal + $ppnDP); ?></u></strong></td>
                            </tr>
                        <?php } ?>
                    </tfoot>
                </table>
                
                <?php
                if ($report->dp_nominal !== null && $report->dp_nominal > 0) { ?>
                    <span>Terbilang : <strong><?= ucwords($this->Krs->terbilang($report->dp_nominal + $ppnDP)) ?> Rupiah</strong></span> <br>
                <?php
                } elseif ($report->dp_nominal === null || $report->dp_nominal == 0) {
                ?>
                    <span>Terbilang : <strong><?= ucwords($this->Krs->terbilang($orders->grandtotal)) ?> Rupiah</strong></span> <br>
                <?php
                }
                ?>

                <?php
                if ($report->payment_nominal_1 != null) { ?>
                <br>
                <span style="font-size: 11;"><strong>Pembayaran</strong></span>
                <br><br>
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal Pembayaran</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($receipt)) : ?>
                            <?php 
                                $totalNominal = 0; // Inisialisasi total nominal
                                foreach ($receipt as $rowReceipt) :  
                                    $totalNominal += (!empty($rowReceipt->nominal) ? $rowReceipt->nominal : 0); // Jumlahkan nominal
                            ?>
                            <tr>
                                <td style="text-align: center; border: 1 solid #000;">
                                    <?= ($rowReceipt->date !== null ? strftime('%d %B %Y', strtotime($rowReceipt->date)) : '') ?>
                                </td>
                                <td style="border: 1 solid #000;">
                                    <?= (!empty($rowReceipt->description) ? $rowReceipt->description : '') ?>
                                </td>
                                <td style="text-align: center; border: 1 solid #000;"> Rp. 
                                    <?= (!empty($rowReceipt->nominal) ? $this->Krs->_currency($rowReceipt->nominal) : '') ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="2" style="text-align: center;">Sisa Tagihan</th>
                            <th style="text-align: center;">Rp. <?= $this->Krs->_currency($orders->grandtotal - $totalNominal); ?></th>
                        </tr>
                    </thead>
                </table>
                <?php
                }
                ?>

                <table>
                    <br><br><br>
                    <tbody>
                        <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="54%">
                                <div class="border-custom">
                                    <span>Pembayaran dapat dilakukan melalui :</span>
                                    <br>
                                    <span>Bank : <strong>BANK PERMATA SYARIAH</strong></span>
                                    <br>
                                    <span>A/N : <strong>PT. NUSA SARAYA INDONESIA</strong></span>
                                    <br>
                                    <span>Pembayaran melalui cek/giro No. Rek. : <strong>7020 99455</strong></span>
                                    <br>
                                    <span>Mohon disertakan keterangan "Nomor lnvoice: dan bukti transfer"</span>
                                    <br>
                                    <span>dikirim ke 'info@nusasaraya.co.id'</span>
                                </div>
                            </td>
                            <td width="45%">&nbsp;</td>                            
                        </tr>
                    </tbody>
                </table> 

                <table>
                    <br><br><br>
                    <tbody>
                        <tr>
                            <td width="5%">&nbsp;</td>
                            <td width="30%" style="text-align: left;">
                                <span>Gresik, <?= $this->Krs->_fDate($report->date); ?></span> 
                                <br>
                                <span>Hormat kami,</span>
                                <br>
                                <span>PT NUSA SARAYA INDONESIA</span>
                                <br><br><br><br><br><br><br><br><br><br>
                                <u><strong>Bennazier Kusuma Pradhani</strong></u>
                                <br>
                                <span>Administrasi</span>
                            </td>
                            <td width="10%">&nbsp;</td>
                            <td width="54%">
                                <td width="200" style="text-align: center;">Penerima <br><br><br><br><br><br><br><br>(.....................................)</td>
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
