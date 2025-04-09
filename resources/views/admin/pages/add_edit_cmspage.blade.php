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
          <h3 class="card-title">{{ $title }}</h3>

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
              <div class="card-header">
                
                <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/cms-pages') }}" class="btn btn-block btn-warning">
                  <i class="fas fa-angle-double-left"></i>
                  Back</a>
              </div>
              

              <form name="cmsForm" id="cmsForm" @if(empty($cms_page['id'])) action="{{ url('admin/add-edit-cms-page') }}" @else action="{{ url('admin/add-edit-cms-page/'.$cms_page['id']) }}" @endif
              method="post">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title*</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title"
                    @if(!empty($cms_page['title'])) value="{{ $cms_page['title'] }}" @endif>
                    
                  </div>
                  <div class="form-group">
                    <label for="url">URL*</label>
                    <input type="text" name="url" class="form-control" id="url" placeholder="Enter Page URL"
                    @if(!empty($cms_page['url'])) value="{{ $cms_page['url'] }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="description">Description*</label>
                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Description">
                      @if(!empty($cms_page['description'])) {{ $cms_page['description'] }} @endif
                    </textarea>
                  </div>
                  <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" id="meta_title" placeholder="Enter Meta Title"
                    @if(!empty($cms_page['meta_title'])) value="{{ $cms_page['meta_title'] }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <input type="text" name="meta_description" class="form-control" id="meta_description" placeholder="Enter Meta Description"
                    @if(!empty($cms_page['meta_description'])) value="{{ $cms_page['meta_description'] }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_keywords">Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control" id="meta_keywords" placeholder="Enter Meta Keywords"
                    @if(!empty($cms_page['meta_keywords'])) value="{{ $cms_page['meta_keywords'] }}" @endif>
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