@extends('layouts.site.app')

@section('meta')
<?php
$arr = explode('<br', $berita->content);
$meta = $arr[0];
?>
<meta name="description" content="{{strip_tags($meta)}}"/>
@endsection

@section('content')

<div class="">
    <div class="mainContent">
        <div class="container">
            <div class="row">
                <div class="col-md-16">
					<h4>{!!$berita->title!!}</h4>
                    <h6>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $berita->published_at)->formatLocalized('%d %B %Y') }} {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $berita->published_at)->format('H:i:s') }}</h6>
                    <?php
                    $listCat = $berita->kategori->pluck('kategori', 'slug')->all();
                    $catArray = [];
                    foreach($listCat as $slug => $cat){
                        $catArray[] = '<a href="'.$slug.'">'.$cat.'</a>';
                    }
                    ?>
                    <h6>{!!implode(', ', $catArray)!!}</h6>
                    <img src="{{$berita->image}}" />
                    <hr />
                    <span style="font-family:Helvetica; font-size: 14px; line-height: 150%; color: darkslategrey; text-align: justify">{!!$berita->content!!}</span>
				</div>
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