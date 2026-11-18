<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GoodsInStoresTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GoodsInStoresTable Test Case
 */
class GoodsInStoresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GoodsInStoresTable
     */
    protected $GoodsInStores;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GoodsInStores',
        'app.Branches',
        'app.Stores',
        'app.GoodsOutWarehouses',
        'app.GoodsOutStores',
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
        $config = $this->getTableLocator()->exists('GoodsInStores') ? [] : ['className' => GoodsInStoresTable::class];
        $this->GoodsInStores = $this->getTableLocator()->get('GoodsInStores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GoodsInStores);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\GoodsInStoresTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\GoodsInStoresTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
