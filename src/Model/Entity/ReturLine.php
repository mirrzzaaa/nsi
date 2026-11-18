<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReturLine Entity
 *
 * @property int $id
 * @property int|null $order_lines_id
 * @property int|null $retur_id
 * @property int|null $quantity
 * @property string|null $nominal
 * @property string|null $condition
 * @property int|null $is_create
 * @property int|null $is_update
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\OrderLine $order_line
 */
class ReturLine extends Entity
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
        'retur_id' => true,
        'order_lines_id' => true,
        'warehouse_stock_id' => true,
        'branch_stock_id' => true,
        'item_id' => true,
        'quantity' => true,
        'nominal' => true,
        'reason' => true,
        'nomor_seri' => true,
        'kode_produk' => true,
        'supplier_code' => true,
        'supplier_name' => true,
        'is_create' => true,
        'is_update' => true,
        'created' => true,
        'modified' => true,
        'order_line' => true,
    ];
}
