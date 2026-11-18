<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReturSupplierLines Model
 *
 * @property \App\Model\Table\ReturSuppliersTable&\Cake\ORM\Association\BelongsTo $ReturSuppliers
 * @property \App\Model\Table\PurchasingLinesTable&\Cake\ORM\Association\BelongsTo $PurchasingLines
 * @property \App\Model\Table\WarehouseStocksTable&\Cake\ORM\Association\BelongsTo $WarehouseStocks
 * @property \App\Model\Table\BranchStocksTable&\Cake\ORM\Association\BelongsTo $BranchStocks
 *
 * @method \App\Model\Entity\ReturSupplierLine newEmptyEntity()
 * @method \App\Model\Entity\ReturSupplierLine newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ReturSupplierLine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReturSupplierLine get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReturSupplierLine findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ReturSupplierLine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReturSupplierLine[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReturSupplierLine|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReturSupplierLine saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReturSupplierLine[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturSupplierLine[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturSupplierLine[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturSupplierLine[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReturSupplierLinesTable extends Table
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

        $this->setTable('retur_supplier_lines');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ReturSuppliers', [
            'foreignKey' => 'retur_supplier_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PurchasingLines', [
            'foreignKey' => 'purchasing_lines_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('WarehouseStocks', [
            'foreignKey' => 'warehouse_stock_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('BranchStocks', [
            'foreignKey' => 'branch_stock_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
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
            ->integer('quantity')
            ->allowEmptyString('quantity');

        $validator
            ->decimal('nominal')
            ->allowEmptyString('nominal');

        $validator
            ->scalar('reason')
            ->maxLength('reason', 255)
            ->allowEmptyString('reason');

        $validator
            ->integer('is_create')
            ->allowEmptyString('is_create');

        $validator
            ->integer('is_update')
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
        $rules->add($rules->existsIn(['retur_supplier_id'], 'ReturSuppliers'), ['errorField' => 'retur_supplier_id']);
        $rules->add($rules->existsIn(['purchasing_lines_id'], 'PurchasingLines'), ['errorField' => 'purchasing_lines_id']);
        $rules->add($rules->existsIn(['warehouse_stock_id'], 'WarehouseStocks'), ['errorField' => 'warehouse_stock_id']);
        $rules->add($rules->existsIn(['branch_stock_id'], 'BranchStocks'), ['errorField' => 'branch_stock_id']);
        $rules->add($rules->existsIn(['item_id'], 'Items'), ['errorField' => 'item_id']);

        return $rules;
    }
}
