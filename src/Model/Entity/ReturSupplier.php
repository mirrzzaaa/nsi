<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReturSupplier Entity
 *
 * @property int $id
 * @property int $supplier_id
 * @property int $purchasing_id
 * @property int $branch_id
 * @property int $warehouse_id
 * @property string|null $code
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $reason
 * @property string|null $total
 * @property int|null $is_create
 * @property int|null $is_update
 * @property string|null $is_active
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\Purchasing $purchasing
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Warehouse $warehouse
 * @property \App\Model\Entity\ReturSupplierLine[] $retur_supplier_lines
 */
class ReturSupplier extends Entity
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
        'supplier_id' => true,
        'purchasing_id' => true,
        'branch_id' => true,
        'warehouse_id' => true,
        'code' => true,
        'date' => true,
        'reason' => true,
        'total' => true,
        'is_create' => true,
        'is_update' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'supplier' => true,
        'purchasing' => true,
        'branch' => true,
        'warehouse' => true,
        'retur_supplier_lines' => true,
    ];
}
