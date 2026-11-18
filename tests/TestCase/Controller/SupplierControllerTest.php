<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\SupplierController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\SupplierController Test Case
 *
 * @uses \App\Controller\SupplierController
 */
class SupplierControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Supplier',
        'app.Users',
        'app.Depreciations',
        'app.Depreciationse',
        'app.Depreciationss',
        'app.ItemPrices',
        'app.MaterialLines',
        'app.PurchaseInvoices',
        'app.PurchasePasses',
        'app.PurchasePrices',
        'app.ReceiptOfGoods',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
