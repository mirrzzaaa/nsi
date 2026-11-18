<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TandaTerima Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\InvoicesTable&\Cake\ORM\Association\BelongsTo $Invoices
 * @property \App\Model\Table\PermitsTable&\Cake\ORM\Association\BelongsTo $Permits
 *
 * @method \App\Model\Entity\TandaTerima newEmptyEntity()
 * @method \App\Model\Entity\TandaTerima newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\TandaTerima[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TandaTerima get($primaryKey, $options = [])
 * @method \App\Model\Entity\TandaTerima findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\TandaTerima patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TandaTerima[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TandaTerima|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TandaTerima saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TandaTerima[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\TandaTerima[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\TandaTerima[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\TandaTerima[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TandaTerimaTable extends Table
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

        $this->setTable('tanda_terima');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Invoices', [
            'foreignKey' => 'invoice_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Permits', [
            'foreignKey' => 'permit_id',
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
            ->scalar('code')
            ->maxLength('code', 255)
            ->allowEmptyString('code');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('no_faktur')
            ->maxLength('no_faktur', 255)
            ->allowEmptyString('no_faktur');

        $validator
            ->scalar('no_ba')
            ->maxLength('no_ba', 255)
            ->allowEmptyString('no_ba');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->date('payment_date')
            ->allowEmptyDate('payment_date');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['invoice_id'], 'Invoices'), ['errorField' => 'invoice_id']);
        $rules->add($rules->existsIn(['permit_id'], 'Permits'), ['errorField' => 'permit_id']);

        return $rules;
    }
}
