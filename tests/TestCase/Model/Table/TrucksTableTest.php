<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrucksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrucksTable Test Case
 */
class TrucksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TrucksTable
     */
    protected $Trucks;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Trucks',
        'app.Branches',
        'app.ManifestInsides',
        'app.Manifests',
        'app.Operationals',
        'app.PurchasePasses',
        'app.SalesPasses',
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
        $config = $this->getTableLocator()->exists('Trucks') ? [] : ['className' => TrucksTable::class];
        $this->Trucks = $this->getTableLocator()->get('Trucks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Trucks);

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
