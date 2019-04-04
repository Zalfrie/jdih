<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Model\Peraturan;
use App\Menu;
use App\Role;
use App\User;
use DB;
use App\MiddlewareClient;

class CASAuth
{
    protected $auth;
    protected $cas;
    protected $user;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->cas = app('cas');
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
//        $this->auth->login(User::where('username', 'widya.rarasati')->first()); //TODO JANGAN LUPA UNCOMMENT >>
        /*if( $this->cas->isAuthenticated() )
        {
            // Store the user credentials in a Laravel managed session
            $casUser = $this->cas->user();
            session()->put('cas_user', $casUser);
            $this->user = User::where('username', $casUser)->first();
//                $this->user = $this->getFirstUserByUsername($casUser)
            if ($this->auth->guest()){
                if (!is_null($this->user)){
                    \Auth::login($this->user);
                } else {
                    if ($request->ajax()) {
                        return response('Unauthorized.', 401);
                    }
                    \Auth::logout();
                    $this->cas->logout();
                }
            }
        }*/
        if( $this->cas->isAuthenticated() )
        {
            // Store the user credentials in a Laravel managed session
            $casUser = $this->cas->user();
            if (!session()->has('cas_user') || $this->auth->guest() || $this->auth->user()->username != $casUser){
                /*$param = ['username' => $casUser, 'portal' => env('KODE_SSO', '')];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, env('MIDDLEWARE__URL', '').'/check');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = json_decode(curl_exec ($ch));
                curl_close ($ch); */
//                $response = MiddlewareClient::check($casUser, env('KODE_SSO', ''));
                $response = MiddlewareClient::getUserProfile($casUser);
                $user = User::where('username', $casUser)->first();
                if ($response['access_portal']){
                   if (is_null($user)){
                       $is_external = $response['data']['kategori_user_id'] != env('MW_INTERNAL_USER_CATEGORY_ID', 1);
                       $jdih_user = User::create([
                           'username' => $response['data']['username'],
                           'email' => $response['data']['email'],
                           'is_external' => $is_external,
                           'name' => $is_external ? $response['data']['bumn_singkat'] : $response['data']['name'],
                       ]);
                       $jdih_user->save();
                       $jdih_user->roles()->attach(env('PREPARE_ROLE_ID', null));
                   }
                    $user = User::where('username', $casUser)->first();
                    $this->auth->login($user);
                    session()->put('cas_user', $casUser);
                } else {
                    if ($request->ajax()) {
                        return response('Unauthorized.', 401);
                    }
                    $this->auth->logout();
                    \Cas::logoutWithRedirectService(env('CAS_LOGOUT_REDIRECT_URL', ''));
                }
            }
        } else {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }
            \Auth::logout();
            $this->cas->authenticate();
        }
        $userMenu = array();
        if (!$request->ajax()){
            $roles = \DB::select('select role_id from role_user where user_id = ?', [\Auth::user()->id]);
            $whereIn = array();
            foreach ($roles as $val){
                $whereIn[] = $val->role_id;
            }
            $roles = Role::with('menus')->whereIn('id', $whereIn)->get();
            foreach ($roles as $role){
                foreach ($role->menus as $val){
                    $userMenu[] = $val->id;
                }
            }
            $menu = Menu::with('children.children.children.children.children')->where('parent_id', 0)->orderBy('order', 'asc')->get();
            $declinedNotif = null;
            if (\Auth::user()->hasRole(['sys_admin', 'Admin_Konten'])){
                $declinedNotif = Peraturan::where('is_publish', 2)->orderBy('published_at', 'desc')->get();
            }
            \View::share('declinedNotif', $declinedNotif);
            $approvalNotif = null;
            if (\Auth::user()->hasRole(['sys_admin', 'Verifikator'])){
                $approvalNotif = Peraturan::where('is_publish', 0)->whereNotNull('file_id')->orderBy('updated_at', 'desc')->get();
            }
            \View::share('approvalNotif', $approvalNotif);
            \View::share('menu1', $this->buildMenu($menu->toArray(), $userMenu, false));
            \View::share('layout', \Cookie::get('layout'));
        }

        return $next($request);
    }
    
    public function getAllStructure(Menu $menu){
        $children = $menu->children;
        if (count($children) > 0){
            foreach($children as $val){
                $this->getAllStructure($val);
            }
        }
    }
    
    public function buildMenu($menu, $menus, $is_submenu = false){ 
        $result = null;
        foreach ($menu as $item) {
            $children = null;
            if (count($item['children']) > 0){
                $children = $this->buildMenu($item['children'], $menus, true);
            }
            if (!empty($children) || in_array($item['id'], $menus)){
                if(!empty($children)){
                    $link = 'javascript:;';
                }else{
                    $link = $item['link'];
                }
                $result .= "<li>
							<a href='$link'>
    							<i class='{$item['icon']}'></i>
    							<span class='title'>{$item['label']}</span>".
                                (!empty($children) ? "<span class='arrow '></span>":"")."
							</a>\n$children";
                $result .= "</li>";
            }
        }
         
        if ($is_submenu){
            return $result ?  "\n<ul class='sub-menu'>\n$result</ul>\n" : null;
        }else{
            return $result ?  "\n$result\n" : null;
        }
    }
}
