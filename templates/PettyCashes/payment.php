<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
    .custom-thead-dark {
        background-color: #343a40; /* Warna hitam atau warna gelap */
        color: white; /* Warna teks putih untuk kontras */
        height: 35px;
        padding-bottom: 50px;
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
$dataCodeTitle = '/PCA-NSI'.'/'.$dateMonth.'/'.$dateYear;
$dataDate = (empty($pettyCash->date)) ? '' : $this->Krs->fDate($pettyCash->date, 'd-m-Y');
$dataDueDate = (empty($pettyCash->due_date)) ? '' : $this->Krs->fDate($pettyCash->due_date, 'd-m-Y');
$pettyCashCeoDate = (empty($pettyCash->approved_ceo_date)) ? '' : $pettyCash->approved_ceo_date;
$pettyCashPaymentLast = $pettyCash->payment_nominal;
$pettyCashPaymentDate = (empty($pettyCash->payment_date)) ? '' : ' pada tgl '.$this->Krs->fDate($pettyCash->payment_date, 'd M Y');
$pettyCashPaymentNominal = $this->Krs->nom($pettyCashPaymentLast);


$pettyCashLineData = Hash::combine($pettyCashLine, '{n}.petty_cash_no', ['%s^%s^%s^%s^%s^%s^%s', '{n}.id', '{n}.petty_cash_id', '{n}.petty_cash_no', '{n}.detail_of_request', '{n}.quantity', '{n}.price', '{n}.amount']);

// pr($pettyCashLineData);
?>
<?= $this->Krs->breadcrumb_('Keuangan', $dataChild, 'Pembayaran') ?>
<?= $this->Form->create($pettyCash, ['data-parsley-validate' => true]) ?>
<div class="row">
    <div class="col-lg-7">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Data</h4>
            </div>
            <div class="panel-body">
                <div class="form-group row m-b-5">
                    <label class="col-form-label col-md-3">No.</label>
                    <div class="col-md-6">
                        <?= $this->Krs->fTextPlain($pettyCash->code.$dataCodeTitle) ?>
                    </div>
                </div>
                <div class="form-group row m-b-5">
                    <label class="col-form-label col-md-3">Tanggal</label>
                    <div class="col-md-3">
                        <?= $this->Krs->fTextPlain($dataDate) ?>
                    </div>
                    <label class="col-form-label col-md-3">Jatuh Tempo</label>
                    <div class="col-md-3">
                        <?php echo $this->Krs->fTextPlain($dataDueDate); ?>
                    </div>
                </div>
                <div class="form-group row m-b-5">
                    <label class="col-form-label col-md-3">Tujuan Advance</label>
                    <div class="col-md-9">
                        <?php echo $this->Krs->fTextPlain($pettyCash->purpose_of_advancing); ?>
                    </div>
                </div>
                <div class="form-group row m-b-5">
                    <label class="col-form-label col-md-3">Keterangan</label>
                    <div class="col-md-9">
                        <?= (!empty($pettyCash->description) ? $this->Krs->fTextPlain($pettyCash->description) : $this->Krs->fTextPlain('-')) ?>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table m-b-0 table-advance">
                        <thead class="custom-thead-dark text-center">
                            <tr>
                                <th width="10">No.</th>
                                <th>Rincian Permohonan</th>
                                <th width="80">Jumlah</th>
                                <th width="100">Harga</th>
                                <th width="100">Total</th>
                            </tr>
                        </thead>                                    
                        <tbody>
                            <?php 
                            $countDataLine = count($pettyCashLine);
                             $amountNominals = array();

                            for ($a=1; $a <= $countDataLine; $a++) {
                            list($idCashLine, $idPettyCashLine, $noCashLine, $petition, $qty, $price, $amount) = explode("^", $pettyCashLineData[$a]);
                            $amountNominal = ($amount==0 || empty($amount)) ? 0 : $this->Krs->nom($amount);
                            $amountNominals[] = $amount;
                            ?>
                            <tr>
                                <td><?php echo $a; ?></td>
                                <td><?php echo $petition; ?></td>
                                <td align="right"><?php echo $this->Krs->nom($qty); ?></td>
                                <td align="right"><?php echo $this->Krs->nom($price); ?></td>
                                <td align="right"><?php echo $amountNominal; ?></td>
                            </tr>
                            <?php 
                            }
                            ?>
                        </tbody>
                        <thead>
                            <tr id="voucher-total">
                                <td colspan="4" align="right"><strong>JUMLAH PETTY CASH ADVANCE</strong></td>
                                <td id="grandTotal" align="right"><b>
                                <?php 
                                $totalAmount = array_sum($amountNominals);
                                echo $this->Krs->nom($totalAmount); 
                                ?></b></td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-5">
        <div class="panel panel-inverse">
            <div class="panel-heading">
            <h4 class="panel-title">Perincian</h4>
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                </div>
            </div>
            
                <?= $this->Form->create($pettyCash) ?>
                <div class="panel-body">
                    <div class="form-group row m-b-15 mb-2">
                        <label class="col-form-label col-md-4">Jenis pembayaran</label>
                        <div class="col-md-8">
                            <?php
                            echo $this->Form->control('payment_type', ['label'=>false, 'empty'=>false, 'class'=>'form-control select2Form', 'options'=>$this->Krs->methodPayment()]);
                            echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);

                            // echo $this->Form->input('payment', array('type' => 'hidden', 'value' => $session['id']));
                            ?>
                        </div>
                    </div>
                    <div class="form-group row m-b-15 mb-2">
                        <label class="col-form-label col-md-4">Tanggal</label>
                        <div class="col-md-8">
                            <div class="input-group" id="default-daterange">
                                <?php
                                echo $this->Form->input('payment_dates', ['id' => 'datepicker-autoClose', 'error' => false, 'class'=>'form-control', 'placeholder' => 'Tanggal..', 'value'=>(!empty($dataRows) ? $this->Krs->fDate($pettyCashCeoDate, 'd-m-Y'):date('d-m-Y'))]);
                                ?>
                                <span class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </span>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group row m-b-15 mb-2">
                        <label class="col-form-label col-md-4">Sudah terbayar</label>
                        <div class="col-md-8">
                            <?php
                            echo $this->Form->input('payments', ['type' => 'hidden', 'value' => $totalAmount]);
                            echo $this->Form->input('payment_lasts', ['class' => 'form-control', 'placeholder'=>'Jumlah dibayar..', 'value'=>$pettyCashPaymentNominal, 'div'=>false, 'readonly' => true]);
                            echo $pettyCashPaymentDate;
                            ?>
                        </div>
                    </div>
                    <div class="form-group row m-b-15 mb-2">
                        <label class="col-form-label col-md-4">Jumlah dibayar</label>
                        <div class="col-md-8">
                            <?php
                            $pettyCashPaymentLastNominals = $totalAmount-$pettyCashPaymentLast;
                            $pettyCashPaymentLastNominal = $this->Krs->nom($pettyCashPaymentLastNominals);
                            echo $this->Form->input('payment_nominals', ['class' => 'form-control auto', 'placeholder'=>'Jumlah dibayar..', 'value'=>$pettyCashPaymentLastNominal, 'div'=>false]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group row m-b-15 mb-2">
                        <label class="col-form-label col-md-4">Keterangan</label>
                        <div class="col-md-8">
                            <?php
                            echo $this->Form->input("payment_desc", ['type'=>'textarea', 'rows' => '4', 'cols'=>'75', 'class'=>'form-control', 'placeholder' => 'Keterangan']);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right bg-orange">
                    <?php
                    echo $this->Form->button('Simpan', ['class'=>'btn btn-primary', 'type'=>'button', 'escape' => false, 'id'=> 'btn-add']);
                    ?>
                </div>
                <?= $this->Form->end() ?>
        </div>
    </div>        
</div>
<script>
$(document).ready(function() {
    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['prefix'=>false, 'controller'=>'petty_cashes', 'action' => 'payment', $pettyCash->id], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('PettyCashAddForm', 'btn-add', confirmTitle, formAction);

    $("#datepicker-autoClose").datepicker({
        todayHighlight: true,
        autoclose: true
    });

    $(".select2Form").select2();
    $('input.auto').autoNumeric({aSep: '.', aDec: ',', vMax: '99999999999'});    
});
</script>
