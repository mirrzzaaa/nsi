<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Mouses Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\ProcessorsTable&\Cake\ORM\Association\BelongsTo $Processors
 *
 * @method \App\Model\Entity\Mouse newEmptyEntity()
 * @method \App\Model\Entity\Mouse newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Mouse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Mouse get($primaryKey, $options = [])
 * @method \App\Model\Entity\Mouse findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Mouse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Mouse[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Mouse|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mouse saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mouse[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Mouse[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Mouse[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Mouse[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MousesTable extends Table
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

        $this->setTable('mouses');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'LEFT',
        ]);

        $this->hasMany('MouseItems', [
            'foreignKey' => 'mouse_id',
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
            ->scalar('customer_no')
            ->maxLength('customer_no', 100)
            ->allowEmptyString('customer_no');

        $validator
            ->integer('transporter_id_1')
            ->allowEmptyString('transporter_id_1');

        $validator
            ->scalar('transporter_no_1')
            ->maxLength('transporter_no_1', 100)
            ->allowEmptyString('transporter_no_1');

        $validator
            ->integer('transporter_id_2')
            ->allowEmptyString('transporter_id_2');

        $validator
            ->scalar('transporter_no_2')
            ->maxLength('transporter_no_2', 100)
            ->allowEmptyString('transporter_no_2');

        $validator
            ->integer('transporter_id_3')
            ->allowEmptyString('transporter_id_3');

        $validator
            ->scalar('transporter_no_3')
            ->maxLength('transporter_no_3', 100)
            ->allowEmptyString('transporter_no_3');

        $validator
            ->integer('transporter_id_4')
            ->allowEmptyString('transporter_id_4');

        $validator
            ->scalar('transporter_no_4')
            ->maxLength('transporter_no_4', 100)
            ->allowEmptyString('transporter_no_4');

        $validator
            ->integer('transporter_id_5')
            ->allowEmptyString('transporter_id_5');

        $validator
            ->scalar('transporter_no_5')
            ->maxLength('transporter_no_5', 100)
            ->allowEmptyString('transporter_no_5');

        $validator
            ->scalar('processor_no')
            ->maxLength('processor_no', 100)
            ->allowEmptyString('processor_no');

        $validator
            ->scalar('klasifikasi')
            ->maxLength('klasifikasi', 50)
            ->allowEmptyString('klasifikasi');

        $validator
            ->date('date_contract')
            ->allowEmptyDate('date_contract');

        $validator
            ->date('date_expired')
            ->allowEmptyDate('date_expired');

        $validator
            ->scalar('invoice_name')
            ->maxLength('invoice_name', 255)
            ->allowEmptyString('invoice_name');

        $validator
            ->scalar('code')
            ->maxLength('code', 50)
            ->allowEmptyString('code');

        $validator
            ->scalar('code_name')
            ->maxLength('code_name', 50)
            ->allowEmptyString('code_name');

        $validator
            ->scalar('pihak')
            ->maxLength('pihak', 50)
            ->allowEmptyString('pihak');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->decimal('deposit')
            ->allowEmptyString('deposit');

        $validator
            ->date('date_deposit')
            ->allowEmptyDate('date_deposit');

        $validator
            ->decimal('saldo')
            ->allowEmptyString('saldo');

        $validator
            ->integer('is_approve')
            ->allowEmptyString('is_approve');

        $validator
            ->dateTime('date_approve')
            ->allowEmptyDateTime('date_approve');

        $validator
            ->scalar('type')
            ->maxLength('type', 50)
            ->allowEmptyString('type');

        $validator
            ->scalar('class')
            ->maxLength('class', 50)
            ->allowEmptyString('class');

        $validator
            ->decimal('price')
            ->allowEmptyString('price');

        $validator
            ->decimal('price_netto')
            ->allowEmptyString('price_netto');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 100)
            ->allowEmptyString('unit');

        $validator
            ->scalar('paket_desc')
            ->allowEmptyString('paket_desc');

        $validator
            ->scalar('pic_name')
            ->maxLength('pic_name', 255)
            ->allowEmptyString('pic_name');

        $validator
            ->scalar('pic_telp')
            ->maxLength('pic_telp', 255)
            ->allowEmptyString('pic_telp');

        $validator
            ->scalar('pic_hp')
            ->maxLength('pic_hp', 255)
            ->allowEmptyString('pic_hp');

        $validator
            ->scalar('pic_email')
            ->maxLength('pic_email', 255)
            ->allowEmptyString('pic_email');

        $validator
            ->scalar('pic_title')
            ->maxLength('pic_title', 255)
            ->allowEmptyString('pic_title');

        $validator
            ->scalar('is_active')
            ->allowEmptyString('is_active');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

        $validator
            ->scalar('is_create')
            ->maxLength('is_create', 15)
            ->allowEmptyString('is_create');

        $validator
            ->scalar('is_update')
            ->maxLength('is_update', 15)
            ->allowEmptyString('is_update');

        $validator
            ->scalar('who_create')
            ->maxLength('who_create', 50)
            ->allowEmptyString('who_create');

        $validator
            ->scalar('who_update')
            ->maxLength('who_update', 50)
            ->allowEmptyString('who_update');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn(['item_id'], 'Items'), ['errorField' => 'item_id']);

        return $rules;
    }
}
