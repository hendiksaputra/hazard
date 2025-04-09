@extends('admin.layout.layout')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Subadmins</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Role/Permission</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">     
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-name">{{ $title }}</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                  </div>
              @endif
              @if(Session::has('error_message'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error:</strong> {{ Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              @if(Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success:</strong> {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              <div class="card-header">
                
                <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/subadmins') }}" class="btn btn-block btn-warning">
                  <i class="fas fa-angle-double-left"></i>
                  Back</a>
              </div>
              

              <form name="subadminForm" id="subadminForm" action="{{ url('admin/update-role/'.$id) }}" method="post">
                @csrf  
                <input type="hidden" name="subadmin_id" value="{{ $id }}">
                @if(!empty($subadminRoles))
                @foreach($subadminRoles as $role)

                  {{-- @if($role['module']=="cms_pages")
                      @if($role['view_access']==1)
                          @php $viewCMSPages = "checked" @endphp
                      @else
                          @php $viewCMSPages = "" @endphp
                      @endif

                      @if($role['edit_access']==1)
                          @php $editCMSPages = "checked" @endphp
                      @else
                          @php $editCMSPages = "" @endphp
                      @endif

                      @if($role['full_access']==1)
                          @php $fullCMSPages = "checked" @endphp
                      @else
                          @php $fullCMSPages = "" @endphp
                      @endif
                  @endif --}}

                  @if($role['module']=="departments")
                      @if($role['view_access']==1)
                          @php $viewDepartmentPages = "checked" @endphp
                      @else
                          @php $viewDepartmentPages = "" @endphp
                      @endif

                      @if($role['edit_access']==1)
                          @php $editDepartmentPages = "checked" @endphp
                      @else
                          @php $editDepartmentPages = "" @endphp
                      @endif

                      @if($role['full_access']==1)
                          @php $fullDepartmentPages = "checked" @endphp
                      @else
                          @php $fullDepartmentPages = "" @endphp
                      @endif
                  @endif

                  @if($role['module']=="danger-types")
                      @if($role['view_access']==1)
                          @php $viewDangerTypePages = "checked" @endphp
                      @else
                          @php $viewDangerTypePages = "" @endphp
                      @endif

                      @if($role['edit_access']==1)
                          @php $editDangerTypePages = "checked" @endphp
                      @else
                          @php $editDangerTypePages = "" @endphp
                      @endif

                      @if($role['full_access']==1)  
                          @php $fullDangerTypePages = "checked" @endphp
                      @else
                          @php $fullDangerTypePages = "" @endphp
                      @endif
                  @endif

                  @if($role['module']=="hazard-reports")
                      @if($role['view_access']==1)
                          @php $viewHazardReportPages = "checked" @endphp
                      @else
                          @php $viewHazardReportPages = "" @endphp
                      @endif

                      @if($role['edit_access']==1)
                          @php $editHazardReportPages = "checked" @endphp
                      @else
                          @php $editHazardReportPages = "" @endphp
                      @endif

                      @if($role['full_access']==1)
                          @php $fullHazardReportPages = "checked" @endphp
                      @else
                          @php $fullHazardReportPages = "" @endphp
                      @endif
                  @endif

                  @if($role['module']=="positions")
                      @if($role['view_access']==1)
                          @php $viewPositionPages = "checked" @endphp
                      @else
                          @php $viewPositionPages = "" @endphp
                      @endif

                      @if($role['edit_access']==1)
                          @php $editPositionPages = "checked" @endphp
                      @else

                          @php $editPositionPages = "" @endphp
                      @endif

                      @if($role['full_access']==1)
                          @php $fullPositionPages = "checked" @endphp
                      @else
                          @php $fullPositionPages = "" @endphp
                      @endif
                  @endif


                @endforeach
                @endif
                <div class="card-body">
                  {{-- <div class="form-group col-md-6">
                    <label for="cms_pages">CMS Pages : &nbsp;&nbsp;</label>
                    <input type="checkbox" name="cms_pages[view]" value="1" @if(isset($viewCMSPages)) {{ $viewCMSPages }} @endif> 
                    View Access &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="cms_pages[edit]" value="1" @if(isset($editCMSPages)) {{ $editCMSPages }} @endif> 
                    View/Edit Access &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="cms_pages[full]" value="1" @if(isset($fullCMSPages)) {{ $fullCMSPages }} @endif> 
                    Full Access
                  </div>  --}}
                  <div class="form-group col-md-6">
                    <label for="department">Departments : &nbsp;&nbsp;</label>
                    <input type="checkbox" name="departments[view]" value="1" @if(isset($viewDepartmentPages)) {{ $viewDepartmentPages }} @endif> 
                    View Access &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="departments[edit]" value="1" @if(isset($editDepartmentPages)) {{ $editDepartmentPages }} @endif> 
                    View/Edit Access &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="departments[full]" value="1" @if(isset($fullDepartmentPages)) {{ $fullDepartmentPages }} @endif> 
                    Full Access
                  </div>
                  <div class="form-group col-md-6">
                    <label for="danger-types">Danger Types : &nbsp;&nbsp;</label>
                    <input type="checkbox" name="danger-types[view]" value="1" @if(isset($viewDangerTypePages)) {{ $viewDangerTypePages }} @endif> 
                    View Access &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="danger-types[edit]" value="1" @if(isset($editDangerTypePages)) {{ $editDangerTypePages }} @endif> 
                    View/Edit Access &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="danger-types[full]" value="1" @if(isset($fullDangerTypePages)) {{ $fullDangerTypePages }} @endif> 
                    Full Access
                  </div>
                  <div class="form-group col-md-6">
                    <label for="hazard-reports">Hazard Reports : &nbsp;&nbsp;</label>
                    <input type="checkbox" name="hazard-reports[view]" value="1" @if(isset($viewHazardReportPages)) {{ $viewHazardReportPages }} @endif> 
                    View Access &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="hazard-reports[edit]" value="1" @if(isset($editHazardReportPages)) {{ $editHazardReportPages }} @endif> 
                    View/Edit Access &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="hazard-reports[full]" value="1" @if(isset($fullHazardReportPages)) {{ $fullHazardReportPages }} @endif> 
                    Full Access
                  </div>
                  <div class="form-group col-md-6">
                    <label for="positions">Positions : &nbsp;&nbsp;</label>
                    <input type="checkbox" name="positions[view]" value="1" @if(isset($viewPositionPages)) {{ $viewPositionPages }} @endif> 
                    View Access &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="positions[edit]" value="1" @if(isset($editPositionPages)) {{ $editPositionPages }} @endif> 
                    View/Edit Access &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="positions[full]" value="1" @if(isset($fullPositionPages)) {{ $fullPositionPages }} @endif> 
                    Full Access
                  </div>                                    
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>     
      </div>  
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection