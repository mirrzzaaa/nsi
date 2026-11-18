<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccJournalsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccJournalsTable Test Case
 */
class AccJournalsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AccJournalsTable
     */
    protected $AccJournals;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.AccJournals',
        'app.Branches',
        'app.JournalSubs',
        'app.Customers',
        'app.RecipientPayers',
        'app.AccJournalLines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AccJournals') ? [] : ['className' => AccJournalsTable::class];
        $this->AccJournals = $this->getTableLocator()->get('AccJournals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->AccJournals);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AccJournalsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AccJournalsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
