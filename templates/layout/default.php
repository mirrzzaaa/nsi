<?php

$cakeDescription = 'NSI-App';

$session = $this->request->getSession();
$sessionAuth = $session->read('Auth.id');
$action = $this->request->getParam('action');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->Html->charset() ?>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>

    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?> 

    <?= $this->Html->css(['/assets/css/default/theme/apple/vendor.min',  '/assets/css/default/theme/apple/app.min',  '/plugins/gritter/css/jquery.gritter', '/plugins/nvd3/build/nv.d3', '/plugins/select2/dist/css/select2.min', '/plugins/dropzone/dist/min/dropzone.min.css', '/plugins/bootstrap-daterangepicker/daterangepicker', '/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker', '/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min', '/plugins/ion-rangeslider/css/ion.rangeSlider.min', '/plugins/tag-it/css/jquery.tagit', '/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker', '/plugins/fullcalendar/lib/main.min', '/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css', '/plugins/fileinput/css/fileinput.css', '/plugins/lightbox2/dist/css/lightbox.css'], ['fullBase' => true]) ?>
    <?= $this->Html->script(['/plugins/ionicons/ionicons-master/ionicons.js'], ['fullBase' => true]) ?>

    <?= $this->Html->script(['jquery.min', '/plugins/moment/min/moment.min.js', '/plugins/tinymce/tinymce.min.js', '/plugins/ckeditor/ckeditor.js'], ['fullBase' => true]) ?> 
    <!-- /plugins/ckeditor/ckeditor.js -->
    <!-- /plugins/tinymce4/tinymce.min.js -->

</head>

<body <?= ($sessionAuth) ? 'class="theme-yellow"' : ' class="pace-top theme-yellow"'; ?>>

    <?php
    if ($sessionAuth) {
    ?>

        <div id="app" class="app app-header-fixed app-sidebar-fixed ">
            <?= $this->element('header') ?>
            <?= $this->element('sidebar') ?>
            <div id="content" class="app-content">
                <?= $this->fetch('content') ?>
                <?= $this->element('footer') ?>
            </div>
            <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        </div>
    <?php
    } else {
    ?>
        <div id="app" class="app">
            <?= $this->fetch('content') ?>
        </div>
    <?php
    }
    ?>

    <?= $this->Html->script(['/assets/js/theme/apple/vendor.min',  '/assets/js/theme/apple/app.min', '/plugins/d3/d3.min', '/plugins/nvd3/build/nv.d3.min', '/plugins/apexcharts/dist/apexcharts.min', '/plugins/chart.js/dist/Chart.min', '/plugins/gritter/js/jquery.gritter', '/plugins/sweetalert/dist/sweetalert.min', '/plugins/select2/dist/js/select2.full.min', '/plugins/dropzone/dist/min/dropzone.min', '/plugins/bootbox/js/bootbox.min', '/plugins/jquery-validation/dist/jquery.validate.min', '/plugins/parsleyjs/dist/parsley.min', '/plugins/highlight.js/highlight.min', '/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker', '/plugins/jquery.maskedinput/src/jquery.maskedinput', 'demo/render.highlight', 'ui-krs', '/plugins/bootstrap-daterangepicker/daterangepicker', '/plugins/bootstrap-show-password/dist/bootstrap-show-password', '/plugins/jquery.autoNumeric/jquery.autoNumeric',  '/plugins/fullcalendar/lib/main.js', '/plugins/form-plugins', '/plugins/jquery.krs', '/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', '/plugins/fileinput/js/fileinput.js', '/plugins/lightbox2/dist/js/lightbox.min.js', '/plugins/jquery.number/jquery.number'], ['fullBase' => true]); ?>

    <?php
    if ($action == 'changePassword' || $action == 'login') { 
        echo $this->Html->script(['/plugins/bootstrap-show-password/dist/bootstrap-show-password'], ['fullBase' => true]);
    }
    if ($action == 'portal' || $action == 'editMany' || $action == 'generalJournalReport') {
        echo $this->Html->script(['/plugins/datatables.krs/datatables.min'], ['fullBase' => true]);
        // echo $this->Html->script(['/plugins/datatables/media/js/jquery.dataTables.min'], ['fullBase' => true]);
    }

    $flashMessages = trim(strip_tags($this->Flash->render()));

    if (!empty($flashMessages)) {
        list($flashTitle, $flashText) = explode(" : ", $flashMessages);
        if ($flashTitle == 'Berhasil') {
            $imgFlash = 'success.png';
        } elseif ($flashTitle == 'Gagal') {
            $imgFlash = 'error.png';
        } elseif ($flashTitle == 'Peringatan') {
            $imgFlash = 'warning.png';
        }
    ?>
        <script>
            /*
             * For Notification with alert.
             */
            $(document).ready(function() {
                $.gritter.add({
                    title: '<?php echo  $flashTitle; ?>',
                    text: '<?php echo $flashText; ?>',
                    time: '3000',
                    image: '<?php echo $this->request->getAttribute('webroot') . 'img/logo/' . $imgFlash; ?>'
                });

            });

            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
    <?php } ?>
</body>

</html>
<?php

?>
