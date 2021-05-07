@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Marketing</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Marketing</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
	<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title mr-3">Add Marketing Banner</h3>
                       @if(session()->has('msgError'))
          <span class="alert alert-danger">{{session('msgError')}}</span>
          @endif
                @if(session()->has('msg'))
          <span class="alert alert-success">{{session('msg')}}</span>
          @endif
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  
                
                  <div class="row">
					<div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-banner">
								Add Marketing Banner
							</button>
							
                      </div>
                    </div>
					
					
                    
                  </div>
                 
                </div>
                <!-- /.card-body -->

               
              </form>
            </div>
            <!-- /.card -->

            <!-- Form Element sizes -->
           

           

          </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
     <section class="content">
		<div class="container-fluid">
			<div class="row">
        
			<div class="col-md-12">
          
          <!-- /.card -->
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Marketing Banners</h3>

              
            </div>
            <div class="card-body p-0">
              <table class="table">
                <thead>
                  <tr>
                    <th>Banner</th>
                    <th>Image (1800 * 1700)</th>
					<th>Action</th>
                    
                  </tr>
                </thead>
                <tbody>
@if(isset($marketing))
@foreach($marketing as $market)
                  <tr>
                    <td>{{$market->banner_number}}</td>
                    <td><img width="150" height="150" src="{{asset($market->tumbnail)}}"/></td>
                    <td class="project-actions text-middle">
                          
                        <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$market->id}}')">
                              <i class="fas fa-trash">
                              </i>
                              Delete
                          </a>
                          <form id="delete-market-{{$market->id}}" action="{{ route('deleteMarket', $market->id ) }}" method="POST" style="display: none;">
        @csrf
      </form>
                      </td>
				  </tr>
			@endforeach
			@endif

                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      </div>
    </section>
    <!-- /.content -->
    <!-- /.content -->
	<!--- Add User Model-->
	<div class="modal fade" id="modal-default-banner">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Basic info</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                
              <form id="quickbannerForm" action="{{route('uploadBanner')}}" enctype="multipart/form-data" method="post">
                  @csrf
                
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="text" name="bannerName" class="form-control" id="bannername" placeholder="Enter Banner Title">
						</div>
					</div>
					<div class="col-sm-12">
						<div class="input-group">
							<div class="custom-file">
							<input type="file" class="custom-file-input" name="bannerFile" id="customFile">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
						</div>	
					</div>
				</div>	
				
				
               
                <!-- /.card-body -->
                <div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
              </form>
            </div>
            
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
	  <!----ADD Banner- STart-->
	  <div class="modal fade" id="modal-add-banner">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Upload Banner</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="quickbannerForm" action="{{route('uploadBanner')}}" enctype="multipart/form-data" method="post">
                  @csrf
                
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="text" name="bannerName" class="form-control" id="bannername" placeholder="Enter Banner Title">
						</div>
					</div>
					<div class="col-sm-12">
						<div class="input-group">
						    <img id="blah" src="" alt="Banner File" class="d-none"  style="width:350px" />
						    <div class="custom-file">
							<input type="file" class="custom-file-input" name="bannerFile" id="UpcustomFile">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
						</div>	
					</div>
				</div>	
				
				
               
                <!-- /.card-body -->
                <div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
              </form>
            </div>
            
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
  </div>
  <!-- /.content-wrapper -->
 

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<!-- ./wrapper -->

@endsection

@section('script')


<script>

    function clickUser(){
        document.getElementById("openAddUser").click();
    }
    
 var errors = $('#geterrors').val();   
 
    if(errors.length >2){
  clickUser();
    }
    
   setTimeout(function(){ 
       
       $('#sumsg').fadeOut('slow');
       
   }, 3000); 
    
     setTimeout(function(){ 
       
       $('.alert').fadeOut('slow');
       
   }, 3000); 
     
    
    
    
    
</script>
<script type="text/javascript">
function confirmDelete(id){
    let choice = confirm("Are You sure, You want to Delete this User ?")
    if(choice){
      document.getElementById('delete-market-'+id).submit();
    }
  }
  
  
  function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result).removeClass("d-none");
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#UpcustomFile").change(function() {
  readURL(this);
});
  
  
  
  

</script>

@endsection


