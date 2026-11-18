<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int|null $customer_id
 * @property int|null $member_id
 * @property int|null $table_id
 * @property string|null $code
 * @property string|null $number
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $subtotal
 * @property string|null $addon
 * @property string|null $tax
 * @property string|null $grandtotal
 * @property string|null $pay
 * @property string|null $diff
 * @property string|null $discount
 * @property string|null $payment_method
 * @property string $status_wait
 * @property string|null $status_approve
 * @property \Cake\I18n\FrozenDate|null $status_date
 * @property string|null $status_desc
 * @property string|null $waste_id
 * @property int|null $waste_type_id
 * @property int|null $processor_id
 * @property string|null $unit
 * @property string|null $quantity
 * @property int|null $order
 * @property int|null $cashier_id
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
 * @property int|null $who_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int|null $who_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $active
 * @property string|null $status
 * @property int $is_create
 * @property int $is_update
 * @property int $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $is_active
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Member $member
 * @property \App\Model\Entity\Table $table
 * @property \App\Model\Entity\Waste $waste
 * @property \App\Model\Entity\WasteType $waste_type
 * @property \App\Model\Entity\Processor $processor
 * @property \App\Model\Entity\Cashier $cashier
 * @property \App\Model\Entity\Manifest $manifest
 * @property \App\Model\Entity\Permit $permit
 * @property \App\Model\Entity\Sjp $sjp
 * @property \App\Model\Entity\TruckSchedule $truck_schedule
 * @property \App\Model\Entity\GoodsOutStore[] $goods_out_stores
 * @property \App\Model\Entity\OrderLine[] $order_lines
 */
class Order extends Entity
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
        'warehouse_id' => true,
        'customer_id' => true, 
        'retur_id' => true, 
        'member_id' => true,
        'table_id' => true,
        'invoice_id' => true,
        'code' => true,
        'number' => true,
        'po_number' => true,
        'date' => true,
        'subtotal' => true,
        'addon' => true,
        'tax' => true,
        'with_price' => true,
        'ppn' => true,
        'deliver_pays' => true,
        'grandtotal' => true,
        'pay' => true,
        'diff' => true,
        'discount' => true,
        'customer' => true,
        'keterangan' => true,
        'deliver_pay' => true,
        'payment_method' => true,
        'debit_card' => true,
        'credit_card' => true,
        'note' => true,
        'status_wait' => true,
        'status_approve' => true,
        'status_date' => true,
        'status_desc' => true,
        'waste_id' => true,
        'waste_type_id' => true,
        'processor_id' => true,
        'unit' => true,
        'quantity' => true,
        'order' => true,
        'cashier_id' => true,
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
        'who_create' => true,
        'created' => true,
        'who_update' => true,
        'modified' => true,
        'active' => true,
        'status' => true,
        'is_create' => true,
        'is_update' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
        'is_log' => true,
        'branch' => true,
        'member' => true,
        'table' => true,
        'waste' => true,
        'waste_type' => true,
        'processor' => true,
        'cashier' => true,
        'manifest' => true,
        'permit' => true,
        'sjp' => true,
        'truck_schedule' => true,
        'goods_out_stores' => true,
        'order_lines' => true,
    ];
}
