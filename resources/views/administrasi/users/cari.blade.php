@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-users"></i> Cek Username
					</div>
				</div>
				<div class="portlet-body">
					<form action="/administrasi/user/cari" class="form-horizontal" method="POST">
						{{ csrf_field() }}
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Username</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="username" value="{{ old('username') }}" required/>
                                </div>
                                <div class="col-md-1">
    								<button type="submit" class="btn green btn-sm">Cek Username</button>
                                </div>
							</div>
						</div>
					</form>
					<form action="/administrasi/user/tambah" class="form-horizontal" method="POST" id="newForm">
						{{ csrf_field() }}
                        <input type="hidden" name="search" value="{{ old('search') }}" />
						<div class="form-body">
							<div class="form-group">
                                <div class="col-md-offset-3 col-md-9" id="newButtonDiv">
            						<a href="/administrasi/users" class="btn red">
            							<i class="fa fa-btn fa-long-arrow-left"></i>Batal
            						</a>
                                </div>
							</div>
						</div>
					</form>
                    <hr />
					<!--<table class="table table-striped table-hover" id="tableUsers">
    					<thead>
        					<tr>
    							<th>Username</th>
    							<th>Email</th>
    							<th>Nama</th>
    							<th>NIP</th>
    							<th>&nbsp;</th>
        					</tr>
    					</thead>
    					<tbody>
                        <?php
/*                        $found = false;
                        if (!empty($JDIHUser) && $JDIHUser['count'] > 0){
                            unset($JDIHUser['count']);
                            foreach ($JDIHUser as $key => $user){
                                if (old('search') == $user['cn'][0]) $found = true;
                        */?>
							<tr>
								<td>{{ !empty($user['cn'][0])?$user['cn'][0]:'' }}</td>
								<td>{{ !empty($user['mail'][0])?$user['mail'][0]:'' }}</td>
								<td>{{ !empty($user['sn'][0])?$user['sn'][0]:'' }}</td>
								<td>{{ !empty($user['employeenumber'][0])?$user['employeenumber'][0]:'' }}</td>
								<td><strong>Sudak Aktif</strong></td>
							</tr>
                        <?php
/*							}
                        }
                        if (!empty($nonJDIHUser) && $nonJDIHUser['count'] > 0){
                            unset($nonJDIHUser['count']);
                            foreach ($nonJDIHUser as $key => $user){
                                if (old('search') == $user['cn'][0]) $found = true;
                        */?>
							<tr>
								<td>{{ !empty($user['cn'][0])?$user['cn'][0]:'' }}</td>
								<td>{{ !empty($user['mail'][0])?$user['mail'][0]:'' }}</td>
								<td>{{ !empty($user['sn'][0])?$user['sn'][0]:'' }}</td>
								<td>{{ !empty($user['employeenumber'][0])?$user['employeenumber'][0]:'' }}</td>
								<td>
									<form action="/administrasi/user/tambah" method="POST">
										{{ csrf_field() }}
                                        <input type="hidden" name="search" value="{{ !empty(old('search'))?old('search'):'' }}" />
                                        <input type="hidden" name="type" value="activate" />
                                        <input type="hidden" name="username" value="{{ !empty($user['cn'][0])?$user['cn'][0]:'' }}" />
                                        <input type="hidden" name="email" value="{{ !empty($user['mail'][0])?$user['mail'][0]:'' }}" />
                                        <input type="hidden" name="nama" value="{{ !empty($user['sn'][0])?$user['sn'][0]:'' }}" />
                                        <input type="hidden" name="nip" value="{{ !empty($user['employeenumber'][0])?$user['employeenumber'][0]:'' }}" />
										<button type="submit" class="btn btn-danger btn-sm">
											Aktifkan
										</button>
									</form>
								</td>
							</tr>
                        <?php
/*							}
                        }
                        */?>
    					</tbody>
					</table>-->
				</div>
			</div>
        </div>
    </div>
    <!--@if(!$found && !empty(old('search')))
    <input type="hidden" name="username" value="{{ old('search') }}" id="newUsername" />
    <input type="submit" class="btn blue" value='Tambah Baru User "{{ trim(old('search')) }}"' id="newSubmit" />
    @endif-->
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
    $('#newUsername').prependTo("#newForm");
    $('#newSubmit').appendTo("#newButtonDiv");
    
    var oTable = $("#tableUsers").dataTable({
        "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        "deferRender": true,
        "order": [
            [0, 'asc']
        ],
        "lengthMenu": [
            [5, 10, 15, 20, -1],
            [5, 10, 15, 20, "All"]
        ],
        "pageLength": 20
    });


    var tableWrapper = $('#tableUsers_wrapper');
    tableWrapper.find('.dataTables_length select').select2();
    
    $('.nextUser').click(function(){
        var that = this;
        bootbox.confirm("Anda yakin akan menghapus data ini?", function(result) {
           if (result){
                $(that).closest('form').submit();
           }
        });
    });
});
</script>
@endsection