@extends('layouts.site1.app')

@section('meta')
<meta name="description" content="prakata"/>
@endsection

@section('content')

<section class="page-header">
	<div class="container">
	  <div class="row">
	    <div class="col">
	      <ul class="breadcrumb">
	        <li><a href="/">Beranda</a></li>
	        <li class="active">Prepare BUMN</li>
	      </ul>
	    </div>
	  </div>
	  <div class="row">
	    <div class="col">
	      <h1>Menuju Peraturan Menteri BUMN yang efektif dan efisien</h1>
	    </div>
	  </div>
	</div>
</section>

<section class="section section-default">
	<div class="container">
		<div class="row">
			<div class="col">
				<h4 class="mb-0">Apakah Prepare BUMN?</h4>
				<p class="mb-0">{!! $mukadimah->content !!}</p>
			</div>
		</div>
	</div>
</section>

<div class="container">
	<div class="row">
		<div class="col">
			<div class="toggle toggle-primary" data-plugin-toggle>
				<section class="toggle">
					<label>Apa itu PREPARE BUMN</label>
					<p style="height: 0px;" class="">{!! $mukadimah1 !!}</p>
				</section>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="toggle toggle-primary" data-plugin-toggle>
				<section class="toggle">
					<label>Ruang Lingkup Peraturan</label>
					<p style="height: 0px;" class="">{!! $mukadimah2 !!}</p>
				</section>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="toggle toggle-primary" data-plugin-toggle>
				<section class="toggle">
					<label>Output yang diharapkan</label>
					<p style="height: 0px;" class="">{!! $mukadimah2 !!}</p>
				</section>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="toggle toggle-primary" data-plugin-toggle>
				<section class="toggle">
					<label>Metode Evaluasi</label>
					<p style="height: 0px;" class="">{!! $mukadimah2 !!}</p>
				</section>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="toggle toggle-primary" data-plugin-toggle>
				<section class="toggle">
					<label>Bagimana Berkontribusi & Waktu Pelaksanaan</label>
					<p style="height: 0px;" class="">{!! $mukadimah1 !!}</p>
				</section>
			</div>
		</div>
	</div>
	<div class="form-group" style="text-align: center">
	    <div class="col-sm-16" >
	        <a href="/administrasi/review">
	        <button type="button" class="button button-3d button-primary button-rounded"
	            style="width: 25%; height: 100px; font-size: 20pt; margin-top: 20px;margin-bottom: 15px">
	            <b>Reviu di sini</b></button>
	        </a>
	    </div>
	</div><p>&nbsp;</p>
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