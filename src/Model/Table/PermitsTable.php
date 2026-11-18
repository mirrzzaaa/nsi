<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Permits Model
 *
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\InvoicesTable&\Cake\ORM\Association\BelongsTo $Invoices
 * @property \App\Model\Table\TrucksTable&\Cake\ORM\Association\BelongsTo $Trucks
 * @property \App\Model\Table\OrderLinesTable&\Cake\ORM\Association\HasMany $OrderLines
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 *
 * @method \App\Model\Entity\Permit newEmptyEntity()
 * @method \App\Model\Entity\Permit newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Permit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Permit get($primaryKey, $options = [])
 * @method \App\Model\Entity\Permit findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Permit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Permit[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Permit|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Permit saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Permit[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Permit[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Permit[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Permit[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PermitsTable extends Table
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

        $this->setTable('permits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id', 
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('OrderLines', [
            'foreignKey' => 'order_line_id', 
        ]);

        $this->belongsTo('Trucks', [
            'foreignKey' => 'truck_id',
        ]);

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
        ]);

        $this->belongsTo('TandaTerima', [
            'foreignKey' => 'tanda_terima_id',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'is_create',
            'joinType' => 'LEFT',
        ]);

        $this->hasMany('PermitOrderLines', [
            'foreignKey' => 'permit_id',
            'joinType' => 'LEFT', // Jika data bisa kosong
        ]);

        // $this->hasMany('OrderLines', [
        //     'foreignKey' => 'permit_id',
        // ]);
        // $this->hasMany('Orders', [
        //     'foreignKey' => 'permit_id',
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
            ->scalar('delivered')
            ->maxLength('delivered', 255)
            ->allowEmptyString('delivered');

        $validator
            ->scalar('code')
            ->maxLength('code', 255)
            ->allowEmptyString('code'); 

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->integer('is_create')
            ->allowEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->allowEmptyString('is_update');

        $validator
            ->integer('is_print')
            ->allowEmptyString('is_print');

        $validator
            ->integer('is_active')
            ->allowEmptyString('is_active');

        $validator
            ->dateTime('date_print')
            ->allowEmptyDateTime('date_print');

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'), ['errorField' => 'order_id']);
        $rules->add($rules->existsIn(['order_line_id'], 'OrderLines'), ['errorField' => 'order_line_id']);
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn(['truck_id'], 'Trucks'), ['errorField' => 'truck_id']);
        $rules->add($rules->existsIn(['tanda_terima_id'], 'TandaTerima'), ['errorField' => 'tanda_terima_id']);
        $rules->add($rules->existsIn(['is_create'], 'Users'), ['errorField' => 'is_create']);

        return $rules;
    }
}
