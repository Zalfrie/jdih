@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-settings"></i>
						<span class="caption-subject bold uppercase"> REFERENSI KOTA</span>
					</div>
					<div class="actions">
						<a type="button" class="btn blue" data-toggle="modal" href="/administrasi/referensi/kota/tambah">
                            <i class="fa fa-btn fa-plus"></i>Tambah Baru
                        </a>
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered table-hover" id="tableData">
    					<thead>
        					<tr>
                                <th>No</th>
    							<th>Nama Kota</th>
    							<th></th>
        					</tr>
    					</thead>
    					<tbody>
    					</tbody>
					</table>
				</div>
			</div>
        </div>
    </div>
@endsection

@section('jspluginscript')
<script type="text/javascript" src="/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
@endsection

@section('csspluginscript')
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
@endsection

@section('jsscript')
<script type="text/javascript">
jQuery(document).ready(function() {
    
    var oTable = $('#tableData').dataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": '/administrasi/referensi/kota/getdatatable',
            "type": "POST"
        },
        "columns": [
            {data: null, sortable: false, searchable: false, width: "20px", className: "text-center"},
            {data: 'nama', name: 'nama'},
            {data: 'actions', name: 'actions', searchable: false, sortable: false, width: "20%"}
        ],
        "order": [
            [1, 'asc']
        ],
        "lengthMenu": [
            [10, 20, -1],
            [10, 20, "All"]
        ],
        "pageLength": 20,
        "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        "rowCallback": function( row, data, iDisplayIndex ) {
            var info = oTable.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = (page * length + (iDisplayIndex +1));
            $('td:eq(0)', row).html(index);
    
            $('.deleteData', row).click(function(){
                var that = this;
                bootbox.confirm("Anda yakin akan menghapus data ini?", function(result) {
                   if (result){
                        $(that).closest('form').submit();
                   }
                });
            });
        }
    });
    var tableWrapper = $('#tableData_wrapper');
    tableWrapper.find('.dataTables_length select').select2();
});
</script>
@endsection