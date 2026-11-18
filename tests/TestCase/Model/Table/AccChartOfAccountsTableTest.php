<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccChartOfAccountsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccChartOfAccountsTable Test Case
 */
class AccChartOfAccountsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AccChartOfAccountsTable
     */
    protected $AccChartOfAccounts;

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
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AccChartOfAccounts') ? [] : ['className' => AccChartOfAccountsTable::class];
        $this->AccChartOfAccounts = $this->getTableLocator()->get('AccChartOfAccounts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->AccChartOfAccounts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AccChartOfAccountsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AccChartOfAccountsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
