<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\OperationalsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\OperationalsController Test Case
 *
 * @uses \App\Controller\OperationalsController
 */
class OperationalsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Operationals',
        'app.Branches',
        'app.Permits',
        'app.Projects',
        'app.Customers',
        'app.Processors',
        'app.Trucks',
        'app.Drivers',
        'app.Helpers',
        'app.CashReceipts',
        'app.Manifests',
        'app.OperationalLines',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\OperationalsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\OperationalsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\OperationalsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\OperationalsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\OperationalsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
