<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WarehouseStocksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WarehouseStocksTable Test Case
 */
class WarehouseStocksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WarehouseStocksTable
     */
    protected $WarehouseStocks;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.WarehouseStocks',
        'app.Branches',
        'app.ItemLines',
        'app.Warehouses',
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
        $config = $this->getTableLocator()->exists('WarehouseStocks') ? [] : ['className' => WarehouseStocksTable::class];
        $this->WarehouseStocks = $this->getTableLocator()->get('WarehouseStocks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->WarehouseStocks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\WarehouseStocksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\WarehouseStocksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
