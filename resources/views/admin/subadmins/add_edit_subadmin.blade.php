@extends('admin.layout.layout')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $title }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">{{ $title }}</li>
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
              <div class="card-header">
                
                <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/subadmins') }}" class="btn btn-block btn-warning">
                  <i class="fas fa-angle-double-left"></i>
                  Back</a>
              </div>
              

              <form name="subadminForm" id="subadminForm" @if(empty($subadmindata['id'])) action="{{ url('admin/add-edit-subadmin') }}" @else action="{{ url('admin/add-edit-subadmin/'.$subadmindata['id']) }}" @endif
              method="post">
                @csrf
                <div class="card-body">
                  <div class="form-group col-md-6">
                    <label for="name">Name*</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name"
                    @if(!empty($subadmindata['name'])) value="{{ $subadmindata['name'] }}"  
                    @endif>
                    
                  </div>
                  <div class="form-group col-md-6">
                    <label for="email">Email*</label>
                    <input @if($subadmindata['id']!="") disabled="" style="background-color: darkgrey" @else required="" @endif 
                    type="email" name="email" class="form-control" id="email" placeholder="Enter Email"
                    @if(!empty($subadmindata['email'])) value="{{ $subadmindata['email'] }}" @endif>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="type">Type</label>
                    <input type="text" name="type" class="form-control" id="type" value="subadmin" placeholder="Enter Type"
                    @if(!empty($subadmindata['type'])) value="{{ $subadmindata['type'] }}" @endif 
                    style="background-color: darkgrey"  readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password"
                    @if(!empty($subadmindata['password'])) value="{{ $subadmindata['password'] }}" @endif>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="department_id">Department</label>
                        <select name="department_id" id="department_id" class="form-control select2">
                            <option value="">--Select Department--</option>
                                  @foreach ($departments as $department)
                                      <option value="{{ $department->id }}" @if(!empty($subadmindata['department_id'])) {{ $subadmindata['department_id'] == $department->id ? 'selected' : '' }} @endif>
                                        {{ $department->department_name }}
                                      </option>
                                  @endforeach
                        </select>               
                    </div>                                  
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="position_id">Position</label>
                        <select name="position_id" id="position_id" class="form-control select2">
                            <option value="">--Select Position--</option>
                                  @foreach ($positions as $position)
                                      <option value="{{ $position->id }}" @if(!empty($subadmindata['position_id'])) {{ $subadmindata['position_id'] == $position->id ? 'selected' : '' }} @endif>
                                        {{ $position->position_name }}
                                      </option>
                                  @endforeach
                        </select>               
                    </div>                                  
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="project">Project</label>
                        <select name="project" id="project" class="form-control select2">
                            <option value="">--Select Project--</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project }}" @if(!empty($subadmindata['project'])) {{ $subadmindata['project'] == $project ? 'selected' : '' }} @endif>
                                  {{ $project }}
                                </option>
                            @endforeach
                        </select>               
                    </div>                                  
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