@extends('admin.layout.layout')

@section('content')
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Danger Types</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Danger Types</li>
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
                  <h3 class="card-title"> Data Table Danger Types</h3>
                  @if($dangerTypeModule['edit_access'] == 1 || $dangerTypeModule['full_access'] == 1)
                    <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/add-edit-danger-type') }}" 
                      class="btn btn-block btn-primary">Add Danger Type</a>
                  @endif
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="dangerTypes" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th class="text-center">Created On</th>
                        <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($dangerTypes as $page)   
                        <tr>
                        <td>{{ $page['id'] }}</td>
                        <td>{{ $page['name'] }}</td>
                        <td class="text-right">{{ date("F j, Y, g:i a", strtotime($page['created_at'])); }}</td>
                        <td class="text-center">

                          @if($dangerTypeModule['edit_access'] == 1 || $dangerTypeModule['full_access'] == 1)
                            <a href="{{ url('admin/add-edit-danger-type/'.$page['id'])}}"><i class="fas fa-edit text-info" title="Edit"></i></a>
                            &nbsp;&nbsp;
                          @endif

                          @if($dangerTypeModule['full_access'] == 1)
                            <a href="javascript:void(0)" record="danger-type" recordid="{{ $page['id'] }}"                        
                            {{-- href="{{ url('admin/delete-cms-page/'.$page['id'])}}" --}}                        
                            class="confirmDelete" name="Danger Type" title="Delete Danger Type">
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
