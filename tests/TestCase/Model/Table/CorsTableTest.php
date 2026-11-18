<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CorsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CorsTable Test Case
 */
class CorsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CorsTable
     */
    protected $Cors;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Cors',
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
        $config = $this->getTableLocator()->exists('Cors') ? [] : ['className' => CorsTable::class];
        $this->Cors = $this->getTableLocator()->get('Cors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Cors);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CorsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CorsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
