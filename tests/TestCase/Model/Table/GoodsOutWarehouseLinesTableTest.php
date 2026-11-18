<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GoodsOutWarehouseLinesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GoodsOutWarehouseLinesTable Test Case
 */
class GoodsOutWarehouseLinesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GoodsOutWarehouseLinesTable
     */
    protected $GoodsOutWarehouseLines;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GoodsOutWarehouseLines',
        'app.Branches',
        'app.GoodsOutWarehouses',
        'app.GoodsInWarehouses',
        'app.GoodsInWarehouseLines',
        'app.WarehouseStocks',
        'app.Items',
        'app.GoodsInStoreLines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('GoodsOutWarehouseLines') ? [] : ['className' => GoodsOutWarehouseLinesTable::class];
        $this->GoodsOutWarehouseLines = $this->getTableLocator()->get('GoodsOutWarehouseLines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GoodsOutWarehouseLines);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\GoodsOutWarehouseLinesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\GoodsOutWarehouseLinesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
