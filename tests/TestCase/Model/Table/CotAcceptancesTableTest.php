<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CotAcceptancesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CotAcceptancesTable Test Case
 */
class CotAcceptancesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CotAcceptancesTable
     */
    protected $CotAcceptances;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CotAcceptances',
        'app.Branches',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CotAcceptances') ? [] : ['className' => CotAcceptancesTable::class];
        $this->CotAcceptances = $this->getTableLocator()->get('CotAcceptances', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CotAcceptances);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CotAcceptancesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CotAcceptancesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
