
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
			<div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-book-open"></i> Tambah Whitelist
					</div>
				</div>
				<div class="portlet-body form">
                    @include('common.errors')
					<form id="newDataForm" class="form-horizontal" action="/administrasi/whitelist" method="POST" enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}
						<div class="form-body">
                            <div class="row">
                                <div class="col-md-9">
        							<div class="form-group">
        								<label class="col-md-2 control-label">IP Address</label>
                                        <div class="col-md-10">
        								    <input type="text" name="ip" class="form-control input-sm" value="{{ old('ip') }}" >
                                        </div>
        							</div>
        							<div class="form-group">
        								<label class="col-md-2 control-label">Domain</label>
                                        <div class="col-md-10">
        								    <input type="text" name="domain" class="form-control input-sm" value="{{ old('domain') }}" >
                                        </div>
        							</div>
        							<div class="form-group">
        								<label class="col-md-2 control-label">Keterangan</label>
                                        <div class="col-md-10">
        								    <input type="text" name="keterangan" class="form-control input-sm" value="{{ old('keterangan') }}" >
                                        </div>
        							</div>
        							<div class="form-group">
        								<label class="col-md-2 control-label">Aktif</label>
                                        <div class="col-md-10">
        									<div class="icheck-inline">
        										<label>
        										<input type="radio" name="status" value="draft" checked class="icheck" data-radio="iradio_square-grey"> Tidak </label>
        										<label>
        										<input type="radio" name="status" value="publish" class="icheck" data-radio="iradio_square-grey"> Ya </label>
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