<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccAccountMappingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccAccountMappingsTable Test Case
 */
class AccAccountMappingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AccAccountMappingsTable
     */
    protected $AccAccountMappings;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.AccAccountMappings',
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
        $config = $this->getTableLocator()->exists('AccAccountMappings') ? [] : ['className' => AccAccountMappingsTable::class];
        $this->AccAccountMappings = $this->getTableLocator()->get('AccAccountMappings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->AccAccountMappings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AccAccountMappingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AccAccountMappingsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
