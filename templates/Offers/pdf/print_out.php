<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
            padding: 0px 0px 0px 0px;
            margin: 0px;
            /* Center the DIV horizontally */
        }

        p {
            line-height: 1;
            font-size: 10;
            /* font-family: sans-serif; */
        }

        span {
        /* font-family: DejaVu Sans, sans-serif; */
        font-family: 'Times New Roman', Times, serif;
        }

        table {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10;
            border-collapse: collapse;
            width: 100%;
        }

        thead {
            background-color: gray;
        }

        td,
        th {
            /* border: 1px solid #000; */
            /* text-align: center; */
            padding: 1.5px;
            /* height: 20px; */
            font-size: 9.5;
        }

        .border-custom {
            border-collapse: collapse;
            border: 2px solid black;
            padding: 10px; /* Padding untuk memastikan ruang antara teks dan border */
            vertical-align: top; /* Untuk memastikan teks mulai dari atas */
            height: auto;
            font-size: 9;
            border-radius: 15px;
        }

    </style>
</head>

<body>
    <div class="container">
        <table style="margin-top: 15px;  padding: 0cm 1cm 0cm 1cm !important;">
            <tbody>
                <?php if (!empty($print->branch->company_name)) { ?>
                    <tr>
                        <td colspan="2" style="text-align: right;"><strong><?= $print->branch->company_name . ', ' . $this->Krs->fDates(date('Y-m-d'), 'd F Y'); ?></strong>
                        </td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="2" style="text-align: right;"><strong>Gresik, <?= $this->Krs->fDates(date('Y-m-d'), 'd F Y'); ?></strong></td>
                    </tr>
                <?php } ?>

                <tr>
                    <td width="50">Nomor</td>
                    <td> : <?= $print->code ?></td>
                </tr>
                <tr>
                    <td width="50">Lampiran</td> 
                    <td> : Brosur</td>
                </tr>
                <tr>
                    <td width="50">Perihal</td>
                    <td> : <?= $print->perihal ?></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>

                <?php if (empty($print->attn_1) && !empty($print->attn_2)) { ?>
                    <tr>
                        <td colspan="2">Kepada Yth :</td>
                    </tr>
                    <tr>
                        <td colspan="2"><b><?= $print->customer_name ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="2">CC : <?= $print->attn_2 ?></td>
                    </tr>
                <?php } elseif (!empty($print->attn_1) && empty($print->attn_2)) { ?>
                    <tr>
                        <td colspan="2">Kepada Yth :</td>
                    </tr>
                    <tr>
                        <td colspan="2"><?= $print->attn_1 ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b><?= $print->customer_name ?></b></td>
                    </tr>
                <?php } elseif (empty($print->attn_1) && empty($print->attn_2)) { ?>
                    <tr>
                        <td colspan="2">Kepada Yth :</td>
                    </tr>
                    <tr>
                        <td colspan="2"><b><?= $print->customer_name ?></b></td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="2">Kepada Yth :</td>
                    </tr>
                    <tr>
                        <td colspan="2"><?= $print->attn_1 ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b><?= $print->customer_name ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?= $print->customer_address ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">CC : <?= $print->attn_2 ?></td>
                    </tr>
                <?php } ?>

                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
            </tbody>
        </table>
        <div style="padding: 0cm 1cm 0cm 1cm !important;"> 
            <?= base64_decode($print->description) ?>
        </div>
        <?php if (!empty($print->branch->company_name && $print->branch->company_address)) { ?>
            <table style="margin-left: 60px; margin-right: 40px;">
                <tbody>
                    <tr>
                        <td width="30%">
                            <div class="border-custom">
                                <span>
                                    <strong style="font-style: italic;">
                                        Representative Office : <br><?= $print->branch->company_address; ?></strong>
                                </span>
                            </div>
                        </td>
                        <td width="44%" style="text-align: center;">
                            <span>Hormat kami,</span>
                            <br>
                            <span><img src="<?php echo WWW_ROOT ?>img/ttd/nanang.png" width="200px" alt="" style=""></span>
                            <br>
                            <u><strong>Nanang Triono</strong></u>
                            <br>
                            <span>Manager</span>
                        </td>
                        <td width="1%">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        <?php } else { ?>
            <table>
                <tbody>
                    <tr>
                        <td width="55%">&nbsp;</td>
                        <td width="44%" style="text-align: center;">
                            <span>Hormat kami,</span>
                            <br>
                            <span><img src="<?php echo WWW_ROOT ?>img/ttd/nanang.png" width="200px" alt="" style=""></span>
                            <br>
                            <u><strong>Nanang Triono</strong></u>
                            <br>
                            <span>Manager</span>
                        </td>
                        <td width="1%">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>
    </div>
</body>

</html>
