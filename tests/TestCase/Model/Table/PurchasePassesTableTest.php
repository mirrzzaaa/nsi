<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PurchasePassesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PurchasePassesTable Test Case
 */
class PurchasePassesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PurchasePassesTable
     */
    protected $PurchasePasses;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PurchasePasses',
        'app.Branches',
        'app.ReceiptOfGoods',
        'app.PurchaseInvoices',
        'app.Stocks',
        'app.Suppliers',
        'app.Trucks',
        'app.PurchasePassLines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PurchasePasses') ? [] : ['className' => PurchasePassesTable::class];
        $this->PurchasePasses = $this->getTableLocator()->get('PurchasePasses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PurchasePasses);

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
