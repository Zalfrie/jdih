<header id="header" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 55, 'stickySetTop': '-55px', 'stickyChangeLogo': true}">
	<div class="header-body">
		<div class="header-container container">
			<div class="header-row">
				<div class="header-column">
					<div class="header-row">
						<div class="header-logo">
							<a href="/">
								<img alt="jdih" width="180" height="54" data-sticky-width="130" data-sticky-height="35" data-sticky-top="33" src="/assets/site/images/logo_jdih.png">

							</a>
						</div>
						<div class="header-logo">
							<a href="/">
								<img alt="kbumn" width="180" height="54" data-sticky-width="130" data-sticky-height="35" data-sticky-top="33" src="/assets/site/images/logo_bumn.png">
								
							</a>
						</div>
					</div>
				</div>
				<div class="header-column justify-content-end">
					<div class="header-row pt-3">
						<nav class="header-nav-top">
							<ul class="nav nav-pills">
								<li class="nav-item d-none d-sm-block">
									<a class="nav-link" href="/visi-misi"><i class="fas fa-angle-right"></i> Visi Misi</a>
								</li>
								<li class="nav-item d-none d-sm-block">
									<a class="nav-link" href="/kontak-kami"><i class="fas fa-angle-right"></i> Kontak Kami</a>
								</li>
								<li class="nav-item d-none d-sm-block">
									<a class="nav-link" href="/admin"><i class="fas fa-angle-right"></i> Login</a>
								</li>
							</ul>
						</nav>
						
					</div>
					<div class="header-row">
						<div class="header-nav">
							<div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1">
								<nav class="collapse">
									{!! $menu1 !!}
								</nav>
							</div>
							
							<button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main nav">
								<i class="fas fa-bars"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>

<div role="main" class="main">