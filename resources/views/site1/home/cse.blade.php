@extends('layouts.site1.app')

@section('meta')
<meta name="robots" content="noindex, nofollow" />
@endsection

@section('content')
<div id="bottomHeader">
    <div class="container">
      <h3>Pencarian Khusus</h3>
    </div>
  </div>
  <!--/#bottomHeader-->


  <div class="contentWrapper">
    <div class="container">
      <div class="col-sm-16">
        <div>
<gcse:searchbox></gcse:searchbox>
        </div>
        <div>
<gcse:searchresults></gcse:searchresults>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('jsscript')
@endsection