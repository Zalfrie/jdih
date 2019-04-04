@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-green-haze">
						<i class="icon-settings font-green-haze"></i>
						<span class="caption-subject bold uppercase"> New Role</span>
					</div>
				</div>
				<div class="portlet-body form">
                    
					<!-- Display Validation Errors -->
					@include('common.errors')

					<form id="roleForm" class="form-horizontal margin-bottom-40" action="/adm/role" method="POST" role="form">
    					{{ csrf_field() }}
    					<div class="alert alert-danger display-hide">
    						<button class="close" data-close="alert"></button>
    						You have some form errors. Please check below.
    					</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label">Name <span class="required"> * </span></label>
							<div class="col-md-4 input-icon right">
								<input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}" />
								<div class="form-control-focus"></div>
                                <i class="fa"></i>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label">Display Name</label>
							<div class="col-md-4">
								<input type="text" class="form-control" placeholder="Display Name" name="display_name" value="{{ old('display_name') }}" />
								<div class="form-control-focus">
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label">Description</label>
							<div class="col-md-8">
								<textarea class="form-control" rows="3" placeholder="Description" name="description">{{ old('description') }}</textarea>
								<div class="form-control-focus">
								</div>
							</div>
						</div>
                        <h3>Permissions</h3>
		                 @if (count($permissions) > 0)
                        <div class="form-row-seperated">
							@for ($i = 0; $i < count($permissions); $i++)
                                @if ($i%4 == 0)
                        <div class="form-group">
                                @endif
							<div class="col-md-3">
								<div class="md-checkbox-inline">
									<div class="md-checkbox tooltiped" data-original-title="{{ $permissions[$i]->description }}">
										<input type="checkbox" name="permission[]" value="{{ $permissions[$i]->id }}" id="checkbox{{ $i }}" class="md-check" />
										<label for="checkbox{{ $i }}">
										<span></span>
										<span class="check"></span>
										<span class="box"></span>
										{{ $permissions[$i]->display_name }} </label>
									</div>
								</div>
							</div>
                                @if (($i+1)%4 == 0 || ($i+1) == count($permissions))
						</div>
                                @endif
                            @endfor
                        </div>
		                 @endif
                         
                        <h3>Menus</h3>
                        <div class="form-row-seperated">
                            <div id="tree_menu" class="tree-demo"></div>
                        </div>
                         
                        <div class="form-actions">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
    								<button type="submit" class="btn blue">
                                        <i class="fa fa-btn fa-plus"></i>Add Role
                                    </button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
            
            <div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-globe"></i>Roles
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-hover" id="tableRoles">
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
		                 @if (count($roles) > 0)
							@foreach ($roles as $role)
							<tr>
								<td>{{ $role->name }}</td>
								<td>{{ $role->display_name }}</td>
								<td>{{ $role->description }}</td>

								<td>
                                    <a  class="btn btn-primary btn-xs" href="/adm/role/{{ $role->id }}/edit">
										<i class="fa fa-btn fa-pencil"></i>Edit
                                    </a>
								</td>
								<td>
									<form action="/adm/role/{{ $role->id }}" method="POST">
										{{ csrf_field() }}
										{{ method_field('DELETE') }}

										<button type="button" id="delete-role-{{ $role->id }}" class="btn btn-danger btn-xs deleteRole">
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
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-markdown/lib/markdown.js"></script>
<script type="text/javascript" src="/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jstree/dist/jstree.min.js"></script>
@endsection

@section('csspluginscript')
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" />
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/jstree/dist/themes/default/style.min.css"/>
@endsection

@section('jsscript')
<script type="text/javascript">
jQuery(document).ready(function() {
    $('#tree_menu').jstree({
        'plugins': ["wholerow", "checkbox", "types"],
        'core': {
            "themes" : {
                "responsive": true
            },    
            'data': {
                type: "GET",
                dataType: 'json',
                url: '/adm/menu/getmenutree',
                data: {role: 0}
            }
        },
        "types" : {
            "default" : {
                "icon" : "fa fa-folder icon-state-warning icon-lg"
            },
            "file" : {
                "icon" : "fa fa-file icon-state-warning icon-lg"
            }
        }
    });
    
    var oTable = $("#tableRoles").dataTable({
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


    var tableWrapper = $('#tableRoles_wrapper');
    tableWrapper.find('.dataTables_length select').select2();
    
    
    var form = $('#roleForm');
    var error = $('.alert-danger', form);
    var success = $('.alert-success', form);

    form.validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: false,
        ignore: "",
        rules: {
            name: {
                required: true
            }
        },

        invalidHandler: function (event, validator) {              
            success.hide();
            error.show();
            Metronic.scrollTo(error, -200);
        },

        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },

        highlight: function (element) {
            var icon = $(element).parent('.input-icon').children('i');
            icon.removeClass('fa-check').addClass("fa-warning");
            $(element).addClass('edited');
            $(element)
                .closest('.form-group').removeClass("has-success").addClass('has-error');   
        },

        unhighlight: function (element) {
            $(element)
                .closest('.form-group').removeClass("has-error").addClass('has-success');
        },

        success: function (label, element) {
            var icon = $(element).parent('.input-icon').children('i');
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            icon.removeClass("fa-warning").addClass("fa-check");
            $(element).removeClass('edited');
        },

        submitHandler: function (form) {
            error.hide();
                var selectedElements = $("#tree_menu").jstree("get_selected", true);
                $.each(selectedElements, function () {
                    $('<input />').attr('type', 'hidden')
                        .attr('name', "menu[]")
                        .attr('value', this.id)
                        .appendTo(form);
                });
//                $("#tree_menu").find(".jstree-undetermined").each(function (i, element) {
//                    $('<input />').attr('type', 'hidden')
//                        .attr('name', "menu[]")
//                        .attr('value', $(element).closest('li').attr("id"))
//                        .appendTo(form);
//                });
            form.submit();
        }
    }); 
    
    $('.deleteRole').click(function(){
        var that = this;
        bootbox.confirm("Are you sure?", function(result) {
           if (result){
                $(that).closest('form').submit();
           }
        });
    });
    
    $('.tooltiped').tooltip({'container': 'body'});
});
</script>
@endsection