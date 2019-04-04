@extends('layouts.site1.app')

@section('meta')
<meta name="description" content="Website Resmi Jaringan Dokumentasi dan Informasi Hukum Kementerian BUMN"/>
@endsection

@section('content')
@include('site1.home.main-banner')

<div class="home-intro" id="home-intro">
	<div class="container">

		<div class="row align-items-center">
			<div class="col-lg-25">
				<marquee scrolldelay="100">
	               <p>{!! $title_beranda->content !!}</p>
	            </marquee>
			</div>
		</div>

	</div>
</div>

<div class="container" id="home-intro">
	<div class="row">
		<div class="col-lg-8">
			<div class="featured-box featured-box-secondary featured-box-text-left">
				<div class="box-content">
					<div class="row">
						<div class="col">
							 <h2>Peraturan <strong>Terbaru</strong></h2>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							@if (count($newest) > 0)
							  <ul class="list list-icons list-icons-sm">
				              @foreach($newest as $val)
				                <li><i class="fas fa-caret-right"></i>
				                  <a class="clearfix" href="/lihat/{!! $val->per_no !!}">
				                    <span style="color: #F00;">{!! $val->per_no !!}</span> Tentang {!! implode(' ', array_slice(explode(' ', $val->tentang), 0, 15)) !!} {{count(explode(' ', $val->tentang)) > 15?' ...':''}}
				                    </a>
				                    <p>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $val->tanggal)->formatLocalized('%d %B %Y') }}</p>
				                    <a class="clearfix" href="/unduh/{!! $val->per_no !!}.pdf">
				                    <span class="download-button">
				                      <img src="/assets/site/images/icon_download.png" alt="Download PDF">
				                    </span>
				                  </a>
				                </li>
				              @endforeach
				          	  </ul>
		              		@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="featured-box featured-box-primary featured-box-text-left">
				<div class="box-content">
					<div class="row">
						<div class="col">
							<h5>Peraturan <strong>Terpopuler</strong></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							@if (count($populer) > 0)
							  <ol class="list list-ordened">
				              @foreach($populer as $key => $val)
				                <li>
				                  <a class="clearfix" href="/lihat/{!! $val->per_no !!}">
				                    <p class="listHeading"><span style="color: #F00;">{!! $val->per_no !!}</span> Tentang {!! implode(' ', array_slice(explode(' ', $val->tentang), 0, 15)) !!} {{count(explode(' ', $val->tentang)) > 15?' ...':''}}</p>
				                    dibaca {{ $val->monthly_counter }} kali
				                  </a>
				                </li>
				              @endforeach
				          	  </ol>
				            @endif
						</div>
					</div>
				</div>
			</div>
			<div class="accordion" id="accordion">
				<div class="card card-default">
					<div class="card-header">
						<h4 class="card-title m-0">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
								<i class="fas fa-laptop"></i>
								Statistik Pengunjung
							</a>
						</h4>
					</div>
					<div id="collapseOne" class="collapse show">
						<div class="card-body">
							<p>Pengunjung Hari Ini <strong data-to="120" data-plugin-counter data-plugin-options="{'speed': 3500}">0</strong></p>

							<p>Pengujung Aktif <strong class="alternative-font" data-to="450" data-plugin-counter data-plugin-options="{'speed': 3500}">0</strong></p>

							<p>Total Keseluruhan <strong class="alternative-font" data-to="1500000" data-plugin-counter data-plugin-options="{'speed': 3500}">0</strong></p>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<section class="call-to-action call-to-action-default with-button-arrow content-align-center call-to-action-in-footer" id="prepare-kbumn">
	<div class="container" >
		<div class="row">
			<div class="col-md-8 col-lg-8">
				<div class="call-to-action-content">
					<h3>PREPARE BUMN menuju Peraturan <strong>Menteri BUMN</strong> yang efektif dan efisien</h3>
				</div>
			</div>
			<div class="col-md-4 col-lg-4">
				<div class="call-to-action-btn">
					<a href="/prepare" target="_blank" class="btn btn-lg btn-primary">Prepare BUMN</a><span class="arrow hlb d-none d-md-block" data-appear-animation="rotateInUpLeft" style="top: -40px; left: 70%;"></span>
				</div>
			</div>
		</div>
	</div>
</section>
<br>
<br>
<hr class="tall">
<div class="container" id="berita-terbaru">
	<div class="featured-box featured-box-primary featured-box-text-left">
		<div class="box-content">
			<div class="recent-posts mb-5">
			<h2>Berita <strong>Terbaru</strong></h2>
				<div class="owl-carousel owl-theme mb-0" data-plugin-options="{'items': 1}">
					<div class="row">
						@if (count($berita) > 0)
			              @foreach($berita as $val)
			              <div class="col-lg-6">
							<article>
								<div class="date">
									<span class="day">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val->published_at)->formatLocalized('%d') }}</span>
									<span class="month">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val->published_at)->formatLocalized('%B') }}</span>
								</div>
								<h4 class="heading-primary"><a href="/berita/{!! $val->slug !!}">{!! $val->title !!}</a></h4>
								<p>{!!strip_tags(substr($val->content, 0, 100))!!} ...  <a href="/berita/{!! $val->slug !!}" class="read-more">read more <i class="fas fa-angle-right"></i></a></p>
							</article>
						  </div>
			              @endforeach
		                @endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<section class="section section-default section-default-scale-1">
		<div class="container">
			<div class="row">
				<div class="col">
					<h4 class="mb-0">Disclaimer</h4>
					<p class="mb-0">{!!$disclaimer->content!!}</p>
				</div>
			</div>
		</div>
	</section>
</div>

@endsection