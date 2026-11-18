<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
        'code' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => '0', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'staff' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => '0', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'password' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => '0', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'password_new' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => '0', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'help_hint_pwd' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => '0', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'telp' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'email' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'devision' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'position' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'marketing_code' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'approved' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'N', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'approved_ceo' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'N', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'payment' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'N', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'pettycash_full_access' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'N', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'hris_approved' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'N', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'hris_knowing' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'N', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'hris_full_access' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'N', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'rule' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'rules' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'rule_acc' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'jurnal_type_acc' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'change_password' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'change_password_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'reset' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'reset_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'is_create' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'is_update' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'is_delete' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'is_active' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'Y', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'is_log' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'who_create' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'who_update' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'last_login' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'status' => ['type' => 'string', 'length' => 5, 'null' => true, 'default' => '0', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'level' => ['type' => 'string', 'length' => 5, 'null' => true, 'default' => '0', 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null],
        'visited' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
                'code' => 'Lorem ipsum dolor ',
                'staff' => 'Lorem ipsum dolor ',
                'name' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'password_new' => 'Lorem ipsum dolor sit amet',
                'help_hint_pwd' => 'Lorem ipsum dolor sit amet',
                'telp' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'devision' => 'Lorem ipsum dolor sit amet',
                'position' => 'Lorem ipsum dolor sit amet',
                'marketing_code' => 'Lorem ipsum dolor sit amet',
                'approved' => 'Lorem ipsum dolor sit amet',
                'approved_ceo' => 'Lorem ipsum dolor sit amet',
                'payment' => 'Lorem ipsum dolor sit amet',
                'pettycash_full_access' => 'Lorem ipsum dolor sit amet',
                'hris_approved' => 'Lorem ipsum dolor sit amet',
                'hris_knowing' => 'Lorem ipsum dolor sit amet',
                'hris_full_access' => 'Lorem ipsum dolor sit amet',
                'rule' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'rules' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'rule_acc' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'jurnal_type_acc' => 'Lorem ipsum dolor sit amet',
                'change_password' => 'Lorem ipsum dolor sit amet',
                'change_password_date' => '2022-12-07 14:52:40',
                'reset' => 1,
                'reset_date' => '2022-12-07 14:52:40',
                'is_create' => 1,
                'is_update' => 1,
                'is_delete' => 1,
                'deleted' => '2022-12-07 14:52:40',
                'is_active' => 'Lorem ipsum dolor sit amet',
                'is_log' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'who_create' => 'Lorem ipsum dolor sit amet',
                'created' => '2022-12-07 14:52:40',
                'who_update' => 'Lorem ipsum dolor sit amet',
                'modified' => '2022-12-07 14:52:40',
                'last_login' => '2022-12-07 14:52:40',
                'status' => 'Lor',
                'level' => 'Lor',
                'visited' => 1,
            ],
        ];
        parent::init();
    }
}
