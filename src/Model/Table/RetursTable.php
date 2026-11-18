<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Returs Model
 *
 * @property \App\Model\Table\ReturLinesTable&\Cake\ORM\Association\HasMany $ReturLines
 *
 * @method \App\Model\Entity\Retur newEmptyEntity()
 * @method \App\Model\Entity\Retur newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Retur[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Retur get($primaryKey, $options = [])
 * @method \App\Model\Entity\Retur findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Retur patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Retur[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Retur|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Retur saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Retur[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Retur[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Retur[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Retur[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RetursTable extends Table
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

        $this->setTable('returs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Warehouses', [
            'foreignKey' => 'warehouse_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'LEFT',
        ]);

        $this->hasMany('ReturLines', [
            'foreignKey' => 'retur_id',
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
            ->scalar('code')
            ->maxLength('code', 255)
            ->allowEmptyString('code');

        $validator
            ->scalar('number')
            ->maxLength('number', 255)
            ->allowEmptyString('number');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('reason')
            ->maxLength('reason', 50)
            ->allowEmptyString('reason');

        $validator
            ->decimal('total')
            ->allowEmptyString('total');

        $validator
            ->integer('is_create')
            ->allowEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->allowEmptyString('is_update');

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
        $rules->add($rules->existsIn(['branch_id'], 'Branches'), ['errorField' => 'branch_id']);
        $rules->add($rules->existsIn(['warehouse_id'], 'Warehouses'), ['errorField' => 'warehouse_id']);
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn(['order_id'], 'Orders'), ['errorField' => 'order_id']);

        return $rules;
    }
}
