<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int $category_id
 * @property int $supplier_id
 * @property string $code
 * @property string|null $name
 * @property string|null $sku
 * @property string|null $barcode
 * @property string|null $weight
 * @property string|null $unit
 * @property string $stock
 * @property string|null $last_stock
 * @property string|null $min_stock
 * @property string|null $description
 * @property string|null $image
 * @property string|null $raw_materials_id
 * @property string|null $selling_price
 * @property string|null $cost_price
 * @property string|null $rent_cost
 * @property string|null $phone1
 * @property string|null $phone2
 * @property string|null $phone3
 * @property string|null $group
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
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\ItemLine[] $item_lines
 */
class Item extends Entity
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
        'category_id' => true,
        'supplier_id' => true,
        'satuan_id' => true,
        'code' => true,
        'name' => true,
        'sku' => true,
        'barcode' => true,
        'code_internal' => true,
        'type' => true,
        'weight' => true,
        'unit' => true,
        'stock' => true,
        'last_stock' => true,
        'min_stock' => true,
        'izin_edar' => true, 
        'type' => true,
        'ukuran' => true,
        'description' => true,
        'expired_date' => true,
        'image' => true,
        'raw_materials_id' => true,
        'selling_price' => true,
        'buying_price' => true,
        'cost_price' => true,
        'rent_cost' => true,
        'phone1' => true,
        'phone2' => true,
        'phone3' => true,
        'group' => true,
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
        'warehouse' => true,
        'category' => true,
        'item_lines' => true,
    ];
}
