<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Letter Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property string $number
 * @property string|null $code
 * @property string|null $project
 * @property string $coded
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $purpose
 * @property string|null $description
 * @property int|null $applicant
 * @property int|null $approved
 * @property \Cake\I18n\FrozenTime|null $approved_date
 * @property int|null $knowing
 * @property int|null $approved_ceo
 * @property \Cake\I18n\FrozenTime|null $approved_ceo_date
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
 */
class Letter extends Entity
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
        'number' => true,
        'code' => true,
        'project' => true,
        'coded' => true,
        'date' => true,
        'branch' => true,
        'purpose' => true,
        'description' => true,
        'applicant' => true,
        'approved' => true,
        'approved_date' => true,
        'knowing' => true,
        'approved_ceo' => true,
        'approved_ceo_date' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
        'is_log' => true,
    ];
}
