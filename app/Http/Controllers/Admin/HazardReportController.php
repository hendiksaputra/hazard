<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\AdminsRole;
use App\Models\DangerType;
use App\Models\Department;
use App\Models\HazardReport;
use Illuminate\Http\Request;
use App\Models\HazardResponse;
use App\Models\ReportAttachment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class HazardReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        Session::put('page', 'hazard-reports');
        $admin = Auth::guard('admin')->user();

        // Set admin/Subadmins permission permission
        $hazardReportModuleCount = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->
                                   id,'module'=>'hazard-reports'])->count();
        $hazardReportModule = array();
        if(Auth::guard('admin')->user()->type=="admin"){
            $hazardReportModule['view_access'] = 1;
            $hazardReportModule['edit_access'] = 1;
            $hazardReportModule['full_access'] = 1;
        }else if($hazardReportModuleCount==0){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message', $message);
        }else{
            $hazardReportModule = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->
            id,'module'=>'hazard-reports'])->first()->toArray();
        }

        $hazardReports = HazardReport::join('admins', 'hazard_reports.admin_id', '=', 'admins.id')
                                        ->join('danger_types', 'hazard_reports.danger_type_id', '=', 'danger_types.id')
                                        ->join('departments', 'hazard_reports.department_id', '=', 'departments.id')
                                        ->select('hazard_reports.*', 'admins.name as admin_name', 'danger_types.name as danger_type_name', 'departments.department_name as department_name')
                                        ->where('hazard_reports.status', 'pending') // Tambahkan nama tabel sebelum kolom status
                                        ->orderBy('created_at', 'desc')
                                        ->get();
        
        return view('admin.hazard_reports.index')->with(compact('hazardReports', 'hazardReportModule'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id=null)
    {
        // $admin = Auth::guard('admin')->user();

        $title = 'New Hazard Report';
        $nomor = Carbon::now()->addHours(8)->format('y') . '/SHE/' .  Auth::guard('admin')->user()->project . '/' . str_pad(HazardReport::count() + 1, 3, '0', STR_PAD_LEFT);
        $date_time = Carbon::now()->addHours(8)->format('d M Y H:i:s');
        $projects = ['000H', '001H', '017C', '021C', '022C', '023C', 'APS'];
        $departments = Department::orderBy('department_name', 'asc')->get();
        $danger_types = DangerType::orderBy('name', 'asc')->get();

        //filter data admin berdasarkan projectnya
        $admins = Admin::where('project', Auth::guard('admin')->user()->project)->get();

        // filter nama admin berdasarkan projectnya
        // if($admin->type === 'admin'){
        //     $admins = Admin::join('departments', 'hazard_reports.to_department_id', '=', 'departments.id') 
        //                     ->select('admins.*', 'departments.department_name as department_name')
        //                     ->where('project', Auth::guard('admin')->user()->project)
        //                     ->orderBy('created_at', 'desc')
        //                     ->get();
        // }else{
        //     $admins = Admin::join('departments', 'hazard_reports.to_department_id', '=', 'departments.id')
        //                     ->select('admins.*', 'departments.department_name as department_name')                             
        //                     ->where('project', Auth::guard('admin')->user()->project)
        //                     ->orderBy('created_at', 'desc')
        //                     ->get();
        // }
        
       

       
        return view('admin.hazard_reports.add_edit_hazard_report')->with(compact ('title','nomor','date_time', 'projects', 'departments','danger_types', 'admins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  return $request->all();

        $request->validate([
            // 'project_code' => 'required',
            'description' => 'required',
        ]);

        $hazard = new HazardReport();
        $hazard->nomor = Carbon::now()->addHours(8)->format('y') . '/SHE/' .  Auth::guard('admin')->user()->project . '/' . str_pad(HazardReport::count() + 1, 3, '0', STR_PAD_LEFT);
        $hazard->admin_id = $request->admin_id;
        $hazard->department_id = $request->department_id;
        $hazard->position_id = $request->position_id;
        $hazard->project_code = $request->project_code;
        $hazard->category = $request->category;
        $hazard->danger_type_id = $request->danger_type_id;
        $hazard->description = $request->description;
        $hazard->location = $request->location;
        $hazard->created_by = Auth::guard('admin')->user()->id;
        $hazard->save();

        if ($request->file_upload) {
            foreach ($request->file_upload as $file) {
                $filename = rand() . '_' . $file->getClientOriginalName();
                $file->move(public_path('document_upload'), $filename);

                $attachment = new ReportAttachment();
                $attachment->hazard_report_id = $hazard->id;
                $attachment->filename = $filename;
                $attachment->uploaded_by =  Auth::guard('admin')->user()->id;
                $attachment->save();
            }
        }

       
        return redirect('admin/hazard-reports')->with('success_message', 'Hazard Report has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = 'Edit Hazard Report';
        $hazardReport = HazardReport::find($id);
        $projects = ['000H', '001H', '017C', '021C', '022C', '023C', 'APS'];
        $departments = Department::orderBy('department_name', 'asc')->get();
        $danger_types = DangerType::orderBy('name', 'asc')->get();
        $attachments = ReportAttachment::where('hazard_report_id', $id)->get();
        $admins = Admin::where('project', Auth::guard('admin')->user()->project)->get();


        return view('admin.hazard_reports.edit_hazard_report')->with(compact('title', 'hazardReport', 'projects', 'departments', 'danger_types','attachments', 'admins'));
       
    }

    public function deleteCart($hazard_reports_id)
    {
        $cart = session()->get('cart');
        if($cart){
            foreach($cart as $key => $items){
                if($items['hazard_reports_id'] == $hazard_reports_id){
                    unset($cart[$key]);
                }
            }
            session()->put('cart',$cart);


            return redirect()->back()->with('success', 'Data Berhasil Dihapus');
        }
    }

    public function addToCart(Request $request)
    {

         // Ambil session 'cart' atau buat array kosong jika belum ada
         $cart = session()->get('cart', []);

         $cart[] = [
            'filename' => $request->filename, 
            'uploaded_by' => $request->uploaded_by,
            'hazard_reports_id' => $request->hazard_reports_id,
         ];
 
        
        
               
         
         
           // Simpan data ke session 'cart'
        session()->put('cart', $cart);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success_message', 'Data added to cart successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        
        $request->validate([
            'project_code' => 'required',
            'admin_id' => 'required',
            'description' => 'required',
        ]);

        $hazard = HazardReport::find($id);
        $hazard->nomor = Carbon::now()->addHours(8)->format('y') . '/SHE/' .  Auth::guard('admin')->user()->project . '/' . str_pad(HazardReport::count() + 1, 3, '0', STR_PAD_LEFT);
        $hazard->admin_id = $request->admin_id;
        $hazard->department_id = $request->department_id;
        $hazard->position_id = $request->position_id;
        $hazard->project_code = $request->project_code;
        $hazard->category = $request->category;
        $hazard->danger_type_id = $request->danger_type_id;
        $hazard->description = $request->description;
        $hazard->location = $request->location;
        $hazard->created_by = Auth::guard('admin')->user()->id;
        $hazard->save();

        // $hazard = ReportAttachment::findOrFail($id);

        // Delete selected attachments
        if ($request->delete_attachments) {
            foreach ($request->delete_attachments as $attachment_id) {
                $attachment = ReportAttachment::find($attachment_id);
                if ($attachment) {
                    // Delete file from storage
                    $filePath = public_path('document_upload/' . $attachment->filename);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    $attachment->delete();
                }
            }
        }

         // Save new file uploads
    if ($request->file_upload) {
        foreach ($request->file_upload as $file) {
            $filename = rand() . '_' . $file->getClientOriginalName();
            $file->move(public_path('document_upload'), $filename);

            $attachment = new ReportAttachment();
            $attachment->hazard_report_id = $hazard->id;
            $attachment->filename = $filename;
            $attachment->uploaded_by = Auth::guard('admin')->user()->id;
            $attachment->save();
        }
    }

        return redirect('admin/hazard-reports')->with('success_message', 'Hazard Report updated successfully.');

    }

    public function closed_index()
    {
        Session::put('page', 'hazard-reports');

        $admin = Auth::guard('admin')->user();

        if ($admin->type === 'admin'){
            $hazards = HazardReport::join('departments', 'hazard_reports.department_id', '=', 'departments.id')
                                     ->select('hazard_reports.*', 'departments.department_name as department_name')
                                     ->where('status','closed')
                                     ->orderBy('created_at', 'desc')
                                    ->get();
        } else {
            $hazards = HazardReport::join('departments', 'hazard_reports.department_id', '=', 'departments.id')
                                     ->select('hazard_reports.*', 'departments.department_name as department_name')
                                     ->where('status','closed')
                                     ->where('project_code',  Auth::guard('admin')->user()->project)
                                     ->orderBy('created_at', 'desc')
                                    ->get();
        }

        // Calculate duration for each hazard report
        $hazards->each(function ($hazard) {
            if ($hazard->created_at && $hazard->closed_date) {
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $hazard->closed_date);
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $hazard->created_at);
                $days = $start_date->diffInDays($end_date);
                $hours = $start_date->copy()->addDays($days)->diffInHours($end_date);
                $minutes = $start_date->copy()->addDays($days)->addHours($hours)->diffInMinutes($end_date);
                $hazard->duration = $days . 'd ' . $hours . 'h ' . $minutes . 'm';
            } else {
                $hazard->duration = '-';
            }
        });
        
        return view('admin.hazard_reports.closed_index')->with(compact('hazards'));
    }

    public function close_report($id) // update status to closed
    {
        $hazard = HazardReport::findOrFail($id);
        $hazard->status = 'closed';
        $hazard->updated_by = Auth::guard('admin')->user()->id;
        $hazard->closed_date = Carbon::now();
        $hazard->save();

        return redirect()->back()->with('success', 'Hazard Report has been closed successfully.');
    }

    

    public function show_closed($id)
    {
        $hazard = HazardReport::join('danger_types', 'hazard_reports.danger_type_id', '=', 'danger_types.id')
                                ->join('departments', 'hazard_reports.department_id', '=', 'departments.id')
                                ->join('admins', 'hazard_reports.created_by', '=', 'admins.id')
                                ->select('hazard_reports.*', 'danger_types.name as danger_type_name', 'departments.department_name as department_name', 'admins.name as created_by')
                                ->where('hazard_reports.id', $id)
                                ->first();
        $attachments = ReportAttachment::join('admins', 'report_attachments.uploaded_by', '=', 'admins.id')
                        ->select('report_attachments.*', 'admins.name as uploaded_by_name')
                        ->where('hazard_report_id', $id)->get();

        $responses = HazardResponse::join('admins', 'hazard_responses.comment_by', '=', 'admins.id')
        ->select('hazard_responses.*', 'admins.name as created_by_name')
        ->where('hazard_report_id', $id)->get();
        
      
        return view('admin.hazard_reports.show_closed', compact('hazard', 'attachments', 'responses'));
    }

    public function show($id)
    {

        $hazard = HazardReport::join('danger_types', 'hazard_reports.danger_type_id', '=', 'danger_types.id')
                                ->join('departments', 'hazard_reports.department_id', '=', 'departments.id')
                                ->join('admins', 'hazard_reports.created_by', '=', 'admins.id')
                                ->select('hazard_reports.*', 'danger_types.name as danger_type_name', 'departments.department_name as department_name', 'admins.name as created_by')
                                ->where('hazard_reports.id', $id)
                                ->first();
        $attachments = ReportAttachment::join('admins', 'report_attachments.uploaded_by', '=', 'admins.id')
                        ->select('report_attachments.*', 'admins.name as uploaded_by_name')
                        ->where('hazard_report_id', $id)->get();

        $responses = HazardResponse::join('admins', 'hazard_responses.comment_by', '=', 'admins.id')
        ->select('hazard_responses.*', 'admins.name as created_by_name')
        ->where('hazard_report_id', $id)
        ->get();

        return view('admin.hazard_reports.show', compact('hazard', 'attachments', 'responses'));
    }

    public function store_attachment(Request $request)
    {
        app(ReportAttachmentController::class)->store($request);

        return redirect()->back()->with('success_message', 'Attachment added successfully');
    }

    public function store_response(Request $request)
    {
        app(HazardResponseController::class)->store($request);

        return redirect()->back()->with('success_message', 'Response has been submitted successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        HazardReport::where('id',$id)->delete();
        ReportAttachment::where('hazard_report_id', $id)->delete();
        return redirect('admin/hazard-reports')->with('success_message', 'Hazard Report deleted successfully');
    }
}
