<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PettyCashesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PettyCashesTable Test Case
 */
class PettyCashesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PettyCashesTable
     */
    protected $PettyCashes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PettyCashes',
        'app.Branches',
        'app.PettyCashLines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PettyCashes') ? [] : ['className' => PettyCashesTable::class];
        $this->PettyCashes = $this->getTableLocator()->get('PettyCashes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PettyCashes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PettyCashesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PettyCashesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
