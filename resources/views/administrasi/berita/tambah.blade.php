
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
			<div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-book-open"></i> Tambah Berita Baru
					</div>
				</div>
				<div class="portlet-body form">
                    @include('common.errors')
					<form id="newDataForm" class="form-horizontal" action="/administrasi/berita" method="POST" enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}
						<div class="form-body">
                            <div class="row">
                                <div class="col-md-9">
        							<div class="form-group">
        								<label class="col-md-2 control-label">Judul</label>
                                        <div class="col-md-10">
        								    <input type="text" name="judul" class="form-control input-sm" value="{{ old('judul') }}" >
                                        </div>
        							</div>
        							<div class="form-group">
        								<label class="col-md-2 control-label">Konten</label>
                                        <div class="col-md-10">
        								    <textarea class=" form-control" id=berita-editor rows="6" name="konten" >{{ old('konten') }}</textarea>
                                        </div>
        							</div>
        							<div class="form-group">
        								<label class="col-md-2 control-label">Heading Image</label>
        								<div class="col-md-10">
        									<div class="fileinput fileinput-new" data-provides="fileinput">
        										<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
        											<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
        										</div>
        										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
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
        							<div class="form-group">
        								<label class="col-md-2 control-label">Status</label>
                                        <div class="col-md-10">
        									<div class="icheck-inline">
        										<label>
        										<input type="radio" name="status" value="draft" checked class="icheck" data-radio="iradio_square-grey"> Draft </label>
        										<label>
        										<input type="radio" name="status" value="publish" class="icheck" data-radio="iradio_square-grey"> Publish </label>
        									</div>
                                        </div>
        							</div>
                                </div>
                                <div class="col-md-3">
        							<div class="form-group">
        								<label>Kategori</label>
                                        <div class="input-group fix-margin">
											<div class="icheck-list" data-error-container="#kategori_error">
                                                @if (count($kategori) > 0)
                                                @foreach ($kategori as $val)
												<label>
												<input type="checkbox" name="kategori[]" {{!empty(old('kategori')) && in_array($val->kategori_id, old('kategori'))?'checked':''}} value="{{$val->kategori_id}}" class="icheck" data-checkbox="icheckbox_square-grey"> {{$val->kategori}} </label>
                                                @endforeach
                                                @endif
											</div>
    										<div id="kategori_error">
    										</div>
                                        </div>
        							</div>
                                </div>
                            </div>
						</div>
						<div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
        							<a type="button" href="/administrasi/berita" class="btn default">Kembali</a>
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
<script type="text/javascript" src="/assets/global/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-markdown/lib/markdown.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="/assets/global/plugins/icheck/icheck.min.js"></script>
@endsection

@section('csspluginscript')
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" />
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<link type="text/css" href="/assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>
@endsection

@section('jsscript')
<script type="text/javascript">
    CKEDITOR.replace('berita-editor',{
        enterMode: CKEDITOR.ENTER_P,
        fillEmptyBlocks: false,
        on:{'instanceReady': function(evt){evt.editor.dataProcessor.writer.setRules('p',
            {
                indent: false,
                breakBeforeOpen: false,
                breakAfterOpen: false,
                breakBeforeClose:false,
                breakAfterClose:false
            });
        }},
        toolbarGroups:[
            {"name":"basicstyles","groups":["basicstyles"]},
            {"name":"links","groups":["links"]},
            {"name":"paragraph","groups":["list","indent","blocks","align"]},
            {"name":"styles","groups":["styles"]},
            {"name": "colors"},
            {"name": "insert"}
        ],
        removeButtons: 'Strike,Subscript,Superscript,NumberedList,Anchor,Styles,CreateDiv,BGColor,Flash,Table,HorizontalRule,Rule,Smiley,PageBreak,Iframe,Font',
    });
jQuery(document).ready(function() {
    $('.wysihtml5').wysihtml5({"image": true, "color": true, "stylesheets": ["/assets/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]});
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
                judul: {
                    required: true,
                    maxlength: 100
                },
                konten: {
                    required: true
                },
                image: {
                    required: true,
                    accept: "image/*"
                },
                "kategori[]": {
                    required: true,
                    minlength: 1
                }
            },

            messages: { // custom messages for radio buttons and checkboxes
                membership: {
                    required: "Please select a Membership type"
                },
                "kategori[]": {
                    required: "Minimum pilih 1 kategori",
                    minlength: jQuery.validator.format("Minimum pilih {0} kategori")
                }
            },
    
            invalidHandler: function (event, validator) {              
                success.hide();
                error.show();
                Metronic.scrollTo(error, -200);
            },
    
            errorPlacement: function (error, element) {
                if (element.parents('.icheck-list').size() > 0) {
                    error.appendTo(element.parents('.icheck-list').attr("data-error-container"));
                } else if (element.parent(".input-group").size() > 0) {
                    error.insertAfter(element.parent(".input-group"));
                } else if (element.hasClass("fileinput")) { 
                    error.insertAfter(element.closest("div.fileinput"));
                } else if (element.attr("data-error-container")) { 
                    error.appendTo(element.attr("data-error-container"));
                } else if (element.parents('.radio-list').size() > 0) { 
                    error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                } else if (element.parents('.radio-inline').size() > 0) { 
                    error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
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