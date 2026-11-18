<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReturSuppliers Model
 *
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\PurchasingsTable&\Cake\ORM\Association\BelongsTo $Purchasings
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\WarehousesTable&\Cake\ORM\Association\BelongsTo $Warehouses
 * @property \App\Model\Table\ReturSupplierLinesTable&\Cake\ORM\Association\HasMany $ReturSupplierLines
 *
 * @method \App\Model\Entity\ReturSupplier newEmptyEntity()
 * @method \App\Model\Entity\ReturSupplier newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ReturSupplier[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReturSupplier get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReturSupplier findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ReturSupplier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReturSupplier[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReturSupplier|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReturSupplier saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReturSupplier[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturSupplier[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturSupplier[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturSupplier[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReturSuppliersTable extends Table
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

        $this->setTable('retur_suppliers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Purchasings', [
            'foreignKey' => 'purchasing_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Warehouses', [
            'foreignKey' => 'warehouse_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ReturSupplierLines', [
            'foreignKey' => 'retur_supplier_id',
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
            ->scalar('reason')
            ->maxLength('reason', 255)
            ->allowEmptyString('reason');

        $validator
            ->decimal('total')
            ->allowEmptyString('total');

        $validator
            ->integer('is_create')
            ->allowEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->allowEmptyString('is_update');

        $validator
            ->scalar('is_active')
            ->allowEmptyString('is_active');

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
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);
        $rules->add($rules->existsIn(['purchasing_id'], 'Purchasings'), ['errorField' => 'purchasing_id']);
       // $rules->add($rules->existsIn(['branch_id'], 'Branches'), ['errorField' => 'branch_id']);
        //$rules->add($rules->existsIn(['warehouse_id'], 'Warehouses'), ['errorField' => 'warehouse_id']);

        return $rules;
    }
}
