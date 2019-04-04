@extends('layouts.site1.app')

@section('meta')
<meta name="description" content="Hubungi Kami Subbagian Jaringan dan Informasi Dokumentasi Hukum Kementerian BUMN Jl. Medan Merdeka Selatan No. 13 Jakarta 10110"/>
@endsection

@section('content')

  <section class="page-header">
    <div class="container">
      <div class="row">
        <div class="col">
          <ul class="breadcrumb">
            <li><a href="/">Beranda</a></li>
            <li class="active">Kontak Kami</li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h1>Kontak Kami</h1>
        </div>
      </div>
    </div>
  </section>

<div id="googlemaps" class="google-map"></div>

<div class="container">
  <div class="row">
    <div class="col-lg-6">
      <section class="section section-default">
        <div class="container">
          <div class="row">
            <div class="col">
              <h4 class="mb-0">Hubungi Kami</h4>
              <p class="mb-0">Subbagian Jaringan dan Informasi Dokumentasi Hukum<br/>Kementerian Badan Usaha Milik Negara Republik Indonesia<br>Jl. Medan Merdeka Selatan No. 13 Jakarta 10110 Indonesia<br>
            Telp. 021-29935678 Ext. 7601<br/>Fax. 021-29935742<br/>Email jdih@bumn.go.id</p>
            </div>
          </div>
        </div>
      </section>
      @if (Session::has('flash_notification.message'))
          <h3>{!! Session::get('flash_notification.message') !!}</h3>
      @endif
      <form id="contactForm" action="/kontak-kami" method="POST">
        {{ csrf_field() }}
        <div class="form-row">
          <div class="form-group col-lg-6">
            <label>Nama *</label>
            <input type="text" required="" name="nama" data-msg-required="Masukan Nama Anda." id="nama" class="form-control" maxlength="100" value="{{old('nama')}}" />
          </div>
          <div class="form-group col-lg-6">
            <label>Email *</label>
            <input type="email" autocomplete="off" required="" name="email" id="email" class="form-control" maxlength="100" data-msg-required="Masukan Alamat Email Anda." value="{{old('email')}}" />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label>Pesan *</label>
            <textarea required="" name="message" id="message" class="form-control" rows="10" maxlength="5000">{{old('message')}}</textarea>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <div class="pull-left">
            <div class="g-recaptcha" data-sitekey="6LeSyiITAAAAAMWIolLtc38AeoNQwgboZPUE9ruj"></div>
            </div>
            </div>
          </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <button type="submit" class="btn btn-primary">Kirim</button>
          </div>
        </div>
      </form>
    </div>
    
  
  
</div>
<section class="section section-default section-with-divider">
  <div class="divider divider-solid divider-style-4">
    <i class="fas fa-chevron-down"></i>
  </div>
  <div class="container">
    <div class="row">
      <div class="col">
        <h4 class="mb-0">Disclamer</h4>
        <p class="mb-0">{!!$disclaimer->content!!}</p>
      </div>
    </div>
  </div>
</section>
  
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