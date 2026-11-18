<?php
// Memanggil action yang aktif
$action = $this->request->getParam('action');

// Memanggil controller yang aktif
$controller = $this->request->getParam('controller');

$menuDashboard = ($getController == 'home') ? 'active' : '';
$menuUserChangePassword = ($getController == 'Users' && $action == 'change_password') ? ' class="active"' : '';

if (empty($getController)) {

    $users = array();
    $items = array();
    $categories = array();
    $suppliers = array();
    $members = array();
    $customers = array();
    $warehouses = array();
    $branches = array();
    $trucks = array();
    $mouses = array();
    $warehousestocks = array();
    $branchstocks = array();
    $country = array();
    $area = array();
    $unit = array();

    $offers = array();
    $letters = array();
    $tandaterima = array();
    $orders = array();
    $receipts = array();
    $permits = array();
    $returs = array();
    $retursupplier = array();
    $purchasings = array();
    $goodsinwarehouses = array();
    $goodsoutwarehouses = array();
    $goodsinstores = array();

    $invoiceentries = array();
    $invoices = array();
    $pettycashes = array();
    $pettycashbooks = array();
} else {

    $users = $checkUrl['users'];
    $items = $checkUrl['items'];
    $categories = $checkUrl['categories'];
    $suppliers = $checkUrl['suppliers'];
    $members = $checkUrl['members'];
    $customers = $checkUrl['customers'];
    $warehouses = $checkUrl['warehouses'];
    $branches = $checkUrl['branches'];
    $trucks = $checkUrl['trucks'];
    $mouses = $checkUrl['mouses'];
    $warehousestocks = $checkUrl['warehousestocks'];
    $branchstocks = $checkUrl['branchstocks'];
    $country = $checkUrl['country'];
    $area = $checkUrl['area'];
    $unit = $checkUrl['unit'];

    $offers = $checkUrl['offers'];
    $letters = $checkUrl['letters'];
    $tandaterima = $checkUrl['tandaterima'];
    $orders = $checkUrl['orders'];
    $receipts = $checkUrl['receipts'];
    $permits = $checkUrl['permits'];
    $returs = $checkUrl['returs'];
    $retursupplier = $checkUrl['retursuppliers'];
    $purchasings = $checkUrl['purchasings'];
    $goodsinwarehouses = $checkUrl['goodsinwarehouses'];
    $goodsoutwarehouses = $checkUrl['goodsoutwarehouses'];
    $goodsinstores = $checkUrl['goodsinstores'];

    $invoiceentries = $checkUrl['invoiceentries'];
    $invoices = $checkUrl['invoices'];
    $pettycashes = $checkUrl['pettycashes'];
    $pettycashbooks = isset($checkUrl['pettycashbooks']) ? $checkUrl['pettycashbooks'] : array();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ionicons Example</title>

    <!-- CDN Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>

    <div id="sidebar" class="app-sidebar">

        <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">

            <div class="menu">
                <div class="menu-profile active">
                    <a href="javascript:;" class="menu-profile-link" data-toggle="app-sidebar-profile"
                        data-target="#appSidebarProfileMenu">
                        <div class="menu-profile-cover with-shadow"></div>
                        <div class="menu-profile-image">
                            <img src="<?= $this->request->getAttribute('webroot'); ?>img/user/user-12.jpg" alt="">
                        </div>
                        <div class="menu-profile-info">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <?= $getUser->code ?>
                                </div>
                            </div>
                            <small><?= $getUser->name ?></small>
                        </div>
                    </a>
                </div>
                <div class="menu-header"></div>
                <div class="menu-item <?= $menuDashboard ?>">
                    <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Home', 'action' => 'index']); ?>"
                        class="menu-link">
                        <div class="menu-icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </div>
                        <div class="menu-text">Dashboard</div>
                    </a>
                </div>
                <div class="menu-header">DAFTAR MENU</div>

                <?php
                if (!empty($pettycashbooks['index']) || $pettycashes['index'] == 1 || $purchasings['index'] == 1 || $letters['index'] == 1 || $tandaterima['index'] == 1 || $offers['index'] == 1 || $orders['index'] == 1 || $receipts['index'] == 1 || $returs['index'] == 1 || $retursupplier['index'] == 1 || $goodsoutwarehouses['delivery'] == 1 || $invoiceentries['add'] == 1 || $invoiceentries['payment'] == 1 || $invoices['add'] == 1 || $invoices['payment'] == 1 || $invoices['delivery'] == 1 || $permits['add'] == 1 || $orders['delivery'] == 1) {
                    $menuData = ($getController == 'purchasings' || $getController == 'orders' || $getController == 'receipts' || $getController == 'returs' || $getController == 'retursuppliers' || (($getController == 'goodsoutwarehouses') && ($getAction == 'delivery')) || (($getController == 'invoices') && ($getAction == 'add' || $getAction == 'payment' || $getAction == 'delivery')) || (($getController == 'invoiceentries') && ($getAction == 'add' || $getAction == 'payment' || $getAction == 'edit' || $getAction == 'view' || $getAction == 'index')) || (($getController == 'permits') && ($getAction == 'add'))) ? 'active' : '';

                    $menuLetter = (($getController == 'letters')) ? 'active' : '';
                    $menuTandaTerima = (($getController == 'tandaterima')) ? 'active' : '';
                    $menuOffer = (($getController == 'offers')) ? 'active' : '';
                    $menuOrder = (($getController == 'orders')) ? 'active' : '';
                    $menuReceipt = (($getController == 'receipts')) ? 'active' : '';

                    $menuKeuangan = ((($getController == 'pettycashes') && ($getAction == 'add' || $getAction == 'edit' || $getAction == 'view' || $getAction == 'index' || $getAction == 'payment' || $getAction == 'approve')) || $getController == 'pettycashbooks') ? 'active' : '';
                    $menuPettyCash = ($getController == 'pettycashes' && ($getAction == 'index' || $getAction == 'add' || $getAction == 'edit' || $getAction == 'payment' || $getAction == 'approve')) ? 'active' : '';
                    $menuBukuKas = ($getController == 'pettycashbooks') ? 'active' : '';

                    $menuMarketing = ($getController == 'offers' || $getController == 'letters' || $getController == 'tandaterima') ? 'active' : '';

                    $menuTransactionCustomer = (($getController == 'orders') || ($getController == 'receipts') || $getController == 'invoices' && ($getAction == 'add' || $getAction == 'payment' || $getAction == 'delivery') || ($getController == 'permits') || ($getController == 'goodsoutwarehouses') || ($getController == 'returs' && $getAction == 'add')) ? 'active' : '';

                    $menuTransactionSupplier = (($getController == 'purchasings') || ($getController == 'invoiceentries' && ($getAction == 'add' || $getAction == 'payment' || $getAction == 'edit' || $getAction == 'view' || $getAction == 'index')) || $getController == 'retursuppliers' && $getAction == 'add') ? 'active' : '';

                    $menuPurchasingSupplier = ($getController == 'purchasings') ? 'active' : '';

                    $menuPermits = (($getController == 'permits') || ($getController == 'goodsoutwarehouses' && $getAction == 'delivery')) ? 'active' : '';
                    $menuPermitAdd = (($getController == 'permits') && ($getAction == 'add')) ? 'active' : '';
                    $menuOrderDelivery = (($getController == 'goodsoutwarehouses' && $getAction == 'delivery')) ? 'active' : '';

                    $menuReturCustomer = ($getController == 'returs' && ($getAction == 'add') || ($getController == 'returs' && $getAction == 'index') || ($getController == 'returs' && $getAction == 'edit')) ? 'active' : '';

                    $menuReturSupplier = ($getController == 'retursuppliers' && ($getAction == 'add') || ($getController == 'retursuppliers' && $getAction == 'index') || ($getController == 'retursuppliers' && $getAction == 'edit')) ? 'active' : '';

                    $menuInvoiceEntries = ($getController == 'invoiceentries' && ($getAction == 'add' || $getAction == 'payment' || $getAction == 'edit' || $getAction == 'view' || $getAction == 'index')) ? 'active' : '';
                    $menuInvoiceEntriesAdd = ($getController == 'invoiceentries' && ($getAction == 'add')) ? 'active' : '';
                    $menuInvoiceEntriesPay = ($getController == 'invoiceentries' && ($getAction == 'payment')) ? 'active' : '';


                    $menuInvoices = ($getController == 'invoices') ? 'active' : '';
                    $menuInvoiceAdd = ($getController == 'invoices' && ($getAction == 'add')) ? 'active' : '';
                    $menuInvoiceDelivery = ($getController == 'invoices' && ($getAction == 'delivery')) ? 'active' : '';
                    $menuInvoicePayment = ($getController == 'invoices' && ($getAction == 'payment')) ? 'active' : '';
                    ?>

                    <div class="menu-item has-sub <?= $menuKeuangan ?>">
                        <a href="javascript:;" class="menu-link">
                            <div class="menu-icon">
                                <ion-icon name="cash-outline"></ion-icon>
                            </div>
                            <div class="menu-text">Keuangan </div>
                            <div class="menu-caret"></div>
                        </a>
                        <div class="menu-submenu">

                            <?php
                            if ($pettycashes['index'] == 1) { ?>
                                <div class="menu-item <?= $menuPettyCash ?>">
                                    <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'PettyCashes', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">Petty Cash</div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if (!empty($pettycashbooks['index'])) { ?>
                                <div class="menu-item <?= $menuBukuKas ?>">
                                    <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'PettyCashBooks', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">Buku Kas Kecil</div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>

                        </div>
                    </div>

                    <div class="menu-item has-sub <?= $menuMarketing ?>">
                        <a href="javascript:;" class="menu-link">
                            <div class="menu-icon">
                                <ion-icon name="grid-outline"></ion-icon>
                            </div>
                            <div class="menu-text">Data </div>
                            <div class="menu-caret"></div>
                        </a>
                        <div class="menu-submenu">

                            <?php
                            if ($offers['index'] == 1) { ?>
                                <div class="menu-item <?= $menuOffer ?>">
                                    <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Offers', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">Penawaran</div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if ($letters['index'] == 1) { ?>
                                <div class="menu-item <?= $menuLetter ?>">
                                    <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Letters', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">No. Surat</div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if ($tandaterima['index'] == 1) { ?>
                                <div class="menu-item <?= $menuTandaTerima ?>">
                                    <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'TandaTerima', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">Tanda Terima</div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>

                        </div>
                    </div>

                    <div class="menu-item has-sub <?= $menuData ?>">
                        <a href="javascript:;" class="menu-link">
                            <div class="menu-icon">
                                <ion-icon name="bar-chart-outline"></ion-icon>
                            </div>
                            <div class="menu-text">Transaksi </div>
                            <div class="menu-caret"></div>
                        </a>
                        <div class="menu-submenu">




                            <?php
                            if ($orders['index'] == 1) {
                                ?>
                                <div class="menu-item has-sub <?= $menuTransactionCustomer ?>">
                                    <a href="javascript:;" class="menu-link">
                                        <div class="menu-text">Customer </div>
                                        <div class="menu-caret"></div>
                                    </a>
                                    <div class="menu-submenu">
                                        <?php
                                        if ($orders['index'] == 1) { ?>
                                            <div class="menu-item <?= $menuOrder ?>">
                                                <a href="<?= $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Orders', 'action' => 'index']); ?>"
                                                    class="menu-link">
                                                    <div class="menu-text">Order</div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($invoices['add'] == 1) {
                                            ?>
                                            <div class="menu-item has-sub <?= $menuInvoices ?>">
                                                <a href="javascript:;" class="menu-link">
                                                    <div class="menu-text">Invoice</div>
                                                    <div class="menu-caret"></div>
                                                </a>
                                                <div class="menu-submenu">
                                                    <?php
                                                    if ($invoices['add'] == 1) {
                                                        ?>
                                                        <div class="menu-item <?= $menuInvoiceAdd ?>">
                                                            <a href="<?= $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Invoices', 'action' => 'add']); ?>"
                                                                class="menu-link">
                                                                <div class="menu-text">Buat</div>
                                                            </a>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($invoices['delivery'] == 1) {
                                                        ?>
                                                        <div class="menu-item <?= $menuInvoiceDelivery ?>">
                                                            <a href="<?= $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Invoices', 'action' => 'delivery']); ?>"
                                                                class="menu-link">
                                                                <div class="menu-text">Pengiriman</div>
                                                            </a>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($invoices['payment'] == 1) {
                                                        ?>
                                                        <div class="menu-item <?= $menuInvoicePayment ?>">
                                                            <a href="<?= $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Invoices', 'action' => 'payment']); ?>"
                                                                class="menu-link">
                                                                <div class="menu-text">Pembayaran</div>
                                                            </a>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($permits['add'] == 1 || $goodsoutwarehouses['delivery'] == 1) {
                                            ?>
                                            <div class="menu-item has-sub <?= $menuPermits ?>">
                                                <a href="javascript:;" class="menu-link">
                                                    <div class="menu-text">Surat Jalan </div>
                                                    <div class="menu-caret"></div>
                                                </a>
                                                <div class="menu-submenu">
                                                    <?php
                                                    if ($orders['index'] == 1) { ?>
                                                        <div class="menu-item <?= $menuPermitAdd ?>">
                                                            <a href="<?= $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Permits', 'action' => 'add']); ?>"
                                                                class="menu-link">
                                                                <div class="menu-text">Buat</div>
                                                            </a>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($goodsoutwarehouses['delivery'] == 1) { ?>
                                                        <div class="menu-item <?= $menuOrderDelivery ?>">
                                                            <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'GoodsOutWarehouses', 'action' => 'delivery']); ?>"
                                                                class="menu-link">
                                                                <div class="menu-text">Pengiriman</div>
                                                            </a>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($receipts['index'] == 1) { ?>
                                            <div class="menu-item <?= $menuReceipt ?>">
                                                <a href="<?= $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Receipts', 'action' => 'index']); ?>"
                                                    class="menu-link">
                                                    <div class="menu-text">Kwitansi</div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($returs['add'] == 1) { ?>
                                            <div class="menu-item <?= $menuReturCustomer ?>">
                                                <a href="<?= $this->Url->build(['prefix' => 'Transaction', 'controller' => 'Returs', 'action' => 'add']); ?>"
                                                    class="menu-link">
                                                    <div class="menu-text">Retur</div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        ?>


                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if ($purchasings['index'] == 1) {
                                ?>
                                <div class="menu-item has-sub <?= $menuTransactionSupplier ?>">
                                    <a href="javascript:;" class="menu-link">
                                        <div class="menu-text">Supplier</div>
                                        <div class="menu-caret"></div>
                                    </a>
                                    <div class="menu-submenu">
                                        <?php
                                        if ($purchasings['index'] == 1) { ?>
                                            <div class="menu-item <?= $menuPurchasingSupplier ?>">
                                                <a href="<?= $this->Url->build(['prefix' => False, 'controller' => 'Purchasings', 'action' => 'index']); ?>"
                                                    class="menu-link">
                                                    <div class="menu-text"> Purchase Order</div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        /**
                                        if ($invoiceentries['add'] == 1 || $invoiceentries['payment'] == 1) {
                                        ?>
                                            <div class="menu-item has-sub <?= $menuInvoiceEntries ?>">
                                                <a href="javascript:;" class="menu-link">
                                                    <div class="menu-text">Invoice</div>
                                                    <div class="menu-caret"></div>
                                                </a>
                                                <div class="menu-submenu">
                                                    <?php
                                                    if ($invoiceentries['add'] == 1) { ?>
                                                        <div class="menu-item <?= $menuInvoiceEntriesAdd ?>">
                                                            <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'InvoiceEntries', 'action' => 'add']); ?>" class="menu-link">
                                                                <div class="menu-text">Buat</div>
                                                            </a>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($invoiceentries['payment'] == 1) { ?>
                                                        <div class="menu-item <?= $menuInvoiceEntriesPay ?>">
                                                            <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'InvoiceEntries', 'action' => 'payment   ']); ?>" class="menu-link">
                                                                <div class="menu-text">Pembayaran</div>
                                                            </a>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>


                                                </div>
                                            </div>
                                        <?php
                                        }
                                        */
                                        ?>

                                        <?php
                                        if ($retursupplier['add'] == 1) { ?>
                                            <div class="menu-item <?= $menuReturSupplier ?>">
                                                <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'ReturSuppliers', 'action' => 'add']); ?>"
                                                    class="menu-link">
                                                    <div class="menu-text">Retur</div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        ?>


                                    </div>
                                </div>
                                <?php
                            }
                            ?>


                        </div>
                    </div>
                    <?php
                }
                ?>

                <?php
                if ($categories['index'] == 1 || $suppliers['index'] == 1 || $customers['index'] == 1 || $trucks['trucks'] == 1 || $mouses['mouses'] == 1 || $items['items'] == 1 || $warehousestocks['warehousestocks'] == 1 || $branchstocks['branchstocks'] == 1 || $warehouses['warehouses'] == 1 || $branches['branches'] == 1 || $goodsinwarehouses['index'] == 1 || (($goodsoutwarehouses['index'] == 1) && ($getAction == 'index' || $getAction == 'add' || $getAction == 'edit')) || $goodsinstores['index'] == 1 || $goodsoutstores['index'] == 1 || $goodsinwarehouses['index'] == 1 || (($goodsoutwarehouses['index'] == 1) && ($getAction == 'index' || $getAction == 'add' || $getAction == 'edit')) || $goodsinstores['index'] == 1 || $goodsoutstores['index'] == 1 || $country['index'] == 1 || $area['index'] == 1 | $unit['index'] == 1) {
                    $menuMaster = ($getController == 'categories' || $getController == 'suppliers' || $getController == 'customers' || $getController == 'trucks' || $getController == 'mouses' || $getController == 'items' || $getController == 'warehousestocks' || $getController == 'branchstocks' || $getController == 'warehouses' || $getController == 'branches' || $getController == 'goodsinwarehouses' || (($getController == 'goodsoutwarehouses') && ($goodsoutwarehouses['index'] == 1) && ($getAction == 'index' || $getAction == 'add' || $getAction == 'edit')) || $getController == 'goodsinstores' || $getController == 'goodsoutstores' || $getController == 'country' || $getController == 'area' || $getController == 'unit') ? 'active' : '';

                    $menuCategory = ($getController == 'categories') ? 'active' : '';
                    $menuSupplier = ($getController == 'suppliers') ? 'active' : '';
                    $menuCustomer = ($getController == 'customers') ? 'active' : '';
                    $menuTrucks = ($getController == 'trucks') ? 'active' : '';
                    $menuMouses = ($getController == 'mouses') ? 'active' : '';
                    $menuCountry = ($getController == 'country') ? 'active' : '';
                    $menuArea = ($getController == 'area') ? 'active' : '';
                    $menuUnit = ($getController == 'unit') ? 'active' : '';

                    $menuMasterItem = ($getController == 'items') ? 'active' : '';
                    ;
                    // $menuItems = ($getController == 'items')  ? 'active' : '';
                    $menuWarehouseStocks = ($getController == 'warehousestocks') ? 'active' : '';
                    $menuBranchStocks = ($getController == 'branchstocks') ? 'active' : '';

                    $menuWareAndBranc = ($getController == 'warehouses' || $getController == 'branches') ? 'active' : '';

                    $menuWareAndBranchStock = ($getController == 'warehousestocks' || $getController == 'branchstocks') ? 'active' : '';

                    $menuWarehouses = ($getController == 'warehouses') ? 'active' : '';
                    $menuStores = ($getController == 'branches') ? 'active' : '';

                    $menuInOut = ($getController == 'goodsinwarehouses' || (($getController == 'goodsoutwarehouses') && ($goodsoutwarehouses['index'] == 1) && ($getAction == 'index' || $getAction == 'add' || $getAction == 'edit')) || $getController == 'goodsinstores' || $getController == 'goodsoutstores') ? 'active' : '';

                    $menuGoodWarehouses = ($getController == 'goodsinwarehouses' || (($getController == 'goodsoutwarehouses') && ($goodsoutwarehouses['index'] == 1) && ($getAction == 'index' || $getAction == 'add' || $getAction == 'edit'))) ? 'active' : '';
                    $menuGoodStores = ($getController == 'goodsinstores' || $getController == 'goodsoutstores') ? 'active' : '';

                    $menuInWarehouse = ($getController == 'goodsinwarehouses') ? 'active' : '';
                    $menuOutWarehouse = (($getController == 'goodsoutwarehouses') && ($goodsoutwarehouses['index'] == 1) && ($getAction == 'index' || $getAction == 'add' || $getAction == 'edit')) ? 'active' : '';
                    $menuInStore = ($getController == 'goodsinstores') ? 'active' : '';
                    $menuOutStore = ($getController == 'goodsoutstores') ? 'active' : '';


                    ?>
                    <div class="menu-item has-sub <?= $menuMaster ?>">
                        <a href="javascript:;" class="menu-link">
                            <div class="menu-icon">
                                <ion-icon name="server-outline"></ion-icon>
                            </div>
                            <div class="menu-text">Master Data</div>
                            <div class="menu-caret"></div>
                        </a>
                        <div class="menu-submenu">

                            <?php
                            if ($country['index'] == 1) { ?>
                                <div class="menu-item <?= $menuCountry ?>">
                                    <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'Country', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">Negara</div>
                                    </a>
                                </div>

                                <?php
                            }
                            ?>

                            <?php
                            if ($area['index'] == 1) { ?>
                                <div class="menu-item <?= $menuArea ?>">
                                    <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'Area', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">Daerah</div>
                                    </a>
                                </div>

                                <?php
                            }
                            ?>

                            <?php
                            if ($customers['index'] == 1) { ?>
                                <div class="menu-item <?= $menuCustomer ?>">
                                    <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'Customers', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">Customer</div>
                                    </a>
                                </div>

                                <?php
                            }
                            ?>

                            <?php
                            if ($suppliers['index'] == 1) { ?>
                                <div class="menu-item <?= $menuSupplier ?>">
                                    <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'Suppliers', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">Supplier</div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>


                            <?php
                            if ($trucks['index'] == 1) { ?>
                                <div class="menu-item <?= $menuTrucks ?>">
                                    <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'Trucks', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">Armada</div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if ($categories['index'] == 1) { ?>
                                <div class="menu-item <?= $menuCategory ?>">
                                    <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'Categories', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">Kategori</div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>

                            <!-- <?php
                            if ($unit['index'] == 1) { ?>
                            <div class="menu-item <?= $menuUnit ?>">
                                <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'Unit', 'action' => 'index']); ?>" class="menu-link">
                                    <div class="menu-text">Satuan</div>
                                </a>
                            </div>
                        <?php
                            }
                            ?> -->

                            <?php
                            if ($items['index'] == 1) { ?>
                                <div class="menu-item <?= $menuMasterItem ?>">
                                    <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'Items', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">Produk</div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if ($mouses['index'] == 1) { ?>
                                <div class="menu-item <?= $menuMouses ?>">
                                    <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'Mouses', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">MOU</div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            /**
                            if ($items['index'] == 1) { ?>
                                <div class="menu-item  has-sub  <?= $menuMasterItem ?>">
                                    <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'Items', 'action' => 'index']); ?>" class="menu-link">
                                        <div class="menu-text"> Master Produk</div>
                                        <div class="menu-caret"></div>
                                    </a>
                                    <div class="menu-submenu">

                                        <?php
                                        if ($items['index'] == 1) { ?>
                                            <div class="menu-item <?= $menuMasterItem ?>">
                                                <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'Items', 'action' => 'index']); ?>" class="menu-link">
                                                    <div class="menu-text">Produk</div>
                                                </a>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </div>

                            <?php
                            } */
                            ?>

                            <?php
                            if ($warehouses['index'] == 1 || $branches['index'] == 1) { ?>
                                <div class="menu-item  has-sub  <?= $menuWareAndBranc ?>">
                                    <a href="javascript:;" class="menu-link">
                                        <div class="menu-text"> Master Gudang & Cabang</div>
                                        <div class="menu-caret"></div>
                                    </a>
                                    <div class="menu-submenu">

                                        <?php
                                        if ($warehouses['index'] == 1) { ?>
                                            <div class="menu-item <?= $menuWarehouses ?>">
                                                <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'Warehouses', 'action' => 'index']); ?>"
                                                    class="menu-link">
                                                    <div class="menu-text">Gudang</div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($branches['index'] == 1) { ?>
                                            <div class="menu-item <?= $menuStores ?>">
                                                <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'Branches', 'action' => 'index']); ?>"
                                                    class="menu-link">
                                                    <div class="menu-text">Cabang</div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div>

                                <?php
                            }
                            ?>

                            <?php
                            if ($warehousestocks['index'] == 1 || $branchstocks['index'] == 1) { ?>
                                <div class="menu-item  has-sub  <?= $menuWareAndBranchStock ?>">
                                    <a href="javascript:;" class="menu-link">
                                        <div class="menu-text">Master Item</div>
                                        <div class="menu-caret"></div>
                                    </a>
                                    <div class="menu-submenu">

                                        <?php
                                        if ($warehousestocks['index'] == 1) { ?>
                                            <div class="menu-item <?= $menuWarehouseStocks ?>">
                                                <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'WarehouseStocks', 'action' => 'index']); ?>"
                                                    class="menu-link">
                                                    <div class="menu-text">Item Gudang</div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($branchstocks['index'] == 1) { ?>
                                            <div class="menu-item <?= $menuBranchStocks ?>">
                                                <a href="<?= $this->Url->build(['prefix' => "Master", 'controller' => 'BranchStocks', 'action' => 'index']); ?>"
                                                    class="menu-link">
                                                    <div class="menu-text">Item Toko</div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div>

                                <?php
                            }
                            ?>

                            <?php
                            if ($goodsinwarehouses['index'] == 1 || $goodsoutwarehouses['index'] == 1) { ?>
                                <div class="menu-item  has-sub  <?= $menuInOut ?>">
                                    <a href="javascript:;" class="menu-link">
                                        <div class="menu-text"> Master In/Out</div>
                                        <div class="menu-caret"></div>
                                    </a>
                                    <div class="menu-submenu">
                                        <div class="menu-item has-sub <?= $menuGoodWarehouses ?>">
                                            <a href="javascript:;" class="menu-link">
                                                <div class="menu-text">Gudang </div>
                                                <div class="menu-caret"></div>
                                            </a>
                                            <div class="menu-submenu">
                                                <?php
                                                if ($goodsinwarehouses['index'] == 1) { ?>
                                                    <div class="menu-item <?= $menuInWarehouse ?>">
                                                        <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'GoodsInWarehouses', 'action' => 'index']); ?>"
                                                            class="menu-link">
                                                            <div class="menu-text">Masuk Gudang</div>
                                                        </a>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                                if ($goodsoutwarehouses['index'] == 1) { ?>
                                                    <div class="menu-item <?= $menuOutWarehouse ?>">
                                                        <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'GoodsOutWarehouses', 'action' => 'index   ']); ?>"
                                                            class="menu-link">
                                                            <div class="menu-text">Keluar Gudang</div>
                                                        </a>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                            }
                            ?>

                                    <?php
                                    if ($goodsinstores['index'] == 1 || $goodsoutstores['index'] == 1) {
                                        ?>
                                        <div class="menu-item has-sub <?= $menuGoodStores ?>">
                                            <a href="javascript:;" class="menu-link">
                                                <div class="menu-text">Toko </div>
                                                <div class="menu-caret"></div>
                                            </a>
                                            <div class="menu-submenu">
                                                <?php
                                                if ($goodsinstores['index'] == 1) { ?>
                                                    <div class="menu-item <?= $menuInStore ?>">
                                                        <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'GoodsInStores', 'action' => 'index']); ?>"
                                                            class="menu-link">
                                                            <div class="menu-text">Masuk Toko</div>
                                                        </a>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                                if ($goodsoutwarehouses['index'] == 1) { ?>
                                                    <div class="menu-item <?= $menuOutStore ?>">
                                                        <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'GoodsOutStores', 'action' => 'index   ']); ?>"
                                                            class="menu-link">
                                                            <div class="menu-text">Keluar Toko</div>
                                                        </a>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <?php
                                    }
                                    ?>


                        </div>
                    </div>
                    <?php
                }
                ?>


                <?php
                if ($permits['index'] == 1 || $invoice['index'] == 1) {
                    $menuPrint = (($getController == 'permits' && ($getAction == 'index' || $getAction == 'edit')) || ($getController == 'invoices' && ($getAction == 'index' || $getAction == 'edit' || $getAction == 'child' || $getAction == 'childEdit'))) ? 'active' : '';
                    $menuPermitPrint = ($getController == 'permits' && ($getAction == 'index' || $getAction == 'edit')) ? 'active' : '';
                    $menuInvoicePrint = ($getController == 'invoices' && ($getAction == 'index' || $getAction == 'edit' || $getAction == 'child' || $getAction == 'childEdit')) ? 'active' : '';
                    ?>
                    <div class="menu-item has-sub <?= $menuPrint ?>">
                        <a href="javascript:;" class="menu-link">
                            <div class="menu-icon">
                                <ion-icon name="print-outline"></ion-icon>
                            </div>
                            <div class="menu-text">Cetak</div>
                            <div class="menu-caret"></div>
                        </a>
                        <div class="menu-submenu">

                            <?php
                            if ($permits['print'] == 1) { ?>
                                <div class="menu-item <?= $menuPermitPrint ?>">
                                    <a href="<?= $this->Url->build(['prefix' => "Transaction", 'controller' => 'Permits', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">Surat Jalan Customer</div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if ($invoices['print'] == 1) { ?>
                                <div class="menu-item <?= $menuInvoicePrint ?>">
                                    <a href="<?= $this->Url->build(['prefix' => "Transaction", 'controller' => 'Invoices', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">Invoice Customer</div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>

                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ($users['index'] == 1) {
                    $menuSetting = ($getController == 'users') ? 'active' : '';
                    $menuUser = ($getController == 'users' && ($getAction == 'index' || $getAction == 'add' || $getAction == 'edit' || $getAction == 'access' || $getAction == 'reset')) ? 'active' : '';
                    $menuUserPwd = ($getController == 'users' && $getAction == 'change') ? 'active' : '';

                    ?>
                    <div class="menu-item has-sub <?= $menuSetting ?>">
                        <a href="javascript:;" class="menu-link">
                            <div class="menu-icon">
                                <ion-icon name="cog-outline"></ion-icon>
                            </div>
                            <div class="menu-text">Setting </div>
                            <div class="menu-caret"></div>
                        </a>
                        <div class="menu-submenu">

                            <?php
                            if ($users['index'] == 1) { ?>
                                <div class="menu-item <?= $menuUser ?>">
                                    <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Users', 'action' => 'index']); ?>"
                                        class="menu-link">
                                        <div class="menu-text">User</div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>


                            <div class="menu-item <?= $menuUserPwd ?>">
                                <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Users', 'action' => 'change', $getUser->id]); ?>"
                                    class="menu-link">
                                    <div class="menu-text">Ubah Password</div>
                                </a>
                            </div>

                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="menu-item d-flex">
                    <a href="javascript:;"
                        class="app-sidebar-minify-btn ms-auto d-flex align-items-center text-decoration-none"
                        data-toggle="app-sidebar-minify">
                        <ion-icon id="collapse-icon" name="arrow-forward"></ion-icon>
                    </a>
                </div>

            </div>

        </div>

    </div>
    <div class="app-sidebar-bg"></div>
    <div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a>
    </div>

</body>

<script>
    $(document).ready(function () {
        $('.app-sidebar-minify-btn').on('click', function () {
            // Toggle the icon when the button is clicked
            var icon = $('#collapse-icon');
            icon.attr('name', icon.attr('name') === 'arrow-back' ? 'arrow-forward' : 'arrow-back');
        });
    });
</script>