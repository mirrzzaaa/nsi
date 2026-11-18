<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RecipientPayersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RecipientPayersTable Test Case
 */
class RecipientPayersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RecipientPayersTable
     */
    protected $RecipientPayers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.RecipientPayers',
        'app.Branches',
        'app.AccJournalBanks220611',
        'app.AccJournalCashes220611',
        'app.AccJournalMemorials',
        'app.AccJournals',
        'app.AccJournals220611',
        'app.AccJournals220616',
        'app.AccJournals220629',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RecipientPayers') ? [] : ['className' => RecipientPayersTable::class];
        $this->RecipientPayers = $this->getTableLocator()->get('RecipientPayers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->RecipientPayers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RecipientPayersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\RecipientPayersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
