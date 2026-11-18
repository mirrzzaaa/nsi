<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PettyCashLine Entity
 *
 * @property int $id
 * @property int $petty_cash_id
 * @property int $petty_cash_no
 * @property string|null $detail_of_request
 * @property string|null $quantity
 * @property string|null $price
 * @property string|null $amount
 * @property string|null $description
 * @property string|null $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $is_active
 *
 * @property \App\Model\Entity\PettyCash $petty_cash
 */
class PettyCashLine extends Entity
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
        'petty_cash_id' => true,
        'petty_cash_no' => true,
        'detail_of_request' => true,
        'quantity' => true,
        'price' => true,
        'amount' => true,
        'description' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
        'petty_cash' => true,
    ];
}
