<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\BranchesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\BranchesController Test Case
 *
 * @uses \App\Controller\BranchesController
 */
class BranchesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Branches',
        'app.AccAccountMappings',
        'app.AccAccounts',
        'app.AccBeginningBalances',
        'app.AccChartOfAccounts',
        'app.AccJournalLines',
        'app.AccJournalMappings',
        'app.AccJournals',
        'app.Activities',
        'app.Calks',
        'app.CashReceipts',
        'app.Certificates',
        'app.CommissionDetails',
        'app.Commissions',
        'app.Cors',
        'app.Cots',
        'app.Creditors',
        'app.Customers',
        'app.DataInvoices',
        'app.DataTaxes',
        'app.Depreciations',
        'app.Depreciationse',
        'app.Depreciationss',
        'app.Drivers',
        'app.InvoiceEntries',
        'app.Invoices',
        'app.Leaves',
        'app.Letters',
        'app.LicenseAbsents',
        'app.LicenseLates',
        'app.LicenseOuts',
        'app.Logs',
        'app.ManifestDirects',
        'app.ManifestFakes',
        'app.ManifestInsides',
        'app.ManifestLogbooks',
        'app.Manifests',
        'app.MouLines',
        'app.Mouses',
        'app.Numbers',
        'app.Offers',
        'app.OperationalLines',
        'app.Operationals',
        'app.Orders',
        'app.Overtimes',
        'app.Payments',
        'app.Permits',
        'app.PettyCashes',
        'app.ProCots',
        'app.ProManifests',
        'app.Processors',
        'app.Projects',
        'app.RecipientPayers',
        'app.Settings',
        'app.Transporters',
        'app.TruckInspections',
        'app.TruckSchedules',
        'app.Trucks',
        'app.Users',
        'app.WasteTypes',
        'app.Wastes',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\BranchesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\BranchesController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\BranchesController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\BranchesController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\BranchesController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
