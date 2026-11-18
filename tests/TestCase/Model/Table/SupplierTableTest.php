<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SupplierTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SupplierTable Test Case
 */
class SupplierTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SupplierTable
     */
    protected $Supplier;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Supplier',
        'app.Users',
        'app.Depreciations',
        'app.Depreciationse',
        'app.Depreciationss',
        'app.ItemPrices',
        'app.MaterialLines',
        'app.PurchaseInvoices',
        'app.PurchasePasses',
        'app.PurchasePrices',
        'app.ReceiptOfGoods',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Supplier') ? [] : ['className' => SupplierTable::class];
        $this->Supplier = $this->getTableLocator()->get('Supplier', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Supplier);

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
