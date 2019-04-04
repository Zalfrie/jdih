
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
			<div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						Watermark File PDF
					</div>
				</div>
				<div class="portlet-body form">
					<form id="Form" class="form-horizontal" action="/administrasi/referensi/watermark" method="POST" enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}
						<div class="form-body">
    						<div class="form-group">
    							<label class="col-md-3 control-label">File Gambar</label>
    							<div class="col-md-9">
                                <?php
                                $fileImage = \Config::get('constants.public_upload').'watermark.png';
                                $image = \Image::make($fileImage);
                                $width = $image->width();
                                $height = $image->height();
                                ?>
    								<div class="fileinput fileinput-new" data-provides="fileinput">
    									<div class="fileinput-new thumbnail">
    										<img src="/assets/upload/watermark.png" alt=""/>
    									</div>
    									<div class="fileinput-preview fileinput-exists thumbnail">
    									</div>
    									<div>
    										<span class="btn default btn-file">
    										<span class="fileinput-new">
    										Select image </span>
    										<span class="fileinput-exists">
    										Change </span>
    										<input type="file" name="image" required="required">
    										</span>
    										<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
    										Remove </a>
    									</div>
    								</div>
    							</div>
    						</div>
    						<div class="form-group">
    							<label class="col-md-3 control-label"></label>
    							<div class="col-md-9">
    								<div class="md-checkbox-list">
    									<div class="md-checkbox">
    										<input type="checkbox" id="checkbox1" value="1" name="greyscale" class="md-check">
    										<label for="checkbox1">
    										<span></span>
    										<span class="check"></span>
    										<span class="box"></span>
    										Greyscale </label>
    									</div>
                                    </div>
                                </div>
                            </div>
    						<div class="form-group">
    							<label class="col-md-3 control-label">Transparansi (%)</label>
    							<div class="col-md-1">
    								<div class="md-checkbox-list">
    									<input type="text" class="form-control input-sm" name="opacity" value="10" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
        							<button type="submit" class="btn green">Simpan</button>
                                </div>
                            </div>
						</div>
					</form>
						<div class="form-horizontal form-body">
                            <div class="row">
    							<label class="col-md-3 control-label bold">Contoh Hasil</label>
    							<div class="col-md-9">
                                    <object data="/administrasi/referensi/exwatermark" type="application/pdf" width="100%" height="900px">
                                    </object>
                                </div>
                            </div>
                        </div>
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
    var form = $('#Form');
    var error = $('.alert-danger', form);
    var success = $('.alert-success', form);

    form.validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: false,
        ignore: "",
        rules: {
            "opacity": {
                required: true,
                min: 0,
                max: 100
            },
            image: {
                required: true,
                accept: "image/*"
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