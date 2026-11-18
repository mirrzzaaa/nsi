<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invoice Entity
 *
 * @property int $id
 * @property string $order_id
 * @property string|null $code
 * @property string|null $number_noppn
 * @property string $ppn
 * @property string $tax
 * @property string|null $through
 * @property string|null $came_from
 * @property string|null $number_tax_invoice
 * @property string $commission
 * @property \Cake\I18n\FrozenDate|null $date
 * @property \Cake\I18n\FrozenDate|null $expired
 * @property string|null $referense_po
 * @property string|null $transport
 * @property string|null $transport_quantity
 * @property string|null $transport_unit
 * @property string|null $transport_2
 * @property string|null $transport_quantity_2
 * @property string|null $transport_unit_2
 * @property string|null $handling
 * @property string|null $handling_quantity
 * @property string|null $handling_unit
 * @property string|null $discount
 * @property string|null $discount_price
 * @property string|null $discount_quantity
 * @property string|null $discount_unit
 * @property string|null $biaya_lain
 * @property string|null $biaya_lain_1
 * @property string|null $biaya_lain_2
 * @property string|null $biaya_lain_3
 * @property string|null $biaya_lain_quantity
 * @property string|null $biaya_lain_quantity_1
 * @property string|null $biaya_lain_quantity_2
 * @property string|null $biaya_lain_quantity_3
 * @property string|null $biaya_lain_unit
 * @property string|null $biaya_lain_unit_1
 * @property string|null $biaya_lain_unit_2
 * @property string|null $biaya_lain_unit_3
 * @property string|null $biaya_lain_desc
 * @property string|null $biaya_lain_desc_1
 * @property string|null $biaya_lain_desc_2
 * @property string|null $biaya_lain_desc_3
 * @property string $payment
 * @property \Cake\I18n\FrozenDate|null $payment_date
 * @property string|null $payment_who
 * @property string|null $payment_jumlah_ori
 * @property string|null $payment_jumlah
 * @property string $payment_desc
 * @property string|null $payment_method
 * @property string|null $payment_bank
 * @property string|null $payment_bank_va
 * @property string|null $biaya_bank
 * @property string|null $pembulatan
 * @property string|null $description
 * @property string|null $komisi_1
 * @property string|null $komisi_2
 * @property string|null $komisi_3
 * @property string|null $komisi_4
 * @property string|null $komisi_5
 * @property int|null $rpt_berita_acara
 * @property \Cake\I18n\FrozenTime|null $rpt_berita_acara_date
 * @property int|null $rpt_invoice
 * @property \Cake\I18n\FrozenTime|null $rpt_invoice_date
 * @property int|null $rpt_tax_invoice
 * @property \Cake\I18n\FrozenTime|null $rpt_tax_invoice_date
 * @property string|null $pph_no
 * @property \Cake\I18n\FrozenDate|null $pph_date
 * @property string|null $pph_jumlah
 * @property \Cake\I18n\FrozenDate|null $ppn_900_date
 * @property string|null $ppn_900_jumlah
 * @property string|null $delivery
 * @property \Cake\I18n\FrozenDate|null $delivery_date
 * @property string|null $delivery_media
 * @property string|null $delivery_up
 * @property string|null $delivery_desc_all
 * @property string|null $delivery_desc
 * @property \Cake\I18n\FrozenDate|null $receive_date
 * @property string|null $receive
 * @property int|null $sign_id
 * @property int|null $director
 * @property string|null $posting
 * @property \Cake\I18n\FrozenDate|null $posting_date
 * @property string|null $who_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $who_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $active
 * @property string|null $status
 * @property string|null $is_log
 * @property string|null $is_create
 * @property string|null $is_update
 * @property string|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string $is_active
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Sign $sign
 * @property \App\Model\Entity\Permit[] $permits
 */
class Invoice extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'parent_id' => true,
        'order_id' => true,
        'customer_id' => true,
        'item_id' => true,
        'receipt_id' => true,
        'tanda_terima_id' => true,
        'code' => true,
        'number_noppn' => true,
        'ppn' => true,
        'tax' => true,
        'proforma_method' => true,
        'proforma_nominal' => true,
        'proforma_ppn' => true,
        'dp_method' => true,
        'dp_nominal' => true,
        'dp_ppn' => true,
        'through' => true,
        'came_from' => true,
        'number_tax_invoice' => true,
        'commission' => true,
        'date' => true,
        'expired' => true,
        'referense_po' => true,
        'grandtotal' => true,
        'transport' => true,
        'transport_quantity' => true,
        'transport_unit' => true,
        'transport_2' => true,
        'transport_quantity_2' => true,
        'transport_unit_2' => true,
        'handling' => true,
        'handling_quantity' => true,
        'handling_unit' => true,
        'discount' => true,
        'discount_price' => true,
        'discount_quantity' => true,
        'discount_unit' => true,
        'biaya_lain' => true,
        'biaya_lain_1' => true,
        'biaya_lain_2' => true,
        'biaya_lain_3' => true,
        'biaya_lain_quantity' => true,
        'biaya_lain_quantity_1' => true,
        'biaya_lain_quantity_2' => true,
        'biaya_lain_quantity_3' => true,
        'biaya_lain_unit' => true,
        'biaya_lain_unit_1' => true,
        'biaya_lain_unit_2' => true,
        'biaya_lain_unit_3' => true,
        'biaya_lain_desc' => true,
        'biaya_lain_desc_1' => true,
        'biaya_lain_desc_2' => true,
        'biaya_lain_desc_3' => true,
        'payment' => true,
        'payment_nominal_1' => true,
        'payment_nominal_2' => true,
        'payment_nominal_3' => true,
        'payment_date' => true,
        'payment_date_1' => true,
        'payment_date_2' => true,
        'payment_date_3' => true,
        'payment_who' => true,
        'payment_jumlah_ori' => true,
        'payment_jumlah' => true,
        'payment_desc' => true,
        'payment_method' => true,
        'payment_method_1' => true,
        'payment_method_2' => true,
        'payment_method_3' => true,
        'payment_bank' => true,
        'payment_bank_va' => true,
        'biaya_bank' => true,
        'biaya_bank_1' => true,
        'biaya_bank_2' => true,
        'biaya_bank_3' => true,
        'pembulatan' => true,
        'pembulatan_1' => true,
        'pembulatan_2' => true,
        'pembulatan_3' => true,   
        'description' => true,
        'komisi_1' => true,
        'komisi_2' => true,
        'komisi_3' => true,
        'komisi_4' => true,
        'komisi_5' => true,
        'rpt_berita_acara' => true,
        'rpt_berita_acara_date' => true,
        'rpt_invoice' => true,
        'rpt_invoice_date' => true,
        'rpt_tax_invoice' => true,
        'rpt_tax_invoice_date' => true,
        'pph_no' => true,
        'pph_no_1' => true,
        'pph_no_2' => true,
        'pph_no_3' => true,
        'pph_date' => true,
        'pph_date_1' => true,
        'pph_date_2' => true,
        'pph_date_3' => true,
        'pph_jumlah' => true,
        'pph_jumlah_1' => true,
        'pph_jumlah_2' => true,
        'pph_jumlah_3' => true,
        'ppn_900_date' => true,
        'ppn_900_date_1' => true,
        'ppn_900_date_2' => true,
        'ppn_900_date_3' => true,
        'ppn_900_jumlah' => true,
        'ppn_900_jumlah_1' => true,
        'ppn_900_jumlah_2' => true,
        'ppn_900_jumlah_3' => true,
        'delivery' => true,
        'delivery_date' => true,
        'delivery_media' => true,
        'delivery_up' => true,
        'delivery_desc_all' => true,
        'delivery_desc' => true,
        'receive_date' => true,
        'receive' => true,
        'sign_id' => true,
        'director' => true,
        'posting' => true,
        'posting_date' => true,
        'who_create' => true,
        'created' => true,
        'who_update' => true,
        'modified' => true,
        'active' => true,
        'status' => true,
        'is_log' => true,
        'is_create' => true,
        'is_update' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
        'order' => true,
        'sign' => true,
        'permits' => true,
    ];
}
