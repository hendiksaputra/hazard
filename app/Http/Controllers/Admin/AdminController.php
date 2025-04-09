<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Position;
use App\Models\AdminsRole;
use App\Models\DangerType;
use App\Models\Department;
use App\Models\HazardReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public function dashboard()
    {
        Session::put('page', 'dashboard');

        $admin = Admin::orderBy('id', 'desc')
                        ->where('type', 'subadmin')        
                        ->get();
        $totalAdmin = Admin::where('type', 'subadmin')->count();
        $totalHazards = HazardReport::count();
        $totalDangerTypes = DangerType::count();
        $totalDepartments = Department::count();

        $totalHazardClosed = HazardReport::where('status', 'closed')->count();

        $totalHazardPending = HazardReport::where('status', 'pending')->count();

        // Calculate the percentage of closed hazard reports
        $percentageClosed = $totalHazards > 0 ? ($totalHazardClosed / $totalHazards) * 100 : 0;

        // Calculate the percentage of pending hazard reports
        $percentagePending = $totalHazards > 0 ? ($totalHazardPending / $totalHazards) * 100 : 0;

        // Get the total closed hazard reports per month for the current year
        $monthlyHazardClosed = HazardReport::select(DB::raw("COUNT(*) as count"), DB::raw("MONTH(created_at) as month"))
        ->where('status', 'closed')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('month')
        ->pluck('count', 'month')
        ->toArray();

        // Prepare data for each month (if no data, set count to 0)
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = $monthlyHazardClosed[$i] ?? 0;
        }




        return view ('admin.dashboard')->with(compact('admin', 'totalAdmin', 'totalHazards','totalDangerTypes','totalDepartments','totalHazardPending','totalHazardClosed','percentageClosed','percentagePending'
        ,'monthlyData'));
    }

    public function login(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required|max:15',
            ]; 
            
            $customMessages = [
                'email.required' => 'Email is required',
                'email.email' => 'Valid Email is required',
                'password.required' => 'Password is required',
            ];
            $this->validate($request, $rules, $customMessages);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {

                //Remember admin email and password with cookie
                if(isset($data['remember'])&&!empty($data['remember'])){
                    setcookie("email", $data['email'], time()+3600);
                    setcookie("password", $data['password'], time()+3600);
                }else{
                    setcookie("email","");
                    setcookie("password",""); 
                }                                 
                return redirect("admin/dashboard");
            } else {
                return redirect()->back()->with('error_message', 'Invalid Email or Password');
            }
        }
        return view ('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    public function updatePassword(Request $request)
    {
        Session::put('page', 'update-password');

        if($request->isMethod('post'))
        {
            $data = $request->all();
            // check if current password is correct
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password))
            {
                // check if new password and confirm password are matching
                if($data['new_password'] == $data['confirm_password']){
                    //update new password
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message', 'Password updated successfully');
                }else {
                    return redirect()->back()->with('error_message', 'New password and retype new password does not match');                 
                }
            }else{
                    return redirect()->back()->with('error_message', 'Your current password is incorrect');
            }

        }
        return view ('admin.update_password');
    }

    public function checkCurrentPassword(Request $request)
    {
        $data = $request->all();
        if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
        

    }

    public function updateDetails(Request $request)
    {
        Session::put('page', 'update-details');

        $departments = Department::orderBy('department_name', 'asc')->get();

        if($request->isMethod('post'))
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'department_id' => 'required'
            ]; 
            
            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_name.regex' => 'Valid Name is required',
                'department_id.required' => 'Department is required',
            ];
            $this->validate($request, $rules, $customMessages);

            //update admin details
           Admin::where('email', Auth::guard('admin')->user()->email)->update(['name'=>$data['admin_name'], 'department_id' => $data['department_id']]);

           return redirect()->back()->with('success_message', 'Admin details updated successfully');

        }
        return view ('admin.update_details')->with(compact('departments'));
    }

    public function subadmins()
    {
        Session::put('page', 'subadmins');
        // get all subadmins join with departments, positions 
        $subadmins = Admin::join('departments', 'admins.department_id', 'departments.id')
                            ->join('positions', 'admins.position_id', 'positions.id')
                            ->select('admins.*', 'departments.department_name', 'positions.position_name')
                            ->where('type', 'subadmin')->get();
        return view ('admin.subadmins.subadmins')->with(compact('subadmins'));
    }

    public function updateSubadminStatus(Request $request)
    {
        if ($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            if ($data['status'] == "Active"){
                $status = 0;
            } else {
                $status = 1;
            }

            Admin::where('id',$data['subadmin_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'subadmin_id'=>$data['subadmin_id']]);
        
           
        }
    }

    public function addEditSubadmin(Request $request, $id=null)
    {
        Session::put('page', 'subadmins');
        $projects = ['000H', '001H', '017C', '021C', '022C', '023C', 'APS'];

        $departments = Department::orderBy('department_name', 'asc')->get();
        $positions = Position::orderBy('position_name', 'asc')->get();


        if($id==""){
            $title = "Add Subadmin";
            $subadmindata = new Admin;
            $message = "Subadmin added successfully";
        }else{
            $title = "Edit Subadmin";
            $subadmindata = Admin::find($id);
            $message = "Subadmin updated successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            if($id==""){
                $subadminCount = Admin::where('email',$data['email'])->count();
                if($subadminCount>0){                 
                    return redirect()->back()->with('error_message', 'Subadmin with this email already exists');
                }
            }

            $rules = [
                'name' => 'required',
                'type' => 'required',
                'password' => 'required',
                'department_id' => 'required',
                'position_id' => 'required',
                'project' => 'required',
            ]; 
            $customMessages = [
                'name.required' => 'Name is required',
                
            ];

            $this->validate($request, $rules, $customMessages);

            $subadmindata->name = $data['name'];
            if($id==""){
                $subadmindata->email = $data['email'];
                $subadmindata->type = 'subadmin';
            }

            $subadmindata->department_id = $data['department_id'];
            $subadmindata->position_id = $data['position_id'];
            $subadmindata->type = $data['type'];
            $subadmindata->project = $data['project'];
            if($data['password'] != ""){
                $subadmindata->password = bcrypt($data['password']);
            }
            $subadmindata->save();
            return redirect('admin/subadmins')->with('success_message', $message);

        }

        return view('admin.subadmins.add_edit_subadmin')->with(compact('title','subadmindata','departments','projects','positions'));


    }

    public function deleteSubadmin($id)
    {
        Admin::where('id',$id)->delete();
        return redirect()->back()->with('success_message', 'Subadmin deleted successfully');
    }

    public function updateRole($id,Request $request)
    {
       

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            //delete all earlier roles
            AdminsRole::where('subadmin_id',$id)->delete();


            //add new subadmin roles dynamically
            foreach ($data as $key => $value){
                if(isset($value['view'])){
                    $view = $value['view'];
                }else{
                    $view = 0;
                }

                if(isset($value['edit'])){
                    $edit = $value['edit'];
                }else{
                    $edit = 0;
                }

                if(isset($value['full'])){
                    $full = $value['full'];
                }else{
                    $full = 0;
                }

                AdminsRole::where('subadmin_id',$id)->insert(['subadmin_id'=>$id,'module'=>$key,'view_access'=>$view,'edit_access'=>$edit,'full_access'=>$full]);
            }

        //    $role = new AdminsRole;
        //    $role->subadmin_id = $id;
        //    $role->module = $key;
        //    $role->view_access = $view;
        //    $role->edit_access = $edit;
        //    $role->full_access = $full;
        //    $role->save();


           
           $message = "Subadmin Roles updated successfully";
           return redirect()->back()->with('success_message', $message);

        }

        $subadminRoles = AdminsRole::where('subadmin_id', $id)->get()->toArray();
        $subadminDetails = Admin::where('id', $id)->first()->toArray();
        $title = "Update Name : ".$subadminDetails['name'].", Subadmin Roles/Permission";
        // dd($subadminRoles);


        return view('admin.subadmins.update_role')->with(compact('title','id','subadminRoles'));
    }

   

}
