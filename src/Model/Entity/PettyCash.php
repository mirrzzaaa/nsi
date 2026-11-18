<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PettyCash Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property string $code_old
 * @property string $code
 * @property string|null $project
 * @property string $coded
 * @property \Cake\I18n\FrozenDate|null $date
 * @property \Cake\I18n\FrozenDate|null $due_date
 * @property string|null $devision
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
 * @property \App\Model\Entity\PettyCashLine[] $petty_cash_lines
 */
class PettyCash extends Entity
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
        'code_old' => true,
        'code' => true,
        'project' => true,
        'coded' => true,
        'date' => true,
        'due_date' => true,
        'devision' => true,
        'purpose_of_advancing' => true,
        'description' => true,
        'applicant' => true,
        'approved' => true,
        'approved_date' => true,
        'knowing' => true,
        'approved_acc' => true,
        'approved_acc_date' => true,
        'approved_ceo' => true,
        'approved_ceo_date' => true,
        'payment' => true,
        'payment_date' => true,
        'payment_date_now' => true,
        'payment_type' => true,
        'payment_last' => true,
        'payment_nominal' => true,
        'payment_desc' => true,
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
        'petty_cash_lines' => true,
    ];
}
