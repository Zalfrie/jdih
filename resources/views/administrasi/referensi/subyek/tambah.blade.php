
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
			<div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-book-open"></i> Tambah Referensi Subyek
					</div>
				</div>
				<div class="portlet-body form">
                    @include('common.errors')
					<form id="newDataForm" class="form-horizontal" action="/administrasi/referensi/subyek" method="POST" role="form">
                    {{ csrf_field() }}
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Nama Subyek</label>
                                <div class="col-md-4">
    								<input type="text" name="subyek" required="required" class="form-control input-sm" value="{{ old('subyek') }}" />
                                </div>
							</div>
						</div>
						<div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
        							<a type="button" href="/administrasi/referensi/subyek" class="btn default">Kembali</a>
        							<button type="submit" class="btn green">Simpan</button>
                                </div>
                            </div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
@endsection

@section('jspluginscript')
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
@endsection

@section('csspluginscript')
@endsection

@section('jsscript')
<script type="text/javascript">
jQuery(document).ready(function() {
    
    var validatorMainForm = function(context){
        var form = $(context);
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
    
        form.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
            },
    
            invalidHandler: function (event, validator) {              
                success.hide();
                error.show();
                Metronic.scrollTo(error, -200);
            },
    
            errorPlacement: function (error, element) {
                if (element.parent(".input-group").size() > 0) {
                    error.insertAfter(element.parent(".input-group"));
                } else if (element.hasClass("fileinput")) { 
                    error.insertAfter(element.closest("div.fileinput"));
                } else if (element.attr("data-error-container")) { 
                    error.appendTo(element.attr("data-error-container"));
                } else if (element.parents('.radio-list').size() > 0) { 
                    error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                } else if (element.parents('.radio-inline').size() > 0) { 
                    error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                } else if (element.parents('.checkbox-list').size() > 0) {
                    error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                } else if (element.parents('.checkbox-inline').size() > 0) { 
                    error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
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
    };
    validatorMainForm($("#newDataForm"));
});
</script>
@endsection