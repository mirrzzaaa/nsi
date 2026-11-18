<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PettyCashBook Entity
 *
 * @property int $id
 * @property int|null $no_urut
 * @property \Cake\I18n\FrozenDate $tgl_input
 * @property \Cake\I18n\FrozenDate|null $tgl_trx
 * @property string|null $uraian
 * @property string $debet
 * @property string $kredit
 * @property string|null $pj
 * @property string|null $pca
 * @property string|null $ktgr
 * @property string|null $keterangan
 * @property bool $is_saldo_awal
 * @property string|null $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string $is_active
 *
 * @property string $no_kas  (virtual)
 * @property float|null $total  (diisi controller, bukan kolom DB)
 */
class PettyCashBook extends Entity
{
    protected $_accessible = [
        'no_urut' => true,
        'tgl_input' => true,
        'tgl_trx' => true,
        'uraian' => true,
        'debet' => true,
        'kredit' => true,
        'pj' => true,
        'pca' => true,
        'ktgr' => true,
        'keterangan' => true,
        'is_saldo_awal' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
    ];

    protected $_virtual = ['no_kas'];

    /**
     * No Kas otomatis, contoh: 0001/KK-NSI/I/2026
     */
    protected function _getNoKas(): string
    {
        if (empty($this->no_urut) || empty($this->tgl_input)) {
            return '';
        }

        $romawi = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

        return sprintf(
            '%04d/KK-NSI/%s/%s',
            $this->no_urut,
            $romawi[(int) $this->tgl_input->format('n')],
            $this->tgl_input->format('Y')
        );
    }
}