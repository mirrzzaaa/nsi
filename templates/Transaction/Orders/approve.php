<?php
$dataChild = $this->Html->link('Order', ['action' => 'index'], ['full_base'=>true]);
//pr($order->order_lines);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Approve') ?>
<?= $this->Form->create($order, []) ?>
<?= $this->Form->control('is_approve', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="invoice">

    <div class="invoice-header">
        <div class="invoice-from">
            <small>Dari</small> 
            <address class="mt-5px mb-5px">
                <strong class="text-dark">PT. Nusa Saraya Indonesia</strong><br>
                Pergudangan Meiko Abadi VI G-01, Sumput, Kec. Driyorejo, Kabupaten Gresik, Jawa Timur 61177<br>
                Telepon: +62 31 99026591
            </address>
        </div>
        <div class="invoice-to">
            <small>Customer</small>
            <address class="mt-5px mb-5px">
                <strong class="text-dark"><?= ($order->customer_id > 0) ? (!empty($order->pelanggan) ? $order->pelanggan->title . ' - ' . $order->pelanggan->name : '') : ''; ?></strong><br>
                <?= ($order->customer_id > 0) ? (!empty($order->pelanggan) ? $order->pelanggan->address_penghasil : '') : ''; ?><br>
                <?= ($order->customer_id > 0) ? (!empty($order->pelanggan) ? $order->pelanggan->telp_person : '') : ''; ?><br>
            </address>
        </div>
        <div class="invoice-date">
            <small>Invoice</small>
            <div class="date text-dark mt-5px"><?= ($order->date != null) ? $this->Krs->dateIndo(date_format($order->date, 'Y-m-d')) : '-' ?></div>
            <div class="invoice-detail"> 
                <?= $order->code ?>
            </div>
        </div>
    </div>
 

    <div class="invoice-content">

        <div class="table-responsive">
            <table class="table table-invoice">
                <thead>
                    <tr>
                        <th>PRODUK</th>
                        <th class="text-center" width="12%">TGL. EXPIRED</th>
                        <?php if ($order->with_price === 'Y') { ?>
                            <th class="text-center" width="10%">HARGA</th>
                            <th class="text-center" width="10%">JUMLAH</th>
                            <th class="text-center" width="9%">DISKON</th>
                            <th class="text-end" width="10%">SUBTOTAL</th>
                        <?php } elseif ($order->with_price === 'N') { ?>
                            <th class="text-center" width="20%">JUMLAH</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $subtotal = array();
                    if (count($order->order_lines) > 0) {
                        foreach ($order->order_lines as $index => $rowItem) {
                            $subtotal[$index] = $rowItem->subtotal;
                            $items = $rowItem->item;
                    ?>
                            <tr>
                                <td>
                                    <b><span class="text-dark"><?= ($rowItem->item_id > 0) ? ((!empty($rowItem->item)) ? $rowItem->item->name : '-') : '-' ?></span></b><br>
                                    <small><?= ($rowItem->item_id > 0) ? ((!empty($rowItem->item)) ? $rowItem->item->description : '-') : '-' ?></small>
                                </td>
                                <td class="text-center"><?= $this->Krs->fDate($rowItem->expired_date, 'd-m-Y'); ?></td>
                                <?php if ($order->with_price === 'Y') { ?>
                                    <td class="text-end"><?= $this->Krs->_currency($rowItem->price_t); ?></td>
                                    <td class="text-center"><?= $this->Krs->_currency($rowItem->quantity) . ' ' . $items->unit; ?></td>
                                    <td class="text-end"><?= $this->Krs->_currency($rowItem->discount); ?></td>
                                    <td class="text-end"><?= $this->Krs->_currency($rowItem->subtotal); ?></td>
                                <?php } elseif ($order->with_price === 'N') { ?>
                                    <td class="text-center"><?= $this->Krs->_currency($rowItem->quantity) . ' ' . $items->unit; ?></td>
                                <?php } ?>
                            </tr>
                        <?php
                        }
                    } else { ?>
                        <tr>
                            <td colspan="<?php echo ($purchasing->with_price === 'Y') ? '5' : '2'; ?>" class="text-center"><span class="text-dark">DATA KOSONG</span></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php if ($order->with_price !== 'N') { ?>
        <div class="invoice-price">
            <div class="invoice-price-left">
                <div class="invoice-price-row">
                    <?php
                    $deliverPays = floatval(str_replace(",", ".", $order->deliver_pays));
                    if ($deliverPays > 0) { ?>
                    <div class="sub-price">
                        <small>BIAYA PENGIRIMAN</small>
                        <span class="text-dark"><?= $this->Krs->_currency($order->deliver_pays); ?></span>
                    </div>
                    <?php
                    }
                    ?>
                    <?php
                    if ($order->ppn > 0) { ?>
                        <div class="sub-price">
                            <i class="fa fa-plus text-muted"></i>
                        </div>
                        <div class="sub-price">
                            <?php
                            $nomPpn = (11 * array_sum($subtotal)) / 100;
                            ?>
                            <small>PPN (12%)</small>
                            <span class="text-dark"><?= $this->Krs->_currency($nomPpn); ?></span>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="invoice-price-right">
                <small>TOTAL</small> <span class="fw-bold"><?= $this->Krs->_currency($order->grandtotal); ?></span>
            </div>
        </div>
        <?php } ?>

        <?php
        if (!empty($order->description)) { ?>
            <div class="invoice-note">
                <b>Note :</b>
                <?= $order->description ?>
            </div>
        <?php
        }
        ?>

    </div>


    <div class="invoice-footer d-flex">
        <?php
        echo $this->Form->button('Approve', ['class' => 'btn btn-success  ms-auto', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
        ?>
    </div>
</div>
<?= $this->Form->end() ?>


<script>
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Orders', 'action' => 'approve', $order->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

    });
</script>
