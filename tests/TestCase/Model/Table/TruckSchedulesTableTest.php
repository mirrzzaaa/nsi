<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TruckSchedulesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TruckSchedulesTable Test Case
 */
class TruckSchedulesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TruckSchedulesTable
     */
    protected $TruckSchedules;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.TruckSchedules',
        'app.Projects',
        'app.Branches',
        'app.Customers',
        'app.Manifests',
        'app.Wastes',
        'app.Orders',
        'app.Drivers',
        'app.Helpers',
        'app.Trucks',
        'app.ModaTrucks',
        'app.ModaDrivers',
        'app.ModaHelpers',
        'app.ManifestFakes',
        'app.OrdersOri',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TruckSchedules') ? [] : ['className' => TruckSchedulesTable::class];
        $this->TruckSchedules = $this->getTableLocator()->get('TruckSchedules', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->TruckSchedules);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TruckSchedulesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\TruckSchedulesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
