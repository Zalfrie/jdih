<?php

namespace App\Http\Controllers\Administrasi;

use App\User;
use App\Role;
use App\Model\Employee;
use App\Model\Ldap;
use App\Model\Bumn;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;
use Validator;
use DB;
use App\MiddlewareClient;
use Barryvdh\DomPDF\Facade as PDF;
use Excel;

class UserController extends Controller
{
    
    protected $users;
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        return view('administrasi.users.index', [
            'users' => User::with('roles')->orderBy('username')->get()
        ]);
    }
    
    public function tambah(Request $request)
    {
        $request->flash();
        $bumn = MiddlewareClient::getBumn();
        return view('administrasi.users.tambah', [
            'roles' => Role::orderBy('name')->get(),'bumn' => $bumn['data'],
        ]);
    }
    
    public function cari(Request $request)
    {
        /*$ldap = ($request->isMethod('post')) ? new Ldap() : null;
        $nonJDIHUser = ($request->isMethod('post')) ? $ldap->cariUserNonJDIH($request->search) : null;
        $JDIHUser = ($request->isMethod('post')) ? $ldap->cariUserJDIH($request->search) : null;
        $request->flash();
        return view('administrasi.users.tambah', ['nonJDIHUser' => $nonJDIHUser, 'JDIHUser' => $JDIHUser, 'found' => false]);*/
//        return view('administrasi.users.cari', ['found'=>false]);


        $bumn = MiddlewareClient::getBumn();
        return view('administrasi.users.tambah', [
            'bumn'=>$bumn['data'], 'roles' => []
        ]);

    }

    public function search(Request $request){
        $user = User::where('username', $request->username)->first();
        if ($user){
            $res = MiddlewareClient::getUserProfile($request->username);
            if (!$res['status'] || !$res['access_portal']){
                $user->handphone = 0;
                MiddlewareClient::addUser($request);
            }
            \Flash::success("Username sudah terdaftar di portal ini.");
            return redirect('/administrasi/user/cari');
        }
        $res = MiddlewareClient::getUserProfile($request->username);
        if ($res['access_portal']){
            User::where('username', $res['data']['username'])->orWhere('email', $res['data']['email'])->delete();
            $user = User::create([
                'username' => $res['data']['username'],
                'email' => $res['data']['email'],
                'name' => $res['data']['name'],
                'is_external' => $res['data']['kategori_user_id'] == env('MW_INTERNAL_USER_CATEGORY_ID', 1),
            ]);
            $user->save();
            $user->roles()->attach(env('PREPARE_ROLE_ID', null));
            \Flash::success("Username sudah terdaftar di portal ini.");
            return redirect('/administrasi/user/cari');
        }
        $bumn = MiddlewareClient::getBumn();
        return view('administrasi.users.tambah', [
            'status'=>$user['status'], 'bumn'=>$bumn['data'], 'user'=>$user['data'], 'request'=>$request->username, 'roles' => []
        ]);
    }

    public function detail($username){
        $userProfile = MiddlewareClient::getUserProfile($username);
        $jdih_user = User::where('username', $username)->first();
        if (is_null($jdih_user)){
            \Flash::error("{$username} tidak ditemukan.");
            return view('administrasi.users.index', [
                'users' => User::with('roles')->orderBy('username')->get()
            ]);
        }
        if (is_null($userProfile)){
            \Flash::error("Gagal terhubung ke Middleware.");
            return view('administrasi.users.index', [
                'users' => User::with('roles')->orderBy('username')->get()
            ]);
        }
        if (!$userProfile['status']){
            User::where('username', $username)->delete();
            \Flash::error("User tidak ditemukan di Middleware.");
            return view('administrasi.users.index', [
                'users' => User::with('roles')->orderBy('username')->get()
            ]);
        }
        if (!$userProfile['access_portal']){ //Add JDIH access in Middleware
            $user = new \stdClass;
            $user->username = $jdih_user->username;
            $user->email = $jdih_user->email;
            $user->name = $jdih_user->name;
            $user->handphone = 0;
            MiddlewareClient::addUser($user);
            $userProfile = MiddlewareClient::getUserProfile($username);
        }
        if ($userProfile['data']['kategori_user_id'] == env('MW_BUMN_USER_CATEGORY_ID', 2))
            $userProfile['data']['asal_instansi'] = $userProfile['data']['bumn_lengkap'];
        $userProfile['data']['roles'] = $jdih_user->roles;

        $rolesBelonged = array();
        foreach ($jdih_user->roles as $role){
            $rolesBelonged[] = $role->id;
        }
        return view('administrasi.users.detail', [
            'user'=>$userProfile['data'],
            'rolesBelonged' => $rolesBelonged,
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function updateRoles(Request $request, $id){
        DB::beginTransaction();
        try{
            $user = User::where('username', $id)->first();
            $user->roles()->detach();
            $user->attachRoles($request->role);
        }catch(\Exception $e){
            DB::rollback();
            \Flash::error("Failed to update user data.");
            throw $e;
            return redirect('/administrasi/users');
        }

        DB::commit();
        \Flash::success("Successfully updating user data.");
        return redirect('/administrasi/users');
    }
    
    public function edit(Request $request, $id)
    {
        $bumn = MiddlewareClient::getBumn();
        $user = User::with('roles')->find($id);
        $rolesBelonged = array();
        foreach ($user->roles as $role){
            $rolesBelonged[] = $role->id;
        }
        
        return view('administrasi.users.edit', [
            'user' => $user,
            'roles' => Role::orderBy('name')->get(),
            'rolesBelonged' => $rolesBelonged,
            'bumn' => $bumn['data'],
        ]);
    }

    protected function create(array $data)
    {
        $userInput = User::create([
            'username' => $data['email'],
            'email' => $data['email'],
        ]);
        return $userInput;
    }
    
    public function store(Request $request)
    {
        $dataValidator = [
            'email' => 'required|email',
            'id_bumn' => 'required',
        ];
        /*if ($request->type == 'new'){
            $dataValidator['password'] = 'required|confirmed|min:8';
        }*/
        $validator = Validator::make($request->all(), $dataValidator);

        if ($validator->fails()) {
//            $this->throwValidationException($request, $validator);
            \Flash::error($validator->errors());
            return redirect('/administrasi/user/cari');
        }
        DB::beginTransaction();
        try {
            $request->username = $request->email;
            $request->name = $request->email;
            $res = MiddlewareClient::addUser($request);
            if ($res['status']==false){
                \Flash::error($res['msg'][0]);
                return redirect('/administrasi/user/cari');
            }
            User::where('username', $request->username)->orWhere('email', $request->email)->delete();
            $user = $this->create($request->all());
            $user->name = MiddlewareClient::getAsalInstansi($request->username);
            $user->is_external = true;
            $user->save();
            $user->roles()->attach(env('PREPARE_ROLE_ID', null));
            /*$employee = new Employee;
            $employee->employee_number = $request->nip;
            $employee->name = $request->nama;
            
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $public_upload = \Config::get('constants.public_upload');
                $dir = $public_upload.'/'.date('Y').'/'.date('m');
                if (!file_exists ($dir)){
                    mkdir($dir, 0755, true);
                }
                $img = \Image::make($_FILES['image']['tmp_name']);
                $img->fit(150, 150);
                $img->save(($dir."/".pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)."_".$img->width()."x".$img->height().".".$request->file('image')-> getClientOriginalExtension()));
                $employee->image = ("/assets/upload/".date('Y').'/'.date('m').'/'.pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)."_".$img->width()."x".$img->height().".".$request->file('image')-> getClientOriginalExtension());
            }else{
                $employee->image = "/assets/global/img/noimage.png";
            }
            $employee->save();
            
//            $user->employee()->associate($employee);
            $user->save();
            $ldap = new Ldap();
            $bumn_id = $request->bumn;

            if($bumn_id == '' || $bumn_id == NULL){
                $bumn_id_ldap = '0000';
            } else {
                $bumn_id_ldap = $bumn_id;
            }

            //echo $bumn_id_ldap;die;

            if ($request->type == 'new'){
                $result = $ldap->addNewUser($request->username, $request->password, 'us', 'jdih', $bumn_id_ldap, $request->nip, $request->email, null, null, $request->nama);
                if (!$result){
                    throw new Exception('Ldap Gagal');
                }
            }else{
                $result = $ldap->addPortal($request->username, 'jdih');
                if (!$result){
                    throw new Exception('Ldap Gagal');
                }
            }*/
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error('Failed to insert user data.');
            return redirect('/administrasi/users');
        }
        
        DB::commit();
        \Flash::success("Successfully inserting new user.");
        return redirect('/administrasi/users');
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'confirmed|min:8',
            'image' => 'mimes:jpg,jpeg,bmp,png',
        ]);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $user->roles()->detach();
            $user->attachRoles($request->role);
            $employee = $user->employee;
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $public_upload = \Config::get('constants.public_upload');
                $dir = $public_upload.'/'.date('Y').'/'.date('m');
                if (!file_exists ($dir)){
                    mkdir($dir, 0755, true);
                }
                $img = \Image::make($_FILES['image']['tmp_name']);
                $img->fit(150, 150);
                $img->save(($dir."/".pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)."_".$img->width()."x".$img->height().".".$request->file('image')-> getClientOriginalExtension()));
                $employee->image = ("/assets/upload/".date('Y').'/'.date('m').'/'.pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)."_".$img->width()."x".$img->height().".".$request->file('image')-> getClientOriginalExtension());
            }
            $employee->save();
            $user->save();
            
            if (!empty($request->password)){
                $ldap = new Ldap();
                $result = $ldap->changePassword($request->username, $request->password);
                if (!$result){
                    throw new Exception('Ldap Gagal');
                }
            }
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Failed to update user data.");
            throw $e;
            return redirect('/administrasi/users');
        }
        
        DB::commit();
        \Flash::success("Successfully updating user data.");
        return redirect('/administrasi/users');
    }

    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $response = MiddlewareClient::deleteUser($user->username);
        DB::beginTransaction();
        try {
            $user->roles()->detach();
//            $user->employee()->delete();
            $user->delete();
            /*$ldap = new Ldap();
            $result = $ldap->removePortal($username, 'jdih');
            if (!$result){
                throw new Exception('Ldap Gagal');
            }*/
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Failed to delete role data caused by {$e->getMessage()}");
            return redirect('/administrasi/users');
        }
        
        DB::commit();
        /*if (!$response['status']){
            $message = implode(',', $response['msg']);
            throw new \Exception("Failed to delete user in Middleware : {$message}");
        }*/
        \Flash::success("Successfully deleting role data.");
        return redirect('/administrasi/users');
    }

    public function downloadPDF()
    {
        $i = 0;

        $usersDB = User::with('roles')->orderBy('username')->get();
        $usersMW = MiddlewareClient::getUser();
        $users = MiddlewareClient::getUser();
        $pdf = PDF::loadView('administrasi.users.downloadPDF', compact('users'))
                    ->setPaper('A4', 'landscape');
        return $pdf->download('JDIH-User.pdf');
        //*/
       
    }

    public function downloadExcel()
    {
       Excel::create('JDIH KBUMN User', function($excel) {
            $excel->sheet('JDIH KBUMN', function($sheet) {
                $users = MiddlewareClient::getUser();
                $sheet->setAutoSize(true);
                $sheet->loadView('administrasi.users.downloadExcel')->with('users', $users);
            });
        })->download('xlsx');
    }
}
