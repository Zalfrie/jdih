@extends('layouts.site.app')

@section('meta')
<meta name="description" content="Hubungi Kami Subbagian Jaringan dan Informasi Dokumentasi Hukum Kementerian BUMN Jl. Medan Merdeka Selatan No. 13 Jakarta 10110"/>
@endsection

@section('content')

  <div id="bottomHeader">
    <div class="container">
      <h3><i class="fa fa-phone"></i> Kontak Kami</h3>
    </div>
  </div>
  <!--/#bottomHeader-->


  <div class="contentWrapper">
    <div class="container">
    <div class="well">
		<div class="p-content">
			<p style="text-align:justify;">Subbagian Jaringan dan Informasi Dokumentasi Hukum<br/>Kementerian Badan Usaha Milik Negara Republik Indonesia<br>Jl. Medan Merdeka Selatan No. 13 Jakarta 10110 Indonesia<br>
			Telp. 021-29935678 Ext. 7601<br/>Fax. 021-29935742<br/>Email jdih@bumn.go.id</p>
		</div>
	</div>
    @if (Session::has('flash_notification.message'))
        <h3>{!! Session::get('flash_notification.message') !!}</h3>
    @endif
      <form class="form-horizontal clearfix" action="/kontak-kami" method="post">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-md-16">
            <div class="form-group">
              <label class="col-md-3 control-label">Nama<span class="text-danger">*</span></label>
              <div class="col-md-4">
                  <input type="text" required="" name="nama" class="form-control" maxlength="100" value="{{old('nama')}}" />
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-16">
            <div class="form-group">
              <label class="col-md-3 control-label">Email<span class="text-danger">*</span></label>
              <div class="col-md-4">
                  <input type="email" autocomplete="off" required="" name="email" class="form-control" maxlength="100" value="{{old('email')}}" />
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-16">
            <div class="form-group">
              <label class="col-md-3 control-label">Pesan<span class="text-danger">*</span></label>
              <div class="col-md-9">
                  <textarea required="" name="message" class="form-control" rows="6" maxlength="5000">{{old('message')}}</textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
          <div class="pull-right">
            <div class="g-recaptcha" data-sitekey="6LeSyiITAAAAAMWIolLtc38AeoNQwgboZPUE9ruj"></div>
            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="button-line text-right">
              <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
          </div>
        </div>
      </form>
      <hr />
        <div class="row">
            <div class="col-md-16">
                <div class="well no-margin" style="text-align: justify;">
                    <h3>Disclaimer</h3>
                    {!!$disclaimer->content!!}
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection

@section('jspluginscript')
<script src='https://www.google.com/recaptcha/api.js?hl=id'></script>
@endsection

@section('csspluginscript')
@endsection

@section('jsscript')
<script type="text/javascript">
jQuery(document).ready(function() {
    
});
</script>
@endsection