<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Master;

use App\Controller\Master\CustomersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Master\CustomersController Test Case
 *
 * @uses \App\Controller\Master\CustomersController
 */
class CustomersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Customers',
        'app.Branches',
        'app.Users',
        'app.Marketings',
        'app.DataInvoices',
        'app.DataTaxes',
        'app.OrderLines',
        'app.Orders',
        'app.PurchasingLines',
        'app.Purchasings',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Master\CustomersController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Master\CustomersController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Master\CustomersController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Master\CustomersController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Master\CustomersController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
