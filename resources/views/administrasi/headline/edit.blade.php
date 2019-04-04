
@extends('layouts.app')

@section('content')
    
    <div class="row">
        <div class="col-md-12">
			<div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-book-open"></i> Edit Headline
					</div>
				</div>
				<div class="portlet-body form">
                    @include('common.errors')
					<form id="ubahDataForm" class="form-horizontal" action="/administrasi/headline/{{ $data->id }}" method="POST" role="form">
                    {{ csrf_field() }}
                        {{ method_field('PUT') }}
						<div class="form-body">
                            <div class="row">
                                <div class="col-md-9">
        							<div class="form-group">
        								<label class="col-md-2 control-label">Konten</label>
                                        <div class="col-md-10">
        								    <input type="text" name="konten" class="form-control input-sm" value="{{ $data->content }}" >
                                        </div>
        							</div>
        							<div class="form-group">
        								<label class="col-md-2 control-label">Aktif</label>
                                        <div class="col-md-10">
        									<div class="icheck-inline">
        										<label>
        										<input type="radio" name="status" value="draft" {{(!$data->is_active)? 'checked':''}} class="icheck" data-radio="iradio_square-grey"> Tidak </label>
        										<label>
        										<input type="radio" name="status" value="publish" {{($data->is_active)? 'checked':''}} class="icheck" data-radio="iradio_square-grey"> Ya </label>
        									</div>
                                        </div>
        							</div>
                                </div>
                            </div>
						</div>
						<div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
        							<a type="button" href="/administrasi/headline" class="btn default">Kembali</a>
        							<button type="submit" class="btn green">Simpan</button>
                                </div>
                            </div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
@endsection

@section('jspluginscript')
<script type="text/javascript" src="/assets/global/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-markdown/lib/markdown.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="/assets/global/plugins/icheck/icheck.min.js"></script>
@endsection

@section('csspluginscript')
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" />
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<link type="text/css" href="/assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>
@endsection

@section('jsscript')
<script type="text/javascript">
jQuery(document).ready(function() {
});
</script>
@endsection