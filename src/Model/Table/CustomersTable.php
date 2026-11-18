<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Customers Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 *
 * @method \App\Model\Entity\Customer newEmptyEntity()
 * @method \App\Model\Entity\Customer newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Customer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Customer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Customer findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Customer[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Customer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Customer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CustomersTable extends Table
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
        $this->belongsTo('Users');
        $this->setTable('customers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        
        $this->belongsTo('Users', [
            'foreignKey' => 'marketing_id',
        ]);
        $this->hasMany('MouseItems', [
            'foreignKey' => 'customer_id',
        ]);
        $this->hasMany('Mouses', [
            'foreignKey' => 'customer_id',
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'customer_id',
        ]);
        $this->hasMany('OrderLines', [
            'foreignKey' => 'customer_id',
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'customer_id',
        ]);
        $this->hasMany('PurchasingLines', [
            'foreignKey' => 'customer_id',
        ]);
        $this->hasMany('Purchasings', [
            'foreignKey' => 'customer_id',
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
            ->maxLength('code', 20)
            ->allowEmptyString('code');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('title')
            ->maxLength('title', 50)
            ->allowEmptyString('title');

        $validator
            ->scalar('nickname')
            ->maxLength('nickname', 255)
            ->allowEmptyString('nickname');

        $validator
            ->scalar('contact_person')
            ->maxLength('contact_person', 255)
            ->allowEmptyString('contact_person');

        $validator
            ->scalar('dept_person')
            ->maxLength('dept_person', 255)
            ->allowEmptyString('dept_person');

        $validator
            ->scalar('telp_person')
            ->maxLength('telp_person', 255)
            ->allowEmptyString('telp_person');

        $validator
            ->scalar('address_penghasil')
            ->allowEmptyString('address_penghasil');

        $validator
            ->scalar('area')
            ->maxLength('area', 255)
            ->allowEmptyString('area');

        $validator
            ->scalar('province')
            ->maxLength('province', 100)
            ->allowEmptyString('province');

        $validator
            ->integer('postal')
            ->allowEmptyString('postal');

        $validator
            ->scalar('website')
            ->maxLength('website', 50)
            ->allowEmptyString('website');

        $validator
            ->scalar('email1')
            ->maxLength('email1', 255)
            ->allowEmptyString('email1');

        $validator
            ->scalar('email2')
            ->maxLength('email2', 255)
            ->allowEmptyString('email2');

        $validator
            ->scalar('name_invoice')
            ->maxLength('name_invoice', 100)
            ->allowEmptyString('name_invoice');

        $validator
            ->scalar('phone_invoice')
            ->maxLength('phone_invoice', 30)
            ->allowEmptyString('phone_invoice');

        $validator
            ->scalar('fax_invoice')
            ->maxLength('fax_invoice', 30)
            ->allowEmptyString('fax_invoice');

        $validator
            ->scalar('address_invoice')
            ->allowEmptyString('address_invoice');

        $validator
            ->scalar('name_tax_invoice')
            ->maxLength('name_tax_invoice', 100)
            ->allowEmptyString('name_tax_invoice');

        $validator
            ->scalar('phone_tax_invoice')
            ->maxLength('phone_tax_invoice', 30)
            ->allowEmptyString('phone_tax_invoice');

        $validator
            ->scalar('fax_tax_invoice')
            ->maxLength('fax_tax_invoice', 30)
            ->allowEmptyString('fax_tax_invoice');

        $validator
            ->scalar('address_tax_invoice')
            ->allowEmptyString('address_tax_invoice');

        $validator
            ->scalar('npwp')
            ->maxLength('npwp', 100)
            ->allowEmptyString('npwp');

        $validator
            ->scalar('bank_name_ori')
            ->maxLength('bank_name_ori', 50)
            ->allowEmptyString('bank_name_ori');

        $validator
            ->scalar('bank_norek_ori')
            ->maxLength('bank_norek_ori', 50)
            ->allowEmptyString('bank_norek_ori');

        $validator
            ->scalar('va_no')
            ->maxLength('va_no', 50)
            ->allowEmptyString('va_no');

        $validator
            ->scalar('va_name')
            ->maxLength('va_name', 50)
            ->allowEmptyString('va_name');

        $validator
            ->scalar('ppn')
            ->allowEmptyString('ppn');

        $validator
            ->scalar('district')
            ->maxLength('district', 100)
            ->allowEmptyString('district');

        $validator
            ->scalar('is_active')
            ->notEmptyString('is_active');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

        $validator
            ->scalar('is_create')
            ->maxLength('is_create', 50)
            ->allowEmptyString('is_create');

        $validator
            ->scalar('is_update')
            ->maxLength('is_update', 50)
            ->allowEmptyString('is_update');

        $validator
            ->scalar('is_delete')
            ->maxLength('is_delete', 50)
            ->allowEmptyString('is_delete');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

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
        $rules->add($rules->existsIn(['marketing_id'], 'Users'), ['errorField' => 'marketing_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['item_id'], 'Items'), ['errorField' => 'item_id']);
        return $rules;
    }
}
