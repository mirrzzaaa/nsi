<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property string $branch_id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $title
 * @property string|null $nickname
 * @property string|null $marketing_id
 * @property string|null $contact_person
 * @property string|null $dept_person
 * @property string|null $telp_person
 * @property string|null $address_penghasil
 * @property string|null $province
 * @property int|null $postal
 * @property string|null $website
 * @property string|null $email1
 * @property string|null $email2
 * @property string|null $name_invoice
 * @property string|null $phone_invoice
 * @property string|null $fax_invoice
 * @property string|null $address_invoice
 * @property string|null $name_tax_invoice
 * @property string|null $phone_tax_invoice
 * @property string|null $fax_tax_invoice
 * @property string|null $address_tax_invoice
 * @property string|null $npwp
 * @property string|null $bank_name_ori
 * @property string|null $bank_norek_ori
 * @property string|null $va_no
 * @property string|null $va_name
 * @property string|null $ppn
 * @property string|null $district
 * @property string $is_active
 * @property string|null $is_log
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $active
 * @property string|null $is_create
 * @property string|null $is_update
 * @property string|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\User $user
 */
class Customer extends Entity
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
        'code' => true,
        'user_id' => true,
        'name' => true,
        'title' => true,
        'nickname' => true,
        'marketing_id' => true,
        'contact_person' => true,
        'dept_person' => true,
        'telp_person' => true,
        'address_penghasil' => true,
        'area' => true,
        'province' => true,
        'postal' => true,
        'website' => true,
        'email1' => true,
        'email2' => true,
        'name_invoice' => true,
        'phone_invoice' => true,
        'fax_invoice' => true,
        'address_invoice' => true,
        'name_tax_invoice' => true,
        'phone_tax_invoice' => true,
        'fax_tax_invoice' => true,
        'address_tax_invoice' => true,
        'npwp' => true,
        'bank_name_ori' => true,
        'bank_norek_ori' => true,
        'va_no' => true,
        'va_name' => true,
        'ppn' => true,
        'district' => true,
        'is_active' => true,
        'is_log' => true,
        'created' => true,
        'modified' => true,
        'active' => true,
        'is_create' => true,
        'is_update' => true,
        'is_delete' => true,
        'deleted' => true,
        'branch' => true,
        'user' => true,
    ];
}
