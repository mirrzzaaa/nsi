<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MouseItem Entity
 *
 * @property int $id
 * @property int|null $mouse_id
 * @property int|null $item_id
 * @property string|null $price
 * @property string|null $description
 * @property string|null $unit
 * @property int|null $is_create
 * @property int|null $is_update
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Mouse $mouse
 * @property \App\Model\Entity\Item $item
 */
class MouseItem extends Entity
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
        'mouse_id' => true,
        'item_id' => true,
        'customer_id' => true,
        'price' => true,
        'description' => true,
        'unit' => true,
        'is_create' => true,
        'is_update' => true,
        'created' => true,
        'modified' => true,
        'is_log' => true,
        'mouse' => true,
        'item' => true,
        'customer' => true,
    ];
}
