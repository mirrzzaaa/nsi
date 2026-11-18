<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Letters Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 *
 * @method \App\Model\Entity\Letter newEmptyEntity()
 * @method \App\Model\Entity\Letter newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Letter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Letter get($primaryKey, $options = [])
 * @method \App\Model\Entity\Letter findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Letter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Letter[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Letter|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Letter saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Letter[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Letter[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Letter[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Letter[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LettersTable extends Table
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

        $this->setTable('letters');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // $this->belongsTo('Branches', [
        //     'foreignKey' => 'branch_id',
        //     'joinType' => 'INNER',
        // ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'is_create',
            'joinType' => 'INNER',
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
            ->notEmptyString('number');

        $validator
            ->scalar('code')
            ->maxLength('code', 100)
            ->allowEmptyString('code');

        $validator
            ->scalar('project')
            ->maxLength('project', 100)
            ->allowEmptyString('project');

        $validator
            ->scalar('coded')
            ->maxLength('coded', 100)
            ->notEmptyString('coded');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('branch')
            ->maxLength('branch', 100)
            ->allowEmptyString('branch');

        $validator
            ->scalar('purpose')
            ->maxLength('purpose', 255)
            ->allowEmptyString('purpose');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->integer('applicant')
            ->allowEmptyString('applicant');

        $validator
            ->integer('approved')
            ->allowEmptyString('approved');

        $validator
            ->dateTime('approved_date')
            ->allowEmptyDateTime('approved_date');

        $validator
            ->integer('knowing')
            ->allowEmptyString('knowing');

        $validator
            ->integer('approved_ceo')
            ->allowEmptyString('approved_ceo');

        $validator
            ->dateTime('approved_ceo_date')
            ->allowEmptyDateTime('approved_ceo_date');

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

        $validator
            ->scalar('is_active')
            ->notEmptyString('is_active');

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
        // $rules->add($rules->existsIn(['branch_id'], 'Branches'), ['errorField' => 'branch_id']);
        $rules->add($rules->existsIn(['is_create'], 'Users'), ['errorField' => 'is_create']);

        return $rules;
    }
}
