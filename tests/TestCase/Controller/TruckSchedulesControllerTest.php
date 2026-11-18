<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\TruckSchedulesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\TruckSchedulesController Test Case
 *
 * @uses \App\Controller\TruckSchedulesController
 */
class TruckSchedulesControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
     * Test index method
     *
     * @return void
     * @uses \App\Controller\TruckSchedulesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\TruckSchedulesController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\TruckSchedulesController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\TruckSchedulesController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\TruckSchedulesController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
