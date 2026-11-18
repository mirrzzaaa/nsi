<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProManifestsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProManifestsTable Test Case
 */
class ProManifestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProManifestsTable
     */
    protected $ProManifests;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ProManifests',
        'app.Branches',
        'app.Manifests',
        'app.Invoices',
        'app.Customers',
        'app.Wastes',
        'app.Transporters',
        'app.Processors',
        'app.Trucks',
        'app.Drivers',
        'app.ProCots',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProManifests') ? [] : ['className' => ProManifestsTable::class];
        $this->ProManifests = $this->getTableLocator()->get('ProManifests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ProManifests);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
