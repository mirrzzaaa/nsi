<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PurchasingLinesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PurchasingLinesTable Test Case
 */
class PurchasingLinesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PurchasingLinesTable
     */
    protected $PurchasingLines;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PurchasingLines',
        'app.Purchasings',
        'app.Items',
        'app.Customers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PurchasingLines') ? [] : ['className' => PurchasingLinesTable::class];
        $this->PurchasingLines = $this->getTableLocator()->get('PurchasingLines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PurchasingLines);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PurchasingLinesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PurchasingLinesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
