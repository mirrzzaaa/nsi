<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GoodsInStore Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int|null $store_id
 * @property int|null $goods_out_warehouse_id
 * @property int|null $goods_out_store_id
 * @property string|null $status_in
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
 * @property \App\Model\Entity\Store $store
 * @property \App\Model\Entity\GoodsOutWarehouse[] $goods_out_warehouses
 * @property \App\Model\Entity\GoodsOutStore $goods_out_store
 * @property \App\Model\Entity\GoodsInStoreLine[] $goods_in_store_lines
 */
class GoodsInStore extends Entity
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
        'store_id' => true,
        'goods_out_warehouse_id' => true,
        'goods_out_store_id' => true,
        'status_in' => true,
        'is_from' => true,
        'code' => true,
        'number' => true,
        'date' => true,
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
        'store' => true,
        'goods_out_warehouses' => true,
        'goods_out_store' => true,
        'goods_in_store_lines' => true,
    ];
}
