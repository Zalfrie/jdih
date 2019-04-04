@extends('layouts.site1.app')

@section('meta')
<meta name="description" content="{{!empty($kategori)?$kategori->kategori:'Berita'}} Jaringan Dokumentasi dan Informasi Hukum Kementerian BUMN"/>
@endsection

@section('content')

<section class="page-header">
<div class="container">
  <div class="row">
    <div class="col">
      <ul class="breadcrumb">
        <li><a href="/">Beranda</a></li>
        <li class="active">Berita</li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <h1>Berita</h1>
    </div>
  </div>
</div>
</section>

<div class="container">
	<div class="row">
		<div class="col">
			<div class="blog-posts">
				@if (count($berita) > 0)
	              @foreach($berita as $val)
	                <article class="post post-large">
	                	<div class="post-image">
							<div>
								<div>
									<div class="img-thumbnail d-block">
										<img class="img-fluid" src="{{$val->image}}" width="100%" alt="">
									</div>
								</div>
							</div>
						</div>
						<div class="post-date">
							<span class="day">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val->published_at)->formatLocalized('%d') }}</span>
							<span class="month">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val->published_at)->formatLocalized('%B') }}</span>
						</div>
						<div class="post-content">

							<h2><a href="/berita/{!! $val->slug !!}">{!! $val->title !!}</a></h2>
							<p>{!!substr($val->content, 0, strpos($val->content, '<br'))!!}</p>

							<div class="post-meta">
								&nbsp;
								&nbsp;
								&nbsp;
								<span class="d-block d-sm-inline-block float-sm-right mt-3 mt-sm-0"><a href="/berita/{!! $val->slug !!}" class="btn btn-xs btn-primary">Baca Selengkapnya...</a></span>
							</div>

						</div>
	                </article>
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
	            
			</div>
		</div>
	</div>
</div>

@endsection

@section('jsscript')
<script type="text/javascript">
jQuery(document).ready(function() {});
</script>
@endsection