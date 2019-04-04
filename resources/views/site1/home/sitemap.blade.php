@extends('layouts.site1.app')

@section('content')

<section class="page-header">
<div class="container">
  <div class="row">
    <div class="col">
      <ul class="breadcrumb">
        <li><a href="/">Beranda</a></li>
        <li class="active">Peta Situs</li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <h1>Peta Situs</h1>
    </div>
  </div>
</div>
</section>

<div class="container">
	<div class="row justify-content-between">
		<div class="col-lg-4">
			<ul class="nav nav-list flex-column mb-5">
				<li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
				<li class="nav-item">
					<a class="nav-link" href="#">Peraturan</a>
					<ul>
						<li class="nav-item"><a class="nav-link" href="/permenbumn">PERMEN BUMN</a></li>
						<li class="nav-item"><a class="nav-link" href="/kepmenbumn">KEPMEN</a></li>
						<li class="nav-item"><a class="nav-link" href="/semenbumn">SE Menteri</a></li>
					</ul>
				</li>
				<li class="nav-item"><a class="nav-link" href="/">Berita</a></li>
				<li class="nav-item"><a class="nav-link" href="/">Visi & Misi</a></li>
				<li class="nav-item"><a class="nav-link" href="/">Kontak Kami</a></li>
			</ul>
		</div>
	</div>
</div>

@endsection

@section('jsscript')
<script type="text/javascript">
jQuery(document).ready(function() {});
</script>
@endsection