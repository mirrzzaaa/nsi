<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Offer Entity
 *
 * @property int $id
 * @property string $branch_id
 * @property string|null $number
 * @property string|null $code
 * @property \Cake\I18n\FrozenDate|null $date
 * @property int|null $customer_id
 * @property string|null $customer_name
 * @property string|null $customer_address
 * @property string|null $attn_1
 * @property string|null $attn_2
 * @property string|null $perihal
 * @property string|null $description
 * @property string|null $info
 * @property string|null $klasifikasi
 * @property int|null $kabupaten_id
 * @property string|null $kabupaten_price_trip
 * @property int|null $print
 * @property int|null $is_marketing
 * @property int|null $is_approve
 * @property \Cake\I18n\FrozenTime|null $approve_date
 * @property int|null $is_print
 * @property \Cake\I18n\FrozenTime|null $print_date
 * @property string|null $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $is_active
 * @property string|null $is_log
 * @property string|null $active
 * @property string|null $status
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Kabupaten $kabupaten
 */
class Offer extends Entity
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
        'number' => true,
        'code' => true,
        'date' => true,
        'customer_id' => true,
        'customer_name' => true,
        'customer_address' => true,
        'attn_1' => true,
        'attn_2' => true,
        'perihal' => true,
        'waste_type' => true,
        'description' => true,
        'info' => true,
        'klasifikasi' => true,
        'kabupaten_id' => true,
        'kabupaten_price_trip' => true,
        'print' => true,
        'is_marketing' => true,
        'is_approve' => true,
        'approve_date' => true,
        'is_print' => true,
        'print_date' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
        'is_log' => true,
        'active' => true,
        'status' => true,
        'branch' => true,
        'customer' => true,
        'kabupaten' => true,
    ];
}
