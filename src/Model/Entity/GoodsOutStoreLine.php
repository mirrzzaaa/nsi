<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GoodsOutStoreLine Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int|null $goods_out_store_id
 * @property int|null $item_lines_id
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
 * @property \App\Model\Entity\GoodsOutStore $goods_out_store
 * @property \App\Model\Entity\ItemLine $item_line
 */
class GoodsOutStoreLine extends Entity
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
        'goods_out_store_id' => true,
        'item_lines_id' => true,
        'item_id' => true,
        'code' => true,
        'unit' => true,
        'qty' => true,
        'qty_out' => true,
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
        'goods_out_store' => true,
        'item_line' => true,
        'item' => true,
    ];
}
