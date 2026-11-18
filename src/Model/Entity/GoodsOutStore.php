<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GoodsOutStore Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int|null $order_id
 * @property int|null $return_goods_id
 * @property string|null $status_out
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
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\ReturnGood $return_good
 * @property \App\Model\Entity\GoodsInStore[] $goods_in_stores
 * @property \App\Model\Entity\GoodsOutStoreLine[] $goods_out_store_lines
 */
class GoodsOutStore extends Entity
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
        'order_id' => true,
        'return_id' => true,
        'branch_stock_id' => true,
        'status_out' => true,
        'is_to' => true,
        'code' => true,
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
        'order' => true,
        'return_good' => true,
        'goods_in_stores' => true,
        'goods_out_store_lines' => true,
    ];
}
