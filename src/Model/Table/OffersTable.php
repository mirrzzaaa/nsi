<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Offers Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\KabupatensTable&\Cake\ORM\Association\BelongsTo $Kabupatens
 *
 * @method \App\Model\Entity\Offer newEmptyEntity()
 * @method \App\Model\Entity\Offer newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Offer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Offer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Offer findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Offer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Offer[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Offer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Offer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Offer[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Offer[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Offer[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Offer[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OffersTable extends Table
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

        $this->setTable('offers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Marketing', [
            'className' => 'Users',
            'foreignKey' => 'is_marketing',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'is_marketing',
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
            ->maxLength('number', 255)
            ->allowEmptyString('number');

        $validator
            ->scalar('code')
            ->maxLength('code', 255)
            ->allowEmptyString('code');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('customer_name')
            ->maxLength('customer_name', 255)
            ->allowEmptyString('customer_name');

        $validator
            ->scalar('customer_address')
            ->maxLength('customer_address', 255)
            ->allowEmptyString('customer_address');

        $validator
            ->scalar('attn_1')
            ->maxLength('attn_1', 255)
            ->allowEmptyString('attn_1');

        $validator
            ->scalar('attn_2')
            ->maxLength('attn_2', 255)
            ->allowEmptyString('attn_2');

        $validator
            ->scalar('perihal')
            ->maxLength('perihal', 255)
            ->allowEmptyString('perihal');

        $validator
            ->scalar('waste_type')
            ->maxLength('waste_type', 255)
            ->allowEmptyString('waste_type');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('info')
            ->maxLength('info', 255)
            ->allowEmptyString('info');

        $validator
            ->scalar('klasifikasi')
            ->maxLength('klasifikasi', 255)
            ->allowEmptyString('klasifikasi');

        $validator
            ->decimal('kabupaten_price_trip')
            ->allowEmptyString('kabupaten_price_trip');

        $validator
            ->integer('print')
            ->allowEmptyString('print');

        $validator
            ->integer('is_marketing')
            ->allowEmptyString('is_marketing');

        $validator
            ->integer('is_approve')
            ->allowEmptyString('is_approve');

        $validator
            ->dateTime('approve_date')
            ->allowEmptyDateTime('approve_date');

        $validator
            ->integer('is_print')
            ->allowEmptyString('is_print');

        $validator
            ->dateTime('print_date')
            ->allowEmptyDateTime('print_date');

        $validator
            ->scalar('is_create')
            ->maxLength('is_create', 50)
            ->allowEmptyString('is_create');

        $validator
            ->scalar('is_update')
            ->maxLength('is_update', 50)
            ->allowEmptyString('is_update');

        $validator
            ->integer('is_delete')
            ->allowEmptyString('is_delete');

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
            ->scalar('active')
            ->allowEmptyString('active');

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn(['is_marketing'], 'Users'), ['errorField' => 'is_marketing']);

        return $rules;
    }
}
