<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RawMaterialsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RawMaterialsTable Test Case
 */
class RawMaterialsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RawMaterialsTable
     */
    protected $RawMaterials;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.RawMaterials',
        'app.Suppliers',
        'app.Branches',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RawMaterials') ? [] : ['className' => RawMaterialsTable::class];
        $this->RawMaterials = $this->getTableLocator()->get('RawMaterials', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->RawMaterials);

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
