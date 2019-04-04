@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-green-haze">
						<i class="icon-settings font-green-haze"></i>
						<span class="caption-subject bold uppercase"> Edit Permission</span>
					</div>
				</div>
				<div class="portlet-body">
                    
					<!-- Display Validation Errors -->
					@include('common.errors')

					<form class="form-horizontal margin-bottom-40" action="/adm/permission/{{ $permission->id }}" method="POST" role="form">
    					{{ csrf_field() }}
                        {{ method_field('PUT') }}
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label">Name</label>
							<div class="col-md-4">
								<input type="text" disabled class="form-control" placeholder="Name" name="name" value="{{ $permission->name }}" />
								<div class="form-control-focus">
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label">Display Name</label>
							<div class="col-md-4">
								<input type="text" class="form-control" placeholder="Display Name" name="display_name" value="{{ $permission->display_name }}" />
								<div class="form-control-focus">
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label">Description</label>
							<div class="col-md-8">
								<textarea class="form-control" rows="3" placeholder="Description" name="description">{{ $permission->description }}</textarea>
								<div class="form-control-focus">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn blue">
                                    <i class="fa fa-btn fa-pencil"></i>Update Permission
                                </button>
							</div>
						</div>
					</form>
				</div>
			</div>
            
            <div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-globe"></i>Permissions
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-hover" id="tablePermissions">
    					<thead>
        					<tr>
    							<th>Name</th>
    							<th>Display Name</th>
    							<th>Description</th>
    							<th>&nbsp;</th>
    							<th>&nbsp;</th>
        					</tr>
    					</thead>
    					<tbody>
		                 @if (count($permissions) > 0)
							@foreach ($permissions as $permission)
							<tr>
								<td>{{ $permission->name }}</td>
								<td>{{ $permission->display_name }}</td>
								<td>{{ $permission->description }}</td>

								<td>
                                    <a  class="btn btn-primary btn-xs" href="/adm/permission/{{ $permission->id }}/edit">
										<i class="fa fa-btn fa-pencil"></i>Edit
                                    </a>
								</td>
								<td>
									<form action="/adm/permission/{{ $permission->id }}" method="POST">
										{{ csrf_field() }}
										{{ method_field('DELETE') }}

										<button type="button" id="delete-permission-{{ $permission->id }}" class="btn btn-danger btn-xs deletePermission">
											<i class="fa fa-btn fa-trash"></i>Delete
										</button>
									</form>
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
    var oTable = $("#tablePermissions").dataTable({
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


    var tableWrapper = $('#tablePermissions_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
    tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    
    $('.deletePermission').click(function(){
        var that = this;
        bootbox.confirm("Are you sure?", function(result) {
           if (result){
                $(that).closest('form').submit();
           }
        });
    });
});
</script>
@endsection