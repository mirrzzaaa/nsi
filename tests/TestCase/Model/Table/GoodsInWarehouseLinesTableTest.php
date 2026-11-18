<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GoodsInWarehouseLinesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GoodsInWarehouseLinesTable Test Case
 */
class GoodsInWarehouseLinesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GoodsInWarehouseLinesTable
     */
    protected $GoodsInWarehouseLines;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GoodsInWarehouseLines',
        'app.Branches',
        'app.GoodsInWarehouses',
        'app.GoodsOutWarehouses',
        'app.GoodsOutWarehouseLines',
        'app.Items',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('GoodsInWarehouseLines') ? [] : ['className' => GoodsInWarehouseLinesTable::class];
        $this->GoodsInWarehouseLines = $this->getTableLocator()->get('GoodsInWarehouseLines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GoodsInWarehouseLines);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\GoodsInWarehouseLinesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\GoodsInWarehouseLinesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
