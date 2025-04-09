@extends('admin.layout.layout')
@section('content')
    
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Admin Details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Update Admin Details</h3>
                </div>
                <!-- /.card-header -->
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
                <!-- form start -->
                <form method="POST" action="{{ url('admin/update-details') }}">
                  @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="admin_email">Email address</label>
                      <input class="form-control bg-white" id="admin_email" value="{{ Auth::guard('admin')->user()->email }}" 
                      readonly>
                    </div>
                    <div class="form-group">
                        <label for="admin_name">Name</label>
                        <input type="text" name="admin_name" class="form-control" id="admin_name" placeholder="Name">
                    </div>
                      <div class="form-group">
                        <label for="to_department_id">Department</label>
                          <select name="to_department_id" id="to_department_id" class="form-control select2">
                            <option value="">Select Department</option>
                                  @foreach ($departments as $department)
                                      <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                  @endforeach
                          </select>               
                      </div>                                               
                  </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
      
  </div>


@endsection
