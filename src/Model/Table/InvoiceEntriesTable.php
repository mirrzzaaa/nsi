<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InvoiceEntries Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\PurchasingsTable&\Cake\ORM\Association\BelongsTo $Purchasings
 * @property \App\Model\Table\InvoiceEntryLinesTable&\Cake\ORM\Association\HasMany $InvoiceEntryLines
 *
 * @method \App\Model\Entity\InvoiceEntry newEmptyEntity()
 * @method \App\Model\Entity\InvoiceEntry newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceEntry[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceEntry get($primaryKey, $options = [])
 * @method \App\Model\Entity\InvoiceEntry findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\InvoiceEntry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceEntry[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceEntry|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InvoiceEntry saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InvoiceEntry[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\InvoiceEntry[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\InvoiceEntry[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\InvoiceEntry[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InvoiceEntriesTable extends Table
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

        $this->setTable('invoice_entries');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Purchasings', [
            'foreignKey' => 'purchasing_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('InvoiceEntryLines', [
            'foreignKey' => 'invoice_entry_id',
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
            ->maxLength('code', 100)
            ->notEmptyString('code');

        $validator
            ->scalar('company')
            ->maxLength('company', 255)
            ->allowEmptyString('company');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->date('due_date')
            ->allowEmptyDate('due_date');

        $validator
            ->scalar('purpose_of_advancing')
            ->maxLength('purpose_of_advancing', 255)
            ->allowEmptyString('purpose_of_advancing');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('ppn')
            ->maxLength('ppn', 255)
            ->notEmptyString('ppn');

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
            ->integer('approved_acc')
            ->allowEmptyString('approved_acc');

        $validator
            ->dateTime('approved_acc_date')
            ->allowEmptyDateTime('approved_acc_date');

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
        $rules->add($rules->existsIn(['branch_id'], 'Branches'), ['errorField' => 'branch_id']);
        $rules->add($rules->existsIn(['purchasing_id'], 'Purchasings'), ['errorField' => 'purchasing_id']);

        return $rules;
    }
}
