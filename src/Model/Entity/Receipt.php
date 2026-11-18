<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Receipt Entity
 *
 * @property int $id
 * @property string $branch_id
 * @property int $invoice_id
 * @property int $customer_id
 * @property int $order_id
 * @property string $code
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $description
 * @property string|null $nominal
 * @property string|null $payment_type
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property int|null $is_print
 * @property \Cake\I18n\FrozenTime|null $print_date
 * @property int|null $print
 * @property string|null $is_active
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Invoice $invoice
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Order $order
 */
class Receipt extends Entity
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
        'invoice_id' => true,
        'customer_id' => true,
        'order_id' => true,
        'code' => true,
        'date' => true,
        'description' => true,
        'nominal' => true,
        'payment_type' => true,
        'presentase' => true,
        'payment_jumlah_1' => true,
        'payment_jumlah_2' => true,
        'payment_jumlah_3' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_print' => true,
        'print_date' => true,
        'print' => true,
        'is_active' => true,
        'branch' => true,
        'invoice' => true,
        'customer' => true,
        'order' => true,
    ];
}
