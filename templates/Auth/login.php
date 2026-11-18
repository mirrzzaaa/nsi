<div class="login login-v2 fw-bold">

    <div class="login-cover">
        <div class="login-cover-img" style="background-image: url('<?= $this->request->getAttribute('webroot') ?>img/login-bg/bg-medical.jpg')" data-id="login-cover-image"></div>
        <div class="login-cover-bg"></div>
    </div>


    <div class="login-container">

        <div class="login-header">
            <div class="brand">
                <?php
                echo $this->Html->image('/img/logo/logo-nsi.png', array('alt' => 'logo', 'border' => 0, 'fullBase' => true));
                ?>
                <small>Sistem Informasi Nusa Saraya Indonesia</small>
            </div>
            <div class="icon">
                <i class="fa fa-lock"></i>
            </div>
        </div>


        <div class="login-content">
            <?= $this->Form->create(null, ['class' => 'margin-bottom-0']) ?>
            <div class="form-floating mb-20px">
                <?= $this->Form->text('code', ['label' => false, 'class' => 'form-control fs-13px h-45px border-0', 'placeholder' => 'Masukkan username dengan benar...', 'autofocus']); ?>
                <label for="emailAddress" class="d-flex align-items-center text-gray-600 fs-13px">Username</label>
            </div>
            <div class="form-floating mb-20px">
                <?= $this->Form->text('password_new', ['required' => true, 'type' => 'password', 'class' => 'form-control fs-13px h-45px border-0 pwd', 'label' => false, 'title' => false, 'placeholder' => 'Password']) ?>
                <label for="emailAddress" class="d-flex align-items-center text-gray-600 fs-13px">Password</label>
            </div>
            <div class="form-check mb-20px">
                <input class="form-check-input border-0" type="checkbox" id="show" />
                <label class="form-check-label fs-13px text-gray-500" for="rememberMe">
                    Show Password
                </label>
            </div>
            <div class="mb-20px">
                <?= $this->Form->submit(__('Login'), ['class' => 'btn btn-theme btn-yellow d-block w-100 h-45px btn-lg']); ?>
            </div>
            <div class="text-gray-500">
                <?= $this->Krs->footer() ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#show').click(function() {
            if ($(this).is(':checked')) {
                $('.pwd').attr('type', 'text');
            } else {
                $('.pwd').attr('type', 'password');
            }
        });
    });
</script>
