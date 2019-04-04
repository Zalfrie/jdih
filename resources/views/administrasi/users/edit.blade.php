
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
			<div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-book-open"></i> Tambah User
					</div>
				</div>
				<div class="portlet-body form">
                    @include('common.errors')
					<form id="newDataForm" class="form-horizontal" action="/administrasi/user/{{ $user->id }}" method="POST" role="form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Username</label>
                                <div class="col-md-4">
    								<input type="text" name="username" readonly="readonly" required="required" class="form-control input-sm" value="{{ $user->username }}" />
                                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Email</label>
                                <div class="col-md-4">
    								<input type="text" name="email" readonly="readonly" required="required" class="form-control input-sm" value="{{ $user->email }}" />
                                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Nama</label>
                                <div class="col-md-4">
    								<input type="text" name="nama" readonly="readonly" required="required" class="form-control input-sm" value=" $user->name " />
                                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">No Handphone</label>
                                <div class="col-md-4">
    								<input type="text" name="telp" readonly="readonly" required="required" class="form-control input-sm" value=" $user->name " />
                                </div>
							</div>
							<!--<div class="form-group">
								<label class="col-md-3 control-label">NIP</label>
                                <div class="col-md-4">
    								<input type="text" name="nip" readonly="readonly" required="required" class="form-control input-sm" value=" $user->employee->employee_number " />
                                </div>
							</div>-->
                            <div class="form-group">
                                <label class="col-md-3 control-label">BUMN</label>
                                <div class="col-md-5">
                                    <select class="form-control select2 input-sm" name="bumn" >
                                        <option></option>
                                        @if (count($bumn) > 0)
                                        @foreach ($bumn as $val)
                                        <option value="{{ $val['perusahaan_id'] }}">{{ $val['nama_lengkap'] }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
							<div class="form-group">
								<label class="col-md-3 control-label">Password</label>
                                <div class="col-md-4">
    								<input type="password" class="form-control" autocomplete="off" id="register_password" placeholder="Kosongkan jika tidak ingin ganti Password" name="password" minlength="8" />
                                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Ulangi Password</label>
                                <div class="col-md-4">
    								<input type="password" class="form-control" autocomplete="off" placeholder="Kosongkan jika tidak ingin ganti Password" name="password_confirmation" equalTo="#register_password" />
                                </div>
							</div>
                            <hr />
							<div class="form-group">
								<label class="col-md-3 control-label">Role User</label>
								<div class="col-md-6">
									<div class="md-checkbox-list checkbox-list" data-error-container="#form_roles_error">
                                    @if (count($roles) > 0)
                                    @foreach($roles as $i => $val)
                                    <?php
                                    if ($val->name == 'sys_admin' && $user->id == Auth::user()->id){
                                        $disabled = 'disabled="true"';
                                    }else{
                                        $disabled = '';
                                    }
                                    ?>
										<div class="md-checkbox">
    										<input type="checkbox" {{$disabled}} name="role[]" <?=(in_array($val->id, $rolesBelonged))?'checked':''?> value="{{ $val->id }}" id="checkbox{{ $i }}" class="md-check" />
    										<label for="checkbox{{ $i }}">
    										<span></span>
    										<span class="check"></span>
    										<span class="box"></span>
    										{{ $val->display_name }} </label>
										</div>
                                    @endforeach
                                    @endif
									</div>
									<span class="help-block">
									(Pilih minimal 1 role) </span>
									<div id="form_roles_error">
									</div>
								</div>
							</div>
                            <hr />
							<div class="form-group">
								<label class="col-md-3 control-label">Photo</label>
								<div class="col-md-9">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
											<img src=" $user->employee->image " alt=""/>
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
            						<a href="/administrasi/users" class="btn red">
            							<i class="fa fa-btn fa-long-arrow-left"></i>Batal
            						</a>
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
<script type="text/javascript" src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
@endsection

@section('csspluginscript')
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
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
                "role[]":{
                    required: true
                }
            },
    
            invalidHandler: function (event, validator) {              
                success.hide();
                error.show();
                Metronic.scrollTo(error, -200);
            },

            messages: { // custom messages for radio buttons and checkboxes
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