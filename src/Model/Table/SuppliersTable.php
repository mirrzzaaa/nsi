<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Suppliers Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\HasMany $Items
 * @property \App\Model\Table\PurchasingsTable&\Cake\ORM\Association\HasMany $Purchasings
 *
 * @method \App\Model\Entity\Supplier newEmptyEntity()
 * @method \App\Model\Entity\Supplier newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Supplier[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Supplier get($primaryKey, $options = [])
 * @method \App\Model\Entity\Supplier findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Supplier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Supplier[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Supplier|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Supplier saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Supplier[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Supplier[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Supplier[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Supplier[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SuppliersTable extends Table
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
        $this->setTable('suppliers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('WarehouseStocks', [
            'foreignKey' => 'warehouse_stock_id',
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'supplier_id',
        ]);
        $this->hasMany('Purchasings', [
            'foreignKey' => 'supplier_id',
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
            ->maxLength('code', 50)
            ->allowEmptyString('code');

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->allowEmptyString('name');

        $validator
            ->scalar('address')
            ->allowEmptyString('address');

        $validator
            ->scalar('npwp')
            ->maxLength('npwp', 100)
            ->allowEmptyString('npwp');

        $validator
            ->scalar('tax')
            ->allowEmptyString('tax');

        $validator
            ->scalar('ppn')
            ->allowEmptyString('ppn');

        $validator
            ->scalar('pic')
            ->maxLength('pic', 50)
            ->allowEmptyString('pic');

        $validator
            ->scalar('pic_dept')
            ->maxLength('pic_dept', 50)
            ->allowEmptyString('pic_dept');

        $validator
            ->scalar('telp')
            ->maxLength('telp', 30)
            ->allowEmptyString('telp');

        $validator
            ->scalar('fax')
            ->maxLength('fax', 30)
            ->allowEmptyString('fax');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('is_active')
            ->notEmptyString('is_active');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

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
        $rules->add($rules->existsIn(['warehouse_stock_id'], 'WarehouseStocks'), ['errorField' => 'warehouse_stock_id']);

        return $rules;
    }
}
