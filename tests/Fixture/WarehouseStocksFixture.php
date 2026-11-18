<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * WarehouseStocksFixture
 */
class WarehouseStocksFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'branch_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'item_lines_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => 'id Barang', 'precision' => null, 'autoIncrement' => null],
        'warehouse_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => 'id Gudang', 'precision' => null, 'autoIncrement' => null],
        'code' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => 'Kode', 'precision' => null],
        'unit' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => 'Unit/Satuan', 'precision' => null],
        'stock' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'packing' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'date' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'is_create' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'is_update' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'is_delete' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'is_active' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'Y', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'is_log' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'status' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'Index' => ['type' => 'index', 'columns' => ['code'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'item_id_warehouse_id' => ['type' => 'unique', 'columns' => ['item_lines_id', 'warehouse_id'], 'length' => []],
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
                'branch_id' => 1,
                'item_lines_id' => 1,
                'warehouse_id' => 1,
                'code' => 'Lorem ipsum dolor sit amet',
                'unit' => 'Lorem ipsum dolor sit amet',
                'stock' => 1.5,
                'packing' => 'Lorem ipsum dolor sit amet',
                'date' => '2022-12-27',
                'is_create' => 1,
                'created' => '2022-12-27 13:32:00',
                'is_update' => 1,
                'modified' => '2022-12-27 13:32:00',
                'is_delete' => 1,
                'deleted' => '2022-12-27 13:32:00',
                'is_active' => 'Lorem ipsum dolor sit amet',
                'is_log' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'status' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
