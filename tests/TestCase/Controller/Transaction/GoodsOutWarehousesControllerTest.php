<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Transaction;

use App\Controller\Transaction\GoodsOutWarehousesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Transaction\GoodsOutWarehousesController Test Case
 *
 * @uses \App\Controller\Transaction\GoodsOutWarehousesController
 */
class GoodsOutWarehousesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GoodsOutWarehouses',
        'app.Branches',
        'app.GoodsInWarehouses',
        'app.Warehouses',
        'app.Stores',
        'app.GoodsInStores',
        'app.GoodsInStoreLines',
        'app.GoodsInWarehouseLines',
        'app.GoodsOutWarehouseLines',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Transaction\GoodsOutWarehousesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Transaction\GoodsOutWarehousesController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Transaction\GoodsOutWarehousesController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Transaction\GoodsOutWarehousesController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Transaction\GoodsOutWarehousesController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
