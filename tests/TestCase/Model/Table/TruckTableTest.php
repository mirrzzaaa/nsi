<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TruckTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TruckTable Test Case
 */
class TruckTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TruckTable
     */
    protected $Truck;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Truck',
        'app.Branches',
        'app.ManifestInsides',
        'app.Manifests',
        'app.Operationals',
        'app.PurchasePasses',
        'app.SalesPass',
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
        $config = $this->getTableLocator()->exists('Truck') ? [] : ['className' => TruckTable::class];
        $this->Truck = $this->getTableLocator()->get('Truck', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Truck);

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
