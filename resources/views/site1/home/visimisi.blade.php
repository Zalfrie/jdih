@extends('layouts.site1.app')

@section('meta')
<meta name="description" content="{!! strip_tags($prakata->content) !!}"/>
@endsection

@section('content')

  <section class="page-header">
    <div class="container">
      <div class="row">
        <div class="col">
          <ul class="breadcrumb">
            <li><a href="/">Beranda</a></li>
            <li class="active">Visi Misi</li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h1>Visi Misi JDIH</h1>
        </div>
      </div>
    </div>
  </section>

  <div id="bottomHeader">
    <div class="container">
      <h3>Visi dan Misi</h3>
    </div>
  </div>
  <!--/#bottomHeader-->


  <div class="contentWrapper">
    <div class="container">
        <div class="col-md-16">{!! $prakata->content !!}</div>
        <div class="clearfix"></div>
        <h4>Visi</h4>
        <div class="col-md-16">{!! $visi->content !!}</div>
        <div class="clearfix"></div>
        <h4>Misi</h4>
        <div class="col-md-16">{!! $misi->content !!}</div>
    </div>
  </div>
@endsection

@section('jspluginscript')
@endsection

@section('csspluginscript')
@endsection

@section('jsscript')
<script type="text/javascript">
jQuery(document).ready(function() {
    
});
</script>
@endsection