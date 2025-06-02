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
              @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                  </div>
              @endif
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Hazard Report Detail</h3>              
                    <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/hazard-reports') }}" 
                    class="btn btn-block btn-warning"><i class="fas fa-angle-double-left"></i> Back</a>                 
                </div>
                <div class="card-header">
                      <form action="{{ url ('admin/hazard-report-closed/'.$hazard->id )}}" method="POST" class="d-inline-block">
                        @csrf
                        <button type="submit" style="max-width: 150px; float:right; display:inline-block;" class="btn btn-block btn-primary btn-sm" onclick="return confirm('Are you sure to close this record?')"><i class="fas fa-check"></i> Close Report</button>
                      </form>                  
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
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">: 
                            @if (($hazard->status ?? 'pending') == 'pending')
                                <span class="badge badge-danger">Pending</span>
                            @else
                                <span class="badge badge-success">Closed</span>
                            @endif
                        
                        </dd>

                      </dl>
                </div>
                <div class="card-header">
                    <h3 class="card-title"> Hazard Report Attachment</h3>
                        <button data-toggle="modal" data-target="#modal-attachment" class="btn btn-sm btn-default float-right"> Add Attachment</button>
                   
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
                                <a href="{{ url( 'admin/delete-report-attachment/' . $attachment->id ) }}" onclick="return confirm('Are you sure to delete this record?')" class='btn btn-xs btn-danger'>delete</a>
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
                  <div class="card-header">
                    <h3 class="card-title"> Hazard Responses</h3>
                    <button data-toggle="modal" data-target="#modal-response" class="btn btn-sm btn-default float-right"> Add Response</button>
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
                              <a href="{{ url( 'admin/delete-response/' . $response->id ) }}" onclick="return confirm('Are you sure to delete this record?')" class='btn btn-xs btn-danger'>delete</a>
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
{{-- modal-attachment --}}
<div class="modal fade" id="modal-attachment">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Upload File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ url('admin/hazard-rpt-store-attachment') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="hazard_report_id" value="{{ $hazard->id }}">
            <div class="form-group">
              <label for="file_upload">Upload Attachment</label>
              <input type="file" name="file_upload" id="file_upload" class="form-control" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt">
              <small class="form-text text-muted">
                <i class="fas fa-info-circle"></i> Maximum file size: 1MB. 
                Supported formats: Images, PDF, Word, Excel, Text files.
              </small>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Submit</button>
          </div>
        </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal-attachment -->

  {{-- modal-response --}}
  <div class="modal fade" id="modal-response">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Response</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ url('admin/hazard-rpt-store-response') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="hazard_report_id" value="{{ $hazard->id }}">
            <div class="form-group">
              <label for="comment">Comment</label>
              <textarea name="comment" id="comment" class="form-control" cols="30" rows="3">{{ old('comment') }}</textarea>
            </div>
            <div class="form-group">
              <label for="file_upload">Upload Attachment <small>(optional)</small></label>
              <input type="file" name="file_upload" id="file_upload" class="form-control" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt">
              <small class="form-text text-muted">
                <i class="fas fa-info-circle"></i> Maximum file size: 1MB. 
                Supported formats: Images, PDF, Word, Excel, Text files.
              </small>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Submit</button>
          </div>
        </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal-response -->

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
// Debug: Test if script is loaded
console.log('=== ZOOM SCRIPT LOADED ===');

// Simple global variables
var imageZoom = 1;

// Test function
function testFunction() {
    console.log('Test function called!');
    alert('Test function works!');
}

// Simple function to open modal
function openImageModal(imageSrc, filename) {
    console.log('=== OPENING IMAGE MODAL ===');
    console.log('Image source:', imageSrc);
    console.log('Filename:', filename);
    
    try {
        // Set image source
        var zoomImage = document.getElementById('zoomImage');
        var downloadLink = document.getElementById('downloadLink');
        var modalTitle = document.getElementById('imageZoomModalLabel');
        var zoomLevel = document.getElementById('zoomLevel');
        
        console.log('Elements found:');
        console.log('- zoomImage:', zoomImage);
        console.log('- downloadLink:', downloadLink);
        console.log('- modalTitle:', modalTitle);
        console.log('- zoomLevel:', zoomLevel);
        
        if (zoomImage) {
            zoomImage.src = imageSrc;
            console.log('Image src set');
        }
        
        if (downloadLink) {
            downloadLink.href = imageSrc;
            downloadLink.download = filename;
            console.log('Download link set');
        }
        
        if (modalTitle) {
            modalTitle.textContent = 'Image Preview - ' + filename;
            console.log('Modal title set');
        }
        
        // Reset zoom
        imageZoom = 1;
        if (zoomImage) {
            zoomImage.style.transform = 'scale(1)';
            console.log('Zoom reset to 1');
        }
        
        if (zoomLevel) {
            zoomLevel.textContent = '100%';
            console.log('Zoom level text set');
        }
        
        // Show modal
        var modal = document.getElementById('imageZoomModal');
        console.log('Modal element:', modal);
        
        if (modal) {
            // Try jQuery first
            if (typeof $ !== 'undefined' && $.fn.modal) {
                console.log('Using jQuery to show modal');
                $('#imageZoomModal').modal('show');
            } else {
                console.log('Using manual method to show modal');
                modal.style.display = 'block';
                modal.classList.add('show');
                document.body.classList.add('modal-open');
                
                // Add backdrop
                var backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                backdrop.id = 'modal-backdrop';
                document.body.appendChild(backdrop);
            }
        }
        
    } catch (error) {
        console.error('Error in openImageModal:', error);
    }
}

// Simple function to change zoom
function changeZoom(delta) {
    console.log('=== CHANGE ZOOM CALLED ===');
    console.log('Delta:', delta);
    console.log('Current zoom before:', imageZoom);
    
    try {
        var newZoom = imageZoom + delta;
        console.log('New zoom calculated:', newZoom);
        
        // Limit zoom range
        if (newZoom < 0.25) {
            newZoom = 0.25;
            console.log('Zoom limited to minimum: 0.25');
        }
        if (newZoom > 5) {
            newZoom = 5;
            console.log('Zoom limited to maximum: 5');
        }
        
        imageZoom = newZoom;
        console.log('Image zoom set to:', imageZoom);
        
        // Apply zoom
        var image = document.getElementById('zoomImage');
        var zoomLevel = document.getElementById('zoomLevel');
        
        console.log('Elements for zoom:');
        console.log('- image:', image);
        console.log('- zoomLevel:', zoomLevel);
        
        if (image) {
            var scaleValue = 'scale(' + imageZoom + ')';
            image.style.transform = scaleValue;
            console.log('Transform applied:', scaleValue);
            console.log('Image style transform:', image.style.transform);
        } else {
            console.error('Image element not found!');
        }
        
        if (zoomLevel) {
            var percentText = Math.round(imageZoom * 100) + '%';
            zoomLevel.textContent = percentText;
            console.log('Zoom level text set to:', percentText);
        } else {
            console.error('Zoom level element not found!');
        }
        
    } catch (error) {
        console.error('Error in changeZoom:', error);
    }
}

// Simple function to reset zoom
function resetImageZoom() {
    console.log('=== RESET ZOOM CALLED ===');
    
    try {
        imageZoom = 1;
        
        var image = document.getElementById('zoomImage');
        var zoomLevel = document.getElementById('zoomLevel');
        
        if (image) {
            image.style.transform = 'scale(1)';
            console.log('Zoom reset - transform applied: scale(1)');
        }
        
        if (zoomLevel) {
            zoomLevel.textContent = '100%';
            console.log('Zoom level reset to 100%');
        }
        
    } catch (error) {
        console.error('Error in resetImageZoom:', error);
    }
}

// Client-side file size validation
function validateFileSize(input) {
    var maxSize = 1 * 1024 * 1024; // 1MB in bytes
    var files = input.files;
    
    if (files) {
        for (var i = 0; i < files.length; i++) {
            if (files[i].size > maxSize) {
                alert('File "' + files[i].name + '" is too large. Maximum file size is 1MB.');
                input.value = ''; // Clear the input
                return false;
            }
        }
    }
    return true;
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
    
    // Add file validation to all file inputs
    var fileInputs = document.querySelectorAll('input[type="file"]');
    console.log('File inputs found:', fileInputs.length);
    
    for (var i = 0; i < fileInputs.length; i++) {
        fileInputs[i].addEventListener('change', function() {
            validateFileSize(this);
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

// Global test - call this from console to test
window.testZoom = function() {
    console.log('Testing zoom functionality...');
    changeZoom(0.25);
};

console.log('=== SCRIPT END ===');
</script>

@endsection

 
