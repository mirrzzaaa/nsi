<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderLines Model
 *
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\ItemLinesTable&\Cake\ORM\Association\BelongsTo $ItemLines
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\ManifestsTable&\Cake\ORM\Association\BelongsTo $Manifests
 * @property \App\Model\Table\PermitsTable&\Cake\ORM\Association\BelongsTo $Permits
 * @property \App\Model\Table\SjpsTable&\Cake\ORM\Association\BelongsTo $Sjps
 * @property \App\Model\Table\TruckSchedulesTable&\Cake\ORM\Association\BelongsTo $TruckSchedules
 *
 * @method \App\Model\Entity\OrderLine newEmptyEntity()
 * @method \App\Model\Entity\OrderLine newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OrderLine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderLine get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderLine findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OrderLine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderLine[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderLine|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderLine saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderLine[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderLine[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderLine[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderLine[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrderLinesTable extends Table
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

        $this->setTable('order_lines');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('MouseItems', [
            'foreignKey' => 'mouse_item_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('ReturLines', [
            'foreignKey' => 'retur_line_id',
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
            ->decimal('toping')
            ->notEmptyString('toping');

        $validator
            ->decimal('price_t')
            ->notEmptyString('price_t');

        $validator
            ->date('expired_date')
            ->allowEmptyDate('expired_date');

        $validator
            ->scalar('number')
            ->maxLength('number', 100)
            ->allowEmptyString('number');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->integer('quantity')
            ->allowEmptyString('quantity');

        $validator
            ->decimal('discount')
            ->allowEmptyString('discount');

        $validator
            ->scalar('status_wait')
            ->notEmptyString('status_wait');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 50)
            ->allowEmptyString('unit');

        $validator
            ->decimal('price')
            ->allowEmptyString('price');

        $validator
            ->decimal('subtotal')
            ->allowEmptyString('subtotal');

        $validator
            ->scalar('comment')
            ->maxLength('comment', 255)
            ->allowEmptyString('comment');

        $validator
            ->dateTime('date_order')
            ->allowEmptyDateTime('date_order');

        $validator
            ->dateTime('date_manifest')
            ->allowEmptyDateTime('date_manifest');

        $validator
            ->date('date_estimate_schedule')
            ->allowEmptyDate('date_estimate_schedule');

        $validator
            ->dateTime('date_permit')
            ->allowEmptyDateTime('date_permit');

        $validator
            ->dateTime('date_sjp')
            ->allowEmptyDateTime('date_sjp');

        $validator
            ->dateTime('truck_schedule_date')
            ->allowEmptyDateTime('truck_schedule_date');

        $validator
            ->integer('is_create')
            ->notEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->notEmptyString('is_update');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'), ['errorField' => 'order_id']);
        $rules->add($rules->existsIn(['item_id'], 'Items'), ['errorField' => 'item_id']);
        $rules->add($rules->existsIn(['mouse_item_id'], 'MouseItems'), ['errorField' => 'mouse_item_id']);
        $rules->add($rules->existsIn(['retur_line_id'], 'ReturLines'), ['errorField' => 'retur_line_id']);

        return $rules;
    }
}
