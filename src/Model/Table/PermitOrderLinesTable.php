<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PermitOrderLines Model
 *
 * @property \App\Model\Table\PermitsTable&\Cake\ORM\Association\BelongsTo $Permits
 * @property \App\Model\Table\OrderLinesTable&\Cake\ORM\Association\BelongsTo $OrderLines
 *
 * @method \App\Model\Entity\PermitOrderLine newEmptyEntity()
 * @method \App\Model\Entity\PermitOrderLine newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PermitOrderLine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PermitOrderLine get($primaryKey, $options = [])
 * @method \App\Model\Entity\PermitOrderLine findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PermitOrderLine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PermitOrderLine[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PermitOrderLine|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PermitOrderLine saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PermitOrderLine[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PermitOrderLine[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PermitOrderLine[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PermitOrderLine[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PermitOrderLinesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('permit_order_lines');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Permits', [
            'foreignKey' => 'permit_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('OrderLines', [
            'foreignKey' => 'order_line_id',
            'joinType' => 'LEFT',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description'); 

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['permit_id'], 'Permits'), ['errorField' => 'permit_id']);
        $rules->add($rules->existsIn(['order_line_id'], 'OrderLines'), ['errorField' => 'order_line_id']);

        return $rules;
    }
}
