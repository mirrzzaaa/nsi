<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$dataChild = $this->Html->link('User', ['action' => 'index'], ['full_base' => true]);
?>

<?= $this->Krs->breadcrumb('Pengaturan', $dataChild, 'Akses') ?>
<?php

// Petty Cash
$pettycash = $rules['pettycashes'];
$pettycash_index = ($pettycash['index'] == 1) ? 'checked' : '';
$pettycash_add = ($pettycash['add'] == 1) ? 'checked' : '';
$pettycash_edit = ($pettycash['edit'] == 1) ? 'checked' : ''; 
$pettycash_editAll = ($pettycash['editAll'] == 1) ? 'checked' : '';
$pettycash_pdf = ($pettycash['pdf'] == 1) ? 'checked' : '';
$pettycash_excel = ($pettycash['excel'] == 1) ? 'checked' : '';
$pettycash_delete = ($pettycash['delete'] == 1) ? 'checked' : '';
$pettycash_approve = ($pettycash['approve'] == 1) ? 'checked' : '';
$pettycash_approve_ceo = ($pettycash['approveCeo'] == 1) ? 'checked' : '';
$pettycash_payment = ($pettycash['payment'] == 1) ? 'checked' : '';
$pettycash_preview = ($pettycash['preview'] == 1) ? 'checked' : '';
$pettycash_printing = ($pettycash['printing'] == 1) ? 'checked' : '';

// Toko
$branches = $rules['branches'];
$branch_index = ($branches['index'] == 1) ? 'checked' : '';
$branch_add = ($branches['add'] == 1) ? 'checked' : '';
$branch_edit = ($branches['edit'] == 1) ? 'checked' : '';
$branch_view = ($branches['view'] == 1) ? 'checked' : '';
$branch_delete = ($branches['delete'] == 1) ? 'checked' : '';
$branch_pdf = ($branches['pdf'] == 1) ? 'checked' : '';
$branch_excel = ($branches['excel'] == 1) ? 'checked' : '';
$branch_changestatus = ($branches['changestatus'] == 1) ? 'checked' : ''; 

// Category
$categories = $rules['categories'];
$category_index = ($categories['index'] == 1) ? 'checked' : '';
$category_add = ($categories['add'] == 1) ? 'checked' : '';
$category_edit = ($categories['edit'] == 1) ? 'checked' : '';
$category_view = ($categories['view'] == 1) ? 'checked' : '';
$category_delete = ($categories['delete'] == 1) ? 'checked' : '';
$category_pdf = ($categories['pdf'] == 1) ? 'checked' : '';
$category_excel = ($categories['excel'] == 1) ? 'checked' : '';

// Area
$unit = $rules['unit'];
$unit_index = ($unit['index'] == 1) ? 'checked' : '';
$unit_add = ($unit['add'] == 1) ? 'checked' : '';
$unit_edit = ($unit['edit'] == 1) ? 'checked' : '';
$unit_view = ($unit['view'] == 1) ? 'checked' : '';
$unit_delete = ($unit['delete'] == 1) ? 'checked' : '';
$unit_pdf = ($unit['pdf'] == 1) ? 'checked' : '';
$unit_excel = ($unit['excel'] == 1) ? 'checked' : '';

// Orders
$orders = $rules['orders'];
$orders_index = ($orders['index'] == 1) ? 'checked' : '';
$orders_add = ($orders['add'] == 1) ? 'checked' : '';
$orders_edit = ($orders['edit'] == 1) ? 'checked' : '';
$orders_view = ($orders['view'] == 1) ? 'checked' : '';
$orders_delete = ($orders['delete'] == 1) ? 'checked' : '';
$orders_approve = ($orders['approve'] == 1) ? 'checked' : '';
$orders_pdf = ($orders['pdf'] == 1) ? 'checked' : '';
$orders_excel = ($orders['excel'] == 1) ? 'checked' : '';

// Kwitansi
$receipts = $rules['receipts'];
$receipts_index = ($receipts['index'] == 1) ? 'checked' : '';
$receipts_add = ($receipts['add'] == 1) ? 'checked' : '';
$receipts_edit = ($receipts['edit'] == 1) ? 'checked' : '';
$receipts_view = ($receipts['view'] == 1) ? 'checked' : '';
$receipts_delete = ($receipts['delete'] == 1) ? 'checked' : '';
$receipts_approve = ($receipts['approve'] == 1) ? 'checked' : '';
$receipts_pdf = ($receipts['pdf'] == 1) ? 'checked' : '';
$receipts_excel = ($receipts['excel'] == 1) ? 'checked' : '';
$receipts_print = ($receipts['print'] == 1) ? 'checked' : '';
$receipts_printOut = ($receipts['printOut'] == 1) ? 'checked' : '';

// retur customer
$retur = $rules['returs'];
$retur_index = ($retur['index'] == 1) ? 'checked' : '';
$retur_add = ($retur['add'] == 1) ? 'checked' : ''; 
$retur_edit = ($retur['edit'] == 1) ? 'checked' : '';
$retur_view = ($retur['view'] == 1) ? 'checked' : '';
$retur_delete = ($retur['delete'] == 1) ? 'checked' : '';
$retur_pdf = ($retur['pdf'] == 1) ? 'checked' : '';
$retur_excel = ($retur['excel'] == 1) ? 'checked' : '';

// retur supplier
$retursupplier = $rules['retursuppliers'];
$retursupplier_index = ($retursupplier['index'] == 1) ? 'checked' : '';
$retursupplier_add = ($retursupplier['add'] == 1) ? 'checked' : '';
$retursupplier_edit = ($retursupplier['edit'] == 1) ? 'checked' : '';
$retursupplier_view = ($retursupplier['view'] == 1) ? 'checked' : '';
$retursupplier_delete = ($retursupplier['delete'] == 1) ? 'checked' : '';
$retursupplier_pdf = ($retursupplier['pdf'] == 1) ? 'checked' : '';
$retursupplier_excel = ($retursupplier['excel'] == 1) ? 'checked' : '';

// purchasing
$purchasing = $rules['purchasings'];
$purchasing_index = ($purchasing['index'] == 1) ? 'checked' : '';
$purchasing_add = ($purchasing['add'] == 1) ? 'checked' : '';
$purchasing_edit = ($purchasing['edit'] == 1) ? 'checked' : '';
$purchasing_view = ($purchasing['view'] == 1) ? 'checked' : '';
$purchasing_delete = ($purchasing['delete'] == 1) ? 'checked' : '';
$purchasing_approve = ($purchasing['approve'] == 1) ? 'checked' : '';
$purchasing_cancel = ($purchasing['cancel'] == 1) ? 'checked' : '';
$purchasing_excel = ($purchasing['excel'] == 1) ? 'checked' : '';
$purchasing_print = ($purchasing['print'] == 1) ? 'checked' : '';
$purchasing_print_english = ($purchasing['printEnglish'] == 1) ? 'checked' : '';

// masuk gudang
$goodsinwarehouses = $rules['goodsinwarehouses'];
$goodsinwarehouses_index = ($goodsinwarehouses['index'] == 1) ? 'checked' : '';
$goodsinwarehouses_add = ($goodsinwarehouses['add'] == 1) ? 'checked' : '';
$goodsinwarehouses_edit = ($goodsinwarehouses['edit'] == 1) ? 'checked' : '';
$goodsinwarehouses_view = ($goodsinwarehouses['view'] == 1) ? 'checked' : '';
$goodsinwarehouses_delete = ($goodsinwarehouses['delete'] == 1) ? 'checked' : '';
$goodsinwarehouses_pdf = ($goodsinwarehouses['pdf'] == 1) ? 'checked' : '';
$goodsinwarehouses_excel = ($goodsinwarehouses['excel'] == 1) ? 'checked' : '';


// keluar gudang
$goodsoutwarehouses = $rules['goodsoutwarehouses'];
$goodsoutwarehouses_index = ($goodsoutwarehouses['index'] == 1) ? 'checked' : '';
$goodsoutwarehouses_delivery = ($goodsoutwarehouses['delivery'] == 1) ? 'checked' : '';
$goodsoutwarehouses_add = ($goodsoutwarehouses['add'] == 1) ? 'checked' : '';
$goodsoutwarehouses_edit = ($goodsoutwarehouses['edit'] == 1) ? 'checked' : '';
$goodsoutwarehouses_view = ($goodsoutwarehouses['view'] == 1) ? 'checked' : '';
$goodsoutwarehouses_delete = ($goodsoutwarehouses['delete'] == 1) ? 'checked' : '';
$goodsoutwarehouses_pdf = ($goodsoutwarehouses['pdf'] == 1) ? 'checked' : '';
$goodsoutwarehouses_excel = ($goodsoutwarehouses['excel'] == 1) ? 'checked' : '';

// masuk store cabang
$goodsinstores = $rules['goodsinstores'];
$goodsinstores_index = ($goodsinstores['index'] == 1) ? 'checked' : '';
$goodsinstores_add = ($goodsinstores['add'] == 1) ? 'checked' : '';
$goodsinstores_edit = ($goodsinstores['edit'] == 1) ? 'checked' : '';
$goodsinstores_view = ($goodsinstores['view'] == 1) ? 'checked' : '';
$goodsinstores_delete = ($goodsinstores['delete'] == 1) ? 'checked' : '';
$goodsinstores_pdf = ($goodsinstores['pdf'] == 1) ? 'checked' : '';
$goodsinstores_excel = ($goodsinstores['excel'] == 1) ? 'checked' : '';

// keluar store cabang
$goodsoutstores = $rules['goodsoutstores'];
$goodsoutstores_index = ($goodsoutstores['index'] == 1) ? 'checked' : '';
$goodsoutstores_add = ($goodsoutstores['add'] == 1) ? 'checked' : '';
$goodsoutstores_edit = ($goodsoutstores['edit'] == 1) ? 'checked' : '';
$goodsoutstores_view = ($goodsoutstores['view'] == 1) ? 'checked' : '';
$goodsoutstores_delete = ($goodsoutstores['delete'] == 1) ? 'checked' : '';
$goodsoutstores_pdf = ($goodsoutstores['pdf'] == 1) ? 'checked' : '';
$goodsoutstores_excel = ($goodsoutstores['excel'] == 1) ? 'checked' : '';

// User
$user = $rules['users'];
$user_index = ($user['index'] == 1) ? 'checked' : '';
$user_add = ($user['add'] == 1) ? 'checked' : '';
$user_edit = ($user['edit'] == 1) ? 'checked' : '';
$user_access = ($user['access'] == 1) ? 'checked' : '';
$user_reset = ($user['reset'] == 1) ? 'checked' : '';
$user_change = ($user['change'] == 1) ? 'checked' : '';
$user_delete = ($user['delete'] == 1) ? 'checked' : '';
$user_pdf = ($user['pdf'] == 1) ? 'checked' : '';
$user_excel = ($user['excel'] == 1) ? 'checked' : '';

// Negara
$country = $rules['country'];
$country_index = ($country['index'] == 1) ? 'checked' : '';
$country_add = ($country['add'] == 1) ? 'checked' : '';
$country_edit = ($country['edit'] == 1) ? 'checked' : '';
$country_view = ($country['view'] == 1) ? 'checked' : '';
$country_delete = ($country['delete'] == 1) ? 'checked' : '';
$country_pdf = ($country['pdf'] == 1) ? 'checked' : '';
$country_excel = ($country['excel'] == 1) ? 'checked' : '';
$country_changestatus = ($country['changestatus'] == 1) ? 'checked' : '';
$country_dataExportImport = ($country['dataExportImport'] == 1) ? 'checked' : '';

// Area
$area = $rules['area'];
$area_index = ($area['index'] == 1) ? 'checked' : '';
$area_add = ($area['add'] == 1) ? 'checked' : '';
$area_edit = ($area['edit'] == 1) ? 'checked' : '';
$area_view = ($area['view'] == 1) ? 'checked' : '';
$area_delete = ($area['delete'] == 1) ? 'checked' : '';
$area_pdf = ($area['pdf'] == 1) ? 'checked' : '';
$area_excel = ($area['excel'] == 1) ? 'checked' : '';
$area_changestatus = ($area['changestatus'] == 1) ? 'checked' : '';
$area_dataExportImport = ($area['dataExportImport'] == 1) ? 'checked' : '';

// Customer
$customer = $rules['customers'];
$customer_index = ($customer['index'] == 1) ? 'checked' : '';
$customer_add = ($customer['add'] == 1) ? 'checked' : '';
$customer_edit = ($customer['edit'] == 1) ? 'checked' : '';
$customer_view = ($customer['view'] == 1) ? 'checked' : '';
$customer_delete = ($customer['delete'] == 1) ? 'checked' : '';
$customer_pdf = ($customer['pdf'] == 1) ? 'checked' : '';
$customer_excel = ($customer['excel'] == 1) ? 'checked' : '';
$customer_changestatus = ($customer['changestatus'] == 1) ? 'checked' : '';

// Member
$member = $rules['members'];
$member_index = ($member['index'] == 1) ? 'checked' : '';
$member_add = ($member['add'] == 1) ? 'checked' : '';
$member_edit = ($member['edit'] == 1) ? 'checked' : '';
$member_view = ($member['view'] == 1) ? 'checked' : '';
$member_delete = ($member['delete'] == 1) ? 'checked' : '';
$member_pdf = ($member['pdf'] == 1) ? 'checked' : '';
$member_excel = ($member['excel'] == 1) ? 'checked' : '';

// MOU
$mou = $rules['mouses'];
$mou_index = ($mou['index'] == 1) ? 'checked' : '';
$mou_add = ($mou['add'] == 1) ? 'checked' : '';
$mou_edit = ($mou['edit'] == 1) ? 'checked' : '';
$mou_view = ($mou['view'] == 1) ? 'checked' : '';
$mou_delete = ($mou['delete'] == 1) ? 'checked' : '';
$mou_pdf = ($mou['pdf'] == 1) ? 'checked' : '';
$mou_excel = ($mou['excel'] == 1) ? 'checked' : '';
$mou_changestatus = ($mou['changestatus'] == 1) ? 'checked' : '';

// Truck
$truck = $rules['trucks'];
$truck_index = ($truck['index'] == 1) ? 'checked' : '';
$truck_add = ($truck['add'] == 1) ? 'checked' : '';
$truck_edit = ($truck['edit'] == 1) ? 'checked' : '';
$truck_view = ($truck['view'] == 1) ? 'checked' : '';
$truck_delete = ($truck['delete'] == 1) ? 'checked' : '';
$truck_pdf = ($truck['pdf'] == 1) ? 'checked' : '';
$truck_excel = ($truck['excel'] == 1) ? 'checked' : '';
$truck_changestatus = ($truck['changestatus'] == 1) ? 'checked' : '';

// Stok Toko
$branchstock = $rules['branchstocks'];
$branchstock_index = ($branchstock['index'] == 1) ? 'checked' : '';
$branchstock_add = ($branchstock['add'] == 1) ? 'checked' : '';
$branchstock_edit = ($branchstock['edit'] == 1) ? 'checked' : '';
$branchstock_view = ($branchstock['view'] == 1) ? 'checked' : '';
$branchstock_delete = ($branchstock['delete'] == 1) ? 'checked' : '';
$branchstock_pdf = ($branchstock['pdf'] == 1) ? 'checked' : '';
$branchstock_excel = ($branchstock['excel'] == 1) ? 'checked' : '';

// Surat Jalan
$permit = $rules['permits'];
$permit_index = ($permit['index'] == 1) ? 'checked' : '';
$permit_add = ($permit['add'] == 1) ? 'checked' : '';
$permit_edit = ($permit['edit'] == 1) ? 'checked' : '';
$permit_view = ($permit['view'] == 1) ? 'checked' : '';
$permit_delete = ($permit['delete'] == 1) ? 'checked' : '';
$permit_pdf = ($permit['pdf'] == 1) ? 'checked' : '';
$permit_excel = ($permit['excel'] == 1) ? 'checked' : '';
$permit_print = ($permit['print'] == 1) ? 'checked' : '';

// Invoice Masuk
$invoiceentrie = $rules['invoiceentries'];
$invoiceentrie_index = ($invoiceentrie['index'] == 1) ? 'checked' : '';
$invoiceentrie_payment = ($invoiceentrie['payment'] == 1) ? 'checked' : '';
$invoiceentrie_add = ($invoiceentrie['add'] == 1) ? 'checked' : '';
$invoiceentrie_edit = ($invoiceentrie['edit'] == 1) ? 'checked' : '';
$invoiceentrie_view = ($invoiceentrie['view'] == 1) ? 'checked' : '';
$invoiceentrie_delete = ($invoiceentrie['delete'] == 1) ? 'checked' : '';
$invoiceentrie_pdf = ($invoiceentrie['pdf'] == 1) ? 'checked' : '';
$invoiceentrie_excel = ($invoiceentrie['excel'] == 1) ? 'checked' : '';
$invoiceentrie_print = ($invoiceentrie['print'] == 1) ? 'checked' : '';
 
// Invoice
$invoice = $rules['invoices'];
$invoice_index = ($invoice['index'] == 1) ? 'checked' : '';
$invoice_payment = ($invoice['payment'] == 1) ? 'checked' : '';
$invoice_delivery = ($invoice['delivery'] == 1) ? 'checked' : '';
$invoice_add = ($invoice['add'] == 1) ? 'checked' : '';
$invoice_edit = ($invoice['edit'] == 1) ? 'checked' : '';
$invoice_view = ($invoice['view'] == 1) ? 'checked' : '';
$invoice_delete = ($invoice['delete'] == 1) ? 'checked' : '';
$invoice_pdf = ($invoice['pdf'] == 1) ? 'checked' : '';
$invoice_excel = ($invoice['excel'] == 1) ? 'checked' : '';
$invoice_print = ($invoice['print'] == 1) ? 'checked' : '';
$invoice_printOut = ($invoice['printOut'] == 1) ? 'checked' : '';
$invoice_child = ($invoice['child'] == 1) ? 'checked' : '';
$invoice_child_edit = ($invoice['childEdit'] == 1) ? 'checked' : '';
$invoice_child_view = ($invoice['childView'] == 1) ? 'checked' : '';
$invoice_child_delete = ($invoice['childDelete'] == 1) ? 'checked' : '';
$invoice_child_print = ($invoice['childPrint'] == 1) ? 'checked' : '';
$invoice_child_printOut = ($invoice['childPrintOut'] == 1) ? 'checked' : '';

// Items
$item = $rules['items'];
$item_index = ($item['index'] == 1) ? 'checked' : '';
$item_add = ($item['add'] == 1) ? 'checked' : '';
$item_edit = ($item['edit'] == 1) ? 'checked' : '';
$item_view = ($item['view'] == 1) ? 'checked' : '';
$item_delete = ($item['delete'] == 1) ? 'checked' : '';
$item_pdf = ($item['pdf'] == 1) ? 'checked' : '';
$item_excel = ($item['excel'] == 1) ? 'checked' : '';
$item_template = ($item['template'] == 1) ? 'checked' : '';
$item_dataExportImport = ($item['dataExportImport'] == 1) ? 'checked' : '';

// Supplier
$supplier = $rules['suppliers'];
$supplier_index = ($supplier['index'] == 1) ? 'checked' : '';
$supplier_add = ($supplier['add'] == 1) ? 'checked' : '';
$supplier_view = ($supplier['view'] == 1) ? 'checked' : '';
$supplier_edit = ($supplier['edit'] == 1) ? 'checked' : '';
$supplier_delete = ($supplier['delete'] == 1) ? 'checked' : '';
$supplier_pdf = ($supplier['pdf'] == 1) ? 'checked' : '';
$supplier_excel = ($supplier['excel'] == 1) ? 'checked' : '';
$supplier_changestatus = ($supplier['changestatus'] == 1) ? 'checked' : '';

// Gudang
$warehouse = $rules['warehouses'];
$warehouse_index = ($warehouse['index'] == 1) ? 'checked' : '';
$warehouse_add = ($warehouse['add'] == 1) ? 'checked' : '';
$warehouse_view = ($warehouse['view'] == 1) ? 'checked' : '';
$warehouse_edit = ($warehouse['edit'] == 1) ? 'checked' : '';
$warehouse_delete = ($warehouse['delete'] == 1) ? 'checked' : '';
$warehouse_pdf = ($warehouse['pdf'] == 1) ? 'checked' : '';
$warehouse_excel = ($warehouse['excel'] == 1) ? 'checked' : '';

// Stok Gudang
$warehousestock = $rules['warehousestocks'];
$warehousestock_index = ($warehousestock['index'] == 1) ? 'checked' : '';
$warehousestock_add = ($warehousestock['add'] == 1) ? 'checked' : '';
$warehousestock_view = ($warehousestock['view'] == 1) ? 'checked' : '';
$warehousestock_edit = ($warehousestock['edit'] == 1) ? 'checked' : '';
$warehousestock_delete = ($warehousestock['delete'] == 1) ? 'checked' : '';
$warehousestock_pdf = ($warehousestock['pdf'] == 1) ? 'checked' : '';
$warehousestock_excel = ($warehousestock['excel'] == 1) ? 'checked' : '';

// Penawaran
$offers = $rules['offers'];
$offers_index = ($offers['index'] == 1) ? 'checked' : '';
$offers_add = ($offers['add'] == 1) ? 'checked' : '';
$offers_edit = ($offers['edit'] == 1) ? 'checked' : '';
$offers_view = ($offers['view'] == 1) ? 'checked' : '';
$offers_delete = ($offers['delete'] == 1) ? 'checked' : '';
$offers_approve = ($offers['approve'] == 1) ? 'checked' : '';
$offers_pdf = ($offers['pdf'] == 1) ? 'checked' : '';
$offers_excel = ($offers['excel'] == 1) ? 'checked' : ''; 
$offers_print = ($offers['print'] == 1) ? 'checked' : '';
$offers_printOut = ($offers['printOut'] == 1) ? 'checked' : '';

// No. Surat
$letters = $rules['letters'];
$letters_index = ($letters['index'] == 1) ? 'checked' : '';
$letters_add = ($letters['add'] == 1) ? 'checked' : '';
$letters_edit = ($letters['edit'] == 1) ? 'checked' : '';
$letters_view = ($letters['view'] == 1) ? 'checked' : '';
$letters_delete = ($letters['delete'] == 1) ? 'checked' : '';
$letters_approve = ($letters['approve'] == 1) ? 'checked' : '';
$letters_pdf = ($letters['pdf'] == 1) ? 'checked' : '';
$letters_excel = ($letters['excel'] == 1) ? 'checked' : ''; 

// Tanda Terima
$tandaterima = $rules['tandaterima'];
$tandaterima_index = ($tandaterima['index'] == 1) ? 'checked' : '';
$tandaterima_add = ($tandaterima['add'] == 1) ? 'checked' : '';
$tandaterima_edit = ($tandaterima['edit'] == 1) ? 'checked' : '';
$tandaterima_view = ($tandaterima['view'] == 1) ? 'checked' : '';
$tandaterima_delete = ($tandaterima['delete'] == 1) ? 'checked' : '';
$tandaterima_approve = ($tandaterima['approve'] == 1) ? 'checked' : '';
$tandaterima_pdf = ($tandaterima['pdf'] == 1) ? 'checked' : '';
$tandaterima_excel = ($tandaterima['excel'] == 1) ? 'checked' : ''; 
$tandaterima_print = ($tandaterima['print'] == 1) ? 'checked' : ''; 

?>
<?= $this->Form->create($users) ?>
<div class="row">
    <!-- begin col-6 -->
    <div class="col-lg-4">
        <div class="card border-0">
            <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center">
                <i class="fa fa-user-alt fa-lg me-2 text-gray text-opacity-50"></i>
                User
            </div>
            <div class="card-body">
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Code</label>
                    <div class="col-md-9">
                        <?php
                        echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                        echo $this->Form->control('code', ['label' => false, 'class' => 'form-control-plaintext', 'placeholder' => 'Kode..', 'value' => $users->code, 'disabled' => true]); ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Nama</label>
                    <div class="col-md-9">
                        <?php
                        echo $this->Form->control('name', ['label' => false, 'class' => 'form-control-plaintext', 'placeholder' => 'Nama..', 'value' => $users->name, 'disabled' => true]); ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Email</label>
                    <div class="col-md-9">
                        <?php
                        echo $this->Form->control('email', ['label' => false, 'class' => 'form-control-plaintext', 'placeholder' => 'Email..', 'value' => $users->email, 'disabled' => true]); ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-2">Devisi</label>
                    <div class="col-md-10">
                        <?php
                        // pr($this->Krs->devision());
                        $defaultDevision = explode(",", $users->devision);
                        echo $this->Form->control('devision', array('label' => false, 'empty' => false, 'options' => $this->Krs->devision(), 'data-placeholder' => 'Silakan pilih..', 'class' => 'form-control select2Form', 'error' => false, "default" => $defaultDevision));
                        ?>
                    </div>
                </div>

                <div class="form-group row m-b-15 align-items-center">
                    <label class="col-form-label col-md-2">Aktif</label>
                    <div class="col-md-10">
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedBlock = ($users->is_active == 'Y') ? "checked" : false;
                            echo $this->Form->checkbox('is_active', [
                                'value' => 'Y',
                                'hiddenField' => 'N',
                                'class' => 'form-check-input',
                                'id' => 'defaultCheckbox',
                                'checked' => $checkedBlock
                            ]);

                            // echo $this->Form->hidden('is_active', array('value' => 'N'));
                            // echo $this->Form->input('is_active', array('hiddenField' => false, 'value' => 'Y', 'id' => 'defaultCheckbox', 'type' => 'checkbox', 'class' => 'form-check-input', 'checked' => $checkedBlock));
                            ?>
                            <label class="form-check-label" for="defaultCheckbox">&nbsp;</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row m-b-15 align-items-center">
                    <label class="col-form-label col-md-2">Petty Cash</label>
                    <div class="col-md-10">
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedApproved1 = ($users->approved == 'Y') ? "checked" : false;
                            echo $this->Form->checkbox('approved', [
                                'value' => 'Y',
                                'hiddenField' => 'N',
                                'class' => 'form-check-input',
                                'id' => 'checkbox-inline-1',
                                'checked' => $checkedApproved1
                            ]);

                            // echo $this->Form->hidden('approved', array('value' => 'N'));
                            // echo $this->Form->input('approved', array('hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox', 'class'=>'form-check-input', 'id'=>'checkbox-inline-1', 'checked'=>$checkedApproved1));
                            ?>
                            <label class="form-check-label" for="checkbox-inline-1">Approved 1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedApproved2 = ($users->approved_ceo == 'Y') ? "checked" : false;
                            echo $this->Form->checkbox('approved_ceo', [
                                'value' => 'Y',
                                'hiddenField' => 'N',
                                'class' => 'form-check-input',
                                'id' => 'checkbox-inline-2',
                                'checked' => $checkedApproved2
                            ]);

                            // echo $this->Form->hidden('approved_ceo', array('value' => 'N'));
                            // echo $this->Form->input('approved_ceo', array('hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox', 'class'=>'form-check-input', 'id'=>'checkbox-inline-2', 'checked'=>$checkedApproved2));
                            ?>
                            <label class="form-check-label" for="checkbox-inline-2">Approved 2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedPayment = ($users->payment == 'Y') ? "checked" : false;
                            echo $this->Form->checkbox('payment', [
                                'value' => 'Y',
                                'hiddenField' => 'N',
                                'class' => 'form-check-input',
                                'id' => 'checkbox-inline-3',
                                'checked' => $checkedPayment
                            ]);

                            // echo $this->Form->hidden('payment', array('value' => 'N'));
                            // echo $this->Form->input('payment', array('hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox', 'class'=>'form-check-input', 'id'=>'checkbox-inline-2', 'checked'=>$checkedPayment));
                            ?>
                            <label class="form-check-label" for="checkbox-inline-3">Pembayaran</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedFullAccess = ($users->pettycash_full_access == 'Y') ? "checked" : false;
                            echo $this->Form->checkbox('pettycash_full_access', [
                                'value' => 'Y',
                                'hiddenField' => 'N',
                                'class' => 'form-check-input',
                                'id' => 'checkbox-inline-4',
                                'checked' => $checkedFullAccess
                            ]);

                            // echo $this->Form->hidden('pettycash_full_access', array('value' => 'N'));
                            // echo $this->Form->input('pettycash_full_access', array('hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox', 'class'=>'form-check-input', 'id'=>'checkbox-inline-2', 'checked'=>$checkedFullAccess));
                            ?>
                            <label class="form-check-label" for="checkbox-inline-4">Full Akses</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-2">Cabang</label>
                    <div class="col-md-10">
                        <?php
                        $dataBranch = explode(",", $users->branch_id); 

                        echo $this->Form->control('branch_ids', array('label' => false, 'empty' => false, 'options' => $branch, 'data-placeholder' => 'Cabang..', 'class' => 'form-control select2Form', 'error' => false, 'multiple' => true, "default" => $dataBranch));
                        ?>
                    </div> 
                </div>
            </div>
            <div class="card-footer bg-none d-flex p-3">
                <?php
                // hidden auth
                echo $this->Form->control('Rule.auth.login', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.auth.logout', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.auth.index', ['type' => 'hidden', 'value' =>  '1']);

                // home
                echo $this->Form->control('Rule.home.index', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.home.chart', ['type' => 'hidden', 'value' =>  '1']);

                // home
                echo $this->Form->control('Rule.home.index', ['type' => 'hidden', 'value' =>  '1']);

                // 
                echo $this->Form->control('Rule.branchstocks.getitem', ['type' => 'hidden', 'value' =>  '1']);
                
                // order
                echo $this->Form->control('Rule.orders.getitem', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.orders.struck', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.orders.setitem', ['type' => 'hidden', 'value' =>  '1']);

                // receipt 
                echo $this->Form->control('Rule.receipts.setkwitansi', ['type' => 'hidden', 'value' =>  '1']);

                // invoice 
                echo $this->Form->control('Rule.invoices.getOrder', ['type' => 'hidden', 'value' =>  '1']);

                // invoice masuk
                echo $this->Form->control('Rule.invoiceentries.getpo', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.invoiceentries.setpo', ['type' => 'hidden', 'value' =>  '1']);

                // retur customer
                echo $this->Form->control('Rule.returs.getorder', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.returs.setorder', ['type' => 'hidden', 'value' =>  '1']);

                // retur supplier
                echo $this->Form->control('Rule.retursuppliers.getorder', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.retursuppliers.setorder', ['type' => 'hidden', 'value' =>  '1']);

                // purchase
                echo $this->Form->control('Rule.purchasings.getitem', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.purchasings.setitem', ['type' => 'hidden', 'value' =>  '1']);

                // surat jalan
                echo $this->Form->control('Rule.permits.getorder', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.permits.setorder', ['type' => 'hidden', 'value' =>  '1']);

                // surat jalan
                echo $this->Form->control('Rule.tandaterima.getinvoice', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.tandaterima.setinvoice', ['type' => 'hidden', 'value' =>  '1']);

                // in gudang
                echo $this->Form->control('Rule.goodsinwarehouses.getpo', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.goodsinwarehouses.getsout', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.goodsinwarehouses.getwhout', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.goodsinwarehouses.setpo', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.goodsinwarehouses.setsout', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.goodsinwarehouses.setwhout', ['type' => 'hidden', 'value' =>  '1']);

                // out gudang
                echo $this->Form->control('Rule.goodsoutwarehouses.getitem', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.goodsoutwarehouses.setitem', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.goodsoutwarehouses.getorder', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.goodsoutwarehouses.setorder', ['type' => 'hidden', 'value' =>  '1']);

                // stok gudang
                echo $this->Form->control('Rule.warehousestocks.getitem', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.warehousestocks.setitem', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.warehousestocks.getitemlines', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.warehousestocks.setitemlines', ['type' => 'hidden', 'value' =>  '1']);

                // in store
                echo $this->Form->control('Rule.goodsinstores.getwhout', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.goodsinstores.setwhout', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.goodsinstores.getsout', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.goodsinstores.setsout', ['type' => 'hidden', 'value' =>  '1']);

                // out store
                echo $this->Form->control('Rule.goodsoutstores.getitem', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.goodsoutstores.setitem', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rule.goodsoutstores.getretur', ['type' => 'hidden', 'value' =>  '1']);

                echo $this->Form->control('Rule.customers.getkabupaten', ['type' => 'hidden', 'value' =>  '1']); 

                echo $this->Form->button('Simpan', ['class' => 'btn btn-primary ms-auto', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0">
            <ul class="nav nav-tabs nav-tabs-v2 px-3">
                <li class="nav-item me-2"><a href="#" id="master-tab" class="nav-link px-2 active" data-bs-toggle="tab" data-bs-target="#master" role="tab" aria-controls="master" aria-selected="true">Data Master</a></li>
                <li class="nav-item me-2"><a href="#" id="transaction-tab" class="nav-link px-2" data-bs-toggle="tab" data-bs-target="#transaction" role="tab" aria-controls="transaction" aria-selected="false">Transaksi</a></li>
                <li class="nav-item me-2"><a href="#" id="setting-tab" class="nav-link px-2" data-bs-toggle="tab" data-bs-target="#setting" role="tab" aria-controls="setting" aria-selected="false">Setting</a></li>
            </ul>
            <div class="tab-content p-3">
                <div class="tab-pane fade show active" id="master" aria-labelledby="master-tab">
                    <div class="table-responsive mb-3">
                        <table class="table table-hover table-panel text-nowrap align-middle mb-0">
                            <thead>
                                <tr>
                                    <th width="180">Halaman</th>
                                    <th>Akses</th>
                                </tr>
                            </thead>
                            <tbody>

                            	<tr>
                                    <td>Negara</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.country.index', ['value' => '1', 'hiddenField' => true, 'checked' => $country_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.country.add', ['value' => '1', 'hiddenField' => true, 'checked' => $country_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.country.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $country_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.country.view', ['value' => '1', 'hiddenField' => true, 'checked' => $country_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.country.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $country_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.country.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $country_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.country.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $country_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.country.changestatus', ['value' => '1', 'hiddenField' => true, 'checked' => $country_changestatus, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Status</label>
                                            </div>
                                            <div class="form-check form-check-inline">
		                                        <?php
		                                        echo $this->Form->checkbox('Rule.country.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $country_dataExportImport, 'class' => 'form-check-input']);
		                                        ?>
		                                        <label class="form-check-label">Import (Data Excel)</label>
		                                    </div>
                                            
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Area</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.area.index', ['value' => '1', 'hiddenField' => true, 'checked' => $area_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.area.add', ['value' => '1', 'hiddenField' => true, 'checked' => $area_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.area.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $area_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.area.view', ['value' => '1', 'hiddenField' => true, 'checked' => $area_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.area.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $area_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.area.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $area_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.area.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $area_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.area.changestatus', ['value' => '1', 'hiddenField' => true, 'checked' => $area_changestatus, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Status</label>
                                            </div>
                                            <div class="form-check form-check-inline">
		                                        <?php
		                                        echo $this->Form->checkbox('Rule.area.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $area_dataExportImport, 'class' => 'form-check-input']);
		                                        ?>
		                                        <label class="form-check-label">Import (Data Excel)</label>
		                                    </div>
                                            
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Kategori</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.categories.index', ['value' => '1', 'hiddenField' => true, 'checked' => $category_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.categories.add', ['value' => '1', 'hiddenField' => true, 'checked' => $category_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.categories.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $category_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.categories.view', ['value' => '1', 'hiddenField' => true, 'checked' => $category_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.categories.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $category_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.categories.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $category_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.categories.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $category_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Satuan</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.unit.index', ['value' => '1', 'hiddenField' => true, 'checked' => $unit_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.unit.add', ['value' => '1', 'hiddenField' => true, 'checked' => $unit_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.unit.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $unit_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.unit.view', ['value' => '1', 'hiddenField' => true, 'checked' => $unit_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.unit.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $unit_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.unit.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $unit_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.unit.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $unit_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Pelanggan</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.customers.index', ['value' => '1', 'hiddenField' => true, 'checked' => $customer_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.customers.add', ['value' => '1', 'hiddenField' => true, 'checked' => $customer_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.customers.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $customer_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.customers.view', ['value' => '1', 'hiddenField' => true, 'checked' => $customer_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.customers.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $customer_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.customers.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $customer_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.customers.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $customer_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.customers.changestatus', ['value' => '1', 'hiddenField' => true, 'checked' => $customer_changestatus, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Status</label>
                                            </div>
                                            
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Member</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.members.index', ['value' => '1', 'hiddenField' => true, 'checked' => $member_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.members.add', ['value' => '1', 'hiddenField' => true, 'checked' => $member_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.members.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $member_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.members.view', ['value' => '1', 'hiddenField' => true, 'checked' => $member_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.members.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $member_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.members.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $member_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.members.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $member_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mou</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.mouses.index', ['value' => '1', 'hiddenField' => true, 'checked' => $mou_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.mouses.add', ['value' => '1', 'hiddenField' => true, 'checked' => $mou_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.mouses.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $mou_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.mouses.view', ['value' => '1', 'hiddenField' => true, 'checked' => $mou_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.mouses.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $mou_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.mouses.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $mou_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.mouses.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $mou_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.mouses.changestatus', ['value' => '1', 'hiddenField' => true, 'checked' => $mou_changestatus, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Status</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Truk</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.trucks.index', ['value' => '1', 'hiddenField' => true, 'checked' => $truck_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.trucks.add', ['value' => '1', 'hiddenField' => true, 'checked' => $truck_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.trucks.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $truck_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.trucks.view', ['value' => '1', 'hiddenField' => true, 'checked' => $truck_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.trucks.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $truck_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.trucks.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $truck_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.trucks.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $truck_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.trucks.changestatus', ['value' => '1', 'hiddenField' => true, 'checked' => $truck_changestatus, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Status</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Produk</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.items.index', ['value' => '1', 'hiddenField' => true, 'checked' => $item_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.items.add', ['value' => '1', 'hiddenField' => true, 'checked' => $item_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.items.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $item_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.items.view', ['value' => '1', 'hiddenField' => true, 'checked' => $item_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.items.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $item_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.items.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $item_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.items.template', ['value' => '1', 'hiddenField' => true, 'checked' => $item_template, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Template Farmalkes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.items.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $item_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
		                                        <?php
		                                        echo $this->Form->checkbox('Rule.items.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $item_dataExportImport, 'class' => 'form-check-input']);
		                                        ?>
		                                        <label class="form-check-label">Import (Data Excel)</label>
		                                    </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Supplier</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.suppliers.index', ['value' => '1', 'hiddenField' => true, 'checked' => $supplier_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.suppliers.add', ['value' => '1', 'hiddenField' => true, 'checked' => $supplier_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.suppliers.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $supplier_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.suppliers.view', ['value' => '1', 'hiddenField' => true, 'checked' => $supplier_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.suppliers.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $supplier_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.suppliers.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $supplier_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Pdf</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.suppliers.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $supplier_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.suppliers.changestatus', ['value' => '1', 'hiddenField' => true, 'checked' => $supplier_changestatus, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Status</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gudang</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.warehouses.index', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouse_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.warehouses.add', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouse_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.warehouses.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouse_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.warehouses.view', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouse_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.warehouses.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouse_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.warehouses.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouse_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Pdf</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.warehouses.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouse_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Produk Gudang</td>
                                    <td>
                                        <div class="col-md-12">

                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.warehousestocks.index', ['value' => '1', 'hiddenField' => true, 'checked' => $warehousestock_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.warehousestocks.add', ['value' => '1', 'hiddenField' => true, 'checked' => $warehousestock_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.warehousestocks.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $warehousestock_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.warehousestocks.view', ['value' => '1', 'hiddenField' => true, 'checked' => $warehousestock_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.warehousestocks.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $warehousestock_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.warehousestocks.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $warehousestock_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Pdf</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.warehousestocks.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $warehousestock_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="transaction" aria-labelledby="transaction-tab">
                    <div class="table-responsive mb-3">
                        <table class="table table-hover table-panel text-nowrap align-middle mb-0">
                            <thead>
                                <tr>
                                    <th width="180">Halaman</th>
                                    <th>Akses</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>Penawaran</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.offers.index', ['value' => '1', 'hiddenField' => true, 'checked' => $offers_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.offers.add', ['value' => '1', 'hiddenField' => true, 'checked' => $offers_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.offers.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $offers_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.offers.view', ['value' => '1', 'hiddenField' => true, 'checked' => $offers_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.offers.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $offers_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.offers.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $offers_approve, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Approve</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.offers.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $offers_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.offers.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $offers_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.offers.print', ['value' => '1', 'hiddenField' => true, 'checked' => $offers_print, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Cetak (header footer)</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.offers.printOut', ['value' => '1', 'hiddenField' => true, 'checked' => $offers_printOut, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Cetak (tanpa header footer)</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>No. Surat</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.letters.index', ['value' => '1', 'hiddenField' => true, 'checked' => $letters_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.letters.add', ['value' => '1', 'hiddenField' => true, 'checked' => $letters_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.letters.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $letters_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.letters.view', ['value' => '1', 'hiddenField' => true, 'checked' => $letters_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.letters.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $letters_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.letters.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $letters_approve, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Approve</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.letters.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $letters_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.letters.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $letters_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Tanda Terima</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.tandaterima.index', ['value' => '1', 'hiddenField' => true, 'checked' => $tandaterima_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.tandaterima.add', ['value' => '1', 'hiddenField' => true, 'checked' => $tandaterima_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.tandaterima.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $tandaterima_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.tandaterima.view', ['value' => '1', 'hiddenField' => true, 'checked' => $tandaterima_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.tandaterima.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $tandaterima_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.tandaterima.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $tandaterima_approve, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Approve</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.tandaterima.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $tandaterima_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.tandaterima.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $tandaterima_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.tandaterima.print', ['value' => '1', 'hiddenField' => true, 'checked' => $tandaterima_print, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Cetak</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Order</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.orders.index', ['value' => '1', 'hiddenField' => true, 'checked' => $orders_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.orders.add', ['value' => '1', 'hiddenField' => true, 'checked' => $orders_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.orders.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $orders_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.orders.view', ['value' => '1', 'hiddenField' => true, 'checked' => $orders_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.orders.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $orders_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.orders.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $orders_approve, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Approve</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.orders.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $orders_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.orders.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $orders_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Kwitansi</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.receipts.index', ['value' => '1', 'hiddenField' => true, 'checked' => $receipts_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.receipts.add', ['value' => '1', 'hiddenField' => true, 'checked' => $receipts_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.receipts.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $receipts_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.receipts.view', ['value' => '1', 'hiddenField' => true, 'checked' => $receipts_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.receipts.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $receipts_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.receipts.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $receipts_approve, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Approve</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.receipts.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $receipts_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.receipts.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $receipts_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.receipts.print', ['value' => '1', 'hiddenField' => true, 'checked' => $receipts_print, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Cetak (header footer)</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.receipts.printOut', ['value' => '1', 'hiddenField' => true, 'checked' => $receipts_printOut, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Cetak (tanpa header footer)</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Retur Customer</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.returs.index', ['value' => '1', 'hiddenField' => true, 'checked' => $retur_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.returs.add', ['value' => '1', 'hiddenField' => true, 'checked' => $retur_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.returs.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $retur_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.returs.view', ['value' => '1', 'hiddenField' => true, 'checked' => $retur_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.returs.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $retur_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.returs.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $retur_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.returs.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $retur_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Retur Supplier</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.retursuppliers.index', ['value' => '1', 'hiddenField' => true, 'checked' => $retursupplier_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.retursuppliers.add', ['value' => '1', 'hiddenField' => true, 'checked' => $retursupplier_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.retursuppliers.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $retursupplier_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.retursuppliers.view', ['value' => '1', 'hiddenField' => true, 'checked' => $retursupplier_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.retursuppliers.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $retursupplier_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.retursuppliers.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $retursupplier_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.retursuppliers.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $retursupplier_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Pembelian</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.purchasings.index', ['value' => '1', 'hiddenField' => true, 'checked' => $purchasing_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.purchasings.add', ['value' => '1', 'hiddenField' => true, 'checked' => $purchasing_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.purchasings.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $purchasing_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.purchasings.view', ['value' => '1', 'hiddenField' => true, 'checked' => $purchasing_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.purchasings.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $purchasing_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.purchasings.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $purchasing_approve, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Approve</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.purchasings.cancel', ['value' => '1', 'hiddenField' => true, 'checked' => $purchasing_cancel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Batal</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.purchasings.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $purchasing_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.purchasings.print', ['value' => '1', 'hiddenField' => true, 'checked' => $purchasing_print, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Print (Indonesia)</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.purchasings.printEnglish', ['value' => '1', 'hiddenField' => true, 'checked' => $purchasing_print_english, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Print (English)</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>In Gudang</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsinwarehouses.index', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsinwarehouses_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsinwarehouses.add', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsinwarehouses_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsinwarehouses.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsinwarehouses_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsinwarehouses.view', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsinwarehouses_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsinwarehouses.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsinwarehouses_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsinwarehouses.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsinwarehouses_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsinwarehouses.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsinwarehouses_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Out Gudang</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutwarehouses.index', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutwarehouses_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutwarehouses.delivery', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutwarehouses_delivery, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Pengiriman</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutwarehouses.add', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutwarehouses_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutwarehouses.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutwarehouses_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutwarehouses.view', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutwarehouses_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutwarehouses.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutwarehouses_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutwarehouses.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutwarehouses_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutwarehouses.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutwarehouses_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>In Toko/Cabang</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsinstores.index', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsinstores_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsinstores.add', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsinstores_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsinstores.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsinstores_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsinstores.view', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsinstores_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsinstores.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsinstores_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsinstores.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsinstores_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsinstores.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsinstores_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Out Toko/Cabang</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutstores.index', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutstores_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutstores.add', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutstores_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutstores.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutstores_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutstores.view', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutstores_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutstores.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutstores_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutstores.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutstores_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.goodsoutstores.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $goodsoutstores_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Stok Cabang</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branchstocks.index', ['value' => '1', 'hiddenField' => true, 'checked' => $branchstock_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branchstocks.add', ['value' => '1', 'hiddenField' => true, 'checked' => $branchstock_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branchstocks.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $branchstock_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branchstocks.view', ['value' => '1', 'hiddenField' => true, 'checked' => $branchstock_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branchstocks.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $branchstock_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branchstocks.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $branchstock_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branchstocks.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $branchstock_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Surat Jalan</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.permits.index', ['value' => '1', 'hiddenField' => true, 'checked' => $permit_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.permits.add', ['value' => '1', 'hiddenField' => true, 'checked' => $permit_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.permits.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $permit_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.permits.view', ['value' => '1', 'hiddenField' => true, 'checked' => $permit_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.permits.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $permit_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.permits.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $permit_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.permits.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $permit_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.permits.print', ['value' => '1', 'hiddenField' => true, 'checked' => $permit_print, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Cetak</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Invoice Masuk</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoiceentries.index', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceentrie_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoiceentries.payment', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceentrie_payment, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Pembayaran</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoiceentries.add', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceentrie_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoiceentries.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceentrie_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoiceentries.view', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceentrie_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoiceentries.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceentrie_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoiceentries.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceentrie_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoiceentries.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceentrie_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoiceentries.print', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceentrie_print, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Cetak</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Invoice</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.index', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.payment', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_payment, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Pembayaran</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.delivery', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_delivery, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Pengiriman</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.add', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.view', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.print', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_print, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Cetak (header footer)</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.printOut', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_printOut, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Cetak (tanpa header footer)</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Invoice Proforma</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.child', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_child, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat Proforma</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.childEdit', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_child_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah Proforma</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.childView', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_child_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View Proforma</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.childDelete', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_child_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus Proforma</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.childPrint', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_child_print, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Cetak (header footer)</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.invoices.childPrintOut', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_child_printOut, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Cetak (tanpa header footer)</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Petty Cash</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.pettycashes.index', ['value' => '1', 'hiddenField' => true, 'checked' => $pettycash_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.pettycashes.add', ['value' => '1', 'hiddenField' => true, 'checked' => $pettycash_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.pettycashes.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $pettycash_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.pettycashes.editAll', ['value' => '1', 'hiddenField' => true, 'checked' => $pettycash_editAll, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah Semua</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.pettycashes.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $pettycash_approve, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Setuju 1</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.pettycashes.approveCeo', ['value' => '1', 'hiddenField' => true, 'checked' => $pettycash_approve_ceo, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Setuju 2</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.pettycashes.payment', ['value' => '1', 'hiddenField' => true, 'checked' => $pettycash_payment, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Pembayaran</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.pettycashes.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $pettycash_preview, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Tampilkan</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.pettycashes.printing', ['value' => '1', 'hiddenField' => true, 'checked' => $pettycash_printing, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Cetak</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.pettycashes.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $pettycash_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.pettycashes.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $pettycash_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.pettycashes.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $pettycash_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Delete</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="setting" aria-labelledby="setting-tab">
                    <div class="table-responsive mb-3">
                        <table class="table table-hover table-panel text-nowrap align-middle mb-0">
                            <thead>
                                <tr>
                                    <th width="180">Halaman</th>
                                    <th>Akses</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>User</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.users.index', ['value' => '1', 'hiddenField' => true, 'checked' => $user_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.users.add', ['value' => '1', 'hiddenField' => true, 'checked' => $user_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.users.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $user_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.users.change', ['value' => '1', 'hiddenField' => true, 'checked' => $user_change, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah Password</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.users.reset', ['value' => '1', 'hiddenField' => true, 'checked' => $user_reset, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Reset</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.users.access', ['value' => '1', 'hiddenField' => true, 'checked' => $user_access, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hak Akses</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.users.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $user_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.users.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $user_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.users.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $user_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Cabang</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branches.index', ['value' => '1', 'hiddenField' => true, 'checked' => $branch_index, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Daftar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branches.add', ['value' => '1', 'hiddenField' => true, 'checked' => $branch_add, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Buat</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branches.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $branch_edit, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Ubah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branches.view', ['value' => '1', 'hiddenField' => true, 'checked' => $branch_view, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branches.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $branch_delete, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Hapus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branches.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $branch_pdf, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branches.excel', ['value' => '1', 'hiddenField' => true, 'checked' => $branch_excel, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                echo $this->Form->checkbox('Rule.branches.changestatus', ['value' => '1', 'hiddenField' => true, 'checked' => $branch_changestatus, 'class' => 'form-check-input']);
                                                ?>
                                                <label class="form-check-label">Status</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>
<script>
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['controller' => 'users', 'action' => 'access', $users->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $(".select2Form").select2();

    });
</script> 
