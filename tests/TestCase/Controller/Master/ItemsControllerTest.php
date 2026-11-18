<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Master;

use App\Controller\Master\ItemsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Master\ItemsController Test Case
 *
 * @uses \App\Controller\Master\ItemsController
 */
class ItemsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Items',
        'app.Branches',
        'app.Categories',
        'app.RawMaterials',
        'app.GoodsInStoreLines',
        'app.GoodsInWarehouseLines',
        'app.GoodsOutStoreLines',
        'app.GoodsOutWarehouseLines',
        'app.ItemLines',
        'app.OrderLines',
        'app.PurchasingLines',
        'app.WarehouseStocks',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Master\ItemsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Master\ItemsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Master\ItemsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Master\ItemsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Master\ItemsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
