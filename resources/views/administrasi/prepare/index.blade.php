@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
			<div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						PREPARE BUMN
					</div>
				</div>
				<div class="portlet-body form">
					<!-- Display Validation Errors -->
					@include('common.errors')

					<form id="FormData" class="form-horizontal" action="/administrasi/mukadimah-prepare" method="POST" role="form">
    					{{ csrf_field() }}
                        {{ method_field('PUT') }}
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Mukadimah</label>
                                <div class="col-md-9">
								    <textarea class="wysihtml5 form-control" rows="12" name="mukadimah">{{ $mukadimah->content }}</textarea>
                                </div>
							</div>
                        </div>
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Apa Itu PREPARE BUMN</label>
                                <div class="col-md-9">
								    <textarea class="wysihtml5 form-control" rows="12" name="mukadimah1">{{ $mukadimah1->content }}</textarea>
                                </div>
							</div>
                        </div>
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Ruang Lingkup Peraturan</label>
                                <div class="col-md-9">
								    <textarea class="wysihtml5 form-control" rows="12" name="mukadimah2">{{ $mukadimah2->content }}</textarea>
                                </div>
							</div>
                        </div>
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Output yang diharapkan</label>
                                <div class="col-md-9">
								    <textarea class="wysihtml5 form-control" rows="12" name="mukadimah3">{{ $mukadimah3->content }}</textarea>
                                </div>
							</div>
                        </div>
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Metode Evaluasi</label>
                                <div class="col-md-9">
								    <textarea class="wysihtml5 form-control" rows="12" name="mukadimah4">{{ $mukadimah4->content }}</textarea>
                                </div>
							</div>
                        </div>
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Bagaimana Berkontribusi & Waktu Pelaksanaan</label>
                                <div class="col-md-9">
								    <textarea class="wysihtml5 form-control" rows="12" name="mukadimah5">{{ $mukadimah5->content }}</textarea>
                                </div>
							</div>
                        </div>
						<div class="form-actions right">
							<button type="submit" class="btn green">Submit</button>
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
<script type="text/javascript" src="/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-markdown/lib/markdown.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
@endsection

@section('csspluginscript')
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
@endsection

@section('jsscript')
<script type="text/javascript">
jQuery(document).ready(function() {
    $('.wysihtml5').wysihtml5({"image": false, "color": true, "stylesheets": ["/assets/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]});
    var form = $('#FormData');
    var error = $('.alert-danger', form);
    var success = $('.alert-success', form);

    form.validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: false,
        ignore: "",
        rules: {
            beranda: {
                required: true
            },
            contact: {
                required: true
            }
        },

        invalidHandler: function (event, validator) {              
            success.hide();
            error.show();
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