<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\CustomerController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\CustomerController Test Case
 *
 * @uses \App\Controller\CustomerController
 */
class CustomerControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
