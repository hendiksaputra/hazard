@extends('admin.layout.layout')

@section('content')
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Hazard Reports</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Hazard Reports</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              @if(Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success:</strong> {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              <div class="card">
                
                <div class="card-header">
                    <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/hazard-closed-index') }}">Closed Reports</a>      
                </div>
                <div class="card-header">
                  <h3 class="card-title"> Data Table Hazard Reports</h3> &nbsp;&nbsp;    <small>(Pending)</small>
                  @if($hazardReportModule['edit_access'] == 1 || $hazardReportModule['full_access'] == 1)
                    <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/hazard-create') }}" 
                      class="btn btn-block btn-primary">New Report</a> 
                  @endif     
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="hazardReports" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Nomor</th>
                        <th>Project</th>
                        <th>Given To</th>
                        <th>Department</th>
                        <th>Date & Time</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($hazardReports as $page)   
                        <tr>
                        <td>{{ $page['id'] }}</td>
                        <td>{{ $page['nomor'] }}</td>
                        <td>{{ $page['project_code'] }}</td>
                        <td>{{ $page['admin_name'] ?? 'No Admin' }}</td>
                        <td>{{ $page['department_name'] ?? 'No Department' }}</td>
                        <td class="text-right">{{ date("F j, Y, g:i a", strtotime($page['created_at'])); }}</td>
                        <td>{{ $page['category'] }}</td>
                        <td>{{ $page['location'] }}</td>
                        <td>{{ $page['description'] }}</td>
                        <td class="text-center">
                          @if ($page['status'] == 'pending')
                            <span class="badge badge-warning">Pending</span>
                          @elseif ($page['status'] == 'closed')
                            <span class="badge badge-success">Closed</span>
                          @endif
                        </td>                       
                        <td class="text-center">  
                          @if($hazardReportModule['edit_access'] == 1 || $hazardReportModule['full_access'] == 1)          
                            <a href="{{ url('admin/edit-hazard/'.$page['id'])}}"><i class="fas fa-edit text-info" title="Edit Hazard Report"></i></a>
                            &nbsp;&nbsp;
                          @endif

                          @if($hazardReportModule['edit_access'] == 1 || $hazardReportModule['full_access'] == 1)   
                            <a href="{{ url('admin/hazard-report-show/'.$page['id'])}}"><i class="fas fa-eye text-info" title="Show Hazard Report"></i></a>
                            &nbsp;&nbsp;
                          @endif

                          @if($hazardReportModule['full_access'] == 1)
                            <a href="javascript:void(0)" record="hazard-reports" recordid="{{ $page['id'] }}"                        
                                {{-- href="{{ url('admin/delete-cms-page/'.$page['id'])}}" --}}                        
                                class="confirmDelete" name="CMS Hazard Report" title="Delete Hazard Report">
                                  <i class="fas fa-trash text-danger" title="Delete"></i>
                            </a>
                          @endif
                        </td>                   
                        </tr> 
                    @endforeach               
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


@endsection
