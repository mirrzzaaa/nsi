<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\BranchController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\BranchController Test Case
 *
 * @uses \App\Controller\BranchController
 */
class BranchControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
