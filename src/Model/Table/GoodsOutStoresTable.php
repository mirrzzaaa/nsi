<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GoodsOutStores Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\ReturnGoodsTable&\Cake\ORM\Association\BelongsTo $ReturnGoods
 * @property \App\Model\Table\GoodsInStoresTable&\Cake\ORM\Association\HasMany $GoodsInStores
 * @property \App\Model\Table\GoodsOutStoreLinesTable&\Cake\ORM\Association\HasMany $GoodsOutStoreLines
 *
 * @method \App\Model\Entity\GoodsOutStore newEmptyEntity()
 * @method \App\Model\Entity\GoodsOutStore newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutStore[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutStore get($primaryKey, $options = [])
 * @method \App\Model\Entity\GoodsOutStore findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\GoodsOutStore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutStore[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutStore|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GoodsOutStore saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GoodsOutStore[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsOutStore[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsOutStore[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsOutStore[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GoodsOutStoresTable extends Table
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

        $this->setTable('goods_out_stores');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
        ]);
        // $this->belongsTo('ReturnGoods', [
        //     'foreignKey' => 'return_goods_id',
        // ]);
        $this->hasMany('GoodsInStores', [
            'foreignKey' => 'goods_out_store_id',
        ]);
        $this->hasMany('GoodsOutStoreLines', [
            'foreignKey' => 'goods_out_store_id',
        ]);
        $this->hasMany('BranchStocks', [
            'foreignKey' => 'branch_stock_id',
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
            ->scalar('status_out')
            ->maxLength('status_out', 50)
            ->allowEmptyString('status_out');

        $validator
            ->scalar('is_to')
            ->maxLength('is_to', 50)
            ->allowEmptyString('is_to');

        $validator
            ->scalar('code')
            ->maxLength('code', 255)
            ->allowEmptyString('code');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

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
            ->scalar('is_active')
            ->allowEmptyString('is_active');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

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
        $rules->add($rules->existsIn(['branch_id'], 'Branches'), ['errorField' => 'branch_id']);
        $rules->add($rules->existsIn(['order_id'], 'Orders'), ['errorField' => 'order_id']);
        $rules->add($rules->existsIn(['branch_stock_id'], 'BranchStocks'), ['errorField' => 'branch_stock_id']);
        // $rules->add($rules->existsIn(['return_goods_id'], 'ReturnGoods'), ['errorField' => 'return_goods_id']);

        return $rules;
    }
}
