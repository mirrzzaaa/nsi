<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Member Entity
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $address
 * @property string|null $telp
 * @property string|null $hp
 * @property string|null $fax
 * @property string|null $email
 * @property int $points
 * @property string|null $npwp
 * @property \Cake\I18n\FrozenDate|null $date_registry
 * @property \Cake\I18n\FrozenDate|null $date_expired
 * @property string $tax
 * @property string|null $city
 * @property string|null $province
 * @property int|null $postal
 * @property string|null $country
 * @property string|null $pic
 * @property string|null $website
 * @property string $is_active
 * @property string|null $is_log
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $status
 *
 * @property \App\Model\Entity\Order[] $orders
 */
class Member extends Entity
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
        'name' => true,
        'address' => true,
        'telp' => true,
        'hp' => true,
        'fax' => true,
        'email' => true,
        'points' => true,
        'npwp' => true,
        'date_registry' => true,
        'date_expired' => true,
        'tax' => true,
        'city' => true,
        'province' => true,
        'postal' => true,
        'country' => true,
        'pic' => true,
        'website' => true,
        'is_active' => true,
        'is_log' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'status' => true,
        'orders' => true,
    ];
}
