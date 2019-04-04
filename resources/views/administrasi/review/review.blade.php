
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
			<div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-book-open"></i> Review Peraturan
					</div>
                    <div class="actions">
                        <a type="button" class="btn red" href="/administrasi/review/hide/{{ $data->per_no }}">
                            Sembunyikan
                        </a>
                    </div>
                    <div class="actions" style="margin-right: 10px">
                        <a type="button" class="btn red" href="/administrasi/review/remove/{{ $data->per_no }}">
                            Delete data review
                        </a>
                    </div>
				</div>
				<div class="portlet-body form">
                    @include('common.errors')
					<form id="ubahPeraturanForm" class="form-horizontal" action="/administrasi/peraturan/{{ $data->per_no }}/komen" method="POST" role="form">
                    {{ csrf_field() }}
                        {{ method_field('PUT') }}
						<div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <p class="control-label bold" style="text-align: left !important;">
                                        {{$data->per_no}}
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Tentang</label>
                                <div class="col-md-9">
                                    <p class="control-label bold" style="text-align: left !important;">
                                        {{ $data->tentang }}
                                    </p>
                                </div>
                            </div>
                            <!--
							<div class="form-group">
								<label class="col-md-3 control-label">Tajuk</label>
                                <div class="col-md-9">
                                    <p class="control-label bold" style="text-align: left !important;">
    								    {{$data->tajukNegara->nama_negara}} - {{$data->tajukInstansi->nama_instansi}}
                                    </p>
                                </div>
							</div>
							<div class="form-group">
                                <label class="col-md-3 control-label">Bentuk Peraturan</label>
                                <div class="col-md-9">
                                    <p class="control-label bold" style="text-align: left !important;">
                                        {{$data->bentuk_short}}
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Tanggal Penetapan / Pengesahan</label>
                                <div class="col-md-9">
                                    <p class="control-label bold" style="text-align: left !important;">
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d', $data->tanggal)->formatLocalized('%d %B %Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Materi Peraturan</label>
                                <div class="col-md-9">
                                    <ul class="control-label bold" style="text-align: left !important;">
                                    @if (count($data->materi) > 0)
                                    @foreach ($data->materi as $val)
                                        <li>
                                            {{ $val->materi }}
                                        </li>
                                    @endforeach
                                    @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Kota</label>
                                <div class="col-md-9">
                                    <p class="control-label bold" style="text-align: left !important;">
                                        {{ $data->kota->nama_kota }}
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Sumber</label>
                                <div class="col-md-9">
                                    <ul class="control-label bold" style="text-align: left !important;">
                                    @if (count($data->sumber) > 0)
                                    @foreach ($data->sumber as $val)
                                        <li>
                                            {{ $val->sumber_short }} {{ $val->pivot->year }} {{ !empty($val->pivot->jilid)?('('.$val->pivot->jilid.') '):'' }}: {{ $val->pivot->hal }} hlm
                                        </li>
                                    @endforeach
                                    @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Status</label>
                                <div class="col-md-9">
                                    <ul class="control-label bold" style="text-align: left !important;">
                                    @if (count($data->status) > 0)
                                    @foreach ($data->status as $val)
                                        <li>
                                            {{ $val->status }} : {{ $val->pivot->per_no_object }}
                                        </li>
                                    @endforeach
                                    @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Subyek</label>
                                <div class="col-md-9">
                                    <ul class="control-label bold" style="text-align: left !important;">
                                    @if (count($data->subyek) > 0)
                                    @foreach ($data->subyek as $val)
                                        <li>
                                            {{ $val->subyek }}
                                        </li>
                                    @endforeach
                                    @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Lokasi Penyimpanan</label>
                                <div class="col-md-9">
                                    <p class="control-label bold" style="text-align: left !important;">
                                        {{ $data->lokasi }}
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-1 col-md-10">
                                <label>Katalog</label>
                                <div class="well katalog no-margin" style="background-color: #eee;">
                                    <p class="tajukEntri">{{$data->tajukNegara->nama_negara}}. {{$data->tajukInstansi->nama_instansi}}</p>
                                    <p class="judulSeragam">{{$data->bentuk->seragam}}</p>
                                    <p class="isi">{{$data->per_no}} tanggal {{\Carbon\Carbon::createFromFormat('Y-m-d', $data->tanggal)->formatLocalized('%d %B %Y')}}, tentang {{$data->tentang}}. -{{$data->kota->nama_kota}}, {{\Carbon\Carbon::createFromFormat('Y-m-d', $data->tanggal)->format('Y')}}.</p>
                                    @if (count($data->sumber) > 0)
                                    @foreach ($data->sumber as $val)
                                    <p class="sumber">{{ $val->sumber_short }} {{ $val->pivot->year }} {{ !empty($val->pivot->jilid)?('('.$val->pivot->jilid.') '):'' }}: {{ $val->pivot->hal }} hlm</p>
                                    @endforeach
                                    @endif
                                    <p class="status">
                                    </p>
                                    <p class="subyek">
                                    {!!$data->subyek->implode('subyek', '<br />')!!}
                                    </p>
                                    <div class="singkatan">{{$data->bentuk_short}}</div>
                                    <div class="lokasi">{{$data->lokasi}}</div></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-1 col-md-10">
                                <label>Abstrak</label>
                                    <div class="well abstrak no-margin" style="background-color: #eee;">
                                        <p>{!!$data->subyek->implode('subyek', '<br />')!!}</p>
                                        <p>{{\Carbon\Carbon::createFromFormat('Y-m-d', $data->tanggal)->format('Y')}}</p>
                                        <p>{{$data->bentuk_short}} {{$data->per_no}},
                                        @if (count($data->sumber) > 0)
                                        @foreach ($data->sumber as $val)
                                        {{ $val->sumber_short }} {{ $val->pivot->year }} {{ !empty($val->pivot->jilid)?('('.$val->pivot->jilid.') '):'' }}: {{ $val->pivot->hal }} hlm.
                                        @endforeach
                                        @endif
                                        </p>
                                        <p>{{$data->bentuk->bentuk}} TENTANG {{$data->tentang}}</p>
                                        <br/>
                                        <div class="abstrakLabel">ABSTRAK :</div>
                                        <div class="abstrakIsi">
                                            @if (count($data->abstrak->where('is_note', false)->pluck('abstrak')->all()) > 0)
                                            @foreach ($data->abstrak->where('is_note', false)->pluck('abstrak')->all() as $val)
                                            <div class="abstrakStrip">-</div>
                                            <p class="abstrakIsi">{!!$val!!}</p>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="abstrakLabel">CATATAN :</div>
                                        <div class="abstrakIsi">
                                            @if (count($data->abstrak->where('is_note', true)->pluck('abstrak')->all()) > 0)
                                            @foreach ($data->abstrak->where('is_note', true)->pluck('abstrak')->all() as $val)
                                            <div class="abstrakStrip">-</div>
                                            <p class="abstrakIsi">{!!$val!!}</p>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-1 col-md-10">
                                    <label>File Diunggah</label>
                                    <div>
                                        <object width="100%" height="800px" type="application/pdf" data="/administrasi/peraturan/pdf/{{$data->file_id}}"> 
                                        </object>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Review Sebelumnya</label>
                                <div class="col-md-9">
                                    <ul class="control-label" style="text-align: left !important;">
                                    @if (count($data->review) > 0)
                                    @foreach ($data->review as $val)
                                        <li>
                                            {{ $val->review }} <br> oleh {{$val->review_user}} pada {{$val->review_at}}
                                        </li>
                                    @endforeach
                                    @endif
                                    </ul>
                                </div>
                            </div>
-->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Review Mulai</label>
                                <div class="col-md-9">
                                    <input name="review_start" type="date" value="{{$data->review_start_format}}" placeholder="yyyy-mm-dd" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Review Selesai</label>
                                <div class="col-md-9">
                                    <input name="review_end" type="date" value="{{$data->review_end_format}}" placeholder="yyyy-mm-dd" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Catatan</label>
                                <div class="col-md-9">
                                    <textarea name="catatan" rows="7" cols="55">{{$data->catatan_prepare}}</textarea>
                                </div>
                            </div>
                            
						</div>
						<div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
        							<a type="button" href="/administrasi/review" class="btn default">Kembali</a>
                                    
        							<button type="button" class="btn green simpanWaktuReview" id="agree">Simpan</button>

                                    <input name="value" type="hidden" />
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
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
@endsection

@section('csspluginscript')
@endsection

@section('jsscript')
<script type="text/javascript">



jQuery(document).ready(function() {

    $('.simpanWaktuReview').click(function(){
        var that = this;
        bootbox.confirm("Anda yakin akan menyimpan data ini?", function(result) {
           if (result){
                $(that).closest('form').submit();
           }
        });
    });
    
    
});
</script>
@endsection

@section('jsscript')
<script type="text/javascript">

jQuery(document).ready(function() {
    $("#agree").click(function() {
        $("input[name='value']").val(1);
    });
    $("#disagree").click(function() {
        $("input[name='value']").val(2);
    });
    
    var validatorMainForm = function(context){
        var form = $(context);
    
        form.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
            },
    
            invalidHandler: function (event, validator) {
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
    validatorMainForm($("#ubahPeraturanForm"));
});
</script>
@endsection




