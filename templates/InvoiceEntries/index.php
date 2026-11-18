<?php
//pr($invoiceEntries);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
?>
<?= $this->Krs->breadcrumb_('Data', 'Invoices Masuk', 'Tampilkan') ?>

<div class="panel">
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Krs->addButton(); ?> 
                        <?= $this->Krs->downloadButton(); ?> 
                    </div>
                </div>
            </div>
            <br>

            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-body bg-info">
                <div class="row">
                    <div class="col-md-2">
                        <?= $this->Form->control('filtercode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No invoice...', 'value' => $this->request->getQuery('filtercode')]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('filtercustomer', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Supplier...', 'value' => $this->request->getQuery('filtercustomer')]); ?>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <?php
                            echo $this->Krs->inputDateRange('filterstart', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. buat..', 'value' => $this->request->getQuery('filterstart')), 'filterend', array("class" => "form-control date-picker filterDateReceive", 'readonly' => true, 'placeholder' => 'Tgl. buat..', 'value' => $this->request->getQuery('filterend')), 's/d', 'resetDateReceive');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filterstatus', ['label' => false, 'class' => 'form-control status', 'data-placeholder' => 'Status...', 'empty' => 'Status...', 'options' => $this->Krs->statusInvoices(), 'value' => $this->request->getQuery('filterstatus')]); ?>
                    </div>
                    <div class="col-md-1">
                        <div class="btn-group w-100">
                            <?= $this->Krs->searchButton(); ?> 
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
            <br>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" width="50">#</th>
                            <th width="200">No. Invoice Masuk</th>
                            <th>Supplier</th>
                            <th class="text-center">Tgl. Terima</th>
                            <th class="text-center">Tgl. Jatuh Tempo</th>
                            <th class="text-center" width="100">Status</th>
                            <th class="actions text-center" width="100"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($invoiceEntries) > 0) {
                            foreach ($invoiceEntries as $index => $data) :
                                $linkPreview = array('action' => 'preview', $data->id);
                                //$linkEdit = array('action' => 'edit', $data->id);

                                $status = ''; 
                                $badge = '';
                                $table = '';
                                switch ($data->payment_status) {
                                    case 'N':
                                        $status = 'Belum Terbayar';
                                        $badge = 'bg-warning';
                                        $table = '';
                                        break;
                                    case 'Y':
                                        $status = 'Terbayar';
                                        $badge = 'bg-success';
                                        $table = 'table-success';
                                        break;
                                    default:
                                        $status = 'Kurang Bayar';
                                        $badge = 'bg-lime';
                                        $table = 'table-lime';
                                        break;
                                }
                        ?>
                                <tr class="<?= $table ?>">
                                    <td class="text-center"><?= $no ?></td>
                                    <td><b><?= (!empty($data->code) ? $data->code : '-') ?></b></td>
                                    <td><span class="badge border border-dark text-dark px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i><?= (!empty($data->purchasing) ? $data->purchasing->supplier->name : '-') ?></span></td>
                                    <td class="text-center"><?= ($data->date == null ? '-' : date_format($data->date, 'd-m-Y')) ?></td>
                                    <td class="text-center"><?= ($data->due_date == null ? '-' : date_format($data->due_date, 'd-m-Y')) ?></td>
                                    <td class="text-center"><span class="badge <?= $badge ?>"><?= $status ?></span></td>
                                    <td class="with-btn text-center" nowrap>
                                        <?= $this->Krs->btn('preview', $linkPreview, $data['id']); ?>

                                        <?php
                                        //if (($data->is_print == 0) && ($checkUrl['invoices']['edit'] == 1)) {
                                            //echo $this->Krs->btn('edit', $linkEdit);
                                        //}
                                        ?>

                                    </td>
                                </tr>
                        <?php $no++;
                            endforeach;
                        } else {
                            echo $this->Krs->dataNull();
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?= $this->Krs->paginators() ?>
        </div>
    </div>
</div>



<?php
$urlGetData = $this->Url->build(['prefix' => false, 'controller' => 'InvoiceEntries', 'action' => 'view', '_full' => true]);
?>

<!-- modal  -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<script>
    $(document).ready(function() {

        datePickerReset('input-daterange', 'resetDateReceive', 'filterDateReceive', 'dd-mm-yyyy');

        $('.slc').select2({
            allowClear: true
        });

        $('.status').select2({
            allowClear: true
        });

        <?php
        foreach ($invoiceEntries as $rs) {
            echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
        }
        ?>

    });
</script>
