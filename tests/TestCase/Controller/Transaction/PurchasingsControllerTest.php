<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Transaction;

use App\Controller\Transaction\PurchasingsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Transaction\PurchasingsController Test Case
 *
 * @uses \App\Controller\Transaction\PurchasingsController
 */
class PurchasingsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Purchasings',
        'app.Branches',
        'app.Customers',
        'app.Suppliers',
        'app.GoodsInWarehouses',
        'app.PurchasingLines',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Transaction\PurchasingsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Transaction\PurchasingsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Transaction\PurchasingsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Transaction\PurchasingsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Transaction\PurchasingsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
