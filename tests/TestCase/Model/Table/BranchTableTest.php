<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BranchTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BranchTable Test Case
 */
class BranchTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BranchTable
     */
    protected $Branch;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Branch',
        'app.AccAccountMappings',
        'app.AccAccounts',
        'app.AccBeginningBalances',
        'app.AccChartOfAccounts',
        'app.AccJournalBankLines',
        'app.AccJournalBanks',
        'app.AccJournalCashLines',
        'app.AccJournalCashes',
        'app.AccJournalLines',
        'app.AccJournalMappings',
        'app.AccJournalMemorialLines',
        'app.AccJournalMemorials',
        'app.AccJournals',
        'app.Calks',
        'app.Certificates',
        'app.CommissionDetails',
        'app.Commissions',
        'app.Creditors',
        'app.Customers',
        'app.CustomersOri',
        'app.DataInvoices',
        'app.DataTaxes',
        'app.Deposits',
        'app.Depreciations',
        'app.Depreciationse',
        'app.Depreciationss',
        'app.Drivers',
        'app.IncomingGoodLines',
        'app.IncomingGoods',
        'app.InvoiceDeposits',
        'app.InvoiceEntries',
        'app.InvoiceHutangs',
        'app.InvoiceOuts',
        'app.Invoices',
        'app.ItemPrices',
        'app.Items',
        'app.Logs',
        'app.ManifestDirects',
        'app.ManifestInsides',
        'app.ManifestLogbooks',
        'app.ManifestProcessors',
        'app.Manifests',
        'app.MaterialLines',
        'app.Materials',
        'app.Mouses',
        'app.Numbers',
        'app.Offers',
        'app.OperationalLines',
        'app.Operationals',
        'app.Orders',
        'app.OrdersOri',
        'app.OutgoingGoodLines',
        'app.OutgoingGoods',
        'app.Payments',
        'app.Permits',
        'app.PettyCashes',
        'app.Processors',
        'app.Projects',
        'app.PurchaseInvoices',
        'app.PurchasePassLines',
        'app.PurchasePasses',
        'app.PurchasePrices',
        'app.ReceiptOfDeliveries',
        'app.ReceiptOfGoods',
        'app.RecipientPayers',
        'app.SalesInvoices',
        'app.SalesPassLines',
        'app.SalesPasses',
        'app.SellingPrices',
        'app.Settings',
        'app.StocksOri',
        'app.Templates',
        'app.Transporters',
        'app.TruckInspections',
        'app.TruckSchedules',
        'app.Trucks',
        'app.TrucksOri',
        'app.Users',
        'app.Warehouses',
        'app.WastePrices',
        'app.WasteTypes',
        'app.Wastes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Branch') ? [] : ['className' => BranchTable::class];
        $this->Branch = $this->getTableLocator()->get('Branch', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Branch);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
