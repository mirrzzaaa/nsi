<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GoodsInWarehouseLines Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\GoodsInWarehousesTable&\Cake\ORM\Association\BelongsTo $GoodsInWarehouses
 * @property \App\Model\Table\GoodsOutWarehousesTable&\Cake\ORM\Association\BelongsTo $GoodsOutWarehouses
 * @property \App\Model\Table\GoodsOutWarehouseLinesTable&\Cake\ORM\Association\BelongsTo $GoodsOutWarehouseLines
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\GoodsOutWarehouseLinesTable&\Cake\ORM\Association\HasMany $GoodsOutWarehouseLines
 *
 * @method \App\Model\Entity\GoodsInWarehouseLine newEmptyEntity()
 * @method \App\Model\Entity\GoodsInWarehouseLine newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\GoodsInWarehouseLine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GoodsInWarehouseLine get($primaryKey, $options = [])
 * @method \App\Model\Entity\GoodsInWarehouseLine findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\GoodsInWarehouseLine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GoodsInWarehouseLine[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GoodsInWarehouseLine|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GoodsInWarehouseLine saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GoodsInWarehouseLine[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsInWarehouseLine[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsInWarehouseLine[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsInWarehouseLine[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GoodsInWarehouseLinesTable extends Table
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

        $this->setTable('goods_in_warehouse_lines');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('GoodsInWarehouses', [ 
            'foreignKey' => 'goods_in_warehouse_id',
        ]);
        // $this->belongsTo('GoodsOutWarehouses', [
        //     'foreignKey' => 'goods_out_warehouse_id',
        // ]);
        // $this->belongsTo('GoodsOutWarehouseLines', [
        //     'foreignKey' => 'goods_out_warehouse_line_id',
        // ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('PurchasingLines', [
            'foreignKey' => 'purchasing_line_id',
            'joinType' => 'LEFT',
        ]);
        // $this->belongsTo('ItemLines', [
        //     'foreignKey' => 'item_lines_id',
        // ]);
        // $this->hasMany('GoodsOutWarehouseLines', [
        //     'foreignKey' => 'goods_in_warehouse_line_id',
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
            ->allowEmptyString('code');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 255)
            ->allowEmptyString('unit');

        $validator
            ->integer('qty')
            ->allowEmptyString('qty');

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
        $rules->add($rules->existsIn(['goods_in_warehouse_id'], 'GoodsInWarehouses'), ['errorField' => 'goods_in_warehouse_id']);
        // $rules->add($rules->existsIn(['goods_out_warehouse_id'], 'GoodsOutWarehouses'), ['errorField' => 'goods_out_warehouse_id']);
        // $rules->add($rules->existsIn(['goods_out_warehouse_line_id'], 'GoodsOutWarehouseLines'), ['errorField' => 'goods_out_warehouse_line_id']);
        $rules->add($rules->existsIn(['item_id'], 'Items'), ['errorField' => 'item_id']);
        $rules->add($rules->existsIn(['purchasing_line_id'], 'PurchasingLines'), ['errorField' => 'purchasing_line_id']);
        // $rules->add($rules->existsIn(['item_lines_id'], 'ItemLines'), ['errorField' => 'item_lines_id']);

        return $rules;
    }
}
