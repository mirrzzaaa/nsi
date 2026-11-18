<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PurchasePassTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PurchasePassTable Test Case
 */
class PurchasePassTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PurchasePassTable
     */
    protected $PurchasePass;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PurchasePass',
        'app.Branches',
        'app.ReceiptOfGoods',
        'app.PurchaseInvoices',
        'app.Stocks',
        'app.Suppliers',
        'app.Trucks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PurchasePass') ? [] : ['className' => PurchasePassTable::class];
        $this->PurchasePass = $this->getTableLocator()->get('PurchasePass', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PurchasePass);

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
