<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Transaction;

use App\Controller\Transaction\OrdersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Transaction\OrdersController Test Case
 *
 * @uses \App\Controller\Transaction\OrdersController
 */
class OrdersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Orders',
        'app.Branches',
        'app.Customers',
        'app.Members',
        'app.Tables',
        'app.Wastes',
        'app.WasteTypes',
        'app.Processors',
        'app.Cashiers',
        'app.Manifests',
        'app.Permits',
        'app.Sjps',
        'app.TruckSchedules',
        'app.GoodsOutStores',
        'app.OrderLines',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Transaction\OrdersController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Transaction\OrdersController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Transaction\OrdersController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Transaction\OrdersController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Transaction\OrdersController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
