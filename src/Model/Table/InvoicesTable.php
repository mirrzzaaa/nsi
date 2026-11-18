<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Invoices Model
 *
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\SignsTable&\Cake\ORM\Association\BelongsTo $Signs
 * @property \App\Model\Table\PermitsTable&\Cake\ORM\Association\HasMany $Permits
 *
 * @method \App\Model\Entity\Invoice newEmptyEntity()
 * @method \App\Model\Entity\Invoice newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Invoice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Invoice get($primaryKey, $options = [])
 * @method \App\Model\Entity\Invoice findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Invoice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invoice saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InvoicesTable extends Table
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

        $this->setTable('invoices');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('OrderLines', [
            'foreignKey' => 'order_line_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('TandaTerima', [
            'foreignKey' => 'tanda_terima_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'is_create',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Receipts', [
            'foreignKey' => 'invoice_id',
        ]);

        // $this->belongsTo('Signs', [
        //     'foreignKey' => 'sign_id',
        // ]);
        // $this->hasMany('Permits', [
        //     'foreignKey' => 'invoice_id',
        // ]);
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
            ->scalar('number_noppn')
            ->maxLength('number_noppn', 255)
            ->allowEmptyString('number_noppn');

        $validator
            ->scalar('ppn')
            ->maxLength('ppn', 255)
            ->notEmptyString('ppn');

        $validator
            ->scalar('tax')
            ->notEmptyString('tax');

        $validator
            ->scalar('proforma_method')
            ->maxLength('proforma_method', 100)
            ->allowEmptyString('proforma_method');

        $validator
            ->decimal('proforma_nominal')
            ->allowEmptyString('proforma_nominal');
            
        $validator
            ->scalar('proforma_ppn')
            ->notEmptyString('proforma_ppn');

        $validator
            ->scalar('dp_method')
            ->maxLength('dp_method', 100)
            ->allowEmptyString('dp_method');

        $validator
            ->decimal('dp_nominal')
            ->allowEmptyString('dp_nominal');
            
        $validator
            ->scalar('dp_ppn')
            ->notEmptyString('dp_ppn');

        $validator
            ->scalar('through')
            ->maxLength('through', 50)
            ->allowEmptyString('through');

        $validator
            ->scalar('came_from')
            ->maxLength('came_from', 50)
            ->allowEmptyString('came_from');

        $validator
            ->scalar('number_tax_invoice')
            ->maxLength('number_tax_invoice', 255)
            ->allowEmptyString('number_tax_invoice');

        $validator
            ->scalar('commission')
            ->maxLength('commission', 100)
            ->allowEmptyString('commission');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->date('expired')
            ->allowEmptyDate('expired');

        $validator
            ->scalar('referense_po')
            ->maxLength('referense_po', 100)
            ->allowEmptyString('referense_po');

        $validator
            ->decimal('grandtotal')
            ->allowEmptyString('grandtotal');

        $validator
            ->scalar('transport')
            ->maxLength('transport', 100)
            ->allowEmptyString('transport');

        $validator
            ->scalar('transport_quantity')
            ->maxLength('transport_quantity', 100)
            ->allowEmptyString('transport_quantity');

        $validator
            ->scalar('transport_unit')
            ->maxLength('transport_unit', 100)
            ->allowEmptyString('transport_unit');

        $validator
            ->scalar('transport_2')
            ->maxLength('transport_2', 100)
            ->allowEmptyString('transport_2');

        $validator
            ->scalar('transport_quantity_2')
            ->maxLength('transport_quantity_2', 100)
            ->allowEmptyString('transport_quantity_2');

        $validator
            ->scalar('transport_unit_2')
            ->maxLength('transport_unit_2', 100)
            ->allowEmptyString('transport_unit_2');

        $validator
            ->scalar('handling')
            ->maxLength('handling', 100)
            ->allowEmptyString('handling');

        $validator
            ->scalar('handling_quantity')
            ->maxLength('handling_quantity', 100)
            ->allowEmptyString('handling_quantity');

        $validator
            ->scalar('handling_unit')
            ->maxLength('handling_unit', 100)
            ->allowEmptyString('handling_unit');

        $validator
            ->scalar('discount')
            ->maxLength('discount', 100)
            ->allowEmptyString('discount');

        $validator
            ->decimal('discount_price')
            ->allowEmptyString('discount_price');

        $validator
            ->scalar('discount_quantity')
            ->maxLength('discount_quantity', 100)
            ->allowEmptyString('discount_quantity');

        $validator
            ->scalar('discount_unit')
            ->maxLength('discount_unit', 100)
            ->allowEmptyString('discount_unit');

        $validator
            ->decimal('biaya_lain')
            ->allowEmptyString('biaya_lain');

        $validator
            ->decimal('biaya_lain_1')
            ->allowEmptyString('biaya_lain_1');

        $validator
            ->decimal('biaya_lain_2')
            ->allowEmptyString('biaya_lain_2');

        $validator
            ->decimal('biaya_lain_3')
            ->allowEmptyString('biaya_lain_3');

        $validator
            ->decimal('biaya_lain_quantity')
            ->allowEmptyString('biaya_lain_quantity');

        $validator
            ->decimal('biaya_lain_quantity_1')
            ->allowEmptyString('biaya_lain_quantity_1');

        $validator
            ->decimal('biaya_lain_quantity_2')
            ->allowEmptyString('biaya_lain_quantity_2');

        $validator
            ->decimal('biaya_lain_quantity_3')
            ->allowEmptyString('biaya_lain_quantity_3');

        $validator
            ->scalar('biaya_lain_unit')
            ->maxLength('biaya_lain_unit', 100)
            ->allowEmptyString('biaya_lain_unit');

        $validator
            ->scalar('biaya_lain_unit_1')
            ->maxLength('biaya_lain_unit_1', 100)
            ->allowEmptyString('biaya_lain_unit_1');

        $validator
            ->scalar('biaya_lain_unit_2')
            ->maxLength('biaya_lain_unit_2', 100)
            ->allowEmptyString('biaya_lain_unit_2');

        $validator
            ->scalar('biaya_lain_unit_3')
            ->maxLength('biaya_lain_unit_3', 100)
            ->allowEmptyString('biaya_lain_unit_3');

        $validator
            ->scalar('biaya_lain_desc')
            ->maxLength('biaya_lain_desc', 255)
            ->allowEmptyString('biaya_lain_desc');

        $validator
            ->scalar('biaya_lain_desc_1')
            ->maxLength('biaya_lain_desc_1', 255)
            ->allowEmptyString('biaya_lain_desc_1');

        $validator
            ->scalar('biaya_lain_desc_2')
            ->maxLength('biaya_lain_desc_2', 255)
            ->allowEmptyString('biaya_lain_desc_2');

        $validator
            ->scalar('biaya_lain_desc_3')
            ->maxLength('biaya_lain_desc_3', 255)
            ->allowEmptyString('biaya_lain_desc_3');

        $validator
            ->scalar('payment')
            ->notEmptyString('payment');

        $validator
            ->decimal('payment_nominal_1')
            ->allowEmptyString('payment_nominal_1');

        $validator
            ->decimal('payment_nominal_2')
            ->allowEmptyString('payment_nominal_2');

        $validator
            ->decimal('payment_nominal_3')
            ->allowEmptyString('payment_nominal_3');

        $validator
            ->date('payment_date')
            ->allowEmptyDate('payment_date'); 

        $validator
            ->date('payment_date_1')
            ->allowEmptyDate('payment_date_1');

        $validator
            ->date('payment_date_2')
            ->allowEmptyDate('payment_date_2');

        $validator
            ->date('payment_date_3')
            ->allowEmptyDate('payment_date_3');

        $validator
            ->scalar('payment_who')
            ->maxLength('payment_who', 100)
            ->allowEmptyString('payment_who');

        $validator
            ->scalar('payment_jumlah_ori')
            ->maxLength('payment_jumlah_ori', 50)
            ->allowEmptyString('payment_jumlah_ori');

        $validator
            ->decimal('payment_jumlah')
            ->allowEmptyString('payment_jumlah');

        $validator
            ->scalar('payment_desc')
            ->allowEmptyString('payment_desc');

        $validator
            ->scalar('payment_method')
            ->maxLength('payment_method', 100)
            ->allowEmptyString('payment_method');

        $validator
            ->scalar('payment_method_1')
            ->maxLength('payment_method_1', 100)
            ->allowEmptyString('payment_method_1');

        $validator
            ->scalar('payment_method_2')
            ->maxLength('payment_method_2', 100)
            ->allowEmptyString('payment_method_2');

        $validator
            ->scalar('payment_method_3')
            ->maxLength('payment_method_3', 100)
            ->allowEmptyString('payment_method_3');

        $validator
            ->scalar('payment_bank')
            ->maxLength('payment_bank', 255)
            ->allowEmptyString('payment_bank');

        $validator
            ->scalar('payment_bank_va')
            ->allowEmptyString('payment_bank_va');

        $validator
            ->decimal('biaya_bank')
            ->allowEmptyString('biaya_bank');

        $validator
            ->decimal('pembulatan')
            ->allowEmptyString('pembulatan');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('komisi_1')
            ->maxLength('komisi_1', 50)
            ->allowEmptyString('komisi_1');

        $validator
            ->scalar('komisi_2')
            ->maxLength('komisi_2', 50)
            ->allowEmptyString('komisi_2');

        $validator
            ->scalar('komisi_3')
            ->maxLength('komisi_3', 50)
            ->allowEmptyString('komisi_3');

        $validator
            ->scalar('komisi_4')
            ->maxLength('komisi_4', 50)
            ->allowEmptyString('komisi_4');

        $validator
            ->scalar('komisi_5')
            ->maxLength('komisi_5', 50)
            ->allowEmptyString('komisi_5');

        $validator
            ->integer('rpt_berita_acara')
            ->allowEmptyString('rpt_berita_acara');

        $validator
            ->dateTime('rpt_berita_acara_date')
            ->allowEmptyDateTime('rpt_berita_acara_date');

        $validator
            ->integer('rpt_invoice')
            ->allowEmptyString('rpt_invoice');

        $validator
            ->dateTime('rpt_invoice_date')
            ->allowEmptyDateTime('rpt_invoice_date');

        $validator
            ->integer('rpt_tax_invoice')
            ->allowEmptyString('rpt_tax_invoice');

        $validator
            ->dateTime('rpt_tax_invoice_date')
            ->allowEmptyDateTime('rpt_tax_invoice_date');

        $validator
            ->scalar('pph_no')
            ->maxLength('pph_no', 50)
            ->allowEmptyString('pph_no');

        $validator
            ->date('pph_date')
            ->allowEmptyDate('pph_date');

        $validator
            ->decimal('pph_jumlah')
            ->allowEmptyString('pph_jumlah');

        $validator
            ->date('ppn_900_date')
            ->allowEmptyDate('ppn_900_date');

        $validator
            ->decimal('ppn_900_jumlah')
            ->allowEmptyString('ppn_900_jumlah');

        $validator
            ->scalar('delivery')
            ->maxLength('delivery', 255)
            ->allowEmptyString('delivery');

        $validator
            ->date('delivery_date')
            ->allowEmptyDate('delivery_date');

        $validator
            ->scalar('delivery_media')
            ->maxLength('delivery_media', 255)
            ->allowEmptyString('delivery_media');

        $validator
            ->scalar('delivery_up')
            ->maxLength('delivery_up', 255)
            ->allowEmptyString('delivery_up');

        $validator
            ->scalar('delivery_desc_all')
            ->allowEmptyString('delivery_desc_all');

        $validator
            ->scalar('delivery_desc')
            ->maxLength('delivery_desc', 255)
            ->allowEmptyString('delivery_desc');

        $validator
            ->date('receive_date')
            ->allowEmptyDate('receive_date');

        $validator
            ->scalar('receive')
            ->maxLength('receive', 255)
            ->allowEmptyString('receive');

        $validator
            ->integer('director')
            ->allowEmptyString('director');

        $validator
            ->scalar('posting')
            ->allowEmptyString('posting');

        $validator
            ->date('posting_date')
            ->allowEmptyDate('posting_date');

        $validator
            ->scalar('who_create')
            ->maxLength('who_create', 50)
            ->allowEmptyString('who_create');

        $validator
            ->scalar('who_update')
            ->maxLength('who_update', 50)
            ->allowEmptyString('who_update');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

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
        $rules->add($rules->existsIn(['order_line_id'], 'OrderLines'), ['errorField' => 'order_line_id']);
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn(['receipt_id'], 'Receipts'), ['errorField' => 'receipt_id']);
        $rules->add($rules->existsIn(['tanda_terima_id'], 'TandaTerima'), ['errorField' => 'tanda_terima_id']);
        $rules->add($rules->existsIn(['is_create'], 'Users'), ['errorField' => 'is_create']);

        return $rules;
    }
}
