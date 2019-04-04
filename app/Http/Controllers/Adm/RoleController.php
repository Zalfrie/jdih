<?php

namespace App\Http\Controllers\Adm;

use App\Role;
use App\Permission;
use App\Menu;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class RoleController extends Controller
{
    
    protected $roles;
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        $menu = Menu::with('children.children.children.children.children')->where('parent_id', 0)->orderBy('order', 'asc')->get();
        return view('adm.roles.index', [
            'roles' => Role::all(),
            'permissions' => Permission::orderBy('name')->get(),
            'menuJson' => json_encode($menu)
        ]);
    }
    
    public function getAllStructureMenu(Menu $menu){
        $children = $menu->children;
        if (count($children) > 0){
            foreach($children as $val){
                $this->getAllStructureMenu($val);
            }
        }
    }
    
    public function edit(Request $request, $id)
    {
        $role = Role::with('perms')->find($id);
        $permsBelonged = array();
        foreach ($role->perms as $permission){
            $permsBelonged[] = $permission->id;
        }
        
        return view('adm.roles.edit', [
            'roles' => Role::all(),
            'role' => $role,
            'permissions' => Permission::orderBy('name')->get(),
            'permsBelonged' => $permsBelonged,
        ]);
    }
    
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => 'required|max:255',
            ]);
            
            $role = new Role;
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->save();
            
            if ($request->permission){
                foreach($request->permission as $permission){
                    $role->attachPermission($permissions);
                }
            }
            
            if ($request->menu){
                foreach($request->menu as $id){
                    $role->menus()->attach($id);
                }
            }
        } catch(ValidationException $e){
            DB::rollback();
            return Redirect::to('/adm/roles')
                ->withErrors( $e->getErrors() )
                ->withInput();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Failed to insert role data.");
            throw $e;
        }
        
        DB::commit();
        \Flash::success("Successfully inserting new role.");
        return redirect('/adm/roles');
    }
    
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $role = Role::find($id);
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->save();
            
            $role->savePermissions(null);
            if ($request->permission){
                foreach($request->permission as $permission){
                    $role->attachPermission($permissions);
                }
            }
            
            $role->menus()->detach();
            if ($request->menu){
                foreach($request->menu as $id){
                    $role->menus()->attach($id);
                }
            }
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Failed to update role data.");
            throw $e;
        }
        
        DB::commit();
        \Flash::success("Successfully updating role data.");

        return redirect('/adm/roles');
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $role = Role::find($id);
            $role->savePermissions(null);
            $role->menus()->detach();
            $role->delete();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Failed to delete role data.");
            throw $e;
        }
        
        DB::commit();
        \Flash::success("Successfully deleting role data.");

        return redirect('/adm/roles');
    }
}
