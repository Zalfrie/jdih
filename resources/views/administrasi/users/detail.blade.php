
@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue-chambray">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-book-open"></i> Detail User
                </div>
            </div>
            <div class="portlet-body form">
                @include('common.errors')
                <form id="ubahDataForm" class="form-horizontal" action="/administrasi/user/update/{{ $user['username'] }}" enctype="multipart/form-data" method="POST" role="form">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-11">
                                <a type="button" href="/administrasi/users" class="btn default pull-right">Kembali</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-md-4 control-label bold">Username</label>
                                    <div class="col-md-8">
                                        <h4>{{ $user['username'] }}</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label bold">Email</label>
                                    <div class="col-md-8">
                                        <h4>{{ $user['email'] }}</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label bold">Nama</label>
                                    <div class="col-md-8">
                                        <h4>{{ $user['name'] }}</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label bold">No Telp.</label>
                                    <div class="col-md-8">
                                        <h4>{{ $user['handphone'] }}</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label bold">Asal Instansi</label>
                                    <div class="col-md-8">
                                        <h4>{{ $user['asal_instansi'] }}</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label bold">Activated</label>
                                    <div class="col-md-8">
                                        <h4>{{ $user['activated']<1 ? 'No' : 'Yes' }}</h4>
                                    </div>
                                </div>

                                @if(Auth::user()->hasRole(['sys_admin']))
                                <div class="form-group">
                                    <label class="col-md-4 control-label bold">Roles</label>
                                    <div class="col-md-8">
                                       <!-- <h4>
                                            <ul class="no-margin">
                                                <?php
/*                                                foreach($user['roles'] as $val){
                                                    echo '<li>'.$val->display_name.'</li>';
                                                }
                                                */?>
                                            </ul>
                                        </h4>-->
                                        <div class="md-checkbox-list checkbox-list" data-error-container="#form_roles_error">
                                            @if (count($roles) > 0)
                                            @foreach($roles as $i => $val)
                                            <?php
                                            if ($val->name == 'sys_admin' && $user['username'] == Auth::user()->username){
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
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-11">
                                <button type="submit" class="btn green pull-right simpanRoles">Simpan Roles</button>
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
        $('.simpanRoles').click(function(){
           var that = this;
            bootbox.confirm("Anda yakin akan menyimpan data ini?", function(result) {
                if (result){
                    $(that).closest('form').submit();
                }
            });
        });
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
    });
</script>
@endsection