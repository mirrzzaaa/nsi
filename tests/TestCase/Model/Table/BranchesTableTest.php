<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BranchesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BranchesTable Test Case
 */
class BranchesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BranchesTable
     */
    protected $Branches;

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
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Branches') ? [] : ['className' => BranchesTable::class];
        $this->Branches = $this->getTableLocator()->get('Branches', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Branches);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\BranchesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
