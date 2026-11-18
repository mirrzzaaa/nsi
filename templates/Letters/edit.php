<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Group $group
 */

// pr($marketings);
$dataChild = $this->Html->link('No. Surat', ['action' => 'index'], ['full_base' => true]);
?>
<?= $this->Krs->breadcrumb_('Data', $dataChild, 'Ubah') ?>
<?= $this->Form->create($letter, ['data-parsley-validate' => true]) ?>
<?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?> 

<div class="card border-0 mb-3">
    <div class="card-header bg-none p-3 h6 m-0 d-flex align-items-center"> 
        <i class="fas fa-mail-bulk fa-lg me-2 text-gray text-opacity-50"></i>
        Data No. Surat
    </div>
    <div class="card-body">
        <div class="row">  
            <div class="col-md-1 d-flex flex-column justify-content-center">
                <label for="" class="form-label">Nomor</label> 
            </div>

            <div class="col-md-2">
                <?= $this->Form->control('codes', ['label' => false, 'class' => 'form-control', 'value' => $letter->code, 'disabled']); ?>
                <?= $this->Form->control('project', ['type' => 'hidden', 'value' => 'NSI']); ?>
            </div>

            <div class="col-md-1 d-flex flex-column justify-content-center">
                <label for="" class="form-label">Tanggal</label>
            </div>

            <div class="col-md-2">
                <?= $this->Form->control('dates', ['label' => false, 'class' => 'form-control tgl', 'value' => !empty($letter->date) ? date('d-m-Y', strtotime($letter->date)) : date('d-m-Y')]); ?>
            </div>

        </div>
        <br>
        <div class="row">
            <div class="col-md-1">
                <label for="" class="form-label">Keterangan</label>
            </div>

            <div class="col-md-11">
                <?= $this->Form->control('description', ['label' => false, 'type' => 'textarea', 'class' => 'form-control', 'placeholder' => 'Keterangan...', 'required']); ?>
            </div>
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
        var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'Letters', 'action' => 'edit', $letter->id], ['fullBase' => true]); ?>";
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
</script>
