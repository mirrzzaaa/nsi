<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Group $group
 */

// pr($marketings);
$dataChild = $this->Html->link('Penawaran', ['action' => 'index'], ['full_base' => true]);
?>
<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Buat') ?>
<?= $this->Form->create($offer, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?> 
<?= $this->Form->control('description', ['type' => 'hidden', 'id' => 'descs']); ?>
<?= $this->Form->control('code', ['type' => 'hidden', 'value' => $data['lastNumber']]); ?>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center"> 
        <i class="fas fa-envelope-open-text fa-lg me-2 text-gray text-opacity-50"></i>
        Data Penawaran 
    </div>
    <div class="card-body">
        <div class="row">  
            <div class="col-md-4">
                <label for="" class="form-label">No. Ref</label> 
                <?= $this->Form->control('codes', ['label' => false, 'class' => 'form-control', 'value' => $data['lastNumber'], 'disabled']); ?>
            </div>

            <div class="col-md-4">
                <label for="" class="form-label">Marketing</label> 
                <?= $this->Form->control('is_marketing', ['label' => false, 'class' => 'form-control cs', 'autocomplete' => 'off', 'options' => $marketings, 'data-placeholder' => 'Pilih marketing . . .', 'empty' => 'Pilih marketing...', 'data-parsley-required' => true, 'data-parsley-errors-container' => '#check-marketing', 'data-parsley-required-message' => 'Marketing harus dipilih !']); ?>
                <div id="check-marketing"></div>
            </div>

            <div class="col-md-4">
                <label for="" class="form-label">Tanggal</label>
                <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control tgl']); ?>
            </div>

            <div class="col-md-4 mt-3">
                <label for="" class="form-label">Cabang</label>
                <?= $this->Form->control('branch_id', ['label' => false, 'class' => 'form-control slc', 'autocomplete' => 'off', 'options' => $branch, 'data-placeholder' => 'Pilih cabang . . .', 'empty' => 'Pilih cabang...', 'data-parsley-required' => true, 'data-parsley-errors-container' => '#check-cabang', 'data-parsley-required-message' => 'Cabang harus dipilih !']); ?>
                <div id="check-cabang"></div>
            </div>

        </div>
    </div>
</div>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center"> 
        <i class="fas fa-users fa-lg me-2 text-gray text-opacity-50"></i>
        Data Customer
    </div>
    <div class="card-body">
        <div class="row">  
            <div class="col-md-4">
                <label for="" class="form-label">Customer</label> 
                <?= $this->Form->control('customer_name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama customer...', 'required']); ?>
            </div>

            <div class="col-md-4">
                <label for="" class="form-label">Attn 1</label>
                <?= $this->Form->control('attn_1', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Attn 1... ']); ?>
            </div>

            <div class="col-md-4">
                <label for="" class="form-label">Attn 2</label>
                <?= $this->Form->control('attn_2', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Attn 2... ']); ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-8">
                <label for="" class="form-label">Alamat</label>
                <?= $this->Form->control('address', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat customer...', 'required']); ?>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Perihal</label>
                <?= $this->Form->control('perihal', ['label' => false, 'class' => 'form-control', 'value' => 'Penawaran Unit Alat Kesehatan']); ?>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center"> 
        <i class="fas fa-file-alt fa-lg me-2 text-gray text-opacity-50"></i>
        Isi Surat Penawaran
    </div>
    <div class="card-body">
        <div class="row">  
            <div class="col-md-12">
            <textarea name="description" rows="40" cols="80" style="height: 300px;">
            <table style="width: 100%;">
                <tbody>
                    <tr>
                        <td colspan="3">Dengan hormat,</td>
                    </tr>
                    <tr>
                        <td style="margin-left: 30px; text-align: justify;" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bersama surat ini, izinkan kami PT. Nusa Saraya indonesia yang bergerak di bidang konsultan lingkungan, Suplier bahan kimia laboratorium dan distributor alat kesehatan terkemuka dan Perusahaan kami juga telah menjalin kerjasama dengan berbagai perusahaan market leader di Indonesia dan dunia memberikan surat penawaran kebutuhan alat Kesehatan. Bersama dengan surat ini, kami lampirkan pula beberapa dokumen pendukung terkait spesifikasi product yang bisa menjadi bahan pertimbangan team pengadaan untuk memilih sesuai yang di butuhkan.</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table style="width: 100%; border: 1px solid #000;">
                                <!-- <thead>
                                    <tr>
                                        <th style="border: 1px solid #000; background-color: #00B0F0; text-align: center;" colspan="5" align="center" valign="middle">PENAWARAN ALAT KESEHATAN</th>
                                     </tr>
                                </thead> -->
                                <thead>
                                    <tr>
                                        <th style="border: 1px solid #000; background-color: #dbdbdb;"><strong style="text-align: center;">NAMA PRODUK</strong></th>
                                        <th style="border: 1px solid #000; background-color: #dbdbdb;"><strong style="text-align: center;">TYPE</strong></th>
                                        <th style="border: 1px solid #000; background-color: #dbdbdb;"><strong style="text-align: center;">MEREK</strong></th>
                                        <th style="border: 1px solid #000; background-color: #dbdbdb;"><strong style="text-align: center;">QTY</strong></th>
                                        <th style="border: 1px solid #000; background-color: #dbdbdb;"><strong style="text-align: center;">HARGA</strong></th>
                                     </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border: 1px solid #000; text-align: center; width: 30%;" rowspan="3" align="center" valign="middle">Reclining Wheelchair</td>
                                        <td style="border: 1px solid #000; width: 30%;">&nbsp;FS 958 LBHP (Child)</td>
                                        <td style="border: 1px solid #000; text-align: center; width: 15%;">GEA</td>
                                        <td style="border: 1px solid #000; text-align: center; width: 10%;">1</td>
                                        <td style="border: 1px solid #000; text-align: right; width: 15%;">Rp. 6.902.631&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; width: 30%;">&nbsp;FS 985 LBJ-38 (Child)</td>
                                        <td style="border: 1px solid #000; text-align: center; width: 15%;">GEA</td>
                                        <td style="border: 1px solid #000; text-align: center; width: 10%;">1</td>
                                        <td style="border: 1px solid #000; text-align: right; width: 15%;">Rp. 6.027.026&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; width: 30%;">&nbsp;FS 985 LBJ-43 (Adult)</td>
                                        <td style="border: 1px solid #000; text-align: center; width: 15%;">GEA</td>
                                        <td style="border: 1px solid #000; text-align: center; width: 10%;">1</td>
                                        <td style="border: 1px solid #000; text-align: right; width: 15%;">Rp. 5.847.687&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; text-align: center; width: 30%;">&nbsp;</td>
                                        <td style="border: 1px solid #000; width: 30%;">&nbsp;</td>
                                        <td style="border: 1px solid #000; text-align: center; width: 15%;">&nbsp;</td>
                                        <td style="border: 1px solid #000; text-align: center; width: 10%;">&nbsp;</td>
                                        <td style="border: 1px solid #000; text-align: right; width: 15%;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; text-align: center; width: 30%;">&nbsp;</td>
                                        <td style="border: 1px solid #000; width: 30%;">&nbsp;</td>
                                        <td style="border: 1px solid #000; text-align: center; width: 15%;">&nbsp;</td>
                                        <td style="border: 1px solid #000; text-align: center; width: 10%;">&nbsp;</td>
                                        <td style="border: 1px solid #000; text-align: right; width: 15%;">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align: justify;" colspan="3">Demikian surat penawaran ini. Besar harapan kami untuk mendapatkan kabar baik segera.</td>
                    </tr>
                    <tr>
                        <td style="text-align: justify;" colspan="3">Atas perhatiannya kami sampaikan terima kasih.</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">&nbsp;</td>
                        <td style="width: 95%;" colspan="2">
                            <table style=" width: 100%;" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td colspan="2">Note :</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center; width: 6%;">-</td>
                                        <td style="width: 94%;">Harga belum termasuk Pra Instalasi</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">-</td>
                                        <td>Harga sudah termasuk instalasi & Training alat</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">-</td>
                                        <td>Garansi 1 Tahun</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">-</td>
                                        <td>Penawaran berlaku 30 hari</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">-</td>
                                        <td>Harga Belum termasuk Ongkos Kirim</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">-</td>
                                        <td>Harga belum termasuk PPN</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </textarea>
        <hr>
        </div>
        <label for="" class="form-label">Info Marketing</label>
        <?= $this->Form->control('info', ['label' => false, 'class' => 'form-control', 'value' => 'Untuk informasi lebih lanjut silahakan menghubungi marketing kami']); ?>
        </div>
    </div>
    <div class="card-footer bg-yellow d-flex p-3">
        <?php
        echo $this->Form->button('Simpan', ['class' => 'btn btn-primary  ms-auto', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
        ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'Offers', 'action' => 'add'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

        $('.cs').select2({
            placeholder: "Tanpa title . . ."
        });

        $('.slc').select2({
            placeholder: 'Pilih salah satu...'
        });

        $('.tgl').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            orientation: "bottom"
        }).datepicker('setDate', 'now');
    });

    tinymce.init({
        selector: 'textarea[name="description"]',  // Selector for the specific textarea
        height: 450,
        plugins: [
            "advlist autolink link image lists charmap preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
            "save table contextmenu directionality template paste textcolor"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview fullpage | forecolor backcolor",
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ],
        language: 'id'
    });

</script>
