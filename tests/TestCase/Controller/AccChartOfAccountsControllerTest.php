<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\AccChartOfAccountsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\AccChartOfAccountsController Test Case
 *
 * @uses \App\Controller\AccChartOfAccountsController
 */
class AccChartOfAccountsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.AccChartOfAccounts',
        'app.Branches',
        'app.AccAccountMappings',
        'app.AccBeginningBalances',
        'app.AccJournalBankLines',
        'app.AccJournalCashLines',
        'app.AccJournalLines',
        'app.AccJournalMappings',
        'app.AccJournalMemorialLines',
        'app.Calks',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\AccChartOfAccountsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\AccChartOfAccountsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\AccChartOfAccountsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\AccChartOfAccountsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\AccChartOfAccountsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
