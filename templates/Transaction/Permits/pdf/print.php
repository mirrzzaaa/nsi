<html>

<head>
    <style>
        p {
            line-height: 1.2;
            font-size: 9;
        }

        table {
            font-family: 'Times New Roman', Times, serif;
            font-size: 9;
            border-collapse: separate;
            border-spacing: 0px;
            width: 100%;
            padding: 5px 10px 5px 10px;
        }

        thead {
            background-color: #f1f1f1;
        }

        th {
            border: 1.5px solid #000;
            text-align: center;
            padding: 2px;
            font-size: 9;
        }

        td {
            border-spacing: 2em;
            align-content: flex-start;
            flex: content;
        }

        @page {
            size: 210mm 297mm potrait; 
            margin: 0;
        }
    </style>

</head>

<body>
    <table>
        <tbody>
            <tr>
                <td width="30%">
                    <h3>PT. NUSA SARAYA INDONESIA</h3>
                    <p>Pergudangan Meiko Abadi VI G-01, Ds. Sumput, Kec. Driyorejo, Kabupaten Gresik, Jawa Timur <br>Telp : (031) 99026591</p>
                </td>
                <td width="40%">&nbsp;</td>
                <td width="30%">
                    <p>Kepada Yth. </p>
                    <p><?= (!empty($report->order) ? $report->order->pelanggan->name : '-') ?> <br><?= (!empty($report->order) ? $report->order->pelanggan->address_penghasil : '-') ?> <br>Telp : <?= (!empty($report->order) ? $report->order->pelanggan->telp_person : '-') ?></p>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                <hr>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <h3 style="text-decoration: underline; text-align: center;">SURAT JALAN</h3>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr>
                <td width="50">No. Surat Jalan</td>
                <td width="250"> : <?= $report->code ?></td>
            </tr>
            <tr> 
                <td width="50">No. Invoice</td>
                <td width="250"> : <?= (!empty($report->order->invoice_id) ? $report->order->invoice->code : '-') ?></td>
            </tr>
            <tr>
                <td width="50">Tgl. Pengiriman</td>
                <td width="250"> : <?= ($report->date !== null ? date_format($report->date, 'd') . ' ' . $this->Krs->getMonth(date_format($report->date, 'n')) . ' ' . date_format($report->date, 'Y') : '-') ?></td>
            </tr>
            <tr>
                <td width="50">Pengirim</td>
                <td width="250"> : <?php echo (!empty($report->delivered) ? $report->delivered : $report->truck->name) ?></td>
            </tr>
            <br>
            <tr>
                <td colspan="2">Bersama dengan surat ini, kami kirimkan barang dengan rincian sebagai berikut :</td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th width="50">NO.</th>
                <th width="300">NAMA ALAT/BARANG/PERAGA</th>
                <th width="100">JUMLAH</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
            $no = 1;
            if (!empty($report->permit_order_lines)) {
                foreach ($report->permit_order_lines as $permitOrderLine) { 
                    // Ambil order_line dari relasi OrderLines
                    $orderLine = $permitOrderLine->order_line ?? null;
                    if ($orderLine) {
                        ?>
                        <tr>
                            <td style="text-align: center; border: 1px solid #000000; padding: 2px;"><?= $no; ?></td>
                            <td style="border: 1px solid #000000; padding: 2px;">
                                <?= h($orderLine->item->name ?? '-') ?> 
                            </td>
                            <td style="text-align: center; border: 1px solid #000000; padding: 2px;" class="text-center">
                                <?= $this->Krs->_currency($orderLine->quantity ?? 0) . ' ' . ($orderLine->unit ?? '-'); ?>
                            </td>
                        </tr>
                        <?php
                        $no++;
                    }
                }
            } else {
                echo "<tr><td colspan='3' class='text-center'>Data tidak ditemukan</td></tr>";
            }
            ?>

            <br>
            <tr>
                <td colspan="3"><strong>Note : </strong></td>
            </tr>
            <tr>
                <td colspan="3"> <?= $report->description ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <tbody>
            <tr>
                <td width="100" style="text-align: center;">Pengirim, <br><br><br><br><br>(..............................)</td>
                <td width="100" style="text-align: center;">Security, <br><br><br><br><br>(..............................)</td>
                <td width="100" style="text-align: center;">Bagian Pengiriman, <br><br><br><br><br>(..............................)</td>
                <td width="100" style="text-align: center;">Penerima, <br><br><br><br><br>(..............................)</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
