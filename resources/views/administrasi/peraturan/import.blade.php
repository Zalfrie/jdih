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
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered table-hover" id="tablePeraturan">
    					<thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor<br />Peraturan</th>
                                <th>Bentuk<br />Peraturan</th>
                                <th>Tentang</th>
                                <th></th>
                                <th></th>
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
    oTable = $('#tablePeraturan').dataTable({
        "columns": [
            {data: 'no', sortable: false, searchable: false, width: '10px'},
            {data: 'nomor_peraturan', sortable: false},
            {data: 'bentuk', sortable: false},
            {data: 'tentang', sortable: false},
            {data: 'detail', searchable: false, sortable: false},
            {data: 'action', searchable: false, sortable: false}
        ],
        "data" : {!!$hasil!!},
        "lengthMenu": [
            [10, 20, -1],
            [10, 20, "All"]
        ],
        "pageLength": 20,
        "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        "rowCallback": function( row, data, iDisplayIndex ) {
            $(row).on('click', '.dataDetail', function () {
                var nTr = row;
                if (oTable.fnIsOpen(nTr)) {
                    if ($('.row-details-open', nTr).length && !$('.row-details-open', nTr).hasClass('dataDetail')){
                        $('.row-details-open', nTr).trigger('click');
                        $(this).addClass("row-details-open").removeClass("row-details-close");
                        oTable.fnOpen(nTr, openDetails(oTable, nTr, data), 'details');
                    }else{
                        $(this).addClass("row-details-close").removeClass("row-details-open");
                        oTable.fnClose(nTr);
                    }
                } else {
                    $(this).addClass("row-details-open").removeClass("row-details-close");
                    oTable.fnOpen(nTr, openDetails(oTable, nTr, data), 'details');
                }
            });
            $(row).on('click', '.dataError', function () {
                var nTr = row;
                if (oTable.fnIsOpen(nTr)) {
                    if ($('.row-details-open', nTr).length && !$('.row-details-open', nTr).hasClass('dataError')){
                        $('.row-details-open', nTr).trigger('click');
                        $(this).addClass("row-details-open").removeClass("row-details-close");
                        oTable.fnOpen(nTr, openErrors(oTable, nTr, data), 'details');
                    }else{
                        $(this).addClass("row-details-close").removeClass("row-details-open");
                        oTable.fnClose(nTr);
                    }
                } else {
                    $(this).addClass("row-details-open").removeClass("row-details-close");
                    oTable.fnOpen(nTr, openErrors(oTable, nTr, data), 'details');
                }
            });
            
            $(row).on('click', '.submitButton', function () {
                $.ajax({
                    url: "/administrasi/peraturan/savedataimport",
                    method: "POST",
                    data: data,
                    dataType: "json",
                    success: function(hasil){
                        if (hasil.result == 'berhasil'){
                            $('.submitButton', row).parent().text('Simpan Berhasil');
                        }else{
                            $('.submitButton', row).parent().text('Simpan Gagal');
                        }
                        $('.submitButton', row).remove();
                        toastr[hasil.type](hasil.message, hasil.title);
                    }
                });
            });
        }
    });
    var tableWrapper = $('#tablePeraturan_wrapper');
    tableWrapper.find('.dataTables_length select').select2();
    
    function openDetails(oTable, nTr, data) {
        var aData = oTable.fnGetData(nTr);
        var sOut = '<div class="panel">';
        sOut += '<div class="panel-body">';
                
        sOut += '<div class="row">';
        sOut += '<label class="col-md-3"><strong>Tajuk Entri Utama</strong></label>';
        sOut += '<div class="col-md-9">';
        sOut += '<p>'+data.negara+'. '+data.instansi+'</p>';
        sOut += '</div>';
        sOut += '</div>';
                
        sOut += '<div class="row">';
        sOut += '<label class="col-md-3"><strong>Bentuk Peraturan</strong></label>';
        sOut += '<div class="col-md-9">';
        sOut += '<p>'+data.bentuk+'</p>';
        sOut += '</div>';
        sOut += '</div>';
                
        sOut += '<div class="row">';
        sOut += '<label class="col-md-3"><strong>Nomor Peraturan</strong></label>';
        sOut += '<div class="col-md-9">';
        sOut += '<p>'+data.nomor_peraturan+'</p>';
        sOut += '</div>';
        sOut += '</div>';
                
        sOut += '<div class="row">';
        sOut += '<label class="col-md-3"><strong>Penetapan</strong></label>';
        sOut += '<div class="col-md-9">';
        sOut += '<p>Tanggal '+data.tanggal_penetapan+' di '+data.tempat_penetapan+'</p>';
        sOut += '</div>';
        sOut += '</div>';
                
        sOut += '<div class="row">';
        sOut += '<label class="col-md-3"><strong>Tentang</strong></label>';
        sOut += '<div class="col-md-9">';
        sOut += '<p>'+data.tentang+'</p>';
        sOut += '</div>';
        sOut += '</div>';
                
        sOut += '<div class="row">';
        sOut += '<label class="col-md-3"><strong>Sumber Teks</strong></label>';
        sOut += '<div class="col-md-9">';
        sOut += '<ul>';
        for (var i = 0; i < data.sumber.length; i++){
            sOut += '<li>';
            sOut += data.sumber[i].jnsSumber;
            if (data.sumber[i].thnSumber != '' && data.sumber[i].thnSumber != 'null'){
                sOut += ' '+data.sumber[i].thnSumber;
            }
            if (data.sumber[i].jilid != '' && data.sumber[i].jilid != 'null'){
                sOut += ' ('+data.sumber[i].jilid+')';
            }
            if (data.sumber[i].hal != '' && data.sumber[i].hal != 'null'){
                sOut += ' : '+data.sumber[i].hal+' hlm';
            }
            sOut += '</li>';
        }
        sOut += '</ul>';
        sOut += '</div>';
        sOut += '</div>';
                
        sOut += '<div class="row">';
        sOut += '<label class="col-md-3"><strong>Status Peraturan</strong></label>';
        sOut += '<div class="col-md-9">';
        sOut += '<ul>';
        for (var i = 0; i < data.status.length; i++){
            sOut += '<li>';
            sOut += data.status[i].status+' '+data.status[i].objek_peraturan;
            sOut += '</li>';
        }
        sOut += '</ul>';
        sOut += '</div>';
        sOut += '</div>';
                
        sOut += '<div class="row">';
        sOut += '<label class="col-md-3"><strong>Subyek Peraturan</strong></label>';
        sOut += '<div class="col-md-9">';
        sOut += '<ul>';
        for (var i = 0; i < data.subyek.length; i++){
            sOut += '<li>';
            sOut += data.subyek[i];
            sOut += '</li>';
        }
        sOut += '</ul>';
        sOut += '</div>';
        sOut += '</div>';
                
        sOut += '<div class="row">';
        sOut += '<label class="col-md-3"><strong>Lokasi Penyimpanan</strong></label>';
        sOut += '<div class="col-md-9">';
        sOut += '<p>'+data.penyimpanan+'</p>';
        sOut += '</div>';
        sOut += '</div>';
                
        sOut += '<div class="row">';
        sOut += '<label class="col-md-3"><strong>Abstrak 1</strong></label>';
        sOut += '<div class="col-md-9">';
        sOut += '<p>'+data.abstrak[0].show+'</p>';
        sOut += '</div>';
        sOut += '</div>';
                
        sOut += '<div class="row">';
        sOut += '<label class="col-md-3"><strong>Abstrak 2</strong></label>';
        sOut += '<div class="col-md-9">';
        sOut += '<p>'+data.abstrak[1].show+'</p>';
        sOut += '</div>';
        sOut += '</div>';
                
        sOut += '<div class="row">';
        sOut += '<label class="col-md-3"><strong>Abstrak 3</strong></label>';
        sOut += '<div class="col-md-9">';
        sOut += '<p>'+data.abstrak[2].show+'</p>';
        sOut += '</div>';
        sOut += '</div>';
                
        sOut += '<div class="row">';
        sOut += '<label class="col-md-3"><strong>Catatan Abstrak</strong></label>';
        sOut += '<div class="col-md-9">';
        sOut += '<ul>';
        for (var i = 0; i < data.abstrakNote.length; i++){
            sOut += '<li>';
            sOut += data.abstrakNote[i].show;
            sOut += '</li>';
        }
        sOut += '</ul>';
        sOut += '</div>';
        sOut += '</div>';
                
        sOut += '</div>';
        sOut += '</div>';
                                                    
        return sOut;
    }
    
    function openErrors(oTable, nTr, data) {
        var aData = oTable.fnGetData(nTr);
        var sOut = '<div class="panel">';
        sOut += '<div class="panel-body">';
                
        sOut += '<h3>List Error</h3>';
        sOut += '<div class="row">';
        sOut += '<div class="col-md-12">';
        sOut += '<ol>';
        for (var i = 0; i < data.error.length; i++){
            sOut += '<li>';
            sOut += data.error[i];
            sOut += '</li>';
        }
        sOut += '</ol>';
        sOut += '</div>';
        sOut += '</div>';
                
        sOut += '</div>';
        sOut += '</div>';
                                                    
        return sOut;
    }
});
</script>
@endsection