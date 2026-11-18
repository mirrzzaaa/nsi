<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GoodsOutWarehouse Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int|null $goods_in_warehouse_id
 * @property int|null $warehouse_id
 * @property int|null $store_id
 * @property int|null $goods_in_store_id
 * @property string|null $code
 * @property \Cake\I18n\FrozenDate|null $date
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
 * @property \App\Model\Entity\GoodsInWarehouse $goods_in_warehouse
 * @property \App\Model\Entity\Warehouse $warehouse
 * @property \App\Model\Entity\Store $store
 * @property \App\Model\Entity\GoodsInStore[] $goods_in_stores
 * @property \App\Model\Entity\GoodsInStoreLine[] $goods_in_store_lines
 * @property \App\Model\Entity\GoodsInWarehouseLine[] $goods_in_warehouse_lines
 * @property \App\Model\Entity\GoodsOutWarehouseLine[] $goods_out_warehouse_lines
 */
class GoodsOutWarehouse extends Entity
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
        'goods_in_warehouse_id' => true,
        'permit_id' => true,
        'warehouse_id' => true,
        'store_id' => true,
        'goods_in_store_id' => true,
        'code' => true,
        'number' => true,
        'description' => true,
        'date' => true,
        'is_to' => true,
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
        'goods_in_warehouse' => true,
        'warehouse' => true,
        'store' => true,
        'permit' => true,
        'goods_in_stores' => true,
        'goods_in_store_lines' => true,
        'goods_in_warehouse_lines' => true,
        'goods_out_warehouse_lines' => true,
    ];
}
