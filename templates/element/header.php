<div id="header" class="app-header">

    <div class="navbar-header">
        <a href="#" class="navbar-brand">
            <?php
            echo $this->Html->image('/img/logo/nsi-header.png', array('alt' => 'logo', 'border' => 0, 'fullBase' => true));
            ?>
        </a>
        <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>


    <div class="navbar-nav">
        <div class="navbar-item navbar-user dropdown">
            <a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                <?php
                echo $this->Html->image("/img/logo/cp.png", ["alt" => "", "border" => 0, 'fullBase' => true]);
                $lastLoginDate =  $getUser->last_login == null ? '' :  $this->Krs->fDate($getUser->last_login, 'd M Y H:m');;
                ?>
                <span>
                    <span class="d-none d-md-inline"><?= $getUser->code ?></span>
                    <b class="caret"></b>
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-end me-1" style="">
                <a href="javascript:;" class="dropdown-item"><small>Last login : <?php echo $lastLoginDate; ?></small></a>
                <div class="dropdown-divider"></div>
                <?php echo $this->Html->link('Keluar', ['prefix' => false, 'controller' => 'auth', 'action' => 'logout', 'full_base' => true], ['escape' => false, 'class' => 'dropdown-item']); ?>
            </div>
        </div>
        <div class="navbar-item navbar-user">
            <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Auth', 'action' => 'logout']); ?>" class="navbar-link icon">
                <ion-icon name="power"></ion-icon>
            </a>
        </div>
    </div>

</div>
