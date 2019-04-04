@extends('layouts.site1.app')

@section('meta')
<meta name="description" content="{{$peraturan->bentuk->bentuk.' '.$peraturan->per_no.' tanggal '.\Carbon\Carbon::createFromFormat('Y-m-d', $peraturan->tanggal)->formatLocalized('%d %B %Y').' tentang '.$peraturan->tentang}}"/>
@endsection

@section('content')

<section class="page-header">
<div class="container">
  <div class="row">
    <div class="col">
      <ul class="breadcrumb">
        <li><a href="/">Beranda</a></li>
        <li class="active">{{$peraturan->bentuk->bentuk.' '.$peraturan->per_no.' tanggal '.\Carbon\Carbon::createFromFormat('Y-m-d', $peraturan->tanggal)->formatLocalized('%d %B %Y')}}</li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <h1>{{$peraturan->bentuk->bentuk.' '.$peraturan->per_no.' tanggal '.\Carbon\Carbon::createFromFormat('Y-m-d', $peraturan->tanggal)->formatLocalized('%d %B %Y')}}</h1>
    </div>
  </div>
</div>
</section>

<div class="contentWrapper"> 
    <div class="mainContent">
        <div class="container">
        
        
        
      <div class="row peraturan">

        <div class="col-md-3">
          <img src="/assets/upload/peraturan/{{str_replace('/', '-', $peraturan->per_no)}}.jpg"
               onerror="this.style.display='none'" class="img-polaroid">
          <div class="space"></div>
          <a href="/unduh/{{ $peraturan->per_no }}.pdf" class="btn btn-mini btn-success" target="_blank">
            <i class="icon-download-alt icon-white"></i>Unduh PDF</a>
          <div class="space"></div>
        </div>

        <div class="col-md-13">
          <h4>{{ $peraturan->bentuk->bentuk }} {{ $peraturan->per_no }} tanggal {{ \Carbon\Carbon::createFromFormat('Y-m-d', $peraturan->tanggal)->formatLocalized('%d %B %Y') }}</h4>
          <h5>{!! $peraturan->tentang !!}</h5>
          <table class="detail-view table table-condensed" id="yw0"><tbody><tr><th>Kategori</th><td>{{ $peraturan->bentuk->bentuk }}</td></tr>
<tr><th>Nomor</th><td>{{ $peraturan->per_no }}</td></tr>
<tr><th> Tanggal ditetapkan</th><td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $peraturan->tanggal)->formatLocalized('%d %B %Y') }}</td></tr>
<tr><th> Tanggal unggah</th><td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $peraturan->published_at)->formatLocalized('%d %B %Y') }}</td></tr>
<tr><th>Diunduh sebanyak</th><td>{{ $peraturan->reading_counter }} kali</td></tr>
<tr><th>Status</th><td>
    @if (count($peraturan->status) > 0)
    <?php $i = 1; ?>
    @foreach ($peraturan->status as $val)
    @if ($i>1)
    {!!'<br />'!!}    
    @endif
    {{$val->status}} {{$val->status == 'Dicabut' || $val->status == 'Diubah' ? 'dengan ':': '}}<a href="/lihat/{{$val->pivot->per_no_object}}">{{$val->pivot->per_no_object}}</a>
    <?php $i++; ?>
    @endforeach
    @endif
</td></tr>
<tr><th>Katalog</th><td><div style="width:26em;">
    <span>{{$peraturan->tajukNegara->nama_negara}}. {{$peraturan->tajukInstansi->nama_instansi}}</span>
    <div style="padding-left:2.5em;">{{$peraturan->bentuk->seragam}}</div>
    <div style="text-indent:1.5em;padding-left: 1em;">
        {{$peraturan->per_no}} tanggal {{\Carbon\Carbon::createFromFormat('Y-m-d', $peraturan->tanggal)->formatLocalized('%d %B %Y')}}, tentang {{$peraturan->tentang}}. -{{$peraturan->kota->nama_kota}}, {{\Carbon\Carbon::createFromFormat('Y-m-d', $peraturan->tanggal)->format('Y')}}.</div>
    @if (count($peraturan->sumber) > 0)
    <div style="padding-left:2.5em;margin-top:6px;"><p>
    <?php $i = 1; ?>
    @foreach ($peraturan->sumber as $val)
    @if ($i>1)
    {!!'<br />'!!}    
    @endif
    {{ $val->sumber_short }} {{ $val->pivot->year }} {{ !empty($val->pivot->jilid)?('('.$val->pivot->jilid.') '):'' }}: {{ $val->pivot->hal }} hlm
    <?php $i++; ?>
    @endforeach
    </p></div>    
    @endif
    @if (count($peraturan->subyek) > 0)
    <div style="padding-left:2.5em;margin-top:6px;">{!!$peraturan->subyek->implode('subyek', '<br />')!!}</div>
    @endif
    <div style="padding-left:2.5em;margin-top:10px;">
      <span class="pull-left"> {{$peraturan->bentuk_short}} </span>
      <span class="pull-right">{{$peraturan->lokasi}}</span>
    </div>
</div>
</td></tr>

<!-- <tr><th>Review</th><td><div style="width:26em;">
@if (count($peraturan->review) > 0)
@foreach ($peraturan->review as $val)
   
        <div style="padding-left:2.5em;margin-top:2px;">{{ $val->review }}</div>
    
@endforeach
@endif
</div> -->

@if($peraturan->bentuk->bentuk_short == 'PERMENBUMN')
<tr><th>Abstraksi</th><td>
  <a role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Lihat Abstrak <i class="glyphicon glyphicon-chevron-down"></i></a>   
</td></tr>
@endif




</tbody></table>

<div class="collapse" id="collapseExample">
  <div class="well">
    <p>{!!$peraturan->subyek->implode('subyek', '<br />')!!}</p>
    <p>{{\Carbon\Carbon::createFromFormat('Y-m-d', $peraturan->tanggal)->format('Y')}}</p>
    <p>{{$peraturan->bentuk_short}} {{$peraturan->per_no}},
    @if (count($peraturan->sumber) > 0)
    @foreach ($peraturan->sumber as $val)
    {{ $val->sumber_short }} {{ $val->pivot->year }} {{ !empty($val->pivot->jilid)?('('.$val->pivot->jilid.') '):'' }}: {{ $val->pivot->hal }} hlm.
    @endforeach
    @endif</p>
<p>{{$peraturan->bentuk->bentuk}} TENTANG {{$peraturan->tentang}}</p>
    <br>

    <table>
    @if (count($peraturan->abstrak->where('is_note', false)->pluck('abstrak')->all()) > 0)
    <?php
    $i = 1;
    ?>
    @foreach ($peraturan->abstrak->where('is_note', false)->pluck('abstrak')->all() as $val)
  <tr>
    <td>{{$i == 1?'ABSTRAK:':''}}</td>
    <td>
        <p> - </p>
    </td>
    <td>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </td>
    <td>
        <p>{!!$val!!}</p>
    </td>
  </tr>
    <?php
    $i++;
    ?>
    @endforeach
    @endif
    </table>

    <!-- <div class="mt-element-list">
        @if (count($peraturan->abstrak->where('is_note', false)->pluck('abstrak')->all()) > 0)
        <?php
        $i = 1;
        ?>
        @foreach ($peraturan->abstrak->where('is_note', false)->pluck('abstrak')->all() as $val)
        <div class="mt-list-head list-simple ext-1 font-white bg-blue-chambray">
            <div class="list-head-title-container">
                <h3 class="list-title">{{$i == 1?'ABSTRAK:':''}}</h3>
            </div>
        </div>
        <div class="mt-list-container list-simple ext-1 group">
            <div class="panel-collapse collapse in" id="completed-simple">
                <ul>
                    <li class="mt-list-item done">
                        <div class="list-icon-container">
                            <i class="icon-check"></i>
                        </div>
                        <div class="list-datetime"> {!!$val!!} </div>
                    </li>
                </ul>
            </div>
        </div>
        <?php
        $i++;
        ?>
        @endforeach
        @endif 
    </div> -->
     
     
    <table>
    @if (count($peraturan->abstrak->where('is_note', true)->pluck('abstrak')->all()) > 0)
    <?php
    $i = 1;
    ?>
    @foreach ($peraturan->abstrak->where('is_note', true)->pluck('abstrak')->all() as $val)
      <tr>
        <td>{{$i == 1?'CATATAN:':''}}</td>
        <td><p>-</p></td>
        <td><p>&nbsp;&nbsp;&nbsp;&nbsp;</p></td>
        <td><p>{!!$val!!}</p></td>
      </tr>
    <?php
    $i++;
    ?>
    @endforeach
    @else
      <tr>
        <td>CATATAN:</td>
        <td>-</td>
      </tr>
    @endif
    </table>


    <!-- <div class="mt-element-list">
        @if (count($peraturan->abstrak->where('is_note', true)->pluck('abstrak')->all()) > 0)
        <?php
        $i = 1;
        ?>
        @foreach ($peraturan->abstrak->where('is_note', true)->pluck('abstrak')->all() as $val)
        <div class="mt-list-head list-simple ext-1 font-white bg-blue-chambray">
            <div class="list-head-title-container">
                <h5 class="list-title">{{$i == 1?'CATATAN:':''}}</h5>
            </div>
        </div>
        <div class="mt-list-container list-simple ext-1 group">
            <div class="panel-collapse collapse in" id="completed-simple">
                <ul>
                    <li class="mt-list-item done">
                        <div class="list-icon-container">
                            <i class="icon-check"></i>
                        </div>
                        <div class="list-datetime"> {!!$val!!} </div>
                    </li>
                </ul>
            </div>
        </div>
        <?php
        $i++;
        ?>
        @endforeach
        @else
        <div class="mt-list-head list-simple ext-1 font-white bg-blue-chambray">
            <div class="list-head-title-container">
                <h5 class="list-title">CATATAN:</h5>
            </div>
        </div>
        <div class="mt-list-container list-simple ext-1 group">
            <div class="panel-collapse collapse in" id="completed-simple">
                <ul>
                    <li class="mt-list-item done">
                        <div class="list-icon-container">
                            <i class="icon-check"></i>
                        </div>
                        <div class="list-datetime"> - </div>
                    </li>
                </ul>
            </div>
        </div>
        @endif 
    </div> -->


  </div>
</div>
        </div>
            <div id="no-pdf" style="display: none; text-align: center">Maaf, PDF tidak ditemukan.</div>
            <img id="loading-icon" src="/assets/site/images/loading-icon.gif" style="margin: auto; display: none">
            <div id="filePDF" class="span9 fileview" style="background: transparent url("/assets/admin/layout/img/loading.gif")" >
            <div class="addthis_sharing_toolbox"></div>
                <object data="/baca/{{ $peraturan->per_no }}.pdf" type="application/pdf" width="100%" height="600px" onload="loaded()" onerror="notfoundpdf()">
                </object>
            </div>
        </div>
    </div>

<!--/.mainContent--> 
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