<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReturSupplierLine Entity
 *
 * @property int $id
 * @property int $retur_supplier_id
 * @property int $purchasing_lines_id
 * @property int $warehouse_stock_id
 * @property int $branch_stock_id
 * @property int|null $quantity
 * @property string|null $nominal
 * @property string|null $reason
 * @property int|null $is_create
 * @property int|null $is_update
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\ReturSupplier $retur_supplier
 * @property \App\Model\Entity\PurchasingLine $purchasing_line
 * @property \App\Model\Entity\WarehouseStock $warehouse_stock
 * @property \App\Model\Entity\BranchStock $branch_stock
 */
class ReturSupplierLine extends Entity
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
        'retur_supplier_id' => true,
        'purchasing_lines_id' => true,
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
        'retur_supplier' => true,
        'purchasing_line' => true,
        'warehouse_stock' => true,
        'branch_stock' => true,
    ];
}
