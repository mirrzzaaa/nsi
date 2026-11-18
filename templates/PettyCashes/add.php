<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
    .custom-thead-dark {
        background-color: #343a40; /* Warna hitam atau warna gelap */
        color: white; /* Warna teks putih untuk kontras */
        height: 35px;
    }

    .table td {
        border-right: 10px solid transparent; /* Jarak di antara kolom */
    }

    #voucher-total td {
        padding-bottom: 20px;
    }

    .horizontal-line {
        border-top: 1px solid #ddd; /* Sesuaikan warna dan ketebalan sesuai kebutuhan */
        margin: 10px 0; /* Sesuaikan jarak dengan kebutuhan */
    }


</style>
</head>

<?php
//pr($customers);
$dataChild = $this->Html->link('Petty Cash', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb_('Keuangan', $dataChild, 'Buat') ?>
<?= $this->Form->create($pettyCash, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_delivery', ['type' => 'hidden', 'value' => $getUser->id]); ?> 

<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Perincian</h4>
    </div>

    <?= $this->Form->create($pettyCash) ?>
    <?php // nav-tabs-inverse ?>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-group mb-2"><strong>No</strong></label>
                    <div class="input-group m-b-10">
                        <?php
                        echo $this->Form->input('codes', ['class' => 'form-control', 'placeholder'=>'No..', 'value'=>$pettyCash['getMaxCode']]); 
                        echo $this->Form->control('devision', ['type' => 'hidden', 'value' => $getUser->devision]);
                        echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                        ?>
                        <span class="input-group-append">
                            <span class="input-group-text">PCA-NSI</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-group mb-2"><strong>Proyek</strong></label>                        
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
                    <label class="form-group mb-2"><strong>Tanggal</strong></label>                        
                    <div class="input-group" id="default-daterange">
                        <?php
                        echo $this->Form->input('dates', array('id' => 'datepicker-autoClose', 'error' => false, 'class'=>'form-control', 'placeholder' => 'Tanggal..', 'value'=>date('d-m-Y')));
                        ?>
                        <span class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-group mb-2"><strong>Jatuh Tempo</strong></label>
                    <div class="input-group" id="default-daterange">
                        <?php
                        $nextDay = date("d-m-Y", mktime(0, 0, 0, date("m"), date("d")+1, date("Y")));
                        echo $this->Form->input('due_dates', array('id' => 'datepicker-autoClose1', 'error' => false, 'class'=>'form-control', 'placeholder' => 'Tanggal..', 'value'=>$nextDay));
                        ?>
                        <span class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <label class="form-group mb-2"><strong>Tujuan Advance</strong></label>
             <?php
            echo $this->Form->control('purpose_of_advancing', array('label' => false, 'class' => 'form-control', 'error' => false, 'placeholder' => 'Tujuan Advance..'));
            ?>
        </div>
        <div class="form-group mt-3">
            <label class="form-group mb-2"><strong>Keterangan</strong></label>
            <?php
            echo $this->Form->control('description', array('label' => false, 'type'=>'textarea', 'rows' => '6', 'cols'=>'75', 'class'=>'form-control', 'placeholder' => 'Keterangan'));
            ?>
        </div> 
        <div class="table-responsive mt-3">
            <table class="table m-b-0 table-advance">
            <tr class="sum">
                <td>
                    <table cellpadding="0" class="adminlist" cellspacing="0" border="0" id="myTable" width="100%">
                        <thead class="custom-thead-dark text-center">
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
                            $a=1;
                            ?>
                            <tr>
                                <td>
                                    <?php 
                                    echo $this->Form->input('petty_cash_lines.'.$a.'.rincian', array('autocomplete'=>'off', 'class' => 'form-control mt-3', 'placeholder' => 'Rincian..')); ?>
                                </td>
                                <td>
                                    <?php 
                                    echo $this->Form->input('petty_cash_lines.'.$a.'.qty', array("id"=>"data-qty", "autocomplete"=>"off", 'class'=>'form-control mt-3 qty', 'placeholder' => 'Jumlah..')); 
                                    ?>
                                </td>
                                <td>
                                    <?php echo $this->Form->input('petty_cash_lines.'.$a.'.price', array("id"=>"data-price", "autocomplete"=>"off", 'class'=>'form-control mt-3 auto', 'placeholder' => 'Harga..')); ?>
                                </td>
                                <td align="right"><span id="line-total">0</span>
                                <?php
                                echo $this->Form->input('petty_cash_lines.'.$a.'.linetotal', array('class'=>'form-control mt-3', "id"=>"line-totals", "type" => "hidden"));
                                ?></td>
                                <td align="right">
                                    <button class="btn btn-orange addrow mt-3" type="button" id="addrow"><i class="fa fa-plus"></i></button>

                                    <?php 
                                    // echo '<i class="fa fa-plus" id="addrow"></i>';
                                    ?>
                                </td>                               
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div class="horizontal-line"></div>
                                </td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr id="voucher-total">
                                <td colspan="3" align="right"><strong>Grand Total</strong></td>
                                <td id="grandTotal" align="right">0</td>
                                <td>&nbsp;</td>
                            </tr>
                        </thead>
                    </table>

                </td>
            </tr>
            </table>
        </div>
    </div>
    <div class="card-footer bg-yellow d-flex p-3">
                <?php
                echo $this->Form->button('Simpan', ['class' => 'btn btn-primary  ms-auto', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
                ?>
            </div>
    <?= $this->Form->end() ?>
</div>
<script>
$(document).ready(function() {
    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['controller'=>'petty_cashes', 'action' => 'add'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('PettyCashAddForm', 'btn-add', confirmTitle, formAction);

    $("#datepicker-autoClose").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true
    });

    $("#datepicker-autoClose1").datepicker({
        format: 'dd-mm-yyyy',
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

    var ctr = 999;
    $('#addrow').on('click', function (e) {
        //alert('test');

        if (e.originalEvent.defaultPrevented) return;
        ctr++;
        
        autoNumber();
        var newTr = "";

        newTr += '<tr><td><input name="petty_cash_lines['+ ctr +'][rincian]" autocomplete="off" class="form-control" placeholder="Rincian.." type="text" id="PettyCashLines'+ ctr +'Rincian" /></td><td><input name="petty_cash_lines['+ ctr +'][qty]" autocomplete="off" size="6" type="text" class="form-control qty" placeholder="Jumlah.." id="data-qty" /></td><td><input name="petty_cash_lines['+ ctr +'][price]" autocomplete="off" size="20" type="text" class="form-control auto" placeholder="Harga.." id="data-price" /></td><td align="right" class="mt-3"><span id="line-total">0</span><input type="hidden" name="petty_cash_lines['+ ctr +'][linetotal]" id="line-totals" /></td><td align="right"><button class="btn btn-danger deleterow" type="button" id="deleterow"><i class="fa fa-minus addrow"></i></button></td></tr><tr><td colspan="5"><div class="horizontal-line"></div></td>';
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
