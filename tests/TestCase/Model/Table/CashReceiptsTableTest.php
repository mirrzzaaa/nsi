<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CashReceiptsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CashReceiptsTable Test Case
 */
class CashReceiptsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CashReceiptsTable
     */
    protected $CashReceipts;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CashReceipts',
        'app.Branches',
        'app.Projects',
        'app.Drivers',
        'app.Operationals',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CashReceipts') ? [] : ['className' => CashReceiptsTable::class];
        $this->CashReceipts = $this->getTableLocator()->get('CashReceipts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CashReceipts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CashReceiptsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CashReceiptsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
