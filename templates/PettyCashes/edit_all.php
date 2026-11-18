<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PettyCash $pettyCash
 */
use Cake\Utility\Hash;

$dataChild = $this->Html->link('Petty Cash', ['action' => 'index'], ['full_base'=>true]);

// pr($pettyCash);
$pettyCashLine = $pettyCash->petty_cash_lines;
$pettyCashDevision = $pettyCash->devision;
$dateYear = $this->Krs->fDate($pettyCash->date, 'Y');
$dateMonth = $this->Krs->numToRome($this->Krs->fDate($pettyCash->date, 'n'));
$dataCodeTitle = 'PCA-'.$pettyCashDevision.'/'.$dateMonth.'/'.$dateYear;
$dataDate = (empty($pettyCash->date)) ? '' : $this->Krs->fDate($pettyCash->date, 'd-m-Y');
$dataDueDate = (empty($pettyCash->due_date)) ? '' : $this->Krs->fDate($pettyCash->due_date, 'd-m-Y');
$pettyCashLineData = Hash::combine($pettyCashLine, '{n}.petty_cash_no', ['%s^%s^%s^%s^%s^%s^%s', '{n}.id', '{n}.petty_cash_id', '{n}.petty_cash_no', '{n}.detail_of_request', '{n}.quantity', '{n}.price', '{n}.amount']);

// pr($pettyCashLineData);
?>
<?= $this->Krs->breadcrumb('Data', $dataChild, 'Ubah--') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Perincian</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>

    <?= $this->Form->create($pettyCash) ?>
    <?php // nav-tabs-inverse ?>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>No</label>
                    <div class="input-group m-b-10">
                        <?php
                        echo $this->Form->input('codes', ['class' => 'form-control', 'placeholder'=>'No..', 'value'=>$pettyCash->code, 'readonly'=>true]); 
                        echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                        ?>
                        <span class="input-group-append">
                            <span class="input-group-text"><?= $dataCodeTitle ?></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Proyek</label>                        
                    <div class="input-group">
                    <?php
                    echo $this->Form->input('project', ['empty'=>false, 'options'=>$this->Krs->projectStatus(), 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'type'=>'select']);
                    //echo $this->Form->input('type', ['label' => 'Jenis', 'empty'=>false, 'options'=>$this->Krs->typePca(), 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form']);
                    ?>
                 </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tanggal</label>                        
                    <div class="input-group" id="default-daterange">
                        <?php
                        echo $this->Form->input('dates', array('id' => 'datepicker-autoClose', 'error' => false, 'class'=>'form-control', 'placeholder' => 'Tanggal..', 'value'=>$dataDate));
                        ?>
                        <span class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Jatuh Tempo</label>
                    <div class="input-group" id="default-daterange">
                        <?php
                        echo $this->Form->input('due_dates', array('id' => 'datepicker-autoClose1', 'error' => false, 'class'=>'form-control', 'placeholder' => 'Tanggal..', 'value'=>$dataDueDate));
                        ?>
                        <span class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
             <?php
            echo $this->Form->control('purpose_of_advancing', array('label' => 'Tujuan Advance', 'class' => 'form-control', 'error' => false, 'placeholder' => 'Tujuan Advance..'));
            ?>
        </div>
        <div class="form-group">
            <?php
            echo $this->Form->control('description', array('label' => 'Keterangan', 'type'=>'textarea', 'rows' => '6', 'cols'=>'75', 'class'=>'form-control', 'placeholder' => 'Keterangan'));
            ?>
        </div> 
        <div class="table-responsive">
            <table class="table m-b-0 table-advance">
            <tr class="sum">
                <td>
                    <table cellpadding="0" class="adminlist" cellspacing="0" border="0" id="myTable" width="100%">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>Rincian Permohonan</th>
                                <th width="100">Jumlah</th>
                                <th width="150">Harga</th>
                                <th width="150">Total</th>
                                <th width="30"></th>
                            </tr>
                        </thead>
                            
                        <tbody>
                            <?php 
                            $countDataLine = count($pettyCashLine);
                            $amountNominals = array();

                            // pr($pettyCashLineData);
                            //$pettyCashLineData = Hash::combine($pettyCashLine, '{n}.petty_cash_no', ['%s^%s^%s^%s^%s^%s^%s', '{n}.id', '{n}.petty_cash_id', '{n}.petty_cash_no', '{n}.detail_of_request', '{n}.quantity', '{n}.price', '{n}.amount']);


                            for ($a=1; $a <= $countDataLine; $a++) {
                                //pr($a.' - '.$pettyCashLineData[$a]);
                                list($idCashLine, $idPettyCashLine, $noCashLine, $petition, $qty, $price, $amount) = explode("^", $pettyCashLineData[$a]);
                                $amountNominal = ($amount==0 || empty($amount)) ? 0 : $this->Krs->nom($amount);
                                $amountNominals[] = $amount;
                            ?>
                            <tr>
                                <td>
                                    <?php 
                                    echo $this->Form->input('petty_cash_lines.'.$a.'.id', array('type' => 'hidden', 'value'=>$idCashLine));
                                    echo $this->Form->input('petty_cash_lines.'.$a.'.petty_cash_id', array('type' => 'hidden', 'value'=>$idPettyCashLine));
                                    echo $this->Form->input('petty_cash_lines.'.$a.'.petty_cash_no', array('type' => 'hidden', 'value'=>$noCashLine));
                                    echo $this->Form->input('petty_cash_lines.'.$a.'.rincian', array('autocomplete'=>'off', 'class' => 'form-control', 'value'=>$petition)); ?>
                                </td>
                                <td>
                                    <?php 
                                    echo $this->Form->input('petty_cash_lines.'.$a.'.qty', array("id"=>"data-qty", "autocomplete"=>"off", 'class'=>'form-control qty', 'value'=>$this->Krs->nom($qty))); 
                                    ?>
                                </td>
                                <td>
                                    <?php echo $this->Form->input('petty_cash_lines.'.$a.'.price', array("id"=>"data-price", "autocomplete"=>"off", 'class'=>'form-control auto', 'value'=>$this->Krs->nom($price))); ?>
                                </td>
                                <td align="right"><span id="line-total"><?php echo $amountNominal; ?></span>
                                <?php
                                // id="subTotal"
                                echo $this->Form->input('petty_cash_lines.'.$a.'.linetotal', array("id"=>"line-totals", "type" => "hidden", "value"=>$amount));
                                ?></td>
                                <td align="right">                                  
                                    <?php 
                                    if($a==$countDataLine) {
                                        echo '<button class="btn btn-purple addrow" type="button" id="addrow"><i class="fa fa-plus"></i></button>';
                                    }
                                    ?>
                                </td>
                                
                            </tr>

                            <?php 
                            }
                            ?>
                        </tbody>
                        <thead>
                            <tr id="voucher-total">
                                <td colspan="3" align="right"><strong>Grand Total</strong></td>
                                <td id="grandTotal" align="right"><b><?php 
                                $totalAmount = array_sum($amountNominals);
                                echo $this->Krs->nom($totalAmount); ?></b></td>
                                <td>&nbsp;</td>
                            </tr>
                        </thead>
                    </table>

                </td>
            </tr>
            </table>
        </div>
    </div>
    <div class="panel-footer text-right bg-orange">
    <?php
    echo $this->Form->button('Simpan', ['class'=>'btn btn-primary', 'type'=>'button', 'escape' => false, 'id'=> 'btn-add']);
    ?>
    </div>   
    <?= $this->Form->end() ?>
</div>
<script>
$(document).ready(function() {
    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['controller'=>'petty_cashes', 'action' => 'editAll', $pettyCash->id], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('PettyCashAddForm', 'btn-add', confirmTitle, formAction);

    $("#datepicker-autoClose").datepicker({
        todayHighlight: true,
        autoclose: true
    });

    $("#datepicker-autoClose1").datepicker({
        todayHighlight: true,
        autoclose: true
    });

    hotkeyEnter();

    $("#codePCA").mask("9999");

    $(".select2Form").select2();
    $("select2-clear").on("select2-clear:close", function (e) {  
        $(this).valid(); 
    });
    $('input.nominal').autoNumeric({aSep: '.', aDec: ','});

    function autoNumber() {
        $('input.auto').autoNumeric({aSep: '.', aDec: ','});
        $('input.qty').autoNumeric({aSep: '.', aDec: ',', pSign: 's', vMax: '100000000'});
        $('.noCode').autoNumeric({aSep: '.', aDec: ',', mDec: '', vMax:'999'});
    }
    autoNumber();

    function hotkeyEnter(){
        $('input').keydown( function(e) {
            var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
            if(key == 13) {
                e.preventDefault();
                var inputs = $(this).closest('form').find(':input:visible');
                inputs.eq( inputs.index(this)+ 1 ).focus();
            }
        });
    }

    var ctr = <?= $countDataLine ?>;
    $('#addrow').on('click', function (e) {
        //alert('test');

        if (e.originalEvent.defaultPrevented) return;
        ctr++;
        
        autoNumber();
        var newTr = "";

        newTr += '<tr><td><input name="petty_cash_lines['+ ctr +'][rincian]" autocomplete="off" class="form-control" placeholder="Rincian.." type="text" id="PettyCashPetition'+ ctr +'Rincian" /></td><td><input name="petty_cash_lines['+ ctr +'][qty]" autocomplete="off" size="6" type="text" class="form-control qty" placeholder="Jumlah.." id="data-qty" /></td><td><input name="petty_cash_lines['+ ctr +'][price]" autocomplete="off" size="20" type="text" class="form-control auto" placeholder="Harga.." id="data-price" /></td><td align="right"><span id="line-total">0</span><input type="hidden" name="petty_cash_lines['+ ctr +'][linetotal]" id="line-totals" /></td><td align="right"><button class="btn btn-danger deleterow" type="button" id="deleterow"><i class="fa fa-minus addrow"></i></button></td></tr>';
        $('#myTable').append(newTr);

        autoNumber();
    });

    // Delete Row
    $("table#myTable").on("click", '#deleterow', function (event) {
        if (event.originalEvent.defaultPrevented) return;
        $(this).parent().parent().remove();
        calcGrandTotal();
    }); 

    function calcRows() {
        $("table#myTable").on("change", 'input[id^="data-price"], input[id^="data-qty"]', function (event) {
            calcRow($(this).closest("tr"));
        });     
    }
    
    calcRows();

    function calcRow(row) {
        //var prices = 0;
        var prices = row.find('#data-price').val().replace(/(?!^-)[^0-9\,]+/g,"");
        var price = prices.replace(/,/g, '.');
        var qtys = row.find('#data-qty').val().replace(/(?!^-)[^0-9\,]+/g,"");
        var qty = qtys.replace(/,/g, '.');
        var totalLine = price*qty;
        row.find('#line-totals').val(totalLine.toFixed(2));
        row.find("#line-total").number(totalLine, 2, ",", ".");
        calcGrandTotal();
    }
        
    function calcGrandTotal() {
        var grandTotal = 0;
        $("table#myTable").find('input[id^="line-totals"]').each(function () {
            grandTotal += +$(this).val();
        });
        $("#grandTotal").number(grandTotal, 2, ",", ".");
    }
    
});
</script>