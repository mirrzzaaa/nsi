<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\GoodsInWarehousesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\GoodsInWarehousesController Test Case
 *
 * @uses \App\Controller\GoodsInWarehousesController
 */
class GoodsInWarehousesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GoodsInWarehouses',
        'app.Branches',
        'app.Purchasings',
        'app.Warehouses',
        'app.GoodsInWarehouseLines',
        'app.GoodsOutWarehouseLines',
        'app.GoodsOutWarehouses',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\GoodsInWarehousesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\GoodsInWarehousesController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\GoodsInWarehousesController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\GoodsInWarehousesController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\GoodsInWarehousesController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
