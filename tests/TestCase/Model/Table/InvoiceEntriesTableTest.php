<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InvoiceEntriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InvoiceEntriesTable Test Case
 */
class InvoiceEntriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InvoiceEntriesTable
     */
    protected $InvoiceEntries;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.InvoiceEntries',
        'app.Branches',
        'app.Customers',
        'app.Signs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('InvoiceEntries') ? [] : ['className' => InvoiceEntriesTable::class];
        $this->InvoiceEntries = $this->getTableLocator()->get('InvoiceEntries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->InvoiceEntries);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\InvoiceEntriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\InvoiceEntriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
