<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table; 
use Cake\Validation\Validator;

/**
 * Orders Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\MembersTable&\Cake\ORM\Association\BelongsTo $Members
 * @property \App\Model\Table\TablesTable&\Cake\ORM\Association\BelongsTo $Tables
 * @property \App\Model\Table\WastesTable&\Cake\ORM\Association\BelongsTo $Wastes
 * @property \App\Model\Table\WasteTypesTable&\Cake\ORM\Association\BelongsTo $WasteTypes
 * @property \App\Model\Table\ProcessorsTable&\Cake\ORM\Association\BelongsTo $Processors
 * @property \App\Model\Table\CashiersTable&\Cake\ORM\Association\BelongsTo $Cashiers
 * @property \App\Model\Table\ManifestsTable&\Cake\ORM\Association\BelongsTo $Manifests
 * @property \App\Model\Table\PermitsTable&\Cake\ORM\Association\BelongsTo $Permits
 * @property \App\Model\Table\SjpsTable&\Cake\ORM\Association\BelongsTo $Sjps
 * @property \App\Model\Table\TruckSchedulesTable&\Cake\ORM\Association\BelongsTo $TruckSchedules
 * @property \App\Model\Table\GoodsOutStoresTable&\Cake\ORM\Association\HasMany $GoodsOutStores
 * @property \App\Model\Table\OrderLinesTable&\Cake\ORM\Association\HasMany $OrderLines
 *
 * @method \App\Model\Entity\Order newEmptyEntity()
 * @method \App\Model\Entity\Order newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Order get($primaryKey, $options = [])
 * @method \App\Model\Entity\Order findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Order[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Order|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersTable extends Table
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

        $this->setTable('orders');
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

        $this->belongsTo('Customers', [
            'propertyName' => 'pelanggan',
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'is_create',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Members', [
            'foreignKey' => 'member_id',
        ]);

        $this->belongsTo('Invoices', [
            'foreignKey' => 'invoice_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Returs', [
            'foreignKey' => 'retur_id',
            'joinType' => 'LEFT',
        ]);

        // $this->hasMany('GoodsOutStores', [
        //     'foreignKey' => 'order_id',
        // ]);
        $this->hasMany('OrderLines', [
            'foreignKey' => 'order_id',
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
            ->scalar('customer')
            ->maxLength('customer', 50)
            ->allowEmptyString('customer');

        $validator
            ->scalar('code')
            ->maxLength('code', 50)
            ->allowEmptyString('code');

        $validator
            ->scalar('number')
            ->maxLength('number', 100)
            ->allowEmptyString('number');

        $validator
            ->scalar('po_number')
            ->maxLength('po_number', 255)
            ->allowEmptyString('po_number');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->decimal('subtotal')
            ->allowEmptyString('subtotal');

        $validator
            ->decimal('addon')
            ->allowEmptyString('addon');

        $validator
            ->decimal('tax')
            ->allowEmptyString('tax');

        $validator
            ->scalar('with_price')
            ->allowEmptyString('with_price');

        $validator
            ->decimal('ppn')
            ->allowEmptyString('ppn');

        $validator
            ->decimal('deliver_pays')
            ->allowEmptyString('deliver_pays');

        $validator
            ->decimal('grandtotal')
            ->allowEmptyString('grandtotal');

        $validator
            ->decimal('pay')
            ->allowEmptyString('pay');

        $validator
            ->decimal('diff')
            ->allowEmptyString('diff');

        $validator
            ->decimal('discount')
            ->allowEmptyString('discount');

        $validator
            ->scalar('keterangan')
            ->maxLength('keterangan', 255)
            ->allowEmptyString('keterangan');

        $validator
            ->decimal('deliver_pay')
            ->allowEmptyString('deliver_pay');

        $validator
            ->scalar('payment_method')
            ->maxLength('payment_method', 100)
            ->allowEmptyString('payment_method');

        $validator
            ->scalar('debit_card')
            ->maxLength('debit_card', 255)
            ->allowEmptyString('debit_card');

        $validator
            ->scalar('credit_card')
            ->maxLength('credit_card', 255)
            ->allowEmptyString('credit_card');

        $validator
            ->scalar('note')
            ->maxLength('note', 255)
            ->allowEmptyString('note');

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
            ->integer('order')
            ->allowEmptyString('order');

        $validator
            ->dateTime('date_order')
            ->allowEmptyDateTime('date_order');

        $validator
            ->dateTime('date_manifest')
            ->allowEmptyDateTime('date_manifest');

        $validator
            ->date('date_estimate_schedule')
            ->allowEmptyDate('date_estimate_schedule');

        $validator
            ->dateTime('date_permit')
            ->allowEmptyDateTime('date_permit');

        $validator
            ->dateTime('date_sjp')
            ->allowEmptyDateTime('date_sjp');

        $validator
            ->dateTime('truck_schedule_date')
            ->allowEmptyDateTime('truck_schedule_date');

        $validator
            ->integer('who_create')
            ->allowEmptyString('who_create');

        $validator
            ->integer('who_update')
            ->allowEmptyString('who_update');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['item_id'], 'Items'), ['errorField' => 'item_id']);
        $rules->add($rules->existsIn(['invoice_id'], 'Invoices'), ['errorField' => 'invoice_id']);
        $rules->add($rules->existsIn(['member_id'], 'Members'), ['errorField' => 'member_id']);
        $rules->add($rules->existsIn(['is_create'], 'Users'), ['errorField' => 'is_create']);
        $rules->add($rules->existsIn(['retur_id'], 'Returs'), ['errorField' => 'retur_id']);

        return $rules;
    }
}
