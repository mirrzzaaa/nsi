<?php

declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\I18n\Number; 
use Cake\View\Helper\UrlHelper;

// use Cake\I18n\Date;

class KrsHelper extends Helper
{
    public $helpers = ['Html', 'Paginator', 'Form', 'Url'];

    public $titleManifest = 'TMI';
    public $urlClientMpp = "http://localhost/triatama/mpp";
    public $urlClient8sisi = "http://localhost/triatama/8sisi";
    public $urlClientNjk = "http://localhost/triatama/njk";
    public $urlClientMozaik = "http://localhost/triatama/mozaik";

    //public $urlClientMpp = "https://mpp.triatama.id";
    //public $urlClient8sisi = "https://8sisi.triatama.id";
    //public $urlClientNjk = "https://njk.triatama.id";
    //public $urlClientMozaik = "https://mozaik.triatama.id";


    public function dataNull($desc = null, $type = 'warning') 
    {
        $result = '<tr> 
                    	<td colspan="20">
                        	<div class="note bg-yellow-100">
                                <div class="note-icon"><i class="fas fa-exclamation-circle"></i></div>
                                <div class="note-content">
                                	<h4><b>Maaf... data tidak ditemukan!</b></h4>
                            	    <p>Silakan masukkan data dengan benar...</p>
                                </div>
                            </div>
                        </td>
                    </tr>';
        return $result;
    }


    public function footer()
    {
        $result = 'Nusa Saraya Indonesia; NSI App v.1.0 &copy; 2023&#126;' . date("Y");
        return $result;
    }

    public function validUntil($value = null)
    {
        $data = array("12" => "1 Tahun", "6" => "6 Bulan", "3" => "3 Bulan");
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function type($value = null)
    {
        $data = array("Plastik" => "Plastik", "Wadah Kemasan" => "Wadah Kemasan", "Bahan Makanan" => "Bahan Makanan");
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function typeItem($value = null)
    {
        $data = array("Store" => "Toko", "Warehouse" => "Gudang");
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function btn($type = null, $btnLink = null, $btnId = null, $id = null)
    {
        if ($type == "add") {
            $btnAttribute = ['name' => '<i class="fa fa-plus"></i>', 'color' => 'inverse', 'title' => 'Baru'];
        } elseif ($type == "preview") {
            $btnAttribute = ['name' => '<i class="fa fa-tv"></i>', 'color' => 'yellow', 'title' => 'Tampilkan'];
        } elseif ($type == "edit") {
            $btnAttribute = ['name' => '<i class="fas fa-pencil-alt"></i>', 'color' => 'info', 'title' => 'Ubah'];
        } elseif ($type == "print") {
            $btnAttribute = ['name' => '<i class="fas fa-print"></i>', 'color' => 'lime', 'title' => 'Cetak'];
        } elseif ($type == "edit_admin") {
            $btnAttribute = ['name' => '<i class="fa fa-pencil-alt"></i>', 'color' => 'indigo', 'title' => 'Ubah--'];
        } elseif ($type == "delete") {
            $btnAttribute = ['name' => '<i class="fa fa-trash-alt"></i>', 'color' => 'danger', 'title' => 'Hapus'];
        } elseif ($type == "cancel") {
            $btnAttribute = ['name' => '<i class="fa fa-ban"></i>', 'color' => 'pink', 'title' => 'Batal'];
        } elseif ($type == "download") {
            $btnAttribute = ['name' => '<i class="fa fa-download"></i>', 'color' => 'primary', 'title' => 'Unduh'];
        } elseif ($type == "print") {
            $btnAttribute = ['name' => '<i class="fa fa-print"></i>', 'color' => 'lime', 'title' => 'Cetak'];
        } elseif ($type == "payment") {
            $btnAttribute = ['name' => '<i class="fa fa-dollar-sign"></i>', 'color' => 'purple', 'title' => 'Pembayaran'];
        } elseif ($type == "access") {
            $btnAttribute = ['name' => '<i class="fa fa-sitemap"></i>', 'color' => 'purple', 'title' => 'Hak Akses'];
        } elseif ($type == "resetPassword") {
            $btnAttribute = ['name' => '<i class="fa fa-unlock-alt"></i>', 'color' => 'lime', 'title' => 'Reset Password'];
        } elseif ($type == "editCustome") {
            $btnAttribute = ['name' => '<i class="fa fa-pencil-alt"></i>', 'color' => 'purple', 'title' => 'Ubah'];
        } elseif ($type == "approve") {
            $btnAttribute = ['name' => '<i class="fa fa-check"></i>', 'color' => 'success', 'title' => 'Approve'];
        } elseif ($type == "retur") {
            $btnAttribute = ['name' => '<i class="fa fa-retweet"></i>', 'color' => 'purple', 'title' => 'Retur'];
        }elseif ($type == "delivery") {
            $btnAttribute = ['name' => '<i class="far fa-paper-plane"></i>', 'color' => 'success', 'title' => 'Kirim'];
        }elseif ($type == "child") {
            $btnAttribute = ['name' => '<i class="fas fa-file-invoice"></i>', 'color' => 'indigo', 'title' => 'Performa'];
        }


        if ($type == "delete") {
            $view = $this->Form->postLink($btnAttribute['name'], $btnLink, ['confirm' => __('Apakah anda ingin menghapus data tersebut # {0}?', $btnId), 'class' => 'btn btn-' . $btnAttribute['color'] . ' btn-sm p-l-15 p-r-15', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => $btnAttribute['title'], 'escape' => false, 'fullBase' => true]);
        } elseif ($type == 'preview') {
            $btnLink = "javascript:void(0)";
            $view = $this->Html->link($btnAttribute['name'], $btnLink, ['class' => 'btn btn-' . $btnAttribute['color'] . ' btn-sm btn-preview p-l-15 p-r-15', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => $btnAttribute['title'], 'data-id' => $btnId, 'id' => 'btn-preview' . $btnId, 'escape' => false, 'fullBase' => true]);

            // $view = $this->Html->link($btnAttribute['name'], $btnLink, ['class'=>'btn btn-'.$btnAttribute['color'].' btn-sm btn-preview', 'data-id'=>$btnId, 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>$btnAttribute['title'], 'id'=>'btn-preview'.$btnId, 'escape' => false, 'fullBase'=>true]);
        } else {
            $view = $this->Html->link($btnAttribute['name'], $btnLink, ['class' => 'btn btn-' . $btnAttribute['color'] . ' btn-sm p-l-15 p-r-15', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => $btnAttribute['title'], 'escape' => false, 'fullBase' => true]);
        }

        return $view;
    }

    public function breadcrumb($dataParent = null, $dataChild = null, $dataGrandChild = null, $url = null)
    {
        $view = '<div class="d-flex align-items-center mb-3"><div><ul class="breadcrumb">';
        if (!empty($dataChild)) {
            $view .= (isset($dataParent)) ? '<li class="breadcrumb-item">' . $dataParent . '</li>' : '';
        }
        if (!empty($dataChild)) {
            $view .= (isset($dataChild)) ? '<li class="breadcrumb-item">' . $dataChild . '</li>' : '<li class="breadcrumb-item active">' . $dataChild . '</li>';
        }
        if (!empty($dataGrandChild)) {
            $view .= (isset($dataGrandChild)) ? '<li class="breadcrumb-item active">' . $dataGrandChild . '</li>' : '';
        }
        $view .= '</ul>';
        $view .= '<h1 class="page-header mb-0">' . trim(strip_tags($dataChild)) . '</h1></div>';
        if (!empty($url)) {
            $view .= '<div class="ms-auto"><a href="' . $url . '" class="btn btn-outline-secondary btn-sm"><i class="fa fa-filter fa-lg"></i></a>&nbsp;<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus-square fa-lg"></i></a></div>';
        }
        $view .= '</div>';

        return $view;
    }

    public function breadcrumb_($dataParent = null, $dataChild = null, $dataGrandChild = null)
    {
        $view = '<ol class="breadcrumb float-xl-end">';
        if (!empty($dataChild)) {
            $view .= (isset($dataParent)) ? '<li class="breadcrumb-item">' . $dataParent . '</li>' : '';
        }
        if (!empty($dataChild)) {
            $view .= (isset($dataChild)) ? '<li class="breadcrumb-item">' . $dataChild . '</li>' : '<li class="breadcrumb-item active">' . $dataChild . '</li>';
        }
        if (!empty($dataGrandChild)) {
            $view .= (isset($dataGrandChild)) ? '<li class="breadcrumb-item active">' . $dataGrandChild . '</li>' : '';
        }
        $view .= '</ol>';
        $view .= '<h1 class="page-header">' . trim(strip_tags($dataChild)) . ' <small>kumpulan data . . .</small></h1>';

        return $view;
    }

    public function fTextPlain($dataText)
    {
        $view = '<input type="text" readonly class="form-control-plaintext" value="' . $dataText . '" />';
        return $view;
    }

    public function emptyData($value = '')
    {

        $value = (empty($value)) ? 'Data tidak ditemukan' : $value;
        $result = '<div class="table-responsive">
		<table class="table table-td-valign-middle">
		<tbody>
		<tr style="text-align: center;">
		<td>
		<br>
		<br>
		<i class="fa fa-chalkboard" style="font-size:48px; color: rgb(29, 34, 38, 0.1);"> ' . $value . '</i>
		<br>
		<br>
		</td>
		</tr>
		</tbody>
		</table>
		</div>';
        return $result;
    }
    // Mata Uang
    public  function _currency($value)
    {
        return Number::format($value, ['places' => 0, 'locale' => 'id_ID']);
    }

    public  function truncate($value)
    {
        $view = (!empty($value)) ? substr(str_pad($value, 5), 0, 5) . '...' : "...";
        return $view;
    }

    public function _jenisvendor($value = null)
    {
        $data = array('Pengolahan Limbah' => 'Pengolahan Limbah', 'Transporter' => 'Transporter', 'Sewa' => 'Sewa', 'GPS' => 'GPS', 'Gas' => 'Gas', 'Perawatan dan Pemeliharaan' => 'Perawatan dan Pemeliharaan', 'Lain-lain' => 'Lain-lain');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }


    public function _klasifikasi($value = null)
    {
        $data = array('Industri' => 'Industri', 'Fasyankes' => 'Fasyankes', 'Project' => 'Project');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    // Kemasan
    public function _packing($value = null)
    {
        $data = array('Drum logam (MD)' => 'Drum logam (MD)', 'Drum plastik (FC)' => 'Drum plastik (FC)', 'Jumbo Bag (JB)' => 'Jumbo Bag (JB)', 'Wheel Bin (WB)' => 'MD', 'Jerygan (JC)' => 'Jerygan (JC)',  'Karung Plastik (BA)' => 'Karung Plastik (BA)', 'Kemasan Karton atau plastik (FC)' => 'Kemasan Karton atau plastik (FC)');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function journalTypeCode($value = null)
    {
        $data = array('BKM' => 'C', 'BKK' => 'C', 'Bank Debet' => 'B', 'Bank Credit' => 'B', 'Memorial' => 'M');
        $view = (!empty($value)) ? $data[$value] : $data;
        return $view;
    }

    public function journalTypePrintCashBank()
    {
        $result = array('BKM', 'BKK', 'Bank Debet', 'Bank Credit');
        return $result;
    }

    public function journalTypePrintPosting()
    {
        $result = array('BKM', 'BKK', 'Bank Debet', 'Bank Credit', 'Memorial', 'Beginning Balance', 'Invoice', 'Operational');
        return $result;
    }

    public function journalType($value = null)
    {
        $data = array('BKM' => 'BKM', 'BKK' => 'BKK', 'Bank Debet' => 'Bank Debet', 'Bank Credit' => 'Bank Credit', 'Memorial' => 'Umum', 'Beginning Balance' => 'Saldo Awal', 'Invoice' => 'Invoice', 'Invoice Masuk' => 'Invoice Masuk', 'Operational' => 'Operasional');
        $view = (!empty($value)) ? $data[$value] : $data;
        return $view;
    }

    public function _vendor($value = null)
    {
        $data = array('PT. Gas Alam Solusi' => 'PT. Gas Alam Solusi');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function _operator($value = null)
    {
        $data = array('Agung' => 'Agung', 'Sugito' => 'Sugito');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function _shift($value = null)
    {
        $data = array('1' => 'I (Satu)', '2' => 'II (Dua)', '3' => 'III (Tiga)');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function u_kas($value = null)
    {
        $data = array('Triatama' => 'Triatama', 'Dede' => 'Dede', 'Deasy' => 'Deasy', 'Fina' => 'Fina', 'Mas Ruchi' => 'Mas Ruchi', 'Setyowati' => 'Setyowati', 'Novia' => 'Novia');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    // Incenerator
    public function incenerator($value = null)
    {
        $data = array('1' => 'Incenerator 1', '2' => 'Incenerator 2', '3' => 'Incenerator 3', 'Elektrokoagulasi' => 'Elektrokoagulasi');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function _forto($value = null)
    {
        $data = array('Produksi' => 'Produksi', 'Pengolah' => 'Pengolah');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function _kelompok($value = null)
    {
        $data = array(
            '' => '',
            'Bangunan' => array(
                'Permanen' => 'Permanen (Tarif 5%)',
                'Non-Permanen' => 'Non Permanen (Tarif 10%)',
                'Proses' => 'Dalam Proses (Tarif 0%)',
            ),
            'Non Bangunan' => array(
                '1' => 'Kelompok 1 (Tarif 25%)', '2' => 'Kelompok 2 (Tarif 12,5%)', '3' => 'Kelompok 3 (Tarif 6,25%)', '4' => 'Kelompok 4 (Tarif 5%)'
            )
        );
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function _group($value = null)
    {
        $data = array('Customer' => 'Customer', 'Pengolah' => 'Pengolah', 'Pengangkut' => 'Pengangkut', 'Pengumpul' => 'Pengumpul');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    // Gudang
    public function _warehouse($value = null)
    {
        $data = array('' => '', 'Gudang 1' => 'Gudang 1', 'Gudang 2' => 'Gudang 2', 'Gudang 3' => 'Gudang 3', 'Gudang 4' => 'Gudang 4', 'Gudang 5' => 'Gudang 5');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    // Satuan
    public function _unit($value = null) 
    {
        $data = array('pcs' => 'Pcs', 'kg' => 'Kg', 'liter' => 'Liter', 'botol' => 'Botol', 'galon' => 'Galon', 'karton' => 'Karton', 'gram' => 'Gram', 'pack' => 'Pack', 'bag' => 'Bag', 'box' => 'Box', 'roll' => 'Roll', 'kali' => 'Kali', 'unit' => 'Unit');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    // From
    public function _from($value = null)
    {
        $data = array('Purchasing' => 'Purchasing', 'Warehouse' => 'Warehouse');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    // public function _from($value = null)
    // {
    //     $data = array('Purchasing' => 'Purchasing', 'Warehouse' => 'Gudang', 'Store' => 'Toko');
    //     $result = ($value) ? $data[$value] : $data;
    //     return $result;
    // }

    // From
    public function _to($value = null)
    {
        $data = array('Warehouse' => 'Gudang', 'Store' => 'Toko');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function _toEdit($value = null)
    {
        $data = array('Warehouse' => 'Gudang', 'Store' => 'Toko', 'Order' => 'Pengiriman');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function _tax($value = null)
    {
        $data = array('0' => 'No Tax', '1' => '(12%) Tax');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    /*public function _devision()
	{
		$view = array('KEU' => 'Accounting', 'WWH' => 'Gudang', 'HSE' => 'HSE');
		return $view;
	}*/

    // Jabatan
    public function position($data = null)
    {
        $view = array('Driver' => 'Driver', 'Operator' => 'Operator', 'Staff' => 'Staff', 'Supervisor' => 'Supervisor', 'Manajer' => 'Manajer', 'Direktur' => 'Direktur');
        $result = (empty($data)) ? $view : $view[$data];

        return $result;
    }

    // Devisi
    public function devision($data = null)
    {
        $view = array('Cashier' => 'Cashier', 'Admin' => 'Admin', 'Warehouse' => 'Warehouse', 'Marketing' => 'Marketing', 'Manager' => 'Manager', 'Directur' => 'Directur', 'HRD' => 'HRD');

        if (empty($data)) {
            $result = $view;
        } else {
            $dataGets = explode(',', $data);
            $resultData = array();
            foreach ($dataGets as $dataGet) {
                $resultData[] = $view[$dataGet];
            }
            $result = implode(', ', $resultData);
        }

        return $result;
    }

    public function _staff($data = null)
    {
        $view = array('Admin' => 'Admin', 'Marketing' => 'Marketing', 'Motoris' => 'Motoris', 'Finance' => 'Finance', 'Gudang' => 'Gudang', 'Cashier' => 'Cashier');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function typePca($value = null)
    {
        $data = array('ATK' => 'ATK', 'BEVERAGE' => 'BEVERAGE', 'CASH PURCHASE' => 'CASH PURCHASE', 'OPERATIONAL' => 'OPERATIONAL', 'TRANSPORT' => 'TRANSPORT');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function nom2Dec($number)
    {
        if (empty($number)) {
            $number = 0;
        } else {
            $number = str_replace(".", "", $number);
            $number = str_replace(",", ".", $number);
        }
        return $number;
    }

    public function nom($value = null)
    {
        $values = (empty($value)) ? 0 : $value;
        $view = ($values == 0) ? 0 : number_format((float)$values, 2, ',', '.');
        return $view;
    }


    public function cur($value = null)
    {
        $values = (empty($value)) ? 0 : $value;
        if ($values < 0) {
            $result = str_replace('-', '', $values);
            $view = '(' . number_format((float)$result, 2, ',', '.') . ')';
        } elseif ($values == 0) {
            $view = 0;
        } else {
            // pr(number_format((float)$values, 2, '.', ','));
            $view = number_format((float)$values, 2, ',', '.');
        }

        // $values = (!empty($value)) ? number_format($value, 2, '.', ',') : '';
        return $view;
    }

    public function percent($data = null)
    {
        $result = (empty($data)) ? 0 : str_replace(",000", "", (string)number_format($data, 3, ",", ""));

        return $result;
    }

    public function paginators()
    {
        $view = '<div class="d-md-flex align-items-center"><div class="me-md-auto text-md-left mb-2 mb-md-0">';
        $view .= $this->Paginator->counter('Halaman {{page}} sampai {{pages}}, mulai baris ke {{start}} sampai dengan baris ke {{end}} <br />Menampilkan {{current}} baris dengan jumlah total {{count}} baris');
        $view .= '</div>';
        $view .= '<ul class="pagination mb-0 justify-content-center">';
        $view .= $this->Paginator->first('&laquo;', ['escape' => false]);
        $view .= $this->Paginator->numbers(['first' => 0, 'last' => 0, 'ellipsis' => '<li><a class="page-link">...</a></li>', 'separator' => false, 'tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active', 'modulus' => 4, 'class' => 'page-item']);
        $view .= $this->Paginator->last('&raquo;', ['escape' => false]);
        $view .= '</ul></div>';

        return $view;
    }

    public function paginator($count = null, $prev = null, $number = null, $next = null)
    {
        return
            '<div class="d-md-flex align-items-center">
            <div class="me-md-auto text-md-left text-center mb-2 mb-md-0">
               ' . $count . '
            </div>
            <ul class="pagination mb-0 justify-content-center">
            ' . $prev . '' . $number . '' . $next . '
            </ul>
        </div>';
    }

    public function generateRandomString($length = 10)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function numToRome($month)
    {
        $hasil = "";

        $iromawi = array(
            "", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", 20 => "XX", 30 => "XXX", 40 => "XL", 50 => "L",
            60 => "LX", 70 => "LXX", 80 => "LXXX", 90 => "XC", 100 => "C", 200 => "CC", 300 => "CCC", 400 => "CD", 500 => "D", 600 => "DC", 700 => "DCC",
            800 => "DCCC", 900 => "CM", 1000 => "M", 2000 => "MM", 3000 => "MMM"
        );
        if (array_key_exists($month, $iromawi)) {
            $hasil = $iromawi[$month];
        } elseif ($month >= 11 && $month <= 99) {
            $i = $month % 10;
            $hasil = $iromawi[$month - $i] . $this->numToRome($month % 10);
        } elseif ($month >= 101 && $month <= 999) {
            $i = $month % 100;
            $hasil = $iromawi[$month - $i] . $this->numToRome($month % 100);
        } else {
            $i = $month % 1000;
            $hasil = $iromawi[$month - $i] . $this->numToRome($month % 1000);
        }
        return $hasil;
    }

    public function selectCOAType($data = null)
    {
        $view = array('kas_bank' => 'Kas/Bank', 'akun_piutang' => 'Akun Piutang', 'piutang_usaha' => 'Piutang Usaha', 'persediaan' => 'Persediaan', 'aktiva_lancar_lainnya' => 'Aktiva Lancar Lainnya', 'aktiva_tetap' => 'Aktiva Tetap', 'akumulasi_penyusutan' => 'Akumulasi Penyusutan', 'aktiva_lainnya' => 'Aktiva Lainnya', 'akun_hutang' => 'Akun Hutang', 'hutang_lancar_lainnya' => 'Hutang Lancar Lainnya', 'hutang_jangka_panjang' => 'Hutang Jangka Panjang', 'ekuitas' => 'Ekuitas', 'pendapatan' => 'Pendapatan', 'harga_pokok_penjualan' => 'Harga Pokok Penjualan', 'beban' => 'Beban', 'beban_pemasaran' => 'Beban Pemasaran', 'beban_lain_lain' => 'Beban Lain-Lain', 'potongan_penjualan' => 'Potongan Penjualan', 'pendapatan_lain' => 'Pendapatan Lain', 'saldo_ditahan' => 'Saldo Ditahan', 'modal' => 'Modal', 'pajak' => 'Pajak', 'prive' => 'Prive');
        $result = (!empty($data)) ? $view[$data] : $view;
        return $result;
    }

    public function projectStatus($data = null)
    {
        $view = array("Triata" => "Triata", "Artama" => "Artama", "NSI" => "NSI", "MAA" => "MAA", "GNJ" => "GNJ", "Mozaik" => "Mozaik", "Saraya" => "Saraya", "Ekata" => "Ekata", "MPP" => "MPP", "8Sisi" => "8Sisi", "NJK" => "NJK", "Lain" => "Lain-lain");
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function klasifikasi($data = null)
    {
        $view = array("Industri" => "Industri", "Fasyankes" => "Fasyankes", "Project" => "Project");
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function responsiblePayment($data = null)
    {
        $view = array("Driver ke Kasir" => "Driver ke Kasir", "Kasir ke Driver" => "Kasir ke Driver");
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function brandClass($data = null)
    {
        $view = array("TMI" => "Triata", "ARSI" => "Artama", "NSI" => "Nusa", "MAA" => "MAA", "GNJ" => "GNJ");
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function i_t($data = null)
    {
        $view = array("" => "", "Achmad Junaidi" => "Achmad Junaidi", "Asri Hikmatullaili" => "Asri Hikmatullaili", "Ahmad Sandy Febrian P" => "Ahmad Sandy Febrian P");
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function paymentStatus($data = null)
    {
        $view = array("" => "Semua", "N" => "Belum Terbayar", "Y" => "Sudah Terbayar", "NP" => "Kurang Bayar");
        //$view = array('Wait'=>'Menunggu', 'Yes' => 'Diproses', 'Cancel'=>'Batal');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function titleCustomer($data = null)
    {
        $view = array(' ' => 'Tanpa title', 'PT' => 'PT', 'CV' => 'CV', 'UD' => 'UD', 'DLH' => 'DLH', 'PMI' => 'PMI', 'BIDAN' => 'BIDAN', 'RSUD' => 'RSUD', 'RS' => 'RS', 'RSI' => 'RSI', 'RSIA' => 'RSIA', 'RSAD' => 'RSAD', 'RSAL' => 'RSAL', 'RSAU' => 'RSAU', 'RSB' => 'RSB', 'RSGM' => 'RSGM', 'RSJ' => 'RSJ', 'RSK' => 'RSK', 'RSKB' => 'RSKB', 'RSKM' => 'RSKM', 'RSM' => 'RSM', 'RSNU' => 'RSNU', 'RSPM' => 'RSPM', 'RSUH' => 'RSUH', 'RSUI' => 'RSUI', 'RSUM' => 'RSUM', 'RSUP' => 'RSUP', 'PRAKTEK DRG' => 'PRAKTEK DRG', 'PRAKTEK DR' => 'PRAKTEK DR', 'POLIKLINIK' => 'POLIKLINIK', 'LABORATURIUM' => 'LABORATURIUM', 'PKM' => 'PKM', 'PG' => 'PG', 'KLINIK' => 'KLINIK', 'HOTEL' => 'HOTEL', 'DR' => 'DR', 'RSUD' => 'RSUD', 'RSU' => 'RSU', 'UPT' => 'UPT', 'UPTD' => 'UPTD', 'PLTU' => 'PLTU', 'PLTA' => 'PLTA', 'UTD' => 'UTD', 'PUSKESMAS' => 'PUSKESMAS', 'YAYASAN' => 'YAYASAN');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function descLeaves($data = null)
    {
        $view = array('Pernikahan' => 'Pernikahan (3 hari)', 'Baptis Khitan' => 'Baptis/Khitan anak (2 hari)', 'Meninggal' => 'Orang tua/anak/istri/suami/mertua meninggal (2 hari)', 'Anggota lain meninggal' => 'Anggota keluarga lainnya yang serumah meninggal (1 hari)', 'Pernikahan Anak' => 'Pernikahan anak (2 hari)', 'Istri Melahirkan Keguguran' => 'Istri melahirkan/keguguran (2 hari)', 'Lain Lain' => 'Lain-lain');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function methodPayment($value = null)
    {
        $data = array('Cash' => 'Cash', 'Pajak' => 'Pajak', 'BCA' => 'BCA', 'BSM' => 'BSM', 'Bank Jatim' => 'Bank Jatim', 'Mandiri' => 'Mandiri', 'Bank Mandiri' => 'Bank Mandiri', 'Bank Mandiri Artama' => 'Bank Mandiri Artama', 'Muamalat - Artama' => 'Muamalah - Artama', 'Permata - GNJ' => 'Permata - GNJ', 'Permata - TMI' => 'Permata - TMI', 'Permata Syariah - Artama' => 'Permata Syariah - Artama', 'Permata Syariah - TMI' => 'Permata Syariah - TMI', 'Permata - Nusa Saraya' => 'Permata - Nusa Saraya', 'BTPN - Triata' => 'BTPN - Triata', 'BNI Syariah - Triata' => 'BNI Syariah - Triata', 'BNI Syariah - Artama' => 'BNI Syariah - Artama', 'Bank Jatim Syariah' => 'Bank Jatim Syariah', 'BSI - Triata' => 'BSI - Triata', 'BSI - Artama' => 'BSI - Artama', 'BCA Madu Mozaik' => 'BCA Madu Mozaik', 'BSI Mozaik' => 'BSI Mozaik', 'BSI - MPP' => 'BSI - MPP', 'BSI - NJK' => 'BSI - NJK', 'Permata - 8sisi' => 'Permata - 8sisi', 'Marketing' => 'Marketing', 'Mas Ruchi' => 'Mas Ruchi');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function typeWaste($data = null)
    {
        $view = array('LM' => 'Limbah Medis', 'LC' => 'Limbah Curah', 'LU' => 'Limbah Umum', 'PR' => 'Project');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    // Kategori Limbah
    public function _procCategory($value = null)
    {
        $data = array('Pemanfaat' => 'Pemanfaat', 'Pengolah' => 'Pengolah', 'Pengumpul' => 'Pengumpul');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function statusWait($data = null)
    {
        $view = array('Wait' => 'Diproses', 'Yes' => 'Terkirim', 'Cancel' => 'Batal');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function fPayment($data = null)
    {
        $view = array('Y' => 'Lunas', 'N' => 'Blm Dibayar', 'NP' => 'Kurang Bayar');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }


    public function _status($data = null)
    {
        $view = array(1 => 'Aktif', 0 => 'Non-aktif');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function statusInvoices($data = null)
    {
        $view = array('Y' => 'Lunas', 'N' => 'Belum Bayar', 'NP' => 'Kurang Bayar');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function _ppn($data = null)
    {
        $view = array(1 => 'Pajak ', 0 => 'No Pajak');
        $result = (empty($data)) ? $view : $view[data];
        return $result;
    }

    public function is_active($data = null)
    {
        $view = array('Y' => 'Aktif', 'N' => 'Non-aktif');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }


    public function tax($data = null)
    {
        $view = array('y' => 'Menggunakan', 'n' => 'Tidak Menggunakan');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

 
    public function invoiceDelivery($data = null)
    {
        $view = array('Semua' => 'Semua', 'Terkirim' => 'Terkirim', 'Belum Terkirim' => 'Belum Terkirim');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }


    public function inputDateRange($nameFrom, $arrayFrom = array(), $nameTo, $arrayTo = array(), $separator, $reset)
    {
        $input = '<div class="input-group input-daterange">';
        $input .= $this->Form->input($nameFrom, $arrayFrom);
        $input .= '<div class="input-group-prepend">';
        $input .=   '<span class="input-group-text">' . $separator . '</span>';
        $input .= '</div>';
        $input .= $this->Form->input($nameTo, $arrayTo);
        $input .= '<div class="input-group-append">';
        $input .= '<button class="btn btn-inverse ' . $reset . '" type="button"><i class="fa fa-times"></i></button>';
        $input .= '</div></div>';

        return $input;
    }

    public function fDate($value = null, $format = '')
    {
        // $dateCreate = date_create($value);
        $result = (empty($value) && empty($format)) ? '' : date_format($value, $format);
        return $result;
    }


    public function fEncode($data)
    {
        return $this->base64_encode(serialize($data));
    }

    public function fDecode($data)
    {
        return unserialize($this->base64_decode($data));
    }

    public function base64_encode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_~');
    }

    public function base64_decode($input)
    {
        return base64_decode(strtr($input, '-_~', '+/='));
    }

    public function dateIndo($date, $showAll = true)
    {
        $split = explode("-", $date);
        $date = $split[2];
        $month = $this->getMonth($split[1]);
        $year = $split[0];

        if ($showAll == true) {
            $result = $date . ' ' . $month . ' ' . $year;
        } else {
            $result = $month . ' ' . $year;
        }

        return $result;
    }

    public function getMonth($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;

            case 2:
                return "Februari";
                break;

            case 3:
                return "Maret";
                break;

            case 4:
                return "April";
                break;

            case 5:
                return "Mei";
                break;

            case 6:
                return "Juni";
                break;

            case 7:
                return "Juli";
                break;

            case 8:
                return "Agustus";
                break;

            case 9:
                return "September";
                break;

            case 10:
                return "Oktober";
                break;

            case 11:
                return "November";
                break;

            case 12:
                return "Desember";
                break;
        }
    }

    public function incomeMultiPercentNew($data = null, $dataMonth = null, $name = null)
    {
        list($monthFrom, $monthEnd) = explode('^', $dataMonth);

        $dataCOALevel5Value = array();
        foreach ($data as $idLevel4 => $detail) {
            if (isset($detail['Level5Name']) && $detail['Level5Name']) {
                $level5Name = array_unique($detail['Level5Name']);

                $a = 0;
                foreach ($level5Name as $dataLevelCOA) {
                    if (isset($dataLevelCOA)) {
                        list($idDetail, $codeDetail, $nameDetail) = explode('^', $dataLevelCOA);

                        for ($i = $monthFrom; $i <= $monthEnd; $i++) {
                            $monthData = str_pad(strval($i), 2, '0', STR_PAD_LEFT);

                            if ((isset($detail['Level5'][$monthData][$idDetail]))) {
                                $dataCOALevel5Values = $detail['Level5'][$monthData][$idDetail];
                                list($code, $debetCredit, $beginningBalance, $total) = explode('^', $dataCOALevel5Values);
                                $dataCOALevel5Value[$monthData][$code] = $debetCredit;
                            } else {
                                $dataCOALevel5Value[$monthData][] = 0;
                            }
                        }
                        $a++;
                    }
                }
            }
        }
        for ($zz = $monthFrom; $zz <= $monthEnd; $zz++) {
            $monthData = str_pad(strval($zz), 2, '0', STR_PAD_LEFT);
            $dataCOATotalValue[$monthData][$name] = (isset($dataCOALevel5Value[$monthData])) ? array_sum($dataCOALevel5Value[$monthData]) : 0;
        }
        return $dataCOATotalValue;
    }

    function totalCOADetail($listCOA = null)
    {
        if (isset($listCOA)) {
            $totalDetails = array();
            foreach ($listCOA as $total) {
                if (isset($total['Level5']) && $total['Level5']) {
                    foreach ($total['Level5'] as $dataCOA) {
                        list($codeTotalDetail, $nameTotalDetail, $debetCreditTotalDetail, $beginningBalanceTotalDetail) = explode('^', $dataCOA);
                        $totalDetails[] = ((int)$debetCreditTotalDetail + (int)$beginningBalanceTotalDetail);
                    }
                }
            }
        }

        return $totalDetails;
    }

    function totalCOADetailBefore($listCOA = null)
    {
        if (isset($listCOA)) {
            $totalDetails = array();
            foreach ($listCOA as $total) {
                if (isset($total['Level5']) && $total['Level5']) {
                    $debetCreditDetailBefore = array();
                    foreach ($total['Level5'] as $dataCOA) {
                        list($codeTotalDetail, $nameTotalDetail, $debetCreditTotalDetail, $beginningBalanceTotalDetail, $subTotalDetailBefore) = explode('^', $dataCOA);
                        $debetCreditDetailBefore[] = $subTotalDetailBefore;
                    }
                }

                if (isset($total['Level5']) && $total['Level4']) {
                    list($codeBefore, $nameBeforePrive) = explode('^', $total['Level4']);

                    if (!empty($codeBefore)) {
                        $totalLevel4Before = array_sum($debetCreditDetailBefore);
                        $totalDetails[] = $totalLevel4Before;
                    }
                }
            }
        }

        return $totalDetails;
    }

    public function balanceSheetPercent($data = null, $listCOABalanceSheet = null, $condDC = null, $flip = false)
    {

        //list($monthFrom, $monthEnd) = explode('^', $dataMonth);

        $dataPercentBalanceSheet = array();
        if (!empty($listCOABalanceSheet)) {
            $dataBalanceSheet = $this->balanceSheetData($data, $listCOABalanceSheet, $condDC);

            foreach ($dataBalanceSheet as $idBalanceSheet => $detailBalanceSheet) {
                /*if(!empty($detailBalanceSheet['COA'])) {
					foreach ($detailBalanceSheet['COA'] as $idCOABalanceSheet => $dataCOABalanceSheet) {
						list($idDataCOABalanceSheet, $nameDataCOABalanceSheet) = explode('^', $dataCOABalanceSheet);
							//for ($a=$monthFrom; $a <= $monthEnd; $a++) {
							//	$monthDataBalanceSheet = str_pad($a, 2, '0', STR_PAD_LEFT);
						if(isset($detailBalanceSheet['data'][$idCOABalanceSheet])) {
							list($codeDetailBalanceSheet, $valueDetailBalanceSheet) = explode('^', $detailBalanceSheet['data'][$idCOABalanceSheet]);
							list($codeTotalBalanceSheet, $valueTotalBalanceSheet) = explode('^', $detailBalanceSheet['data']['Total']);

							$percenBalanceSheet = $valueDetailBalanceSheet/$valueTotalBalanceSheet*100;
						} else {
							$codeDetailBalanceSheet = "";
							$valueDetailBalanceSheet = 0;
						}
							//}
					}
				}*/


                if (!empty($detailBalanceSheet['COA']) && $detailBalanceSheet['level4']) {
                    //for ($b=$monthFrom; $b <= $monthEnd; $b++) {
                    //	$monthTotalData = str_pad($b, 2, '0', STR_PAD_LEFT);

                    if (isset($detailBalanceSheet['data']['Total'])) {
                        list($codeGrandTotalBalanceSheet, $valueGrandTotalBalanceSheet) = explode('^', $detailBalanceSheet['data']['Total']);
                    } else {
                        $codeGrandTotalBalanceSheet = "";
                        $valueGrandTotalBalanceSheet = 0;
                    }

                    $dataPercentBalanceSheet[$idBalanceSheet] = ($flip == true) ? $this->flipTheValue($valueGrandTotalBalanceSheet) : $valueGrandTotalBalanceSheet;
                    //}
                }
            }
        }
        return $dataPercentBalanceSheet;
    }


    public function balanceSheetData($data = null, $listCOAIncomeMulti = null, $condDC = null)
    {
        //list($monthFrom, $monthEnd) = explode('^', $dataMonth);

        // for ($monthDataz=$monthFrom; $monthDataz <= $monthEnd; $monthDataz++) {
        // 	$monthData = str_pad($monthDataz, 2, '0', STR_PAD_LEFT);
        // 	$dataJournal = $data[$monthData];

        // 	// Mengambil data hanya sesuai dengan filter.
        // 	$dataJournalCOA[$monthData] = Set::classicExtract($dataJournal, '{n}.AccJournal.{coaId|totalDebet|totalCredit}');
        // }
        $dataJournal = $data;
        $dataJournalCOA = Hash::combine($dataJournal, ['%s|%s|%s', '{n}.coaId', '{n}.totalDebet', '{n}.totalCredit']);

        // $dataJournalCOA = Set::classicExtract($dataJournal, '{n}.AccJournal.{coaId|totalDebet|totalCredit}');

        $dataIncomeMulti = array();
        foreach ($listCOAIncomeMulti as $keyParentIncomeMulti => $valueIncomeMulti) {
            if ($valueIncomeMulti['level4']) {
                list($statusLvl4IncomeMulti, $idLvl4IncomeMulti, $codeLvl4IncomeMulti, $nameLvl4IncomeMulti, $beginningBalanceLvl4IncomeMulti, $idParentLvl4IncomeMulti) = explode('^', $valueIncomeMulti['level4']);

                $dataIncomeMulti[$keyParentIncomeMulti]['level4'] = $nameLvl4IncomeMulti;
            }

            if ($valueIncomeMulti['level5']) {
                $resultIncomeMultis = array();
                //$resultBeginningBalances = array();
                foreach ($valueIncomeMulti['level5'] as $valueLvl5) {
                    list($statusLvl5IncomeMulti, $idLvl5IncomeMulti, $codeLvl5IncomeMulti, $nameLvl5IncomeMulti, $beginningBalanceLvl5IncomeMulti, $idParentLvl5IncomeMulti) = explode('^', $valueLvl5);

                    //for ($i=$monthFrom; $i <= $monthEnd; $i++) {
                    //	$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $resultIncomeMulti = $this->sumDataJournalBalance($dataJournalCOA, $idLvl5IncomeMulti, $condDC, $beginningBalanceLvl5IncomeMulti);
                    //$resultIncomeMulti = $this->sumDataJournalOrdinary($dataJournalCOA, $idLvl5IncomeMulti, $condDC, $beginningBalanceLvl5IncomeMulti);
                    //pr($dataJournalCOA);

                    //pr($nameLvl5IncomeMulti.' = '.$resultIncomeMulti.' - '.$beginningBalanceLvl5IncomeMulti);

                    if ($resultIncomeMulti <> 0 || $beginningBalanceLvl5IncomeMulti <> 0) {
                        //$totalIncomeMulti = $resultIncomeMulti+$beginningBalanceLvl5IncomeMulti;
                        //$totalIncomeMulti = $beginningBalanceLvl5IncomeMulti+round($resultIncomeMulti,2);
                        $totalIncomeMulti = $resultIncomeMulti;

                        $resultIncomeMultis[$keyParentIncomeMulti][] = $totalIncomeMulti;
                        //$resultIncomeMultis[$keyParentIncomeMulti][] = $resultIncomeMulti;
                        //$resultBeginningBalances[$keyParentIncomeMulti][] = $beginningBalanceLvl5IncomeMulti;
                        $dataIncomeMulti[$keyParentIncomeMulti]['Beginingbalance'][$idLvl5IncomeMulti] = $beginningBalanceLvl5IncomeMulti;


                        $dataIncomeMulti[$keyParentIncomeMulti]['COA'][$idLvl5IncomeMulti] = $idLvl5IncomeMulti . '^(' . $codeLvl5IncomeMulti . ') ' . $nameLvl5IncomeMulti;

                        $dataIncomeMulti[$keyParentIncomeMulti]['data'][$idLvl5IncomeMulti] = $codeLvl5IncomeMulti . ' ' . $nameLvl5IncomeMulti . '^' . $totalIncomeMulti;
                        //$dataIncomeMulti[$keyParentIncomeMulti]['data'][$idLvl5IncomeMulti] = $codeLvl5IncomeMulti.' '.$nameLvl5IncomeMulti.'^'.$resultIncomeMulti.'^'.$beginningBalanceLvl5IncomeMulti;
                    }

                    //}
                }
            }

            if ($valueIncomeMulti['total']) {
                list($statusTotalIncomeMulti, $idTotalIncomeMulti, $codeTotalIncomeMulti, $nameTotalIncomeMulti, $beginningBalanceTotalIncomeMulti, $idParentTotalIncomeMulti) = explode('^', $valueIncomeMulti['total']);

                //for ($i=$monthFrom; $i <= $monthEnd; $i++) {
                //	$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);
                //pr($resultBeginningBalances);

                $resultTotalIncomeMulti = (empty($resultIncomeMultis[$keyParentIncomeMulti])) ? 0 : array_sum($resultIncomeMultis[$keyParentIncomeMulti]);

                if ($resultTotalIncomeMulti <> 0) {
                    $dataIncomeMulti[$keyParentIncomeMulti]['data']['Total'] = $nameTotalIncomeMulti . '^' . $resultTotalIncomeMulti;
                    //$dataIncomeMulti[$keyParentIncomeMulti]['data']['Total'] = $nameTotalIncomeMulti.'^'.$resultTotalIncomeMulti.'^'.$beginningBalanceTotalIncomeMulti;
                }
                //}
            }
        }

        return $dataIncomeMulti;
    }

    public function sumDataJournalBalance($data = '', $value = '', $dk = '', $balance = '')
    {
        // Membuat array dari value
        $arrayValue = explode(',', $value);
        $countArrayValue = count($arrayValue);

        //pr($value);

        $resultDebet = array();
        $resultCredit = array();
        if ($data) {
            foreach ($data as $values) {
                // Mengambil value hanya 1
                if ($countArrayValue == 1) {
                    if ($value == $values['coaId']) {
                        $resultDebet[] = $values['totalDebet'];
                        $resultCredit[] = $values['totalCredit'];
                    }
                } else {
                    // Mengambil banyaknya value
                    foreach ($arrayValue as $keys) {
                        if ($keys == $values['coaId']) {
                            $resultDebet[] = $values['totalDebet'];
                            $resultCredit[] = $values['totalCredit'];
                        }
                    }
                }
            }
        } else {
            $resultDebet[] = 0;
            $resultCredit[] = 0;
        }

        $totalDebet = round(array_sum($resultDebet), 2);
        $totalCredit = round(array_sum($resultCredit), 2);
        //pr($value.' : '.$totalDebet.' = '.$totalCredit);

        if ($dk == 'debet') {
            $resultTotal = ((int)$balance + (int)$totalDebet);
        } elseif ($dk == 'credit') {
            $resultTotal = ((int)$balance + (int)$totalCredit);
        } elseif ($dk == 'creditMinusdebet') {
            $resultTotal = ((int)$balance + (int)$totalCredit - (int)$totalDebet);
        } elseif ($dk == 'debetMinuscredit') {
            $resultTotal = ((int)$balance + (int)$totalDebet - (int)$totalCredit);
        } else {
            $resultTotal = ((int)$balance + (int)$totalDebet - (int)$totalCredit);
        }

        return $resultTotal;
    }

    public function flipTheValue($value = '')
    {
        if ($value < 0) {
            $result = abs($value);
        } elseif ($value > 0) {
            $result = 0 - $value;
        } else {
            $result = 0 - $value;
        }
        //$result = $value;

        return $result;
    }

    public function addButton($options = [])
    {
        $icon = $this->Html->tag('i', '', ['class' => 'fa fa-square-plus']);

        // Mengambil action dari parameter options atau menggunakan default 'add'
        $action = isset($options['action']) ? $options['action'] : 'add';

        // Menggunakan HtmlHelper untuk membuat tag <button> dengan ikon dan atribut lainnya
        $button = $this->Html->tag('button', $icon, [
            'type' => 'button',
            'class' => 'btn btn-inverse',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => 'Add',
            'escape' => false,
        ]);

        // Membungkus tombol dalam link menuju action yang ditentukan
        $link = $this->Html->link($button, ['action' => $action], [
            'escape' => false, // Menonaktifkan escape untuk konten HTML di dalam link 
        ]);

        return $link;
    }

    public function downloadButton($options = [])
    {
        $icon = $this->Html->tag('i', '', ['class' => 'fa fa-download']);

        // Mengambil action dari parameter options atau menggunakan default 'excel'
        $action = isset($options['action']) ? $options['action'] : 'excel';

        // Menggunakan HtmlHelper untuk membuat tag <button> dengan ikon dan atribut lainnya
        $button = $this->Html->tag('button', $icon, [
            'type' => 'button',
            'class' => 'btn btn-green',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => 'Download Excel',
            'escape' => false,
        ]);

        // Membungkus tombol dalam link menuju action yang ditentukan
        $link = $this->Html->link($button, ['action' => $action], [
            'escape' => false, // Menonaktifkan escape untuk konten HTML di dalam link
        ]);

        return $link;
    }

    public function searchButton($value = null)
    {
        $icon = $this->Html->tag('i', '', ['class' => 'fa fa-search']);
        $view = $this->Html->tag('button', $icon, [
            'type' => 'submit',
            'class' => 'btn btn-yellow btn-block',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => 'Cari',
            'escapeTitle' => false, 
        ]);

        return $view;
    }

    public function printButton($options = [])
    {
        // Ambil ikon dari opsi atau gunakan ikon default
        $icon = $this->Html->tag('i', '', ['class' => 'fa fa-print']);

        // Ambil action dari parameter options atau gunakan default 'print'
        $action = isset($options['action']) ? $options['action'] : 'print';

        // Buat tag <button> dengan ikon dan atribut lainnya
        $button = $this->Html->tag('button', $icon, [
            'type' => 'button',
            'class' => 'btn btn-lime btn-sm p-l-15 p-r-15',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => 'Cetak (header footer)',
            'escape' => false, // Jangan escape HTML di dalam button
        ]);

        // Bungkus tombol dalam link menuju action yang ditentukan
        $link = $this->Html->link($button, ['action' => $action], [
            'escape' => false, // Jangan escape HTML di dalam link
            'target' => '_blank', // Membuka link di tab baru jika diperlukan
        ]);

        return $link;
    }

    public function printOutButton($options = [])
    {
        // Ambil ikon dari opsi atau gunakan ikon default
        $icon = $this->Html->tag('i', '', ['class' => 'fa fa-print']);

        // Ambil action dari parameter options atau gunakan default 'print'
        $action = isset($options['action']) ? $options['action'] : 'printOut';

        // Buat tag <button> dengan ikon dan atribut lainnya
        $button = $this->Html->tag('button', $icon, [
            'type' => 'button',
            'class' => 'btn btn-orange btn-sm p-l-15 p-r-15',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => 'Cetak (tanpa header footer)',
            'escape' => false, // Jangan escape HTML di dalam button
        ]);

        // Bungkus tombol dalam link menuju action yang ditentukan
        $link = $this->Html->link($button, ['action' => $action], [
            'escape' => false, // Jangan escape HTML di dalam link
            'target' => '_blank', // Membuka link di tab baru jika diperlukan
        ]);

        return $link;
    }

    public function payment_type($value = null)
    {
        $data = array('Normal' => 'Normal', 'Termin' => 'Termin');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function terbilang($number) {
        $number = abs($number);
        $words = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $result = "";

        if ($number < 12) {
            $result = " " . $words[$number];
        } elseif ($number < 20) {
            $result = $this->terbilang($number - 10) . " belas";
        } elseif ($number < 100) {
            $result = $this->terbilang($number / 10) . " puluh" . $this->terbilang($number % 10);
        } elseif ($number < 200) {
            $result = " seratus" . $this->terbilang($number - 100);
        } elseif ($number < 1000) {
            $result = $this->terbilang($number / 100) . " ratus" . $this->terbilang($number % 100);
        } elseif ($number < 2000) {
            $result = " seribu" . $this->terbilang($number - 1000);
        } elseif ($number < 1000000) {
            $result = $this->terbilang($number / 1000) . " ribu" . $this->terbilang($number % 1000);
        } elseif ($number < 1000000000) {
            $result = $this->terbilang($number / 1000000) . " juta" . $this->terbilang($number % 1000000);
        } elseif ($number < 1000000000000) {
            $result = $this->terbilang($number / 1000000000) . " milyar" . $this->terbilang(fmod($number, 1000000000));
        } elseif ($number < 1000000000000000) {
            $result = $this->terbilang($number / 1000000000000) . " triliun" . $this->terbilang(fmod($number, 1000000000000));
        }

        return $result;
    }

    // Area
    public function area($value = null) 
    {
        $data = array('Jatim 1' => 'Jatim 1', 'Jatim 2' => 'Jatim 2', 'Jatim 3' => 'Jatim 3', 'Bali' => 'Bali');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function fDates($date, $format = 'd F Y')
    {
        if (empty($date)) {
            return '-';
        }

        // Ubah tanggal ke format yang diminta
        $tanggal = date($format, strtotime($date));

        // Array bulan dalam bahasa Indonesia
        $bulanIndo = array(
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        );

        // Ganti nama bulan dari bahasa Inggris ke bahasa Indonesia
        foreach ($bulanIndo as $en => $id) {
            $tanggal = str_replace($en, $id, $tanggal);
        }

        return $tanggal;
    }

    public function metodePembayaran($value = null)
    {
        $data = array('DP' => 'DP', 'Termin' => 'Termin');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function _fDate($date, $format = 'd F Y')
    {
        if (empty($date)) {
            return '-';
        }

        // Konversi objek ke string jika diperlukan
        if (is_object($date)) {
            $date = $date->format('Y-m-d');
        }

        // Ubah tanggal ke format yang diminta
        $tanggal = date($format, strtotime($date));

        // Array bulan dalam bahasa Indonesia
        $bulanIndo = array(
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        );

        // Ganti nama bulan dari bahasa Inggris ke bahasa Indonesia
        foreach ($bulanIndo as $en => $id) {
            $tanggal = str_replace($en, $id, $tanggal);
        }

        return $tanggal;
    }


}
