<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GoodsInStoreLinesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GoodsInStoreLinesTable Test Case
 */
class GoodsInStoreLinesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GoodsInStoreLinesTable
     */
    protected $GoodsInStoreLines;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GoodsInStoreLines',
        'app.Branches',
        'app.GoodsInStores',
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
        $config = $this->getTableLocator()->exists('GoodsInStoreLines') ? [] : ['className' => GoodsInStoreLinesTable::class];
        $this->GoodsInStoreLines = $this->getTableLocator()->get('GoodsInStoreLines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GoodsInStoreLines);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\GoodsInStoreLinesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\GoodsInStoreLinesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
