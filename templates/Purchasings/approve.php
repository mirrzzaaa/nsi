<?php
$dataChild = $this->Html->link('Purchase Order', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Approve') ?>
<?= $this->Form->create($purchasing, []) ?>
<?= $this->Form->control('is_approve', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="invoice">
    <div class="invoice-company">
        <?= ($purchasing->supplier_id > 0) ? (!empty($purchasing->supplier) ? $purchasing->supplier->name : '') : ''; ?>
    </div>


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
            <small>Supplier</small>
            <address class="mt-5px mb-5px">
                <strong class="text-dark"><?= ($purchasing->supplier_id > 0) ? (!empty($purchasing->supplier) ? $purchasing->supplier->name : '') : ''; ?></strong><br>
                <?= ($purchasing->supplier_id > 0) ? (!empty($purchasing->supplier) ? $purchasing->supplier->address : '') : ''; ?><br>
                Telepon: <?= ($purchasing->supplier_id > 0) ? (!empty($purchasing->supplier) ? $purchasing->supplier->telp : '') : ''; ?><br>
            </address>
        </div> 
        <div class="invoice-date">
            <small>Invoice</small>
            <div class="date text-dark mt-5px"><?= ($purchasing->date != null) ? $this->Krs->dateIndo(date_format($purchasing->date, 'Y-m-d')) : '-' ?></div>
            <div class="invoice-detail">
                <?= $purchasing->number ?><br>
                Services Product
            </div>
        </div>
    </div>
 

    <div class="invoice-content">

        <div class="table-responsive">
            <table class="table table-invoice">
                <thead>
                    <tr>
                        <th>PRODUK</th>
                        <?php if ($purchasing->with_price === 'Y') { ?>
                            <th class="text-center" width="12%">HARGA</th>
                            <th class="text-center" width="10%">JUMLAH</th>
                            <th class="text-center" width="10%">DISKON</th>
                            <th class="text-end" width="20%">SUBTOTAL</th>
                        <?php } elseif ($purchasing->with_price === 'N') { ?>
                            <th class="text-center" width="20%">JUMLAH</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $subtotal = array();
                    if (count($purchasing->purchasing_lines) > 0) {
                        foreach ($purchasing->purchasing_lines as $index => $rowItem) {
                            $subtotal[$index] = $rowItem->subtotal;
                            $items = $rowItem->item;
                            //pr($items);
                    ?>
                            <tr>
                                <td>
                                    <b><span class="text-dark"><?= ($rowItem->item_id > 0) ? ((!empty($rowItem->item)) ? $rowItem->item->name : '-') : '-' ?></span></b><br>
                                    <small><?= ($rowItem->item_id > 0) ? ((!empty($rowItem->item)) ? $rowItem->item->description : '-') : '-' ?></small>
                                </td>
                                <?php if ($purchasing->with_price === 'Y') { ?>
                                    <td class="text-end"><?= $this->Krs->_currency($rowItem->price); ?></td>
                                    <td class="text-center"><?= $this->Krs->_currency($rowItem->quantity) . ' ' . $items->unit; ?></td>
                                    <td class="text-center"><?= $this->Krs->_currency($rowItem->discount); ?> %</td>
                                    <td class="text-end"><?= $this->Krs->_currency($rowItem->subtotal); ?></td>
                                <?php } elseif ($purchasing->with_price === 'N') { ?>
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


        <?php if ($purchasing->with_price !== 'N') { ?>
        <div class="invoice-price">
            <div class="invoice-price-left">
                <div class="invoice-price-row">
                    <div class="sub-price">
                        <small>BIAYA PENGIRIMAN</small>
                        <span class="text-dark"><?= $this->Krs->_currency($purchasing->ship_payment); ?></span>
                    </div>
                    <?php if ($purchasing->ppn > 0) { ?>
                        <div class="sub-price">
                            <i class="fa fa-plus text-muted"></i>
                        </div>
                        <div class="sub-price">
                            <?php $nomTotals = (array_sum($subtotal) * 11) / 100; ?>
                            <small>PPN (12%)</small>
                            <span class="text-dark"><?= $this->Krs->_currency($nomTotals); ?></span>
                        </div>
                    <?php } ?>
                    <div class="sub-price">
                        <i class="fa fa-minus text-muted"></i>
                    </div>
                    <div class="sub-price">
                        <?php $nomTotal = ($purchasing->discount * array_sum($subtotal)) / 100; ?>
                        <small>DISKON (<?= $this->Krs->_currency($purchasing->discount); ?>%)</small>
                        <span class="text-dark"><?= $this->Krs->_currency($nomTotal); ?></span>
                    </div>
                </div>
            </div>
            <div class="invoice-price-right">
                <small>TOTAL</small> <span class="fw-bold"><?= $this->Krs->_currency($purchasing->grandtotal); ?></span>
            </div>
        </div>
        <?php } ?>

        <?php
        if (!empty($purchasing->description)) { ?>
            <div class="invoice-note">
                <b>Note :</b>
                <?= $purchasing->description ?>
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
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'Purchasings', 'action' => 'approve', $purchasing->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

    });
</script>
