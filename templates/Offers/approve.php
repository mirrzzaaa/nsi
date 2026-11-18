<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Group $group
 */

$dataChild = $this->Html->link('Penawaran', ['action' => 'index'], ['full_base' => true]);
?>

<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Approve') ?>
<?= $this->Form->create($offer, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_approve', ['type' => 'hidden', 'value' => $getUser->id]); ?> 
<?= $this->Form->control('description', ['type' => 'hidden', 'id' => 'descs']); ?>

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center"> 
        <i class="fas fa-envelope-open-text fa-lg me-2 text-gray text-opacity-50"></i>
        Data Penawaran
    </div>
    <div class="card-body">
        <div class="row">  
            <div class="col-md-4">
                <label for="" class="form-label">No. Ref</label> 
                <?= $this->Form->control('codes', ['label' => false, 'class' => 'form-control', 'value' => $offer->code, 'disabled']); ?>
            </div>

            <div class="col-md-4">
                <label for="" class="form-label">Marketing</label>
                <?= $this->Form->control('is_marketing', ['label' => false, 'class' => 'form-control cs', 'autocomplete' => 'off', 'options' => $marketings, 'data-placeholder' => 'Pilih marketing . . .', 'empty' => 'Pilih marketing...', 'data-parsley-required' => true, 'data-parsley-errors-container' => '#check-marketing', 'data-parsley-required-message' => 'Marketing harus dipilih !']); ?>
                <div id="check-marketing"></div>
            </div>

            <div class="col-md-4">
                <label for="" class="form-label">Tanggal</label>
                <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control tgl', 'value' => !empty($offer->date) ? date('d-m-Y', strtotime($offer->date)) : date('d-m-Y')]); ?>
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
                <?= $this->Form->control('customer_address', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat customer...', 'required']); ?>
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
                <?= base64_decode($offer->description) ?>
            </textarea>
            <hr>
        </div>
        <label for="" class="form-label">Info Marketing</label>
        <?= $this->Form->control('info', ['label' => false, 'class' => 'form-control', 'value' => 'Untuk informasi lebih lanjut silahakan menghubungi marketing kami']); ?>
        </div>
    </div>
    <div class="card-footer bg-yellow d-flex p-3">
        <?php
        echo $this->Form->button('Setuju', ['class' => 'btn btn-primary  ms-auto', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
        ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'Offers', 'action' => 'approve', $offer->id], ['fullBase' => true]); ?>";
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
        });

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
