<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Acc;

use App\Controller\Acc\CashReceiptsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Acc\CashReceiptsController Test Case
 *
 * @uses \App\Controller\Acc\CashReceiptsController
 */
class CashReceiptsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CashReceipts',
        'app.Branches',
        'app.Projects',
        'app.Drivers',
        'app.Operationals',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Acc\CashReceiptsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Acc\CashReceiptsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Acc\CashReceiptsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Acc\CashReceiptsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Acc\CashReceiptsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
