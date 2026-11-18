<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GoodsOutWarehouses Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\GoodsInWarehousesTable&\Cake\ORM\Association\BelongsTo $GoodsInWarehouses
 * @property \App\Model\Table\WarehousesTable&\Cake\ORM\Association\BelongsTo $Warehouses
 * @property \App\Model\Table\StoresTable&\Cake\ORM\Association\BelongsTo $Stores
 * @property \App\Model\Table\GoodsInStoresTable&\Cake\ORM\Association\BelongsTo $GoodsInStores
 * @property \App\Model\Table\GoodsInStoreLinesTable&\Cake\ORM\Association\HasMany $GoodsInStoreLines
 * @property \App\Model\Table\GoodsInStoresTable&\Cake\ORM\Association\HasMany $GoodsInStores
 * @property \App\Model\Table\GoodsInWarehouseLinesTable&\Cake\ORM\Association\HasMany $GoodsInWarehouseLines
 * @property \App\Model\Table\GoodsOutWarehouseLinesTable&\Cake\ORM\Association\HasMany $GoodsOutWarehouseLines
 *
 * @method \App\Model\Entity\GoodsOutWarehouse newEmptyEntity()
 * @method \App\Model\Entity\GoodsOutWarehouse newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouse get($primaryKey, $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouse findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouse[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouse|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouse saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouse[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouse[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouse[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouse[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GoodsOutWarehousesTable extends Table
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

        $this->setTable('goods_out_warehouses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Permits', [
            'foreignKey' => 'permit_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('GoodsInWarehouses', [
            'foreignKey' => 'goods_in_warehouse_id',
        ]);
        $this->belongsTo('Warehouses', [
            'foreignKey' => 'warehouse_id',
        ]);
        // $this->belongsTo('Stores', [
        //     'foreignKey' => 'store_id',
        // ]);
        // $this->belongsTo('GoodsInStores', [
        //     'foreignKey' => 'goods_in_store_id',
        // ]);
        // $this->hasMany('GoodsInStoreLines', [
        //     'foreignKey' => 'goods_out_warehouse_id',
        // ]);
        // $this->hasMany('GoodsInStores', [
        //     'foreignKey' => 'goods_out_warehouse_id',
        // ]);
        $this->hasMany('GoodsInWarehouseLines', [
            'foreignKey' => 'goods_out_warehouse_id',
        ]);
        $this->hasMany('GoodsOutWarehouseLines', [
            'foreignKey' => 'goods_out_warehouse_id',
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
            ->scalar('description')
            ->allowEmptyString('description');

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
            ->scalar('is_to')
            ->allowEmptyString('is_to');

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
        $rules->add($rules->existsIn(['goods_in_warehouse_id'], 'GoodsInWarehouses'), ['errorField' => 'goods_in_warehouse_id']);
        $rules->add($rules->existsIn(['warehouse_id'], 'Warehouses'), ['errorField' => 'warehouse_id']);
        $rules->add($rules->existsIn(['permit_id'], 'Permits'), ['errorField' => 'permit_id']);
        // $rules->add($rules->existsIn(['store_id'], 'Stores'), ['errorField' => 'store_id']);
        // $rules->add($rules->existsIn(['goods_in_store_id'], 'GoodsInStores'), ['errorField' => 'goods_in_store_id']);

        return $rules;
    }
}
