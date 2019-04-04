@extends('layouts.site.app')

@section('meta')
<meta name="description" content="{{$title.' Kementerian BUMN'}}"/>
@endsection

@section('content')

  <div id="bottomHeader">
    <div class="container">
      <h3>{{ !empty($perBentuk) ? $perBentuk->bentuk:'Peraturan Lainnya'}}</h3>
    </div>
  </div>
  <!--/#bottomHeader-->


  <div class="contentWrapper">
    <div class="container">
      <form name="cariForm" class="form-horizontal clearfix" action="/{{$bentuk}}" method="get">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="selectNomor" class="col-sm-5 control-label">Nomor</label>
              <div class="col-sm-11">
                <div class="input-group">
                  <input type="text" class="form-control" name="byNomor" id="inputNomor" placeholder="Nomor" value="{{ old('byNomor') }}">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="selectTahun" class="col-sm-5 control-label">Tahun</label>
              <div class="col-sm-11">
                <div class="input-group">
                  <input type="text" class="form-control" name="byTahun" id="inputTahun" placeholder="Tahun" value="{{ old('byTahun') }}">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-6">
              <div class="form-group">
                  <label for="selectTentang" class="col-sm-5 control-label">Tentang</label>
                  <div class="col-sm-11">
                      <div class="input-group">
                          <input type="text" class="form-control" name="byTentang" id="inputTentang" placeholder="Tentang" value="{{ old('byTentang') }}">
                      </div>
                  </div>
              </div>
            <div class="form-group">
              <label for="selectStatus" class="col-sm-5 control-label">Status</label>
              <div class="col-sm-11">
                <div class="input-group">
                  <select id="selectStatus" name="byStatus">
                    <option value="">- Status Produk Hukum -</option>
                    @if(count($status) > 0)
                    @foreach($status as $val)
                    <option value="{{ strtolower($val->status) }}" {{ old('byStatus') == strtolower($val->status) ? 'selected="selected"':'' }}> {{ $val->status }} </option>
                    @endforeach
                    @endif
                  </select>
                  </select>           
                </div>
              </div>
            </div>
              <input type="hidden" class="form-control" name="sorting" id="inputSorting" value="desc">
            <div class="button-line text-right">
              <button type="submit" class="btn btn-primary">Cari Peraturan</button>
              <a class="btn btn-link" type="button" href="/cse">Pencarian Text</a>
            </div>
          </div>
          <div class="col-md-3"></div>
        </div>
      </form>
        <form name="sortingForm">
            <div class="row" style="font-family:Helvetica; font-size: 14px;">
                Urutkan dari:
                <input type="radio" name="sorting" <?php if ($sorting=='desc')
                    echo 'checked'?> value="desc" onchange="urutkan()">Terbaru
                <input type="radio" name="sorting" <?php if ($sorting!='desc')
                    echo 'checked'?> value="asc" onchange="urutkan()">Terlama
            </div>
        </form>
      <div class="col-sm-16">
        <div class="hasilPencarian">
          <p class="blue-text">Hasil Pencarian</p>
          <div class="table-wrapper">
              <table id="tablePeraturan" class="table table-striped table-bordered table-hover">
              <thead>
                <tr bgcolor="#0a3c6b">
                  <th style="width: 10px;">NOMOR</th>
                    <th style="width: 30px;">TANGGAL PENETAPAN</th>
                  <th style="width: 100px;">TENTANG</th>
                  <th style="width: 10px;">STATUS</th>
                  <th style="width: 10px;">DOWNLOAD</th>
                </tr>
              </thead>
              <tbody>
              @if(count($peraturan) > 0)
              @foreach($peraturan as $val)
              <?php
                $status = [];
                foreach($val->status as $stat){
                    $status[] = $stat->status.' : <a href="/lihat/'.$stat->pivot->per_no_object.'">'.$stat->pivot->per_no_object.'</a>';
                }
                $strStatus = (count($status) > 0)?(implode('<br/>', $status)):'';
              ?>
                <tr>
                  <td style="text-align: left;">{!! '<a href="/lihat/'.$val->per_no.'">'.$val->per_no.'</a>' !!}</td>
                  <td style="text-align: left;">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $val->tanggal)->formatLocalized('%d %B %Y') }}</td>
                  <td style="text-align: left;">{{ $val->tentang }}</td>
                  <td style="text-align: left;">{!! $strStatus !!}</td>
                  <td style="text-align: center;">{!! '<a href="/unduh/'.$val->per_no.'.pdf"><img src="/assets/global/img/pdficon.png" /></a>' !!}</td>
                </tr>
              @endforeach
              @endif
              </tbody>
              </table>
              {!! $peraturan->render() !!}
          </div>
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
    function urutkan() {
        document.cariForm.sorting.value = document.sortingForm.sorting.value;
        document.cariForm.submit();
    }
</script>
@endsection