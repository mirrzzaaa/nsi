<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WarehouseStock Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int|null $item_lines_id
 * @property int|null $warehouse_id
 * @property string|null $code
 * @property string|null $unit
 * @property string|null $stock
 * @property string|null $packing
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
 * @property \App\Model\Entity\ItemLine $item_line
 * @property \App\Model\Entity\Warehouse $warehouse
 * @property \App\Model\Entity\GoodsOutWarehouseLine[] $goods_out_warehouse_lines
 */
class WarehouseStock extends Entity
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
        'item_id' => true,
        'warehouse_id' => true,
        'code' => true,
        'unit' => true,
        'stock' => true,
        'buy' => true,
        'sell' => true,
        'packing' => true,
        'izin_edar' => true, 
        'type' => true,
        'ukuran' => true,
        'date' => true,
        'expired_date' => true,
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
        'item' => true,
        'warehouse' => true,
        'goods_out_warehouse_lines' => true,
    ];
}
