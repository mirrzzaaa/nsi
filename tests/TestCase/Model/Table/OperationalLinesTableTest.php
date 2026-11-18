<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OperationalLinesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OperationalLinesTable Test Case
 */
class OperationalLinesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OperationalLinesTable
     */
    protected $OperationalLines;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OperationalLines',
        'app.Branches',
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
        $config = $this->getTableLocator()->exists('OperationalLines') ? [] : ['className' => OperationalLinesTable::class];
        $this->OperationalLines = $this->getTableLocator()->get('OperationalLines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OperationalLines);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OperationalLinesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OperationalLinesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
