<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Transaction;

use App\Controller\Transaction\GoodsInStoresController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Transaction\GoodsInStoresController Test Case
 *
 * @uses \App\Controller\Transaction\GoodsInStoresController
 */
class GoodsInStoresControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GoodsInStores',
        'app.Branches',
        'app.Stores',
        'app.GoodsOutWarehouses',
        'app.GoodsOutStores',
        'app.GoodsInStoreLines',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Transaction\GoodsInStoresController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Transaction\GoodsInStoresController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Transaction\GoodsInStoresController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Transaction\GoodsInStoresController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Transaction\GoodsInStoresController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
