<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InvoiceEntryLine Entity
 *
 * @property int $id
 * @property int $invoice_entry_id
 * @property int $item_id
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
 * @property \App\Model\Entity\InvoiceEntry $invoice_entry
 * @property \App\Model\Entity\Item $item
 */
class InvoiceEntryLine extends Entity
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
        'invoice_entry_id' => true,
        'item_id' => true,
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
        'invoice_entry' => true,
        'item' => true,
    ];
}
