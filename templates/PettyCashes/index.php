<head>
    <style>
    .custom-thead-dark {
        background-color: #343a40; /* Warna hitam atau warna gelap */
        color: white; /* Warna teks putih untuk kontras */
    }

    .fas.fa-dollar-sign {
        font-size: 15px; /* Sesuaikan ukuran font untuk lebar ikon */
    }

    .btn-purple {
        padding-left: 13px;
        padding-right: 13px;
        padding-top: 5px;
        padding-bottom: 5px;
    }

</style>
</head>

<?php
//pr($PettyChashes);

use Cake\Utility\Hash;

$cross = '<i class="fa fa-times"></i>';
$tick = '<i class="fa fa-check"></i>';
$hourglass = '<i class="fa fa-hourglass-half"></i>';
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cor[]|\Cake\Collection\CollectionInterface $cors
 */
?>

<?= $this->Krs->breadcrumb_('Keuangan', 'Petty Cash') ?>

<div class="panel">
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Krs->addButton(); ?> 
                        <?= $this->Krs->downloadButton(); ?> 
                    </div>
                </div>
            </div>
            <br>

            <?= $this->Form->create(null, ['type' => 'post']) ?>
            <div class="panel-body bg-info">
                <div class="row">
                    <div class="col-md-2">
                        <?php
                            echo $this->Form->input('filterCode', array('class' => 'form-control', 'id' => 'maxlength_defaultconfig', 'required' => false, 'placeholder'=>'Kode..', 'value'=>$dataLink['filterCode']));
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                            echo $this->Form->input('filterAdvance', array('class' => 'form-control', 'id' => 'maxlength_defaultconfig', 'required' => false, 'placeholder'=>'Tujuan..', 'empty'=>true, 'value'=>$dataLink['filterAdvance']));
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php
                        echo $this->Krs->inputDateRange('filterDateFrom', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tgl Buat...', 'value'=>$dataLink['filterDateFrom']), 'filterDateEnd', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tgl Buat...', 'value'=>$dataLink['filterDateEnd']), 's/d', 'resetDate');
                        ?>
                    </div>
                    <div class="col-md-2">
                        <?php
                        echo $this->Form->input('filterPayment', ['empty'=>true, 'options'=>$this->Krs->fPayment(), 'data-placeholder'=>'Aktif..', 'class'=>'form-control select2Form', 'type'=>'select', 'default'=>$dataLink['filterPayment']]);
                        ?>
                    </div>
                    <div class="col-md-1">
                        <div class="btn-group w-100">
                            <?php
                            echo $this->Form->button('<i class="fas fa-search"></i>', array('class'=>'btn btn-warning width-60 m-r-10', 'type'=>'submit', 'id'=> 'btnSearch', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Cari"));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle">
                    <thead class="custom-thead-dark text-center">
                        <tr>
                            <th width="200">Kode</th>
                            <th colspan="5">Tujuan Advance</th>
                            <th width="80">Admin</th>
                            <th>Pertanggung jawaban</th>
                        </tr>
                        <tr>
                            <th>&nbsp;</th>
                            <th width="120">Tanggal</th>
                            <th width="120">Jatuh Tempo</th>
                            <th width="120">Jumlah Petty Cash</th>
                            <th width="120">Jumlah Dibayar</th>
                            <th width="120">Setuju 1</th>
                            <th width="150">Setuju 2</th>
                            <th width="120">Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // pr($pettyCashes);
                        $trcount = 0;
                        foreach ($pettyCashes as $pettyCash) {
                            // pr($pettyCash);
                            $user_applicant = $pettyCash->user_applicant;
                            $pettyCashLine = $pettyCash->petty_cash_lines;

                            // pr($pettyCash->user_applicant);
                            $linkPreview = array('action' => 'preview', $pettyCash->id);
                            $linkEdit = array('action' => 'edit', $pettyCash->id);
                            $linkEditAdmin = array('action' => 'edit_admin', $pettyCash->id);
                            $linkDelete = array('action' => 'delete', $pettyCash->id);
                            $pettyCashName = $pettyCash->title.' '.$pettyCash->name;
                            $pettyCashPurpose = $pettyCash->purpose_of_advancing;
                            $userCode = $user_applicant->code;
                            $pettyCashPaymentDescs = (empty($pettyCash->payment_desc)) ? '-' : $pettyCash->payment_desc;
                            $pettyCashPayment = $pettyCash->payment_nominal;

                            // pr($pettyCashLine);
                            $pettyCashLineAmount = Hash::extract($pettyCashLine, '{n}.amount');
                            $pettyCashProject = (empty($pettyCash->project)) ? "" : " (".$this->Krs->projectStatus($pettyCash->project).")";
                            // $pettyCashLineAmount = Set::classicExtract($pettyCashLine, '{n}.amount');
                            $pettyCashLineAmountTotal = (empty($pettyCashLineAmount)) ? '': array_sum($pettyCashLineAmount);
                            $pettyCashLineAmountTotalNominal = ($pettyCashLineAmountTotal=='') ? '': $this->Krs->cur($pettyCashLineAmountTotal);
                            $pettyCashLinePaymentNominal = ($pettyCashPayment=='') ? '': $this->Krs->cur($pettyCashPayment);
                            // $pettyCashLineAmountTotal = 0;
                            // $pettyCashLinePaymentNominal = 0;
                            // $pettyCashLineAmountTotalNominal = 0;
                            // $pettyCashLineAmountTotal = 0;
                            //pr($pettyCashLineAmount);

                            $pettyCashDate = (empty($pettyCash->date)) ? '-' : $this->Krs->fDate($pettyCash->date, 'd-m-Y');
                            $pettyCashDueDate = (empty($pettyCash->due_date)) ? '-' : $this->Krs->fDate($pettyCash->due_date, 'd-m-Y');
                            $pettyCashApprovedDate = (empty($pettyCash->approved_date)) ? $cross : $this->Krs->fDate($pettyCash->approved_date, 'd-m-Y');
                            $pettyCashPaymentDate = (empty($pettyCash->payment_date)) ? '-' : $this->Krs->fDate($pettyCash->payment_date, 'd-m-Y');
                            $pettyCashApprovedCeoDate = (empty($pettyCash->approved_ceo_date)) ? '' : $this->Krs->fDate($pettyCash->approved_ceo_date, 'd-m-Y');
                            $pettyCashAccountabilityDates = (empty($pettyCash->accountability_date)) ? '-' : $this->Krs->fDate($pettyCash->accountability_date, 'd-m-Y');
                            $dateMonth = $this->Krs->numToRome($this->Krs->fDate($pettyCash->date, 'n'));
                            // pr($dateMonth);
                            $dateYear = $this->Krs->fDate($pettyCash->date, 'Y');

                            $pettyCashCode = $pettyCash->code.'/PCA-NSI/'.$dateMonth.'/'.$dateYear;


                            $pettyCashId = $pettyCash['id'];
                            $pettyCashPayment = $pettyCash->payment_nominal;
                            //$pettyCashName = $pettyCash['name'];


                            $pettyCashDevision = $pettyCash->devision;
                            $pettyCashPurpose = $pettyCash->purpose_of_advancing;
                            $pettyCashApplicant = $pettyCash->applicant;
                            $pettyCashApproved = $pettyCash->approved;
                            $statusApprove = $getUser->approved;
                            $statusApproveCeo = $getUser->approved_ceo;
                            $statusPayment = $getUser->payment;

                            $accept = $pettyCash->accept;
                            $approvedCode = (!empty($accept['code'])) ? ' ('.$accept['code'].')' : '';

                            // $statusApprove = $getUser->pettycash_full_access;
                            // $statusApprove = $getUser->approved;
                            // $statusDevision = $getUser->statusDevision;

                            $pettyCashPaymentStatus = $pettyCash->payment_status;


                            $pettyCashPaymentDescs = (empty($pettyCash->payment_desc)) ? '-' : $pettyCash->payment_desc;

                            $pettyCashApprovedCeo = $pettyCash->approved_ceo;

                            $statusApproves = (!empty($pettyCashApproved)) ? '<b><i>'.$pettyCashApprovedDate.'</i></b>' : $cross;

                            $pettyCashAccountabilityDate = $pettyCash->accountability_date;

                            $statusHiddenActive = ($pettyCash->is_active=='Y') ? "": ' style="display: none;"';
                            $statusHiddenInactive = ($pettyCash->is_active=='N') ? "": ' style="display: none;"';
                            $btnActive = "<div id='statusSpin".$pettyCash->id."'></div>";
                            $btnActive .= "<div id='statusActive".$pettyCash->id."'".$statusHiddenActive.">".$this->Html->link('<i class="fa fa-check"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatusActive('".$pettyCash->id."', 'N', '".$getUser->id."')", "class"=>"btn btn-lime btn-icon btn-circle btn-sm"))."</div>";

                            $btnActive .= "<div id='statusInactive".$pettyCash->id."'".$statusHiddenInactive.">".$this->Html->link('<i class="fa fa-times"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatusInactive('".$pettyCash->id."', 'Y', '".$getUser->id."')", "class"=>"btn btn-danger btn-icon btn-circle btn-sm"))."</div>";
                            //$pettyCash->has('branch') ? $this->Html->link($pettyCash->branch->name, ['controller' => 'Branches', 'action' => 'view', $pettyCash->branch->id]) : ''

                            $actions = '';
                            if(empty($pettyCashApproved) && $statusApprove=='Y') {
                                $actions .= $this->Html->link('<i class="fas fa-check"></i>', array('controller' => 'petty_cashes', 'action' => 'approve/'.$pettyCashId, 'full_base'=>true), array('class' => 'btn btn-sm btn-lime p-l-15 p-r-15 m-r-5', 'escape' => false, 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Approve -'.$pettyCashCode));
                                $actions .= '&nbsp;';
                            }

                            if(!empty($pettyCashApprovedCeo) && $pettyCashPaymentStatus!='Y' && $statusPayment=='Y') {
                                $actions .= $this->Html->link('<i class="fas fa-dollar-sign"></i>', array('controller' => 'petty_cashes', 'action' => 'payment/'.$pettyCashId, 'full_base'=>true), array('class' => 'btn btn-sm btn-purple p-l-15 p-r-15 m-r-5', 'escape' => false, 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Pembayaran -'.$pettyCashCode));
                                $actions .= '&nbsp;';

                            }

                            // if(empty($pettyCashApproved) || $statusApprove=='Y' || $statusPayment=='Y' || !empty($pettyCashApprovedCeo)) {

                            //     $actions .= $this->Html->link('<i class="fas fa-cogs"></i>', array('controller' => 'petty_cashes', 'action' => 'edit_all/'.$pettyCashId, 'full_base'=>true), array('class' => 'btn btn-sm btn-info p-l-15 p-r-15 m-r-5', 'escape' => false, 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ubah-- -'.$pettyCashCode));
                            // $actions .= '&nbsp;';

                            // }

                            //pr($statusPayment);
                            // if(!empty($pettyCashApprovedCeo) && $pettyCashPaymentStatus=='Y' && $statusPayment=='Y' && empty($pettyCashAccountabilityDate)) {

                            //     $actions .= $this->Html->link('<i class="fas fa-users"></i>', array('controller' => 'petty_cashes', 'action' => 'accountability/'.$pettyCashId, 'full_base'=>true), array('class' => 'btn btn-sm btn-orange m-r-5 p-l-15 p-r-15', 'escape' => false, 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Pertanggungjawaban-- -'.$pettyCashCode));
                            //     $actions .= '&nbsp;';

                            // }

                            if(empty($pettyCashApproved) && empty($pettyCashApprovedCeo)) {
                                $actions .= $this->Html->link('<i class="fas fa-pencil-alt"></i>', array('controller' => 'petty_cashes', 'action' => 'edit/'.$pettyCashId, 'full_base'=>true), array('class' => 'btn btn-sm btn-info m-r-5 p-l-15 p-r-15', 'escape' => false, 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ubah -'.$pettyCashCode));
                                $actions .= '&nbsp;';
                            }

                            if($statusApproveCeo=='Y') {
                                $dataStatusApproveCeo = empty($pettyCashApprovedCeo)? 'N':'Y';

                                $statusHiddenActive = ($dataStatusApproveCeo=='Y') ? "": ' style="display: none;"';
                                $statusHiddenInactive = ($dataStatusApproveCeo=='N') ? "": ' style="display: none;"';

                                $statusApproveCeos = "<div id='statusSpin".$pettyCashId."'></div>";
                                $statusApproveCeos .= "<div id='statusActive".$pettyCashId."'".$statusHiddenActive.">".$this->Html->link('<i class="fa fa-check"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatusActive('".$pettyCashId."', 'N', '".$getUser->id."')", "class"=>"btn btn-lime btn-icon btn-circle btn-sm"))."</div>";

                                $statusApproveCeos .= "<div id='statusInactive".$pettyCashId."'".$statusHiddenInactive.">".$this->Html->link('<i class="fa fa-times"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatusInactive('".$pettyCashId."', 'Y', '".$getUser->id."')", "class"=>"btn btn-danger btn-icon btn-circle btn-sm"))."</div>";

                                $statusApproveCeos .= "<div id='statusDateApprovedCeo".$pettyCashId."'><b><i> ".$pettyCashApprovedCeoDate."</i></b></div>";
                            } else {
                                $statusApproveCeos = (!empty($pettyCashApprovedCeo)) ? '<b><i>'.$pettyCashApprovedCeoDate.'</i></b>' : $cross;
                            }
                            
                            if($pettyCashPaymentStatus==='Y') {
                                $statusPaymentStatus = $tick.' ('.$pettyCashPaymentDate.')';
                            } elseif($pettyCashPaymentStatus==='NP') {
                                $statusPaymentStatus = $hourglass.' ('.$pettyCashPaymentDate.')';
                            } else {
                                $statusPaymentStatus = $cross;
                            }

                            if($pettyCashPaymentStatus==='Y') {
                                $class = ' class="table-success"';
                            } else {
                                $odd=$trcount%2;
                                if($odd==1){
                                    $class = ' class="table-warning"';
                                } else {
                                    $class = '';
                                }
                            }

                            //$actions .= $this->Krs->btnPreview($pettyCashId, $pettyCashCode);
                            $actions .= $this->Krs->btn('preview', $linkPreview, $pettyCashId);
                            //$this->Krs->btn('preview', $linkPreview, $supplier->id);
                            //'.$class.'
                            echo '<tr'.$class.'>
                                    <td align="center"><b>'.$pettyCashCode.'</b></td>
                                    <td align="left" colspan="5"><b><i>'.$pettyCashPurpose.'</i></b></td>
                                    <td align="center">'.$userCode.'</td>
                                    <td align="center">'.$pettyCashPaymentDescs.'</td>
                                </tr>
                                <tr'.$class.'>
                                    <td class="with-btn" nowrap>'.$actions.'</td>
                                    <td align="center">'.$pettyCashDate.'</td>
                                    <td align="center">'.$pettyCashDueDate.'</td>
                                    <td align="right">'.$pettyCashLineAmountTotalNominal.'</td>
                                    <td align="right">'.$pettyCashLinePaymentNominal.'</td>
                                    <td align="center">'.$statusApproves.'<br>'.$approvedCode.'</td>
                                    <td align="center"><div class="btn-group">'.$statusApproveCeos.'</div></td>
                                    <td align="center">'.$statusPaymentStatus.'</td>
                                </tr>';

                        $trcount++;
                        } ?>
                    </tbody>
                </table>
                <!-- #modal-dialog -->
                <!-- <div class="modal fade" tabindex="-1" role="dialog" id="modal-detail"></div> -->
            </div>

            <?= $this->Krs->paginators() ?>
        </div>
    </div>
</div>



<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<?php
$urlGetData = $this->Url->build(['controller' => 'petty_cashes', 'action' => 'preview', '_full'=>true]);
$urlStatusData = $this->Url->build(['controller' => 'petty_cashes', 'action' => 'approve_ceo', '_full'=>true]);
?>
<script>
function changeStatusActive(dataId, dataStatus, dataUserId) {
    if (!$('#statusActive'+dataId).attr('complete')) {
        $('#statusSpin'+dataId).html('<i class="fas fa-spinner fa-pulse fa-fw"></i>').show();
        $('#statusActive'+dataId).hide();
    }

    if(dataId.length != 0) {
        $.ajax({
            type: 'POST', // Metode pengiriman data menggunakan POST
            url: '<?php echo $urlStatusData; ?>', // File pemroses data
            data: {
                id:dataId, status:dataStatus, userId:dataUserId
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
            },
            //Data yang akan dikirim ke file pemroses
            cache: false,
            async: true,
            // processData: false,
            // contentType: false,
            success: function(response) {
                var res = response.split("^");

                if(res[0]=='Y') {
                    $('#statusActive'+dataId).show();
                    //$('#statusDateApprovedCeo'+status).hide();
                    $('#statusDateApprovedCeo'+dataId).html("<b><i>"+ res[1] + "</i></b>").show();
                }
                if(res[0]=='N') {
                    $('#statusInactive'+dataId).show();
                    $('#statusDateApprovedCeo'+dataId).hide();
                }

                $('#statusSpin'+dataId).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
            },
            error: function() {
                // alert('gagal');
                $('#statusSpin'+dataId).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
                console.log('error');
            }
            // success: function(response) { // Jika berhasil
            //     alert(response);
                // if(response=='Y') {
                //     $('#statusActive'+dataId).show();
                // }
                // if(response=='N') {
                //     $('#statusInactive'+dataId).show();
                // }
                // $('#statusSpin'+dataId).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
            // }
        });
    } else {
        $('#statusSpin'+dataId).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
    }
}

function changeStatusInactive(dataId, dataStatus, dataUserId) {
    if (!$('#statusInactive'+dataId).attr('complete')) {
        $('#statusSpin'+dataId).html('<i class="fas fa-spinner fa-pulse fa-fw"></i>').show();
        $('#statusInactive'+dataId).hide();
    }

    if(dataId.length != 0) {
        $.ajax({
            type: 'POST', // Metode pengiriman data menggunakan POST
            url: '<?php echo $urlStatusData; ?>', // File pemroses data
            data: {
                id:dataId, status:dataStatus, userId:dataUserId
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
            },
            //Data yang akan dikirim ke file pemroses
            cache: false,
            async: true,
            // processData: false,
            // contentType: false,
            success: function(response) {
                var res = response.split("^");

                if(res[0]=='Y') {
                    $('#statusActive'+dataId).show();
                    $('#statusDateApprovedCeo'+dataId).html("<b><i>"+ res[1] + "</i></b>").show();
                    //alert(res[1]);
                }
                if(res[0]=='N') {
                    $('#statusInactive'+dataId).show();
                    $('#statusDateApprovedCeo'+dataId).hide();
                    //$('#statusDateApprovedCeo'+dataId).html("<b><i>"+ res[1] + "</i></b>").show();
                }
                $('#statusSpin'+dataId).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
            },
            error: function() {
                // alert('gagal');
                $('#statusSpin'+dataId).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
                console.log('error');
            }
        });
    } else {
        $('#statusSpin'+dataId).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
    }

}

$(document).ready(function() {
    handleDateRange('date-picker', 'resetDate', 'filterDate', 'dd-mm-yyyy');
    handleDateRange('date-picker1', 'resetDate1', 'filterDate1', 'dd-mm-yyyy');
    handleDateRange('date-picker2', 'resetDate2', 'filterDate2', 'dd-mm-yyyy');

    $(".select2Form").select2({ allowClear: true });

    <?php
    foreach ($pettyCashes as $pettyCash) {
    echo 'handleFormPreview("btn-preview'.$pettyCash->id.'", "'.$urlGetData.'/'.$pettyCash->id.'");';
    }
    ?>

});
</script>