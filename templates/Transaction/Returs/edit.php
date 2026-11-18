<?php
//pr($returLines);
$dataChild = $this->Html->link('Retur Customer', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Transaksi', $dataChild, 'Edit') ?>
<?= $this->Form->create($retur, []) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>


<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
        <i class="fas fa-search fa-lg me-2 text-gray text-opacity-50"></i>
        Cari No. Order
    </div>
    <div class="card-body">
        <?= $this->Form->text('order_ids', ['label' => false, 'class' => 'form-control finding', 'placeholder' => 'Cari nomor order...', 'id' => "jquery-autocompletePo", 'autofocus', 'value' => $retur->order->code]); ?>
        <?= $this->Form->hidden('order_id', ['class' => 'order_id']); ?>
        <?= $this->Form->hidden('customer_id', ['class' => 'customer_id']); ?>
        <div id="dataId"></div>
    </div>
</div>  

<div class="row">
    <div class="col-md-4">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-undo fa-lg me-2 text-gray text-opacity-50"></i>
                Retur
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="" class="form-label">No. Retur</label>
                    <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'type' => 'text', 'value' => $retur->code]); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Tanggal</label>
                    <input type="text" class="form-control tgl" value="<?= date_format($retur->date, 'd-m-Y') ?>" name="date" />
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Keterangan</label>
                    <?= $this->Form->control('reason', ['label' => false, 'class' => 'form-control', 'type' => 'textarea']); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 mb-3">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-shopping-basket fa-lg me-2 text-gray text-opacity-50"></i>
                Produk Retur
            </div>
            <div class="card-body">
                <div class="table-responsive mb-3" style="overflow: auto; height: 200px;">
                    <table class="table table-hover retur">
                        <thead>
                            <tr>
                                <th width="100">Kode</th>
                                <th width="500">Produk</th>
                                <th width="80" class="text-center">Harga</th>
                                <th width="100" class="text-center">Jumlah</th>
                                <th width="200" class="text-center">Kondisi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $total = count($retur->retur_lines) - 1;
                            foreach ($retur->retur_lines as $index => $dataRetur) { 
                                $qty = $dataRetur->quantity;
                                $items = $dataRetur->item;
                                $codeItems = $items->code;
                                $nameItems = $items->name;
                                $checked = $dataRetur->reason == 1 ? 'checked' : '';

                                ?>
                            <tr id="dataReturs">
                                <td><?= $codeItems; ?></td>
                                <td><?= $nameItems; ?></td>
                                <td class="text-end"><?= $this->Krs->_currency($dataRetur->nominal); ?></td>
                                <td ><input class="form-control text-center" value="<?= $qty; ?>" readonly></td>
                                <td class="text-center">
                                    <label class="form-check-label">Rusak</label>
                                </td>
                                <td class="text-center"><button class="btn btn-pink btn-sm" id="del" type="button"><i class="far fa-trash-alt"></i></button></td>
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
                echo $this->Form->button('Simpan', ['class' => 'btn btn-primary  ms-auto save', 'type' => 'button', 'escape' => false, 'id' => 'btn-add', 'disabled']);
                ?>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->end(); ?>

<script>
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }

    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Returs', 'action' => 'edit', $retur->id], ['fullBase' => true]); ?>";

        var counter = ($('.retur tr').length);
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $('.slc').select2({
            placeholder: "Pilih..."
        });


        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        $("#jquery-autocompletePo").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Returs', 'action' => 'getorder']); ?>",
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(e, i) {
                var id = i.item.data.id;
                $.ajax({
                    url: "<?php echo $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Returs', 'action' => 'setorder']); ?>",
                    method: "get",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data) {
                            // Sembunyikan elemen data order
                            hideElemen(data) 

                            $('.save').prop('disabled', false);
                            if (data.branch_id > 0) {
                                $("#dataId").append('<input type="hidden" name="branch_id" value="' + data.branch_id + '">' );
                            } else {
                                $("#dataId").append('<input type="hidden" name="warehouse_id" value="' + data.warehouse_id + '">');
                            }
                            $('.order_id').val(data.id);
                            $('.customer_id').val(data.customer_id);
                            $.each(data.order_lines, function(i, val) {
                                let qty = val.quantity;
                                let subtotal = qty * val.price_t;

                                $('.total').text(rupiah(subtotal));

                                $('.retur > tbody').append('<tr id="rowData' + i + '"><td>' + val.item.code + '<input type="hidden" name="returLines[' + i + '][item_id]" value="' + val.item_id + '"><input type="hidden" name="returLines[' + i + '][id]" value="' + val.id + '"><input type="hidden" name="returLines[' + i + '][code]" value="' + val.item.code + '"></td><td>' + val.item.name + '<input type="hidden" name="returLines[' + i + '][nominal]" value="' + val.price_t + '"></td><td>' + rupiah(val.price_t) + '</td><td><input type="number" name="returLines[' + i + '][quantity]" min="0" max="' + qty + '" class="form-control text-end qty-input" data-price="' + val.price_t + '" data-index="' + i + '" value="' + qty + '"></td><td><input type="hidden" name="returLines[' + i + '][reason]" value="0"><input type="checkbox" class="form-check-input" name="returLines[' + i + '][reason]" value="1">&nbsp;<label class="form-check-label">Rusak</label></td><td class="text-center"><button class="btn btn-pink btn-sm" id="del" type="button"><i class="far fa-trash-alt"></i></button></td></tr>');
                            });

                            $('.qty-input').on('input', function() {
                                let price = $(this).data('price');
                                let index = $(this).data('index');
                                let qty = $(this).val();
                                let subtotal = qty * price;
                                $('#rowData' + index + ' .subtotal').text(rupiah(subtotal));
                            });
                        }
                    }
                });

            }
        });

        function hideElemen(data) {
            var elemen = document.getElementById("dataReturs");
            elemen.style.display = "none";
        }

        $(document).on("click", "#del", function(event) {

            counter -= 1
            if (counter >= 0) {
                $(this).closest("tr").remove();
            } else {
                swal('Informasi', 'Minimal retur 1 item produk', 'info');
            }
        });

    });


    function calculate() {
        var net_total = 0;

        $(".subtotal").each(function(data) {
            net_total = net_total + ($(this).val() * 1);
        });

        $('.total').val(rupiah(net_total));
        // $('.grandtotal').val(gt);
    }
</script>
