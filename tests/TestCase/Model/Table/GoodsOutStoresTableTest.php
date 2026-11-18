<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GoodsOutStoresTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GoodsOutStoresTable Test Case
 */
class GoodsOutStoresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GoodsOutStoresTable
     */
    protected $GoodsOutStores;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GoodsOutStores',
        'app.Branches',
        'app.Orders',
        'app.ReturnGoods',
        'app.GoodsInStores',
        'app.GoodsOutStoreLines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('GoodsOutStores') ? [] : ['className' => GoodsOutStoresTable::class];
        $this->GoodsOutStores = $this->getTableLocator()->get('GoodsOutStores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GoodsOutStores);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\GoodsOutStoresTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\GoodsOutStoresTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
