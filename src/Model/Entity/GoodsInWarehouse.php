<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GoodsInWarehouse Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int|null $purchasing_id
 * @property int|null $warehouse_id
 * @property string|null $code
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $description
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $is_active
 * @property string|null $is_log
 * @property string|null $status
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Purchasing $purchasing
 * @property \App\Model\Entity\Warehouse $warehouse
 * @property \App\Model\Entity\GoodsInWarehouseLine[] $goods_in_warehouse_lines
 * @property \App\Model\Entity\GoodsOutWarehouseLine[] $goods_out_warehouse_lines
 * @property \App\Model\Entity\GoodsOutWarehouse[] $goods_out_warehouses
 */
class GoodsInWarehouse extends Entity
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
        'purchasing_id' => true,
        'goods_out_warehouse_id' => true,
        'goods_out_store_id' => true,
        'warehouse_id' => true,
        'code' => true,
        'number' => true,
        'is_from' => true,
        'date' => true,
        'description' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
        'is_log' => true,
        'status' => true,
        'branch' => true,
        'purchasing' => true,
        'warehouse' => true,
        'goods_in_warehouse_lines' => true,
        'goods_out_warehouse_lines' => true,
        'goods_out_warehouses' => true,
    ];
}
