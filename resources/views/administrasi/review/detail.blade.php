
@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue-chambray">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-book-open"></i> Detail Review Peraturan
                </div>
            </div>
            <div class="portlet-body form">
                @include('common.errors')
                <form id="ubahDataForm" class="form-horizontal" action="" role="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-9">
                                        <h4>
                                            <b>
                                                {{ $peraturan->bentuk->bentuk }} <a href="/lihat/{{$peraturan->per_no}}">{{$peraturan->per_no}}</a>
                                            </b>
                                        </h4>
                                        tanggal {{ \Carbon\Carbon::createFromFormat('Y-m-d', $peraturan->tanggal)->formatLocalized('%d %B %Y') }}


                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label bold">Tentang</label>
                                    <div class="col-md-9">
                                        <h4>{{ $peraturan->tentang }}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Pengirim</label>
                                    <div class="col-md-9">
                                        <h4>{!! $review->review_user !!} - {!! $review->instansi !!}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Tanggal Review</label>
                                    <div class="col-md-9">
                                        <h4>{{\Carbon\Carbon::parse($review->review_at)->formatLocalized('%d %B %Y')}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Detail Review</label>
                                    <div class="col-md-9">
                                        <span style="line-height: 1.8"><h4>{!!($review->review)!!}</h4></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9" style="margin-bottom: 25px">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">File Pendukung</label>
                                    <div class="col-md-9">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            @if(!empty($review->filedoc))
                                            <a href="/administrasi/review/download/{{$review->review_id}}">
                                            <img height="25px" width="25px" src="/assets/site/images/blue-download.png" title="Download uploaded file"/>
                                            </a>
                                            @else
                                            <h4><i>File tidak tersedia.</i></h4>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-11">
                                <a type="button" href="/administrasi/review/{{$peraturan->per_no}}/review-submit" class="btn default pull-right">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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

<script type="text/javascript" src="/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

<script src="/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script src="/assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
@endsection

@section('csspluginscript')
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" />
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<link type="text/css" href="/assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>

<link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
<link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/typeahead/typeahead.css">
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
        removeButtons: 'Strike,Subscript,Superscript,NumberedList,Anchor,Styles,CreateDiv,BGColor,Flash,HorizontalRule,Rule,Smiley,PageBreak,Iframe,Font',
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
                    image: {
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
        validatorMainForm($("#ubahDataForm"));
    });
</script>
@endsection