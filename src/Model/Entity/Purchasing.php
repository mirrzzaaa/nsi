<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Purchasing Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int|null $customer_id
 * @property string|null $number
 * @property string|null $code
 * @property \Cake\I18n\FrozenDate|null $date
 * @property int $supplier_id
 * @property string|null $person_shop
 * @property string|null $shop_name
 * @property string $status_wait
 * @property string|null $status_approve
 * @property \Cake\I18n\FrozenDate|null $status_date
 * @property string|null $status_desc
 * @property string|null $unit
 * @property string|null $quantity
 * @property string $grandtotal
 * @property int|null $purchasing
 * @property \Cake\I18n\FrozenTime|null $date_purchasing
 * @property \Cake\I18n\FrozenTime|null $created
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
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\GoodsInWarehouse[] $goods_in_warehouses
 * @property \App\Model\Entity\PurchasingLine[] $purchasing_lines
 */
class Purchasing extends Entity
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
        'supplier_id' => true,
        'invoice_entry_id' => true,
        'goods_in_warehouse_id' => true,
        'number' => true,
        'code' => true,
        'date' => true,
        'address' => true,
        'person_shop' => true,
        'shop_name' => true,
        'status_wait' => true,
        'status_approve' => true,
        'status_date' => true,
        'status_desc' => true,
        'unit' => true, 
        'quantity' => true,
        'grandtotal' => true,
        'discount' => true,
        'ship_payment' => true,
        'ppn' => true,
        'purchasing' => true,
        'date_purchasing' => true,
        'created' => true,
        'modified' => true,
        'active' => true,
        'with_price' => true,
        'status' => true,
        'description' => true,
        'is_create' => true,
        'is_approve' => true,
        'is_cancel' => true,
        'is_update' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
        'is_log' => true,
        'branch' => true,
        'customer' => true,
        'supplier' => true,
        'warehouse' => true,
        'goods_in_warehouses' => true,
        'purchasing_lines' => true,
    ];
}
