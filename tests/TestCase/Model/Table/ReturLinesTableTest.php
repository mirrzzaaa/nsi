<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReturLinesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReturLinesTable Test Case
 */
class ReturLinesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReturLinesTable
     */
    protected $ReturLines;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ReturLines',
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
        $config = $this->getTableLocator()->exists('ReturLines') ? [] : ['className' => ReturLinesTable::class];
        $this->ReturLines = $this->getTableLocator()->get('ReturLines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ReturLines);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ReturLinesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ReturLinesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
