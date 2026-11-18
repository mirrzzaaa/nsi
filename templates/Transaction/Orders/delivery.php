<?php
$dataChild = $this->Html->link('Surat Jalan', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Buat') ?>
<?= $this->Form->create($order, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_delivery', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<div class="row">
    <div class="col-md-6">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-file-alt fa-lg me-2 text-gray text-opacity-50"></i>
                Surat Jalan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">No. Surat Jalan</label> 
                        <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $data['lastNumber'], 'readonly']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Tgl. Pengiriman</label>
                        <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tgl. surat jalan', 'value' => date('d-m-Y'), 'readonly']); ?>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Pengirim</label>
                        <?= $this->Form->control('delivered', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Contoh : Resi Expedisi, Nopol truck, admin pengiriman...', 'data-parsley-required' => true, 'data-parsley-error-message' => 'Pengirim harus diisi !']); ?>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Catatan</label>
                        <?= $this->Form->control('description', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Catatan...', 'type' => 'textarea']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-truck-loading fa-lg me-2 text-gray text-opacity-50"></i>
                Data Order
            </div>
            <div class="card-body">
                <div class="row m-b-15">
                    <div class="col-2 col-sm-2 mb-1">
                        <b>No. Order</b>
                        <?= $this->Form->hidden('order_id', ['value' => $order->id]); ?>
                    </div>
                    <div class="col-10 col-sm-10 mb-1">: <i><?php echo $order->code ?></i></div>

                    <div class="col-2 col-sm-2 mb-1">
                        <b>Customer</b>
                    </div>
                    <div class="col-10 col-sm-10 mb-1">: <i><?php echo (!empty($order->pelanggan) ? $order->pelanggan->title . ' ' . $order->pelanggan->name : '-') ?></i></div>

                    <div class="col-2 col-sm-2 mb-1">
                        <b>Alamat</b>
                    </div>
                    <div class="col-10 col-sm-10 mb-1">: <i><?php echo (!empty($order->pelanggan) ? $order->pelanggan->address_penghasil : '-') ?></i></div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($order->order_lines as $rowOrder) { ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= (!empty($rowOrder->mouse_item) ? $rowOrder->mouse_item->item->name : '-') ?></td>
                                    <td><?= $this->Krs->_currency($rowOrder->quantity) . ' ' . (!empty($rowOrder->mouse_item) ? $rowOrder->mouse_item->unit : '-'); ?> </td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-yellow d-flex p-3">
                <?php
                echo $this->Form->button('Simpan', ['class' => 'btn btn-primary  ms-auto', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
                ?>
            </div>
        </div>
    </div>
</div>


<?= $this->Form->end(); ?>

<script>
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Orders', 'action' => 'delivery', $order->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

    });
</script>
