<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MaterialTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MaterialTable Test Case
 */
class MaterialTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MaterialTable
     */
    protected $Material;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Material',
        'app.Branches',
        'app.Customers',
        'app.IncomingGoodLines',
        'app.MaterialLines',
        'app.OutgoingGoodLines',
        'app.ProductionLines',
        'app.PurchasePassLines',
        'app.PurchasePrices',
        'app.SalesPassLines',
        'app.SellingPrices',
        'app.Stocks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Material') ? [] : ['className' => MaterialTable::class];
        $this->Material = $this->getTableLocator()->get('Material', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Material);

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
