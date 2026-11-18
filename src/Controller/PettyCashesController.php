<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Utility\Hash;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * PettyCashes Controller
 *
 * @property \App\Model\Table\PettyCashesTable $PettyCashes
 * @method \App\Model\Entity\PettyCash[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PettyCashesController extends AppController
{
    
    private $session;

    public function initialize(): void
    {
        parent::initialize();
        
        $sessions = $this->request->getSession();
        $this->session = $sessions->read('Auth');

        //$this->db = ConnectionManager::get("default");
        // $this->autoRender = false;
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $dataKeyAll = $this->request->getQueryParams();
        $getSearch = $this->request->getQuery('search');
        $getLink = $this->request->getQuery();
        //if ($this->request->is(['patch', 'post', 'put'])) {
        if ($this->request->is(['post'])) {
            $dataRow = $this->request->getData();
            // pr($dataRow);

            $dataLink = array();
            $dataWhere = array();
            // $filterData = array('project LIKE'=> '%'.$dataRow['filterProject'].'%');
            if(!empty($dataRow['filterProject'])) {
                $dataWhere['PettyCashes.project'] = $dataRow['filterProject'];
                $dataLink['filterProject'] = $dataRow['filterProject'];
            }
            if(!empty($dataRow['filterCode'])) {
                $dataWhere['PettyCashes.code LIKE'] = '%'.$dataRow['filterCode'] . '%';
                $dataLink['filterCode'] = $dataRow['filterCode'];                
            }
            if(!empty($dataRow['filterDevision'])) {
                $dataWhere['PettyCashes.devision LIKE'] = '%'.$dataRow['filterDevision'] . '%';
                $dataLink['filterDevision'] = $dataRow['filterDevision'];           
            }
            if(!empty($dataRow['filterAdvance'])) {
                $dataWhere['PettyCashes.purpose_of_advancing LIKE'] = '%'.$dataRow['filterAdvance'] . '%';
                $dataLink['filterAdvance'] = $dataRow['filterAdvance'];               
            }
            if(!empty($dataRow['filterDateFrom'])) {
                // $dataWhere['DATE(PettyCashes.date) BETWEEN'] = $this->Krs->dateTo($dataRow['filterDateFrom'])."' AND '".$this->Krs->dateTo($dataRow['filterDateEnd']);
                $dataWhere[] = 'DATE(PettyCashes.date) BETWEEN "' . $this->Krs->dateTo($dataRow['filterDateFrom']) . '" AND "' . $this->Krs->dateTo($dataRow['filterDateEnd']) . '"';
                $dataLink['filterDateFrom'] = $dataRow['filterDateFrom'];
                $dataLink['filterDateEnd'] = $dataRow['filterDateEnd'];
                /*$dataWhere[] = function (QueryExpression $exp, Query $q) {
                return $exp->between('DATE(PettyCashes.date)', $this->Krs->dateTo($dataRow['filterDateFrom']), $this->Krs->dateTo($dataRow['filterDateEnd']));
                }*/

            }
            if(!empty($dataRow['filterDueDateStart'])) {
                $dataWhere[] = 'DATE(PettyCashes.due_date) BETWEEN "' . $this->Krs->dateTo($dataRow['filterDueDateStart']) . '" AND "' . $this->Krs->dateTo($dataRow['filterDueDateEnd']) . '"';
                $dataLink['filterDueDateStart'] = $dataRow['filterDueDateStart'];
                $dataLink['filterDueDateEnd'] = $dataRow['filterDueDateEnd'];
                // $dataWhere['DATE(PettyCashes.due_date) BETWEEN'] = $this->Krs->dateTo($dataRow['filterDueDateStart']).' AND '.$this->Krs->dateTo($dataRow['filterDueDateEnd']);             
            }
            if(!empty($dataRow['filterApprove2DateStart'])) {
                $dataWhere[] = 'DATE(PettyCashes.approved_ceo_date) BETWEEN "' . $this->Krs->dateTo($dataRow['filterApprove2DateStart']) . '" AND "' . $this->Krs->dateTo($dataRow['filterApprove2DateEnd']) . '"';
                $dataLink['filterApprove2DateStart'] = $dataRow['filterApprove2DateStart'];
                $dataLink['filterApprove2DateEnd'] = $dataRow['filterApprove2DateEnd'];
                // $dataWhere['DATE(PettyCashes.approved_ceo_date) BETWEEN'] = $this->Krs->dateTo($dataRow['filterApprove2DateStart']).' AND '.$this->Krs->dateTo($dataRow['filterApprove2DateEnd']);
            }
            if(!empty($dataRow['filterUserAdmin'])) {
                $dataWhere['UserApplicant.code LIKE'] = '%'.$dataRow['filterUserAdmin'] . '%';
                $dataLink['filterUserAdmin'] = $dataRow['filterUserAdmin'];
                
            }
            if(!empty($dataRow['filterPayment'])) {
                $dataWhere['PettyCashes.payment_status'] = $dataRow['filterPayment'];
                $dataLink['filterPayment'] = $dataRow['filterPayment'];
            }

            // pr($dataWhere);


            /*[filterProject] => 
            [filterCode] => 
            [filterDevision] => 
            [filterAdvance] => 
            [filterDateFrom] => 
            [filterDateEnd] => 
            [filterDueDateStart] => 
            [filterDueDateEnd] => 
            [filterApprove2DateStart] => 
            [filterApprove2DateEnd] => 
            [filterUserAdmin] => mich
            [filterPayment] => */

            /*
            $this->paginate['conditions'][]['Post.name LIKE'] = str_replace('*','%',$this->passedArgs['Search.name']);
                $this->data['Search']['name'] = $this->passedArgs['Search.name'];
                $title[] = __('Name',true).': '.$this->passedArgs['Search.name'];

            $url['action'] = 'index';
            foreach ($dataRow as $k=>$v){ 
                foreach ($v as $kk=>$vv){ 
                    if ($vv) {
                        $url[$k.'.'.$kk]=$vv; 
                    }
                } 
            }*/

            
            // pr($filterData);
            
            //return $this->redirect(['action' => 'transportCost', '?' => $dataKeyAll]);
            //
            // $dataKey = $this->request->getQuery('key');

            $dataSearchs = $this->Krs->fEncode($dataWhere);
            $dataLinks = $this->Krs->fEncode($dataLink);
            return $this->redirect(['action' => 'index', '?' => ['search' => $dataSearchs, 'link' => $dataLinks]]);
        } else {
            $dataSearchs = $this->Krs->fEncode("");
        }

        if(!empty($getLink['link'])) {
            $dataLinks = $this->Krs->fdecode($getLink['link']);
            //pr($dataLinks);
            $dataLink['filterProject'] = (isset($dataLinks['filterProject'])) ? $dataLinks['filterProject'] : "";
            $dataLink['filterCode'] = (isset($dataLinks['filterCode'])) ? $dataLinks['filterCode'] : "";
            $dataLink['filterDevision'] = (isset($dataLinks['filterDevision'])) ? $dataLinks['filterDevision'] : "";
            $dataLink['filterAdvance'] = (isset($dataLinks['filterAdvance'])) ? $dataLinks['filterAdvance'] : "";
            $dataLink['filterDateFrom'] = (isset($dataLinks['filterDateFrom'])) ? $dataLinks['filterDateFrom'] : "";
            $dataLink['filterDateEnd'] = (isset($dataLinks['filterDateEnd'])) ? $dataLinks['filterDateEnd'] : "";
            $dataLink['filterDueDateStart'] = (isset($dataLinks['filterDueDateStart'])) ? $dataLinks['filterDueDateStart'] : "";
            $dataLink['filterDueDateEnd'] = (isset($dataLinks['filterDueDateEnd'])) ? $dataLinks['filterDueDateEnd'] : "";
            $dataLink['filterApprove2DateStart'] = (isset($dataLinks['filterApprove2DateStart'])) ? $dataLinks['filterApprove2DateStart'] : "";
            $dataLink['filterApprove2DateEnd'] = (isset($dataLinks['filterApprove2DateEnd'])) ? $dataLinks['filterApprove2DateEnd'] : "";
            $dataLink['filterUserAdmin'] = (isset($dataLinks['filterUserAdmin'])) ? $dataLinks['filterUserAdmin'] : "";
            $dataLink['filterPayment'] = (isset($dataLinks['filterPayment'])) ? $dataLinks['filterPayment'] : "";
        } else {
            $dataLink['filterProject'] = "";
            $dataLink['filterCode'] = "";
            $dataLink['filterDevision'] = "";
            $dataLink['filterAdvance'] = "";
            $dataLink['filterDateFrom'] = "";
            $dataLink['filterDateEnd'] = "";
            $dataLink['filterDueDateStart'] = "";
            $dataLink['filterDueDateEnd'] = "";
            $dataLink['filterApprove2DateStart'] = "";
            $dataLink['filterApprove2DateEnd'] = ""; 
            $dataLink['filterUserAdmin'] = "";
            $dataLink['filterPayment'] = "";
        }

        $pettyCashes = $this->PettyCashes->find('all')->contain(['Accept', 'UserApplicant', 'PettyCashLines']);

        // pr($dataKeyAll['search']);
        $dataWheres = (empty($getLink['search'])) ? "" : $this->Krs->fdecode($getLink['search']);

        $queries = (!empty($dataWheres)) ? $pettyCashes->where([$dataWheres]) : $pettyCashes;

        $settings = [
            'limit' => 15,
            'order' => [
                'IF(due_date = DATE(NOW()), 0, 1)',
                'due_date' => 'desc',
                "FIELD(payment_status, 'Y', 'NP', 'N') desc",
                'approved_date' => 'asc',
            ],
        ];
        // 'order' => [
        //         'IF(due_date = DATE(NOW()), 0, 1)',
        //         'due_date' => 'desc',
        //         "FIELD(payment_status, 'Y', 'NP', 'N') desc",
        //         'approved_date' => 'asc',
        //     ],
        // $this->paginate = [
        //     'contain' => ['Accept', 'UserApplicant', 'PettyCashLines'],
        // ];
        // $pettyCashes = $this->paginate($this->PettyCashes, $settings);
        $pettyCashes = $this->paginate($queries, $settings);
        
        $this->set(compact('pettyCashes', 'dataLink', 'dataSearchs'));
    }

    public function portal()
    {
       /* $dataKeyAll = $this->request->getQueryParams();
        $getSearch = $this->request->getQuery('search');
        $getLink = $this->request->getQuery();
        //if ($this->request->is(['patch', 'post', 'put'])) {
        if ($this->request->is(['post'])) {
            $dataRow = $this->request->getData();
            // pr($dataRow);

            $dataLink = array();
            $dataWhere = array();
            // $filterData = array('project LIKE'=> '%'.$dataRow['filterProject'].'%');
            if(!empty($dataRow['filterProject'])) {
                $dataWhere['PettyCashes.project'] = $dataRow['filterProject'];
                $dataLink['filterProject'] = $dataRow['filterProject'];
            }
            if(!empty($dataRow['filterCode'])) {
                $dataWhere['PettyCashes.code LIKE'] = '%'.$dataRow['filterCode'] . '%';
                $dataLink['filterCode'] = $dataRow['filterCode'];                
            }
            if(!empty($dataRow['filterDevision'])) {
                $dataWhere['PettyCashes.devision LIKE'] = '%'.$dataRow['filterDevision'] . '%';
                $dataLink['filterDevision'] = $dataRow['filterDevision'];           
            }
            if(!empty($dataRow['filterAdvance'])) {
                $dataWhere['PettyCashes.purpose_of_advancing LIKE'] = '%'.$dataRow['filterAdvance'] . '%';
                $dataLink['filterAdvance'] = $dataRow['filterAdvance'];               
            }
            if(!empty($dataRow['filterDateFrom'])) {
                // $dataWhere['DATE(PettyCashes.date) BETWEEN'] = $this->Krs->dateTo($dataRow['filterDateFrom'])."' AND '".$this->Krs->dateTo($dataRow['filterDateEnd']);
                $dataWhere[] = 'DATE(PettyCashes.date) BETWEEN "' . $this->Krs->dateTo($dataRow['filterDateFrom']) . '" AND "' . $this->Krs->dateTo($dataRow['filterDateEnd']) . '"';
                $dataLink['filterDateFrom'] = $dataRow['filterDateFrom'];
                $dataLink['filterDateEnd'] = $dataRow['filterDateEnd'];
                

            }
            if(!empty($dataRow['filterDueDateStart'])) {
                $dataWhere[] = 'DATE(PettyCashes.due_date) BETWEEN "' . $this->Krs->dateTo($dataRow['filterDueDateStart']) . '" AND "' . $this->Krs->dateTo($dataRow['filterDueDateEnd']) . '"';
                $dataLink['filterDueDateStart'] = $dataRow['filterDueDateStart'];
                $dataLink['filterDueDateEnd'] = $dataRow['filterDueDateEnd'];
                // $dataWhere['DATE(PettyCashes.due_date) BETWEEN'] = $this->Krs->dateTo($dataRow['filterDueDateStart']).' AND '.$this->Krs->dateTo($dataRow['filterDueDateEnd']);             
            }
            if(!empty($dataRow['filterApprove2DateStart'])) {
                $dataWhere[] = 'DATE(PettyCashes.approved_ceo_date) BETWEEN "' . $this->Krs->dateTo($dataRow['filterApprove2DateStart']) . '" AND "' . $this->Krs->dateTo($dataRow['filterApprove2DateEnd']) . '"';
                $dataLink['filterApprove2DateStart'] = $dataRow['filterApprove2DateStart'];
                $dataLink['filterApprove2DateEnd'] = $dataRow['filterApprove2DateEnd'];
                // $dataWhere['DATE(PettyCashes.approved_ceo_date) BETWEEN'] = $this->Krs->dateTo($dataRow['filterApprove2DateStart']).' AND '.$this->Krs->dateTo($dataRow['filterApprove2DateEnd']);
            }
            if(!empty($dataRow['filterUserAdmin'])) {
                $dataWhere['UserApplicant.code LIKE'] = '%'.$dataRow['filterUserAdmin'] . '%';
                $dataLink['filterUserAdmin'] = $dataRow['filterUserAdmin'];
                
            }
            if(!empty($dataRow['filterPayment'])) {
                $dataWhere['PettyCashes.payment_status'] = $dataRow['filterPayment'];
                $dataLink['filterPayment'] = $dataRow['filterPayment'];
            }

            // pr($dataWhere);


            $this->paginate['conditions'][]['Post.name LIKE'] = str_replace('*','%',$this->passedArgs['Search.name']);
                $this->data['Search']['name'] = $this->passedArgs['Search.name'];
                $title[] = __('Name',true).': '.$this->passedArgs['Search.name'];

            $url['action'] = 'index';
            foreach ($dataRow as $k=>$v){ 
                foreach ($v as $kk=>$vv){ 
                    if ($vv) {
                        $url[$k.'.'.$kk]=$vv; 
                    }
                } 
            }

            
            // pr($filterData);
            
            //return $this->redirect(['action' => 'transportCost', '?' => $dataKeyAll]);
            //
            // $dataKey = $this->request->getQuery('key');

            $dataSearchs = $this->Krs->fEncode($dataWhere);
            $dataLinks = $this->Krs->fEncode($dataLink);
            return $this->redirect(['action' => 'index', '?' => ['search' => $dataSearchs, 'link' => $dataLinks]]);
        } 

        if(!empty($getLink['link'])) {
            $dataLinks = $this->Krs->fdecode($getLink['link']);
            //pr($dataLinks);
            $dataLink['filterProject'] = (isset($dataLinks['filterProject'])) ? $dataLinks['filterProject'] : "";
            $dataLink['filterCode'] = (isset($dataLinks['filterCode'])) ? $dataLinks['filterCode'] : "";
            $dataLink['filterDevision'] = (isset($dataLinks['filterDevision'])) ? $dataLinks['filterDevision'] : "";
            $dataLink['filterAdvance'] = (isset($dataLinks['filterAdvance'])) ? $dataLinks['filterAdvance'] : "";
            $dataLink['filterDateFrom'] = (isset($dataLinks['filterDateFrom'])) ? $dataLinks['filterDateFrom'] : "";
            $dataLink['filterDateEnd'] = (isset($dataLinks['filterDateEnd'])) ? $dataLinks['filterDateEnd'] : "";
            $dataLink['filterDueDateStart'] = (isset($dataLinks['filterDueDateStart'])) ? $dataLinks['filterDueDateStart'] : "";
            $dataLink['filterDueDateEnd'] = (isset($dataLinks['filterDueDateEnd'])) ? $dataLinks['filterDueDateEnd'] : "";
            $dataLink['filterApprove2DateStart'] = (isset($dataLinks['filterApprove2DateStart'])) ? $dataLinks['filterApprove2DateStart'] : "";
            $dataLink['filterApprove2DateEnd'] = (isset($dataLinks['filterApprove2DateEnd'])) ? $dataLinks['filterApprove2DateEnd'] : "";
            $dataLink['filterUserAdmin'] = (isset($dataLinks['filterUserAdmin'])) ? $dataLinks['filterUserAdmin'] : "";
            $dataLink['filterPayment'] = (isset($dataLinks['filterPayment'])) ? $dataLinks['filterPayment'] : "";
        } else {
            $dataLink['filterProject'] = "";
            $dataLink['filterCode'] = "";
            $dataLink['filterDevision'] = "";
            $dataLink['filterAdvance'] = "";
            $dataLink['filterDateFrom'] = "";
            $dataLink['filterDateEnd'] = "";
            $dataLink['filterDueDateStart'] = "";
            $dataLink['filterDueDateEnd'] = "";
            $dataLink['filterApprove2DateStart'] = "";
            $dataLink['filterApprove2DateEnd'] = "";
            $dataLink['filterUserAdmin'] = "";
            $dataLink['filterPayment'] = "";
        }

        

        $pettyCashes = $this->PettyCashes->find('all')->contain(['Accept', 'UserApplicant', 'PettyCashLines']);

        // pr($dataKeyAll['search']);
        $dataWheres = (empty($getLink['search'])) ? "" : $this->Krs->fdecode($getLink['search']);

        $queries = (!empty($dataWheres)) ? $pettyCashes->where([$dataWheres]) : $pettyCashes;

        $settings = [
            'limit' => 15,
            'order' => [
                'IF(due_date = DATE(NOW()), 0, 1)',
                'due_date' => 'desc',
                "FIELD(payment_status, 'Y', 'NP', 'N') desc",
                'approved_date' => 'asc',
            ],
        ];
        // 'order' => [
        //         'IF(due_date = DATE(NOW()), 0, 1)',
        //         'due_date' => 'desc',
        //         "FIELD(payment_status, 'Y', 'NP', 'N') desc",
        //         'approved_date' => 'asc',
        //     ],
        // $this->paginate = [
        //     'contain' => ['Accept', 'UserApplicant', 'PettyCashLines'],
        // ];
        // $pettyCashes = $this->paginate($this->PettyCashes, $settings);
        $pettyCashes = $this->paginate($queries, $settings);
        
        // $json_data = array(
        //     "draw" => intval($pettyCashes),
        //     "recordsTotal" => $pettyCashes->count(),
        //     "recordsFiltered" => $pettyCashes->count(),
        //     "data" => $pettyCashes   // total data array
        // );

        //echo json_encode($json_data);

        // pr($pettyCashes->count());
        // pr($this->Paginator->param('count'));
        $this->set(compact('pettyCashes', 'dataLink'));*/
    }

    public function pcaApi()
    {
        $db = ConnectionManager::get('default');

        if ($this->request->is("ajax")) {
            // Used when ajax loads data
            $params['draw'] = $_REQUEST['draw'];
            $start = $_REQUEST['start'];
            $length = $_REQUEST['length'];
            /* If we pass any extra data in request from ajax */
            //$value1 = isset($_REQUEST['key1'])?$_REQUEST['key1']:"";

            /* Value we will get from typing in search */
            $search_value = $_REQUEST['search']['value'];

            if (!empty($search_value)) {
                // If we have value in search, searching by id, name, email, mobile

                // count all data
                $total_count = $db->execute("SELECT * FROM petty_cashes WHERE id LIKE '%" . $search_value . "%' OR name like '%" . $search_value . "%' OR code like '%" . $search_value . "%' OR project like '%" . $search_value . "%'")->fetchAll('assoc');

                $data = $db->execute("SELECT * FROM petty_cashes WHERE id LIKE '%" . $search_value . "%' OR name like '%" . $search_value . "%' OR code like '%" . $search_value . "%' OR project like '%" . $search_value . "%' limit $start, $length")->fetchAll('assoc');
            } else {
                // count all data
                $total_count = $db->execute("SELECT * FROM petty_cashes")->fetchAll('assoc');
                
                // get per page data
                $result = $db->execute("SELECT CONCAT('<b>Kode :</b> ', IFNULL(PCs.code,''), '/', 'PCA-', IFNULL(PCs.devision,''), '/', CAST(toRoman(MONTH(PCs.date)) AS CHAR CHARACTER SET utf8), '/', IFNULL(YEAR(PCs.date),''), ' (', PCs.project ,')^<b>Tujuan Advance : </b><i>', PCs.purpose_of_advancing, '</i>^<b>Tanggal : </b>', DATE_FORMAT(PCs.date,'%d-%m-%Y'), ' | <b>Jatuh Tempo : </b>', DATE_FORMAT(PCs.due_date,'%d-%m-%Y')) AS pcaCode, CONCAT('<b>Tanggal : </b>', DATE_FORMAT(PCs.date,'%d-%m-%Y'), '^<b>Jatuh Tempo : </b>', DATE_FORMAT(PCs.due_date,'%d-%m-%Y')) AS pcaDate, DATE_FORMAT(PCs.due_date,'%d-%m-%Y') AS pcaDueDate, PCs.id AS pcaId, PCs.project AS pcaProject, CONCAT('<b>Admin :</b> ', UAs.code,'^<b>Setuju 1 :</b> ', IFNULL(DATE_FORMAT(PCs.approved_date,'%d-%m-%Y'),'-'), ' (',IFNULL(ACp.code,''),')^<b>Setuju 2 :</b> ', IFNULL(DATE_FORMAT(PCs.approved_ceo_date,'%d-%m-%Y'),'-'),')^<b>Pembayaran :</b> ', IFNULL(DATE_FORMAT(PCs.payment_date,'%d-%m-%Y'),'-')) AS pcaProgress, PCs.approved_ceo AS pcaApprove2, DATE_FORMAT(PCs.approved_ceo_date,'%d-%m-%Y') AS pcaApproveDate2, PCs.payment AS pcaPayment, DATE_FORMAT(PCs.payment_date,'%d-%m-%Y') AS pcaPaymentDate, IFNULL(PCs.approved_ceo,'-') AS pcaApproveCeo, Acp.id AS acpId, ACp.code AS acpCode, UAs.id AS uasId, UAs.code AS uasCode FROM petty_cashes PCs LEFT JOIN users ACp ON ACp.id = PCs.approved LEFT JOIN users UAs ON UAs.id = (PCs.applicant) ORDER BY IF(PCs.due_date = DATE(NOW()), 0, 1), PCs.due_date DESC, FIELD(PCs.payment_status, 'Y', 'NP', 'N') DESC, PCs.approved_date ASC LIMIT $start, $length")->fetchAll('assoc');
                //, PCs.branch_id, PCs.code, PCs.date, PCs.due_date, PCs.devision, PCs.purpose_of_advancing, PCs.applicant, PCs.approved, PCs.approved_date, PCs.knowing

                $pcaIds = Hash::extract($result, '{n}.pcaId');
                $pcaId = implode(",", $pcaIds);
                $dataPcaLine = $db->execute("SELECT PCl.id, PCl.petty_cash_id AS pclPcaId, PCl.petty_cash_no, PCl.detail_of_request, PCl.quantity, PCl.price, PCl.amount AS pclAmount, PCl.description FROM petty_cash_lines PCl WHERE PCl.petty_cash_id in ($pcaId)")->fetchAll('assoc');

                $data = array();
                foreach($result as $keyRow => $resultRow) {
                    $data[$keyRow] = $resultRow;
                    // $pettyCashLineAmount = Hash::extract($dataPcaLine, '{n}.amount');
                    // pr($dataPcaLine);
                    $dataLine = array();
                    foreach ($dataPcaLine as $resultRowLine) {
                        if($resultRowLine['pclPcaId']==$resultRow['pcaId']){

                            $dataLine[$keyRow]['pcalAmount'][] = $resultRowLine['pclAmount'];
                            // $dataLine[$keyRow]['pcaLineId'] = $resultRowLine['pclPcaId'];
                        }
                    }
                    //$data[$keyRow]['pcaLineAmount'] = $resultRowLine['pclAmount'];
                    $data[$keyRow]['pcaLineAmount'] = (empty($dataLine[$keyRow]['pcalAmount'])) ? 0: array_sum($dataLine[$keyRow]['pcalAmount']);

                }
                /**/
                //$pettyCashCode = $pettyCash->code.'/PCA/'.$dateMonth.'/'.$dateYear;
                // pr($data);
            }
            //pr($total_count);
            // pr($dataPcaLine);

            $json_data = array(
                "draw" => intval($params['draw']),
                "recordsTotal" => count($total_count),
                "recordsFiltered" => count($total_count),
                "data" => $data   // total data array
            );

            // pr($total_counts);
            // pr($data);
            return $this->response->withType("application/json")->withStringBody(json_encode($json_data));
        }
    }

    public function portalApi()
    {
        $this->autoRender=false;

        $db = ConnectionManager::get('default');

       // if ($this->request->is("ajax")) {
            // Used when ajax loads data
            $params['draw'] = $_REQUEST['draw'];
            $start = $_REQUEST['start'];
            $length = $_REQUEST['length'];
            /* If we pass any extra data in request from ajax */
            //$value1 = isset($_REQUEST['key1'])?$_REQUEST['key1']:"";

            /* Value we will get from typing in search */
            $search_value = $_REQUEST['search']['value'];

            // If we have value in search, searching by id, name, email, mobile
            if (!empty($search_value)) {
                $condWhere = " WHERE PCs.code LIKE '%" . $search_value . "%' OR PCs.purpose_of_advancing LIKE '%" . $search_value . "%' OR PCs.date LIKE '%" . $search_value . "%'";
                //$condWhere = " WHERE UAs.code LIKE '%$search_value%'";
                
            } elseif (empty($search_value)) {
                $condWhere = "";
            } else {
                $condWhere = "";
            }
            // if (!empty($search_value)) 
            // {
            //     $condWhere = " WHERE UAs.code LIKE '%$search_value%'";
            // } 
            // else 
            // {
            //     $condWhere = "";
            // }
                

            // count all data
            $total_count = $db->execute("SELECT * FROM petty_cashes PCs LEFT JOIN users ACp ON ACp.id = PCs.approved LEFT JOIN users UAs ON UAs.id = (PCs.applicant) $condWhere ORDER BY IF(PCs.due_date = DATE(NOW()), 0, 1), PCs.due_date DESC, FIELD(PCs.payment_status, 'Y', 'NP', 'N') DESC, PCs.approved_date ASC")->fetchAll('assoc');

                // $total_count = $db->execute("SELECT * FROM petty_cashes $where")->fetchAll('assoc');
            
            if(!empty($total_count)) { 
                // get per page data
                $result = $db->execute("SELECT CONCAT('<b>Kode :</b> ', IFNULL(PCs.code,''), '/', 'PCA-', IFNULL(PCs.devision,''), '/', CAST(toRoman(MONTH(PCs.date)) AS CHAR CHARACTER SET utf8), '/', IFNULL(YEAR(PCs.date),''), ' (', PCs.project ,')^<b>Tujuan Advance : </b><i>', PCs.purpose_of_advancing, '</i>^<b>Tanggal : </b>', DATE_FORMAT(PCs.date,'%d-%m-%Y'), ' | <b>Jatuh Tempo : </b>', DATE_FORMAT(PCs.due_date,'%d-%m-%Y')) AS pcaCode, CONCAT('<b>Tanggal : </b>', DATE_FORMAT(PCs.date,'%d-%m-%Y'), '^<b>Jatuh Tempo : </b>', DATE_FORMAT(PCs.due_date,'%d-%m-%Y')) AS pcaDate, DATE_FORMAT(PCs.due_date,'%d-%m-%Y') AS pcaDueDate, PCs.id AS pcaId, PCs.project AS pcaProject, CONCAT('<b>Admin :</b> ', UAs.code,'^<b>Setuju 1 :</b> ', IFNULL(DATE_FORMAT(PCs.approved_date,'%d-%m-%Y'),'-'), ' (',IFNULL(ACp.code,''),')^<b>Setuju ACC :</b> ', IFNULL(DATE_FORMAT(PCs.approved_acc_date,'%d-%m-%Y'),'-'), ' (',IFNULL(ACacc.code,''),')^<b>Setuju 2 :</b> ', IFNULL(DATE_FORMAT(PCs.approved_ceo_date,'%d-%m-%Y'),'-'),'^<b>Pembayaran :</b> ', IFNULL(DATE_FORMAT(PCs.payment_date,'%d-%m-%Y'),'-')) AS pcaProgress, PCs.approved_ceo AS pcaApprove2, DATE_FORMAT(PCs.approved_ceo_date,'%d-%m-%Y') AS pcaApproveDate2, PCs.payment AS pcaPayment, DATE_FORMAT(PCs.payment_date,'%d-%m-%Y') AS pcaPaymentDate, IFNULL(PCs.approved_ceo,'-') AS pcaApproveCeo, ACp.id AS acpId, ACp.code AS acpCode, UAs.id AS uasId, UAs.code AS uasCode, CONCAT(IFNULL(PCs.code,''), '/', 'PCA-', IFNULL(PCs.devision,''), '/', CAST(toRoman(MONTH(PCs.date)) AS CHAR CHARACTER SET utf8), '/', IFNULL(YEAR(PCs.date),''),'^',PCs.project, '^', DATE_FORMAT(PCs.date,'%d %b %Y'), '^', UAs.name, '^', PCs.devision, '^', PCs.purpose_of_advancing, '^', PCs.description) AS pcaDataModals FROM petty_cashes PCs LEFT JOIN users ACp ON ACp.id = PCs.approved LEFT JOIN users ACacc ON ACacc.id = PCs.approved_acc LEFT JOIN users UAs ON UAs.id = (PCs.applicant) $condWhere ORDER BY IF(PCs.due_date = DATE(NOW()), 0, 1), PCs.due_date DESC, FIELD(PCs.payment_status, 'Y', 'NP', 'N') DESC, PCs.approved_date ASC LIMIT $start, $length")->fetchAll('assoc');
                // $result = $db->execute("SELECT CONCAT('<b>Kode :</b> ', IFNULL(PCs.code,''), '/', 'PCA-', IFNULL(PCs.devision,''), '/', CAST(toRoman(MONTH(PCs.date)) AS CHAR CHARACTER SET utf8), '/', IFNULL(YEAR(PCs.date),''), ' (', PCs.project ,')^<b>Tujuan Advance : </b><i>', PCs.purpose_of_advancing, '</i>^<b>Tanggal : </b>', DATE_FORMAT(PCs.date,'%d-%m-%Y'), ' | <b>Jatuh Tempo : </b>', DATE_FORMAT(PCs.due_date,'%d-%m-%Y')) AS pcaCode, CONCAT('<b>Tanggal : </b>', DATE_FORMAT(PCs.date,'%d-%m-%Y'), '^<b>Jatuh Tempo : </b>', DATE_FORMAT(PCs.due_date,'%d-%m-%Y')) AS pcaDate, DATE_FORMAT(PCs.due_date,'%d-%m-%Y') AS pcaDueDate, PCs.id AS pcaId, PCs.project AS pcaProject, CONCAT('<b>Admin :</b> ', UAs.code,'^<b>Setuju 1 :</b> ', IFNULL(DATE_FORMAT(PCs.approved_date,'%d-%m-%Y'),'-'), ' (',IFNULL(ACp.code,''),')^<b>Setuju ACC :</b> ', IFNULL(DATE_FORMAT(PCs.approved_acc_date,'%d-%m-%Y'),'-'), ' (',IFNULL(ACacc.code,''),')^<b>Setuju 2 :</b> ', IFNULL(DATE_FORMAT(PCs.approved_ceo_date,'%d-%m-%Y'),'-'),'^<b>Pembayaran :</b> ', IFNULL(DATE_FORMAT(PCs.payment_date,'%d-%m-%Y'),'-')) AS pcaProgress, PCs.approved_ceo AS pcaApprove2, DATE_FORMAT(PCs.approved_ceo_date,'%d-%m-%Y') AS pcaApproveDate2, PCs.payment AS pcaPayment, DATE_FORMAT(PCs.payment_date,'%d-%m-%Y') AS pcaPaymentDate, IFNULL(PCs.approved_ceo,'-') AS pcaApproveCeo, ACp.id AS acpId, ACp.code AS acpCode, UAs.id AS uasId, UAs.code AS uasCode, CONCAT(IFNULL(PCs.code,''), '/', 'PCA-', IFNULL(PCs.devision,''), '/', CAST(toRoman(MONTH(PCs.date)) AS CHAR CHARACTER SET utf8), '/', IFNULL(YEAR(PCs.date),''),'^',PCs.project, '^', DATE_FORMAT(PCs.date,'%d %b %Y'), '^', UAs.name, '^', PCs.devision, '^', PCs.purpose_of_advancing, '^', PCs.description) AS pcaDataModals FROM petty_cashes PCs LEFT JOIN users ACp ON ACp.id = PCs.approved LEFT JOIN users ACacc ON ACacc.id = PCs.approved_acc LEFT JOIN users UAs ON UAs.id = (PCs.applicant) $condWhere ORDER BY IF(PCs.due_date = DATE(NOW()), 0, 1), PCs.due_date DESC, FIELD(PCs.payment_status, 'Y', 'NP', 'N') DESC, PCs.approved_date ASC LIMIT $start, $length")->fetchAll('assoc');
                //$result = $db->execute("SELECT CONCAT('<b>Kode :</b> ', IFNULL(PCs.code,''), '/', 'PCA-', IFNULL(PCs.devision,''), '/', CAST(toRoman(MONTH(PCs.date)) AS CHAR CHARACTER SET utf8), '/', IFNULL(YEAR(PCs.date),''), ' (', PCs.project ,')^<b>Tujuan Advance : </b><i>', PCs.purpose_of_advancing, '</i>^<b>Tanggal : </b>', DATE_FORMAT(PCs.date,'%d-%m-%Y'), ' | <b>Jatuh Tempo : </b>', DATE_FORMAT(PCs.due_date,'%d-%m-%Y')) AS pcaCode, CONCAT('<b>Tanggal : </b>', DATE_FORMAT(PCs.date,'%d-%m-%Y'), '^<b>Jatuh Tempo : </b>', DATE_FORMAT(PCs.due_date,'%d-%m-%Y')) AS pcaDate, DATE_FORMAT(PCs.due_date,'%d-%m-%Y') AS pcaDueDate, PCs.id AS pcaId, PCs.project AS pcaProject, CONCAT('<b>Admin :</b> ', UAs.code,'^<b>Setuju 1 :</b> ', IFNULL(DATE_FORMAT(PCs.approved_date,'%d-%m-%Y'),'-'), ' (',IFNULL(ACp.code,''),')^<b>Setuju 2 :</b> ', IFNULL(DATE_FORMAT(PCs.approved_ceo_date,'%d-%m-%Y'),'-'),'^<b>Pembayaran :</b> ', IFNULL(DATE_FORMAT(PCs.payment_date,'%d-%m-%Y'),'-')) AS pcaProgress, PCs.approved_ceo AS pcaApprove2, DATE_FORMAT(PCs.approved_ceo_date,'%d-%m-%Y') AS pcaApproveDate2, PCs.payment AS pcaPayment, DATE_FORMAT(PCs.payment_date,'%d-%m-%Y') AS pcaPaymentDate, IFNULL(PCs.approved_ceo,'-') AS pcaApproveCeo, ACp.id AS acpId, ACp.code AS acpCode, UAs.id AS uasId, UAs.code AS uasCode, CONCAT(IFNULL(PCs.code,''), '/', 'PCA-', IFNULL(PCs.devision,''), '/', CAST(toRoman(MONTH(PCs.date)) AS CHAR CHARACTER SET utf8), '/', IFNULL(YEAR(PCs.date),''),'^',PCs.project, '^', DATE_FORMAT(PCs.date,'%d %b %Y'), '^', UAs.name, '^', PCs.devision, '^', PCs.purpose_of_advancing, '^', PCs.description) AS pcaDataModals FROM petty_cashes PCs LEFT JOIN users ACp ON ACp.id = PCs.approved LEFT JOIN users UAs ON UAs.id = (PCs.applicant) $condWhere ORDER BY IF(PCs.due_date = DATE(NOW()), 0, 1), PCs.due_date DESC, FIELD(PCs.payment_status, 'Y', 'NP', 'N') DESC, PCs.approved_date ASC LIMIT $start, $length")->fetchAll('assoc');
                    //, PCs.branch_id, PCs.code, PCs.date, PCs.due_date, PCs.devision, PCs.purpose_of_advancing, PCs.applicant, PCs.approved, PCs.approved_date, PCs.knowing

                $pcaIds = Hash::extract($result, '{n}.pcaId');
                $pcaId = implode(",", $pcaIds);
                $dataPcaLine = $db->execute("SELECT PCl.id, PCl.petty_cash_id AS pclPcaId, PCl.petty_cash_no, PCl.detail_of_request, FORMAT(PCl.quantity, 2, 'de_DE') AS pclQty, FORMAT(PCl.price, 2, 'de_DE') AS pclPrice, PCl.amount AS pclAmount, FORMAT(PCl.quantity*PCl.price, 2, 'de_DE') AS pclAmounts, PCl.description FROM petty_cash_lines PCl WHERE PCl.petty_cash_id in ($pcaId) ORDER BY PCl.petty_cash_no ASC")->fetchAll('assoc');

                $data = array();
                foreach($result as $keyRow => $resultRow) {
                    $data[$keyRow] = $resultRow;
                    $data[$keyRow]['pcaDataModal'] = base64_encode($resultRow['pcaDataModals']);
                    //$data[$keyRow]['pcaDataModal'] = $resultRow['pcaProject'].'^'.$resultRow['pcaProject'].'^'.$resultRow['pcaProject'].'^'.$resultRow['pcaProject'].'^'.$resultRow['pcaProject'].'^'.$resultRow['pcaProject'].'^'.$resultRow['pcaProject'].'^'.$resultRow['pcaProject'].'^'.$resultRow['pcaProject'].'^'.$resultRow['pcaProject'].'^'.$resultRow['pcaProject'];
                    // $pettyCashLineAmount = Hash::extract($dataPcaLine, '{n}.amount');
                    // pr($dataPcaLine);
                    $dataLine = array();
                    foreach ($dataPcaLine as $resultRowLine) {
                        if($resultRowLine['pclPcaId']==$resultRow['pcaId']){

                            $dataLine[$keyRow]['pcalAmount'][] = $resultRowLine['pclAmount'];
                            //$dataLine[$keyRow]['pcalData'][] = base64_encode($resultRowLine['id'].'^'.$resultRowLine['detail_of_request'].'^'.$this->Krs->nom2Dec($resultRowLine['quantity']).'^'.$this->Krs->nom2Dec($resultRowLine['price']).'^'.$this->Krs->nom2Dec($resultRowLine['amount']));
                            //$dataLine[$keyRow]['pcalData'][] = base64_encode($resultRowLine['id'].'^'.$resultRowLine['detail_of_request'].'^'.$this->Krs->nom($resultRowLine['quantity']).'^'.$this->Krs->nom($resultRowLine['price']).'^'.$this->Krs->nom($resultRowLine['quantity']*$resultRowLine['price']));
                            $dataLine[$keyRow]['pcalData'][] = base64_encode($resultRowLine['id'].'^'.$resultRowLine['detail_of_request'].'^'.$resultRowLine['pclQty'].'^'.$resultRowLine['pclPrice'].'^'.$resultRowLine['pclAmounts']);


                            //$dataLine[$keyRow]['pcalData'][] = base64_encode($resultRowLine['pcaLineDatas']);
                            // PCl.id, '^', PCl.detail_of_request, '^', PCl.quantity, '^', PCl.price, '^', PCl.amount

                            //$encrypt_val=base64_encode("value");
                            // $dataLine[$keyRow]['pcalData'][][$resultRowLine['pclPcaId']] = $resultRowLine;
                            // $dataLine[$keyRow]['pcaLineId'] = $resultRowLine['pclPcaId'];
                        }
                    }
                    //$data[$keyRow]['pcaLineAmount'] = $resultRowLine['pclAmount'];
                    $data[$keyRow]['pcaLineAmount'] = (empty($dataLine[$keyRow]['pcalAmount'])) ? 0: array_sum($dataLine[$keyRow]['pcalAmount']);
                    $data[$keyRow]['pcaLineTotalAmount'] = (empty($dataLine[$keyRow]['pcalAmount'])) ? 0: $this->Krs->nom(array_sum($dataLine[$keyRow]['pcalAmount']));
                    $data[$keyRow]['pcaLineData'] = (empty($dataLine[$keyRow]['pcalAmount'])) ? array(): $dataLine[$keyRow]['pcalData'];

                }
                    /**/
                    //$pettyCashCode = $pettyCash->code.'/PCA/'.$dateMonth.'/'.$dateYear;
                    // pr($data);
                // }
                //pr($total_count);
                // pr($dataPcaLine);

                $json_data = array(
                    "draw" => intval($params['draw']),
                    "recordsTotal" => count($total_count),
                    "recordsFiltered" => count($total_count),
                    "data" => $data   // total data array
                );
            } else {
                $json_data = array(
                    "draw" => 1,
                    "recordsTotal" => 1,
                    "recordsFiltered" => 1,
                    "data" => []   // total data array
                );
            }
            // pr($total_counts);
             // pr($json_data);
            return $this->response->withType("application/json")->withStringBody(json_encode($json_data));
            
            // if (!empty($search_value)) {
            //     // If we have value in search, searching by id, name, email, mobile

            //     // count all data
            //     $total_count = $db->execute("SELECT * FROM petty_cashes WHERE id LIKE '%" . $search_value . "%' OR name like '%" . $search_value . "%' OR code like '%" . $search_value . "%' OR project like '%" . $search_value . "%'")->fetchAll('assoc');

            //     $data = $db->execute("SELECT * FROM petty_cashes WHERE id LIKE '%" . $search_value . "%' OR name like '%" . $search_value . "%' OR code like '%" . $search_value . "%' OR project like '%" . $search_value . "%' limit $start, $length")->fetchAll('assoc');
            // } else {
            //     // count all data
            //     $total_count = $db->execute("SELECT * FROM petty_cashes")->fetchAll('assoc');
                
            //     // get per page data
            //     $result = $db->execute("SELECT CONCAT('<b>Kode :</b> ', IFNULL(PCs.code,''), '/', 'PCA-', IFNULL(PCs.devision,''), '/', CAST(toRoman(MONTH(PCs.date)) AS CHAR CHARACTER SET utf8), '/', IFNULL(YEAR(PCs.date),''), ' (', PCs.project ,')^<b>Tujuan Advance : </b><i>', PCs.purpose_of_advancing, '</i>^<b>Tanggal : </b>', DATE_FORMAT(PCs.date,'%d-%m-%Y'), ' | <b>Jatuh Tempo : </b>', DATE_FORMAT(PCs.due_date,'%d-%m-%Y')) AS pcaCode, CONCAT('<b>Tanggal : </b>', DATE_FORMAT(PCs.date,'%d-%m-%Y'), '^<b>Jatuh Tempo : </b>', DATE_FORMAT(PCs.due_date,'%d-%m-%Y')) AS pcaDate, DATE_FORMAT(PCs.due_date,'%d-%m-%Y') AS pcaDueDate, PCs.id AS pcaId, PCs.project AS pcaProject, CONCAT('<b>Admin :</b> ', UAs.code,'^<b>Setuju 1 :</b> ', IFNULL(DATE_FORMAT(PCs.approved_date,'%d-%m-%Y'),'-'), ' (',IFNULL(ACp.code,''),')^<b>Setuju 2 :</b> ', IFNULL(DATE_FORMAT(PCs.approved_ceo_date,'%d-%m-%Y'),'-'),')^<b>Pembayaran :</b> ', IFNULL(DATE_FORMAT(PCs.payment_date,'%d-%m-%Y'),'-')) AS pcaProgress, PCs.approved_ceo AS pcaApprove2, DATE_FORMAT(PCs.approved_ceo_date,'%d-%m-%Y') AS pcaApproveDate2, PCs.payment AS pcaPayment, DATE_FORMAT(PCs.payment_date,'%d-%m-%Y') AS pcaPaymentDate, IFNULL(PCs.approved_ceo,'-') AS pcaApproveCeo, Acp.id AS acpId, ACp.code AS acpCode, UAs.id AS uasId, UAs.code AS uasCode FROM petty_cashes PCs LEFT JOIN users ACp ON ACp.id = PCs.approved LEFT JOIN users UAs ON UAs.id = (PCs.applicant) ORDER BY IF(PCs.due_date = DATE(NOW()), 0, 1), PCs.due_date DESC, FIELD(PCs.payment_status, 'Y', 'NP', 'N') DESC, PCs.approved_date ASC LIMIT $start, $length")->fetchAll('assoc');
            //     //, PCs.branch_id, PCs.code, PCs.date, PCs.due_date, PCs.devision, PCs.purpose_of_advancing, PCs.applicant, PCs.approved, PCs.approved_date, PCs.knowing

            //     $pcaIds = Hash::extract($result, '{n}.pcaId');
            //     $pcaId = implode(",", $pcaIds);
            //     $dataPcaLine = $db->execute("SELECT PCl.id, PCl.petty_cash_id AS pclPcaId, PCl.petty_cash_no, PCl.detail_of_request, PCl.quantity, PCl.price, PCl.amount AS pclAmount, PCl.description FROM petty_cash_lines PCl WHERE PCl.petty_cash_id in ($pcaId)")->fetchAll('assoc');

            //     $data = array();
            //     foreach($result as $keyRow => $resultRow) {
            //         $data[$keyRow] = $resultRow;
            //         // $pettyCashLineAmount = Hash::extract($dataPcaLine, '{n}.amount');
            //         // pr($dataPcaLine);
            //         $dataLine = array();
            //         foreach ($dataPcaLine as $resultRowLine) {
            //             if($resultRowLine['pclPcaId']==$resultRow['pcaId']){

            //                 $dataLine[$keyRow]['pcalAmount'][] = $resultRowLine['pclAmount'];
            //                 // $dataLine[$keyRow]['pcaLineId'] = $resultRowLine['pclPcaId'];
            //             }
            //         }
            //         //$data[$keyRow]['pcaLineAmount'] = $resultRowLine['pclAmount'];
            //         $data[$keyRow]['pcaLineAmount'] = (empty($dataLine[$keyRow]['pcalAmount'])) ? 0: array_sum($dataLine[$keyRow]['pcalAmount']);

            //     }
            //     /**/
            //     //$pettyCashCode = $pettyCash->code.'/PCA/'.$dateMonth.'/'.$dateYear;
            //     // pr($data);
            // }
            // //pr($total_count);
            // // pr($dataPcaLine);

            // $json_data = array(
            //     "draw" => intval($params['draw']),
            //     "recordsTotal" => count($total_count),
            //     "recordsFiltered" => count($total_count),
            //     "data" => $data   // total data array
            // );

            // // pr($total_counts);
            // // pr($data);
            // return $this->response->withType("application/json")->withStringBody(json_encode($json_data));
            //echo json_encode($json_data);
        //    die;
        //}
            // $page = (int)$_GET["page"];
        // $row_per_page = (int)$_GET["per_page"];
        // $page = 1;
        // $row_per_page = 10;
        
        // $pettyCashes = $this->PettyCashes->find('all')->contain(['Accept', 'UserApplicant', 'PettyCashLines'])->limit($row_per_page)->page($page)->toArray();
        // $pagging = array('page_count' => count($pettyCashes), 'current_page' => $page);
        // $dataPage = (object)$pagging;

        // pr($dataPage);
        // $json_data = array(
        //     "draw" => 1,
        //     "recordsTotal" => count($pettyCashes),
        //     "recordsFiltered" => count($pettyCashes),
        //     "page" => $page,
        //     "data" => $pettyCashes   // total data array
        // );

        // $this->viewBuilder()->setOption("serialize", $json_data);
        // return $this->response->withType("application/json")->withStringBody(json_encode($json_data));
        // pr($json_data);
        // $this->autoRender = false;
        /*$pettyCashes = $this->PettyCashes->find('all')->contain(['Accept', 'UserApplicant', 'PettyCashLines']);
        $settings = [
            'limit' => 15,
            'order' => [
                'IF(due_date = DATE(NOW()), 0, 1)',
                'due_date' => 'desc',
                "FIELD(payment_status, 'Y', 'NP', 'N') desc",
                'approved_date' => 'asc',
            ],
        ];
        $result = $this->paginate($pettyCashes, $settings);
        */
         // $pagging = array('page_count' => count($pc), 'current_page' => $page);

        /*$json_data = array(
            "draw" => 2,
            "recordsTotal" => $result->count(),
            "recordsFiltered" => $result->count(),
            "data" => $result   // total data array
        );

        // echo json_encode($json_data);

        return $this->response->withType("application/json")->withStringBody(json_encode($json_data));*/
        
        // $this->set(compact('pettyCashes'));
    }

    /**
     * View method
     *
     * @param string|null $id Petty Cash id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pettyCash = $this->PettyCashes->get($id, [
            'contain' => ['PettyCashLines'],
        ]);

        $this->set(compact('pettyCash'));
    }

    public function preview($id = null)
    {
        $pettyCash = $this->PettyCashes->get($id, [
            'contain' => ['User', 'PettyCashLines' => [
                'sort' => ['PettyCashLines.petty_cash_no' => 'ASC']
            ]],
        ]);

        $this->set(compact('pettyCash'));        
    }

    public function printing($id = null)
    {
        // $this->autoRender=false;

        $pettyCash = $this->PettyCashes->get($id, [
            'contain' => ['User', 'PettyCashLines' => [
                'sort' => ['PettyCashLines.petty_cash_no' => 'ASC']
            ]],
        ]);

        $this->set(compact('pettyCash'));
        // $this->render('print');   
        // Set the layout.
        $this->viewBuilder()->setLayout('print');
        // $this->layout = 'print';
        // $this->layout = 'print'; 
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // $sessions = $this->session->read('Auth');
        // $sessionDevision = explode(",", $this->session->devision);

        $pettyCash = $this->PettyCashes->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            
            //$this->PettyCashes->getMax(date('Y'));

            $datePCA = (empty($dataRow['dates']))? NULL:$this->Krs->dateTo($dataRow['dates']);
            $datePCAYear = substr($datePCA, 0, 4);
            $dataDevisions = $dataRow['devision'];
            //pr($dataDevisions);
            //$getMaxPCA = 0;
            $getMaxPCA = $this->PettyCashes->getMax($dataDevisions, $datePCAYear);
            $codePCA = ($dataRow['codes']==$getMaxPCA || $dataRow['codes']>$getMaxPCA) ? $dataRow['codes']:$getMaxPCA;

            $isUser = $dataRow['user_id'];
            $dataCode = array('code' => $codePCA);
            $dataDevision = array('devision' => $dataDevisions);
            $dataBranchId = array('branch_id' => 0);
            $dataUserId = array('is_create' => $isUser);
            $dataApplicant = array('applicant' => $isUser);
            $dataProject = array('project' => $dataRow['project']);

            $dataDate = array('date' => $datePCA);
            $dataDueDate = array('due_date' => (empty($dataRow['due_dates']))? NULL:$this->Krs->dateTo($dataRow['due_dates'])); 
            $dataPurpose = array('purpose_of_advancing' => $dataRow['purpose_of_advancing']);
            $dataDesc = array('description' => $dataRow['description']);
            
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add"); 
            $dataAuditLog = array('is_log' => $auditLog);
            
            // Data PettyCashLine, membenahi data agar bisa masuk ke database.
            $pettyCashLine = array();
            $key = 1;
            foreach ($dataRow['petty_cash_lines'] as $value) {
                if(!empty($value['rincian'])) {
                    $pettyCashQty = $this->Krs->nom2Dec($value['qty']);
                    $pettyCashPrice = $this->Krs->nom2Dec($value['price']);
                    $pettyCashLineAmount = $pettyCashQty*$pettyCashPrice;

                    $pettyCashLine['petty_cash_lines'][$key]['petty_cash_no'] = $key;
                    $pettyCashLine['petty_cash_lines'][$key]['is_create'] = $isUser;
                    $pettyCashLine['petty_cash_lines'][$key]['quantity'] = $pettyCashQty;
                    $pettyCashLine['petty_cash_lines'][$key]['price'] = $pettyCashPrice;
                    $pettyCashLine['petty_cash_lines'][$key]['detail_of_request'] = $value['rincian'];
                    $pettyCashLine['petty_cash_lines'][$key]['amount'] = $pettyCashLineAmount;
                    $key++;
                }
            }

            $pettyCash = $this->PettyCashes->patchEntity($pettyCash, array_merge($dataBranchId, $dataUserId, $dataApplicant, $dataAuditLog, $dataCode, $dataDate, $dataDueDate, $dataPurpose, $dataProject, $dataDevision, $dataDesc, $pettyCashLine));
            //pr($pettyCash);
            if ($this->PettyCashes->save($pettyCash, array('callbacks' => false))) {
                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                //return $this->redirect($this->referer());
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf Data gagal disimpan, Silakan coba kembali.'));
        }
        
        $pettyCash['getMaxCode'] = $this->PettyCashes->getMax($this->session->devision, date('Y'));
        
        $this->set(compact('pettyCash'));
        
    }

    /**
     * Edit method
     *
     * @param string|null $id Petty Cash id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pettyCash = $this->PettyCashes->get($id, [
            'contain' => ['PettyCashLines'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            
            $isUser = $dataRow['user_id'];
            $dataUserId = array('is_update' => $isUser);
            $dataProject = array('project' => $dataRow['project']);
            $dataDate = array('date' => (empty($dataRow['dates']))? NULL:$this->Krs->dateTo($dataRow['dates']));
            $dataDueDate = array('due_date' => (empty($dataRow['due_dates']))? NULL:$this->Krs->dateTo($dataRow['due_dates'])); 
            $dataPurpose = array('purpose_of_advancing' => $dataRow['purpose_of_advancing']);
            $dataDesc = array('description' => $dataRow['description']);
            
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id,  $isUser, "Edit"); 
            $dataAuditLog = array('is_log' => $auditLog);
            
            // Data PettyCashLine, membenahi data agar bisa masuk ke database.
            $pettyCashLine = array();
            $key = 1;
            foreach ($dataRow['petty_cash_lines'] as $value) {
                if(!empty($value['rincian'])) {
                    $pettyCashQty = $this->Krs->nom2Dec($value['qty']);
                    $pettyCashPrice = $this->Krs->nom2Dec($value['price']);
                    $pettyCashLineAmount = $pettyCashQty*$pettyCashPrice;
                    $pettyCashNo = (isset($value['petty_cash_no'])) ? $value['petty_cash_no'] : $key;

                    $pettyCashLineId = (!empty($value['id'])) ? $value['id'] : '';

                    $pettyCashLine['petty_cash_lines'][$key]['id'] = $pettyCashLineId;
                    $pettyCashLine['petty_cash_lines'][$key]['petty_cash_id'] = $id;
                    $pettyCashLine['petty_cash_lines'][$key]['petty_cash_no'] = $pettyCashNo;

                    $pettyCashLine['petty_cash_lines'][$key]['petty_cash_no'] = $key;
                    $pettyCashLine['petty_cash_lines'][$key]['is_create'] = $isUser;
                    $pettyCashLine['petty_cash_lines'][$key]['quantity'] = $pettyCashQty;
                    $pettyCashLine['petty_cash_lines'][$key]['price'] = $pettyCashPrice;
                    $pettyCashLine['petty_cash_lines'][$key]['detail_of_request'] = $value['rincian'];
                    $pettyCashLine['petty_cash_lines'][$key]['amount'] = $pettyCashLineAmount;
                    $key++;
                }
            }

            $pettyCash = $this->PettyCashes->patchEntity($pettyCash, array_merge($dataUserId, $dataAuditLog, $dataDate, $dataDueDate, $dataPurpose, $dataProject, $dataDesc, $pettyCashLine));

            // pr($dataRow);
            
            if ($this->PettyCashes->save($pettyCash, array('callbacks' => false))) {
                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf Data gagal disimpan, Silakan coba kembali.'));
        }
        $this->set(compact('pettyCash'));
    }

    public function editAll($id = null)
    {
        $pettyCash = $this->PettyCashes->get($id, [
            'contain' => ['PettyCashLines'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            
            $isUser = $dataRow['user_id'];
            $dataUserId = array('is_update' => $isUser);
            $dataProject = array('project' => $dataRow['project']);
            $dataDate = array('date' => (empty($dataRow['dates']))? NULL:$this->Krs->dateTo($dataRow['dates']));
            $dataDueDate = array('due_date' => (empty($dataRow['due_dates']))? NULL:$this->Krs->dateTo($dataRow['due_dates'])); 
            $dataPurpose = array('purpose_of_advancing' => $dataRow['purpose_of_advancing']);
            $dataDesc = array('description' => $dataRow['description']);
            
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id,  $isUser, "Edit"); 
            $dataAuditLog = array('is_log' => $auditLog);
            
            // Data PettyCashLine, membenahi data agar bisa masuk ke database.
            $pettyCashLine = array();
            $key = 1;
            foreach ($dataRow['petty_cash_lines'] as $value) {
                if(!empty($value['rincian'])) {
                    $pettyCashQty = $this->Krs->nom2Dec($value['qty']);
                    $pettyCashPrice = $this->Krs->nom2Dec($value['price']);
                    $pettyCashLineAmount = $pettyCashQty*$pettyCashPrice;
                    $pettyCashNo = (isset($value['petty_cash_no'])) ? $value['petty_cash_no'] : $key;

                    $pettyCashLineId = (!empty($value['id'])) ? $value['id'] : '';

                    $pettyCashLine['petty_cash_lines'][$key]['id'] = $pettyCashLineId;
                    $pettyCashLine['petty_cash_lines'][$key]['petty_cash_id'] = $id;
                    $pettyCashLine['petty_cash_lines'][$key]['petty_cash_no'] = $pettyCashNo;

                    $pettyCashLine['petty_cash_lines'][$key]['petty_cash_no'] = $key;
                    $pettyCashLine['petty_cash_lines'][$key]['is_create'] = $isUser;
                    $pettyCashLine['petty_cash_lines'][$key]['quantity'] = $pettyCashQty;
                    $pettyCashLine['petty_cash_lines'][$key]['price'] = $pettyCashPrice;
                    $pettyCashLine['petty_cash_lines'][$key]['detail_of_request'] = $value['rincian'];
                    $pettyCashLine['petty_cash_lines'][$key]['amount'] = $pettyCashLineAmount;
                    $key++;
                }
            }

            $pettyCash = $this->PettyCashes->patchEntity($pettyCash, array_merge($dataUserId, $dataAuditLog, $dataDate, $dataDueDate, $dataPurpose, $dataProject, $dataDesc, $pettyCashLine));
            
            if ($this->PettyCashes->save($pettyCash, array('callbacks' => false))) {
                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf Data gagal disimpan, Silakan coba kembali.'));
        }
        $this->set(compact('pettyCash'));
    }

    public function payment($id = null)
    {
        $pettyCash = $this->PettyCashes->get($id, [
            'contain' => ['PettyCashLines'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            
             $isUser = $dataRow['user_id'];
            $dataPaymentDates = (empty($dataRow['payment_dates'])) ? NULL:$this->Krs->dateTo($dataRow['payment_dates']);
            $toBePaid = $dataRow['payments'];
            $paymentLast = $this->Krs->nom2Dec($dataRow['payment_lasts']);
            $paymentNow = $this->Krs->nom2Dec($dataRow['payment_nominals']);

            $paymentTotal = $toBePaid-$paymentNow-$paymentLast;
            $paymentDifference = $paymentNow+$paymentLast;
            $paymentStatus = '';

            if($paymentTotal<0) {
                $payment = $toBePaid;
                $paymentStatus = 'Y';
            } elseif($paymentTotal==0 || $paymentNow==$toBePaid) {
                $payment = $toBePaid;
                $paymentStatus = 'Y';
            } else {
                if($paymentDifference <= $toBePaid) {
                    $payment = $paymentDifference;
                    $paymentStatus = 'NP';
                } else {
                    $payment = $paymentDifference;
                    $paymentStatus = 'NP';
                }
            }
            
            $dataUserId = array('is_update' => $isUser);
            
            $dataPayment = array('payment' => $isUser);
            $dataPaymentType = array('payment_type' => $dataRow['payment_type']);            
            $dataDate = array('payment_date' => $dataPaymentDates);
            $dataDesc = array('payment_desc' => $dataRow['payment_desc']);
            $dataNominal = array('payment_nominal' => $payment);
            $dataDateNow = array('payment_date_now' => $this->Krs->dateNow());
            $dataStatus = array('payment_status' => $paymentStatus);

            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id,  $isUser, "Payment"); 
            $dataAuditLog = array('is_log' => $auditLog);
            
            $pettyCash = $this->PettyCashes->patchEntity($pettyCash, array_merge($dataUserId, $dataAuditLog, $dataPaymentType, $dataPayment, $dataDate, $dataDesc, $dataNominal, $dataDateNow, $dataStatus));

            if ($this->PettyCashes->save($pettyCash, array('callbacks' => false))) {
                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf Data gagal disimpan, Silakan coba kembali.'));
        }
        $this->set(compact('pettyCash'));
    }

    public function approve($id = null)
    {
        $pettyCash = $this->PettyCashes->get($id, [
            'contain' => ['PettyCashLines'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            
            $isUser = $dataRow['user_id'];
            $dataUserId = array('is_update' => $isUser);
            $dataProject = array('project' => $dataRow['project']);
            $dataApproved = array('approved' => $dataRow['approved']);
            $dataApprovedDate = array('approved_date' => $this->Krs->dateNow());
            $dataDate = array('date' => (empty($dataRow['dates']))? NULL:$this->Krs->dateTo($dataRow['dates']));
            $dataDueDate = array('due_date' => (empty($dataRow['due_dates']))? NULL:$this->Krs->dateTo($dataRow['due_dates'])); 
            $dataPurpose = array('purpose_of_advancing' => $dataRow['purpose_of_advancing']);
            $dataDesc = array('description' => $dataRow['description']);
            
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id,  $isUser, "Edit"); 
            $dataAuditLog = array('is_log' => $auditLog);
            
            // Data PettyCashLine, membenahi data agar bisa masuk ke database.
            $pettyCashLine = array();
            $key = 1;
            foreach ($dataRow['petty_cash_lines'] as $value) {
                if(!empty($value['rincian'])) {
                    $pettyCashQty = $this->Krs->nom2Dec($value['qty']);
                    $pettyCashPrice = $this->Krs->nom2Dec($value['price']);
                    $pettyCashLineAmount = $pettyCashQty*$pettyCashPrice;
                    $pettyCashNo = (isset($value['petty_cash_no'])) ? $value['petty_cash_no'] : $key;

                    $pettyCashLineId = (!empty($value['id'])) ? $value['id'] : '';

                    $pettyCashLine['petty_cash_lines'][$key]['id'] = $pettyCashLineId;
                    $pettyCashLine['petty_cash_lines'][$key]['petty_cash_id'] = $id;
                    $pettyCashLine['petty_cash_lines'][$key]['petty_cash_no'] = $pettyCashNo;

                    $pettyCashLine['petty_cash_lines'][$key]['petty_cash_no'] = $key;
                    $pettyCashLine['petty_cash_lines'][$key]['is_create'] = $isUser;
                    $pettyCashLine['petty_cash_lines'][$key]['quantity'] = $pettyCashQty;
                    $pettyCashLine['petty_cash_lines'][$key]['price'] = $pettyCashPrice;
                    $pettyCashLine['petty_cash_lines'][$key]['detail_of_request'] = $value['rincian'];
                    $pettyCashLine['petty_cash_lines'][$key]['amount'] = $pettyCashLineAmount;
                    $key++;
                }
            }

            $pettyCash = $this->PettyCashes->patchEntity($pettyCash, array_merge($dataUserId, $dataAuditLog, $dataDate, $dataDueDate, $dataPurpose, $dataProject, $dataApproved, $dataApprovedDate, $dataDesc, $pettyCashLine));
            
            if ($this->PettyCashes->save($pettyCash, array('callbacks' => false))) {
                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf Data gagal disimpan, Silakan coba kembali.'));
        }
        $this->set(compact('pettyCash'));
    }

    public function approveCeo()
    {
        // $dataKeyAll = $this->request->getQueryParams();
        $this->autoRender=false;

        // $dataKeyAll = $this->request->getQueryParams();
        // $getSearch = $this->request->getQuery('search');
        $getLink = $this->request->getQuery();

        $dataRow = $this->request->getData();
        
        $id = (empty($dataRow)) ? $getLink['id'] : $dataRow['id'];
        $status = (empty($dataRow)) ? $getLink['status'] : $dataRow['status'];
        $userId = (empty($dataRow)) ? $getLink['userId'] : $dataRow['userId'];
        // pr($status);
        if (!empty($id) && !empty($status)) {
            $dataApprovedCeo = ($status=='Y') ? $userId : NULL;
            $dataApprovedCeoDate = ($status=='Y') ? date("Y-m-d H:i:s"): NULL;

            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id, $userId, "Edit"); 

            // $auditLog = $this->KrsCom->auditLog("PettyCash", $id, $this->params['controller'], $dataApprovedCeo, "approve ceo");
            // pr(array('approved_ceo' => $dataApprovedCeo, 'approved_ceo_date' => $dataApprovedCeoDate, 'is_log' => $auditLog));
            // $result = "";
            //pr($dataApprovedCeo.$dataApprovedCeoDate);
            $this->PettyCashes->updateAll(['approved_ceo' => $dataApprovedCeo, 'approved_ceo_date' => $dataApprovedCeoDate, 'is_log' => $auditLog], ['id' => $id]);

            $row = $this->PettyCashes->find()
                        ->select(['PettyCashes.approved_ceo', 'PettyCashes.approved_ceo_date'])
                        ->where(['PettyCashes.id'=>$id])
                        ->toArray();

            if(empty($row[0]->approved_ceo)){
                $dataRow = "N^";
            } else {
                $dataRow = "Y^".$this->Krs->fDate($row[0]->approved_ceo_date, 'd-m-Y');
            }
            // pr($this->Krs->fDate($row[0]->approved_ceo_date, 'd-m-Y'));

            $result = $dataRow;
        } 
        else
        {
            $result = "errors";
        }
        
        return $this->response->withType("application/json")->withStringBody(json_encode($result));

        // $this->viewBuilder()->setOption("serialize", $result);

        // $response = array('status' => $result);
        // return json_encode($response);

        // return $result;

        // $this->response->type('json');
        // $this->response->body($result);
        // return $this->response;

        // $this->response->body(json_encode($result));
        // return $this->response;
        
    }

    public function excel()
    {
        ini_set('memory_limit', '2048M');

        $session = $this->getRequest()->getSession(); //get session
        $dataLinks = $session->read('dataLinks');
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'Kode');
        $sheet->setCellValue('B1', 'Tujuan');
        $sheet->setCellValue('C1', 'Tanggal Buat');
        $sheet->setCellValue('D1', 'Tanggal Jatuh Tempo');
        $sheet->setCellValue('E1', 'Nominal');
        $sheet->setCellValue('F1', 'Status');

        $row = 1;
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }


        $report = $this->PettyCashes->find('all')->contain('PettyCashLines')->where([$dataLinks])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $dataDate = $data->date;
            $dateYear = (empty($dataDate)) ? '' : $this->Krs->fDate($dataDate, 'Y');
            $dateMonth = (empty($dataDate)) ? '' : $this->Krs->numToRome($this->Krs->fDate($dataDate, 'n'));
            $pettyCashCode = $data->code.'/PCA-NSI'.'/'.$dateMonth.'/'.$dateYear;

            $pettyCashLine = $data->petty_cash_lines;
            $pettyCashLineAmount = Hash::extract($pettyCashLine, '{n}.amount');
            $pettyCashLineAmountTotal = (empty($pettyCashLineAmount)) ? '': array_sum($pettyCashLineAmount);
            $pettyCashLineAmountTotalNominal = ($pettyCashLineAmountTotal=='') ? '': $this->Krs->_currency($pettyCashLineAmountTotal);
            // $dataNominal = $this->Krs->_currency($pettyCashLine->amount);

            $sheet->setCellValue('A' . $row, $pettyCashCode);
            $sheet->setCellValue('B' . $row, (!empty($data->purpose_of_advancing) ? $data->purpose_of_advancing : '-'));
            $sheet->setCellValue('C' . $row, $this->Krs->fDate($data->date, 'd-m-Y'));
            $sheet->setCellValue('D' . $row, $this->Krs->fDate($data->due_date, 'd-m-Y')); 
            $sheet->setCellValue('E' . $row, $pettyCashLineAmountTotalNominal);
            $sheet->setCellValue('F' . $row, $this->Krs->fPayment($data->payment_status));
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Petty Cash - ' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }

    /**
     * Delete method
     *
     * @param string|null $id Petty Cash id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pettyCash = $this->PettyCashes->get($id);
        if ($this->PettyCashes->delete($pettyCash)) {
            $this->Flash->success(__('The petty cash has been deleted.'));
        } else {
            $this->Flash->error(__('The petty cash could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
