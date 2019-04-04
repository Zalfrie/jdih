@extends('layouts.site.app')

@section('meta')
<meta name="description" content="prakata"/>
@endsection

@section('content')

  <div id="bottomHeader">
    <div class="container">
      <h1>PREPARE BUMN</h1>
      <h4>menuju Peraturan Menteri BUMN yang efektif dan efisien</h4>
    </div>
  </div>
  <!--/#bottomHeader-->


  <div class="contentWrapper">
    <div class="container" style="font-family:Helvetica; font-size: 16px; line-height: 150%; color: darkslategrey; text-align: justify">
<!--        <div class="row">-->
            <div class="col-md-16">
                <span>
                    {!! $mukadimah->content !!}
                </span>
            </div>
<!--        </div>-->
        <div class="col-sm-16"><!--
            <div class="hasilPencarian">
                <p class="blue-text">Review Peraturan</p>
                <div class="table-wrapper">
                    <table id="tablePeraturan" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr bgcolor="#0a3c6b">
                            <th style="width: 10px;">NOMOR</th>
                            <th style="width: 30px;">TANGGAL PENETAPAN</th>
                            <th style="width: 100px;">TENTANG</th>
                            <th style="width: 10px;">WAKTU REVIEW</th>
                            <th style="width: 10px;">STATUS</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($peraturan) > 0)
                        @foreach($peraturan as $val)
                        <?php
/*                        $status = [];
                        foreach($val->status as $stat){
                            $status[] = $stat->status.' : <a href="/lihat/'.$stat->pivot->per_no_object.'">'.$stat->pivot->per_no_object.'</a>';
                        }
                        $strStatus = (count($status) > 0)?(implode('<br/>', $status)):'';
                        */?>
                        <tr>
                            <td style="text-align: left;">{!! '<a href="/lihat/'.$val->per_no.'">'.$val->per_no.'</a>' !!}</td>
                            <td style="text-align: left;">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $val->tanggal)->formatLocalized('%d %B %Y') }}</td>
                            <td style="text-align: left;">{{ $val->tentang }}</td>
                            <td style="text-align: left;">{!! \Carbon\Carbon::parse($val->review_start)->formatLocalized('%d %b %Y').' s/d<br>'.\Carbon\Carbon::parse($val->review_end)->formatLocalized('%d %b %Y') !!}</td>
                            <td style="text-align: center;">@if(\Carbon\Carbon::parse($val->review_start)->format('Y-m-d') <= date('Y-m-d')
                                && \Carbon\Carbon::parse( $val->review_end)->format('Y-m-d') >= date('Y-m-d'))
                                Open
                                @else
                                Closed
                                @endif</td>
                        </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                    {!! $peraturan->render() !!}
                </div>
            </div>--><p>&nbsp;</p>
            <input id="mukadimah" type="text" value="" hidden/>
            <div class="form-group">
                <div class="col-sm-3" style="margin-bottom: 15px">
                    <div class="button button-3d button-primary button-rounded"
                                style="font-size: 10pt; height: 70px; line-height: 17px" onclick="lihat('1')">
                            <div style="margin-top: 10px">Apa itu PREPARE BUMN</div>
                    </div>
                </div>
                <div class="col-sm-3" >
                    <div class="button button-3d button-primary button-rounded"
                                style="font-size: 10pt; height: 70px; line-height: 17px" onclick="lihat('2')">
                            <div style="margin-top: 10px">Ruang Lingkup Peraturan</div>
                    </div>
                </div>
                <div class="col-sm-3" >
                    <div class="button button-3d button-primary button-rounded"
                                style="font-size: 10pt; height: 70px; line-height: 17px" onclick="lihat('3')">
                            <div style="margin-top: 10px">Output yang diharapkan</div>
                    </div>
                </div>
                <div class="col-sm-3" >
                    <div class="button button-3d button-primary button-rounded"
                                style="font-size: 10pt; height: 70px; line-height: 17px" onclick="lihat('4')">
                            <div style="margin-top: 15px">Metode Evaluasi</div>
                    </div>
                </div>
                <div class="col-sm-3" >
                    <div class="button button-3d button-primary button-rounded"
                                style="font-size: 10pt; height: 70px; line-height: 17px" onclick="lihat('5')">
                            <div>Bagimana Berkontribusi & Waktu Pelaksanaan</div>
                    </div>
                </div>
            </div>
            <div id="lihat-1" class="col-md-16 lihat-mukadimah" style="display: none">
                {!! $mukadimah1 !!}
            </div>
            <div id="lihat-2" class="col-md-16 lihat-mukadimah" style="display: none">
                {!! $mukadimah2 !!}
            </div>
            <div id="lihat-3" class="col-md-16 lihat-mukadimah" style="display: none">
                {!! $mukadimah3 !!}
            </div>
            <div id="lihat-4" class="col-md-16 lihat-mukadimah" style="display: none">
                {!! $mukadimah4 !!}
            </div>
            <div id="lihat-5" class="col-md-16 lihat-mukadimah" style="display: none">
                {!! $mukadimah5 !!}
            </div>
            <div class="form-group" style="text-align: center">
                <div class="col-sm-16" >
                    <a href="/administrasi/review">
                    <button type="button" class="button button-3d button-primary button-rounded"
                        style="width: 40%; height: 200px; font-size: 30pt; margin-top: 20px;margin-bottom: 15px">
                        <b>Reviu di sini</b></button>
                    </a>
                </div>
            </div><p>&nbsp;</p>
        </div>
    </div>
  </div>
@endsection

@section('jspluginscript')
<script type="text/javascript" src="/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<!--<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>-->
<!--<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Buttons/2.0.0/js/buttons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Buttons/2.0.0/js/buttons.min.js"></script>
@endsection

@section('csspluginscript')
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!--<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Buttons/2.0.0/css/buttons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Buttons/2.0.0/css/buttons.min.css">
@endsection

@section('jsscript')
<script type="text/javascript">
    itemShow = "";

    function lihat(val) {
        mukadimahShow = "lihat-" + val;
        if(itemShow != mukadimahShow){
            document.getElementById("lihat-1").style.display = "none";
            document.getElementById("lihat-2").style.display = "none";
            document.getElementById("lihat-3").style.display = "none";
            document.getElementById("lihat-4").style.display = "none";
            document.getElementById("lihat-5").style.display = "none";
            document.getElementById(mukadimahShow).style.display = "block";
            itemShow = mukadimahShow;
        }else{
            document.getElementById("lihat-1").style.display = "none";
            document.getElementById("lihat-2").style.display = "none";
            document.getElementById("lihat-3").style.display = "none";
            document.getElementById("lihat-4").style.display = "none";
            document.getElementById("lihat-5").style.display = "none";
            itemShow = "";
        }
    }
jQuery(document).ready(function() {
});
</script>
@endsection