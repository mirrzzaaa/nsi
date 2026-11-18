<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemLine Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int $item_id
 * @property string $code
 * @property string|null $name
 * @property string|null $image
 * @property string|null $raw_materials_id
 * @property string|null $barcode
 * @property string|null $unit
 * @property string|null $selling_price
 * @property string|null $rent_cost
 * @property string $stock
 * @property string $weight
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string $is_view
 * @property string $is_active
 * @property string|null $is_log
 * @property string|null $status
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\OrderLine[] $order_lines
 */
class ItemLine extends Entity
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
        'code' => true,
        'name' => true,
        'image' => true,
        'raw_materials_id' => true,
        'barcode' => true,
        'unit' => true,
        'selling_price' => true,
        'cost_price' => true,
        'rent_cost' => true,
        'stock' => true,
        'stock_min' => true,
        'weight' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_view' => true,
        'is_active' => true,
        'is_log' => true,
        'status' => true,
        'branch' => true,
        'item' => true,
        'order_lines' => true,
    ];
}
