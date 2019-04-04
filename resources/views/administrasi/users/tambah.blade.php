
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
			<div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-book-open"></i> Tambah User BUMN
					</div>
				</div>
				<div class="portlet-body form">
					<!--<form action="/administrasi/user/cari" class="form-horizontal" method="POST">
						{{ csrf_field() }}
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Cari Username Lain</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="search" value="{{ old('search') }}" />
                                </div>
                                <div class="col-md-1">
    								<button type="submit" class="btn green btn-sm">Cek Username</button>
                                </div>
							</div>
						</div>
					</form>-->
                    <hr />
                    @include('common.errors')
					<form id="newDataForm" class="form-horizontal" action="/administrasi/user/tambah" method="POST" role="form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <input type="hidden" name="type" value="{{ old('type') == 'activate'?'activate':'new' }}" />
						<div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">BUMN<span class="required">*</span></label>
                                <div class="col-md-4">
                                    <select class="form-control select2 input-sm" name="id_bumn" required>
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
								<label class="col-md-3 control-label">Email<span class="required">*</span></label>
                                <div class="col-md-4">
    								<input type="text" name="email" class="form-control input-sm" value=""}/>
                                </div>
							</div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">No Handphone</label>
                                <div class="col-md-4">
                                    <input type="number" name="handphone" class="form-control input-sm"/>
                                </div>
                            </div>
							<!--<div class="form-group">
								<label class="col-md-3 control-label">NIP</label>
                                <div class="col-md-4">
    								<input type="text" name="nip" {{ old('type') == 'activate'?'readonly="readonly"':'' }} required="required" class="form-control input-sm" value="{{ old('nip') }}" />
                                </div>
							</div>-->
                            <!--@if(old('type') != 'activate')
							<div class="form-group">
								<label class="col-md-3 control-label">Password</label>
                                <div class="col-md-4">
    								<input type="password" class="form-control" autocomplete="off" id="register_password" placeholder="Password" name="password" required="required" minlength="8" />
                                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Ulangi Password</label>
                                <div class="col-md-4">
    								<input type="password" class="form-control" autocomplete="off" placeholder="Ulangi Password" name="password_confirmation" required="required" equalTo="#register_password" />
                                </div>
							</div>
                            @endif
                            <hr />
							<div class="form-group">
								<label class="col-md-3 control-label">Role User</label>
								<div class="col-md-6">
									<div class="md-checkbox-list checkbox-list" data-error-container="#form_roles_error">
                                    @if (count($roles) > 0)
                                    @foreach($roles as $i => $val)
										<div class="md-checkbox">
    										<input type="checkbox" name="role[]" value="{{ $val->id }}" id="checkbox{{ $i }}" class="md-check" />
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
											<img src="/assets/global/img/noimage.png" alt=""/>
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
						</div>-->
						<div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
            						<a href="/administrasi/users" class="btn red">
            							<i class="fa fa-btn fa-long-arrow-left"></i>Batal
            						</a>
        							<button type="button" class="btn green simpanUserBaru">Tambah</button>
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
<script type="text/javascript" src="/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
@endsection

@section('csspluginscript')
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
@endsection

@section('jsscript')
<script type="text/javascript">
jQuery(document).ready(function() {

    $(".select2").select2();
    $('.simpanUserBaru').click(function(){
        var that = this;
        bootbox.confirm("Anda yakin akan menyimpan data ini?", function(result) {
            if (result){
                $(that).closest('form').submit();
            }
        });
    });
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