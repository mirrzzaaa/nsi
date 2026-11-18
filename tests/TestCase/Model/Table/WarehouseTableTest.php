<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WarehouseTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WarehouseTable Test Case
 */
class WarehouseTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WarehouseTable
     */
    protected $Warehouse;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Warehouse',
        'app.Branches',
        'app.ReceiptOfDeliveries',
        'app.ReceiptOfGoods',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Warehouse') ? [] : ['className' => WarehouseTable::class];
        $this->Warehouse = $this->getTableLocator()->get('Warehouse', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Warehouse);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
