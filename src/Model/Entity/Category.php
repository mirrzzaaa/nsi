<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $branch_id
 * @property string $code
 * @property string|null $name
 * @property string|null $note
 * @property string $is_view
 * @property string $is_active
 * @property string|null $is_log
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $status
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Item[] $items
 */
class Category extends Entity
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
        'branch_id' => true,
        'code' => true,
        'name' => true,
        'note' => true,
        'is_view' => true,
        'is_active' => true,
        'is_log' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'status' => true,
        'branch' => true,
        'user' => true,
        'items' => true,
    ];
}
