<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Master;

use App\Controller\Master\WarehouseStocksController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Master\WarehouseStocksController Test Case
 *
 * @uses \App\Controller\Master\WarehouseStocksController
 */
class WarehouseStocksControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.WarehouseStocks',
        'app.Branches',
        'app.ItemLines',
        'app.Warehouses',
        'app.GoodsOutWarehouseLines',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Master\WarehouseStocksController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Master\WarehouseStocksController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Master\WarehouseStocksController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Master\WarehouseStocksController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Master\WarehouseStocksController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
