<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CotsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CotsTable Test Case
 */
class CotsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CotsTable
     */
    protected $Cots;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Cots',
        'app.Branches',
        'app.Customers',
        'app.Managers',
        'app.ManifestFakes',
        'app.Manifests',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Cots') ? [] : ['className' => CotsTable::class];
        $this->Cots = $this->getTableLocator()->get('Cots', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Cots);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CotsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CotsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
