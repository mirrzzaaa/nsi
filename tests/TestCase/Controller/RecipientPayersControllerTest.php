<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\RecipientPayersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\RecipientPayersController Test Case
 *
 * @uses \App\Controller\RecipientPayersController
 */
class RecipientPayersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.RecipientPayers',
        'app.Branches',
        'app.AccJournalBanks220611',
        'app.AccJournalCashes220611',
        'app.AccJournalMemorials',
        'app.AccJournals',
        'app.AccJournals220611',
        'app.AccJournals220616',
        'app.AccJournals220629',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\RecipientPayersController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\RecipientPayersController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\RecipientPayersController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\RecipientPayersController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\RecipientPayersController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
