@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-users"></i> Users
					</div>
                    <div class="actions">
                        <a type="button" class="btn blue" data-toggle="modal" href="/administrasi/user/cari">
                            <i class="fa fa-btn fa-plus"></i>Tambah User BUMN
                        </a>
                    </div>
                    <div class="actions">
                        <a type="button" class="btn red" data-toggle="modal" href="/administrasi/user/downloadPDF">
                            <i class="fa fa-btn fa-download"></i>Download to PDF
                        </a>
                    </div>
                    <div class="actions">
                        <a type="button" class="btn green" data-toggle="modal" href="/administrasi/user/downloadExcel">
                            <i class="fa fa-btn fa-download"></i>Download to Excel
                        </a>
                    </div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-hover" id="tableUsers">
    					<thead>
        					<tr>
    							<th>Username</th>
                                <th>Nama</th>
    							<th>Email</th>
    							<th>Roles</th>
<!--    							<th>NIP</th>-->
    							<th>&nbsp;</th>
    							<th>&nbsp;</th>
        					</tr>
    					</thead>
    					<tbody>
		                 @if (count($users) > 0)
							@foreach ($users as $user)
							<tr>
								<td>{{ $user->username }}</td>
                                <td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td><ul class="no-margin">
                                <?php
                                foreach($user->roles as $val){
                                    echo '<li>'.$val->name.'</li>';
                                }
                                ?></ul>
                                </td>
<!--								<td> $user->employee->employee_number </td>-->
								<td>
                                    <a  class="btn btn-primary btn-xs" href="/administrasi/user/detail/{{$user->username}}">
										<i class="fa fa-btn fa-search"></i>Detail
                                    </a>
								</td>
								<td>
                                    @if($user->is_external)
									<form action="/administrasi/user/{{ $user->id }}" method="POST">
										{{ csrf_field() }}
										{{ method_field('DELETE') }}

										<button type="button" id="delete-user-{{ $user->id }}" class="btn btn-danger btn-xs deleteUser">
											<i class="fa fa-btn fa-trash"></i>Delete
										</button>
									</form>
                                    @endif
								</td>
							</tr>
							@endforeach
		                 @endif
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
    var oTable = $("#tableUsers").dataTable({
        "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        "deferRender": true,
        "order": [
            [0, 'asc']
        ],
        "lengthMenu": [
            [5, 10, 15, 20, -1],
            [5, 10, 15, 20, "All"]
        ],
        "pageLength": -1 
    });


    var tableWrapper = $('#tableUsers_wrapper');
    tableWrapper.find('.dataTables_length select').select2();
    
    $('.deleteUser').click(function(){
        var that = this;
        bootbox.confirm("Anda yakin akan menghapus data ini?", function(result) {
           if (result){
                $(that).closest('form').submit();
           }
        });
    });
});
</script>
@endsection