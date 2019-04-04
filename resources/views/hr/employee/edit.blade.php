
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
			<div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-users"></i> Edit Employee Data
					</div>
				</div>
				<div class="portlet-body form">
                    @include('common.errors')
					<form id="EmployeeForm" class="form-horizontal" action="/hr/employee/{{ $employee->id }}" method="POST" enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}
                        {{ method_field('PUT') }}
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Employee Number</label>
                                <div class="col-md-3">
								    <input type="text" name="empl_numb" class="form-control input-sm" value="{{ $employee->employee_number }}" />
                                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Name</label>
                                <div class="col-md-6">
								    <input type="text" name="name" class="form-control input-sm" value="{{ $employee->name }}" />
                                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Email</label>
                                <div class="col-md-6">
								    <input type="text" name="email" class="form-control input-sm" value="{{ $employee->email }}" />
                                </div>
							</div>
    						<div class="form-group">
    							<label class="col-md-3 control-label">Image</label>
    							<div class="col-md-9">
    								<div class="fileinput fileinput-new" data-provides="fileinput">
    									<div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
    										<img src="<?=$employee->image ? $employee->image : 'http://www.placehold.it/150x150/EFEFEF/AAAAAA&amp;text=no+image'?>" alt=""/>
    									</div>
    									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;">
    									</div>
    									<div>
    										<span class="btn default btn-file">
    										<span class="fileinput-new">
    										Select image </span>
    										<span class="fileinput-exists">
    										Change </span>
    										<input type="file" name="image">
    										</span>
    										<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
    										Remove </a>
    									</div>
    								</div>
    							</div>
    						</div>
						</div>
						<div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
        							<a type="button" href="/hr/employees" class="btn default">Cancel</a>
        							<button type="submit" class="btn green">Submit</button>
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
<script type="text/javascript" src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
@endsection

@section('csspluginscript')
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
@endsection

@section('jsscript')
<script type="text/javascript">
jQuery(document).ready(function() {
    var form = $('#EmployeeForm');
    var error = $('.alert-danger', form);
    var success = $('.alert-success', form);

    form.validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: false,
        ignore: "",
        rules: {
            empl_numb: {
                required: true
            },
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
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
</script>
@endsection