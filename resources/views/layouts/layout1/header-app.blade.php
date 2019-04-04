<!-- BEGIN HEADER -->
<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="top-menu">
			<ul class="nav navbar-nav pull-right">
				<!-- BEGIN NOTIFICATION DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                @if(Auth::user()->hasRole(['sys_admin', 'Admin_Konten']))
				<li class="dropdown dropdown-extended dropdown-notification">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="icon-bell"></i>
                    @if (count($declinedNotif) > 0)
					<span class="badge badge-default">
					{{$declinedNotif->count()}} </span>
                    @endif
					</a>
					<ul class="dropdown-menu">
						<li class="external">
							<h3><span class="bold">Verifikasi Ditolak</span></h3>
						</li>
						<li>
							<ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                            @if (count($declinedNotif) > 0)
                            @foreach($declinedNotif as $notif)
								<li>
									<a href="/administrasi/peraturan/{{$notif->per_no}}/edit">
									<span class="time">cek</span>
									<span class="details bold">
									{{$notif->per_no}}</span>
                                    : {{$notif->unpublish_note}} 
									</a>
								</li>
                            @endforeach
                            @endif
							</ul>
						</li>
					</ul>
				</li>
                @endif
                @if(Auth::user()->hasRole(['sys_admin', 'Verifikator']))
				<li class="dropdown dropdown-extended dropdown-notification">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="icon-bell"></i>
                    @if (count($approvalNotif) > 0)
					<span class="badge badge-default">
					{{$approvalNotif->count()}} </span>
                    @endif
					</a>
					<ul class="dropdown-menu">
						<li class="external">
							<h3><span class="bold">Notifikasi Verifikasi</span></h3>
						</li>
						<li>
							<ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                            @if (count($approvalNotif) > 0)
                            @foreach($approvalNotif as $notif)
								<li>
									<a href="/administrasi/peraturan/{{$notif->per_no}}/verifikasi">
									<span class="time">verifikasi</span>
									<span class="details bold">
									{{$notif->per_no}} </span>
									</a>
								</li>
                            @endforeach
                            @endif
							</ul>
						</li>
					</ul>
				</li>
                @endif
				<!-- END NOTIFICATION DROPDOWN -->
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				<li class="dropdown dropdown-user">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<img alt="" class="img-circle" src="<?=(Auth::user()->employee)?Auth::user()->employee->image:'http://www.placehold.it/150x150/EFEFEF/AAAAAA&amp;text=no+image'?>"/>
					<span class="username username-hide-on-mobile">
					<?=(Auth::user()->employee)?Auth::user()->employee->name:Auth::user()->username?> </span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default">
						<li>
							<a href="/auth/logout">
							<i class="icon-key"></i> Log Out </a>
						</li>
					</ul>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
			</ul>
		</div>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->