<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
@yield('meta')
<title><?=(!empty($title)? ($title.' | JDIH Kementerian BUMN'):'Jaringan Dokumentasi Dan Informasi Hukum Kementerian BUMN')?></title>
<!-- Bootstrap -->
    <link href="/assets/site/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/site/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="/assets/site/css/font-awesome.min.css" type="text/css"> 
@yield('csspluginscript')
<link href="/assets/site/css/style.css" rel="stylesheet" type="text/css">
<link href="/assets/site/css/chosen.css" rel="stylesheet" type="text/css">
<link href="/assets/global/css/katalog.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />

<style type="text/css">

.cse .gsc-control-cse, .gsc-control-cse {
    padding: 1em;
    width: auto;
}
.cse .gsc-control-wrapper-cse, .gsc-control-wrapper-cse {
    width: 100%;
}
.cse .gsc-branding, .gsc-branding {
    display: none;
}
.cse .gsc-control-cse, .gsc-control-cse {
    background-color: #ffffff;
    border: 1px solid #ffffff;
}
.cse .gsc-control-cse::after, .gsc-control-cse::after {
    clear: both;
    content: ".";
    display: block;
    height: 0;
    visibility: hidden;
}
.cse .gsc-resultsHeader, .gsc-resultsHeader {
}
table.gsc-search-box td.gsc-input {
    padding-right: 12px;
}
.gsc-control-searchbox-only input.gsc-input, .gsc-control-searchbox-only-id input.gsc-input {
    border-color: #ffffff !important;
    font-size: 13px;
    padding: 1px 6px;
}
input.gsc-input {
    border-color: #ffffff;
    font-size: 13px;
    padding: 1px 6px;
}
.cse input.gsc-search-button, input.gsc-search-button {
    background-color: #cecece;
    border: 1px solid #666666;
    border-radius: 2px;
    color: #000000;
    font-family: inherit;
    font-size: 11px;
    font-weight: bold;
    height: 20px;
    min-width: 54px;
    padding: 0 8px;
}
.cse .gsc-tabHeader.gsc-tabhInactive, .gsc-tabHeader.gsc-tabhInactive {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #e9e9e9;
    border-color: #e9e9e9 #e9e9e9 -moz-use-text-color;
    border-image: none;
    border-style: solid solid none;
    border-width: 1px 1px medium;
    color: #666666;
}
.cse .gsc-tabHeader.gsc-tabhActive, .gsc-tabHeader.gsc-tabhActive {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #ffffff;
    border-color: #ff9900 #e9e9e9 -moz-use-text-color;
    border-image: none;
    border-style: solid solid none;
    border-width: 2px 1px medium;
}
.cse .gsc-tabsArea, .gsc-tabsArea {
    border-bottom: 1px solid #e9e9e9;
    margin-top: 1em;
}
.cse .gsc-webResult.gsc-result, .gsc-webResult.gsc-result, .gsc-imageResult-column, .gsc-imageResult-classic {
    border: 1px solid #ffffff;
    margin-bottom: 1em;
    padding: 0.25em;
}
.cse .gsc-webResult.gsc-result:hover, .gsc-webResult.gsc-result:hover, .gsc-webResult.gsc-result.gsc-promotion:hover, .gsc-results .gsc-imageResult-classic:hover, .gsc-results .gsc-imageResult-column:hover {
    border: 1px solid #ffffff;
}
.cse .gsc-webResult.gsc-result.gsc-promotion, .gsc-webResult.gsc-result.gsc-promotion {
    background-color: #ffffff;
    border-color: #336699;
}
.cse .gs-promotion a.gs-title:link, .gs-promotion a.gs-title:link, .cse .gs-promotion a.gs-title:link *, .gs-promotion a.gs-title:link *, .cse .gs-promotion .gs-snippet a:link, .gs-promotion .gs-snippet a:link {
    color: #0000cc;
}
.cse .gs-promotion a.gs-title:visited, .gs-promotion a.gs-title:visited, .cse .gs-promotion a.gs-title:visited *, .gs-promotion a.gs-title:visited *, .cse .gs-promotion .gs-snippet a:visited, .gs-promotion .gs-snippet a:visited {
    color: #0000cc;
}
.cse .gs-promotion a.gs-title:hover, .gs-promotion a.gs-title:hover, .cse .gs-promotion a.gs-title:hover *, .gs-promotion a.gs-title:hover *, .cse .gs-promotion .gs-snippet a:hover, .gs-promotion .gs-snippet a:hover {
    color: #0000cc;
}
.cse .gs-promotion a.gs-title:active, .gs-promotion a.gs-title:active, .cse .gs-promotion a.gs-title:active *, .gs-promotion a.gs-title:active *, .cse .gs-promotion .gs-snippet a:active, .gs-promotion .gs-snippet a:active {
    color: #0000cc;
}
.cse .gs-promotion .gs-snippet, .gs-promotion .gs-snippet, .cse .gs-promotion .gs-title .gs-promotion-title-right, .gs-promotion .gs-title .gs-promotion-title-right, .cse .gs-promotion .gs-title .gs-promotion-title-right *, .gs-promotion .gs-title .gs-promotion-title-right * {
    color: #000000;
}
.cse .gs-promotion .gs-visibleUrl, .gs-promotion .gs-visibleUrl {
    color: #008000;
}
.gsc-completion-selected {
    background: #eeeeee none repeat scroll 0 0;
}
.gsc-completion-container {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background: #ffffff none repeat scroll 0 0;
    border-color: #d9d9d9 #cccccc #cccccc;
    border-image: none;
    border-style: solid;
    border-width: 1px;
    font-family: Arial,sans-serif;
    font-size: 13px;
    margin-left: 0;
    margin-right: 0;
}
.gsc-completion-title {
    color: #0000cc;
}
.gsc-completion-snippet {
    color: #000000;
}
.gs-webResult div.gs-visibleUrl-short, .gs-promotion div.gs-visibleUrl-short {
    display: none;
}
.gs-webResult div.gs-visibleUrl-long, .gs-promotion div.gs-visibleUrl-long {
    display: block;
}
.gsc-context-box {
    border-collapse: collapse;
    font-size: 83%;
    margin-top: 3px;
}
.gsc-context-box .gsc-col {
    padding: 1px 0;
    vertical-align: middle;
    white-space: nowrap;
}
.gsc-context-box .gsc-facet-label {
    color: #1155cc;
    cursor: pointer;
    padding-left: 2px;
    text-decoration: underline;
    width: 65px;
}
.gsc-context-box .gsc-chart {
    border-left: 1px solid #6a9cf3;
    border-right: 1px solid #6a9cf3;
    padding: 3px;
    width: 32em;
}
.gsc-context-box .gsc-top {
    border-top: 1px solid #6a9cf3;
}
.gsc-context-box .gsc-bottom {
    border-bottom: 1px solid #6a9cf3;
}
.gsc-context-box .gsc-chart div {
    background: #6a9cf3 none repeat scroll 0 0;
    height: 9px;
}
.gsc-context-box .gsc-facet-result {
    color: #1155cc;
    padding-right: 5px;
    text-align: right;
    width: 30px;
}
.gsc-usr-group-thumbnail {
    display: inline-block;
    max-height: 72px;
    max-width: 72px;
}
.gsc-usr-group-thumbnail img {
    max-height: 72px;
    overflow: hidden;
}
.gs-webResult .gs-title .gs-title.gsc-usr-group-heading {
    color: #1155cc;
    cursor: pointer;
}
.gsc-usr-group {
    display: block;
    line-height: 1.24;
    margin-bottom: -7px;
    margin-left: 20px;
    margin-top: -7px;
    min-height: 100px;
}
.gsc-usr-group-content {
    padding-bottom: 3px;
    padding-top: 1px;
}
.gsc-usr-group-content-thumbnail {
    display: inline-block;
    vertical-align: top;
}
.gsc-usr-group-head-result {
    display: inline-block;
    padding-left: 6px;
}
.gsc-usr-group-snippet {
    height: 3.6em;
    overflow: hidden;
    width: 100%;
}
.gsc-usr-group-content-results {
    font-size: 12px;
    padding-left: 1px;
    padding-top: 7px;
    width: 80%;
}
.gsc-usr-group-head-results {
    display: inline-block;
    font-size: 13px;
    padding-left: 6px;
    width: 80%;
}
.gs-webResult .gs-title .gs-title.gsc-usr-group-all-results {
    font-size: 11px;
    line-height: 10px;
}
.gs-webResult .gs-title .gs-title.gsc-usr-group-all-results b {
    font-size: 14px;
    font-weight: 600;
}
.gs-webResult .gs-title .gs-title.gsc-usr-group-heading b {
    color: #1155cc;
}
.gsc-clear-button {
    visibility: hidden;
}

</style>
</head>
<body>
@include('layouts.site.header')
@include('layouts.site.navbar')

@yield('content')
@include('layouts.site.footer')

<script src="/assets/site/js/jquery.min.js"></script> 
<script src="/assets/site/js/bootstrap.min.js"></script>
<script src="/assets/site/js/bootstrap-select.min.js"></script>
<script src="/assets/site/js/jquery.magnific-popup.min.js"></script>
<script src="/assets/site/js/slick.min.js"></script>
@yield('jspluginscript')
<script src="/assets/site/js/chosen.jquery.min.js"></script>
<script src="/assets/site/js/main.js"></script>
@yield('jsscript')

<script>
  (function() {
    var cx = '005693940055625683615:s-jaglzo1x0';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50191621-5', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
