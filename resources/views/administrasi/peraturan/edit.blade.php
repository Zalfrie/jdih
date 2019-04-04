<?php
$isOld = Session('failed')?true:false;
?>
@extends('layouts.app')

@section('content')
	<div id="modalAddSubyek" class="modal fade" tabindex="-1" data-width="760" data-focus-on="input:first">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">tambah Subyek Peraturan Baru</h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
                
					<form id="addSubyekForm" class="form-horizontal margin-bottom-40" action="/administrasi/peraturan/subyek" method="POST" role="form">
    					{{ csrf_field() }}
    					<div class="alert alert-danger display-hide">
    						<button class="close" data-close="alert"></button>
    						You have some form errors. Please check below.
    					</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label">Subyek <span class="required"> * </span></label>
							<div class="col-md-8 input-icon right">
								<input type="text" class="form-control" required="required" placeholder="Subyek Peraturan" name="newSubyek" value="{{ old('newSubyek') }}" />
								<div class="form-control-focus"></div>
                                <i class="fa"></i>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
                                <button type="button" data-dismiss="modal" class="btn btn-default">Batal</button>
    							<button type="submit" class="btn blue">
                                    <i class="fa fa-btn fa-plus"></i>Simpan
                                </button>
							</div>
						</div>
					</form>
                </div>
			</div>
		</div>
	</div>
    
	<div id="modalAddMateri" class="modal fade" tabindex="-1" data-width="760" data-focus-on="input:first">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Tambah Materi Peraturan Baru</h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
                
					<form id="addMateriForm" class="form-horizontal margin-bottom-40" action="/administrasi/peraturan/materi" method="POST" role="form">
    					{{ csrf_field() }}
    					<div class="alert alert-danger display-hide">
    						<button class="close" data-close="alert"></button>
    						You have some form errors. Please check below.
    					</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label">Materi Peraturan <span class="required"> * </span></label>
							<div class="col-md-8 input-icon right">
								<input type="text" class="form-control" required="required" placeholder="Materi Peraturan" name="newMateri" value="{{ old('newMateri') }}" />
								<div class="form-control-focus"></div>
                                <i class="fa"></i>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
                                <button type="button" data-dismiss="modal" class="btn btn-default">Batal</button>
    							<button type="submit" class="btn blue">
                                    <i class="fa fa-btn fa-plus"></i>Simpan
                                </button>
							</div>
						</div>
					</form>
                </div>
			</div>
		</div>
	</div>
    
    <div class="row">
        <div class="col-md-12">
			<div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-book-open"></i> Ubah Peraturan
					</div>
				</div>
				<div class="portlet-body form">
                    @include('common.errors')
					<form id="ubahPeraturanForm" class="form-horizontal" action="/administrasi/peraturan/{{ $data->per_no }}" method="POST" enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}
                        {{ method_field('PUT') }}
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Tajuk</label>
                                <div class="col-md-3">
    								<select class="form-control select2 input-sm" name="negara" disabled>
                                        @if (count($negara) > 0)
                                        @foreach ($negara as $val)
                                        <option value="{{ $val->negara_id }}" <?=old('negara') == $val->negara_id || $data->tajuk_negara_id == $val->negara_id? 'selected="selected"':''?>>{{ $val->nama_negara }}</option>
                                        @endforeach
                                        @endif
    								</select>
                                </div>
                                <div class="col-md-4">
    								<select class="form-control select2 input-sm" name="instansi" disabled>
                                        @if (count($instansi) > 0)
                                        @foreach ($instansi as $val)
                                        <option value="{{ $val->instansi_id }}" <?=old('instansi') == $val->instansi_id || $data->tajuk_ins_id == $val->instansi_id? 'selected="selected"':''?>>{{ $val->nama_instansi }}</option>
                                        @endforeach
                                        @endif
    								</select>
                                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Bentuk Peraturan <span class="required">*</span></label>
                                <div class="col-md-3">
    								<select class="form-control select2 input-sm" name="bentuk" >
                                        @if (count($bentuk) > 0)
                                        @foreach ($bentuk as $val)
                                        <option value="{{ $val->bentuk_short }}" <?=old('bentuk') == $val->bentuk_short || $data->bentuk_short == $val->bentuk_short ? 'selected="selected"':''?>>{{ $val->bentuk_short }}</option>
                                        @endforeach
                                        @endif
    								</select>
                                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Nomor Peraturan <span class="required">*</span></label>
                                <div class="col-md-4">
    								<input type="text" name="perno" required="required" class="form-control input-sm" value="{{ $isOld ? old('perno'):$data->per_no }}" />
                                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Tanggal Penetapan / Pengesahan <span class="required">*</span></label>
                                <div class="col-md-2">
    								<input type="text" name="tanggal" placeholder="dd/mm/yyyy" required="required" class="form-control input-sm date-picker" value="{{ \Carbon\Carbon::createFromFormat(($isOld?'d/m/Y':'Y-m-d'), ($isOld?old('tanggal'):$data->tanggal))->format('d/m/Y') }}" />
                                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Tentang <span class="required">*</span></label>
                                <div class="col-md-6">
    								<textarea class="form-control" rows="3" required="required" name="tentang">{{ $isOld?old('tentang'):$data->tentang }}</textarea>
                                </div>
							</div>
                            <?php
                            $dataMateri = $isOld?(old('materi') ? old('materi'):[]):$data->materi->pluck('materi_id')->all();
                            ?>
							<div class="form-group">
								<label class="col-md-3 control-label">Materi Peraturan</label>
                                <div class="col-md-7">
        							<select class="form-control materi input-sm" multiple="" name="materi[]">
                                        @if (count($materi) > 0)
                                        @foreach ($materi as $val)
                                            <option value="{{ $val->materi_id }}" <?= in_array($val->materi_id, $dataMateri) ? 'selected="selected"':''?>>{{ $val->materi }}</option>
                                        @endforeach
                                        @endif
        							</select>
                                </div>
        						<button title="Tambah Materi Peraturan Baru Jika Belum Ada Dalam List Materi Peraturan" type="button" class="btn green btn-sm" data-toggle="modal" href="#modalAddMateri">
                                    <i class="fa fa-btn fa-plus"></i>
                                </button>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Kota</label>
                                <div class="col-md-3">
    								<select class="form-control select2 input-sm" name="kota" disabled>
                                        @if (count($kota) > 0)
                                        @foreach ($kota as $val)
                                        <option value="{{ $val->kota_id }}" selected="selected">{{ $val->nama_kota }}</option>
                                        @endforeach
                                        @endif
    								</select>
                                </div>
							</div>
                            <?php
                            $lastSumber = $isOld ? old('sumberShort'): $data->sumber;
                            if (count($lastSumber) > 0){
                            foreach ($lastSumber as $key => $dataSumber){
                            ?>
    						<div class="form-group <?=$key > 0 ? '':'sumberGroup'?>">
    							<label class="col-md-3 control-label"><?=$key > 0 ? '':'Sumber'?></label>
                                <div class="col-md-2">
    								<select class="form-control selectEmpty input-sm sumberShort" name="sumberShort[]" >
                                        <option value=""></option>
                                        @if (count($sumber) > 0)
                                        @foreach ($sumber as $val)
                                        <option value="{{ $val->sumber_short }}" <?=($isOld && old('sumberShort')[$key] == $val->sumber_short)||(!$isOld && $dataSumber->sumber_short == $val->sumber_short) ? 'selected="selected"':''?>>{{ $val->sumber_short }}</option>
                                        @endforeach
                                        @endif
    								</select>
                                </div>
                                <div class="col-md-1">
    								<input type="text" class="form-control input-sm sumberYear" name="sumberYear[]" placeholder="tahun" value="{{ $isOld ? old('sumberYear')[$key] : $dataSumber->pivot->year }}" />
                                </div>
                                <div class="col-md-1">
    								<input type="text" class="form-control input-sm sumberJilid" name="sumberJilid[]" placeholder="jilid" value="{{ $isOld ? old('sumberJilid')[$key] : $dataSumber->pivot->jilid }}" />
                                </div>
                                <div class="col-md-1">
    								<input type="text" class="form-control input-sm sumberHalaman" name="sumberHalaman[]" placeholder="halaman" value="{{ $isOld ? old('sumberHalaman')[$key] : $dataSumber->pivot->hal }}" />
                                </div>
								<a type="button" class="btn btn-sm <?=$key > 0 ? 'red sumberMin':'green sumberPlus'?>" href="javascript:;" >
									<i class="fa fa-<?=$key > 0 ? 'minus':'plus'?>"></i>
								</a>
    						</div>
                            <?php
                            }}else{
                            ?>
    						<div class="form-group sumberGroup">
    							<label class="col-md-3 control-label">Sumber</label>
                                <div class="col-md-2">
    								<select class="form-control selectEmpty input-sm sumberShort" name="sumberShort[]" >
                                        <option value=""></option>
                                        @if (count($sumber) > 0)
                                        @foreach ($sumber as $val)
                                        <option value="{{ $val->sumber_short }}">{{ $val->sumber_short }}</option>
                                        @endforeach
                                        @endif
    								</select>
                                </div>
                                <div class="col-md-1">
    								<input type="text" class="form-control input-sm sumberYear" name="sumberYear[]" placeholder="tahun" value="" />
                                </div>
                                <div class="col-md-1">
    								<input type="text" class="form-control input-sm sumberJilid" name="sumberJilid[]" placeholder="jilid" value="" />
                                </div>
                                <div class="col-md-1">
    								<input type="text" class="form-control input-sm sumberHalaman" name="sumberHalaman[]" placeholder="halaman" value="" />
                                </div>
								<a type="button" class="btn btn-sm green sumberPlus" href="javascript:;" >
									<i class="fa fa-plus"></i>
								</a>
    						</div>
                            <?php
                            }
                            $lastStatus = $isOld ? old('status'): $data->status;
                            if (count($lastStatus) > 0){
                            foreach ($lastStatus as $key => $dataStatus){
                            ?>
    						<div class="form-group  <?=$key > 0 ? '':'statusGroup'?>"">
    							<label class="col-md-3 control-label"><?=$key > 0 ? '':'Status'?></label>
                                <div class="col-md-2">
    								<select class="form-control selectEmpty input-sm status" name="status[]" >
                                        <option value=""></option>
                                        @if (count($status) > 0)
                                        @foreach ($status as $val)
                                        <option value="{{ $val->status_id }}" <?=($isOld && old('status')[$key] == $val->status_id)||(!$isOld && $dataStatus->status_id == $val->status_id) ? 'selected="selected"':''?>>{{ $val->status }}</option>
                                        @endforeach
                                        @endif
    								</select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control input-sm statusPerno" name="statusPerno[]" value="{{$isOld ? old('statusPerno')[$key] : $dataStatus->pivot->per_no_object}}" />
                                </div>
								<a type="button" class="btn btn-sm <?=$key > 0 ? 'red statusMin':'green statusPlus'?>" href="javascript:;" >
									<i class="fa fa-<?=$key > 0 ? 'minus':'plus'?>"></i>
								</a>
    						</div>
                            <?php
                            }}else{
                            ?>
    						<div class="form-group statusGroup">
    							<label class="col-md-3 control-label">Status</label>
                                <div class="col-md-2">
    								<select class="form-control selectEmpty input-sm status" name="status[]" >
                                        <option value=""></option>
                                        @if (count($status) > 0)
                                        @foreach ($status as $val)
                                        <option value="{{ $val->status_id }}">{{ $val->status }}</option>
                                        @endforeach
                                        @endif
    								</select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control input-sm statusPerno" name="statusPerno[]" value="" />
                                </div>
								<a type="button" class="btn btn-sm green statusPlus" href="javascript:;" >
									<i class="fa fa-plus"></i>
								</a>
    						</div>
                            <?php
                            }
                            $dataSubyek = $isOld?(old('subyek') ? old('subyek'):[]):$data->subyek->pluck('subyek_id')->all();
                            ?>
							<div class="form-group">
								<label class="col-md-3 control-label">Subyek</label>
                                <div class="col-md-7">
        							<select class="form-control subyek input-sm" multiple="" name="subyek[]">
                                        @if (count($subyek) > 0)
                                        @foreach ($subyek as $val)
                                            <option value="{{ $val->subyek_id }}" <?= in_array($val->subyek_id, $dataSubyek) ? 'selected="selected"':''?>>{{ $val->subyek }}</option>
                                        @endforeach
                                        @endif
        							</select>
                                </div>
        						<button title="Tambah Subyek Peraturan Baru Jika Belum Ada Dalam List Subyek Peraturan" type="button" class="btn green btn-sm" data-toggle="modal" href="#modalAddSubyek">
                                    <i class="fa fa-btn fa-plus"></i>
                                </button>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Lokasi Penyimpanan</label>
                                <div class="col-md-6">
    								<input type="text" name="lokasi" class="form-control input-sm" value="{{ $isOld?old('lokasi'):$data->lokasi }}" />
                                </div>
							</div>
                            <?php
                            $abstrak = $isOld? old('abstrak'): $data->abstrak->where('is_note', false)->pluck('abstrak')->all();
                            ?>
							<div class="form-group">
								<label class="col-md-3 control-label">Abstrak </label>
                                <div class="col-md-8">
									<textarea class="form-control" name="abstrak[0]" rows="5"><?=count($abstrak) > 0? $abstrak[0]:''?></textarea>
                                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"></label>
                                <div class="col-md-8">
									<textarea class="form-control" name="abstrak[1]" rows="5"><?=count($abstrak) > 1? $abstrak[1]:''?></textarea>
                                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"></label>
                                <div class="col-md-8">
									<textarea class="form-control" name="abstrak[2]" rows="5"><?=count($abstrak) > 2? $abstrak[2]:''?></textarea>
                                </div>
							</div>
                            <?php
                            $lastAbstrakNote = $isOld?old('abstrakNote'):$data->abstrak->where('is_note', true)->pluck('abstrak')->all();
                            if (count($lastAbstrakNote) > 0){
                            foreach ($lastAbstrakNote as $key => $dataAbstrakNote){
                            ?>
    						<div class="form-group  <?=$key > 0 ? '':'abstrakGroup'?>"">
    							<label class="col-md-3 control-label"><?=$key > 0 ? '':'Catatan Abstrak'?></label>
                                <div class="col-md-7">
    								<textarea class="form-control abstrak" name="abstrakNote[]" rows="5">{{ $dataAbstrakNote }}</textarea>
                                </div>
								<a type="button" class="btn btn-sm <?=$key > 0 ? 'red abstrakMin':'green abstrakPlus'?>" href="javascript:;" >
									<i class="fa fa-<?=$key > 0 ? 'minus':'plus'?>"></i>
								</a>
    						</div>
                            <?php
                            }}else{
                            ?>
    						<div class="form-group abstrakGroup">
    							<label class="col-md-3 control-label">Catatan Abstrak</label>
                                <div class="col-md-7">
    								<textarea class="form-control abstrak" name="abstrakNote[]" rows="5"></textarea>
                                </div>
								<a type="button" class="btn btn-sm green abstrakPlus" href="javascript:;" >
									<i class="fa fa-plus"></i>
								</a>
    						</div>
                            <?php
                            }
                            ?>
							<div class="form-group">
								<label class="control-label col-md-3">File PDF</label>
                                <div class="col-md-4">
                                    @if(!empty($data->filedoc))
                                    <object width="100%" height="400px" type="application/pdf" data="/administrasi/peraturan/pdf/{{$data->file_id}}"> 
                                    </object>
                                    @endif
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
var sumberGroup = null;
var statusGroup = null;
var abstrakGroup = null;
jQuery(document).ready(function() {
    
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
    $(".sumberShort option", sumberGroup).removeAttr('selected');
    $("label.control-label", sumberGroup).text('');
    
    $(".sumberPlus").click(function(){
        var cloned = $(sumberGroup).clone();
        $(".sumberMin", cloned).bind("click", function(){
            $(cloned).remove();
        });
        $(".selectEmpty", cloned).select2({
            placeholder: "Pilih...",
            allowClear: true
        });
        $(".sumberShort").last().closest('.form-group').after(cloned);
    });
    $(".sumberMin").bind("click", function(){
        var cloned = $(this).closest('.form-group');
        $(cloned).remove();
    });
    
    statusGroup = $(".statusGroup").clone();
    $(statusGroup).removeClass('statusGroup');
    $(".statusPlus", statusGroup).addClass('statusMin').removeClass('statusPlus').addClass('red').removeClass('green');
    $(".fa-plus", statusGroup).addClass('fa-minus').removeClass('fa-plus');
    $(".statusPerno, .status", statusGroup).val('');
    $(".status option", statusGroup).removeAttr('selected');
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
    $(".statusMin").bind("click", function(){
        var cloned = $(this).closest('.form-group');
        $(cloned).remove();
    });
    
    $(".selectEmpty").select2({
        placeholder: "Pilih...",
        allowClear: true
    });
    
    abstrakGroup = $(".abstrakGroup").clone();
    $(abstrakGroup).removeClass('abstrakGroup');
    $(".abstrakPlus", abstrakGroup).addClass('abstrakMin').removeClass('abstrakPlus').addClass('red').removeClass('green');
    $(".fa-plus", abstrakGroup).addClass('fa-minus').removeClass('fa-plus');
    $(".abstrak", abstrakGroup).text('');
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
    $(".abstrakMin").bind("click", function(){
        var cloned = $(this).closest('.form-group');
        $(cloned).remove();
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
    validatorMainForm($("#ubahPeraturanForm"));
    
    var addSumberRule = function(obj){
        $(obj).rules('add', {
            required: function(element){
                return $(element).closest('.form-group').find("select[name='sumberShort[]'] option:selected").first().attr('value') != "";
            }
        });
    }
    
    var addStatusRule = function(obj){
        $(obj).rules('add', {
            required: function(element){
                return $(element).closest('.form-group').find("select[name='status[]'] option:selected").first().attr('value') != "";
            }
        });
    }
    
    $("select.sumberYear").each(function(){
        addSumberRule(this);
    });
    
    $("select.sumberHalaman").each(function(){
        addSumberRule(this);
    });
    
    $("select.statusPerno").each(function(){
        addStatusRule(this);
    });
});
</script>
@endsection