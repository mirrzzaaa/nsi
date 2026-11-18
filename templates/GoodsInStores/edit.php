<?php
//pr($orderLine);
$dataChild = $this->Html->link('Masuk Toko', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Ubah') ?>
<?= $this->Form->create($goodsInStore, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

<!-- <div class="card border-0 mb-3">
    <div class="card-header bg-none p-3">
        <div class="row d-flex"> 
            <div class="col-md-4">
                <strong><i class="fas fa-receipt fa-lg text-gray text-opacity-50"></i></i>&nbsp;&nbsp;&nbsp; : <?= (!empty($goodsInStore->code) ? $goodsInStore->code : '-') ?></strong>
            </div>
            <div class="col-md-4 align-items-right">
                <strong class="text-right"><i class="fas fa-calendar-alt fa-lg text-gray text-opacity-50"></i>&nbsp;&nbsp;&nbsp; : <?= (!empty($goodsInStore->date) ? $this->Krs->fDate($goodsInStore->date, 'd F Y') : '-'); ?></strong>
            </div>
        </div>
    </div>
</div> -->

<div class="row"> 
    <div class="col-md-4 mb-3">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-truck-loading fa-lg me-2 text-gray text-opacity-50"></i>
                Masuk Toko
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="" class="form-label">Kode</label>
                    <?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'value' => $goodsInStore->code, 'disabled']); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Toko</label>
                    <?= $this->Form->control('branch_id', ['label' => false, 'class' => 'form-control slc', 'options' => $branches, 'data-parsley-required' => true, 'data-parsley-errors-container' => '#check-to', 'data-parsley-required-message' => 'Tujuan Produk harus dipilih !']); ?>
                    <div id="check-from"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="form-label">Tanggal</label>
                    <?= $this->Form->control('date', ['label' => false, 'class' => 'form-control tgl', 'value' => $this->Krs->fDate($goodsInStore->date, 'd-m-Y'), 'type' => 'text', 'readonly']); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 mb-3">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fas fa-briefcase-medical fa-lg me-2 text-gray text-opacity-50"></i>
                Produk
            </div>
            <div class="card-body">
                <div class="table-responsive mb-3" style="overflow: auto; height: 280px;">
                    <table class="table table-hover table-panel text-nowrap align-middle mb-0 po">
                        <thead style="position: sticky; top: 0; z-index: 1;">
                            <tr>
                                <th width="300">Produk</th>
                                <th class="text-center" width="200">Jumlah</th>
                                <th width="200">Unit</th>
                                <th width="400">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($goodsInStore->goods_in_store_lines as $key => $value) { 
                                $itemsLines = $value->item_lines;
                                $items = $itemsLines->item;
                                ?>
                                <tr>
                                    <td><?= ($value->item_lines_id > 0) ? $items->name : '-' ?></td>
                                    <td class="text-center"><?= $this->Krs->_currency($value->qty) ?></td>
                                    <td><?= $value->unit ?></td>
                                    <td><?= $value->description ?></td>
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

<?= $this->Form->end() ?>

<script>
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID").format(number);
    }

    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'GoodsInStores', 'action' => 'edit', $goodsInStore->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $('.slc').select2({
            placeholder: "Pilih salah satu"
        });

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

    });
</script>
