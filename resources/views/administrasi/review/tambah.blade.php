
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
			<div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-book-open"></i> Tambah Review Peraturan
					</div>
				</div>
				<div class="portlet-body form">
                    @include('common.errors')
					<form id="newPeraturanForm" name="peraturan" class="form-horizontal" action="/administrasi/review/tambah" enctype="multipart/form-data" method="POST" role="form">
                    {{ csrf_field() }}
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Nomor Peraturan<span class="required">*</span></label>
                                <div class="col-md-3">
    								<select class="form-control select2 input-sm" name="perno" onchange="ganti()">
                                        <option value="" disabled selected>Pilih Peraturan</option>
                                        @if (count($peraturan) > 0)
                                        @foreach ($peraturan as $val)
                                        <option value="{{ $val->per_no }}" <?=old('perno') == $val->per_no ? 'selected="selected"':''?>>{{ $val->per_no }}</option>
                                        @endforeach
                                        @endif
    								</select>
                                </div>
							</div>
							<!--<div class="form-group">
								<label class="col-md-3 control-label">Tentang</label>
                                <div class="col-md-3">
                                    <div id="tentang"></div>
                                </div>
							</div>-->
                            <div id="review_selesai" class="form-group">
                                <label class="col-md-3 control-label" >Review Selesai<span class="required">*</span></label>
                                <div class="col-md-9">
                                    <input name="review_end" type="date" placeholder="yyyy-mm-dd" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" >Catatan</label>
                                <div class="col-md-9">
                                    <textarea name="catatan" rows="7" cols="55"></textarea>
                                </div>
                            </div>

						</div>
						<div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
        							<a type="button" href="/administrasi/review" class="btn default">Kembali</a>
        							<button type="submit" class="btn green mulaiReview">Mulai Review</button>
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
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
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
var sumberGroup = null;
var statusGroup = null;
var abstrakGroup = null;
function ganti() {
    document.getElementById("review_selesai").style.display = 'block';
//    document.getElementById("tentang").innerHTML = ? //Print($peraturan['SE-06/MBU/2009']->per_no); ?//;
}
jQuery(document).ready(function() {

    /*$('.mulaiReview').click(function(){
        var that = this;
        bootbox.confirm("Anda yakin akan Memulai Review?", function(result) {
            if (result){
                $(that).closest('form').submit();
            }
        });
    });*/
    
    var custom = new Bloodhound({
        datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.value); },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/administrasi/peraturan/autocomplete/%QUERY',
            wildcard: '%QUERY'
        },
        limit: 100
    });
     
    custom.initialize();
    
    var autoComplete = function(obj){
        $(obj).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
          name: 'statusPerno',
          displayKey: 'value',
          source: custom.ttAdapter(),
          limit: 100
        });
    }
    
    $('.date-picker').datepicker({
        orientation: "left",
        autoclose: true,
        format: 'dd/mm/yyyy'
    });
    
    $(".select2").select2();
    $(".subyek, .materi").select2({
        placeholder: "Pilih..."
    });
    
    sumberGroup = $(".sumberGroup").clone();
    $(sumberGroup).removeClass('sumberGroup');
    $(".sumberPlus", sumberGroup).addClass('sumberMin').removeClass('sumberPlus').addClass('red').removeClass('green');
    $(".fa-plus", sumberGroup).addClass('fa-minus').removeClass('fa-plus');
    $(".sumberYear, .sumberJilid, .sumberHalaman, .sumberShort", sumberGroup).val('');
    $(".sumberYear, .sumberHalaman, .sumberShort", sumberGroup).attr('required', 'true');
    $("label.control-label", sumberGroup).text('');
    
    $(".sumberPlus").click(function(){
        var cloned = $(sumberGroup).clone();
        $(".sumberMin", cloned).bind("click", function(){
            $(cloned).remove();
        });
        $(".selectEmpty", cloned).select2({
            placeholder: "Pilih...",
            allowClear: true
        }).select2("val", "");
        $(".sumberShort").last().closest('.form-group').after(cloned);
    });
    $(".sumberMin").bind("click", function(){
        $(this).closest('.form-group').remove();
    });
    
    statusGroup = $(".statusGroup").clone();
    $(statusGroup).removeClass('statusGroup');
    $(".statusPlus", statusGroup).addClass('statusMin').removeClass('statusPlus').addClass('red').removeClass('green');
    $(".fa-plus", statusGroup).addClass('fa-minus').removeClass('fa-plus');
    $(".statusPerno, .status", statusGroup).val('').attr('required', true);
    $("label.control-label", statusGroup).text('');
    
    $(".statusPlus").click(function(){
        var cloned = $(statusGroup).clone();
        $(".statusMin", cloned).bind("click", function(){
            $(cloned).remove();
        });
        
        $(".selectEmpty", cloned).select2({
            placeholder: "Pilih...",
            allowClear: true
        });
        autoComplete($(".statusPerno", cloned));
        $(".status").last().closest('.form-group').after(cloned);
    });
    autoComplete($(".statusPerno"));
    
    $(".selectEmpty").select2({
        placeholder: "Pilih...",
        allowClear: true
    });
    
    abstrakGroup = $(".abstrakGroup").clone();
    $(abstrakGroup).removeClass('abstrakGroup');
    $(".abstrakPlus", abstrakGroup).addClass('abstrakMin').removeClass('abstrakPlus').addClass('red').removeClass('green');
    $(".fa-plus", abstrakGroup).addClass('fa-minus').removeClass('fa-plus');
    $(".abstrak", abstrakGroup).val('');
    $("label.control-label", abstrakGroup).text('');
    
    $(".abstrakPlus").click(function(){
        var cloned = $(abstrakGroup).clone();
        $(".abstrakMin", cloned).bind("click", function(){
            $(cloned).remove();
        });
        $(".selectEmpty", cloned).select2({
            placeholder: "Pilih...",
            allowClear: true
        });
        $(".abstrak").last().closest('.form-group').after(cloned);
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
                "sumberYear[]": {
                    required: function(element){
                        return $(element).closest('.form-group').find("select[name='sumberShort[]'] option:selected").first().attr('value') != "";
                    }
                },
                "sumberHalaman[]": {
                    required: function(element){
                        return $(element).closest('.form-group').find("select[name='sumberShort[]'] option:selected").first().attr('value') != "";
                    }
                },
                "statusPerno[]": {
                    required: function(element){
                        return $(element).closest('.form-group').find("select[name='status[]'] option:selected").first().attr('value') != "";
                    }
                }
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
                form.submit();
            }
        }); 
    };
    
    var validatorForm = function(context){
        $("form", context).each(function(){
            var form = $(this);
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
                    $.ajax({
                        url: $(form).attr('action'),
                        method: "POST",
                        data: $(form).serialize(),
                        dataType: "json",
                        success: function(data){
                            $(data.appendTarget).append($("<option></option>").attr("selected", "selected").attr("value", data.key).text(data.text));
                            $(data.appendTarget).select2("destroy");
                            $(data.appendTarget).select2({
                                placeholder: "Pilih..."
                            });
                            $(context).modal('toggle');
                        }
                    });
                }
            }); 
        });
    };
    validatorForm($("#modalAddSubyek"));
    validatorForm($("#modalAddMateri"));
    validatorMainForm($("#newPeraturanForm"));
});
</script>
@endsection