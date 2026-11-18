<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
    .custom-thead-dark {
        background-color: #343a40; /* Warna hitam atau warna gelap */
        color: white; /* Warna teks putih untuk kontras */
        height: 35px;
    }

  </style>
</head>

<?php

// pr($pettyCash);

// $customer = $data['rows']['Customer'];

ini_set('precision', 14);

//pr($data);

$pettyCashLine = $pettyCash->petty_cash_lines;

$user = $pettyCash->user;

// $user = $pettyCash["User"];

$pettyCashId = $pettyCash->id;

$dataPaymentDate = $pettyCash->payment_date;

$dataDate = $pettyCash->date;



$pettyCashProject = (empty($pettyCash->project)) ? "" : $this->Krs->projectStatus($pettyCash->project);

$pettyCashDevision = $pettyCash->devision;

$pettyCashAdvancing = $pettyCash->purpose_of_advancing;

$pettyCashDesc = $pettyCash->description;

$pettyCashPaymentDate = (empty($dataPaymentDate)) ? '-' : $this->Krs->fDate($dataPaymentDate, 'd M Y');

$pettyCashPaymentStatus = ($pettyCash->payment_status=='Y') ? 'LUNAS: '.$pettyCashPaymentDate:'';



$dateYear = (empty($dataDate)) ? '' : $this->Krs->fDate($dataDate, 'Y');

$dateMonth = (empty($dataDate)) ? '' : $this->Krs->numToRome($this->Krs->fDate($dataDate, 'n'));

$pettyCashCode = $pettyCash['code'].'/PCA-NSI'.'/'.$dateMonth.'/'.$dateYear;

$dataDate = (empty($dataDate)) ? '-' : $this->Krs->fDate($dataDate, 'd M Y');

$userName = (empty($user['name'])) ? '-' : $user['name'];

$userDevision = (empty($user['devision'])) ? '-' : $user['devision'];

?>

<div class="modal-dialog modal-lg" role="document">

  <div class="modal-content">

    <div class="modal-header">

      <h4 class="modal-title">Data : <?php echo $pettyCashCode; ?></h4>

      <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->

    </div>

    <div class="modal-body">

      <div class="container-fluid">

        <div class="row">

          <div class="col-md-4 col-sm-12">
            <a id="print-out" class="btn btn-inverse" data-toggle="tooltip" data-placement="top" data-original-title="Cetak"><i class="fa fa-print"></i> Cetak</a>
            <?php
            ?>

          </div>

        </div>

        <div class="row m-b-15">

          <div class="col-sm-12">

            <div class="row">

              <div class="col-9 col-sm-9">

              Form No : <b><?php echo $pettyCashCode;?></b>

              </div>

              <div class="col-3 col-sm-3">

              <?php echo $pettyCashPaymentStatus; ?>

              </div>

            </div>

          </div>

        </div>

        <div class="row m-b-15">

          <div class="col-sm-12" style="text-align: center;border-bottom: 1px solid #000000;">

            <span style="font-weight:bold;font-size:12pt;" valign="center" height="50">FORM<br/>PERMOHONAN PETTY CASH ADVANCE</span>

          </div>

        </div>

        <div class="row m-b-15 mt-3 mb-3">

          <div class="col-sm-12">

            <div class="row">

              <div class="col-2 col-sm-2">

              Proyek

              </div>

              <div class="col-10 col-sm-10">

              : <?php echo $pettyCashProject; ?>

              </div>

            </div>

            <div class="row">

              <div class="col-2 col-sm-2">

              Tanggal

              </div>

              <div class="col-10 col-sm-10">

              : <?php echo $dataDate; ?>

              </div>

            </div>

            <div class="row">

              <div class="col-2 col-sm-2">

              Nama

              </div>

              <div class="col-10 col-sm-10">

              : <?php echo $userName; ?>

              </div>

            </div>

            <div class="row">

              <div class="col-2 col-sm-2">

              Devisi

              </div>

              <div class="col-10 col-sm-10">

              : <?php echo $userDevision; ?>

              </div>

            </div>

            <div class="row">

              <div class="col-2 col-sm-2">

              Tujuan

              </div>

              <div class="col-10 col-sm-10">

              : <?php echo $pettyCashAdvancing; ?>

              </div>

            </div>

          </div>

        </div>

        <div class="row m-b-15">

          <div class="col-sm-12">

            <div class="table-responsive">

              <table class="table m-b-0 table-advance table-hover" cellspacing="0" cellpadding="1" border="0" align="center">

                <thead class="custom-thead-dark text-center">

                  <tr>

                    <th width="40">NO</th>

                    <th>RINCIAN PERMOHONAN</th>

                    <th width="70">JUMLAH</th>

                    <th width="100">HARGA</th>

                    <th width="120">TOTAL</th>

                  </tr>

                </thead>

                <?php

                //$countDataLine = count($pettyCashLine);

                //pr($pettyCashLine);

                $a = 1;     

                foreach ($pettyCashLine as $dataLine) {

                  $dataLineDetail = $dataLine['detail_of_request'];

                  $dataLineQty = $dataLine['quantity'];

                  $dataLinePrice = $dataLine['price'];

                  $dataLineAmount = $dataLine['amount'];

                  $dataLineNominalQty = $this->Krs->nom($dataLineQty);

                  $dataLineNominalPrice = $this->Krs->nom($dataLinePrice);

                  $dataLineAmountNominal = $this->Krs->nom($dataLineAmount);

                  $dataLineAmountDatas[] = $dataLineAmount;

                //for ($a=1; $a <= $countDataLine; $a++) {

                ?>

                <tr>

                  <td align="center"><?php echo $a; ?></td>

                  <td><?php echo $dataLineDetail; ?></td>

                  <td align="right"><?php echo $dataLineNominalQty; ?></td>

                  <td align="right"><?php echo $dataLineNominalPrice; ?></td>

                  <td align="right"><?php echo $dataLineAmountNominal; ?></td>

                </tr>

                <?php

                $a++;

                } 

                ?>

                <tr>

                  <td colspan="4" align="right"><b>GRAND TOTAL</b></td>

                  <td align="center"><b><?php 

                  $dataLineAmountData = array_sum($dataLineAmountDatas);

                  $dataLineAmountDataNominal = $this->Krs->nom($dataLineAmountData);

                  echo $dataLineAmountDataNominal; ?></b></td>

                </tr>

              </table>

            </div>

          </div>

          <div class="col-sm-12 mb-3">

            <strong>Keterangan:</strong> <br><?= (!empty($pettyCash->description) ? $pettyCash->description : '-') ?>

          </div>



          </div>

      </div>

    </div>

  </div>

</div>



<script type="text/javascript">

jQuery(document).ready(function() { 

  $('#print-out').on('click', function(){

    window.open("<?php echo $this->Url->build(['prefix' => false, 'controller' => 'PettyCashes', 'action' => 'printing/'.$pettyCashId, '_full'=>true]); ?>", 'page' ,'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=780,height=750,left=50,top=50,titlebar=yes');

  });

});

</script>





<?php
//$this->Html->link('<i class="fa fa-print"></i> Cetak', array('action'=>'printing/'.$pettyCashId), ['id'=>'print-out', 'class'=>'btn btn-inverse', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Cetak', 'escape' => false, 'fullBase'=>true])
            //<a id="print-out"><i class="fa fa-print"></i> Cetak</a>
/*

$this->Html->url(array("action" => "printing/".$pettyCashId), true)

<div class="modal-dialog modal-lg">

  <div class="modal-content">

    <div class="modal-header">

      <h4 class="modal-title">Detail Data : <?= $pettyCash->title.' '.$pettyCash->name ?></h4>

      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

    </div>

    <div class="modal-body">

      <div class="row m-b-15">

        <div class="col-sm-12">

          <div class="row">

            <div class="col-2 col-sm-2">

              Kode

            </div>

            <div class="col-4 col-sm-4">: <?= $pettyCash->code ?></div>

            <div class="col-2 col-sm-2">

              Nama

            </div>

            <div class="col-4 col-sm-4">: <?= $pettyCash->name ?></div>

          </div>

          <div class="row">

            <div class="col-2 col-sm-2">

              Tgl. Permintaan

            </div>

            <div class="col-4 col-sm-4">: <span id="tglpbj"></span></div>

            <div class="col-2 col-sm-2">

              Tgl. Tempo

            </div>

            <div class="col-4 col-sm-4">: <span id="tgltempo"></span></div>

          </div>

        </div>

      </div>

      <div class="table-responsive">

        <table id="barang" class="table table-hover">

          <thead class="thead-dark">

            <tr>

              <th>Nama Barang</th>

              <th>Harga</th>

              <th>Jumlah</th>

              <th>Subtotal</th>

            </tr>

          </thead>

          <tbody>



          </tbody>

          <tfoot class="table-warning table-condensed">

            <tr>

              <td scope="row" colspan="3">Total</td>

              <td scope="row"><span id="total"></span></td>

            </tr>

          </tfoot>

        </table>

      </div>

    </div>

    <div class="modal-footer">

      <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>      

    </div>

  </div>

</div>

*/

?>