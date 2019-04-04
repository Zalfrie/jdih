@extends('layouts.site1.app')

@section('meta')
<meta name="description" content="{{$title.' Kementerian BUMN'}}"/>
@endsection

@section('content')

<section class="page-header">
<div class="container">
  <div class="row">
    <div class="col">
      <ul class="breadcrumb">
        <li><a href="/">Beranda</a></li>
        <li class="active">{{ !empty($perBentuk) ? $perBentuk->bentuk:'Peraturan Lainnya'}}</li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <h1>{{ !empty($perBentuk) ? $perBentuk->bentuk:'Peraturan Lainnya'}}</h1>
    </div>
  </div>
</div>
</section>

<div class="container">
  <div class="row">
    <div class="col-lg-12">

              <div class="accordion" id="accordion">
                <div class="card card-default">
                  <div class="card-header">
                    <h4 class="card-title m-0">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false">
                        Cari {{ !empty($perBentuk) ? $perBentuk->bentuk:'Peraturan Lainnya'}} <i class="fas fa-search"></i><i class="fas fa-caret-down"></i>
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="collapse" style="">
                    <div class="card-body">
                      <form name="cariForm" id="contactForm" action="/{{$bentuk}}" method="get">
                        <div class="form-row">
                          <div class="form-group col-lg-6">
                            <label>Status</label>
                            <select id="selectStatus" name="byStatus" class="form-control">
                              <option value="">- Status Produk Hukum -</option>
                              @if(count($status) > 0)
                              @foreach($status as $val)
                              <option value="{{ strtolower($val->status) }}" {{ old('byStatus') == strtolower($val->status) ? 'selected="selected"':'' }}> {{ $val->status }} </option>
                              @endforeach
                              @endif
                            </select>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-lg-4">
                            <label>Nomor</label>
                            <input type="text" class="form-control" name="byNomor" id="inputNomor" placeholder="Nomor" value="{{ old('byNomor') }}">
                          </div>
                          <div class="form-group col-lg-4">
                            <label>Tahun</label>
                            <input type="text" class="form-control" name="byTahun" id="inputTahun" placeholder="Tahun" value="{{ old('byTahun') }}">
                          </div>
                          <div class="form-group col-lg-4">
                            <label>Tentang</label>
                            <input type="text" class="form-control" name="byTentang" id="inputTentang" placeholder="Tentang" value="{{ old('byTentang') }}">
                          </div>
                        </div>
                        <input type="hidden" class="form-control" name="sorting" id="inputSorting" value="desc">
                        <div class="form-row">
                          <div class="form-group col">
                            <button type="submit" class="btn btn-primary">Cari Peraturan</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    
  </div>
</div>

<div class="contentWrapper">
    <div class="container">
      <hr class="tall">
        <form name="sortingForm">
            <div class="row" style="font-family:Helvetica; font-size: 14px;">
                
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
              <table id="tablePeraturan" class="table table-hover">
              <thead>
                <tr>
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
              {!! with(new App\SmallPaginationPresenter($peraturan))->render() !!}
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('jspluginscript')
@endsection

@section('csspluginscript')
@endsection

@section('jsscript')
<script type="text/javascript">
function urutkan() {
    document.cariForm.sorting.value = document.sortingForm.sorting.value;
    document.cariForm.submit();
}
</script>

<script type="text/javascript">
        $('.pagination li').addClass('page-item');
        $('.pagination li a').addClass('page-link');
        $('.pagination span').addClass('page-link');

</script>
@endsection