@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue-chambray">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-settings"></i>
						<span class="caption-subject bold uppercase"> PRODUK HUKUM</span>
					</div>
					<div class="actions">
						<a type="button" class="btn blue" href="/administrasi/peraturan/tambah">
                            <i class="fa fa-btn fa-plus"></i>Tambah Baru
                        </a>
					</div>
				</div>
				<div class="portlet-body">
					<div class="form-body">
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
					</div>
                    <div class="clearfix"></div>
                    <hr />
					<table class="table table-striped table-bordered table-hover" id="tablePeraturan">
    					<thead>
        					<tr>
                                <th>No</th>
    							<th>Bentuk</th>
    							<th>Nomor</th>
    							<th>Tgl Penetapan /<br />Pengesahan</th>
    							<th>Tentang</th>
    							<th>Sumber<br />Peraturan</th>
    							<th>Status<br />Peraturan</th>
    							<th>Status<br/>Publish</th>
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
    $(".select2").select2({
        placeholder: "Pilih...",
        allowClear: true
    });
    oTable = $('#tablePeraturan').dataTable({
        "processing": true,
        "serverSide": true,
         "stateSave": true,
        "ajax": {
            "url": '/administrasi/peraturan/getdatatable',
            "type": "POST",
            data: function (d) {
                d.bentuk = $('select[name=bentuk]').val();
                d.perno = $('input[name=perno]').val();
                d.tentang = $('input[name=tentang]').val();
                d.status = $('select[name=status]').val();
                d.tahun = $('input[name=tahun]').val();
                d.publish = $('select[name=publish]').val();
                d.subyek = $('select[name=subyek]').val();
            }
        },
        "columns": [
            {data: null, sortable: false, searchable: false},
            {data: 'bentuk.short', name: 'bentuk.short'},
            {data: 'pernoOut', name: 'perno'},
            {data: 'tanggal.humanShort', name: 'tanggal.short'},
            {data: 'tentang', name: 'tentang'},
            {data: 'sumberTabel', name: 'sumberTabel'},
            {data: 'statusList', name: 'statusList'},
            {data: 'publishCol', name: 'publish.state'},
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
            
            $(row).on('click', '.publish', function () {
                $.ajax({
                    url: "/administrasi/peraturan/publish",
                    method: "POST",
                    data: {perno: data.perno, val: $(this).attr('data-publish')},
                    dataType: "json",
                    success: function(hasil){
                        if (hasil.isPublish == 't'){
                            $('.publishCheck', row).removeClass('fa-square').addClass('fa-check-square').removeClass('font-red').addClass('font-green');
                            $('.publish', row).removeClass('green').addClass('red').text('batalkan').attr('data-publish', hasil.isPublish);
                        }else if (hasil.isPublish == 'f'){
                            $('.publishCheck', row).removeClass('fa-check-square').addClass('fa-square').removeClass('font-green').addClass('font-red');
                            $('.publish', row).removeClass('red').addClass('green').text('publish').attr('data-publish', hasil.isPublish);
                        }
                        toastr[hasil.type](hasil.message, hasil.title);
                    }
                });
            });
            
            $(row).on('click', '.katalog', function () {
                var nTr = row;
                if (oTable.fnIsOpen(nTr)) {
                    if ($('.row-details-open', nTr).length && !$('.row-details-open', nTr).hasClass('katalog')){
                        $('.row-details-open', nTr).trigger('click');
                        $(this).addClass("row-details-open").removeClass("row-details-close");
                        oTable.fnOpen(nTr, fnKatalogDetails(oTable, nTr, data), 'details');
                    }else{
                        $(this).addClass("row-details-close").removeClass("row-details-open");
                        oTable.fnClose(nTr);
                    }
                } else {
                    $(this).addClass("row-details-open").removeClass("row-details-close");
                    oTable.fnOpen(nTr, fnKatalogDetails(oTable, nTr, data), 'details');
                }
            });
            
            $(row).on('click', '.abstrak', function () {
                var nTr = row;
                if (oTable.fnIsOpen(nTr)) {
                    if ($('.row-details-open', nTr).length && !$('.row-details-open', nTr).hasClass('abstrak')){
                        $('.row-details-open', nTr).trigger('click');
                        $(this).addClass("row-details-open").removeClass("row-details-close");
                        oTable.fnOpen(nTr, fnAbstrakDetails(oTable, nTr, data), 'details');
                    }else{
                        $(this).addClass("row-details-close").removeClass("row-details-open");
                        oTable.fnClose(nTr);
                    }
                } else {
                    $(this).addClass("row-details-open").removeClass("row-details-close");
                    oTable.fnOpen(nTr, fnAbstrakDetails(oTable, nTr, data), 'details');
                }
            });
            
            $(row).on('click', '.log', function () {
                var nTr = row;
                if (oTable.fnIsOpen(nTr)) {
                    if ($('.row-details-open', nTr).length && !$('.row-details-open', nTr).hasClass('log')){
                        $('.row-details-open', nTr).trigger('click');
                        $(this).addClass("row-details-open").removeClass("row-details-close");
                        oTable.fnOpen(nTr, logAct(oTable, nTr, data), 'details');
                    }else{
                        $(this).addClass("row-details-close").removeClass("row-details-open");
                        oTable.fnClose(nTr);
                    }
                } else {
                    $(this).addClass("row-details-open").removeClass("row-details-close");
                    oTable.fnOpen(nTr, logAct(oTable, nTr, data), 'details');
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
    
            $('.deletePeraturan', row).click(function(){
                var that = this;
                bootbox.confirm("Anda yakin akan menghapus data ini?", function(result) {
                   if (result){
                        $(that).closest('form').submit();
                   }
                });
            });
        }
    });
    var tableWrapper = $('#tablePeraturan_wrapper');
    tableWrapper.find('.dataTables_length select').select2();
    
    $("#cari").click(function(){
        oTable.fnDraw();
    });


    $(document).keypress(function (e) {
        if (e.which == 13) {
            oTable.fnDraw();
            //alert('enter key is pressed');
        }
    });
    
    function fnKatalogDetails(oTable, nTr, data) {
        var aData = oTable.fnGetData(nTr);
        var sOut = '<div class="well katalog no-margin">';
        sOut += '<p class="tajukEntri">';
        sOut += data.tajukEntri;
        sOut += '</p>';
        sOut += '<p class="judulSeragam">';
        sOut += data.bentuk.seragam;
        sOut += '</p>';
        sOut += '<p class="isi">';
        sOut += data.perno+' tanggal '+ data.tanggal.human +', tentang '+ data.tentang +'. -'+ data.kota +', '+ data.tanggal.tahun +'.';
        sOut += '</p>';
        for (var i = 0; i < data.sumber.length; i++){
            sOut += '<p class="sumber">';
            sOut += data.sumber[i].sumber_short;
            if (data.sumber[i].pivot.year != '' && data.sumber[i].pivot.year != 'null'){
                sOut += ' '+data.sumber[i].pivot.year;
            }
            if (data.sumber[i].pivot.jilid){
                sOut += ' ('+data.sumber[i].pivot.jilid+')';
            }
            if (data.sumber[i].pivot.hal != '' && data.sumber[i].pivot.hal != 'null'){
                sOut += ' : '+data.sumber[i].pivot.hal+' hlm';
            }
            sOut += '</p>';
        }
        sOut += '<p class="status">';
        var status = [];
        for (var i = 0; i < data.statusKatalog.length; i++){
            status.push(data.statusKatalog[i].status+" : "+data.statusKatalog[i].pivot.per_no_object);
        }
        sOut += status.join("<br/>");
        sOut += '</p>';
        sOut += '<p class="subyek">';
        sOut += data.subyek.join("<br/>");
        sOut += '</p>';
        sOut += '<div class="singkatan">';
        sOut += data.bentuk.short;
        sOut += '</div>';
        sOut += '<div class="lokasi">';
        sOut += data.lokasi;
        sOut += '</div>';
        sOut += '</div>';
        return sOut;
    }
    
    function fnAbstrakDetails(oTable, nTr, data) {
        var aData = oTable.fnGetData(nTr);
        var sOut = '<div class="well abstrak no-margin">';
        sOut += '<p>';
        sOut += data.subyek.join('<br/>');
        sOut += '</p>';
        sOut += '<p>';
        sOut += data.tanggal.tahun;
        sOut += '</p>';
        sOut += '<p>';
        sOut += data.bentuk.short + ' ' + data.perno;
        if (data.sumber.length > 0){
            sOut += ', ';
        }
        for (var i = 0; i < data.sumber.length; i++){
            sOut += data.sumber[i].sumber_short;
            if (data.sumber[i].pivot.year != '' && data.sumber[i].pivot.year != 'null'){
                sOut += ' '+data.sumber[i].pivot.year;
            }
            if (data.sumber[i].pivot.jilid){
                sOut += ' ('+data.sumber[i].pivot.jilid+')';
            }
            if (data.sumber[i].pivot.hal != '' && data.sumber[i].pivot.hal != 'null'){
                sOut += ' : '+data.sumber[i].pivot.hal+' hlm. ';
            }
        }
        sOut += '</p>';
        sOut += '<p>';
        sOut += data.bentuk.long.toUpperCase()+' TENTANG '+data.tentang.toUpperCase();
        sOut += '</p>';
        sOut += '<br/>';
        sOut += '<div class="abstrakLabel">';
        sOut += 'ABSTRAK :';
        sOut += '</div>';
        sOut += '<div class="abstrakIsi">';
        for (var i = 0; i < data.abstrak.length; i++){
            sOut += '<div class="abstrakStrip">';
            sOut += '-';
            sOut += '</div>';
            sOut += '<p class="abstrakIsi">';
            sOut += data.abstrak[i];
            sOut += '</p>';
        }
        sOut += '</div>';
        sOut += '<br/>';
        sOut += '<div class="abstrakLabel">';
        sOut += 'CATATAN :';
        sOut += '</div>';
        sOut += '<div class="abstrakIsi">';
        for (var i = 0; i < data.abstrakNote.length; i++){
            sOut += '<div class="abstrakStrip">';
            sOut += '-';
            sOut += '</div>';
            sOut += '<p class="abstrakIsi">';
            sOut += data.abstrakNote[i];
            sOut += '</p>';
        }
        sOut += '</div>';
        sOut += '</div>';
        return sOut;
    }
    
    function fnShowPDF(oTable, nTr, data) {
        var aData = oTable.fnGetData(nTr);
        var sOut = '<table>';
        sOut += '<tr>';
        sOut += '<div>';
        sOut += '<object data="/administrasi/peraturan/pdf/'+data.file+'" type="application/pdf" width="100%" height="600px"> ';
        sOut += '</object>';
        sOut += '</div>';
        sOut += '</tr>';
        sOut += '</table>';

        return sOut;
    }
    
    function logAct(oTable, nTr, data) {
        var sOut = '<table class="table table-bordered">';
        sOut += '<thead><tr><th></th><th>User</th><th>Tanggal</th></tr></thead>';
        sOut += '<tbody><tr><td>Input</td><td>'+((data.created.by)?data.created.by:'')+'</td><td>'+((data.created.tanggal)?data.created.tanggal:'')+'</td></tr>';
        sOut += '<tr><td>Update Terakhir</td><td>'+((data.updated.by)?data.updated.by:'')+'</td><td>'+((data.updated.tanggal)?data.updated.tanggal:'')+'</td></tr>';
        if (data.publish.state > 0){
            sOut += '<tr><td>'+(data.publish.state == 1 ? 'Publish':'Unpublish')+'</td><td>'+((data.publish.by)?data.publish.by:'')+'</td><td>'+((data.publish.tanggal)?data.publish.tanggal:'')+'</td></tr>';
        }
        sOut += '</tbody></table>';

        return sOut;
    }
});
</script>
@endsection