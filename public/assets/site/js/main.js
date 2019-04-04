
$(document).ready(
	function() {
    	//$('select').selectpicker({size: '6'}); 
    	$("select").chosen({
    		width: '100%'
    	}); 
		$('.image-popup').magnificPopup({
	          type: 'image',
	          closeOnContentClick: true,
	          mainClass: 'mfp-img-mobile',
	          
	          image: {
	            verticalFit: true,
	            titleSrc: function(item) {
	              return item.el.attr('alt');
	            }
	          }
	          
	    });
	    $('.video-popup').magnificPopup({
	          disableOn: 700,
	          type: 'iframe',
	          mainClass: 'mfp-fade',
	          removalDelay: 160,
	          preloader: false,

	          fixedContentPos: false
	        });

	    $('.news-slider').slick({
	    	dots: true,
	    	infinite: true,
			slidesToShow: 4,
			slidesToScroll: 4,
			arrows: false,
			responsive: [
			    {
			      breakpoint: 1024,
			      settings: {
			        slidesToShow: 3,
			        slidesToScroll: 3,
			        infinite: true,
			        dots: true
			      }
			    },
			    {
			      breakpoint: 767,
			      settings: {
			        slidesToShow: 2,
			        slidesToScroll: 2
			      }
			    },
			    {
			      breakpoint: 480,
			      settings: {
			        slidesToShow: 1,
			        slidesToScroll: 1
			      }
			    } 
			  ]
	    });

	}

);
