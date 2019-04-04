
<div class="mainBanner">
      <div class="container">
        <div class="row">
        <div class="col-sm-11">
          <div class="text-placeholder">
            <marquee scrolldelay="100">
                <h1>{!! $title_beranda->content !!}</h1>
            </marquee>
<!--              <h1>{!! nl2br($title_beranda->content) !!}</h1> {!! $paragraf_beranda->content !!}-->
          </div>
        </div>
        <div class="halfBox">
          <p class="title">Cari Produk Hukum</p>
          <form class="form-horizontal" action="/pencarian" method="get">
            <div class="form-group">
              <div class="col-sm-16">
                <div class="input-group">
                  <select id="selectJenis" name="byBentuk">
                    <option value="">- Jenis Produk Hukum -</option>
                    @if(count($jenis) > 0)
                    @foreach($jenis as $val)
                    <option value="{{ strtolower($val->bentuk_short) }}"> {{ $val->bentuk }} </option>
                    @endforeach
                    @endif
                  </select>                
                 </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-16">
                <div class="input-group">
                  <select id="selectJenis" name="byMateri">
                    <option value="">- Materi Peraturan -</option>
                    @if(count($materi) > 0)
                    @foreach($materi as $val)
                    <option value="{{ $val->materi_id }}"> {{ $val->materi }} </option>
                    @endforeach
                    @endif
                  </select>                
                 </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-16">
                <input type="text" class="form-control" name="byNomor" id="inputNomor" placeholder="Nomor">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-16">
                <input type="text" class="form-control" name="byTahun" id="inputTahun" placeholder="Tahun">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-16">
                <input type="text" class="form-control" name="byTentang" id="inputTentang" placeholder="Tentang">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-16">
                <button type="submit" class="btn btn-search-custom pull-right">Cari</button>
              </div>
            </div>
          </form>
        </div>
        </div>
      </div>  
    </div>
    <!--/.mainBanner-->
    