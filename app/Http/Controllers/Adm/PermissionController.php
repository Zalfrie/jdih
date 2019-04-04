<?php

namespace App\Http\Controllers\Adm;

use App\Permission;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository;

class PermissionController extends Controller
{
    
    protected $permissions;
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        return view('adm.permissions.index', [
            'permissions' => Permission::all(),
        ]);
    }
    
    public function edit(Request $request, $id)
    {
        $permission = Permission::find($id);
        return view('adm.permissions.edit', [
            'permissions' => Permission::all(),
            'permission' => $permission
        ]);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        
        $permission = new Permission;
        $permission->name = $request->name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;
        $permission->save();

        return redirect('/adm/permissions');
    }
    
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;
        $permission->save();

        return redirect('/adm/permissions');
    }

    public function destroy(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->delete();

        return redirect('/adm/permissions');
    }
}
