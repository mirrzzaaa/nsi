<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccJournalLinesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccJournalLinesTable Test Case
 */
class AccJournalLinesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AccJournalLinesTable
     */
    protected $AccJournalLines;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.AccJournalLines',
        'app.Branches',
        'app.AccJournals',
        'app.JournalSubs',
        'app.JournalSubLines',
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
        $config = $this->getTableLocator()->exists('AccJournalLines') ? [] : ['className' => AccJournalLinesTable::class];
        $this->AccJournalLines = $this->getTableLocator()->get('AccJournalLines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->AccJournalLines);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AccJournalLinesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AccJournalLinesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
