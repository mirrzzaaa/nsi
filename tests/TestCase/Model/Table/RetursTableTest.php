<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RetursTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RetursTable Test Case
 */
class RetursTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RetursTable
     */
    protected $Returs;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Returs',
        'app.ReturLines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Returs') ? [] : ['className' => RetursTable::class];
        $this->Returs = $this->getTableLocator()->get('Returs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Returs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RetursTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\RetursTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
