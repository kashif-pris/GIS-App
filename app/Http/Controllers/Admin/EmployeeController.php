<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminRole;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\WelcomeEmail;
use Auth;


class EmployeeController extends Controller
{

    public function add_new()
    {
        $user = auth('admin')->user();
        // dd($user);
        if($user->role_id == '1' && $user->id == '1')
        {
            $rls = AdminRole::get();
        }else{
            $rls = AdminRole::whereNotIn('id', [1])->get();
        }
       
        return view('admin-views.employee.add-new', compact('rls' , 'user'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'f_name' => 'required',
            'role_id' => 'required',
            'zone_id' => 'required',
            'image' => 'required',
            'email' => 'required|unique:admins',
            'phone' => 'required|unique:admins',

        ], [
            'f_name.required' => 'First name is required!',
            'role_id.required' => 'Role is Required',
            'zone_id.required' => 'Zone is Required',
            'email.required' => 'Email id is Required',
            'image.required' => 'Image is Required',

        ]);

        if ($request->role_id == 1) {
            Toastr::warning(trans('messages.access_denied'));
            return back();
        }
            
        $employee = Admin::create([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'phone' => $request->phone,
            'zone_id' => $request->zone_id,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password),
            'image' => Helpers::upload('admin/', 'png', $request->file('image')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user = DB::table('users')->insert([
            'employee_id' => $employee->id,
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'zone_id' => $request->zone_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password),
            'image' => Helpers::upload('admin/', 'png', $request->file('image')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        if($user){
            $dt = $request->all();
            Mail::to($request->email)->send(new WelcomeEmail('https://drive.google.com/file/d/1sZajNoxoGvCXy9_q8YK2MNC6yKbiUOCN/view?usp=sharing',$dt,$request->password));
            \Log::info("Welcome email sent to : ".$request->email);  
        }
       
        Toastr::success(trans('messages.employee_added_successfully'));
        return redirect()->route('admin.employee.list');
    }

    function list()
    {
        $user = auth('admin')->user();
        if($user->role_id == '1' && $user->id =='1')
        {
            $em = Admin::with(['role'])->latest()->paginate(config('default_pagination'));
        }else{
            $em = Admin::with(['role'])->where('role_id', '!=','1')->where('zone_id' , $user->zone_id)->latest()->paginate(config('default_pagination'));
        }
        
        return view('admin-views.employee.list', compact('em'));
    }

    public function edit($id)
    {
        $user = auth('admin')->user();
        if($user->role_id == '1' && $user->id == '1')
        {
            $e = Admin::where('role_id', '!=','1')->where(['id' => $id])->first();
            $rls = AdminRole::get();
        }else{
            $e = Admin::where('role_id', '!=','1')->where(['id' => $id])->first();
            $rls = AdminRole::whereNotIn('id', [1])->get();
        }
        return view('admin-views.employee.edit', compact('rls', 'e' , 'user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'f_name' => 'required',
            'role_id' => 'required',
            'zone_id' => 'required',
            'email' => 'required|unique:admins,email,'.$id,
            'phone' => 'required|unique:admins,phone,'.$id,
        ], [
            'f_name.required' => 'First name is required!',
        ]);

        if ($request->role_id == 1) {
            Toastr::warning(trans('messages.access_denied'));
            return back();
        }

        $e = Admin::find($id);
        if ($request['password'] == null) {
            $pass = $e['password'];
        } else {
            if (strlen($request['password']) < 7) {
                Toastr::warning(trans('messages.password_length_warning',['length'=>'8']));
                return back();
            }
            $pass = bcrypt($request['password']);
        }

        if ($request->has('image')) {
            $e['image'] = Helpers::update('admin/', $e->image, 'png', $request->file('image'));
        }

        DB::table('admins')->where(['id' => $id])->update([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'zone_id'=> $request->zone_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => $pass,
            'image' => $e['image'],
            'updated_at' => now(),
        ]);

        DB::table('users')->where(['employee_id' => $id])->update([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'phone' => $request->phone,
            'zone_id'=> $request->zone_id,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => $pass,
            'image' => $e['image'],
            'updated_at' => now(),
        ]);

        Toastr::success(trans('messages.employee_updated_successfully'));
        return redirect()->route('admin.employee.list');
    }

    public function distroy($id)
    {
        $role=Admin::where('role_id', '!=','1')->where(['id'=>$id])->delete();
        Toastr::info(trans('messages.employee_deleted_successfully'));
        return back();
    }

    public function search(Request $request){
        $key = explode(' ', $request['search']);
        $employees=Admin::where('role_id', '!=','1')
        ->where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('f_name', 'like', "%{$value}%");
                $q->orWhere('l_name', 'like', "%{$value}%");
                $q->orWhere('phone', 'like', "%{$value}%");
                $q->orWhere('email', 'like', "%{$value}%");
            }
        })->limit(50)->get();
        return response()->json([
            'view'=>view('admin-views.employee.partials._table',compact('employees'))->render(),
            'count'=>$employees->count()
        ]);
    }

    public function tempEntries(Request $request){

        $user = auth('admin')->user();
        if($user->role_id == '1' && $user->id == '1')
        {
            $data = DB::table('temp_locations')->orderBy('id','desc')->paginate(50);
        }else{
            $data = DB::table('temp_locations')->where('zone_id' , $user->zone_id)->orderBy('id','desc')->paginate(50);
        }

        return view('admin-views.temp',compact('data'));
    }
}
