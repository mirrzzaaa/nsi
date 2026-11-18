<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Members Model
 *
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 *
 * @method \App\Model\Entity\Member newEmptyEntity()
 * @method \App\Model\Entity\Member newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Member[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Member get($primaryKey, $options = [])
 * @method \App\Model\Entity\Member findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Member patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Member[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Member|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Member saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Member[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Member[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Member[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Member[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MembersTable extends Table
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

        $this->setTable('members');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Orders', [
            'foreignKey' => 'member_id',
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
            ->maxLength('name', 50)
            ->allowEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('address')
            ->allowEmptyString('address');

        $validator
            ->scalar('telp')
            ->maxLength('telp', 255)
            ->allowEmptyString('telp');

        $validator
            ->scalar('hp')
            ->maxLength('hp', 30)
            ->allowEmptyString('hp');

        $validator
            ->scalar('fax')
            ->maxLength('fax', 30)
            ->allowEmptyString('fax');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->integer('points')
            ->notEmptyString('points');

        $validator
            ->scalar('npwp')
            ->maxLength('npwp', 100)
            ->allowEmptyString('npwp');

        $validator
            ->date('date_registry')
            ->allowEmptyDate('date_registry');

        $validator
            ->date('date_expired')
            ->allowEmptyDate('date_expired');

        $validator
            ->scalar('tax')
            ->notEmptyString('tax');

        $validator
            ->scalar('city')
            ->maxLength('city', 50)
            ->allowEmptyString('city');

        $validator
            ->scalar('province')
            ->maxLength('province', 100)
            ->allowEmptyString('province');

        $validator
            ->integer('postal')
            ->allowEmptyString('postal');

        $validator
            ->scalar('country')
            ->maxLength('country', 50)
            ->allowEmptyString('country');

        $validator
            ->scalar('pic')
            ->maxLength('pic', 50)
            ->allowEmptyString('pic');

        $validator
            ->scalar('website')
            ->maxLength('website', 50)
            ->allowEmptyString('website');

        $validator
            ->scalar('is_active')
            ->notEmptyString('is_active');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

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
        $rules->add($rules->isUnique(['name']), ['errorField' => 'name']);

        return $rules;
    }
}
