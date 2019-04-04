@extends('layouts.site.app')

@section('meta')
<meta name="description" content="Website Resmi Jaringan Dokumentasi dan Informasi Hukum Kementerian BUMN"/>
@endsection

@section('content')
@include('site.home.main-banner')

  <div class="contentWrapper"> 
    <div class="mainContent">
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <div class="headTitle">
              <p>
                Peraturan Terbaru
                <span><img src="/assets/site/images/icon_new.png" alt="New Icon"></span>
              </p>
            </div>
            <div class="listWrapper">
              <ul class="clearfix">
              @if (count($newest) > 0)
              @foreach($newest as $val)
                <li>
                  <a class="clearfix" href="/lihat/{!! $val->per_no !!}">
                    <h4><span style="color: #F00;">{!! $val->per_no !!}</span> Tentang {!! implode(' ', array_slice(explode(' ', $val->tentang), 0, 15)) !!} {{count(explode(' ', $val->tentang)) > 15?' ...':''}}</h4>
                    </a>
                    <p>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $val->tanggal)->formatLocalized('%d %B %Y') }}</p>
                    <a class="clearfix" href="/unduh/{!! $val->per_no !!}.pdf">
                    <span class="download-button">
                      <img src="/assets/site/images/icon_download.png" alt="Download PDF">
                    </span>
                  </a>
                </li>
              @endforeach
              @endif
              </ul>
            </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-6 ">
              <center>
            <a href="/prepare">
                <img height="100px" src="/assets/site/images/dummy-prepare.png">
            </a>
              </center>
              <p><br></p>
            <div class="headTitle">
              <p>
                Peraturan Terpopuler
              </p>
            </div>
            <div class="listWrapper2">
              <ul class="clearfix">
              @if (count($populer) > 0)
              @foreach($populer as $key => $val)
                <li>
                  <a class="clearfix" href="/lihat/{!! $val->per_no !!}">
                    <span class="listNumber">{{ $key+1 }}</span>
                    <p class="listHeading"><span style="color: #F00;">{!! $val->per_no !!}</span> Tentang {!! implode(' ', array_slice(explode(' ', $val->tentang), 0, 15)) !!} {{count(explode(' ', $val->tentang)) > 15?' ...':''}}</p>
                    <p class="microText">dibaca {{ $val->monthly_counter }} kali</p>
                  </a>
                </li>
              @endforeach
              @endif
              </ul>
            </div>

            <div class="headTitle">
              <p>
                Statistik Pengunjung
              </p>
            </div>
            <div class="listWrapper2">
              <p>Statistik Pengunjung</p>
              
              <div class="row ">
               <div class="col-md-12 col-sm-12">
                  <div class="portlet box blue-chambray">
                    <div class="portlet-title">
                      <div class="caption">
                        <i class="icon-bar-chart"></i>Statistik Pengunjung
                      </div>
                    </div>
                    <div class="portlet-body">
                      <div class="row">
                          <div class="col-md-4">
                              <select  id="dimensiSelect">
                                <option value="minggu">Seminggu Terakhir</option>
                                <option value="bulan">Bulanan</option>
                                <option value="tahun">Tahun Ini</option>
                              </select>
                          </div>
                          <div class="col-md-6">
                            <button class="btn blue" id="dimensi">Tampilkan</button>
                          </div>
                      </div>
                      <div class="row" style="display: none" id="bulanPengunjungSelectRow">
                          <div class="col-md-2">
                              <select class="form-control" id="bulanPengunjung">
                                  <option value="01">Januari</option>
                                  <option value="02">Februari</option>
                                  <option value="03">Maret</option>
                                  <option value="04">April</option>
                                  <option value="05">Mei</option>
                                  <option value="06">Juni</option>
                                  <option value="07">Juli</option>
                                  <option value="08">Agustus</option>
                                  <option value="09">September</option>
                                  <option value="10">Oktober</option>
                                  <option value="11">November</option>
                                  <option value="12">Desember</option>
                              </select>
                          </div>
                          <div class="col-md-2">
                              <select class="form-control" id="tahunPengunjung">
                                  <?php for( $i = 2016; $i < $thisYear; $i++)
                                      { echo "<option value = ".$i." > ".$i."</option>";} ?>
                                  <option value={{$thisYear}} selected>{{$thisYear}}</option>
                              </select>
                          </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="row">
                        <div class="col-md-12">
                              <div id="visitorLoading">
                                <img src="/assets/admin/layout/img/loading.gif" alt="loading"/>
                              </div>
                              <div id="visitorContent" class="display-none">
                                <div id="visitorChart" class="chart">
                                </div>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="headTitle">
              <p>
                Tautan / Sitemap
              </p>
            </div>
            <div class="listWrapper2">
              <ul class="sitemap clearfix">
              @if (count($tautan) > 0)
              @foreach($tautan as $key => $val)
                <li>
                  <a class="clearfix" href="{{$val->link}}">
                    {{$val->tautan}}
                  </a>
                </li>
              @endforeach
              @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/.mainContent--> 
  </div>
  <!--/.contentWrapper-->
<div class="newsSection">
  <div class="container">
    <div class="row">
      <div class="col-md-16">
        <h3>berita terbaru</h3>
        <div class="news-slider">
              @if (count($berita) > 0)
              @foreach($berita as $val)
          <div class="item">
            <div class="news-list">
              <small>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val->published_at)->formatLocalized('%d %B %Y %H:%I:%S') }}</small>
              <figure>
                <img src="{{$val->image}}" alt="">
              </figure>
              <a href="/berita/{!! $val->slug !!}"><h4>{!! $val->title !!}</h4></a>
<!--              <p>{!!substr($val->content, 0, strpos($val->content, '<br>'))!!}> </p>-->
              <p>{!!strip_tags(substr($val->content, 0, 100))!!} ... </p>
            </div>
          </div>
              @endforeach
              @endif
           
        </div>
      </div>
    </div>
  </div>
</div>
  <div class="contentWrapper"> 
    <div class="mainContent">
      <div class="container">
        <div class="row">
          <div class="col-md-16">
            <div class="row">
                <div class="col-md-16">
                    <div class="well no-margin" style="text-align: justify;">
                        <h3>Disclaimer</h3>
                        {!!$disclaimer->content!!}
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

<script src="https://www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
<script src="https://www.amcharts.com/lib/3/serial.js" type="text/javascript"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js" type="text/javascript"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />


<script type="text/javascript">
jQuery(document).ready(function() {
    var visitorChart;
    var peraturanChart;
    
    var formatDate = function(date) {
        var d = date,
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();
    
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
    
        return [year, month, day].join('-');
    }
    
    var startDate = '6daysAgo';
    var endDate = 'today';
    var dimension = 'ga:date';
    var categoryAxis = [{
                            "dateFormats": [{
                                "period": "DD",
                                "format": "DD"
                            }, {
                                "period": "WW",
                                "format": "MMM DD"
                            }, {
                                "period": "MM",
                                "format": "MMM"
                            }, {
                                "period": "YYYY",
                                "format": "YYYY"
                            }],
                            "parseDates": true,
                            "autoGridCount": false,
                            "axisColor": "#555555",
                            "gridAlpha": 0.15,
                            "gridColor": "#000000",
                            "gridCount": 50,
                            "startOnAxis": true
                        },{
                            "autoGridCount": false,
                            "axisColor": "#555555",
                            "gridAlpha": 0.15,
                            "gridColor": "#000000",
                            "gridCount": 50,
                            "startOnAxis": true
                        }];
    var chartCursor = [{
                            "categoryBalloonDateFormat": "MMM DD",
                            "cursorAlpha": 0.1,
                            "cursorColor": "#000000",
                            "fullWidth": true,
                            "valueBalloonsEnabled": false,
                            "zoomable": false
                        },{
                            "cursorAlpha": 0.1,
                            "cursorColor": "#000000",
                            "fullWidth": true,
                            "valueBalloonsEnabled": false,
                            "zoomable": false
                        }];
    var dataChart2 = function(startDate, endDate, dimension, subTitle){
        $.ajax({
            "dataType": 'json',
            "type": "POST",
            "url": '/dashboard/getvisitor',
            data: {'start': startDate, 'end': endDate, 'dimensi': dimension},
            beforeSend: function(){
                $('#visitorContent').hide();
                $('#visitorLoading').show();
            },
            success: function(data){
                $('#visitorContent').show();
                $('#visitorLoading').hide();
                if (visitorChart){
                    visitorChart.dataProvider = data;
                    visitorChart.titles = [
                        {
                            "text": "Statistik Pengunjung Web JDIH",
                            "size": 15
                        },
                        {
                            "text": subTitle,
                            "size": 15,
                            "bold": false
                        }
                    ];
                    if (dimension == 'ga:month'){
                        visitorChart.chartCursor = chartCursor[1];
                        visitorChart.categoryAxis = categoryAxis[1];
                    }else{
                        visitorChart.chartCursor = chartCursor[0];
                        visitorChart.categoryAxis = categoryAxis[0];
                    }
                    visitorChart.validateData();
                }else{
                    visitorChart = AmCharts.makeChart("visitorChart", {
                        "type": "serial",
                        "theme": "light",
            
                        "fontFamily": 'Open Sans',
                        "color":    '#888888',
            
                        "legend": {
                            "equalWidths": false,
                            "useGraphSettings": true,
                            "valueAlign": "left",
                            "valueWidth": 120
                        },
                        "dataProvider": data,
                        "valueAxes": [{
                            "id": "distanceAxis",
                            "axisAlpha": 0,
                            "gridAlpha": 0.15,
                            "position": "left",
                            "title": "sessions"
                        }],
                        "graphs": [{
                            "alphaField": "alpha",
                            "balloonText": "[[value]] sessions",
                            "dashLengthField": "dashLength",
                            "fillAlphas": 0,
                            "legendPeriodValueText": "total: [[value.sum]] sessions",
                            "legendValueText": "[[value]] sessions",
                            "title": "Sessions",
                            "type": "line",
                            "lineColor": "#006ac4",
                            "bullet": "round",
                            "valueField": "sessions",
                            "valueAxis": "distanceAxis"
                        }],
                        "chartCursor": chartCursor[0],
                        "dataDateFormat": "YYYY-MM-DD",
                        "categoryField": "dimension",
                        "categoryAxis": categoryAxis[0],
                        "titles": [
                            {
                                "text": "Statistik Pengunjung Web JDIH",
                                "size": 15
                            },
                            {
                                "text": subTitle,
                                "size": 15,
                                "bold": false
                            }
                        ],
                        "export": {
                            "enabled": true,
                            "menu":[{
                                "format": "JPG",
                                "label": "Save as JPG",
                                "title": "Export chart to JPG",
                            },{
                                "format": "PDF",
                                "label": "Save as PDF",
                                "title": "Export chart to PDF",
                            },]
                        },
                    });
                }
            }
        });
    }
    dataChart2(startDate, endDate, dimension, 'Mingguan');
    
    var date = new Date();
    $("#dimensi").bind('click', function(){
        var subTitle = 'Mingguan';
        if ($('#dimensiSelect').val() == 'minggu'){
            startDate = '6daysAgo';
            endDate = 'today';
            dimension = 'ga:date';
            hideBulanPengunjung();
        }else if ($('#dimensiSelect').val() == 'bulan'){
//            var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            var firstDay = new Date(parseInt($('#tahunPengunjung').val()), parseInt($('#bulanPengunjung').val())-1, 1);
            startDate = formatDate(firstDay);
            var lastDay = new Date(parseInt($('#tahunPengunjung').val()), parseInt($('#bulanPengunjung').val()), 1);
            endDate = formatDate(lastDay);
            dimension = 'ga:date';
            subTitle = $('#bulanPengunjung').children("option:selected").text() + ' ' + $('#tahunPengunjung').val();
            showBulanPengunjung();
        }else if ($('#dimensiSelect').val() == 'tahun'){
            var firstDay = new Date(date.getFullYear(), 0, 1);
            startDate = formatDate(firstDay);
            endDate = 'today';
            dimension = 'ga:month';
            subTitle = 'Tahun ' + date.getFullYear();
            hideBulanPengunjung();
        }
        dataChart2(startDate, endDate, dimension, subTitle);
    });

    var categoryAxis2 = [{
                            "dateFormats": [{
                                "period": "DD",
                                "format": "DD"
                            }, {
                                "period": "WW",
                                "format": "MMM DD"
                            }, {
                                "period": "MM",
                                "format": "MMM"
                            }, {
                                "period": "YYYY",
                                "format": "YYYY"
                            }],
                            "parseDates": true,
                            "autoGridCount": false,
                            "axisColor": "#555555",
                            "gridAlpha": 0.15,
                            "gridColor": "#000000",
                            "gridCount": 50,
                            "startOnAxis": true
                        },{
                            "autoGridCount": false,
                            "axisColor": "#555555",
                            "gridAlpha": 0.15,
                            "gridColor": "#000000",
                            "gridCount": 50,
                            "startOnAxis": true
                        }];
    var chartCursor2 = [{
                            "categoryBalloonDateFormat": "MMM DD",
                            "cursorAlpha": 0.1,
                            "cursorColor": "#000000",
                            "fullWidth": true,
                            "valueBalloonsEnabled": false,
                            "zoomable": false
                        },{
                            "cursorAlpha": 0.1,
                            "cursorColor": "#000000",
                            "fullWidth": true,
                            "valueBalloonsEnabled": false,
                            "zoomable": false
                        }];
    var dataChartPeraturan = function(){
        $.ajax({
            "dataType": 'json',
            "type": "POST",
            "url": '/dashboard/getperaturanchart',
            data: {'jns': $("#timePeraturan").val()},
            beforeSend: function(){
                $('#peraturanContent').hide();
                $('#peraturanLoading').show();
            },
            success: function(data){
                $('#peraturanContent').show();
                $('#peraturanLoading').hide();
                if (peraturanChart){
                    peraturanChart.dataProvider = data;
                    if ($("#timePeraturan").val() == 'tahun'){
                        peraturanChart.chartCursor = chartCursor2[1];
                        peraturanChart.categoryAxis = categoryAxis2[1];
                    }else{
                        peraturanChart.chartCursor = chartCursor2[0];
                        peraturanChart.categoryAxis = categoryAxis2[0];
                    }
                    peraturanChart.validateData();
                }else{
                    peraturanChart = AmCharts.makeChart("peraturanChart", {
                        "type": "serial",
                        "theme": "light",
            
                        "fontFamily": 'Open Sans',
                        "color":    '#888888',
            
                        "legend": {
                            "equalWidths": false,
                            "useGraphSettings": true,
                            "valueAlign": "left",
                            "valueWidth": 120
                        },
                        "dataProvider": data,
                        "valueAxes": [{
                            "id": "jmlPeraturan",
                            "axisAlpha": 0,
                            "gridAlpha": 0.15,
                            "position": "left",
                            "title": "Jumlah"
                        }],
                        "graphs": [{
                            "alphaField": "alpha",
                            "balloonText": "[[value]] peraturan",
                            "dashLengthField": "dashLength",
                            "fillAlphas": 0,
                            "legendPeriodValueText": "total: [[value.sum]] peraturan",
                            "legendValueText": "[[value]] peraturan",
                            "title": "Peraturan",
                            "type": "line",
                            "lineColor": "#006ac4",
                            "bullet": "round",
                            "valueField": "jml",
                            "valueAxis": "jmlPeraturan"
                        }],
                        "chartCursor": chartCursor2[0],
                        "dataDateFormat": "YYYY-MM-DD",
                        "categoryField": "tgl",
                        "categoryAxis": categoryAxis2[0]
                    });
                }
            }
        });
    }
    dataChartPeraturan();
    $("#submitPeraturan").bind('click', function(){
        dataChartPeraturan();
    });
});

var showBulanPengunjung = function(){
    document.getElementById("bulanPengunjungSelectRow").style.display="block";
}
var hideBulanPengunjung = function(){
    document.getElementById("bulanPengunjungSelectRow").style.display="none";
}
</script>