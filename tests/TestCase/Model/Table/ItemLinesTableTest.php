<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemLinesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemLinesTable Test Case
 */
class ItemLinesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemLinesTable
     */
    protected $ItemLines;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ItemLines',
        'app.Branches',
        'app.Items',
        'app.OrderLines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ItemLines') ? [] : ['className' => ItemLinesTable::class];
        $this->ItemLines = $this->getTableLocator()->get('ItemLines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ItemLines);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ItemLinesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ItemLinesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
