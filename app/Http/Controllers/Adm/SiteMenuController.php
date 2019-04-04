<?php

namespace App\Http\Controllers\Adm;

use App\Model\SiteMenu;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Form;

class SiteMenuController extends Controller
{
    
    protected $menus;
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        $menu = SiteMenu::with('children.children.children.children.children')->where('parent_id', 0)->orderBy('order', 'asc')->get();
        return view('adm.sitemenus.index', [
            'menus' => $this->buildMenuFromArray($menu->toArray()),
        ]);
    }
    
    public function menutree(Request $request)
    {
        $menu = SiteMenu::with('children.children.children.children.children')->where('parent_id', 0)->orderBy('order', 'asc')->get();
        $menuTree = $this->buildMenuTree($menu->toArray());
        return json_encode($menuTree);
    }
    
    public function getAllStructure(Menu $menu){
        $children = $menu->children;
        if (count($children) > 0){
            foreach($children as $val){
                $this->getAllStructure($val);
            }
        }
    }
    
    public function buildMenuTree($menu){ 
        $result = array();
        foreach ($menu as $item) {
            $array = array();
            $array['id'] = $item['id'];
            $array['text'] = $item['label'];
            $array['state'] = array();
            if (count($item['children']) > 0){
                $array['state']['opened'] = true;
                $array['icon'] = ($item['icon']) ? ($item['icon']." icon-state-warning") : "fa fa-folder icon-state-warning";
                $array['children'] = $this->buildMenuTree($item['children']);
            }else{
                $array['state']['opened'] = false;
                $array['icon'] = ($item['icon']) ? ($item['icon']." icon-state-warning") : "fa fa-file icon-state-warning";
            }
            $result[] = $array;
        }
        return count($result) ?  $result : null; 
    }
    
    public function buildMenuFromArray($menu){ 
        $result = null;
        foreach ($menu as $item) {
                $result .= "<li class='dd-item dd3-item' data-order='{$item['order']}' data-id='{$item['id']}'>
                ".(($item['id'] > 1) ? "<div class='dd-handle dd3-handle'></div>":"")."
                    <div class='dd3-content'>
                        <div class='col-md-4 menuLabel'>
                            {$item['label']}
                        </div>
                        <div class='col-md-1 menuIcon'>
                            <span class='{$item['icon']}'></span>
                        </div>
                        <div class='col-md-4 menuLink'>
                            {$item['link']}
                        </div>
                        <div class='pull-right'>
                            <a class='bold editModal' href='javascript:;'>Edit</a>
                            ".(($item['id'] > 1) ? "| <form action='/adm/sitemenu/{$item['id']}' method='POST' class='pull-right'>
										".Form::token()."
										<input type='hidden' value='DELETE' name='_method'>
										<a href='javascript:;' class='bold deleteMenu'>Delete</a>
									</form>":"")."
                        </div>
                    </div>".(count($item['children']) > 0 ? $this->buildMenuFromArray($item['children']) : '') . "</li>";
        }
        return $result ?  "\n<ol class=\"dd-list\">\n$result</ol>\n" : null; 
    }
    
    public function buildMenu($menu, $menus, $is_submenu = false){ 
        $result = null;
        foreach ($menu as $item) {
            $children = null;
            if (count($item['children']) > 0){
                $children = $this->buildMenu($item['children'], $menus, true);
            }
            if (!empty($children) || in_array($item['id'], $menus)){
                $result .= "<li>
							<a href='{$item['link']}'>
    							<i class='{$item['icon']}'></i>
    							<span class='title'>{$item['label']}</span>
							</a>\n";
                $result .= "</li>";
            }
        }
        return $result ?  "\n<li>\n$result</li>\n" : null; 
    } 
    
    public function buildMenu2($menu, $parentid = 0){ 
        $result = null;
        foreach ($menu as $item) {
            if ($item->parent_id == $parentid) { 
                $result .= "<li class='dd-item dd3-item' data-order='{$item->order}' data-id='{$item->id}'>
                ".(($item->id > 1) ? "<div class='dd-handle dd3-handle''></div>":"")."
                    <div class='dd3-content'>
                        <div class='col-md-4 menuLabel'>
                            {$item->label}
                        </div>
                        <div class='col-md-1 menuIcon'>
                            <span class='{$item->icon}'></span>
                        </div>
                        <div class='col-md-4 menuLink'>
                            {$item->link}
                        </div>
                        <div class='pull-right'>
                            <a class='bold editModal' href='javascript:;'>Edit</a>
                            ".(($item->id > 1) ? "| <form action='/adm/sitemenu/{$item->id}' method='POST' class='pull-right'>
										".Form::token()."
										<input type='hidden' value='DELETE' name='_method'>
										<a href='javascript:;' class='bold deleteMenu'>Delete</a>
									</form>":"")."
                        </div>
                    </div>".$this->buildMenu($menu, $item->id) . "</li>"; 
            }
        }
        return $result ?  "\n<ol class=\"dd-list\">\n$result</ol>\n" : null; 
    } 
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'label' => 'required|max:255',
        ]);
        
        $menu = new SiteMenu;
        $menu->label = $request->label;
        $menu->link = $request->link;
        $menu->icon = $request->icon;
        $menu->order = 999;
        $menu->save();

        return redirect('/adm/sitemenus');
    }
    
    public function update(Request $request, $id)
    {
        $menu = SiteMenu::find($id);
        $menu->label = $request->label;
        $menu->link = $request->link;
        $menu->icon = $request->icon;
        $menu->save();

        return redirect('/adm/sitemenus');
    }

    public function destroy(Request $request, $id)
    {
        $menu = SiteMenu::find($id);
        SiteMenu::where('parent_id', $menu->id)
            ->update(['parent_id' => 0]);
        $menu->delete();

        return redirect('/adm/sitemenus');
    }
    
    public function reordering($data, $parent, $order)
    {
        foreach($data as $val){
            SiteMenu::where('id', $val['id'])->update(['parent_id' => $parent, 'order' => $order]);
            $order++;
            if (isset($val['children'])){
                $order = $this->reordering($val['children'], $val['id'], $order);
            }
        }
        return $order;
    }
    
    public function reorder(Request $request)
    {
        $data = json_decode($request->data, true);
        $this->reordering($data, 0, 0);

        return json_encode(array('type' => 'success', 'title' => 'Success', 'message' => 'Successfully reordering menu list.'));
    }
}
