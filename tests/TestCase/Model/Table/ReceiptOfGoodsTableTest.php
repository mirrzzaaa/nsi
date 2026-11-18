<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReceiptOfGoodsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReceiptOfGoodsTable Test Case
 */
class ReceiptOfGoodsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReceiptOfGoodsTable
     */
    protected $ReceiptOfGoods;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ReceiptOfGoods',
        'app.Branches',
        'app.Suppliers',
        'app.Warehouses',
        'app.IncomingGood',
        'app.OutgoingGoods',
        'app.PurchasePasses',
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
        $config = $this->getTableLocator()->exists('ReceiptOfGoods') ? [] : ['className' => ReceiptOfGoodsTable::class];
        $this->ReceiptOfGoods = $this->getTableLocator()->get('ReceiptOfGoods', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ReceiptOfGoods);

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
