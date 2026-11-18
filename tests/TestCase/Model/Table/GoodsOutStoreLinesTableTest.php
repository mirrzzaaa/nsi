<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GoodsOutStoreLinesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GoodsOutStoreLinesTable Test Case
 */
class GoodsOutStoreLinesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GoodsOutStoreLinesTable
     */
    protected $GoodsOutStoreLines;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GoodsOutStoreLines',
        'app.Branches',
        'app.GoodsOutStores',
        'app.ItemLines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('GoodsOutStoreLines') ? [] : ['className' => GoodsOutStoreLinesTable::class];
        $this->GoodsOutStoreLines = $this->getTableLocator()->get('GoodsOutStoreLines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GoodsOutStoreLines);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\GoodsOutStoreLinesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\GoodsOutStoreLinesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
