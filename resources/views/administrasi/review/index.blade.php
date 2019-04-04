@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption" style="margin-left: 50px">
						<i class="icon-settings"></i>
						<span class="caption-subject bold uppercase">Program Evaluasi Peraturan Menteri BUMN</span>
					</div>
                    @if(Auth::user()->hasRole(['sys_admin', 'Admin_Konten']))
                    <div class="actions">
                        <a type="button" class="btn blue" href="/administrasi/review/tambah">
                            <i class="fa fa-btn fa-plus"></i>Tambah Baru
                        </a>
                    </div>
                    @endif
				</div>
				<div class="portlet-body" style="padding-left: 50px; padding-right: 50px">
                <!--<span style="font-family:Helvetica; font-size: 16px; line-height: 150%; color: darkslategrey; text-align: center">
                    <br>
                    { $mukadimah->content }
                </span>-->
					<!--<div class="form-body">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-4">
            						<div class="form-group">
            							<label class="col-md-4 control-label">Bentuk</label>
                                        <div class="col-md-8">
            								<select class="form-control select2 input-sm" name="bentuk">
                                                <option></option>
                                                @if (count($bentuk) > 0)
                                                @foreach ($bentuk as $val)
                                                <option value="{{ $val->bentuk_short }}">{{ $val->bentuk_short }}</option>
                                                @endforeach
                                                @endif
            								</select>
                                        </div>
            						</div>
            						<div class="form-group">
            							<label class="col-md-4 control-label">Nomor</label>
                                        <div class="col-md-8">
            								<input type="text" name="perno" class="form-control input-sm" />
                                        </div>
            						</div>
                                </div>
                                <div class="col-md-4">
            						<div class="form-group">
            							<label class="col-md-4 control-label">Tentang</label>
                                        <div class="col-md-8">
            							    <input type="text" name="tentang" class="form-control input-sm" />
                                        </div>
            						</div>
            						<div class="form-group">
            							<label class="col-md-4 control-label">Status</label>
                                        <div class="col-md-8">
            								<select class="form-control select2 input-sm" name="status" >
                                                <option></option>
                                                @if (count($status) > 0)
                                                @foreach ($status as $val)
                                                <option value="{{ $val->status_id }}">{{ $val->status }}</option>
                                                @endforeach
                                                @endif
            								</select>
                                        </div>
            						</div>
                                </div>
                                <div class="col-md-4">
            						<div class="form-group">
            							<label class="col-md-4 control-label">Tahun</label>
                                        <div class="col-md-8">
            							    <input type="text" name="tahun" class="form-control input-sm" maxlength="4" />
                                        </div>
            						</div>
            						<div class="form-group">
            							<label class="col-md-4 control-label">Publish</label>
                                        <div class="col-md-8">
            								<select class="form-control select2 input-sm" name="publish" >
                                                <option></option>
                                                <option value="t">Publish</option>
                                                <option value="f">Unpublished</option>
            								</select>
                                        </div>
            						</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
            						<div class="form-group">
            							<label class="col-md-2 control-label">Subyek</label>
                                        <div class="col-md-8">
            								<select class="form-control select2 input-sm" name="subyek">
                                                <option></option>
                                                @if (count($subyek) > 0)
                                                @foreach ($subyek as $val)
                                                    <option value="{{ $val->subyek_id }}">{{ $val->subyek }}</option>
                                                @endforeach
                                                @endif
            								</select>
                                        </div>
                                        <div class="col-md-1">
            								<a id="cari" type="button" class="btn btn-sm blue" href="javascript:;" >
            									cari
            								</a>
                                        </div>
            						</div>
                                </div>
                            </div>
                        </form>
					</div>-->
                    <div class="clearfix"></div>
                    <hr />
					<table class="table table-striped table-bordered table-hover" id="tablePeraturan">
    					<thead>
        					<tr>
                                <th>No</th>
    							<!--<th>Bentuk</th>-->
    							<th>Nomor</th>
    							<th>Tgl Penetapan /<br />Pengesahan</th>
    							<th>Tentang</th>
    							<th>Jml. Review</th>
    							<th>Jml. User</th>
                                <th>Waktu Evaluasi</th>
                                <th>Status</th>
                                <th>berkas</th>
    							<th>Action</th>
        					</tr>
    					</thead>
    					<tbody>
    					</tbody>
					</table>
				</div>
			</div>
        </div>
    </div>
@endsection

@section('jspluginscript')
<script type="text/javascript" src="/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
@endsection

@section('csspluginscript')
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
@endsection

@section('jsscript')
<script type="text/javascript">

jQuery(document).ready(function() {

    $('.stopReview').click(function(){
        var that = this;
        bootbox.confirm("Anda yakin akan stop Review peraturan ini?", function(result) {
            if (result){
                $(that).closest('form').submit();
            }
        });
    });

    $(".select2").select2({
        placeholder: "Pilih...",
        allowClear: true
    });
    oTable = $('#tablePeraturan').dataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        "ajax": {
            "url": '/administrasi/review/getdatatable',
            "type": "POST",
            data: function (d) {
//                d.bentuk = $('select[name=be]').val();
                d.perno = $('input[name=perno]').val();
                d.tentang = $('input[name=tentang]').val();
                d.tahun = $('input[name=tahun]').val();
                d.review = $('select[name=review]').val();
                d.subyek = $('select[name=subyek]').val();
            }
        },
        "columns": [
            {data: null, sortable: false, searchable: false},
//            {data: 'bentuk.short', name: 'bentuk.short'},
            {data: 'perno', name: 'perno'},
            {data: 'tanggal.humanShort', name: 'tanggal.short'},
            {data: 'tentang', name: 'tentang', sortable: false},
            {data: 'sum', name: 'jumlah'},
            {data: 'sum_distinct', name: 'jumlah_user', width: "10%"},
            {data: 'waktu_review', name: 'waktu'},
            {data: 'status', name: 'status'},
            {data: 'berkas', name: 'berkas'},
            {data: 'actions', name: 'actions', searchable: false, sortable: false}
        ],
        "lengthMenu": [
            [10, 20, -1],
            [10, 20, "All"]
        ],
        "pageLength": 20,
        "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        "rowCallback": function( row, data, iDisplayIndex ) {
            var info = oTable.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = (page * length + (iDisplayIndex +1));
            $('td:eq(0)', row).html(index);

            $(row).on('click', '.reviewnote', function () {
                var nTr = row;
                if (oTable.fnIsOpen(nTr)) {
                    if ($('.row-details-open', nTr).length && !$('.row-details-open', nTr).hasClass('reviewnote')){
                        $('.row-details-open', nTr).trigger('click');
                        $(this).addClass("row-details-open").removeClass("row-details-close");
                        oTable.fnOpen(nTr, fnReviewDetails(oTable, nTr, data), 'details');
                    }else{
                        $(this).addClass("row-details-close").removeClass("row-details-open");
                        oTable.fnClose(nTr);
                    }
                } else {
                    $(this).addClass("row-details-open").removeClass("row-details-close");
                    oTable.fnOpen(nTr, fnReviewDetails(oTable, nTr, data), 'details');
                }
            });

            $(row).on('click', '.pdf', function () {
                var nTr = row;
                if (oTable.fnIsOpen(nTr)) {
                    if ($('.row-details-open', nTr).length && !$('.row-details-open', nTr).hasClass('pdf')){
                        $('.row-details-open', nTr).trigger('click');
                        $(this).addClass("row-details-open").removeClass("row-details-close");
                        oTable.fnOpen(nTr, fnShowPDF(oTable, nTr, data), 'details');
                    }else{
                        $(this).addClass("row-details-close").removeClass("row-details-open");
                        oTable.fnClose(nTr);
                    }
                } else {
                    $(this).addClass("row-details-open").removeClass("row-details-close");
                    oTable.fnOpen(nTr, fnShowPDF(oTable, nTr, data), 'details');
                }
            });
        }
    });
    var tableWrapper = $('#tablePeraturan_wrapper');
    tableWrapper.find('.dataTables_length select').select2();
    
    $("#cari").click(function(){
        oTable.fnDraw();
    });

    function fnReviewDetails(oTable, nTr, data) {
        var sOut = '<div class="well katalog no-margin">';
        sOut += data.review;
        sOut += '</div>';
        

        return sOut;
    }

    function fnShowPDF(oTable, nTr, data) {
        var aData = oTable.fnGetData(nTr);
        var sOut = '<table>';
        sOut += '<tr>';
        sOut += '<div>';
        sOut += '<object data="/administrasi/review/pdf/'+data.file+'" type="application/pdf" width="100%" height="600px"> ';
        sOut += '</object>';
        sOut += '</div>';
        sOut += '</tr>';
        sOut += '</table>';

        return sOut;
    }
});
</script>
@endsection