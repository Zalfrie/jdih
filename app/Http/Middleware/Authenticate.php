<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Menu;
use App\Role;
use DB;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth/login');
            }
        }
        
        $userMenu = array();
        if (!$request->ajax()){
            $roles = DB::select('select role_id from role_user where user_id = ?', [$request->user()->id]);
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
