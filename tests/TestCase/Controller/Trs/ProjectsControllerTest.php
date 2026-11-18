<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Trs;

use App\Controller\Trs\ProjectsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Trs\ProjectsController Test Case
 *
 * @uses \App\Controller\Trs\ProjectsController
 */
class ProjectsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Projects',
        'app.Branches',
        'app.Operationals',
        'app.Manifests',
        'app.TruckSchedules',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Trs\ProjectsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Trs\ProjectsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Trs\ProjectsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Trs\ProjectsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Trs\ProjectsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
