
@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue-chambray">
            <div class="portlet-title">
                <div class="caption" style="margin-left: 50px">
                    <i class="icon-book-open"></i> Review Peraturan ({!! $peraturan->isActive ? '':'tidak ' !!}sedang berlangsung)
                </div>
            </div>
            <div class="portlet-body form" style="padding-left: 50px">
                @include('common.errors')
                <form id="ubahDataForm" class="form-horizontal" action="/administrasi/review/review-submit/{{$peraturan->per_no}}" enctype="multipart/form-data" method="POST" role="form">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-11">
                                <a type="button" href="/administrasi/review" class="btn default pull-right">Kembali</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-9">
                                        <h4 >
                                            <b>
                                                {{ $peraturan->bentuk->bentuk }} <a style="color: dimgrey" href="/lihat/{{$peraturan->per_no}}">{{$peraturan->per_no}}</a>
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
                                @if($peraturan->catatan_prepare)
                                <div class="form-group">
                                    <label class="col-md-3 control-label bold">Catatan</label>
                                    <div class="col-md-9">
                                        <h4>{{ $peraturan->catatan_prepare }}</h4>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @if($peraturan->isActive)
                            <div class="col-md-9" style="margin-top: 0px">
                                <div class="form-group">
                                    <label class="col-md-3 control-label bold">Tambahkan Review</label>
                                    <div class="col-md-9">
                                        <textarea class=" form-control" id="berita-editor" rows="6" name="konten">{{old('konten')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9" style="margin-bottom: 25px">
                                &nbsp;
                                <div class="form-group">
                                    <label class="col-md-3 control-label bold">File Pendukung</label>
                                    <div class="col-md-9">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="input-group input-large" style="margin-bottom: 10px">
                                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                    <i class="fa fa-file-pdf-o fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
												</span>
                                                </div>
                                                <span class="input-group-addon btn default btn-file">
                                                <span class="fileinput-new">
                                                Select file </span>
                                                <span class="fileinput-exists">
                                                Change </span>
                                                <input type="file" name="file" class="fileinput" />
                                                </span>
                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
                                                    Remove </a>

                                            </div>
                                            <!--@
                                            <a href="/administrasi/review/download/ $user_review->review_id">
                                                <img height="25px" width="25px" src="/assets/site/images/blue-download.png" title="Download uploaded file"/>
                                            </a>
                                            @-->
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="col-md-11">
                                        <button type="submit" class="btn blue pull-right" style="margin-bottom: 50px">Simpan</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>

<div id="lihatReview" class="row">
    <div class="col-md-12">
        <div class="portlet box blue-chambray">
            <div class="portlet-title">
                <div id="judul_review_peraturan" class="caption" style="margin-left: 50px">
                    <i class="icon-book-open"></i> Lihat Review Peraturan : {!! $peraturan->per_no !!}
                </div>
            </div>
            <div class="portlet-body" style="padding-left: 50px">
                <div class="row">
                    <div class="col-md-11">
                        @if(count($peraturan->review) > 0)
                        <table class="table table-striped table-bordered table-hover" id="tableReview">
                            <thead>
                                <tr bgcolor="#008b8b"> <!--bgcolor="#0a3c6b">-->
                                    <th style="width: 10px; text-align: center; color: white">No</th>
                                    <th style="width: 300px; text-align: center; color: white">Pengirim</th>
                                    <th style="width: 300px; text-align: center; color: white">Jumlah Review</th>
                                    <th style="width: 100px; text-align: center; color: white">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        @else
                        <p class="col-md-11" style="margin-top: 30px; margin-bottom: 30px; text-align: center">Belum ada review untuk peraturan ini. </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--<div id="lihatReview" class="row" {!! $isReviewer ? 'style="display: block"' : 'style="display: none"' !!}>-->
<div id="lihatReview" class="row">
    <div class="col-md-12">
        <div class="portlet box blue-chambray">
            <div class="portlet-title">
                <div id="judul_review" class="caption" style="margin-left: 50px">
                    <i class="icon-book-open"></i> Lihat Review dari : {{Auth::user()->username}}
                </div>
            </div>
            <div class="portlet-body" style="padding-left: 50px">
                <input id="userReview" name="userReview" type="text" value="{{Auth::user()->username}}" hidden/>
                <input id="pernoReview" name="pernoReview" type="text" value="{{$peraturan->per_no}}" hidden/>
                <div class="row">
                    <div class="col-md-11">
                        <table class="table table-striped table-bordered table-hover" id="tableReviewUser">
                            <thead>
                                <tr>
                                    <th>Dikirim pada</th>
                                    <th>Asal Instansi</th>
                                    <th>Isi Review</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
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

    function lihat($username) {
        document.getElementById("userReview").value = $username;
        document.getElementById("judul_review").innerHTML = "<i class=\"icon-book-open\"></i> Lihat review dari : " + $username;
//        $("#judul_review").html("Lihat Review dari : ".$username );
//            alert($('input[name=userReview]').val());
        document.getElementById("lihatReview").style.display = "block";
        oTable.fnDraw();
    }

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
                        required: false
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

        oTable2 = $('#tableReview').dataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "ajax":{
                "url": '/administrasi/review/getdatareview',
                "type": "POST",
                data: function (d) {
                    d.perno = $('input[name=pernoReview]').val();
                }
            },
            "columns":[
                {data:null, sortable: false, searchable: false},
                {data:'pengirim', name: 'pengirim'},
                {className: "dt-body-center", data:'jumlah', name: 'jumlah'},
                {data:'actions', name: 'actions', searchable: false, sortable:false},
            ],
            "lengthMenu":[
                [5, 10, 20, -1],
                [5, 10, 20, "All"]
            ],
            "pageLength": 5,
            "fnCreatedRow": function (row, data, index) {
                $('td', row).eq(0).html(index + 1);
            }
        });
        oTable = $('#tableReviewUser').dataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "ajax":{
                "url": '/administrasi/review/getdatareviewuser',
                "type": "POST",
                data: function (d) {
                    d.userReview = $('input[name=userReview]').val();
                    d.perno = $('input[name=pernoReview]').val();
                }
            },
            "columns":[
                {data:'review_at', name: 'review_at'},
                {data:'instansi', name: 'instansi'},
                {data:'konten', name: 'konten'},
                {data:'actions', name: 'actions', searchable: false, sortable:false},
            ],
            "lengthMenu":[
                [10, 20, -1],
                [10, 20, "All"]
            ],
        });
    });
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
</script>
@endsection