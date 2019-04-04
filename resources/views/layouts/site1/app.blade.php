<!doctype html>
{{-- <html class="dark"> --}}
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
<!-- Favicon -->
<link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="/assets/site1/img/apple-touch-icon.png">
@yield('meta')
<title><?=(!empty($title)? ($title.' | JDIH Kementerian BUMN'):'Jaringan Dokumentasi Dan Informasi Hukum Kementerian BUMN')?></title>
<!-- Bootstrap -->
<!-- Web Fonts  -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

<!-- Vendor CSS -->
<link rel="stylesheet" href="/assets/site1/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/site1/vendor/font-awesome/css/fontawesome-all.min.css">
<link rel="stylesheet" href="/assets/site1/vendor/animate/animate.min.css">
<link rel="stylesheet" href="/assets/site1/vendor/simple-line-icons/css/simple-line-icons.min.css">
<link rel="stylesheet" href="/assets/site1/vendor/owl.carousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="/assets/site1/vendor/owl.carousel/assets/owl.theme.default.min.css">
<link rel="stylesheet" href="/assets/site1/vendor/magnific-popup/magnific-popup.min.css">
<!--end Vendor CSS -->

<!-- Theme CSS -->
<link rel="stylesheet" href="/assets/site1/css/theme.css">
<link rel="stylesheet" href="/assets/site1/css/theme-elements.css">
<link rel="stylesheet" href="/assets/site1/css/theme-blog.css">
<link rel="stylesheet" href="/assets/site1/css/theme-shop.css">
<!-- end Theme CSS -->

<!-- Current Page CSS -->
<link rel="stylesheet" href="/assets/site1/vendor/rs-plugin/css/settings.css">
<link rel="stylesheet" href="/assets/site1/vendor/rs-plugin/css/layers.css">
<link rel="stylesheet" href="/assets/site1/vendor/rs-plugin/css/navigation.css">
<link rel="stylesheet" href="/assets/site1/vendor/circle-flip-slideshow/css/component.css">
<!-- end Current Page CSS -->

<!-- Demo CSS -->


<!-- Skin CSS -->
<link rel="stylesheet" href="/assets/site1/css/skins/default.css"> 

<!-- Theme Custom CSS -->
<link rel="stylesheet" href="/assets/site1/css/custom.css">

<!-- Head Libs -->
<script src="/assets/site1/vendor/modernizr/modernizr.min.js"></script>
 
@yield('csspluginscript')

</head>
<body>
@include('layouts.site1.header')


@yield('content')
@include('layouts.site1.footer')

<!-- Vendor -->
<script src="/assets/site1/vendor/jquery/jquery.min.js"></script>
<script src="/assets/site1/vendor/jquery.appear/jquery.appear.min.js"></script>
<script src="/assets/site1/vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="/assets/site1/vendor/jquery-cookie/jquery-cookie.min.js"></script>
<script src="/assets/site1/vendor/popper/umd/popper.min.js"></script>
<script src="/assets/site1/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/site1/vendor/common/common.min.js"></script>
<script src="/assets/site1/vendor/jquery.validation/jquery.validation.min.js"></script>
<script src="/assets/site1/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
<script src="/assets/site1/vendor/jquery.gmap/jquery.gmap.min.js"></script>
<script src="/assets/site1/vendor/jquery.lazyload/jquery.lazyload.min.js"></script>
<script src="/assets/site1/vendor/isotope/jquery.isotope.min.js"></script>
<script src="/assets/site1/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="/assets/site1/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="/assets/site1/vendor/vide/vide.min.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="/assets/site1/js/theme.js"></script>

<!-- Current Page Vendor and Views -->
<script src="/assets/site1/vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script src="/assets/site1/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script src="/assets/site1/vendor/circle-flip-slideshow/js/jquery.flipshow.min.js"></script>
<script src="/assets/site1/js/views/view.home.js"></script>

<!-- Theme Custom -->
<script src="/assets/site1/js/custom.js"></script>

<!-- Theme Initialization Files -->
<script src="/assets/site1/js/theme.init.js"></script>



<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information.
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-12345678-1', 'auto');
    ga('send', 'pageview');
</script>
 -->
@yield('jspluginscript')

@yield('jsscript')
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>

	/*
	Map Settings

		Find the Latitude and Longitude of your address:
			- http://universimmedia.pagesperso-orange.fr/geo/loc.htm
			- http://www.findlatitudeandlongitude.com/find-address-from-latitude-and-longitude/

	*/

	// Map Markers
	var mapMarkers = [{
		address: "Jl. Medan Merdeka Selatan No. 13, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10110",
		html: "<strong>Gedung Kementerian BUMN</strong><br>Jakarta, 10110",
		icon: {
			image: "/assets/site1/img/pin.png",
			iconsize: [26, 46],
			iconanchor: [12, 46]
		},
		popup: true
	}];

	// Map Initial Location
	var initLatitude = -6.1816137;
	var initLongitude = 106.8255964;

	// Map Extended Settings
	var mapSettings = {
		controls: {
			draggable: (($.browser.mobile) ? false : true),
			panControl: true,
			zoomControl: true,
			mapTypeControl: true,
			scaleControl: true,
			streetViewControl: true,
			overviewMapControl: true
		},
		scrollwheel: false,
		markers: mapMarkers,
		latitude: initLatitude,
		longitude: initLongitude,
		zoom: 16
	};

	var map = $('#googlemaps').gMap(mapSettings);

	// Map text-center At
	var mapCenterAt = function(options, e) {
		e.preventDefault();
		$('#googlemaps').gMap("centerAt", options);
	}

</script>
<script>
	// Search Properties
	var $headerWrapper = $('#headerSearchProperties'),
		$window = $(window);

	$headerWrapper.on('click', function() {
		if ($window.width() > 992) {
			$headerWrapper.addClass('open');
		}
	});

	$(document).mouseup(function(e) {
		if (!$headerWrapper.is(e.target) && $headerWrapper.has(e.target).length === 0) {
			$headerWrapper.removeClass('open');
		}
	});

	$('#propertiesFormHeader').validate({
		onkeyup: false,
		onclick: false,
		onfocusout: false,
		errorPlacement: function(error, element) {
			if (element.attr('type') == 'radio' || element.attr('type') == 'checkbox') {
				error.appendTo(element.parent().parent());
			} else {
				error.insertAfter(element);
			}
		}
	});
</script>

</body>
</html>
