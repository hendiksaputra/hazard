<?php

namespace App\Http\Controllers\Admin;

use App\Models\CmsPage;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CmsPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'cms_pages');

        $cmsPages = CmsPage::get()->toArray();

        // Set admin/Subadmins permission permission
        $cmspagesModuleCount = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->
                                id,'module'=>'cms_pages'])->count(); 
        $pagesModule = array();
        if(Auth::guard('admin')->user()->type=="admin"){
            $pagesModule['view_access'] = 1;
            $pagesModule['edit_access'] = 1;
            $pagesModule['full_access'] = 1;
        }else if($cmspagesModuleCount==0){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message', $message);
        }else{
            $pagesModule = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->
            id,'module'=>'cms_pages'])->first()->toArray();
        }

        return view('admin.pages.cms_pages')->with(compact('cmsPages', 'pagesModule'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id=null)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id=null)
    {
        Session::put('page', 'cms_pages');

        if($id==""){
            $title = "Add Cms Page";
            $cms_page = new CmsPage;
            $message = "Cms Page added successfully";

        }else{
            $title = "Edit Cms Page";
            $cms_page = CmsPage::find($id);
            $message = "Cms Page updated successfully";
            
        }
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // cms page validation

            $rules = [
                'title' => 'required',
                'url' => 'required',
                'description' => 'required',
            ]; 
            $customMessages = [
                'title.required' => 'Page title is required',
                'url.required' => 'Page url is required',
                'description.required' => 'Page description is required',
            ];

            $this->validate($request, $rules, $customMessages);

            $cms_page->title = $data['title'];
            $cms_page->url = $data['url'];
            $cms_page->description = $data['description'];
            $cms_page->meta_title = $data['meta_title'];
            $cms_page->meta_description = $data['meta_description'];
            $cms_page->meta_keywords = $data['meta_keywords'];
            $cms_page->status = 1;
            $cms_page->save();

            return redirect('admin/cms-pages')->with('success_message', $message);


          

        }

        return view('admin.pages.add_edit_cmspage')->with(compact('title','cms_page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            if ($data['status'] == "Active"){
                $status = 0;
            } else {
                $status = 1;
            }

            CmsPage::where('id',$data['page_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'page_id'=>$data['page_id']]);
        
           
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        CmsPage::where('id',$id)->delete();
        return redirect('admin/cms-pages')->with('success_message', 'Cms Page deleted successfully');
    }
}
