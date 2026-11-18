<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Retur Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property string|null $code
 * @property string|null $number
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $reason
 * @property string|null $total
 * @property int|null $is_create
 * @property int|null $is_update
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\ReturLine[] $retur_lines
 */
class Retur extends Entity
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
        'customer_id' => true,
        'order_id' => true,
        'warehouse_id' => true,
        'supplier_id' => true,
        'code' => true,
        'number' => true,
        'date' => true,
        'reason' => true,
        'total' => true,
        'is_create' => true,
        'is_update' => true,
        'created' => true,
        'modified' => true,
        'retur_lines' => true,
    ];
}
