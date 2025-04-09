@extends('admin.layout.layout')

@section('content')
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
                  <h3 class="card-title"> Data Table Users</h3>
                  <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/add-edit-subadmin') }}" 
                  class="btn btn-block btn-primary">Add Users</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="subadmins" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Project</th>
                        <th>Created On</th>
                        <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($subadmins as $subadmin)   
                        <tr>
                        <td>{{ $subadmin->id }}</td>
                        <td>{{ $subadmin->name }}</td>
                        <td>{{ $subadmin->email }}</td>
                        <td>{{ $subadmin->type }}</td>
                        <td>{{ $subadmin->department_name }}</td>
                        <td>{{ $subadmin->position_name }}</td>
                        <td>{{ $subadmin->project }}</td>
                        <td>{{ date("F j, Y, g:i a", strtotime($subadmin->created_at)); }}</td>
                        <td class="text-center">
                            @if($subadmin->status == 1)
                            <a class="updateSubadminStatus" id="subadmin-{{ $subadmin->id }}" 
                            subadmin_id="{{ $subadmin->id }}" title="Status"  style='color:#3f6ed3' href="javascript:void(0)">
                                <i class="fas fa-toggle-on" status="Active"></i>
                            </a>
                            @else
                                <a class="updateSubadminStatus" id="subadmin-{{ $subadmin->id }}" subadmin_id="{{ $subadmin->id }}" title="Status" style="color: grey" href="javascript:void(0)">
                                    <i class="fas fa-toggle-off" status="Inactive"></i>
                                </a>
                            @endif
                            &nbsp;&nbsp;
                            <a href="{{ url('admin/add-edit-subadmin/'.$subadmin['id'])}}"><i class="fas fa-edit text-info" title="Edit"></i></a>                          
                           
                            &nbsp;&nbsp;
                            <a href="javascript:void(0)" record="subadmin" recordid="{{ $subadmin->id }}"                           
                            {{-- href="{{ url('admin/delete-cms-page/'.$page['id'])}}" --}}                    
                            class="confirmDelete" name="Subadmin" title="Delete Subadmin Page">
                              <i class="fas fa-trash text-danger" title="Delete"></i>
                            </a>
                            &nbsp;&nbsp;
                            <a href="{{ url('admin/update-role/'.$subadmin->id) }}"><i class="fas fa-unlock text-warning" title="Update Role Permission"></i></a>                            
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
