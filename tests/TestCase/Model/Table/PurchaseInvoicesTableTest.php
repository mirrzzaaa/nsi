<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PurchaseInvoicesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PurchaseInvoicesTable Test Case
 */
class PurchaseInvoicesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PurchaseInvoicesTable
     */
    protected $PurchaseInvoices;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PurchaseInvoices',
        'app.Branches',
        'app.Suppliers',
        'app.Marketings',
        'app.PurchasePasses',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PurchaseInvoices') ? [] : ['className' => PurchaseInvoicesTable::class];
        $this->PurchaseInvoices = $this->getTableLocator()->get('PurchaseInvoices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PurchaseInvoices);

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
