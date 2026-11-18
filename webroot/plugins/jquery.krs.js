function submitForm(idName, confirmTitle, urlLink) {
    $('#' + idName).click(function() {
        var $form = $(this).closest('form');
        bootbox.confirm(confirmTitle, function(result) {
            if (result == true) {
                var form_action = urlLink;
                $form.attr('action', form_action);
                $form.submit();
                return true;
            }
        });
    });
}

function checkAllGrid(idName) {
    $('#' + idName + ' .group-checkable').change(function() {
        var set = $(this).attr("data-set");
        var checked = $(this).is(":checked");

        $(set).each(function() {
            if (checked) {
                $(this).attr("checked", true);
                $(this).parents('tr').toggleClass("active");
            } else {
                $(this).attr("checked", false);
                $(this).parents('tr').toggleClass(false);
            }
        });
        //jQuery.uniform.update(set);
        //return;
    });

    $('#' + idName + ' tbody tr .checkboxes').change(function() {
        $(this).parents('tr').toggleClass("active");
    });

}

function previewForm(idName, urlLink) {
    //ajax demo:
    var $modal = $('#ajax-modal');

    $('#' + idName).on('click', function() {
        // create the backdrop and wait for next modal to be triggered

        var formAction = urlLink;
        //$('body').modalmanager('loading');
        // waitingDialog.show('Custom message');setTimeout(function () {waitingDialog.hide();}, 2000);

        //$(this).html('<div id="page-loader" class="fade show"><span class="spinner"></span></div>').show();
        // $.ajax({
        //        url: formAction,
        //        type: "GET",
        //        success: function ( responseText ) {
        //            //$("#result").html( responseText );
        //            $modal.modal();
        //        }
        //    });


        setTimeout(function() {
            $modal.load(formAction, '', function() {
                $modal.modal();
            });
        }, 100);
        // if(!$(this).attr('complete')) {
        // 	$(this).html('<div id="page-loader" class="fade show"><span class="spinner"></span></div>').show();
        // }

        /*$.ajax({
            url: formAction,
            type: 'post',
            //data: {userid: userid},
            success: function(response){
              // Add response in Modal body
              //$('.modal-body').html(response);
              //$(this).html('<div id="page-loader" class="fade show"><span class="spinner"></span></div>').hide();

              // Display Modal
              $modal.modal('show');
            }
          });*/


    });
}

function datePicker(className, formatDate, monthYear) {
    var dateFormat = (formatDate == null) ? 'dd-mm-yyyy' : formatDate;

    if (monthYear == "y") {
        $('.' + className).datepicker({
            format: dateFormat,
            viewMode: 'months',
            minViewMode: 'months',
            orientation: 'bottom',
            autoclose: true,
            todayHighlight: !0,
            defaultDate: "+1w",
            showAnim: "blind",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 2,
        });
    } else {
        $('.' + className).datepicker({
            format: dateFormat,
            orientation: 'bottom',
            autoclose: true,
            todayHighlight: !0,

            defaultDate: "+1w",
            showAnim: "blind",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 2,


        });
    }
}

function datePickerReset(className, classNameReset, dateNameReset, formatDate, monthYear) {
    datePicker(className, formatDate, monthYear);
    dateReset(classNameReset, dateNameReset);
}

function dateReset(className, dateName) {
    $('.' + className).on('click', function() {
        $('.' + dateName).val("");
    });
}
