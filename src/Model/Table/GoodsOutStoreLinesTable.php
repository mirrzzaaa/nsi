<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GoodsOutStoreLines Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\GoodsOutStoresTable&\Cake\ORM\Association\BelongsTo $GoodsOutStores
 * @property \App\Model\Table\ItemLinesTable&\Cake\ORM\Association\BelongsTo $ItemLines
 *
 * @method \App\Model\Entity\GoodsOutStoreLine newEmptyEntity()
 * @method \App\Model\Entity\GoodsOutStoreLine newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutStoreLine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutStoreLine get($primaryKey, $options = [])
 * @method \App\Model\Entity\GoodsOutStoreLine findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\GoodsOutStoreLine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutStoreLine[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GoodsOutStoreLine|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GoodsOutStoreLine saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GoodsOutStoreLine[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsOutStoreLine[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsOutStoreLine[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GoodsOutStoreLine[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GoodsOutStoreLinesTable extends Table
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

        $this->setTable('goods_out_store_lines');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('GoodsOutStores', [
            'foreignKey' => 'goods_out_store_id',
        ]);
        $this->belongsTo('ItemLines', [
            'foreignKey' => 'item_lines_id',
        ]);

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
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
            ->scalar('unit')
            ->maxLength('unit', 255)
            ->allowEmptyString('unit');

        $validator
            ->decimal('qty')
            ->allowEmptyString('qty');

        $validator
            ->scalar('packing')
            ->maxLength('packing', 255)
            ->allowEmptyString('packing');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
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
        $rules->add($rules->existsIn(['goods_out_store_id'], 'GoodsOutStores'), ['errorField' => 'goods_out_store_id']);
        $rules->add($rules->existsIn(['item_lines_id'], 'ItemLines'), ['errorField' => 'item_lines_id']);
        $rules->add($rules->existsIn(['item_id'], 'Items'), ['errorField' => 'item_id']);

        return $rules;
    }
}
