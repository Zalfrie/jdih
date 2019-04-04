@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-settings"></i>
						<span class="caption-subject bold uppercase"> Employees</span>
					</div>
					<div class="actions">
						<a type="button" class="btn blue" data-toggle="modal" href="/hr/employee/add">
                            <i class="fa fa-btn fa-plus"></i>Add New Employee
                        </a>
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-hover" id="tableEmployees">
    					<thead>
        					<tr>
                                <th>No</th>
    							<th>Employee Number</th>
    							<th>Name</th>
    							<th>Email</th>
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
    
	<form id="formDel" method="POST">
		{{ csrf_field() }}
		{{ method_field('DELETE') }}
	</form>
@endsection

@section('jspluginscript')
<script type="text/javascript" src="/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootbox/bootbox.min.js"></script>
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
    oTable = $('#tableEmployees').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": '/hr/employee/getdatatable',
            "type": "POST"
        },
        "columns": [
            {defaultContent: '', sortable: false, searchable: false},
            {data: 'employee_number', name: 'employee_number'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'actions', name: 'actions', searchable: false, sortable: false}
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
        "rowCallback": function( row, data, index ) {
            $(".deleteEmployee", row).click(function(){
                bootbox.confirm("Are you sure?", function(result) {
                   if (result){
                        $("form#formDel").attr('action', '/hr/employee/'+data.id).submit();
                   }
                });
            });
        }
    });
    var tableWrapper = $('#tableEmployees_wrapper');
    tableWrapper.find('.dataTables_length select').select2();
});
</script>
@endsection