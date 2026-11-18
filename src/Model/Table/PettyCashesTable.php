<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PettyCashes Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\PettyCashLinesTable&\Cake\ORM\Association\HasMany $PettyCashLines
 *
 * @method \App\Model\Entity\PettyCash newEmptyEntity()
 * @method \App\Model\Entity\PettyCash newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PettyCash[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PettyCash get($primaryKey, $options = [])
 * @method \App\Model\Entity\PettyCash findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PettyCash patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PettyCash[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PettyCash|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PettyCash saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PettyCash[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PettyCash[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PettyCash[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PettyCash[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PettyCashesTable extends Table
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

        $this->setTable('petty_cashes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // $this->belongsTo('Branches', [
        //     'foreignKey' => 'branch_id',
        //     'joinType' => 'INNER',
        // ]);

        $this->belongsTo('UserApplicant', [
            'className' => 'Users',
            'foreignKey' => 'applicant',
            'joinType' => 'LEFT',
            //'propertyName' => 'userapplicant', //Penambahan nama bila nama table bentrok dengan sistem kerja framework (group bisa juga dipakai mysql)
        ]);

        $this->belongsTo('User', [
            'className' => 'Users',
            'foreignKey' => false,
            'conditions' => 'User.id = PettyCashes.is_create',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('AcceptAcc', [
            'className' => 'Users',
            'foreignKey' => false,
            'conditions' => 'AcceptAcc.id = PettyCashes.approved_acc',
            //'propertyName' => 'appro',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Accept', [
            'className' => 'Users',
            'foreignKey' => false,
            'conditions' => 'Accept.id = PettyCashes.approved',
            //'propertyName' => 'appro',
            'joinType' => 'LEFT',
        ]);

        $this->hasMany('PettyCashLines', ['dependent' => true])->setForeignKey('petty_cash_id')->setDependent(true);

        /*$this->hasMany('PettyCashLines', [
            'foreignKey' => 'petty_cash_id',
            //    'order' => ['PettyCashLines.petty_cash_no' => 'ASC']
        ]);*/
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
            ->maxLength('code', 100)
            ->notEmptyString('code');

        $validator
            ->scalar('type')
            ->maxLength('type', 100)
            ->notEmptyString('type');

        $validator
            ->scalar('project')
            ->maxLength('project', 100)
            ->notEmptyString('project');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->date('due_date')
            ->allowEmptyDate('due_date');

        $validator
            ->scalar('devision')
            ->maxLength('devision', 100)
            ->allowEmptyString('devision');

        $validator
            ->scalar('purpose_of_advancing')
            ->maxLength('purpose_of_advancing', 255)
            ->allowEmptyString('purpose_of_advancing');

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
            ->integer('payment')
            ->allowEmptyString('payment');

        $validator
            ->date('payment_date')
            ->allowEmptyDate('payment_date');

        $validator
            ->dateTime('payment_date_now')
            ->allowEmptyDateTime('payment_date_now');

        $validator
            ->scalar('payment_type')
            ->maxLength('payment_type', 255)
            ->allowEmptyString('payment_type');

        $validator
            ->decimal('payment_last')
            ->allowEmptyString('payment_last');

        $validator
            ->decimal('payment_nominal')
            ->allowEmptyString('payment_nominal');

        $validator
            ->scalar('payment_desc')
            ->maxLength('payment_desc', 255)
            ->allowEmptyString('payment_desc');

        $validator
            ->scalar('payment_status')
            ->allowEmptyString('payment_status');

        $validator
            ->date('accountability_date')
            ->allowEmptyDate('accountability_date');

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
        $rules->add($rules->existsIn(['applicant'], 'UserApplicant'), ['errorField' => 'applicant']);
        return $rules;
    }

    public function getMax($devision, $monthYear) {
        $dataRows = $this->find('all',[
            'fields' => array('codes' => 'MAX(CAST(SUBSTRING_INDEX(PettyCashes.code, " ", -1) AS UNSIGNED))+1'),
            'conditions' => array('PettyCashes.devision' => $devision, 'SUBSTR(PettyCashes.date, 1, 4) =' => $monthYear)
        ]); 

        $dataRows = $dataRows->first();
        $dataResult = $dataRows->codes;
        $results = (empty($dataResult)) ? "1": $dataResult;
        $result = str_pad($results, 4, "0", STR_PAD_LEFT);
        
        return $result;
    }

}
