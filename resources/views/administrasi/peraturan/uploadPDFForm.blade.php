
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
			<div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-book-open"></i> Upload File PDF
					</div>
				</div>
				<div class="portlet-body form">
                    @include('common.errors')
                    <form id="uploadForm" class="form-horizontal" action="/administrasi/peraturan/{{ $data->per_no }}/upload" enctype="multipart/form-data" method="POST" role="form">
                    {{ csrf_field() }}
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">&nbsp;</label>
                                <div class="col-md-9">
    								<p class="form-control-static">
                                    {{$data->per_no}}<br />
                                    Tentang {{$data->tentang}}
                                    </p>
                                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">&nbsp;</label>
                                <div class="col-md-4" id="pdfDiv">
                                @if(!empty($data->filedoc))
                                    <object width="100%" height="400px" type="application/pdf" data="/administrasi/peraturan/pdf/{{$data->file_id}}"> 
                                    </object>
                                @endif
                                </div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">File PDF</label>
								<div class="col-md-5">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="input-group input-large">
											<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
												<i class="fa fa-file-pdf-o fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
												</span>
											</div>
											<span class="input-group-addon btn default btn-file">
											<span class="fileinput-new">
											Select file </span>
											<span class="fileinput-exists">
											Change </span>
											<input type="file" name="pdf" required="required" extension="pdf" class="fileinput" />
											</span>
											<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
											Remove </a>
										</div>
									</div>
                                </div>
							</div>
							<div class="progress progress-striped active" style="height: 20px !important;">
								<div id="progresBar" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
									<span id="progresPersen"></span>
								</div>
							</div>
                        </div>
						<div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
        							<a type="button" href="/administrasi/peraturan" class="btn default">Kembali</a>
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
<script type="text/javascript" src="/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script src="/assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
@endsection

@section('csspluginscript')
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
<link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/typeahead/typeahead.css">
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
                $(element).addClass('edited');
                $(element)
                    .closest('div').removeClass("has-success").addClass('has-error');   
            },
    
            unhighlight: function (element) {
                $(element).closest('div').removeClass("has-error").addClass('has-success');
            },
    
            success: function (label, element) {
                $(element).closest('div').removeClass('has-error').addClass('has-success');
                $(element).removeClass('edited');
            },
    
            submitHandler: function (form) {
                error.hide();
                var formData = new FormData(form);
                $.ajax({
                    url: $(form).attr('action'),
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData:false,
                    dataType: 'json',
                    xhr: function(){
                        //upload Progress
                        var xhr = $.ajaxSettings.xhr();
                        if (xhr.upload) {
                            $("button[type='submit']", form).prop('disabled', true);
                            xhr.upload.addEventListener('progress', function(event) {
                                var percent = 0;
                                var position = event.loaded || event.position;
                                var total = event.total;
                                if (event.lengthComputable) {
                                    percent = Math.ceil(position / total * 100);
                                }
                                //update progressbar
                                $("#progresBar").attr("aria-valuenow", percent).css("width", + percent +"%");
                                $("#progresPersen").text(percent +"%");
                            }, true);
                        }
                        return xhr;
                    },
                    beforeSend: function() {
                        $("#progresBar").attr("aria-valuenow", 0).css("width", "0%");
                        $("#progresPersen").text('');
                    },
                    mimeType:"multipart/form-data"
                }).done(function(res){
                    $("button[type='submit']", form).prop('disabled', false);
                    if (res.result == 'yes'){
                        toastr['success']('Upload Berhasil.', 'Success');
                        $("#pdfDiv").empty().append($('<object width="100%" height="400px" type="application/pdf" data="/administrasi/peraturan/pdf/'+res.id+'"></object>'));
                    }else{
                        toastr['error']('Upload gagal.', 'Error');
                    }
                    
                });
            }
        });
    }
    validatorMainForm($("#uploadForm"));
});
</script>
@endsection