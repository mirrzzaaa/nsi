<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchasingLine Entity
 *
 * @property int $id
 * @property int $purchasing_id
 * @property int $item_id
 * @property int|null $customer_id
 * @property string|null $number
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $quantity
 * @property string $status_wait
 * @property string|null $unit
 * @property string|null $price
 * @property int|null $order
 * @property string $subtotal
 * @property \Cake\I18n\FrozenTime|null $date_order
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $active
 * @property string|null $status
 * @property int $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $is_active
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Purchasing $purchasing
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\Customer $customer
 */
class PurchasingLine extends Entity
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
        'purchasing_id' => true,
        'item_lines_id' => true,
        'item_id' => true,
        'customer_id' => true,
        'number' => true,
        'date' => true,
        'quantity' => true,
        'quantity_in' => true,
        'discount' => true,
        'status_wait' => true,
        'unit' => true,
        'price' => true,
        'order' => true,
        'subtotal' => true,
        'date_order' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'active' => true,
        'status' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
        'is_log' => true,
        'purchasing' => true,
        'item_lines' => true,
        'items' => true,
        'customer' => true,
    ];
}
