<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OperationalsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OperationalsTable Test Case
 */
class OperationalsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OperationalsTable
     */
    protected $Operationals;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Operationals',
        'app.Branches',
        'app.Permits',
        'app.Projects',
        'app.Customers',
        'app.Processors',
        'app.Trucks',
        'app.Drivers',
        'app.Helpers',
        'app.CashReceipts',
        'app.Manifests',
        'app.OperationalLines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Operationals') ? [] : ['className' => OperationalsTable::class];
        $this->Operationals = $this->getTableLocator()->get('Operationals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Operationals);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OperationalsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OperationalsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
