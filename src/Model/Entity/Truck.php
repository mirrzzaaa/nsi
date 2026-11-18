<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Truck Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int $transporter_id
 * @property string|null $name
 * @property string|null $merk
 * @property string|null $types
 * @property string|null $model
 * @property string|null $image
 * @property string|null $chassis_no
 * @property string|null $chassis_no_img
 * @property string|null $machine_no
 * @property string|null $machine_no_img
 * @property string|null $color
 * @property string|null $insurance
 * @property int|null $tire
 * @property string|null $production_year
 * @property string|null $bapedal_registration
 * @property string|null $is_log
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $is_create
 * @property string|null $active
 * @property string $is_active
 * @property string|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $is_update
 */
class Truck extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'branch_id' => true,
        'user_id' => true,
        'name' => true,
        'merk' => true,
        'model' => true,
        'image' => true,
        'chassis_no' => true,
        'chassis_no_img' => true,
        'machine_no' => true,
        'machine_no_img' => true,
        'color' => true,
        'insurance' => true,
        'tire' => true,
        'production_year' => true,
        'bapedal_registration' => true,
        'is_log' => true,
        'modified' => true,
        'created' => true,
        'is_create' => true,
        'active' => true,
        'is_active' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_update' => true,
    ];
}
