<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator; 

/**
 * Warehouses Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\GoodsInWarehousesTable&\Cake\ORM\Association\HasMany $GoodsInWarehouses
 * @property \App\Model\Table\GoodsOutWarehousesTable&\Cake\ORM\Association\HasMany $GoodsOutWarehouses
 * @property \App\Model\Table\WarehouseStocksTable&\Cake\ORM\Association\HasMany $WarehouseStocks
 *
 * @method \App\Model\Entity\Warehouse newEmptyEntity()
 * @method \App\Model\Entity\Warehouse newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Warehouse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Warehouse get($primaryKey, $options = [])
 * @method \App\Model\Entity\Warehouse findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Warehouse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Warehouse[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Warehouse|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Warehouse saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Warehouse[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Warehouse[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Warehouse[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Warehouse[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WarehousesTable extends Table
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

        $this->setTable('warehouses');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('WarehouseStocks', [
            'foreignKey' => 'warehouse_stock_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('GoodsInWarehouses', [
            'foreignKey' => 'warehouse_id',
        ]);
        $this->hasMany('GoodsOutWarehouses', [
            'foreignKey' => 'warehouse_id',
        ]);
        // $this->hasMany('WarehouseStocks', [
        //     'foreignKey' => 'warehouse_id',
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
            ->scalar('code')
            ->maxLength('code', 255)
            ->notEmptyString('code');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('address')
            ->allowEmptyString('address');

        $validator
            ->scalar('pic')
            ->maxLength('pic', 255)
            ->allowEmptyString('pic');

        $validator
            ->scalar('telp')
            ->maxLength('telp', 255)
            ->allowEmptyString('telp');

        $validator
            ->decimal('stock')
            ->notEmptyString('stock');

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
            ->scalar('is_view')
            ->notEmptyString('is_view');

        $validator
            ->scalar('is_active')
            ->notEmptyString('is_active');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

        $validator
            ->scalar('status')
            ->maxLength('status', 5)
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
        $rules->add($rules->existsIn(['warehouse_stock_id'], 'WarehouseStocks'), ['errorField' => 'warehouse_stock_id']);

        return $rules;
    }
}
