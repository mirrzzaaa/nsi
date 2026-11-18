<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InvoiceEntry Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int $purchasing_id
 * @property string $code
 * @property string|null $company
 * @property \Cake\I18n\FrozenDate|null $date
 * @property \Cake\I18n\FrozenDate|null $due_date
 * @property string|null $purpose_of_advancing
 * @property string|null $description
 * @property int|null $applicant
 * @property int|null $approved
 * @property \Cake\I18n\FrozenTime|null $approved_date
 * @property int|null $knowing
 * @property int|null $approved_acc
 * @property \Cake\I18n\FrozenTime|null $approved_acc_date
 * @property int|null $approved_ceo
 * @property \Cake\I18n\FrozenTime|null $approved_ceo_date
 * @property int|null $payment
 * @property \Cake\I18n\FrozenDate|null $payment_date
 * @property \Cake\I18n\FrozenTime|null $payment_date_now
 * @property string|null $payment_type
 * @property string|null $payment_last
 * @property string|null $payment_nominal
 * @property string|null $payment_desc
 * @property string|null $payment_status
 * @property \Cake\I18n\FrozenDate|null $accountability_date
 * @property string|null $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string $is_active
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Purchasing $purchasing
 * @property \App\Model\Entity\InvoiceEntryLine[] $invoice_entry_lines
 */
class InvoiceEntry extends Entity
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
        'purchasing_id' => true,
        'purchasing_line_id' => true,
        'code' => true,
        'company' => true,
        'date' => true,
        'due_date' => true,
        'purpose_of_advancing' => true,
        'description' => true,
        'ppn' => true,
        'applicant' => true,
        'approved' => true,
        'approved_date' => true,
        'knowing' => true,
        'approved_acc' => true,
        'approved_acc_date' => true,
        'approved_ceo' => true,
        'approved_ceo_date' => true,
        'payment' => true,
        'payment_1' => true,
        'payment_date' => true,
        'payment_1_date' => true,
        'payment_date_now' => true,
        'payment_type' => true,
        'payment_1_type' => true,
        'payment_last' => true,
        'payment_nominal' => true,
        'payment_1_nominal' => true,
        'payment_desc' => true,
        'payment_1_desc' => true,
        'payment_status' => true,
        'accountability_date' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
        'is_log' => true,
        'branch' => true,
        'purchasing' => true,
        // 'invoice_entry_lines' => true,
    ];
}
