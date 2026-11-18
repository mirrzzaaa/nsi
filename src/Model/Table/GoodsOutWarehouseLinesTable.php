<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GoodsOutWarehouseLines Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\GoodsOutWarehousesTable&\Cake\ORM\Association\BelongsTo $GoodsOutWarehouses
 * @property \App\Model\Table\GoodsInWarehousesTable&\Cake\ORM\Association\BelongsTo $GoodsInWarehouses
 * @property \App\Model\Table\GoodsInWarehouseLinesTable&\Cake\ORM\Association\BelongsTo $GoodsInWarehouseLines
 * @property \App\Model\Table\WarehouseStocksTable&\Cake\ORM\Association\BelongsTo $WarehouseStocks
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\GoodsInStoreLinesTable&\Cake\ORM\Association\HasMany $GoodsInStoreLines
 * @property \App\Model\Table\GoodsInWarehouseLinesTable&\Cake\ORM\Association\HasMany $GoodsInWarehouseLines
 *
 * @method \App\Model\Entity\GoodsOutWarehouseLine newEmptyEntity()
 * @method \App\Model\Entity\GoodsOutWarehouseLine newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouseLine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouseLine get($primaryKey, $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouseLine findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouseLine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouseLine[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouseLine|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouseLine saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouseLine[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouseLine[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouseLine[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsOutWarehouseLine[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GoodsOutWarehouseLinesTable extends Table
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

        $this->setTable('goods_out_warehouse_lines');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('GoodsOutWarehouses', [
            'foreignKey' => 'goods_out_warehouse_id',
        ]);
        $this->belongsTo('GoodsInWarehouses', [
            'foreignKey' => 'goods_in_warehouse_id',
        ]);
        $this->belongsTo('GoodsInWarehouseLines', [
            'foreignKey' => 'goods_in_warehouse_line_id',
        ]);
        $this->belongsTo('WarehouseStocks', [
            'foreignKey' => 'warehouse_stock_id',
        ]);
        $this->belongsTo('ItemLines', [
            'foreignKey' => 'item_lines_id',
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
        ]);
        $this->hasMany('GoodsInStoreLines', [
            'foreignKey' => 'goods_out_warehouse_line_id',
        ]);
        $this->hasMany('GoodsInWarehouseLines', [
            'foreignKey' => 'goods_out_warehouse_line_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 255)
            ->allowEmptyString('unit');

        $validator
            ->decimal('qty')
            ->allowEmptyString('qty');

        $validator
            ->decimal('qty_out')
            ->allowEmptyString('qty_out');

        $validator
            ->scalar('packing')
            ->maxLength('packing', 255)
            ->allowEmptyString('packing');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
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
        $rules->add($rules->existsIn(['goods_out_warehouse_id'], 'GoodsOutWarehouses'), ['errorField' => 'goods_out_warehouse_id']);
        $rules->add($rules->existsIn(['goods_in_warehouse_id'], 'GoodsInWarehouses'), ['errorField' => 'goods_in_warehouse_id']);
        $rules->add($rules->existsIn(['goods_in_warehouse_line_id'], 'GoodsInWarehouseLines'), ['errorField' => 'goods_in_warehouse_line_id']);
        $rules->add($rules->existsIn(['warehouse_stock_id'], 'WarehouseStocks'), ['errorField' => 'warehouse_stock_id']);
        $rules->add($rules->existsIn(['item_lines_id'], 'ItemLines'), ['errorField' => 'item_lines_id']);
        $rules->add($rules->existsIn(['item_id'], 'Items'), ['errorField' => 'item_id']);

        return $rules;
    }
}
