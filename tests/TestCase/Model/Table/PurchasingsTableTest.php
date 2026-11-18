<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PurchasingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PurchasingsTable Test Case
 */
class PurchasingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PurchasingsTable
     */
    protected $Purchasings;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Purchasings',
        'app.Branches',
        'app.Customers',
        'app.Suppliers',
        'app.GoodsInWarehouses',
        'app.PurchasingLines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Purchasings') ? [] : ['className' => PurchasingsTable::class];
        $this->Purchasings = $this->getTableLocator()->get('Purchasings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Purchasings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PurchasingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PurchasingsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
