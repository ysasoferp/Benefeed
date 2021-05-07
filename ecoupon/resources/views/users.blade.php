@extends('layouts.app')
@section('content')



@php 

if($errors->first('uname') !== ""){
$error_uname =$errors->first('uname');
}
elseif($errors->first('email') !== ""){
$error_email =$errors->first('email');
}elseif($errors->first('firstname') !== ""){
$error_fname = $errors->first('firstname');
}elseif($errors->first('lastname') !== ""){
$error_lname = $errors->first('lastname');
}elseif($errors->first('password') !== ""){
$error_pass =$errors->first('password');
}elseif($errors->first('password_confirmation') !== ""){
$error_Cpass =$errors->first('password_confirmation');
}elseif($errors->first('role') !== ""){
$error_role =$errors->first('role');
}


@endphp


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">New Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">New Users</li>
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
                <h3 class="card-title">Add User</h3>
              </div>
                  @if(session()->has('msgError'))
          <span class="alert alert-danger">{{session('msgError')}}</span>
          @endif
                @if(session()->has('msg'))
          <span class="alert alert-success">{{session('msg')}}</span>
          @endif
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  
                
                  <div class="row">
					<div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        
							<button type="button" class="btn btn-primary" id="openAddUser" data-toggle="modal" data-target="#modal-default">
								Add User
							</button>  
							
								<button type="button" class="btn btn-primary d-none" id="openEditUser" data-toggle="modal" data-target="#modal-default-edit">
							
						     	</button>  
							
							@if(session()->has('sumsg'))
							 <span class="text-success font-weight-bold ml-5" id="sumsg">{{session()->get('sumsg')}}</span>
							@endif
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
              <h3 class="card-title">New User Details</h3>

              
            </div>
            <div class="card-body p-0">
              <table class="table">
                <thead>
                  <tr>
                    <th>User Name</th>
                    <th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Role</th>
					<th>Action</th>
                    
                  </tr>
                </thead>
                <tbody>

@if(isset($users))
@foreach($users as $user)
                  <tr>
                    <td >{{$user->uname}}</td>
					<td>{{$user->fname}}</td>
                    <td>{{$user->lname}}</td>
					<td>{{$user->email}}</td>
					<td>{{$user->role}}</td>
					<td class="project-actions">
                          
                          <a class="btn btn-info btn-sm" href="javascript:;" onclick="editUser('{{$user->id}}')">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
						  <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$user->id}}')">
                              <i class="fas fa-trash-alt">
                              </i>
                              Delete
                          </a>
        <form id="delete-user-{{$user->id}}" action="{{ route('deleteUser', $user->id ) }}" method="POST" style="display: none;">
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
	  <div class="row">
          
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="card-tools">
                  <ul class="pagination pagination-sm float-left">
                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                  </ul>
                </div>
              </div>
             
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

           
          </div>
          <!-- /.col -->
        </div>
      </div>
    </section>
    <!-- /.content -->
    <!-- /.content -->
	
	<!--- Add User Model-->
	<div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add New User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="quickForm" action="{{route('registerUser')}}" enctype="multipart/form-data" method="post">
                  @csrf
                
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" name="uname" value="{{old('uname')}}" class="form-control" id="username" placeholder="Enter User Name">
							  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_uname}}</strong>
         </span>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" name="email" value="{{old('email')}}" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
										  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_email}}</strong>
         </span>
						</div>	
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" name="firstname" value="{{old('firstname')}}" class="form-control" id="firstname" placeholder="Enter First Name">
									  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_fname}}</strong>
         </span>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" name="lastname" value="{{old('lastname')}}" class="form-control" id="lastname" placeholder="Enter Last Name">
									  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_lname}}</strong>
         </span>
						</div>	
					</div>
				</div>
				
					<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<input type="password" name="password" value="{{old('password')}}" class="form-control" id="password" placeholder="Enter Password">
								  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_pass}}</strong>
         </span>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<input type="password"  name="password_confirmation" value="{{old('password_confirmation')}}"    class="form-control" id="Cpassword" placeholder="Enter Confirm Password">
								  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_Cpass}}</strong>
         </span>	
						</div>	
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<div class="form-group">							
								<select name="role" class="form-control">
									<option value="" >Role</option>
									<option value="admin" >Admin</option>
									<option value="user" >User</option>
									
								</select>
													  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_role}}</strong>
         </span>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							
						</div>	
					</div>
				</div>
               
                <!-- /.card-body -->
                <div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" id="submitBTN" class="btn btn-primary">Submit</button>
					<input type="hidden" value="{{@$errors}}" id="geterrors" />
				</div>
              </form>
            </div>
            
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      
      
      
     	<div class="modal fade" id="modal-default-edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Update user info</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="quickForm" action="{{route('postUpdateUser')}}" enctype="multipart/form-data" method="post">
                  @csrf
                  
                  <input type="hidden" name="id" id="user_idGet" />
                
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" name="uname" value="{{old('uname')}}" class="form-control" id="UpdateUsername" placeholder="Enter User Name">
							  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_uname}}</strong>
         </span>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" name="email" value="{{old('email')}}" class="form-control" id="UpdateEmail" placeholder="Enter email">
										  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_email}}</strong>
         </span>
						</div>	
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" name="firstname" value="{{old('firstname')}}" class="form-control" id="Updatefirstname" placeholder="Enter First Name">
									  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_fname}}</strong>
         </span>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" name="lastname" value="{{old('lastname')}}" class="form-control" id="Updatelastname" placeholder="Enter Last Name">
									  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_lname}}</strong>
         </span>
						</div>	
					</div>
				</div>
				
					<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<input type="password" name="password" value="{{old('password')}}" class="form-control" id="Updatepassword" placeholder="Enter Password">
								  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_pass}}</strong>
         </span>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<input type="password"  name="password_confirmation" value="{{old('password_confirmation')}}"    class="form-control" id="Cpassword" placeholder="Enter Confirm Password">
								  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_Cpass}}</strong>
         </span>	
						</div>	
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<div class="form-group">							
								<select name="role" class="form-control">
									<option value="" >Role</option>
									<option value="admin" >Admin</option>
									<option value="user" >User</option>
									
								</select>
													  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_role}}</strong>
         </span>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							
						</div>	
					</div>
				</div>
               
                <!-- /.card-body -->
                <div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" id="edsubmitBTN" class="btn btn-primary">Submit</button>
					<input type="hidden" value="{{@$errors}}" id="geterrors" />
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
      document.getElementById('delete-user-'+id).submit();
    }
  }



function editUser(id){
    
    $.get("/user/getupdate/"+id, function(data, status){
        
        $('#UpdateUsername').val(data.uname);
         $('#UpdateEmail').val(data.email);
          $('#Updatefirstname').val(data.fname);
           $('#Updatelastname').val(data.lname);
            $('#user_idGet').val(data.id);
           
        
   document.getElementById('openEditUser').click();
   
  });
        
  }

</script>

@endsection
