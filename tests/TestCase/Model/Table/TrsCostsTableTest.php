<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrsCostsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrsCostsTable Test Case
 */
class TrsCostsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TrsCostsTable
     */
    protected $TrsCosts;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.TrsCosts',
        'app.Branches',
        'app.Projects',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TrsCosts') ? [] : ['className' => TrsCostsTable::class];
        $this->TrsCosts = $this->getTableLocator()->get('TrsCosts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->TrsCosts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TrsCostsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\TrsCostsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
