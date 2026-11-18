<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DriverTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DriverTable Test Case
 */
class DriverTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DriverTable
     */
    protected $Driver;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Driver',
        'app.Branches',
        'app.ManifestInsides',
        'app.Manifests',
        'app.Operationals',
        'app.TruckInspections',
        'app.TruckSchedules',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Driver') ? [] : ['className' => DriverTable::class];
        $this->Driver = $this->getTableLocator()->get('Driver', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Driver);

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
