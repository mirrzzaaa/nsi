<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PurchasePricesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PurchasePricesTable Test Case
 */
class PurchasePricesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PurchasePricesTable
     */
    protected $PurchasePrices;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PurchasePrices',
        'app.Branches',
        'app.Materials',
        'app.Suppliers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PurchasePrices') ? [] : ['className' => PurchasePricesTable::class];
        $this->PurchasePrices = $this->getTableLocator()->get('PurchasePrices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PurchasePrices);

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
