<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DriversTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DriversTable Test Case
 */
class DriversTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DriversTable
     */
    protected $Drivers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Drivers',
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
        $config = $this->getTableLocator()->exists('Drivers') ? [] : ['className' => DriversTable::class];
        $this->Drivers = $this->getTableLocator()->get('Drivers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Drivers);

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
