<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry; //Memanggil table model
use Cake\I18n\Number;

class KrsComponent extends Component
{

    public function typeItem($value = null)
    {
        $data = array("Store" => "Toko", "Warehouse" => "Gudang");
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    // Add your code to override the core AuthComponent
    public function _unit($value = null)
    {
        $data = array('pcs' => 'Pcs', 'ton' => 'Ton', 'drum' => 'Drum', 'm3' => 'M3', 'kg' => 'Kg', 'liter' => 'Liter', 'truk' => 'Truk', 'hari' => 'Hari', 'lumpsum' => 'Lumpsum', '1 bulan' => '1 Bulan', '2 bulan' => '2 Bulan', '3 bulan' => '3 Bulan', '4 bulan' => '4 Bulan', 'bulan' => 'Bulan', 'tahun' => 'Tahun');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function statusWait($data = null)
    {
        $view = array('Wait' => 'Menunggu', 'Yes' => 'Diproses', 'Cancel' => 'Batal');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function statusWaitOrder($data = null)
    {
        $view = array('Wait' => 'Diproses', 'Yes' => 'Terkirim', 'Cancel' => 'Batal');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function statusInvoice($data = null)
    {
        $view = array('Y' => 'Lunas', 'N' => 'Belum Bayar', 'NP' => 'Kurang Bayar');
        $result = (empty($data)) ? $view : $view[$data]; 
        return $result;
    }

    public function fPayment($data = null)
    {
        $view = array('Y' => 'Lunas', 'N' => 'Blm Dibayar', 'NP' => 'Kurang Bayar');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
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

    public function uploadXls($_filename, $_usingdate, $_fields, &$strConfirmUpload)
    {
        $testAgainstFormats = [
            \PhpOffice\PhpSpreadsheet\IOFactory::READER_XLS,
            \PhpOffice\PhpSpreadsheet\IOFactory::READER_HTML,
        ];

        /** Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName, 0, $testAgainstFormats);

        /*// App::import('Vendor','PHPExcelReader',array('file' => 'PHPExcel/Reader/Excel5.php'));
		// $fileExtension = pathinfo($_filename['name'], PATHINFO_EXTENSION);
		$maxFile = "502400";

		//pr($maxFile);

		if($maxFile>=$_filename['size']){
			if($fileExtension=="xls"){
				//Count filename.
				if (count($_filename) ){
					$filename= basename($_filename['name']);
					$upload_dir = "uploadfiles/".$filename;
					if (move_uploaded_file($_filename['tmp_name'], $upload_dir) ) {
					  $strConfirmUpload =  'File '.$filename.' success to process.\n';
					  $xlsFile=$filename;
					} else {
					  $strConfirmUpload=  '<font color="#FF0000">The upload process fails to connect : </font>'.$upload_dir;
					}
				}

			 	// $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
			 	$objReader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				// $objReader = new PHPExcel_Reader_Excel5();
				$objPHPExcel = $objReader->setReadDataOnly(true);
				$objPHPExcel = $objReader->load('uploadfiles/'.$xlsFile);

				$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
				$array_data = array();
				foreach($rowIterator as $row){
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
					if(1 == $row->getRowIndex ()) continue;//skip first row
					$rowIndex = $row->getRowIndex ();

					foreach ($cellIterator as $cell) {
						if($_usingdate==1){
							for($a=0;$a<$_fields;$a++){
								$_chr = chr(65+$a);
								if($_chr == $cell->getColumn()){
									$array_data[$rowIndex][$_chr] = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'YYYY-MM-DD');
								}
							}
						}else{
							for($a=0;$a<$_fields;$a++){
								$_chr = chr(65+$a);
								if($_chr == $cell->getColumn()){
									$array_data[$rowIndex][$_chr] = $cell->getCalculatedValue();
								}
							}
						}
					}
				}

			}else{
				$array_data = array();
				$strConfirmUpload=  '<font color="#FF0000">Sorry reply is processed instead of the Excel File.</font>';
			}
		}else{
			$array_data = array();
			$strConfirmUpload=  '<font color="#FF0000">Sorry file too large who processed.</font>';
		}
		return $array_data;*/
    }


    public function auditLog($table = null, $id = null, $userId = null, $key = null)
    {
        //, $pageName=null
        if (empty($id) || $id == null || $id == 'N') {
            $dataOld = array();
        } else {
            $model = TableRegistry::get($table);
            // $model = ClassRegistry::init($table);

            $dataRows = $model->find('all', ['conditions' => ['id' => $id]])->first();

            // $dataRows = $this->model->find('first', array(
            //      					'conditions' => array('id' => $id),
            //      					'recursive' => -1));
            // pr($dataRows);

            $dataOlds = $dataRows->is_log;
            $dataOld = (empty($dataOlds)) ? array() : json_decode($dataOlds, true);
        }

        // $dateNow = date("Y-m-d H:i:s");
        $dateNow = $this->dateNow();
        // pr($dataOld);

        $dataCount = (!empty($dataOld)) ? count($dataOld) + 1 : 0;
        // $dataCount = count($dataOld)+1;

        $dataNews = array($dataCount => array("page" => $table, "user_id" => $userId, "key" => $key, "date" => $dateNow));

        // $result = (!empty($dataOld)) ? array_merge_recursive($dataOld, $dataNews) : array();
        $result = (empty($dataOld)) ? $dataNews[0] : array_merge_recursive($dataOld, $dataNews);
        // $result = array_merge_recursive($dataOld, $dataNews);

        return json_encode($result);
    }

    public  function _currency($value)
    {
        return Number::format($value, ['places' => 0, 'locale' => 'id_ID']);
    }

    public function currency($value)
    {
        if (is_numeric($value)) {
            // Format angka sesuai locale Indonesia
            return Number::format(round($value), ['places' => 0, 'locale' => 'id_ID']);
        }
        return $value;
    }

    // Membuat function untuk auditLog
    public function auditLogs($table = null, $id = null, $pageName = null, $userId = null, $key = null)
    {
        if (empty($id) || $id == null || $id == 'N') {
            $dataOld = array();
        } else {
            $model = TableRegistry::get($table);

            $dataRows = $model->find('all', ['conditions' => ['id' => $id]])->first();

            $dataOlds = $dataRows->is_log;
            $dataOld = (empty($dataOlds)) ? array() : json_decode($dataOlds, true);
        }

        $dateNow = $this->dateNow();
        $dataCount = count($dataOld) + 1;

        $dataNews = array($dataCount => array("page" => $pageName, "user_id" => $userId, "key" => $key, "date" => $dateNow));

        $result = array_merge_recursive($dataOld, $dataNews);

        return json_encode($result);
    }

    public function dateNow()
    {
        $result = date("Y-m-d H:i:s");
        return $result;
    }

    // Memisahkan kondisi pada rule
    public function _rule($data = null)
    {
        $dataRule = explode(';', $data);
        $result = array();
        foreach ($dataRule as $idRule => $valRule) {
            $dataAction = explode('=', $valRule);
            $controlRule = array($dataAction[0] => $dataAction[1]);
            $_act = array();
            foreach ($controlRule as $keyControlRule => $valControlRule) {
                $getAction = explode(',', $valControlRule);
                foreach ($getAction as $key => $act) {
                    $splitAct = explode(':', $act);
                    $_act[$splitAct[0]] = $splitAct[1];
                }
                $result[$dataAction[0]] = $_act;
            }
        }
        return $result;
    }

    // Membuat kondisi pada rule
    public function createRule($data = null)
    {
        $rules  = array();
        foreach ($data as $_rule => $_action) {
            $actions = array();
            foreach ($_action as $_actions => $action) {
                $actions[] = $_actions . ':' . $action;
            }
            $rules[] = $_rule . '=' . implode(',', $actions);
        }
        $result = implode(';', $rules);
        return $result;
    }

    public function dataSelectGroup($data = null)
    {
        $result = array();
        foreach ($data as $level1) {
            if ($level1->level == 1) {
                foreach ($data as $level2) {
                    if ($level2->level == 2 && ($level2->parent_id == $level1->id)) {
                        $result[$level1->name][$level2->id] = $level2->name;
                    }
                }
            }
        }
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

    public function dateTo($date, $time = null)
    {
        $day = substr($date, 0, 2);
        $month = substr($date, 3, 2);
        $year = substr($date, 6, 4);
        $times = substr($date, 11);

        if ($date == '') {
            $result = '';
        } else {
            $result = (empty($time)) ? $year . '-' . $month . '-' . $day : $year . '-' . $month . '-' . $day . ' ' . $times;
        }

        return $result;
    }

    public function monthYearTo($date)
    {
        $month = substr($date, 0, 2);
        $year = substr($date, 3, 4);

        if ($date == '') {
            $result = '';
        } else {
            $result = (empty($date)) ? '' : $year . '-' . $month;
        }

        return $result;
    }

    public function fDate($value = '', $format = '')
    {
        $result = (empty($value) && empty($format)) ? '' : date_format(date_create($value), $format);
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

    public function getDataCOAByJournalType($dataCOA = null, $journalType = null)
    {

        if (!empty($dataCOA)) {
            $result = array();
            $a = 0;
            foreach ($dataCOA as $dataRow) {
                // $dataRow = $valueDataCOA['AccChartOfAccounts'];
                if ($dataRow['journal_type'] == $journalType && (!empty($dataRow['name']) || !empty($dataRow['customer_id']))) {
                    $result[$a] = $dataRow;
                }
                $a++;
            }
        } else {
            $result = array();
        }

        return $result;
    }

    public function GetSchemaCOAGlobalShow($dataCOA = '', $dataJournalCOA = '', $dataJournalCOAAfter = '', $dataStatusDebetCredit = 'debit', $flip = false, $showTotal = true)
    {

        $listCOA = array();
        //$a=1;

        foreach ($dataCOA as $coaData) {
            //foreach ($dataCOA as $valueCOA) {
            // $coaData = $valueCOA;
            //$coaData = $valueCOA['AccChartOfAccount'];
            //pr($coaData);
            if (!empty($coaData)) {
                if ($coaData['level'] == 4) {
                    $data4 = (empty($coaData)) ? array('id' => '', 'code' => '', 'name' => '') : $coaData;
                    $data4Name = (empty($data4['name'])) ? $data4['customer_name'] : $data4['name'];
                    $listCOA[$data4['id']]['Level4'] = $data4['code'] . '^' . $data4Name;

                    $parentIdLevel4 = $data4['id'];
                } elseif ($coaData['level'] == 5) {
                    if (!empty($parentIdLevel4)) {
                        if ($coaData['parent_id'] == $parentIdLevel4) {
                            $data5 = (empty($coaData)) ? array('id' => '', 'code' => '', 'name' => '') : $coaData;
                            //pr($coaData);

                            $data5Name = (!empty($data5['name'])) ? $data5['name'] : $data5['customer_name'];
                            //pr($flip);

                            $dataJournalDebetCredit = $this->sumDataJournalShow($dataJournalCOA, $data5['id'], $dataStatusDebetCredit);
                            $dataJournalDebetCredits = round($dataJournalDebetCredit, 2);
                            $dataJournalDebetCreditAfter = $this->sumDataJournalShow($dataJournalCOAAfter, $data5['id'], $dataStatusDebetCredit);
                            $dataJournalDebetCreditAfters = round($dataJournalDebetCreditAfter, 2);

                            $totalJournals = $dataJournalDebetCredits + $data5['beginning_balance'];
                            $totalJournalAfters = $dataJournalDebetCreditAfters + $data5['beginning_balance'];


                            $totalJournal = ($flip == true) ? $this->flipTheValue($totalJournals) : $totalJournals;
                            $totalJournalAfter = ($flip == true) ? $this->flipTheValue($totalJournalAfters) : $totalJournalAfters;
                            if ($totalJournal != 0 || $totalJournalAfter != 0) {
                                $listCOA[$data4['id']]['Level5'][] = $data5['code'] . '^' . $data5Name . '^' . $dataJournalDebetCredit . '^' . $dataJournalDebetCreditAfter . '^' . $data5['beginning_balance'] . '^' . $totalJournal . '^' . $totalJournalAfter;
                            }
                            $idLevel5[] = $data5['id'];
                        }
                    }
                }
            }
        }

        return $listCOA;
    }

    public function GetSchemaCOAGlobalMultiShow($dataCOA = '', $dataJournalCOA = '', $month = '01', $dataJournalCOAAfter = '', $dataStatusDebetCredit = 'debit', $flip = false, $showTotal = true)
    {

        list($monthFrom, $monthEnd) = explode('^', $month);

        $listCOA = array();
        foreach ($dataCOA as $coaData) {
            // $coaData = $valueCOA['AccChartOfAccount'];
            //pr($coaData);
            if (!empty($coaData)) {
                if ($coaData['level'] == 4) {
                    //$dataJournalNowTotal = array_sum($dataJournalNows);

                    $data4 = (empty($coaData)) ? array('id' => '', 'code' => '', 'name' => '') : $coaData;
                    $data4Name = (empty($data4['name'])) ? $data4['customer_name'] : $data4['name'];
                    $listCOA[$data4['id']]['Level4'] = $data4['code'] . '^' . $data4Name;

                    $parentIdLevel4 = $data4['id'];
                } elseif ($coaData['level'] == 5) {
                    if (!empty($parentIdLevel4)) {
                        if ($coaData['parent_id'] == $parentIdLevel4) {
                            $data5 = (empty($coaData)) ? array('id' => '', 'code' => '', 'name' => '') : $coaData;
                            //pr($coaData);

                            $data5Name = (!empty($data5['name'])) ? $data5['name'] : $data5['customer_name'];
                            //pr($flip);

                            //pr($valueData);
                            //}
                            for ($i = $monthFrom; $i <= $monthEnd; $i++) {
                                $monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

                                $dataJournalDebetCredit = (empty($dataJournalCOA)) ? 0 : $this->sumDataJournalShow($dataJournalCOA[$monthData], $data5['id'], $dataStatusDebetCredit);
                                $dataJournalDebetCredits = round($dataJournalDebetCredit, 2);

                                $totalJournals = $dataJournalDebetCredits + $data5['beginning_balance'];

                                $totalJournal = ($flip == true) ? $this->flipTheValue($totalJournals) : $totalJournals;

                                if ($totalJournal != 0) {
                                    $listCOA[$data4['id']]['Level5Name'][] = $data5['id'] . '^' . $data5['code'] . '^' . $data5Name;
                                    $listCOA[$data4['id']]['Level5'][$monthData][$data5['id']] = $data5['id'] . '^' . $dataJournalDebetCredit . '^' . $data5['beginning_balance'] . '^' . $totalJournal;
                                }
                            }
                            $idLevel5[] = $data5['id'];
                        }
                    }
                }
            }
        }

        return $listCOA;
    }

    public function sumDataJournalShow($data = '', $idJournal = '', $dk = '', $flip = false)
    {
        if (!empty($data[$idJournal])) {
            list($totalDebets, $totalCredits) = explode('^', $data[$idJournal]);
            $totalDebet = (!empty($totalDebets)) ? $totalDebets : 0;
            $totalCredit = (!empty($totalCredits)) ? $totalCredits : 0;

            // pr($totalDebets.', '.$totalCredits);

            if ($dk == 'debet') {
                $resultTotal = $totalDebet;
            } elseif ($dk == 'credit') {
                $resultTotal = $totalCredit;
            } elseif ($dk == 'creditMinusdebet') {
                $resultTotal = $totalCredit - $totalDebet;
            } elseif ($dk == 'debetMinuscredit') {
                $resultTotal = $totalDebet - $totalCredit;
            } else {
                $resultTotal = $totalDebet - $totalCredit;
            }
        } else {
            $resultTotal = false;
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

        return $result;
    }

    public function sumDataJournalShowForTrialBalance($data = '', $idJournal = '', $dk = '', $flip = false)
    {
        //$dataDebetCredit = (!empty($data[$idJournal])
        if (!empty($data[$idJournal])) {
            list($totalDebets, $totalCredits) = explode('^', $data[$idJournal]);
            // pr($data[$idJournal]);
            $totalDebet = (empty($totalDebets)) ? 0 : $totalDebets;
            $totalCredit = (empty($totalCredits)) ? 0 : $totalCredits;
            //pr($totalDebet);
            if ($dk == 'debet') {
                $resultTotal = $totalDebet;
            } elseif ($dk == 'credit') {
                $resultTotal = $totalCredit;
            } elseif ($dk == 'creditMinusdebet') {
                $resultTotal = $totalCredit - $totalDebet;
            } elseif ($dk == 'debetMinuscredit') {
                $resultTotal = $totalDebet - $totalCredit;
            } else {
                $resultTotal = $totalDebet - $totalCredit;
            }
            $resultTotals = $resultTotal . '^' . $totalDebet . '^' . $totalCredit;
        } else {
            $resultTotals = "^^";
        }

        return $resultTotals;
    }

    public function GetSchemaCOAShowForTrialBalance($dataCOA = '', $dataJournalCOA = '', $dataStatusDebetCredit = 'debit', $flip = false, $showTotal = true)
    {

        $listCOA = array();
        //$a=1;

        foreach ($dataCOA as $coaData) {
            // $coaData = $valueCOA['AccChartOfAccount'];
            //pr($coaData);
            if (!empty($coaData)) {
                if ($coaData['level'] == 4) {
                    //$dataJournalNowTotal = array_sum($dataJournalNows);

                    $data4 = (empty($coaData)) ? array('id' => '', 'code' => '', 'name' => '') : $coaData;
                    $data4Name = (empty($data4['name'])) ? $data4['customer_name'] : $data4['name'];
                    $listCOA[$data4['id']]['Level4'] = $data4['code'] . '^' . $data4Name;

                    $parentIdLevel4 = $data4['id'];
                } elseif ($coaData['level'] == 5) {
                    if (!empty($parentIdLevel4)) {
                        if ($coaData['parent_id'] == $parentIdLevel4) {
                            $data5 = (empty($coaData)) ? array('id' => '', 'code' => '', 'name' => '') : $coaData;
                            //pr($coaData);

                            $data5Name = (!empty($data5['name'])) ? $data5['name'] : $data5['customer_name'];
                            //pr($flip);
                            //sumDataJournalShowForTrialBalance
                            $dataJournalDebetCredit = $this->sumDataJournalShowForTrialBalance($dataJournalCOA, $data5['id'], $dataStatusDebetCredit);
                            $dataJournalDebetCredits = round($dataJournalDebetCredit, 2);
                            $totalJournals = $dataJournalDebetCredits + $data5['beginning_balance'];

                            $totalJournal = ($flip == true) ? $this->flipTheValue($totalJournals) : $totalJournals;
                            //pr($totalJournal);
                            //pr($dataTotal);

                            //pr($dataCOA);
                            list($totalDebetCredits, $totalDebets, $totalCredits) = explode('^', $dataJournalDebetCredit);
                            if ($totalJournal == 0 && $totalDebets == 0 && $totalCredits == 0 && $data5['beginning_balance'] == 0) {
                            } else {
                                $listCOA[$data4['id']]['Level5'][] = $data5['code'] . '^' . $data5Name . '^' . $dataJournalDebetCredit . '^' . $data5['beginning_balance'] . '^' . $totalJournal;
                            }
                            $idLevel5[] = $data5['id'];
                        }
                    }
                }
            }
        }

        return $listCOA;
    }

    public function GetSchemaCOAShow($dataCOA = '', $dataJournalCOA = '', $dataStatusDebetCredit = 'debit', $flip = false, $showTotal = true)
    {

        $listCOA = array();
        //$a=1;

        foreach ($dataCOA as $coaData) {
            // $coaData = $valueCOA['AccChartOfAccount'];
            //pr($coaData);
            if (!empty($coaData)) {
                if ($coaData['level'] == 4) {
                    //$dataJournalNowTotal = array_sum($dataJournalNows);

                    $data4 = (empty($coaData)) ? array('id' => '', 'code' => '', 'name' => '') : $coaData;
                    $data4Name = (empty($data4['name'])) ? $data4['customer_name'] : $data4['name'];
                    $listCOA[$data4['id']]['Level4'] = $data4['code'] . '^' . $data4Name;

                    $parentIdLevel4 = $data4['id'];
                } elseif ($coaData['level'] == 5) {
                    if (!empty($parentIdLevel4)) {
                        if ($coaData['parent_id'] == $parentIdLevel4) {
                            $data5 = (empty($coaData)) ? array('id' => '', 'code' => '', 'name' => '') : $coaData;
                            //pr($coaData);

                            $data5Name = (!empty($data5['name'])) ? $data5['name'] : $data5['customer_name'];
                            //pr($flip);

                            $dataJournalDebetCredit = $this->sumDataJournalShow($dataJournalCOA, $data5['id'], $dataStatusDebetCredit);
                            $dataJournalDebetCredits = round($dataJournalDebetCredit, 2);
                            $totalJournals = $dataJournalDebetCredits + $data5['beginning_balance'];

                            $totalJournal = ($flip == true) ? $this->flipTheValue($totalJournals) : $totalJournals;

                            if ($totalJournal != 0) {
                                $listCOA[$data4['id']]['Level5'][] = $data5['code'] . '^' . $data5Name . '^' . $dataJournalDebetCredit . '^' . $data5['beginning_balance'] . '^' . $totalJournal;
                            }

                            $idLevel5[] = $data5['id'];
                        }
                    }
                }
            }
        }
        return $listCOA;
    }

    public function totalCOADetailShow($listCOA = null, &$debetTotal = 0, &$creditTotal = 0, $usingBeginningBalance = false)
    {
        if (isset($listCOA)) {
            $totalDetails = array();
            $debetTotal = array();
            $creditTotal = array();
            foreach ($listCOA as $total) {
                if (isset($total['Level5']) && $total['Level5']) {
                    foreach ($total['Level5'] as $dataCOA) {
                        list($codeTotalDetail, $nameTotalDetail, $debetCreditTotalDetail, $debetTotalDetail, $creditTotalDetail, $beginningBalanceTotalDetail, $TotalDetail) = explode('^', $dataCOA);
                        $totalDetail = ($usingBeginningBalance == true) ? $debetCreditTotalDetail + $beginningBalanceTotalDetail : $debetCreditTotalDetail;

                        $totalDetails[] = $totalDetail;
                        $debetTotal[] = $debetTotalDetail;
                        $creditTotal[] = $creditTotalDetail;
                    }
                }
            }
        }

        return $totalDetails;
    }

    public function totalCOADetail($listCOA = null, $usingBeginningBalance = false)
    {
        if (isset($listCOA)) {
            $totalDetails = array();
            foreach ($listCOA as $total) {
                if (isset($total['Level5']) && $total['Level5']) {
                    foreach ($total['Level5'] as $dataCOA) {
                        list($codeTotalDetail, $nameTotalDetail, $debetCreditTotalDetail, $beginningBalanceTotalDetail) = explode('^', $dataCOA);
                        $totalDetail = ($usingBeginningBalance == true) ? $debetCreditTotalDetail + $beginningBalanceTotalDetail : $debetCreditTotalDetail;
                        //$totalDetail = $debetCreditTotalDetail;
                        $totalDetails[] = $totalDetail;
                    }
                }
            }
        }

        return $totalDetails;
    }

    public function formatCurrency($value) {
        // Hilangkan titik dari string dan ubah menjadi float
        $number = floatval(str_replace('.', '', $value));
        
        // Format ke dalam angka dengan dua desimal
        return number_format($number, 2, '', '');
    }
}
