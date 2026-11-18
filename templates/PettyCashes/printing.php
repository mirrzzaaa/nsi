<?php
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
$pettyCashCode = $pettyCash['code'].'/PCA-'.$pettyCashDevision.'/'.$dateMonth.'/'.$dateYear;
$dataDate = (empty($dataDate)) ? '-' : $this->Krs->fDate($dataDate, 'd M Y');
$userName = (empty($user['name'])) ? '-' : $user['name'];
$userDevision = (empty($user['devision'])) ? '-' : $user['devision'];
?>
<style>
.left{ border-left: 1px solid #000000; }
.bottom{ border-bottom: 1px solid #000000; }
</style>
<table width="800" cellspacing="0" cellpadding="1" border="0" align="center">
	<tr><td height="20"><?php 
		//echo $this->Html->link($this->Html->image("layout/printer.png", array("alt" => "Print", "border" => 0)).' '.__('Print', true), array('event_id' => $uuid, 'action'=>'pdf_invoice/'.$pettyCashId), array('escape'=>false));
	?></td></tr>
</table>
<table width="800" cellspacing="0" cellpadding="1" border="0" align="center">
	<tr>
		<td height="20">Form No : <b><?php echo $pettyCashCode;?></b></td>
		<td align="right" style="font-weight:bold;font-size:15pt;"><?php echo $pettyCashPaymentStatus; ?></td>
	</tr>
	<tr style="font-weight:bold;font-size:12pt;"><td align="center" valign="center" height="50" class="bottom" colspan="2">FORM<br/>PERMOHONAN PETTY CASH ADVANCE</td></tr>
	<tr>
		<td align="center" colspan="2">
			<table width="100%" cellspacing="0" cellpadding="1" border="0" align="center">
				<tr>
					<td width="100">Tanggal</td>
					<td>: <?php echo $dataDate; ?></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>: <?php echo $userName; ?></td>
				</tr>
				<tr>
					<td>Bagian</td>
					<td>: <?php echo $userDevision; ?></td>
				</tr>
				<tr>
					<td>Tujuan</td>
					<td>: <?php echo $pettyCashAdvancing; ?></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<table width="100%" cellspacing="0" cellpadding="1" border="1" align="center">
				<tr>
					<th width="40">No</th>
					<th>RINCIAN PERMOHONAN</th>
					<th width="70">JUMLAH</th>
					<th width="100">HARGA</th>
					<th width="120">TOTAL</th>
				</tr>
				<?php
				//$countDataLine = count($pettyCashLine);
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
					<td colspan="4" align="center"><b>GRAND TOTAL</b></td>
					<td align="right"><b><?php 
					$dataLineAmountData = array_sum($dataLineAmountDatas);
					$dataLineAmountDataNominal = $this->Krs->nom($dataLineAmountData);
					echo $dataLineAmountDataNominal; ?></b></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="2">Keterangan: <br><?php echo $pettyCashDesc; ?></td>
	</tr>
</table>
	
	
	
	