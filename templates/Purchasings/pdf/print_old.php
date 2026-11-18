<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>purchase order</title>
    <style>
        
        /* Kertas */
        @page {
            size: 210mm 297mm landscape;
            margin: 0cm 0cm 0cm 0cm !important;
        }

        body {
            padding-top: 50px;
            padding-bottom: 50px;
            padding-right: 50px;
            padding-left: 50px;
        }

        /* Contoh */
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
            font-size: 12;
            font-family: Arial, Helvetica, sans-serif;
            /* padding-left: 15px; */
            /* padding-right: 50px; */
        }

        span {
            line-height: 1.5;
            font-size: 12;
            font-family: Arial, Helvetica, sans-serif;
            /* padding-left: 15px; */
            /* padding-right: 50px; */
        }


        /* Table */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }

        .table .table {
            background-color: #fff;
        }

        .table-invoice th {
            background-color: #f8f9fa;
            text-align: left;
            font-weight: bold;
            color: #333;
        }

        .table-invoice td {
            text-align: left;
            color: #555;
        }

        .table-invoice td small {
            text-align: left;
            color: #555;
            font-size: 13px;
        }

        .table-invoice .text-center {
            text-align: center;
            font-size: 13px;
        }

        .table-invoice .text-end {
            text-align: right;
            font-size: 13px;
        }

        .table-invoice .text-dark {
            text-align: left;
            font-size: 13px;
        }

        .table-invoice thead th {
            border-bottom-width: 2px;
        }

        .table-invoice tbody tr .row-item{
            font-size: 20px;
        }

        .table-invoice th,
        .table-invoice td {
            border: 1px solid #dee2e6;
        }

        .table-invoice th {
            padding: 10px;
            background-color: #f1f1f1;
        }

        .table-invoice td {
            padding: 10px;
            font-size: 12px;
        }

        .table-invoice tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table-invoice tr:hover {
            background-color: #f1f1f1;
        }

        .table-invoice .fw-bold {
            font-weight: bold;
        }

        .table-invoice .text-muted {
            color: #6c757d;
        }

        /* Header */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
        }

        .invoice-row {
            flex: 1;
            margin-right: 20px;
        }

        .invoice-row:last-child {
            margin-right: 0;
        }

        .invoice-row small {
            display: block;
            margin-bottom: 5px;
            color: #6c757d;
        }

        .invoice-row address,
        .invoice-row .date,
        .invoice-row .invoice-detail {
            margin: 0;
            color: #333;
        }

        .invoice-row .text-dark {
            color: #333;
        }

        .mt-5px {
            margin-top: 5px;
        }

        .mb-5px {
            margin-bottom: 5px;
        }

        /* Harga Pembayaran */
        .invoice-price {
            padding: 10px;
            border: 1px solid #dee2e6;
            background-color: #f9f9f9;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .invoice-price-left {
            display: flex;
            flex-direction: column;
        }

        .invoice-price-row {
            display: flex;
            align-items: center;
        }

        .sub-price {
            margin-right: 10px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .sub-price small {
            color: #555;
            font-size: 12px;
        }

        .sub-price span {
            font-weight: bold;
            color: #333;
            font-size: 12px;
        }

        .invoice-price-right {
            text-align: right;
            font-weight: bold;
        }

        .invoice-price-right small{
            color: #555;
            font-weight: bold;
        }

        /* Keterangan */
        .invoice-note {
            padding: 10px;
            border: 1px solid #dee2e6;
            background-color: #fff;
            margin-top: 20px;
        }

        .invoice-note b {
            color: #333;
        }

        .invoice-note .note {
            color: #6c757d;
            font-size: 10px !important;
        }


        /* Footer */
        .invoice-footer {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-top: 1px solid #dee2e6;
        }

        .text-center {
            text-align: center;
            font-size: 13px;
        }

        .mb-5px {
            margin-bottom: 5px;
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
    <div class="invoice">

    <div class="invoice-header">
        <div class="row col-md-12">
            <div class="invoice-row col-md-4">
                <small>Dari</small>
                <address class="mt-5px mb-5px">
                    <strong class="text-dark">PT. Nusa Saraya Indonesia</strong><br>
                    Pergudangan Meiko Abadi VI G-01, Sumput, Kec. Driyorejo, Kabupaten Gresik, Jawa Timur 61177<br>
                    Telepon: +62 31 99026591
                </address>
            </div>
        </div>
    </div>

    <div class="invoice-header">
        <div class="row col-md-12">
            <div class="invoice-row col-md-4">
                <small>Supplier</small>
                <address class="mt-5px mb-5px">
                    <strong class="text-dark"><?= ($report->supplier_id > 0) ? (!empty($report->supplier) ? $report->supplier->name : '') : ''; ?></strong><br>
                    <?= ($report->supplier_id > 0) ? (!empty($report->supplier) ? $report->supplier->address : '') : ''; ?><br>
                    Telepon: <?= ($report->supplier_id > 0) ? (!empty($report->supplier) ? $report->supplier->telp : '') : ''; ?><br>
                </address>
            </div>
        </div>
    </div>

    <div class="invoice-header">
        <div class="row col-md-12">
            <div class="invoice-row col-md-4">
                <small>Invoice</small>
                <div class="date text-dark mt-5px"><?= ($report->date != null) ? $this->Krs->dateIndo(date_format($report->date, 'Y-m-d')) : '-' ?></div>
                <div class="invoice-detail">
                    <?= $report->number ?><br>
                    Services Product
                </div>
            </div>
        </div>
    </div>


    <div class="invoice-content">

        <div class="table-responsive">
            <table class="table table-invoice">
                <thead>
                    <tr>
                        <th>PRODUK</th>
                        <?php if ($report->with_price === 'Y') { ?>
                            <th class="text-center" width="12%">HARGA</th>
                            <th class="text-center" width="10%">JUMLAH</th>
                            <th class="text-center" width="10%">DISKON</th>
                            <th class="text-end" width="20%">SUBTOTAL</th>
                        <?php } elseif ($report->with_price === 'N') { ?>
                            <th class="text-center" width="20%">JUMLAH</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $subtotal = array();
                    if (count($report->purchasing_lines) > 0) {
                        foreach ($report->purchasing_lines as $index => $rowItem) {
                            $subtotal[$index] = $rowItem->subtotal;
                            $items = $rowItem->item;
                            //pr($items);
                    ?>
                            <tr class="row-item">
                                <td>
                                    <b><span class="text-dark"><?= ($rowItem->item_id > 0) ? ((!empty($rowItem->item)) ? $rowItem->item->name : '-') : '-' ?></span></b><br>
                                    <small><?= ($rowItem->item_id > 0) ? ((!empty($rowItem->item)) ? $rowItem->item->description : '-') : '-' ?></small>
                                </td>
                                <?php if ($report->with_price === 'Y') { ?>
                                    <td class="text-end"><?= $this->Krs->_currency($rowItem->price); ?></td>
                                    <td class="text-center"><?= $this->Krs->_currency($rowItem->quantity) . ' ' . $items->unit; ?></td>
                                    <td class="text-center"><?= $this->Krs->_currency($rowItem->discount); ?> %</td>
                                    <td class="text-end"><?= $this->Krs->_currency($rowItem->subtotal); ?></td>
                                <?php } elseif ($report->with_price === 'N') { ?>
                                    <td class="text-center"><?= $this->Krs->_currency($rowItem->quantity) . ' ' . $items->unit; ?></td>
                                <?php } ?>
                            </tr>
                        <?php
                        }
                    } else { ?>
                        <tr>
                            <td colspan="<?php echo ($report->with_price === 'Y') ? '5' : '2'; ?>" class="text-center"><span class="text-dark">DATA KOSONG</span></td> 
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>


        <?php if ($report->with_price !== 'N') { ?>
        <div class="invoice-price">
            <div class="invoice-price-left">
                <div class="invoice-price-row">
                    <div class="sub-price">
                        <small>BIAYA PENGIRIMAN</small> 
                        <span class="text-dark"><?= $this->Krs->_currency($report->ship_payment); ?></span> &nbsp;
                    <?php if ($report->ppn > 0) { ?>
                            <i class="fa fa-plus text-muted"></i> &nbsp;
                            <?php $nomTotals = (array_sum($subtotal) * 11) / 100; ?>
                            <small>PPN (12%)</small> 
                            <span class="text-dark"><?= $this->Krs->_currency($nomTotals); ?></span> &nbsp;
                    <?php } ?>
                        <i class="fa fa-minus text-muted"></i> &nbsp;
                        <?php $nomTotal = ($report->discount * array_sum($subtotal)) / 100; ?>
                        <small>DISKON (<?= $this->Krs->_currency($report->discount); ?>%)</small> 
                        <span class="text-dark"><?= $this->Krs->_currency($nomTotal); ?></span>
                    </div>
                </div>
            <div class="invoice-price-right">
                <small>TOTAL</small> <br>
                <span class="fw-bold"><?= $this->Krs->_currency($report->grandtotal); ?></span>
            </div>
            </div>
        </div>
        <?php } ?>

        <?php
        if (!empty($report->description)) { ?>
            <div class="invoice-note">
                <b>Note :</b>
                <span class="note"><?= $report->description ?></span>
            </div>
        <?php
        }
        ?>

    </div>

    <div class="invoice-footer">
        <p class="text-center mb-5px fw-bold">
           CONNECTION MEDICAL DEVICE SOLUTION
        </p>
        <p class="text-center">
            <span class="me-10px"><i class="fa fa-fw fa-lg fa-globe"></i> www.nusasaraya.co.id</span>
            <span class="me-10px"><i class="fa fa-fw fa-lg fa-phone-volume"></i>+62 31 99026591</span>
        </p>
    </div>

</div>

</body>

</html>
