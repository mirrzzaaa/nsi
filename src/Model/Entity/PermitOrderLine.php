<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PermitOrderLine Entity
 *
 * @property int $id
 * @property int $permit_id
 * @property int $order_line_id
 *
 * @property \App\Model\Entity\Permit $permit
 * @property \App\Model\Entity\OrderLine $order_line
 */
class PermitOrderLine extends Entity
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
        'permit_id' => true,
        'order_line_id' => true,
        'permit' => true,
        'order_line' => true,
        'description' => true,
        'created' => true,
    ];
}
