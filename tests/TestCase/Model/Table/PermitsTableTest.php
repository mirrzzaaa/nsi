<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PermitsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PermitsTable Test Case
 */
class PermitsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PermitsTable
     */
    protected $Permits;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Permits',
        'app.Branches',
        'app.Invoices',
        'app.Manifests',
        'app.Operationals',
        'app.Customers',
        'app.ManifestFakes',
        'app.ManifestInsides',
        'app.Orders',
        'app.OrdersOri',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Permits') ? [] : ['className' => PermitsTable::class];
        $this->Permits = $this->getTableLocator()->get('Permits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Permits);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PermitsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PermitsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
