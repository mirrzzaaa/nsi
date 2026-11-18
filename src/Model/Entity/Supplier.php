<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Supplier Entity
 *
 * @property int $id
 * @property string|null $code
 * @property int|null $user_id
 * @property string|null $name
 * @property string|null $address
 * @property string|null $npwp
 * @property string|null $tax
 * @property string|null $ppn
 * @property string|null $pic
 * @property string|null $telp
 * @property string|null $fax
 * @property string|null $email
 * @property string $is_active
 * @property string|null $active
 * @property string|null $is_log
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Item[] $items
 * @property \App\Model\Entity\Purchasing[] $purchasings
 */
class Supplier extends Entity
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
        'code' => true,
        'user_id' => true,
        'country_id' => true,
        'area_id' => true,
        'name' => true,
        'address' => true,
        'category' => true,
        'izin_edar' => true,
        'npwp' => true,
        'tax' => true,
        'ppn' => true,
        'pic' => true,
        'pic_dept' => true,
        'telp' => true,
        'fax' => true,
        'email' => true,
        'is_active' => true,
        'active' => true,
        'is_log' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'user' => true,
        'items' => true,
        'purchasings' => true,
    ];
}
