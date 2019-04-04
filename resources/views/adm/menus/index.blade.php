@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-green-haze">
						<i class="icon-settings font-green-haze"></i>
						<span class="caption-subject bold uppercase"> Menus</span>
					</div>
					<div class="actions">
						<button type="button" class="btn blue" data-toggle="modal" href="#modalAddMenu">
                            <i class="fa fa-btn fa-plus"></i>Add Menu
                        </button>
					</div>
				</div>
				<div class="portlet-body">
                    @include('common.errors')
					<div class="dd" id="nestable_menu">
                        <?=$menus?>
					</div>
				</div>
			</div>
        </div>
    </div>
    
	<div id="modalAddMenu" class="modal fade" tabindex="-1" data-width="760" data-focus-on="input:first">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Add New Menu</h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
                
					<form id="addMenuForm" class="form-horizontal margin-bottom-40" action="/adm/menu" method="POST" role="form">
    					{{ csrf_field() }}
    					<div class="alert alert-danger display-hide">
    						<button class="close" data-close="alert"></button>
    						You have some form errors. Please check below.
    					</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label">Label <span class="required"> * </span></label>
							<div class="col-md-4 input-icon right">
								<input type="text" class="form-control" placeholder="Label" name="label" value="{{ old('label') }}" />
								<div class="form-control-focus"></div>
                                <i class="fa"></i>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label">Link</label>
							<div class="col-md-4">
								<input type="text" class="form-control" placeholder="Link" name="link" value="{{ old('link') }}" />
								<div class="form-control-focus">
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label">Description</label>
							<div class="col-md-4">
								<input type="text" class="form-control" placeholder="Icon" name="icon" value="{{ old('icon') }}" />
								<div class="form-control-focus">
								</div>
							</div>
                            <div class="col-md-2">
                                <button class="btn blue modalButton" data-toggle="modal" data-sourcebutton="add">Icons</button>
                            </div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
                                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
    							<button type="submit" class="btn blue">
                                    <i class="fa fa-btn fa-plus"></i>Add Menu
                                </button>
							</div>
						</div>
					</form>
                </div>
			</div>
		</div>
		<div class="modal-footer">
		</div>
	</div>
    
	<div id="modalEditMenu" class="modal fade" tabindex="-1" data-width="760" data-focus-on="input:first">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Edit Menu</h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
                
					<form id="editMenuForm" class="form-horizontal margin-bottom-40" action="" method="POST" role="form">
    					{{ csrf_field() }}
                        {{ method_field('PUT') }}
    					<div class="alert alert-danger display-hide">
    						<button class="close" data-close="alert"></button>
    						You have some form errors. Please check below.
    					</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label">Label <span class="required"> * </span></label>
							<div class="col-md-4 input-icon right">
								<input type="text" class="form-control" placeholder="Label" name="label" />
								<div class="form-control-focus"></div>
                                <i class="fa"></i>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label">Link</label>
							<div class="col-md-4">
								<input type="text" class="form-control" placeholder="Link" name="link" />
								<div class="form-control-focus">
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label">Description</label>
							<div class="col-md-4">
								<input type="text" class="form-control" placeholder="Icon" name="icon" />
								<div class="form-control-focus">
								</div>
							</div>
                            <div class="col-md-2">
                                <button class="btn blue modalButton" data-toggle="modal" data-sourcebutton="edit">Icons</button>
                            </div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
                                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
    							<button type="submit" class="btn blue">
                                    <i class="fa fa-btn fa-pencil"></i>Edit Menu
                                </button>
							</div>
						</div>
					</form>
                </div>
			</div>
		</div>
		<div class="modal-footer">
		</div>
	</div>
    
    @include('adm.menus.icons')
@endsection

@section('jspluginscript')
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-markdown/lib/markdown.js"></script>
<script src="/assets/global/plugins/jquery-nestable/jquery.nestable.js"></script>
<script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
@endsection

@section('csspluginscript')
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/jquery-nestable/jquery.nestable.css"/>
<link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
<link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
@endsection

@section('jsscript')
<script type="text/javascript">
jQuery(document).ready(function() {
    var editModalClone = $("#modalEditMenu").clone().removeAttr("id");
    $("#modalEditMenu").remove();
    $('#nestable_menu').nestable({
        group: 1,
        maxDepth: 4
    }).on('change', function (e) {
        var list = $(this);
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: '/adm/menu/reorder',
            data: {data: JSON.stringify(list.nestable('serialize'))},
            success: function(data){
                toastr[data.type](data.message, data.title);
                return;
            }
        });
    });
    $(".modalButton").click(function(){
        $("#modalIcon").attr("data-sourcebutton", $(this).attr("data-sourcebutton")).modal('show');
    });
    
    $("#tab_1_1 .fa-item").click(function(event){
        $("#"+$("#modalIcon").attr("data-sourcebutton")+"MenuForm input[name='icon']").val($(this).children('i.fa').attr('class'));
    });
    $("#tab_1_2 li").click(function(event){
        $("#"+$("#modalIcon").attr("data-sourcebutton")+"MenuForm input[name='icon']").val($(this).children('span.glyphicon').attr('class'));
    });
    $("#tab_1_3 span.item-box").click(function(event){
        $("#"+$("#modalIcon").attr("data-sourcebutton")+"MenuForm input[name='icon']").val($(this).children('span.item').children('span').attr('class'));
    });
    
    var validatorForm = function(context){
        $("form", context).each(function(){
            var form = $(this);
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);
        
            form.validate({
                errorElement: 'span',
                errorClass: 'help-block help-block-error',
                focusInvalid: false,
                ignore: "",
                rules: {
                    label: {
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
                    form.submit();
                }
            }); 
        });
    };
    validatorForm(document);
    
    $("a.editModal").click(function(){
        var item = $(this).closest("li.dd-item");
        var id = item.attr("data-id");
        var label = $(".menuLabel", item).first().text();
        var icon = $(".menuIcon span", item).first().attr('class');
        var link = $(".menuLink", item).first().text();
        var modalElm = editModalClone.clone();
        $("input[name='label']", modalElm).val($.trim(label));
        $("input[name='icon']", modalElm).val($.trim(icon));
        $("input[name='link']", modalElm).val($.trim(link));
        $("form", modalElm).attr('action', '/adm/menu/'+id);
        validatorForm(modalElm);
        $(".modalButton", modalElm).bind('click', function(){
            $("#modalIcon").attr("data-sourcebutton", $(this).attr("data-sourcebutton")).modal('show');
        });
        $(modalElm).modal('show');
    });
    
    $('.deleteMenu').click(function(){
        var that = this;
		if (!$('#dataConfirmModal').length) {
			$('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="dataConfirmLabel">Please Confirm</h3></div><div class="modal-body"></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button><a class="btn btn-primary" id="dataConfirmOK" data-dismiss="modal" aria-hidden="true">OK</a></div></div>');
		} 
		$('#dataConfirmModal').find('.modal-body').text('Are you sure ?');
		$('#dataConfirmOK').bind('click', function(){
            $(that).closest('form').submit();
		});
		$('#dataConfirmModal').modal({show:true});
		return false;
    });
    
    
});
</script>
@endsection