<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Permit Entity
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $invoice_id
 * @property int|null $truck_id
 * @property string|null $delivered
 * @property string|null $code
 * @property \Cake\I18n\FrozenDate|null $date
 * @property int|null $is_create
 * @property int|null $is_update
 * @property int|null $is_print
 * @property \Cake\I18n\FrozenTime|null $date_print
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\Invoice $invoice
 * @property \App\Model\Entity\Truck $truck
 * @property \App\Model\Entity\OrderLine[] $order_lines
 */
class Permit extends Entity
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
        'order_line_id' => true,
        'invoice_id' => true,
        'customer_id' => true,
        'truck_id' => true,
        'goods_out_warehouse_id' => true,
        'tanda_terima_id' => true,
        'delivered' => true,
        'description' => true,
        'code' => true,
        'date' => true,
        'is_create' => true,
        'is_update' => true,
        'is_print' => true,
        'is_active' => true,
        'date_print' => true,
        'created' => true,
        'modified' => true,
        'is_log' => true,
        'orders' => true,
        'invoice' => true,
        'truck' => true,
        'order_lines' => true,
    ];
}
