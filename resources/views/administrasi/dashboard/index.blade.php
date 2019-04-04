@extends('layouts.app')

@section('content')
                
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
                                    <select class="form-control" id="dimensiSelect">
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
			<div class="clearfix">
			</div>
			<div class="row ">
				<div class="col-md-6 col-sm-12">
					<div class="portlet box blue-chambray">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-bar-chart"></i>Statistik Peraturan
							</div>
						</div>
						<div class="portlet-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control" id="timePeraturan">
										<option value="minggu">Seminggu Terakhir</option>
										<option value="bulan">Bulan Ini</option>
										<option value="tahun">Tahun Ini</option>
									</select>
                                </div>
                                <div class="col-md-6">
        							<button class="btn blue" id="submitPeraturan">Pilih</button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
							<div class="row">
								<div class="col-md-12">
        							<div id="peraturanLoading">
        								<img src="/assets/admin/layout/img/loading.gif" alt="loading"/>
        							</div>
        							<div id="peraturanContent" class="display-none">
        								<div id="peraturanChart" class="chart">
        								</div>
        							</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
                    <div class="portlet box blue-chambray">
        				<div class="portlet-title">
        					<div class="caption">
        						Peraturan Terpopuler
        					</div>
        				</div>
        				<div class="portlet-body">
        					<table class="table table-striped table-hover">
            					<thead>
                					<tr>
                                        <th>No</th>
            							<th>No Peraturan</th>
            							<th class="text-right">Views</th>
                					</tr>
            					</thead>
            					<tbody>
                                @if (count($populer) > 0)
                                <?php
                                $i = 1;
                                ?>
                                @foreach($populer as $val)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$val->per_no}}</td>
                                        <td class="text-right">{{number_format($val->reading_counter, 0, '', '.')}}</td>
                                    </tr>
                                <?php
                                $i++;
                                ?>
                                @endforeach
                                @endif
            					</tbody>
        					</table>
        				</div>
        			</div>
				</div>
			</div>
			<div class="clearfix">
			</div>
			<div class="row ">
				<div class="col-md-12 col-sm-12">
                    <div class="portlet box blue-chambray">
        				<div class="portlet-title">
        					<div class="caption">
        						Rekap Peraturan
        					</div>
        				</div>
        				<div class="portlet-body">
        					<table class="table table-striped table-bordered table-hover">
            					<thead>
                					<tr>
                                        <th>No</th>
            							<th>Jenis Peraturan</th>
                                        <?php
                                        echo '<th> < '.(date('Y') - 4).'</th>';
                                        for ($i = date('Y') - 4; $i <= date('Y'); $i++){
                                            echo '<th>'.$i.'</th>';
                                        }
                                        ?>
                					</tr>
            					</thead>
            					<tbody>
                                <?php
                                $no = 1;
                                ?>
                                @foreach($rekap as $val)
                                    <tr>
                                        <td>{{$no}}</td>
                                        <td>{{$val['bentuk']}}</td>
                                        <td>{{$val[1]}}</td>
                                        <?php
                                        for ($i = date('Y') - 4; $i <= date('Y'); $i++){
                                            echo '<td>'.$val[$i].'</td>';
                                        }
                                        ?>
                                    </tr>
                                <?php
                                $no++;
                                ?>
                                @endforeach
            					</tbody>
        					</table>
        				</div>
        			</div>
				</div>
			</div>
@endsection


@section('jspluginscript')
<script src="https://www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
<script src="https://www.amcharts.com/lib/3/serial.js" type="text/javascript"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js" type="text/javascript"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
@endsection

@section('csspluginscript')
@endsection

@section('jsscript')
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
@endsection

@section('styleCustomizer')

			<!-- BEGIN STYLE CUSTOMIZER -->
			<div class="theme-panel hidden-xs hidden-sm">
				<div class="toggler">
				</div>
				<div class="toggler-close">
				</div>
				<div class="theme-options">
					<div class="theme-option theme-colors clearfix">
						<span>
						THEME COLOR </span>
						<ul>
							<li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default">
							</li>
							<li class="color-darkblue tooltips" data-style="darkblue" data-container="body" data-original-title="Dark Blue">
							</li>
							<li class="color-blue tooltips" data-style="blue" data-container="body" data-original-title="Blue">
							</li>
							<li class="color-grey tooltips" data-style="grey" data-container="body" data-original-title="Grey">
							</li>
							<li class="color-light tooltips" data-style="light" data-container="body" data-original-title="Light">
							</li>
							<li class="color-light2 tooltips" data-style="light2" data-container="body" data-html="true" data-original-title="Light 2">
							</li>
						</ul>
					</div>
					<div class="theme-option">
						<span>
						Theme Style </span>
						<select class="layout-style-option form-control input-sm">
							<option value="square" selected="selected">Square corners</option>
							<option value="rounded">Rounded corners</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Layout </span>
						<select class="layout-option form-control input-sm">
							<option value="fluid" selected="selected">Fluid</option>
							<option value="boxed">Boxed</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Header </span>
						<select class="page-header-option form-control input-sm">
							<option value="fixed" selected="selected">Fixed</option>
							<option value="default">Default</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Top Menu Dropdown</span>
						<select class="page-header-top-dropdown-style-option form-control input-sm">
							<option value="light" selected="selected">Light</option>
							<option value="dark">Dark</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Sidebar Mode</span>
						<select class="sidebar-option form-control input-sm">
							<option value="fixed">Fixed</option>
							<option value="default" selected="selected">Default</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Sidebar Menu </span>
						<select class="sidebar-menu-option form-control input-sm">
							<option value="accordion" selected="selected">Accordion</option>
							<option value="hover">Hover</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Sidebar Style </span>
						<select class="sidebar-style-option form-control input-sm">
							<option value="default" selected="selected">Default</option>
							<option value="light">Light</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Sidebar Position </span>
						<select class="sidebar-pos-option form-control input-sm">
							<option value="left" selected="selected">Left</option>
							<option value="right">Right</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Footer </span>
						<select class="page-footer-option form-control input-sm">
							<option value="fixed">Fixed</option>
							<option value="default" selected="selected">Default</option>
						</select>
					</div>
				</div>
			</div>
			<!-- END STYLE CUSTOMIZER -->
			<!-- BEGIN PAGE HEADER-->
			<div class="page-bar">
			</div>
			<h3 class="page-title">
			&nbsp;
			</h3>
			<!-- END PAGE HEADER-->
@endsection