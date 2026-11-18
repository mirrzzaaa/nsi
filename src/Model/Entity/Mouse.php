<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Mouse Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property string $customer_id
 * @property string|null $customer_no
 * @property int|null $transporter_id_1
 * @property string|null $transporter_no_1
 * @property int|null $transporter_id_2
 * @property string|null $transporter_no_2
 * @property int|null $transporter_id_3
 * @property string|null $transporter_no_3
 * @property int|null $transporter_id_4
 * @property string|null $transporter_no_4
 * @property int|null $transporter_id_5
 * @property string|null $transporter_no_5
 * @property int|null $processor_id
 * @property string|null $processor_no
 * @property string|null $klasifikasi
 * @property \Cake\I18n\FrozenDate|null $date_contract
 * @property \Cake\I18n\FrozenDate|null $date_expired
 * @property string|null $invoice_name
 * @property string|null $code
 * @property string|null $code_name
 * @property string|null $pihak
 * @property string|null $name
 * @property string|null $deposit
 * @property \Cake\I18n\FrozenDate|null $date_deposit
 * @property string|null $saldo
 * @property int|null $is_approve
 * @property \Cake\I18n\FrozenTime|null $date_approve
 * @property string|null $type
 * @property string|null $class
 * @property string|null $price
 * @property string|null $price_netto
 * @property string|null $unit
 * @property string|null $paket_desc
 * @property string|null $pic_name
 * @property string|null $pic_telp
 * @property string|null $pic_hp
 * @property string|null $pic_email
 * @property string|null $pic_title
 * @property string|null $is_active
 * @property string|null $is_log
 * @property string|null $is_create
 * @property string|null $is_update
 * @property string|null $who_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $who_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $active
 * @property string|null $status
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Processor $processor
 */
class Mouse extends Entity
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
        'customer_id' => true,
        'customer_no' => true,
        'transporter_id_1' => true,
        'transporter_no_1' => true,
        'transporter_id_2' => true,
        'transporter_no_2' => true,
        'transporter_id_3' => true,
        'transporter_no_3' => true,
        'transporter_id_4' => true,
        'transporter_no_4' => true,
        'transporter_id_5' => true,
        'transporter_no_5' => true,
        'processor_id' => true,
        'processor_no' => true,
        'klasifikasi' => true,
        'date_contract' => true,
        'date_expired' => true,
        'invoice_name' => true,
        'code' => true,
        'code_name' => true,
        'pihak' => true,
        'name' => true,
        'deposit' => true,
        'date_deposit' => true,
        'saldo' => true,
        'is_approve' => true,
        'date_approve' => true,
        'type' => true,
        'class' => true,
        'price' => true,
        'price_netto' => true,
        'unit' => true,
        'paket_desc' => true,
        'pic_name' => true,
        'pic_telp' => true,
        'pic_hp' => true,
        'pic_email' => true,
        'pic_title' => true,
        'is_active' => true,
        'is_log' => true,
        'is_create' => true,
        'is_update' => true,
        'who_create' => true,
        'created' => true,
        'who_update' => true,
        'modified' => true,
        'active' => true,
        'status' => true,
        'branch' => true,
        'customer' => true,
        'processor' => true,
        'mouse_items' => true
    ];
}
