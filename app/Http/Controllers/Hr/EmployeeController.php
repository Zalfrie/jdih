<?php

namespace App\Http\Controllers\Hr;

use App\Model\Departement;
use App\Model\Employee;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Form;

class EmployeeController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        return view('hr.employee.index', []);
    }
    
    public function add(Request $request)
    {
        return view('hr.employee.add', []);
    }
    
    public function edit(Request $request, $id)
    {
        return view('hr.employee.edit', [
            'employee' => Employee::find($id)
        ]);
    }
    
    public function getDataTable(Request $request)
    {
        $employees = Employee::select(array('employee_number','name','email', 'id'));
    
        return \Datatables::of($employees)
            ->addColumn('actions', function($employee){
                return '<a class="btn blue btn-xs" href="/hr/employee/'.$employee->id.'/edit"><i class="fa fa-btn fa-pencil"></i>Edit</a>
					<button type="button" class="btn btn-danger btn-xs deleteEmployee">
						<i class="fa fa-btn fa-trash"></i>Delete
					</button>';
            })
            ->make(true);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'empl_numb' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'required|mimes:jpeg,bmp,png',
        ]);
        
        
        $public_upload = \Config::get('constants.public_upload');
        $dir = $public_upload.'/'.date('Y').'/'.date('m');
        if ($request->file('image')->isValid()) {
            if (!file_exists ($dir)){
                mkdir($dir, 0755, true);
            }
            $employee = new Employee;
            $img = \Image::make($_FILES['image']['tmp_name']);
            $img->fit(150, 150);
            $img->save(($dir."/".pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)."_".$img->width()."x".$img->height().".".$request->file('image')-> getClientOriginalExtension()));
            $employee->image = ("/assets/upload/".date('Y').'/'.date('m').'/'.pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)."_".$img->width()."x".$img->height().".".$request->file('image')-> getClientOriginalExtension());
            $employee->employee_number = $request->empl_numb;
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->save();
        }

        \Flash::success("Successfully inserting new employee data.");
        return redirect('/hr/employees');
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'empl_numb' => 'required',
            'name' => 'required',
            'email' => 'required|email',
        ]);
        
        $employee = Employee::find($id);
        $public_upload = \Config::get('constants.public_upload');
        $dir = $public_upload.'/'.date('Y').'/'.date('m');
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if (!file_exists ($dir)){
                mkdir($dir, 0755, true);
            }
            $img = \Image::make($_FILES['image']['tmp_name']);
            $img->fit(150, 150);
            $img->save(($dir."/".pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)."_".$img->width()."x".$img->height().".".$request->file('image')-> getClientOriginalExtension()));
            $employee->image = ("/assets/upload/".date('Y').'/'.date('m').'/'.pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)."_".$img->width()."x".$img->height().".".$request->file('image')-> getClientOriginalExtension());
        }
        $employee->employee_number = $request->empl_numb;
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->save();

        \Flash::success("Successfully updating employee data.");
        return redirect('/hr/employees');
    }

    public function destroy(Request $request, $id)
    {
        $employee = Employee::find($id);
        $employee->delete();

        \Flash::success("Successfully deleting employee data.");
        return redirect('/hr/employees');
    }
}
