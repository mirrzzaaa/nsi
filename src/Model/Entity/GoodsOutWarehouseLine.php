<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GoodsOutWarehouseLine Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int|null $goods_out_warehouse_id
 * @property int|null $goods_in_warehouse_id
 * @property int|null $goods_in_warehouse_line_id
 * @property int|null $warehouse_stock_id
 * @property int|null $item_id
 * @property string|null $code
 * @property string|null $unit
 * @property string|null $qty
 * @property string|null $packing
 * @property string|null $description
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
 * @property \App\Model\Entity\GoodsOutWarehouse $goods_out_warehouse
 * @property \App\Model\Entity\GoodsInWarehouse $goods_in_warehouse
 * @property \App\Model\Entity\GoodsInWarehouseLine[] $goods_in_warehouse_lines
 * @property \App\Model\Entity\WarehouseStock $warehouse_stock
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\GoodsInStoreLine[] $goods_in_store_lines
 */
class GoodsOutWarehouseLine extends Entity
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
        'goods_out_warehouse_id' => true,
        'goods_in_warehouse_id' => true,
        'goods_in_warehouse_line_id' => true,
        'warehouse_stock_id' => true,
        'item_lines_id' => true,
        'item_id' => true,
        'name' => true,
        'unit' => true,
        'qty' => true,
        'qty_out' => true,
        'nomor_seri' => true,
        'kode_produk' => true,
        'supplier_code' => true,
        'supplier_name' => true,
        'packing' => true,
        'description' => true,
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
        'goods_out_warehouse' => true,
        'goods_in_warehouse' => true,
        'goods_in_warehouse_lines' => true,
        'warehouse_stock' => true,
        'item_lines' => true,
        'item' => true,
        'goods_in_store_lines' => true,
    ];
}
