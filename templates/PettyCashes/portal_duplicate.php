<?php
use Cake\Utility\Hash;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PettyCash[]|\Cake\Collection\CollectionInterface $pettyCashes
 */
$cross = '<i class="fa fa-times"></i>';
$tick = '<i class="fa fa-check"></i>';
$hourglass = '<i class="fa fa-hourglass-half"></i>';
?>
<style>      
/* Define the classes to be used in the table */    
.stripe-1 {
  background-color: #ffffff !important;
}

.stripe-2 {
  background-color: #fce3bf !important;
}

</style>
<?= $this->Krs->breadcrumb('Data', 'Petty Cash', 'Portal') ?>
<div class="panel panel-inverse">
    <ul class="nav nav-tabs nav-tabs-inverse nav-justified nav-justified-mobile" data-sortable-id="index-2">
        <li class="nav-item"><a href="#triatama" data-toggle="tab" class="nav-link active"><i class="fa fa-recycle fa-lg m-r-5"></i> <span class="d-none d-md-inline">Triatama</span></a></li>
        <li class="nav-item"><a href="#mozaik" data-toggle="tab" class="nav-link"><i class="fa fa-kaaba fa-lg m-r-5"></i> <span class="d-none d-md-inline">Mozaik</span></a></li>
        <li class="nav-item"><a href="#mpp" data-toggle="tab" class="nav-link"><i class="fa fa-feather fa-lg m-r-5"></i> <span class="d-none d-md-inline">MPP</span></a></li>
        <li class="nav-item"><a href="#sisi" data-toggle="tab" class="nav-link"><i class="fa fa-dice-d20 fa-lg m-r-5"></i> <span class="d-none d-md-inline">8 Sisi</span></a></li>
        <li class="nav-item"><a href="#njkreatif" data-toggle="tab" class="nav-link"><i class="fa fa-dumpster fa-lg m-r-5"></i> <span class="d-none d-md-inline">NJKreatif</span></a></li>
    </ul>
    <?php //bg-aqua text-white ?>
    <div class="tab-content" data-sortable-id="index-3">
        <div class="tab-pane fade active show" id="triatama">
            <table id="table-triatama" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                    <tr>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Total PCA</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
                <?php
                /*
                 class="height-400" data-scrollbar="true"
                 cell-border compact stripe
                <div class="table-responsive"></div>
                */
                ?>
            <div class="modal fade" id="modal-triatama" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog"></div>

        </div>

        <div class="tab-pane fade" id="mozaik">
            <div class="height-sm" data-scrollbar="true">
            Mozaik
            </div>
        </div>
        <div class="tab-pane fade" id="mpp">
            <div class="height-sm" data-scrollbar="true">
            MPP
            </div>
        </div>
        <div class="tab-pane fade" id="sisi">
            <div class="height-sm" data-scrollbar="true">
            8Sisi
            </div>
        </div>
        <div class="tab-pane fade" id="njkreatif">
            <div class="height-sm" data-scrollbar="true">
            NJKreatif
            </div>
        </div>
    </div>

</div>
<script>
$(document).ready(function() {
    
    $(".select2Form").select2({ allowClear: true });
    //TableManageCombine.init();
    var urlDataTable = "<?php echo $this->Url->build(['controller' => 'petty_cashes', 'action' => 'portal_api', '_full'=>true]); ?>";
    var formActionApproveCeo = "<?php echo $this->Url->build(['controller' => 'petty_cashes', 'action' => 'approve_ceo', '_full'=>true]); ?>";
    var formActionPreview = "<?php echo $this->Url->build(['controller' => 'petty_cashes', 'action' => 'preview', '_full'=>true]); ?>";

    $('#table-triatama').DataTable({
        stripeClasses: ['stripe-1',
                        'stripe-2'],
        lengthMenu: [[ 15, 30, -1], [ 15, 30, "All"]], // page length options
        bProcessing: true,
        bDestroy: true,
        bDeferRender: true,
        iDisplayLength: 15,
        fixedColumns: false,
        sPaginationType: "full_numbers",
        serverSide: true,
        scrollY: 500,
        //responsive: true,
        //scrollX: true,
        //order: [0, "asc"],
        scrollCollapse: true,
        ajax: {
            url: urlDataTable, // json datasource
            type: "get",
            data: {
              // key1: value1 - in case if we want send data with request
            }
            // datatype: "json",
            // headers: { "__requestverificationtoken": token }
        },
        columns: [
            {  
                data: "pcaCode",
                render: function(data, type, row){
                    return data.split("^").join("<br/>");
                }
            },
            { 
                data: "pcaProgress",
                render: function(data, type, row){
                    return data.split("^").join("<br/>");
                }
            },
            { 
                data: "pcaLineAmount", width: "90", "sClass": "dt-right", sortable: false, searchable: false, type: "numeric",
                render: $.fn.dataTable.render.number( '.', ',', 2 )
            },
            { 
                bSortable: false, bSearchable: false, "sClass": "dt-center", "sWidth": "120",
                render: function ( data, type, row ) {
                    var dataId = row.pcaId;
                    if(row.pcaApproveCeo=='-') {
                        //var action = '<div id="statusActive9699"><a href="javascript:;" onClick="changeStatusActive('+ dataId +', N, 2)" class="btn btn-danger btn-icon btn-circle btn-sm"><i class="fa fa-times"></i></a></div>';
                        var iconBtn = '<i class="fa fa-times"></i></a>';
                        var colorBtn = 'btn-danger';
                        var dataBtn = dataId+'^Y^'+<?php echo $getUser->id; ?>;
                    } else {
                        //var action = '<div id="statusActive9699"><a href="javascript:;" onClick="changeStatusActive('+ dataId +', N, 2)" class="btn btn-lime btn-icon btn-circle btn-sm"><i class="fa fa-check"></i></a></div>';
                        var iconBtn = '<i class="fa fa-check"></i></a>';
                        var colorBtn = 'btn-lime';
                        var dataBtn = dataId+'^N^'+<?php echo $getUser->id; ?>;
                    }
                    
                    var actionBtn = '<button type="button" id_data="' + dataId + '" class="btn btn-yellow btn-sm p-l-15 p-r-15 btnPreview" id="btn-preview'+ dataId +'"><i class="fa fa-desktop"></i></button>   <button type="button" id_data="' + dataBtn + '" class="btn '+colorBtn+' btn-sm p-l-15 p-r-15 btnApproveCeo" id="btn-approve-ceo'+ dataId +'">'+iconBtn+'</button>';

                    return actionBtn;
                }
            },

        ],
        columnDefs: [
            { orderable: false, targets: [0, 1, 2, 3] }
        ],
        oLanguage: {            
            
            "sInfo": "Halaman _PAGE_ sampai _PAGES_, Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
            "sEmptyTable": "Tidak ada data yang dapat ditampilkan",
            "sInfoEmpty": "Tidak ada data yang dapat ditampilkan",
            "sInfoFiltered": "(Ditemukan dari  total _MAX_ data)",
            "infoEmpty": "Data tidak ditemukan",
            "sZeroRecords": "Tidak ada data yang cocok",
            "sSearch": '<span class="dataTables_info">Pencarian:</span>',
            "processing": "Sedang memproses data...",
            "loadingRecords": "Sedang memuat data...",
            "sUrl": "",
            "oPaginate": {
                "sFirst":    "&lang;",
                "sPrevious": "&lang;&lang;",
                "sNext":     "&rang;",
                "sLast":     "&rang;&rang;"
            }
        },
        bFilter: true, // to display datatable search
    });

    

    $(document).on("click", ".btnPreview", function(){
        var $modal = $('#modal-triatama');
        var id_data=$(this).attr("id_data");
        var value = {
            id_data: id_data
        };
        
        // Alamat untuk edit form
        var formAction = formActionPreview+'/'+id_data;
        // $('body').modalmanager('loading');

        setTimeout(function(){
            $modal.load(formAction, '', function(){
                $modal.modal();
            });
        }, 1000);
    });

    $(document).on("click", ".btnApproveCeo", function(){

        var confirmTitle = "Apakah anda yakin ingin memproses PCA tersebut ?";
        var id_data=$(this).attr("id_data");
        var value = {
            id_data: id_data
        };

        var idData = id_data.split("^");

        var $form = $(this).closest('form');
        bootbox.confirm(confirmTitle, function(result) {
            if(result==true) {
                // Alamat untuk edit form
                jQuery.ajax({
                    type: "GET",
                    async: true,
                    cache: false,
                    dataType: "html",
                    data: {
                        id:idData[0], status:idData[1], userId:idData[2]
                    }, 
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                    },
                    // data: value,
                    url: formActionApproveCeo,
                   
                    success: function(data, textStatus, jqXHR) {
                        //$('#modal-triatama').modal('show');                       
                        var table = $('#table-triatama').DataTable(); 
                        table.ajax.reload( null, false );
                        swal({
                          title: "Berhasil",
                          text: "Terima kasih, data PCA berhasil diubah.",
                          timer: 4500,
                          icon: 'success',
                          button: false,
                          // showConfirmButton: false,                          
                          //className: 'facebook',
                        });                     
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                       swal("Error!", textStatus, "error");
                    }
                });
                return true;
            }
        });



        /*var $modal = $('#ajax-modal');

        var id_data=$(this).attr("id_data");
        var value = {
            id_data: id_data
        };
        alert("approve"+id_data);*/
/*
        // Alamat untuk edit form
        var formAction = formActionEdit+'/'+id_data;
        $//('body').modalmanager('loading');

        setTimeout(function(){
            $modal.load(formAction, '', function(){
                $modal.modal();
            });
        }, 1000);*/
    });



});
</script>
<?php
    /*
    var actionPreview = '<a href="javascript:void(0)" class="btn btn-yellow btn-sm btn-preview p-l-15 p-r-15" data-toggle="tooltip" data-placement="top" data-original-title="Tampilkan" data-id="'+ dataId +'" id="btn-preview'+ dataId +'"><i class="fa fa-desktop"></i></a>';


    var action = '<button type="button" id_data="' + dataId + '" class="btn btn-warning m-r-5 btnTableEdit"><i class="fa fa-pencil-alt"></i></button><button type="button" id_data="' + dataId + '" class="btn btn-danger m-r-5 btnTableDelete"><i class="fa fa-trash-alt"></i></button>';


    data: "codePca"+"<br />"+"purpose_of_advancing" }

    "sLengthMenu": '<span class="dataTables_info">Tampilkan _MENU_ data per halaman</span>',

    var urlDataTable = "<?php echo $this->Html->url(array('controller'=>'petty_cashes', 'action' => 'edit_many_datatable?idJournal='.(!empty($accJournalId) ? $accJournalId:''))); ?>";
    //var urlDataTable = "<?php //echo $this->Html->url(array('event_id' => $uuid, 'controller'=>'acc_journal_lines', 'action' => 'edit_many_datatable.json'.(!empty($accJournalId) ? '/'.$accJournalId:''))); ?>";
    //"sSearch": "<?php //echo (!empty($accJournalId) ? $accJournalId:''); ?>",
        //"bSearchable_0": true,
        //"sSearch_0": "<?php //echo (!empty($accJournalId) ? $accJournalId:''); ?>",
     var xdefault = {       
        "bDestroy": true,
        "bDeferRender": true,
        "iDisplayLength": 10,
        "fixedColumns":   false,
        "scrollCollapse": true,        
        "bProcessing": true,
        "bServerSide": true,        
        "sDom": "Blfrtip",        
        "sAjaxSource": urlDataTable,
        "sPaginationType": "full_numbers",
        "oLanguage": {
            "sLengthMenu": '<span class="dataTables_info">Tampilkan _MENU_ data per halaman</span>',
            "sInfo": "Halaman _PAGE_ sampai _PAGES_, Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
            "sEmptyTable": "Tidak ada data yang dapat ditampilkan",
            "sInfoEmpty": "Tidak ada data yang dapat ditampilkan",
            "sInfoFiltered": "(Ditemukan dari  total _MAX_ data)",
            "infoEmpty": "Data tidak ditemukan",
            "sZeroRecords": "Tidak ada data yang cocok",
            "sSearch": '<span class="dataTables_info">Pencarian:</span>',
            "sProcessing": "Sedang memproses data...",
            "sLoadingRecords": "Sedang memuat data...",
            "sUrl": "",
            "oPaginate": {
                "sFirst":    "Awal",
                "sPrevious": "Balik",
                "sNext":     "Lanjut",
                "sLast":     "Akhir"
            }
        },
        //{mData:"AccJournalLine.position", bSortable: false, bSearchable: false},
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            },
        ],
       
        "aoColumns": [
            {mData:"AccJournalLine.id"},
            {mData:"AccJournalLine.position"},
            {mData:"AccJournalLine.ledgerdc", "sWidth": "30", "sClass": "dt-center"},
            {mData:"AccChartOfAccount.customer_name", "sWidth": "250", "sClass": "dt-left"},
            {mData:"AccJournalLine.name", "sClass": "dt-left"},
            {mData:"AccJournalLine.debet", "sWidth": "90", "sClass": "dt-right", bSortable: false, bSearchable: false, "type": "numeric",
                mRender: $.fn.dataTable.render.number( '.', ',', 2 )
                //, 'Rp '
            },
            {mData:"AccJournalLine.credit", "sWidth": "90", "sClass": "dt-right", bSortable: false, bSearchable: false, "type": "numeric",
                mRender: $.fn.dataTable.render.number( '.', ',', 2, )
            },
            {bSortable: false, bSearchable: false, "sClass": "dt-center", "sWidth": "70",
                "mRender": function ( data, type, row ) {
                    var dataId = row.AccJournalLine.id;
                    var action = '<button type="button" id_data="' + dataId + '" class="btn btn-warning m-r-5 btnTableEdit"><i class="fa fa-pencil-alt"></i></button><button type="button" id_data="' + dataId + '" class="btn btn-danger m-r-5 btnTableDelete"><i class="fa fa-trash-alt"></i></button>';
                    // id="btnTableEdit"
                    // id="btnTableDelete"
                    //var action = '<a class="btn btn-warning btn-sm m-r-5" href=trucks/edit/' + dataId + '>' + '<i class="fa fa-edit"></i>' + '</a>';
                    return action;
                }
            },
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            //var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '£' ).display;
            var numFormat = $.fn.dataTable.render.number( '.', ',', 2).display;

            var pageTotalDebet = api.column( 5, { page:'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
            var pageTotalCredit = api.column( 6, { page: 'current'} ).data().reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(numFormat(pageTotalDebet));
            $( api.column( 6 ).footer() ).html(numFormat(pageTotalCredit));
            if(pageTotalDebet==pageTotalCredit) {
                //alert("sama oeee");
                $("#btn-add").prop("disabled", false);
            } else {
                //alert("tidak sama oeee");
                $("#btn-add").prop("disabled", true);
            }
        }
    };

    // {mData:"User.full_name",bSearchable:false}, // can't search virtual fields
    $.fn.DataTable.ext.errMode = 'none';
    var oTable = $('#myTable').DataTable(xdefault);
    */
?>