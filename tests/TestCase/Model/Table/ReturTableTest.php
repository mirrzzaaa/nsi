<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReturTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReturTable Test Case
 */
class ReturTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReturTable
     */
    protected $Retur;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Retur',
        'app.OrderLines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Retur') ? [] : ['className' => ReturTable::class];
        $this->Retur = $this->getTableLocator()->get('Retur', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Retur);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ReturTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ReturTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
