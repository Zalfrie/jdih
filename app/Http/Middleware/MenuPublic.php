<?php namespace App\Http\Middleware;

use Closure;
use App\Model\SiteMenu;
use App\Model\PerBentuk;
use App\Model\PerMateri;
use DB;

class MenuPublic
{

    public function __construct()
    {
        
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userMenu = array();
        if (!$request->ajax()){
            $menu = SiteMenu::with('children.children.children.children.children')->where('parent_id', 0)->orderBy('order', 'asc')->get();
            
            \View::share('menu1', $this->buildMenu($menu->toArray(), false));
            \View::share('layout', \Cookie::get('layout'));
        }

        return $next($request);
    }
    
    public function getAllStructure(SiteMenu $menu){
        $children = $menu->children;
        if (count($children) > 0){
            foreach($children as $val){
                $this->getAllStructure($val);
            }
        }
    }
    
    public function buildMenu($menu, $is_submenu = false){ 
        $result = null;
        foreach ($menu as $item) {
            $children = null;
            if (count($item['children']) > 0){
                $children = $this->buildMenu($item['children'], true);
            }
            $result .= "<li>
						<a class='dropdown-item' href='{$item['link']}'>
							{$item['label']}
						</a>\n$children";
            $result .= "</li>";
            
        }

        $jenis = PerBentuk::orderBy('urutan', 'asc')->get();
        $materi = PerMateri::all();

        $selectjenis = null;
        if(count($jenis) > 0){
            foreach ($jenis as $val) {
                $selectjenis .= '<option value="'.strtolower($val->bentuk_short).'"> '.$val->bentuk.' </option>';
            }
        }

        $selectmateri = null;
        if(count($materi) > 0){
            foreach ($materi as $val) {
                $selectmateri .= '<option value="'.$val->materi_id.'"> '.$val->materi.' </option>';
            }
        }

        $search = '<li class="dropdown dropdown-quaternary dropdown-mega" id="headerSearchProperties">
                        <a class="nav-link dropdown-toggle" href="#">
                            Cari Peraturan &nbsp;<i class="fas fa-search"></i>
                        </a>
                    <ul class="dropdown-menu custom-fullwidth-dropdown-menu">
                        <li>
                                                                <div class="dropdown-mega-content">
                                                                    <form id="propertiesFormHeader" action="/pencarian" method="get">
                                                                        <div class="container p-0">
                                                                            <div class="form-row">
                                                                                <div class="form-group">
                                                                                    <div class="input-group ">
                                                                                        <select class="form-control text-uppercase text-2" name="byBentuk" id="propertiesPropertyType" >
                                                                                        <option value="">- Jenis Produk Hukum -</option>
                                                                                        '.$selectjenis.'
                                                                                      </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group col-lg-5">
                                                                                    <div class="form-control-custom">
                                                                                        <select class="form-control text-uppercase text-2" name="byMateri" id="propertiesLocation" >
                                                                                        <option value="">- Materi Peraturan -</option>
                                                                                        '.$selectmateri.'
                                                                                      </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group col-lg-2 mb-0">
                                                                                    <div class="form-control-custom">
                                                                                        <input type="text" value=""  maxlength="100" class="form-control" name="byNomor" id="name" placeholder="Nomor">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group col-lg-2 mb-0">
                                                                                    <div class="form-control-custom">
                                                                                        <input type="text" value=""  maxlength="100" class="form-control" name="byTahun" id="name" placeholder="Tahun">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group col-lg-2 mb-0">
                                                                                    <div class="form-control-custom">
                                                                                        <input type="text" value=""  maxlength="100" class="form-control" name="byTentang" id="name" placeholder="Tentang">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group col-lg-2 mb-0">
                                                                                    <input type="submit" value="Cari" class="btn btn-secondary btn-lg btn-block text-uppercase text-2">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </li>
                    </ul>

                        </li>';
         
        if ($is_submenu){
            return $result ?  "\n<ul class='dropdown-menu'>\n$result&nbsp\n$search</ul>\n" : null;
        }else{
            return $result ?  "\n<ul id='mainNav' class='nav nav-pills'>$result&nbsp\n$search</ul>\n" : null;
        }
    }
}
