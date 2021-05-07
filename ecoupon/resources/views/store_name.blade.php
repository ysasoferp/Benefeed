@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Stores</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
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
                <h3 class="card-title">Stores</h3>

                  @if(session()->has('msgError'))
          <span class="alert alert-danger ml-4">{{session('msgError')}}</span>
          @endif
                @if(session()->has('msg'))
          <span class="alert alert-success ml-4">{{session('msg')}}</span>
          @endif

              </div>
              <!-- /.card-header -->
              <!-- form start -->





              <form action="{{route('storeNameStore')}}" method="post">
                  @csrf
                <div class="card-body">


                  <div class="row">
					<div class="col-sm-6">
                      <!-- select -->
                      <form>

                    </div>
				  </div>
				  <div class="row">
					<div class="col-sm-6">
                      <!-- select -->

						<div class="form-group">
                        <label>Add Store Name</label>
                        	@if(session()->has('sumsg'))
							 <span class="text-success font-weight-bold ml-5" id="sumsg">{{session()->get('sumsg')}}</span>
							@endif

                        <input class="form-control" type="text" rows="3" name="store" placeholder="Enter Store Name"/>


                      </div>

                    </div>
				 </div>
					<button type="submit" class="btn btn-primary">Send</button>

                  </div>
                  </form>
                </div>




                <!-- /.card-body -->


              </form>
            </div>
            <!-- /.card -->





            <!-- Form Element sizes -->




          </div>

        </div>
        <!-- /.row -->

          <!-- Default box -->
      <div class="card">
        <div class="card-header">

          <h3 class="card-title">RECENT CUSTOMER REGISTERED</h3>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>

                      <th style="width: 18%">
                          Store Name
                      </th>
                      <th style="width: 18%">
                          Users
                      </th>
                      <th style="width: 18%">
                        Coupon Used
                      </th>
					    <th style="width: 28%" class="text-center">
						 Action
                      </th>
                  </tr>
              </thead>
              <tbody>

                  @if(isset($stores))
                  @foreach($stores as $key => $store)
                  <tr>
                      <td>
                         {{ $store->name}}
					  </td>
                      <td>

                      </td>
                      <td>

                      </td>

                      <td class="project-actions text-center">
						  <a class="btn btn-danger btn-sm"  href="javascript:;" onclick="confirmDelete('{{$store->id}}')">
                              <i class="fas fa-trash-alt">
                              </i>
                              Delete
                          </a>
                           <form id="delete-store-{{$store->id}}" action="{{ route('deleteStoreName', $store->id ) }}" method="POST" style="display: none;">
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



      </div><!-- /.container-fluid -->
    </section>



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
<!-- jquery-validation -->
<script src="../../public/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../../public/plugins/jquery-validation/additional-methods.min.js"></script>
<script>
$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      alert( "Form successful submitted!" );
    }
  });
  $('#quickForm').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      username: {
        required: true,

      },
      firstname: {
        required: true,
      },
	  lastname: {
        required: true,
      },
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a vaild email address"
      },
      username: {
        required: "Please enter user name"

      },
	  firstname: {
        required: "Please enter first name"

      },
	  lastname: {
        required: "Please enter last name"

      }

    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});


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
      document.getElementById('delete-store-'+id).submit();
    }
  }

</script>
@endsection
