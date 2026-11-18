<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccJournalMappingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccJournalMappingsTable Test Case
 */
class AccJournalMappingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AccJournalMappingsTable
     */
    protected $AccJournalMappings;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.AccJournalMappings',
        'app.Branches',
        'app.AccChartOfAccounts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AccJournalMappings') ? [] : ['className' => AccJournalMappingsTable::class];
        $this->AccJournalMappings = $this->getTableLocator()->get('AccJournalMappings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->AccJournalMappings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AccJournalMappingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AccJournalMappingsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
