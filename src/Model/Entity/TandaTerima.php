<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TandaTerima Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $invoice_id
 * @property int $permit_id
 * @property string|null $code
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $no_faktur
 * @property string|null $no_ba
 * @property \Cake\I18n\FrozenDate|null $payment_date
 * @property int|null $is_create
 * @property int|null $is_update
 * @property int|null $is_print
 * @property \Cake\I18n\FrozenTime|null $date_print
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Invoice $invoice
 * @property \App\Model\Entity\Permit $permit
 */
class TandaTerima extends Entity
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
        'user_id' => true,
        'invoice_id' => true,
        'permit_id' => true,
        'code' => true,
        'date' => true,
        'no_faktur' => true,
        'no_ba' => true,
        'description' => true,
        'payment_date' => true,
        'is_create' => true,
        'is_update' => true,
        'is_print' => true,
        'date_print' => true,
        'created' => true,
        'modified' => true,
        'is_log' => true,
        'user' => true,
        'invoice' => true,
        'permit' => true,
    ];
}
