<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CustomerTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CustomerTable Test Case
 */
class CustomerTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CustomerTable
     */
    protected $Customer;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Customer',
        'app.Branches',
        'app.Users',
        'app.Marketings',
        'app.DataInvoices',
        'app.DataTaxes',
        'app.Mous',
        'app.AccCashes',
        'app.AccChartOfAccounts',
        'app.AccJournalBanks',
        'app.AccJournalCashes',
        'app.AccJournalMemorials',
        'app.AccJournals',
        'app.Certificates',
        'app.CommissionDetails',
        'app.InvoiceDeposits',
        'app.InvoiceEntries',
        'app.InvoiceOuts',
        'app.Invoices',
        'app.ManifestInsides',
        'app.ManifestProcessors',
        'app.Manifests',
        'app.Material',
        'app.MaterialLines',
        'app.Mouses',
        'app.Offers',
        'app.Operationals',
        'app.Orders',
        'app.Permits',
        'app.ReceiptOfDeliveries',
        'app.SalesInvoices',
        'app.SalesPass',
        'app.SellingPrices',
        'app.TruckSchedules',
        'app.WastePrices',
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
        $config = $this->getTableLocator()->exists('Customer') ? [] : ['className' => CustomerTable::class];
        $this->Customer = $this->getTableLocator()->get('Customer', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Customer);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
