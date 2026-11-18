<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GoodsInWarehousesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GoodsInWarehousesTable Test Case
 */
class GoodsInWarehousesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GoodsInWarehousesTable
     */
    protected $GoodsInWarehouses;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GoodsInWarehouses',
        'app.Branches',
        'app.Purchasings',
        'app.Warehouses',
        'app.GoodsInWarehouseLines',
        'app.GoodsOutWarehouseLines',
        'app.GoodsOutWarehouses',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('GoodsInWarehouses') ? [] : ['className' => GoodsInWarehousesTable::class];
        $this->GoodsInWarehouses = $this->getTableLocator()->get('GoodsInWarehouses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GoodsInWarehouses);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\GoodsInWarehousesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\GoodsInWarehousesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
