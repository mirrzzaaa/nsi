<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator; 

/**
 * WarehouseStocks Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\ItemLinesTable&\Cake\ORM\Association\BelongsTo $ItemLines
 * @property \App\Model\Table\WarehousesTable&\Cake\ORM\Association\BelongsTo $Warehouses
 * @property \App\Model\Table\GoodsOutWarehouseLinesTable&\Cake\ORM\Association\HasMany $GoodsOutWarehouseLines
 *
 * @method \App\Model\Entity\WarehouseStock newEmptyEntity()
 * @method \App\Model\Entity\WarehouseStock newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\WarehouseStock[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WarehouseStock get($primaryKey, $options = [])
 * @method \App\Model\Entity\WarehouseStock findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\WarehouseStock patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WarehouseStock[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\WarehouseStock|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WarehouseStock saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WarehouseStock[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\WarehouseStock[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\WarehouseStock[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\WarehouseStock[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WarehouseStocksTable extends Table
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

        $this->setTable('warehouse_stocks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
        ]);
        $this->belongsTo('Warehouses', [
            'foreignKey' => 'warehouse_id',
        ]);
        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'is_create',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('GoodsOutWarehouseLines', [
            'foreignKey' => 'warehouse_stock_id',
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
            ->scalar('unit')
            ->maxLength('unit', 255)
            ->allowEmptyString('unit');

        $validator
            ->decimal('stock')
            ->allowEmptyString('stock');

        $validator
            ->decimal('buy')
            ->allowEmptyString('buy');

        $validator
            ->decimal('sell')
            ->allowEmptyString('sell');

        $validator
            ->scalar('packing')
            ->maxLength('packing', 255)
            ->allowEmptyString('packing');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->date('expired_date')
            ->allowEmptyDate('expired_date');

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
        $rules->add($rules->existsIn(['item_id'], 'Items'), ['errorField' => 'item_id']);
        $rules->add($rules->existsIn(['warehouse_id'], 'Warehouses'), ['errorField' => 'warehouse_id']);
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);
        $rules->add($rules->existsIn(['is_create'], 'Users'), ['errorField' => 'is_create']);

        return $rules;
    }
}
