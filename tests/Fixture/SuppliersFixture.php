<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SuppliersFixture
 */
class SuppliersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'code' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'address' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'npwp' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'ppn' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => '0', 'collate' => 'utf8mb3_general_ci', 'comment' => '0=Exclude, 1=Include', 'precision' => null],
        'tax' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'city' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'province' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'postal' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'country' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'pic' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'telp' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'hp' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'fax' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'email' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'name_invoice' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'address_invoice' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'phone_invoice' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'fax_invoice' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'name_tax_invoice' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'address_tax_invoice' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'phone_tax_invoice' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'fax_tax_invoice' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'sistem' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'website' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'is_active' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'y', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'is_log' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'is_create' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'is_update' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'is_delete' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'active' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => '1', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'status' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'Index 3' => ['type' => 'index', 'columns' => ['code', 'name'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'code' => ['type' => 'unique', 'columns' => ['code', 'name'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'MyISAM',
            'collation' => 'utf8mb3_general_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'code' => 'Lorem ipsum dolor sit amet',
                'user_id' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'address' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'npwp' => 'Lorem ipsum dolor sit amet',
                'ppn' => 'Lorem ipsum dolor sit amet',
                'tax' => 'Lorem ipsum dolor sit amet',
                'city' => 'Lorem ipsum dolor sit amet',
                'province' => 'Lorem ipsum dolor sit amet',
                'postal' => 1,
                'country' => 'Lorem ipsum dolor sit amet',
                'pic' => 'Lorem ipsum dolor sit amet',
                'telp' => 'Lorem ipsum dolor sit amet',
                'hp' => 'Lorem ipsum dolor sit amet',
                'fax' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'name_invoice' => 'Lorem ipsum dolor sit amet',
                'address_invoice' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'phone_invoice' => 'Lorem ipsum dolor sit amet',
                'fax_invoice' => 'Lorem ipsum dolor sit amet',
                'name_tax_invoice' => 'Lorem ipsum dolor sit amet',
                'address_tax_invoice' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'phone_tax_invoice' => 'Lorem ipsum dolor sit amet',
                'fax_tax_invoice' => 'Lorem ipsum dolor sit amet',
                'sistem' => 'Lorem ipsum dolor sit amet',
                'website' => 'Lorem ipsum dolor sit amet',
                'is_active' => 'Lorem ipsum dolor sit amet',
                'is_log' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'is_create' => 1,
                'created' => '2022-12-08 16:16:33',
                'is_update' => 1,
                'modified' => '2022-12-08 16:16:33',
                'is_delete' => 1,
                'deleted' => '2022-12-08 16:16:33',
                'active' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
