<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Items Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\ItemLinesTable&\Cake\ORM\Association\HasMany $ItemLines
 *
 * @method \App\Model\Entity\Item newEmptyEntity()
 * @method \App\Model\Entity\Item newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Item[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item get($primaryKey, $options = [])
 * @method \App\Model\Entity\Item findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Item[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ItemsTable extends Table
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

        $this->setTable('items');
        $this->setDisplayField('name');
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

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'customer_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Mouses', [
            'foreignKey' => 'mouse_id',
            'joinType' => 'LEFT',
        ]);
        // $this->belongsTo('RawMaterials', [
        //     'foreignKey' => 'raw_materials_id',
        // ]);
        // $this->hasMany('GoodsInStoreLines', [
        //     'foreignKey' => 'item_id',
        // ]);
        // $this->hasMany('GoodsInWarehouseLines', [
        //     'foreignKey' => 'item_id',
        // ]);
        // $this->hasMany('GoodsOutStoreLines', [
        //     'foreignKey' => 'item_id',
        // ]);
        // $this->hasMany('GoodsOutWarehouseLines', [
        //     'foreignKey' => 'item_id',
        // ]);
        $this->hasMany('ItemLines', [
            'foreignKey' => 'item_id',
        ]);
        // $this->hasMany('OrderLines', [
        //     'foreignKey' => 'item_id', 
        // ]);
        // $this->hasMany('PurchasingLines', [
        //     'foreignKey' => 'item_id',
        // ]);
        // $this->hasMany('WarehouseStocks', [
        //     'foreignKey' => 'item_id',
        // ]);
        $this->getSchema()->setColumnType('supplier_id', 'string');
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
            ->scalar('sku')
            ->maxLength('sku', 255)
            ->allowEmptyString('sku');

        $validator
            ->scalar('barcode')
            ->maxLength('barcode', 255)
            ->allowEmptyString('barcode');

        $validator
            ->scalar('code_internal')
            ->maxLength('code_internal', 255)
            ->allowEmptyString('code_internal');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->allowEmptyString('type');

        $validator
            ->decimal('weight')
            ->allowEmptyString('weight');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 255)
            ->allowEmptyString('unit');

        $validator
            ->decimal('stock')
            ->notEmptyString('stock');

        $validator
            ->decimal('last_stock')
            ->allowEmptyString('last_stock');

        $validator
            ->decimal('min_stock')
            ->allowEmptyString('min_stock');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->date('expired_date')
            ->allowEmptyDate('expired_date');

        $validator
            ->scalar('image')
            ->maxLength('image', 255)
            ->allowEmptyFile('image');

        $validator
            ->decimal('selling_price')
            ->allowEmptyString('selling_price');

        $validator
            ->decimal('buying_price')
            ->allowEmptyString('buying_price');

        $validator
            ->decimal('cost_price')
            ->allowEmptyString('cost_price');

        $validator
            ->decimal('rent_cost')
            ->allowEmptyString('rent_cost');

        $validator
            ->scalar('phone1')
            ->maxLength('phone1', 30)
            ->allowEmptyString('phone1');

        $validator
            ->scalar('phone2')
            ->maxLength('phone2', 30)
            ->allowEmptyString('phone2');

        $validator
            ->scalar('phone3')
            ->maxLength('phone3', 30)
            ->allowEmptyString('phone3');

        $validator
            ->scalar('group')
            ->allowEmptyString('group');

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
        $rules->add($rules->existsIn(['warehouse_id'], 'Warehouses'), ['errorField' => 'warehouse_id']);
        $rules->add($rules->existsIn(['category_id'], 'Categories'), ['errorField' => 'category_id']);
        // $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);
        $rules->add($rules->existsIn(['mouse_id'], 'Mouses'), ['errorField' => 'mouse_id']);

        return $rules;
    }
}
