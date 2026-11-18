<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Trucks Model
 *
 * @method \App\Model\Entity\Truck newEmptyEntity()
 * @method \App\Model\Entity\Truck newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Truck[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Truck get($primaryKey, $options = [])
 * @method \App\Model\Entity\Truck findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Truck patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Truck[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Truck|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Truck saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Truck[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Truck[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Truck[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Truck[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TrucksTable extends Table
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

        $this->setTable('trucks');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        // $this->belongsTo('Transporters', [
        //     'foreignKey' => 'transporter_id',
        //     'joinType' => 'INNER',
        // ]);
        $this->hasMany('Permits', [
            'foreignKey' => 'truck_id',
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
            ->maxLength('name', 50)
            ->allowEmptyString('name');

        $validator
            ->scalar('merk')
            ->maxLength('merk', 255)
            ->allowEmptyString('merk');

        $validator
            ->scalar('types')
            ->maxLength('types', 255)
            ->allowEmptyString('types');

        $validator
            ->scalar('model')
            ->maxLength('model', 255)
            ->allowEmptyString('model');

        $validator
            ->scalar('image')
            ->maxLength('image', 255)
            ->allowEmptyFile('image');

        $validator
            ->scalar('chassis_no')
            ->maxLength('chassis_no', 255)
            ->allowEmptyString('chassis_no');

        $validator
            ->scalar('chassis_no_img')
            ->maxLength('chassis_no_img', 255)
            ->allowEmptyString('chassis_no_img');

        $validator
            ->scalar('machine_no')
            ->maxLength('machine_no', 255)
            ->allowEmptyString('machine_no');

        $validator
            ->scalar('machine_no_img')
            ->maxLength('machine_no_img', 255)
            ->allowEmptyString('machine_no_img');

        $validator
            ->scalar('color')
            ->maxLength('color', 255)
            ->allowEmptyString('color');

        $validator
            ->scalar('insurance')
            ->maxLength('insurance', 255)
            ->allowEmptyString('insurance');

        $validator
            ->integer('tire')
            ->allowEmptyString('tire');

        $validator
            ->scalar('production_year')
            ->allowEmptyString('production_year');

        $validator
            ->scalar('bapedal_registration')
            ->maxLength('bapedal_registration', 100)
            ->allowEmptyString('bapedal_registration');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

        $validator
            ->scalar('is_create')
            ->maxLength('is_create', 15)
            ->allowEmptyString('is_create');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

        $validator
            ->scalar('is_active')
            ->notEmptyString('is_active');

        $validator
            ->scalar('is_delete')
            ->maxLength('is_delete', 15)
            ->allowEmptyString('is_delete');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        $validator
            ->scalar('is_update')
            ->maxLength('is_update', 15)
            ->allowEmptyString('is_update');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        // $rules->add($rules->existsIn(['transporter_id'], 'Transporters'), ['errorField' => 'transporter_id']);

        return $rules;
    }
}
