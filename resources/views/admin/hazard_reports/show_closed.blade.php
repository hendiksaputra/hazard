@extends('admin.layout.layout')

@section('content')
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Hazard Report</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Hazard Report</li>
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
                  <h3 class="card-title">Hazard Report Detail</h3>
                  
                    <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/hazard-closed-index') }}" 
                    class="btn btn-block btn-warning"><i class="fas fa-angle-double-left"></i> Back</a>
                  
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Report No</dt>
                        <dd class="col-sm-8">: <b>{{ $hazard->nomor ?? 'N/A' }}</b></dd>
                        <dt class="col-sm-4">Date & Time</dt>
                        <dd class="col-sm-8">: {{ $hazard->created_at ? $hazard->created_at->addHours(8)->format('d M Y - H:i:s') : 'N/A' }} </dd>
                        <dt class="col-sm-4">Project</dt>
                        <dd class="col-sm-8">: {{ $hazard->project_code ?? 'N/A' }}</dd>
                        <dt class="col-sm-4">To Department</dt>
                        <dd class="col-sm-8">: {{ $hazard->department_name ?? 'No Department' }}</dd>
                        <dt class="col-sm-4">Category</dt>
                        <dd class="col-sm-8">: {{ $hazard->category ?? 'N/A' }}</dd>
                        <dt class="col-sm-4">Danger Type</dt>
                        <dd class="col-sm-8">: {{ $hazard->danger_type_name ?? 'No Danger Type' }}</dd>
                         
                        </dd>
                        <dt class="col-sm-4">Created by | Department</dt>
                        <dd class="col-sm-8">: {{ $hazard->created_by ?? 'Unknown' }} | {{ $hazard->department_name ?? 'No Department' }} </dd>
                        <dt class="col-sm-4">Description</dt>
                        <dd class="col-sm-8">: {{ $hazard->description ?? 'N/A' }}</dd>
                      </dl>
                </div>
                <div class="card-header">
                    <h3 class="card-title"> Hazard Report Attachment</h3>
                   
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>File Name</th>
                          <th>Preview</th>
                          <th>Uploaded By</th>
                          <th>Uploaded At</th>
                          <th class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if($attachments && $attachments->count() > 0)
                          @foreach ($attachments as $attachment)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $attachment->filename ?? 'Unknown' }}</td>
                              <td>
                                @if(file_exists(public_path('document_upload/' . ($attachment->filename ?? ''))))
                                  @php
                                    $extension = strtolower(pathinfo($attachment->filename ?? '', PATHINFO_EXTENSION));
                                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                  @endphp
                                  
                                  @if(in_array($extension, $imageExtensions))
                                    <img src="{{ asset('document_upload/' . $attachment->filename) }}" 
                                         alt="Preview" 
                                         style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #ddd; cursor: pointer;" 
                                         class="zoom-image-trigger"
                                         data-image-src="{{ asset('document_upload/' . $attachment->filename) }}"
                                         data-filename="{{ $attachment->filename }}">
                                  @else
                                    <i class="fas fa-file" style="font-size: 30px; color: #6c757d;"></i>
                                    <br><small>{{ strtoupper($extension) }} File</small>
                                  @endif
                                @else
                                  <span class="text-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <br><small>File not found</small>
                                  </span>
                                @endif
                              </td>
                              <td>{{ $attachment->uploaded_by_name ?? 'Unknown' }}</td>
                              <td>{{ $attachment->created_at ? $attachment->created_at->addHours(8)->format('d M Y - H:i:s') : 'N/A' }}</td>
                              <td class="text-center">
                                @if(file_exists(public_path('document_upload/' . ($attachment->filename ?? ''))))
                                  <a href="{{ asset('document_upload/' . $attachment->filename) }}" class='btn btn-xs btn-info' target=_blank>view</a>
                                @else
                                  <span class="text-muted">N/A</span>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        @else
                          <tr>
                            <td colspan="6" class="text-center text-muted">No attachments found</td>
                          </tr>
                        @endif
                      </tbody>
                    </table>
                  </div>
                  <div class="card-body">
                    <table id="response-table" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Response At</th>
                          <th>Response By</th>
                          <th>Comment</th>
                          <th>Preview</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($responses as $response)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $response->created_at ? $response->created_at->addHours(8)->format('d M Y - H:i:s') : 'N/A' }}</td>
                            <td>{{ $response->created_by_name ?? 'Unknown' }}</td>
                            <td>{{ $response->comment ?? 'No comment' }}</td>
                            <td>
                              @if($response->filename && file_exists(public_path('document_upload/' . $response->filename)))
                                @php
                                  $extension = strtolower(pathinfo($response->filename, PATHINFO_EXTENSION));
                                  $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                @endphp
                                
                                @if(in_array($extension, $imageExtensions))
                                  <img src="{{ asset('document_upload/' . $response->filename) }}" 
                                       alt="Preview" 
                                       style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #ddd; cursor: pointer;" 
                                       class="zoom-image-trigger"
                                       data-image-src="{{ asset('document_upload/' . $response->filename) }}"
                                       data-filename="{{ $response->filename }}">
                                @else
                                  <i class="fas fa-file" style="font-size: 30px; color: #6c757d;"></i>
                                  <br><small>{{ strtoupper($extension) }} File</small>
                                @endif
                              @elseif($response->filename)
                                <span class="text-danger">
                                  <i class="fas fa-exclamation-triangle"></i>
                                  <br><small>File not found</small>
                                </span>
                              @else
                                <span class="text-muted">
                                  <i class="fas fa-minus"></i>
                                  <br><small>No attachment</small>
                                </span>
                              @endif
                            </td>
                            <td class="text-center">
                              @if($response->filename && file_exists(public_path('document_upload/' . $response->filename)))
                                <a href="{{ asset('document_upload/' . $response->filename) }}" class='btn btn-xs btn-info' target=_blank>view</a>
                              @else
                                <span class="text-muted">N/A</span>
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

{{-- Image Zoom Modal --}}
<div class="modal fade" id="imageZoomModal" tabindex="-1" role="dialog" aria-labelledby="imageZoomModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageZoomModalLabel">Image Preview</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center" style="overflow: auto; max-height: 70vh;">
        <div class="zoom-controls mb-3">
          <button type="button" class="btn btn-sm btn-secondary" onclick="changeZoom(-0.25)">
            <i class="fas fa-search-minus"></i> Zoom Out
          </button>
          <button type="button" class="btn btn-sm btn-secondary" onclick="resetImageZoom()">
            <i class="fas fa-expand-arrows-alt"></i> Reset
          </button>
          <button type="button" class="btn btn-sm btn-secondary" onclick="changeZoom(0.25)">
            <i class="fas fa-search-plus"></i> Zoom In
          </button>
          <span class="ml-3 text-muted" id="zoomLevel">100%</span>
        </div>
        <div class="image-container" style="overflow: auto; border: 1px solid #ddd; background: #f8f9fa; min-height: 300px; display: flex; align-items: center; justify-content: center;">
          <img id="zoomImage" src="" alt="Zoomed Image" style="transition: transform 0.3s ease; max-width: none; transform-origin: center center; display: block;">
        </div>
      </div>
      <div class="modal-footer">
        <a id="downloadLink" href="" download class="btn btn-sm btn-success">
          <i class="fas fa-download"></i> Download
        </a>
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
// Simple global variables
var imageZoom = 1;

// Simple function to open modal
function openImageModal(imageSrc, filename) {
    console.log('Opening image modal: ' + imageSrc);
    
    // Set image source
    document.getElementById('zoomImage').src = imageSrc;
    document.getElementById('downloadLink').href = imageSrc;
    document.getElementById('downloadLink').download = filename;
    document.getElementById('imageZoomModalLabel').textContent = 'Image Preview - ' + filename;
    
    // Reset zoom
    imageZoom = 1;
    document.getElementById('zoomImage').style.transform = 'scale(1)';
    document.getElementById('zoomLevel').textContent = '100%';
    
    // Show modal using Bootstrap directly
    var modal = document.getElementById('imageZoomModal');
    if (modal) {
        // Try jQuery first, fallback to Bootstrap
        if (typeof $ !== 'undefined' && $.fn.modal) {
            $('#imageZoomModal').modal('show');
        } else if (typeof bootstrap !== 'undefined') {
            var bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        } else {
            // Fallback - just show the modal div
            modal.style.display = 'block';
            modal.classList.add('show');
            document.body.classList.add('modal-open');
        }
    }
}

// Simple function to change zoom
function changeZoom(delta) {
    console.log('Changing zoom by: ' + delta);
    
    var newZoom = imageZoom + delta;
    
    // Limit zoom range
    if (newZoom < 0.25) newZoom = 0.25;
    if (newZoom > 5) newZoom = 5;
    
    imageZoom = newZoom;
    
    // Apply zoom
    var image = document.getElementById('zoomImage');
    var zoomLevel = document.getElementById('zoomLevel');
    
    if (image && zoomLevel) {
        image.style.transform = 'scale(' + imageZoom + ')';
        zoomLevel.textContent = Math.round(imageZoom * 100) + '%';
        console.log('Zoom applied: ' + imageZoom);
    }
}

// Simple function to reset zoom
function resetImageZoom() {
    console.log('Resetting zoom');
    imageZoom = 1;
    document.getElementById('zoomImage').style.transform = 'scale(1)';
    document.getElementById('zoomLevel').textContent = '100%';
}

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== DOM READY ===');
    
    // Test if modal exists
    var modal = document.getElementById('imageZoomModal');
    console.log('Modal exists:', modal !== null);
    
    if (modal) {
        console.log('Modal found:', modal);
    } else {
        console.error('Modal NOT found!');
    }
    
    // Test if zoom elements exist
    var zoomImage = document.getElementById('zoomImage');
    var zoomLevel = document.getElementById('zoomLevel');
    
    console.log('Zoom elements:');
    console.log('- zoomImage:', zoomImage);
    console.log('- zoomLevel:', zoomLevel);
    
    // Add click event listeners for zoom image triggers
    var zoomTriggers = document.querySelectorAll('.zoom-image-trigger');
    console.log('Zoom triggers found:', zoomTriggers.length);
    
    for (var i = 0; i < zoomTriggers.length; i++) {
        zoomTriggers[i].addEventListener('click', function() {
            var imageSrc = this.getAttribute('data-image-src');
            var filename = this.getAttribute('data-filename');
            console.log('Zoom trigger clicked - Image:', imageSrc, 'Filename:', filename);
            openImageModal(imageSrc, filename);
        });
    }
    
    // Add close modal functionality
    var closeButtons = document.querySelectorAll('[data-dismiss="modal"]');
    console.log('Close buttons found:', closeButtons.length);
    
    for (var i = 0; i < closeButtons.length; i++) {
        closeButtons[i].addEventListener('click', function() {
            console.log('Close button clicked');
            var modal = document.getElementById('imageZoomModal');
            if (modal) {
                if (typeof $ !== 'undefined' && $.fn.modal) {
                    $('#imageZoomModal').modal('hide');
                } else {
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    
                    // Remove backdrop
                    var backdrop = document.getElementById('modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                }
            }
        });
    }
    
    console.log('=== INITIALIZATION COMPLETE ===');
});

// Fallback for jQuery ready if available
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        console.log('jQuery ready - additional functionality loaded');
    });
}
</script>

@endsection

 
