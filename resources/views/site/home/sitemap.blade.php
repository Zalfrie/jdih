@extends('layouts.site.app')

@section('content')

<div class="contentWrapper"> 
    <div class="mainContent">
        <div class="container">
            <div class="row">
                <div class="col-md-16">
                    <ul>
					{!! $sitemap !!}
                    </ul>
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