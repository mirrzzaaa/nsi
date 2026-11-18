<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReturLines Model
 *
 * @property \App\Model\Table\OrderLinesTable&\Cake\ORM\Association\BelongsTo $OrderLines
 *
 * @method \App\Model\Entity\ReturLine newEmptyEntity()
 * @method \App\Model\Entity\ReturLine newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ReturLine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReturLine get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReturLine findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ReturLine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReturLine[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReturLine|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReturLine saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReturLine[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturLine[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturLine[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturLine[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReturLinesTable extends Table
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

        $this->setTable('retur_lines');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('OrderLines', [
            'foreignKey' => 'order_lines_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Returs', [
            'foreignKey' => 'retur_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('WarehouseStocks', [
            'foreignKey' => 'warehouse_stock_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('BranchStocks', [
            'foreignKey' => 'branch_stock_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'LEFT',
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
            ->scalar('condition')
            ->maxLength('condition', 255)
            ->allowEmptyString('condition');

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
        $rules->add($rules->existsIn(['order_lines_id'], 'OrderLines'), ['errorField' => 'order_lines_id']);
        $rules->add($rules->existsIn(['retur_id'], 'Returs'), ['errorField' => 'retur_id']);
        $rules->add($rules->existsIn(['warehouse_stock_id'], 'WarehouseStocks'), ['errorField' => 'warehouse_stock_id']);
        $rules->add($rules->existsIn(['branch_stock_id'], 'BranchStocks'), ['errorField' => 'branch_stock_id']);
        $rules->add($rules->existsIn(['item_id'], 'Items'), ['errorField' => 'item_id']);

        return $rules;
    }
}
