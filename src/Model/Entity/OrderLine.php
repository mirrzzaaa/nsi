<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderLine Entity
 *
 * @property int $id
 * @property int $order_id
 * @property int $item_line_id
 * @property int $item_id
 * @property string $toping
 * @property string $price_t
 * @property int|null $customer_id
 * @property string|null $number
 * @property \Cake\I18n\FrozenDate|null $date
 * @property int|null $quantity
 * @property string|null $discount
 * @property string $status_wait
 * @property string|null $unit
 * @property string|null $price
 * @property string|null $subtotal
 * @property string|null $comment
 * @property \Cake\I18n\FrozenTime|null $date_order
 * @property int|null $manifest_id
 * @property \Cake\I18n\FrozenTime|null $date_manifest
 * @property \Cake\I18n\FrozenDate|null $date_estimate_schedule
 * @property int|null $permit_id
 * @property \Cake\I18n\FrozenTime|null $date_permit
 * @property int|null $sjp_id
 * @property \Cake\I18n\FrozenTime|null $date_sjp
 * @property int|null $truck_schedule_id
 * @property \Cake\I18n\FrozenTime|null $truck_schedule_date
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
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\ItemLine $item_line
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Manifest $manifest
 * @property \App\Model\Entity\Permit $permit
 * @property \App\Model\Entity\Sjp $sjp
 * @property \App\Model\Entity\TruckSchedule $truck_schedule
 */
class OrderLine extends Entity
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
        'order_id' => true,
        'item_line_id' => true,
        'mouse_item_id' => true,
        'item_id' => true,
        'retur_line_id' => true,
        'toping' => true,
        'price_t' => true,
        'expired_date' => true,
        'customer_id' => true,
        'number' => true,
        'date' => true,
        'quantity' => true,
        'discount' => true,
        'status_wait' => true,
        'unit' => true,
        'price' => true,
        'subtotal' => true,
        'comment' => true,
        'date_order' => true,
        'manifest_id' => true,
        'date_manifest' => true,
        'date_estimate_schedule' => true,
        'permit_id' => true,
        'date_permit' => true,
        'sjp_id' => true,
        'date_sjp' => true,
        'truck_schedule_id' => true,
        'truck_schedule_date' => true,
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
        'order' => true,
        'item_line' => true,
        'item' => true,
        'mouse_item' => true,
        'customer' => true,
        'manifest' => true,
        'permit' => true,
        'sjp' => true,
        'truck_schedule' => true,
    ];
}
