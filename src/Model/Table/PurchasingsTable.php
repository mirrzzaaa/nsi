<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Purchasings Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\GoodsInWarehousesTable&\Cake\ORM\Association\HasMany $GoodsInWarehouses
 * @property \App\Model\Table\PurchasingLinesTable&\Cake\ORM\Association\HasMany $PurchasingLines
 *
 * @method \App\Model\Entity\Purchasing newEmptyEntity()
 * @method \App\Model\Entity\Purchasing newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Purchasing[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Purchasing get($primaryKey, $options = [])
 * @method \App\Model\Entity\Purchasing findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Purchasing patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Purchasing[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Purchasing|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Purchasing saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Purchasing[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Purchasing[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Purchasing[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Purchasing[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PurchasingsTable extends Table
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

        $this->setTable('purchasings');
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
        // $this->belongsTo('Customers', [
        //     'foreignKey' => 'customer_id',
        // ]);
        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('GoodsInWarehouses', [
            'foreignKey' => 'goods_in_warehouse_id',
        ]);
        $this->hasMany('PurchasingLines', [
            'foreignKey' => 'purchasing_id',
        ]);
        $this->belongsTo('InvoiceEntries', [
            'foreignKey' => 'invoice_entry_id',
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
            ->scalar('number')
            ->maxLength('number', 100)
            ->allowEmptyString('number');

        $validator
            ->scalar('code')
            ->maxLength('code', 100)
            ->allowEmptyString('code');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('person_shop')
            ->maxLength('person_shop', 100)
            ->allowEmptyString('person_shop');

        $validator
            ->scalar('shop_name')
            ->maxLength('shop_name', 255)
            ->allowEmptyString('shop_name');

        $validator
            ->scalar('status_wait')
            ->notEmptyString('status_wait');

        $validator
            ->scalar('status_approve')
            ->maxLength('status_approve', 50)
            ->allowEmptyString('status_approve');

        $validator
            ->date('status_date')
            ->allowEmptyDate('status_date');

        $validator
            ->scalar('status_desc')
            ->maxLength('status_desc', 255)
            ->allowEmptyString('status_desc');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 50)
            ->allowEmptyString('unit');

        $validator
            ->scalar('quantity')
            ->maxLength('quantity', 50)
            ->allowEmptyString('quantity');

        $validator
            ->decimal('grandtotal')
            ->notEmptyString('grandtotal');

        $validator
            ->decimal('discount')
            ->allowEmptyString('discount');

        $validator
            ->decimal('ship_payment')
            ->allowEmptyString('ship_payment');

        $validator
            ->decimal('ppn')
            ->allowEmptyString('ppn');

        $validator
            ->integer('purchasing')
            ->allowEmptyString('purchasing');

        $validator
            ->dateTime('date_purchasing')
            ->allowEmptyDateTime('date_purchasing');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

        $validator
            ->scalar('with_price')
            ->allowEmptyString('with_price');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->integer('is_create')
            ->notEmptyString('is_create');

        $validator
            ->integer('is_approve')
            ->notEmptyString('is_approve');

        $validator
            ->integer('is_cancel')
            ->notEmptyString('is_cancel');

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
        // $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);
        $rules->add($rules->existsIn(['invoice_entry_id'], 'InvoiceEntries'), ['errorField' => 'invoice_entry_id']);
        $rules->add($rules->existsIn(['goods_in_warehouse_id'], 'GoodsInWarehouses'), ['errorField' => 'goods_in_warehouse_id']);

        return $rules;
    }
}
