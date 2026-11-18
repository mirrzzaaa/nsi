<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GoodsOutWarehousesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GoodsOutWarehousesTable Test Case
 */
class GoodsOutWarehousesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GoodsOutWarehousesTable
     */
    protected $GoodsOutWarehouses;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GoodsOutWarehouses',
        'app.Branches',
        'app.GoodsInWarehouses',
        'app.Warehouses',
        'app.Stores',
        'app.GoodsInStores',
        'app.GoodsInStoreLines',
        'app.GoodsInWarehouseLines',
        'app.GoodsOutWarehouseLines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('GoodsOutWarehouses') ? [] : ['className' => GoodsOutWarehousesTable::class];
        $this->GoodsOutWarehouses = $this->getTableLocator()->get('GoodsOutWarehouses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GoodsOutWarehouses);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\GoodsOutWarehousesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\GoodsOutWarehousesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
