@extends('layouts.site1.app')

@section('meta')
<?php
$arr = explode('<br', $berita->content);
$meta = $arr[0];
?>
<meta name="description" content="{{strip_tags($meta)}}"/>
@endsection

@section('content')

<section class="page-header">
	<div class="container">
	  <div class="row">
	    <div class="col">
	      <ul class="breadcrumb">
	        <li><a href="/">Beranda</a></li>
	        <li><a href="/berita">Berita</a></li>
	        <li class="active">{!!$berita->title!!}</li>
	      </ul>
	    </div>
	  </div>
	  <div class="row">
	    <div class="col">
	      <h1>{!!$berita->title!!}</h1>
	    </div>
	  </div>
	</div>
</section>

<div class="container">
	<div class="row">
		<div class="col-lg-9">
			<div class="blog-posts single-post">
				<article class="post post-large blog-single-post">
					<div class="post-image">
						<div>
							<div>
								<div class="img-thumbnail d-block">
									<img class="img-fluid" src="{{$berita->image}}" width="100%" alt="">
								</div>
							</div>
						</div>
					</div>

					<div class="post-date">
						<span class="day">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $berita->published_at)->formatLocalized('%d') }}</span>
						<span class="month">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $berita->published_at)->formatLocalized('%B') }}</span>
					</div>

					<div class="post-content">

						<h2><a href="blog-post.html">{!!$berita->title!!}</a></h2>
						<?php
	                    $listCat = $berita->kategori->pluck('kategori', 'slug')->all();
	                    $catArray = [];
	                    foreach($listCat as $slug => $cat){
	                        $catArray[] = '<a href="'.$slug.'">'.$cat.'</a>';
	                    }
	                    ?>
						<div class="post-meta">
							<span><i class="fas fa-tag"></i> {!!implode(', ', $catArray)!!} </span>
						</div>

						<p>{!!$berita->content!!}</p>

					</div>
				</article>
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