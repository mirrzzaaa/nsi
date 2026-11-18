<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Event\EventInterface;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PettyCashBooks Model
 *
 * @method \App\Model\Entity\PettyCashBook newEmptyEntity()
 * @method \App\Model\Entity\PettyCashBook newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PettyCashBook get($primaryKey, $options = [])
 * @method \App\Model\Entity\PettyCashBook patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PettyCashBook|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PettyCashBooksTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('petty_cash_books');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->date('tgl_input')
            ->requirePresence('tgl_input', 'create')
            ->notEmptyDate('tgl_input');

        $validator
            ->date('tgl_trx')
            ->allowEmptyDate('tgl_trx');

        $validator
            ->scalar('uraian')
            ->allowEmptyString('uraian');

        $validator
            ->decimal('debet')
            ->allowEmptyString('debet');

        $validator
            ->decimal('kredit')
            ->allowEmptyString('kredit');

        $validator
            ->scalar('pj')
            ->maxLength('pj', 255)
            ->allowEmptyString('pj');

        $validator
            ->scalar('pca')
            ->maxLength('pca', 100)
            ->allowEmptyString('pca');

        $validator
            ->scalar('ktgr')
            ->maxLength('ktgr', 20)
            ->allowEmptyString('ktgr');

        $validator
            ->scalar('keterangan')
            ->allowEmptyString('keterangan');

        return $validator;
    }

    /**
     * Isi no_urut otomatis (reset tiap tahun) untuk baris baru.
     * Baris Saldo Awal tidak diberi nomor.
     */
    public function beforeSave(EventInterface $event, $entity, $options)
    {
        if ($entity->isNew() && empty($entity->no_urut) && empty($entity->is_saldo_awal)) {
            $tahun = $entity->tgl_input->format('Y');

            $row = $this->find()
                ->select(['m' => 'MAX(PettyCashBooks.no_urut)'])
                ->where(['YEAR(PettyCashBooks.tgl_input)' => $tahun])
                ->first();

            $entity->no_urut = ((int) ($row->m ?? 0)) + 1;
        }
    }
}