<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GoodsInStores Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\StoresTable&\Cake\ORM\Association\BelongsTo $Stores
 * @property \App\Model\Table\GoodsOutWarehousesTable&\Cake\ORM\Association\BelongsTo $GoodsOutWarehouses
 * @property \App\Model\Table\GoodsOutStoresTable&\Cake\ORM\Association\BelongsTo $GoodsOutStores
 * @property \App\Model\Table\GoodsInStoreLinesTable&\Cake\ORM\Association\HasMany $GoodsInStoreLines
 * @property \App\Model\Table\GoodsOutWarehousesTable&\Cake\ORM\Association\HasMany $GoodsOutWarehouses
 *
 * @method \App\Model\Entity\GoodsInStore newEmptyEntity()
 * @method \App\Model\Entity\GoodsInStore newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\GoodsInStore[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GoodsInStore get($primaryKey, $options = [])
 * @method \App\Model\Entity\GoodsInStore findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\GoodsInStore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GoodsInStore[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GoodsInStore|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GoodsInStore saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GoodsInStore[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsInStore[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsInStore[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsInStore[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GoodsInStoresTable extends Table
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

        $this->setTable('goods_in_stores');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        // $this->belongsTo('Stores', [
        //     'foreignKey' => 'store_id',
        // ]);
        $this->belongsTo('GoodsOutWarehouses', [
            'foreignKey' => 'goods_out_warehouse_id',
        ]);
        $this->belongsTo('GoodsOutStores', [
            'foreignKey' => 'goods_out_store_id',
        ]);
        $this->hasMany('GoodsInStoreLines', [
            'foreignKey' => 'goods_in_store_id',
        ]);
        // $this->hasMany('GoodsOutWarehouses', [
        //     'foreignKey' => 'goods_in_store_id',
        // ]);
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
            ->scalar('status_in')
            ->maxLength('status_in', 50)
            ->allowEmptyString('status_in');

        $validator
            ->scalar('is_from')
            ->maxLength('is_from', 50)
            ->allowEmptyString('is_from');

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
            ->integer('is_create')
            ->notEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->notEmptyString('is_update');

        $validator
            ->integer('is_delete')
            ->notEmptyString('is_delete');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        $validator
            ->scalar('is_active')
            ->allowEmptyString('is_active');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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
        // $rules->add($rules->existsIn(['store_id'], 'Stores'), ['errorField' => 'store_id']);
        $rules->add($rules->existsIn(['goods_out_warehouse_id'], 'GoodsOutWarehouses'), ['errorField' => 'goods_out_warehouse_id']);
        // $rules->add($rules->existsIn(['goods_out_store_id'], 'GoodsOutStores'), ['errorField' => 'goods_out_store_id']);

        return $rules;
    }
}
