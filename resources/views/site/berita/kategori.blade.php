@extends('layouts.site.app')

@section('meta')
<meta name="description" content="{{!empty($kategori)?$kategori->kategori:'Berita'}} Jaringan Dokumentasi dan Informasi Hukum Kementerian BUMN"/>
@endsection

@section('content')

  <div id="bottomHeader">
    <div class="container">
      <h3>{{!empty($kategori)?$kategori->kategori:'Berita'}}</h3>
    </div>
  </div>
  
<div class="contentWrapper"> 
    <div class="mainContent">
        <div class="container">
            <div class="listWrapper">
              <ul class="clearfix">
              @if (count($berita) > 0)
              @foreach($berita as $val)
                <li>
                    <img src="{{$val->image}}" width="150" />
                    <div class="clearfix"></div>
                  <a class="clearfix" href="/berita/{!! $val->slug !!}">
                    <h4>{!! $val->title !!}</h4>
                    </a>
                    <p style="text-align: justify;">{!!substr($val->content, 0, strpos($val->content, '<br'))!!}</p>
                    <p>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val->published_at)->formatLocalized('%d %B %Y') }} {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val->published_at)->format('H:i:s') }}</p>
                </li>
              @endforeach
              @endif
                @if ($berita->previousPageUrl())
				<ul class="pagination pagination-lg pull-left">
					<li><a href="{!! $berita->previousPageUrl() !!}"> « Sebelumnya</a></li>
				</ul>
                @endif
                @if ($berita->nextPageUrl())
				<ul class="pagination pagination-lg pull-right">
					<li><a href="{!! $berita->nextPageUrl() !!}"> Selanjutnya »</a></li>
				</ul>
                @endif
              </ul>
            </div>
        </div>
    </div>
<!--/.mainContent--> 
</div>
  <!--/.contentWrapper-->
@endsection

@section('jsscript')
<script type="text/javascript">
jQuery(document).ready(function() {});
</script>
@endsection